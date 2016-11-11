<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

/**
 * 
 * ------------------------------------------
 * video video class
 * ------------------------------------------
 * 
 * 視頻庫管理擴展下的視頻管理控制器  控制視頻添加、修改、刪除及從ku6導入視頻等
 * 用戶在配置好ku6vms賬戶後才能使用該模塊。
 * 在此擴展下對視頻的所有操作通過接口同步到ku6vms下面
 * 
 * @package 	PHPCMS V9.1.16
 * @author		chenxuewang
 * @copyright	CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 * 
 */
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global', 'video');


class video extends admin {
	
	public $db,$module_db;
	
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('video_store_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->userid = $_SESSION['userid'];
		pc_base::load_app_class('ku6api', 'video', 0);
		pc_base::load_app_class('v', 'video', 0);
		$this->v =  new v($this->db); 
		//獲取短信平台配置信息
		$this->setting = getcache('video');
		
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}
	
	/**
	 * 
	 * 視頻列表
	 */
	public function init() {
		$where = '';
		$page = $_GET['page'];
		$pagesize = 20;
		if($_GET['q']){
			if (isset($_GET['type'])) {
				if ($_GET['type']==1) {
					$where .= ' `videoid`=\''.$_GET['q'].'\'';
				} else {
					$where .= " `title` LIKE '%".$_GET['q']."%'";
				}
			}
 		}
 		
		if (isset($_GET['start_addtime']) && !empty($_GET['start_addtime'])) {
 			$where .= !empty($where) ? ' AND `addtime`>=\''.strtotime($_GET['start_addtime']).'\'' : ' `addtime`>=\''.strtotime($_GET['start_addtime']).'\'';
		}
		if (!empty($_GET['end_addtime'])) {
			$where .= !empty($where) ? ' AND `addtime`<=\''.strtotime($_GET['end_addtime']).'\'' : ' `addtime`<=\''.strtotime($_GET['end_addtime']).'\'';
 		} 
		$userupload = intval($_GET['userupload']);
		if ($userupload) {
			$where .= ' AND `userupload`=1';
		}
 		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$pages = $this->db->pages;
		include $this->admin_tpl('video_list');		
	}
	
	/**
	 * 
	 * 視頻添加方法
	 */
	public function add() {
		if ($_POST['dosubmit']) {
			//首先處理，提交過來的數據
			$data['vid'] = safe_replace($_POST['vid']);
			if (!$data['vid']) showmessage(L('failed_you_video_uploading'), 'index.php?m=video&c=video&a=add');
			$data['title'] = isset($_POST['title']) && trim($_POST['title']) ? trim($_POST['title']) : showmessage(L('video_title_not_empty'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			$data['description'] = trim($_POST['description']);
			$data['keywords'] = trim(strip_tags($_POST['keywords']));
			$data['channelid'] = intval($_POST['channelid']);
			//其次向vms post數據，並取得返回值
			$get_data = $this->ku6api->vms_add($data);
			if (!$get_data) {
				showmessage($this->ku6api->error_msg);
			}
			$data['vid'] = $get_data['vid'];
			$data['addtime'] = SYS_TIME;
			
			$data['userupload'] = intval($_POST['userupload']);
			$videoid = $this->v->add($data);
			if ($videoid) {
				showmessage(L('operation_success'), 'index.php?m=video&c=video&a=init&meunid='.$_GET['meunid']);
			} else {
				showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			}
		} else {
			if((empty($this->setting['sn']) || empty($this->setting['skey'])) && ROUTE_A!='open') {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			if(!$this->ku6api->testapi()) {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			$flash_info = $this->ku6api->flashuploadparam();
			$show_validator = true;
			include $this->admin_tpl('video_add');
		}
	}
	
	/**
	 * function edit
	 * 視頻編輯控制器
	 */
	public function edit() {
		$vid = intval($_GET['vid']);
		if (!$vid) showmessage(L('illegal_parameters'));
		if (isset($_POST['dosubmit'])) {
			//首先處理，提交過來的數據
			$data['vid'] = $_POST['vid'];
			if (!$data['vid']) showmessage(L('failed_you_video_uploading'), 'index.php?m=video&c=video&a=add');
			$data['title'] = isset($_POST['title']) && trim($_POST['title']) ? trim($_POST['title']) : showmessage(L('video_title_not_empty'), 'index.php?m=video&c=video&a=add&meunid='.$_GET['meunid']);
			$data['description'] = trim($_POST['description']);
			$data['keywords'] = trim(strip_tags($_POST['keywords']));
			//其次向vms post數據，並取得返回值
			if ($this->ku6api->vms_edit($data)) {
				$return = $this->v->edit($data, $vid);
				if ($return) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=init');
				else showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=edit&vid='.$vid.'&menuid='.$_GET['menuid']);
			} else {
				showmessage($this->ku6api->error_msg, 'index.php?m=video&c=video&a=edit&vid='.$vid.'&menuid='.$_GET['menuid']);
			}
		} else {
			$show_validator = true;
			$info = $this->db->get_one(array('videoid'=>$vid));
			include $this->admin_tpl('video_edit');
		}
	}
	
	/**
	 * function delete
	 * 刪除視頻控制器
	 */
	public function delete() {
		$vid = $_GET['vid'];
		$r = $this->db->get_one(array('videoid'=>$vid), 'vid');
		if (!$r) showmessage(L('video_not_exist_or_deleted'));
		if (!$this->ku6api->delete_v($r['vid'])) showmessage(L('operation_failure'), 'index.php?m=video&c=video&a=init&meunid='.$_GET['meunid']);
		$this->v->del_video($vid);	
		showmessage(L('success_next_update_content'), 'index.php?m=video&c=video&a=public_update_content&vid='.$vid.'&meunid='.$_GET['meunid']);
	}

	/**
	 * function delete_all
	 * 批量刪除視頻
	 * @刪除視頻時，注意同時刪除視頻庫內容對應關系表中的相關數據，因為操作時間限制，無法同時更新相關的內容。刪除完成時需要提醒用戶
	 */
	public function delete_all() {
		if (isset($_GET['dosubmit'])) {
			$ids = $_POST['ids'];
			if (is_array($ids)) {
				$video_content_db = pc_base::load_model('video_content_model');
				foreach ($ids as $videoid) {
					$videoid = intval($videoid);
					$r = $this->db->get_one(array('videoid'=>$videoid), 'vid');
					if (!$this->ku6api->delete_v($r['vid'])) continue;
					$this->v->del_video($videoid);
					$video_content_db->delete(array('videoid'=>$videoid));
				}
			}
			showmessage(L('succfull_create_index'));
		}
	}
	
	/**
	 * Function UPDATE_CONTENT
	 * 更新與此視頻關聯的內容模型
	 * @param int $vid 視頻庫videoid字段
	 */
	public function public_update_content() {
		$videoid = intval($_GET['vid']);
		$video_content_db = pc_base::load_model('video_content_model');
		$meunid = intval($_GET['meunid']);
		$pagesize = 10;
		$result = $video_content_db->select(array('videoid'=>$videoid), '*', $pagesize);
		if (!$result || empty($result)) {
			showmessage(L('update_complete'), 'index.php?m=video&c=video&a=init&meunid='.$meunid);
		}
		//加載更新html類
		$html = pc_base::load_app_class('html', 'content');
		$content_db = pc_base::load_model('content_model');
		$url = pc_base::load_app_class('url', 'content');
		foreach ($result as $rs) {
			$modelid = intval($rs['modelid']);
			$contentid = intval($rs['contentid']);
			$video_content_db->delete(array('videoid'=>$videoid, 'contentid'=>$contentid, 'modelid'=>$modelid));
			$content_db->set_model($modelid);
			$table_name = $content_db->table_name;
			$r1 = $content_db->get_one(array('id'=>$contentid));
			if ($this->ishtml($r1['catid'])) {
				$content_db->table_name = $table_name.'_data';
				$r2 = $content_db->get_one(array('id'=>$contentid));
				$r = array_merge($r1, $r2);unset($r1, $r2);
				if($r['upgrade']) {
					$urls[1] = $r['url'];
				} else {
					$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
				}
				$html->show($urls[1], $r, 0, 'edit');
			} else {
				continue;
			}
		}
		showmessage(L('part_update_complete'), 'index.php?m=video&c=video&a=public_update_content&vid='.$videoid.'&meunid='.$meunid);
	}
	
	/**
	 * Function ISHTML
	 * 判斷內容是否需要生成靜態
	 * @param int $catid 欄目id
	 */
	private function ishtml($catid = 0) {
		static $ishtml, $catid_siteid;
		if (!$ishtml[$catid]) {
			if (!$catid_siteid) {
				$catid_siteid = getcache('category_content', 'commons');
			} else {
				$siteid = $catid_siteid[$catid];
			}
			$siteid = $catid_siteid[$catid];
			$categorys = getcache('category_content_'.$siteid, 'commons');
			$ishtml[$catid] = $categorys[$catid]['content_ishtml'];
		}
		return $ishtml[$catid];
	}
	
	/**
	 * 
	 * 配置視頻參數。包括身份識別碼、加密密鑰、調用方案編號等信息
	 */
	public function setting() {
		if(isset($_POST['dosubmit'])) {
			$setting = array2string($_POST['setting']);
			setcache('video', $_POST['setting']);
			$this->ku6api->ku6api_skey = $_POST['setting']['skey'];
			$this->ku6api->ku6api_sn = $_POST['setting']['sn'];
			$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
			if(!$this->ku6api->testapi()) {
				showmessage(L('vms_sn_skey_error'),'?m=video&c=video&a=open');
			}
			showmessage(L('operation_success'),'?m=video&c=video&a=open');
		} else {
			$show_pc_hash = '';
			$v_model_categorys = $this->ku6api->get_categorys(true, $this->setting['catid']);
			$category_list = '<select name="setting[catid]" id="catid"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			include $this->admin_tpl('video_open');
		}
	}
	
	//獲取SKEY ,SN 寫入緩存
	public function set_video_setting(){
		$array['skey'] = $_GET['skey'];
		$array['sn'] = $_GET['sn'];
		if(empty($_GET['skey']) || empty($_GET['sn'])){
			showmessage(L('操作失敗！正在返回！'),'?m=admin');
		}
		$setting = array2string($array);
		setcache('video', $array);
		$this->ku6api->ku6api_skey = $_GET['skey'];
		$this->ku6api->ku6api_sn = $_GET['sn'];
		$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
		showmessage(L('operation_success'),'?m=admin');
	}
	
	/**
	 * function get_pos 獲取推薦位
	 * 根據欄目獲取推薦位id，並生成form的select形式
	 */
	public function public_get_pos () {
		$catid = intval($_GET['catid']);
		if (!$catid) exit(0);
		$position = getcache('position','commons');
		if(empty($position)) exit;
		$category = pc_base::load_model('category_model');
		$info = $category->get_one(array('catid'=>$catid), 'modelid, arrchildid');
		if (!$info) exit(0);
		$modelid = $info['modelid'];
		$array = array();
		foreach($position as $_key=>$_value) {
			if($_value['modelid'] && ($_value['modelid'] !=  $modelid) || ($_value['catid'] && strpos(','.$info['arrchildid'].',',','.$catid.',')===false)) continue;
			$array[$_key] = $_value['name'];
		}
		$data = form::select($array, '', 'name="sub[posid]"', L('please_select'));
		exit($data);
	}
	
	/**
	 * Function subscribe_list 獲取訂閱列表
	 * 獲取訂閱列表
	 */
	public function subscribe_list() {
		if (isset($_GET['dosubmit'])) {
			if (is_array($_GET['sub']) && !empty($_GET['sub'])) {
				$sub = $_GET['sub'];
				if (!$sub['channelid'] || !$sub['catid']) showmessage(L('please_choose_catid_and_channel'));
				$sub['catid'] = intval($sub['catid']);
				$sub['posid'] = intval($sub['posid']);
				$result = $this->ku6api->subscribe($sub);
				if ($result['check'] == 6) showmessage(L('subscribe_for_default')); 
				if ($result['code'] == 200) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list');
				else showmessage(L('subscribe_set_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
			} else {
				showmessage(L('please_choose_catid_and_channel'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
			}
		} else {
			$type = isset($_GET['type']) ? intval($_GET['type']) : 1;
			if((empty($this->setting['sn']) || empty($this->setting['skey'])) && ROUTE_A!='open') {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			if(!$this->ku6api->testapi()) {
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
			}
			//獲取用戶訂閱信息
			$v_model_categorys = $this->ku6api->get_categorys(true);
			$category_list = '<select name="sub[catid]" id="catid" onchange="select_pos(this)"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			$siteid = get_siteid();
			$CATEGORYS = getcache('category_content_'.$siteid, 'commons');
			$ku6_channels = $this->ku6api->get_subscribetype();
			$subscribes = $this->ku6api->get_subscribe();
			$usersubscribes = $this->ku6api->get_usersubscribe();
			$position = getcache('position','commons');
			
			include $this->admin_tpl('subscribe_list');
		}
	}
	
	/**
	 * Function Sub_DEl 刪除訂閱
	 * 用戶刪除訂閱方法
	 */
	public function sub_del() {
		$id = intval($_GET['id']);
		if (!$id) showmessage(L('illegal_parameters'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		if ($this->ku6api->sub_del($id)) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		else showmessage(L('delete_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
	}
	
	/**
	 * Function sub_del 刪除訂閱用戶
	 * 刪除訂閱用戶方法
	 */
	public function user_sub_del() {
		$id = intval($_GET['id']);
		$type = intval($_GET['type']);
		if (!$id) showmessage(L('illegal_parameters'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		if ($this->ku6api->user_sub_del($id)) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid'].'&type='.$type);
		else showmessage(L('delete_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid'].'&type='.$type);
	}	
	
	/**
	 * Function video2content 視頻庫中視頻
	 * 用戶選擇在視頻中選擇已上傳的視頻加入到視頻字段或編輯器中
	 */
	public function video2content () {
		$page = max(intval($_GET['page']), 1);
		$pagesize = isset($_GET['pagesize']) ? intval($_GET['pagesize']) : 8;
		$where = '`status` = 21';
		if (isset($_GET['name']) && !empty($_GET['name'])) {
			$title = safe_replace($_GET['name']);
			$where .= " AND `title` LIKE '%$title%'";
		}
		if (isset($_GET['starttime']) && !empty($_GET['starttime'])) {
			$addtime = strtotime($_GET['starttime']);
			$where .= " AND `addtime`>='$addtime'";
		}
		if (isset($_GET['endtime']) && !empty($_GET['endtime'])) {
			$endtime = strtotime($_GET['endtime']);
			$where .= " AND `addtime` <= '$endtime'";
		}
		if ($_GET['userupload']) {
			$userupload = intval($_GET['userupload']);
			$where .= " AND `userupload`=1";
		}
		$show_header = 1;
		$infos = $this->db->listinfo($where, '`videoid` DESC', $page, $pagesize, '', 5);
		$pages = $this->db->pages;
		include $this->admin_tpl('album_list');
	}
	
	/**
	 * 設置swfupload上傳的json格式cookie
	 */
	public function swfupload_json() {
		$arr['id'] = $_GET['id'];
		$arr['src'] = trim($_GET['src']);
		$arr['title'] = urlencode($_GET['title']);
		$json_str = json_encode($arr);
		$att_arr_exist = param::get_cookie('att_json');
		$att_arr_exist_tmp = explode('||', $att_arr_exist);
		if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp)) {
			return true;
		} else {
			$json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
			param::set_cookie('att_json',$json_str);
			return true;			
		}
	}
	
	/**
	 * 刪除swfupload上傳的json格式cookie
	 */	
	public function swfupload_json_del() {
		$arr['aid'] = intval($_GET['aid']);
		$arr['src'] = trim($_GET['src']);
		$arr['filename'] = urlencode($_GET['filename']);
		$json_str = json_encode($arr);
		$att_arr_exist = param::get_cookie('att_json');
		$att_arr_exist = str_replace(array($json_str,'||||'), array('','||'), $att_arr_exist);
		$att_arr_exist = preg_replace('/^\|\|||\|\|$/i', '', $att_arr_exist);
		param::set_cookie('att_json',$att_arr_exist);
	}

	/**
	* 導入KU6視頻
	*/
	public function import_ku6video(){
		if(!$this->ku6api->testapi()) {
			header("Location: ".APP_PATH."index.php?m=video&c=video&a=open&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
		}
		pc_base::load_sys_class('format','',0);
		$do = isset($_GET['do']) ? $_GET['do'] : '';
		$ku6url = isset($_GET['ku6url']) ? $_GET['ku6url'] : '';
		$time = isset($_GET['time']) ? $_GET['time'] : '';
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '*:*';
		$len = isset($_GET['len']) ? $_GET['len'] : '';//時長s:小於4分鐘 I:大於4分鐘
		$fenlei = isset($_GET['fenlei']) ? $_GET['fenlei'] : '*:*';//搜索分類
		$srctype = isset($_GET['srctype']) ? $_GET['srctype'] : 0;//視頻質量 
		$videotime = isset($_GET['videotime']) ? $_GET['videotime'] : 0;//視頻時長 
 		$page = isset($_GET['page']) ? $_GET['page'] : '1';
		$pagesize = 20;
 		$list = array();
		
		if(CHARSET!='utf-8'){
			$keyword = iconv('gbk', 'utf-8', $keyword);
		}
		$keyword = urlencode($keyword);
		
  		$data = $this->ku6api->Ku6search($keyword,$pagesize,$page,$srctype,$len,$fenlei,$videotime); 
 		$totals = $data['data']['total'];
		$list = $data['data']['list'];
		//獲取視頻大小接口
		if(isset($list) && is_array($list) && count($list) > 0) {
			foreach ($list as $key=>$v) {
				$spaceurl = "http://v.ku6.com/fetchVideo4Player/1/$v[vid].html";
				$spacejson = file_get_contents($spaceurl);
				$space = json_decode($spacejson, 1);	 
				$list[$key]['size'] = $space['data']['videosize'];
				$list[$key]['uploadTime']  = substr($v['uploadtime'], 0, 10); 
				//判斷那些已經導入過本機系統 $vidstr .= ',\''.$v['vid'].'\'';
			}
		}   
		//選擇站點和欄目進行導入
		$sitelist = getcache('sitelist','commons');
		
		//分類數組
		$fenlei_array = array('101000'=>'資訊','102000'=>'體育','103000'=>'娛樂','104000'=>'電影','105000'=>'原創','106000'=>'廣告','107000'=>'美女','108000'=>'搞笑','109000'=>'遊戲','110000'=>'動漫','111000'=>'教育','113000'=>'生活','114000'=>'汽車','115000'=>'房產','116000'=>'音樂','117000'=>'電視','118000'=>'綜藝','125000'=>'女生','126000'=>'記錄','127000'=>'科技','190000'=>'其它');
		//視頻質量
		$srctype_array = array('1'=>'超清','2'=>'高清','3'=>'標清','4'=>'流暢');
 		$videotime_array = array('1'=>'短視頻','2'=>'普通視頻','3'=>'中視頻','4'=>'長視頻');
		
		//本機視頻欄目
		$categoryrr = $this->get_category();
  		include $this->admin_tpl('import_ku6video');   
 	}

	/**
	* 搜索視頻瀏覽 
	*/
	public function preview_ku6video(){
		$ku6vid = $_GET['ku6vid'];
 		$data = $this->ku6api->Preview($ku6vid);
   		include $this->admin_tpl('priview_ku6video');
	}
	
	/**
	* 獲取站點欄目數據
	*/
	public function get_category(){
  		$siteid = get_siteid();//直取SITEID值
		$sitemodel_field = pc_base::load_model('sitemodel_field_model');
		$result = $sitemodel_field->select(array('formtype'=>'video', 'siteid'=>$siteid), 'modelid');
		if (is_array($result)) {
			$models = '';
			foreach ($result as $r) {
				$models .= $r['modelid'].',';
			}
		}
		$models = substr(trim($models), 0, -1);
		$cat_db = pc_base::load_model('category_model');
		if ($models) {
			$where = '`modelid` IN ('.$models.') AND `type`=0 AND `siteid`=\''.$siteid.'\'';
			$result = $cat_db->select($where, '`catid`, `catname`, `parentid`, `siteid`, `child`');
			if (is_array($result)) { 
				$data = $return_data = $categorys = array(); 
				$tree = pc_base::load_sys_class('tree');   
				$data = $return_data = $categorys = array(); 
				$tree = pc_base::load_sys_class('tree');//factory::load_class('tree', 'utils');
 				$string = '<select name="select_category" id="select_category" onchange="select_pos(this)">';
				$string .= "<option value=0>請選擇分類</option>";
				foreach ($result as $r) {
					$r['html_disabled'] = "";
					if ($r['child']) {
						$r['html_disabled'] = "disabled";
					} 
					$categorys[$r['catid']] = $r;
				}
				$str  = $str2 = "<option value=\$catid \$html_disabled \$selected>\$spacer \$catname</option>"; 			     $tree->init($categorys);
				$string .= $tree->get_tree_category(0, $str, $str2);
 				$string .= '</select>';
				return $string;//不使用前台js調用，使用return ;
			}
 		}
		return array();
	}

	public function public_view_video() {
		$id = intval($_GET['id']);
		if (!$id) showmessage('請選擇要瀏覽的視頻！');
		$r = $this->db->get_one(array('videoid'=>$id), 'vid,channelid');
		$video_cache = $this->setting;
		$show_header = 1;
		include $this->admin_tpl('view_video');
	}

	/**
	 *@ function public_check_status
	 *@ 手動檢查視頻狀態 
	 */
	public function public_check_status() {
		$id = intval($_GET['id']);
		if (!$id) exit('1');
		$r = $this->db->get_one(array('videoid'=>$id), 'vid,channelid,status,picpath');
		if (!$r) exit('2');
		$return = $this->ku6api->check_status($r['vid']);
		if (!$return) exit('3');
		
		$status_arr = pc_base::load_config('ku6status_config');
		if ($return['ku6status'] != $r['status']) {
			$this->db->update(array('status'=>$return['ku6status'], 'picpath'=>$return['picpath']), array('videoid'=>$id));
			
			if ($return['ku6status']==21) {
				/**
				 * 加載視頻內容對應關系數據模型，檢索與刪除視頻相關的內容。
				 * 在對應關系表中找出對應的內容id，並更新內容的靜態頁
				 */
				$video_content_db = pc_base::load_model('video_content_model');
				$result = $video_content_db->select(array('videoid'=>$id));
				if (is_array($result) && !empty($result)) {
					//加載更新html類
					$html = pc_base::load_app_class('html', 'content');
					$content_db = pc_base::load_model('content_model');
					$content_check_db = pc_base::load_model('content_check_model');
					$url = pc_base::load_app_class('url', 'content');
					foreach ($result as $rs) {
						$modelid = intval($rs['modelid']);
						$contentid = intval($rs['contentid']);
						$content_db->set_model($modelid);
						$c_info = $content_db->get_one(array('id'=>$contentid), 'thumb');

						$where = array('status'=>99);
						if (!$c_info['thumb']) $where['thumb'] = $return['picpath'];
						$content_db->update($where, array('id'=>$contentid));
						$checkid = 'c-'.$contentid.'-'.$modelid;
						$content_check_db->delete(array('checkid'=>$checkid));
						$table_name = $content_db->table_name;
						$r1 = $content_db->get_one(array('id'=>$contentid));
						/**
						 * 判斷如果內容頁生成了靜態頁，則更新靜態頁
						 */
						if (ishtml($r1['catid'])) {
							$content_db->table_name = $table_name.'_data';
							$r2 = $content_db->get_one(array('id'=>$contentid));
							$r = array_merge($r1, $r2);unset($r1, $r2);
							if($r['upgrade']) {
								$urls[1] = $r['url'];
							} else {
								$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
							}
							$html->show($urls[1], $r, 0, 'edit');
							
						} else {
							continue;
						}
					}
				}
				$msg_r = json_encode(array('change'=>1, 'status'=>21, 'statusname'=>iconv(CHARSET, 'UTF-8', $status_arr[$return['ku6status']])));
			} else {
				$msg_r = json_encode(array('change'=>1, 'status'=>$return['ku6status'], 'statusname'=>iconv(CHARSET, 'UTF-8', $status_arr[$return['ku6status']])));
			}
		} else if (!$r['picpath'] && $return['picpath']) {
			$this->db->update(array('picpath'=>$return['picpath']), array('videoid'=>$id));
			$msg_r = json_encode(array('change'=>1, 'status'=>$return['ku6status'], 'statusname'=>iconv(CHARSET, 'UTF-8', $status_arr[$return['ku6status']])));
		}else {
			$msg_r = json_encode(array('change'=>0));
		}	
		exit($msg_r);	
	}
	
	/***********2013.1.15添加**********/
	
	/** 
	 * 後台申請開通視頻聚合功能。服務器自動返回配置視頻參數。包括身份識別碼、加密密鑰、調用方案編號等信息
	 */
	public function open() {   
		$this->setting = getcache('video');
 		if(empty($this->setting['skey']) || empty($this->setting['sn'])){
			//配置不存在，則先驗證域名是否存在，如果存在，直接跳去驗證頁面
			$check_user_back = APP_PATH . 'api.php?op=video_api';
			$return_check = $this->ku6api->check_user_back($check_user_back);
			if ($return_check==200 && SITE_URL != 'localhost' && !preg_match("/^(127|192|10)\.([1-2]?)([0-9]?)([0-9])\.([1-2]?)([0-9]?)([0-9])\.([1-2]?)([0-9]?)([0-9])/", SITE_URL)) {//存在同域名記錄，進行email驗證
				header("Location: ".APP_PATH."index.php?m=video&c=video&a=check_user_back&meunid=".$_GET['meunid'].'&pc_hash='.$_GET['pc_hash']);
				exit;
			}
			
			//配置不存在，跳轉至盛大通行證登錄頁面 
			$user_back = APP_PATH . 'api.php?op=video_api';
			$user_back = str_replace("/","__",$user_back);
			$user_back = urlencode(str_replace(".php","@php",$user_back));
			include $this->admin_tpl('video_open');
		} else {
			$config_flag = false;
			if($this->ku6api->testapi()) {
				$config_flag = true;
			}
			include $this->admin_tpl('video_setting');
		} 
	}
	
	//完善詳細資料，通過API接口完善資料,獲取 SKEY,SN 
	public function complete_info() { 
 		if(isset($_POST['dosubmit'])) {
			$info = safe_replace($_POST['info']); //包含隱藏的uid
			if (CHARSET == 'gbk') {
				$info = array_iconv($info);
			}
			//提交數據，獲取SKEY,SN  
			$return_skey_sn = $this->ku6api->complete_info($info);
 			if(is_array($return_skey_sn) && !empty($return_skey_sn)){
				$setting = array2string($return_skey_sn);
				setcache('video', $return_skey_sn);
				$this->ku6api->ku6api_skey = $return_skey_sn['skey'];
				$this->ku6api->ku6api_sn = $return_skey_sn['sn'];
				$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
				showmessage('資料提交成功，已成功開通視頻應用，正在返回！','?m=video&c=video&a=open');
			}else{
				echo $return_skey_sn;exit;
			showmessage('資料提交失敗，請聯系商務人員處理！','?m=video&c=video&a=open');
			} 
		}else{ 
			//如果傳遞uid,snid則為登錄通行證成功，返回完善資料，沒有傳遞則為自行填寫資料申請開通視頻應用
			$uid = intval($_GET['uid']);
			$snid = $_GET['snid'];
			
			//如果skey,sn存在，通過接口調取用戶完善的資料，再提交為修改操作
			$skey_sn_array = getcache('video');
			if(!empty($skey_sn_array['skey']) && !empty($skey_sn_array['sn'])){ 
   				$return_info = $this->ku6api->Get_Complete_Info($skey_sn_array);
				if (CHARSET == 'gbk') {
					$return_info = array_iconv($return_info,'utf-8','gbk');
				} 
  				$complete_info = is_array($return_info) ? $return_info : array(); 
				$uid = $complete_info['uid'];
				$snid = $complete_info['sndaid'];
			}else{
				//沒有配置則判斷域名在聚合平台是否已經存在，如果存在進行驗證獲取SKEY
				$check_user_back = APP_PATH . 'api.php?op=video_api';
				$return_check = $this->ku6api->check_user_back($check_user_back);
				if($return_check==200){//存在同域名記錄，進行email驗證
					showmessage('域名已經存在，請驗證開通視頻應用！','?m=video&c=video&a=check_user_back');
				}
 				$complete_info = array();	
			}
			$show_dialog = 1;
			$show_header = $show_scroll = true;
			include $this->admin_tpl('video_complete_info');
		}
	}
	
	//Email 驗證老網站，獲取sn,skey
	public function check_user_back(){
		if(isset($_POST['dosubmit_new'])) {
			$data['email'] = $_POST['email'];
			$data['code'] = $_POST['code'];
			if(empty($data['email']) || empty($data['code'])) return false;
			$return_skey_sn = $this->ku6api->check_email_code($data);
			if(is_array($return_skey_sn) && !empty($return_skey_sn)){
				$setting = array2string($return_skey_sn);
				setcache('video', $return_skey_sn);
				$this->ku6api->ku6api_skey = $return_skey_sn['skey'];
				$this->ku6api->ku6api_sn = $return_skey_sn['sn'];
				$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
				showmessage('驗證成功，已成功開通視頻應用，正在返回！','?m=video&c=video&a=open');
			}else{
				showmessage('驗證失敗，請返回！',HTTP_REFERER);
			}  
		}else{
			$show_dialog = 1;
			$show_header = $show_scroll = true;
			include $this->admin_tpl('video_check_user_back');
		}
	}
	
	//由平台發送驗證碼到指定信箱
	public function send_code(){ 
		$data['email'] = $_GET['email'];
		$data['url'] = APP_PATH . 'api.php?op=video_api';
 		$return = $this->ku6api->send_code($data);
 		if($return['code']=='200'){
			echo 1;
		}else{
			echo 2;
		}
	}
	
	
	//獲取傳遞的skey ,sn 寫入緩存
	public function get_skey_sn(){
		$skey = $_REQUEST['skey'];
		$sn = $_REQUEST['sn'];
		if(empty($skey) || empty($sn)){
			showmessage('視頻配置信息不能為空',HTTP_REFERER);
		}
		$setting_arr['skey'] = $skey;
		$setting_arr['sn'] = $sn;
		$setting = array2string($setting_arr);
		setcache('video', $setting_arr);//寫緩存  
		$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));//更新模版數據
		//驗證配置
		$this->ku6api->ku6api_skey = $skey;
		$this->ku6api->ku6api_sn = $sn;
		if(!$this->ku6api->testapi()) {
			showmessage(L('vms_sn_skey_error'),'?m=video&c=video&a=open');
		}
		showmessage(L('operation_success'),'?m=video&c=video&a=open');
	}
	
	public function open_setting() {
		if(isset($_POST['dosubmit'])) {
			$setting = array2string($_POST['setting']);
			setcache('video', $_POST['setting']);
			$this->ku6api->ku6api_skey = $_POST['setting']['skey'];
			$this->ku6api->ku6api_sn = $_POST['setting']['sn'];
			$this->module_db->update(array('setting'=>$setting),array('module'=>'video'));
			if(!$this->ku6api->testapi()) {
				showmessage(L('vms_sn_skey_error'),HTTP_REFERER);
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_pc_hash = '';
			$v_model_categorys = $this->ku6api->get_categorys(true, $this->setting['catid']);
			$category_list = '<select name="setting[catid]" id="catid"><option value="0">'.L('please_choose_catid').'</option>'.$v_model_categorys.'</select>';
			include $this->admin_tpl('video_opensetting');
		}
	}
	
	//獲取userid下的視頻
	public function ajax_getuseridvideo(){
		$userid = intval($_GET['userid']);
		if (!$userid) exit(0);
		$url = "http://v.ku6.com/video.htm?t=list&uid=" . $userid . "&p=1";
		$data = @file_get_contents($url);
		$data = json_decode($data, 1);
		$list = $data['data'];
		if (is_array($list)) {
			$sub['userid'] = $userid;
			$result = $this->ku6api->checkusersubscribe($sub);
			$status = $result['status'];
			exit($status);
		} 
		exit('0');
	}

	/**
	 * 訂閱用戶視頻
	 */
	public function subscribe_uservideo() {
		if (is_array($_GET['sub']) && !empty($_GET['sub'])) {
			$sub = $_GET['sub'];
			if (!$sub['userid'] || !$sub['catid']) showmessage(L('please_choose_catid_and_channel'));
			$sub['catid'] = intval($sub['catid']);
			$sub['posid'] = intval($sub['posid']);
			$result = $this->ku6api->usersubscribe($sub);
			if ($result['check'] == 6) showmessage(L('subscribe_for_default')); 
			if ($result['code'] == 200) showmessage(L('operation_success'), 'index.php?m=video&c=video&a=subscribe_list&type=2');
			else showmessage(L('subscribe_set_failed'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid']);
		} else {
			showmessage(L('please_choose_catid_and_iputuserid'), 'index.php?m=video&c=video&a=subscribe_list&meunid='.$_GET['meunid'].'&type=2');
		}
	}	
	
}

?>