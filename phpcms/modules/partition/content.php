<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
class content extends admin {
	private $db, $data_db, $type_db;
	public function __construct() {
		parent::__construct();
		// $this->db = pc_base::load_model('special_content_model');
		// $this->data_db = pc_base::load_model('special_c_data_model');
		$this->data_db = pc_base::load_model('special_c_data_model');

		//專區內容存入內容模型表中
		$this->db = pc_base::load_model('content_model');
		$this->partition_db = pc_base::load_model('partition_model');
		$this->type_db = pc_base::load_model('type_model');

		$this->db_partition_games = pc_base::load_model('partition_games_model');
		$this->db_content = pc_base::load_model('content_model');
		$this->db_model = pc_base::load_model('model_model');
	}
	
	/**
	 * 添加信息,這裡沒有使用,待刪除
	 */
	public function add() {
		$_GET['partition_id'] = intval($_GET['partition_id']);
		$parentid = intval($_GET['parentid']);//最頂級的父級欄目

		if (!$_GET['partition_id']) showmessage('請選擇新加文章所在專區！', HTTP_REFERER);
		if ($_POST['dosubmit'] || $_POST['dosubmit_continue']) {//提交 
			//先把推送到其它欄目賦值其它
			$other_catid = $_POST['othor_catid'];

			//文章入新聞表
			$_POST['info']['catid'] = 1317;//專區文章倉庫欄目 
			$content_info = $_POST['info'];
            $content_info['style'] = '';
            if ($content_info['style_color']) {
                $content_info['style'] .= $content_info['style_color'].';';
            }
            if ($content_info['style_font_weight']) {
                $content_info['style'] .= $content_info['style_font_weight'];
            }
            unset($content_info['style_color'], $content_info['style_font_weight']);
			$content_info['status'] = 99;//狀態99代表開放
			$this->db->set_model(1);
			$_POST['othor_catid'] = array();
			unset($_POST['othor_catid']);
			$contentid = $this->db->add_content($content_info);

			//當前專區發文章，生成當前專區的URL，為後面向百度提交做好準備 
			$now_partition_url = $this->make_partition_url($_REQUEST['parentid'],1317,$contentid);
			if($now_partition_url){
				$this->db->update(array('url'=>$now_partition_url),array("id"=>$contentid));
				$url_array = pathinfo($now_partition_url);
				$str = str_replace("http://","",$url_array['dirname']);
				$strdomain = explode("/",$str);
				$domain = $strdomain[0];
				//向百度推送文章信息
				$baidu_return = tobaidu($now_partition_url,$domain);
			}

			//入文章庫後，專區文章對表入庫
			$info['part_id'] = $_GET['partition_id'];
			$info['modelid'] = 1;
			$info['gameid'] = $contentid;//對應表中gameid既為原文章ID
			$info['listorder'] = 0;
			$info['inputtime'] = SYS_TIME;
			$this->db_partition_games->insert($info);

			//同時發到其它欄目 
			if(is_array($other_catid)){
				$info = array();
				foreach ($other_catid as $key => $value) {
					$info['part_id'] = $key;
					$info['modelid'] = 1;
					$info['gameid'] = $contentid;//對應表中gameid既為原文章ID
					$info['listorder'] = 0;
					$info['inputtime'] = SYS_TIME;
					$this->db_partition_games->insert($info);
				}
			}

			// 向數據統計表添加數據,這裡可能可以去掉
			// $count = pc_base::load_model('hits_model');
			// $hitsid = 'special-c-'.$info['specialid'].'-'.$contentid;
			// $count->insert(array('hitsid'=>$hitsid));

			if ($_POST['dosubmit'])//保存
				showmessage('發布成功！', HTTP_REFERER, '', '', 'setTimeout("window.close()", 2000)');
			elseif ($_POST['dosubmit_continue'])//保存並繼續發表
				showmessage('發布成功！', HTTP_REFERER);

		} else {
			if(!$_GET['partition_id'] || !$parentid){
				showmessage('需要的參數未正確傳遞，請重試！', HTTP_REFERER, '', '', 'setTimeout("window.close()", 1000)');
				exit;
			}
			//查詢所在欄目的欄目名稱
			$cat_array = $this->partition_db->get_one(array('catid'=>$_GET['partition_id'], 'siteid'=>$this->get_siteid()), '*');

			// $types = array();
			// foreach ($rs as $r) {
			// 	$types[$r['typeid']] = $r['name'];
			// }
			//獲取站點模板信息 (專區不需要選擇內容的模版)
			// pc_base::load_app_func('global', 'admin');
			// $template_list = template_list(get_siteid(), 0);
			// foreach ($template_list as $k=>$v) {
			// 	$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
			// 	unset($template_list[$k]);
			// }
			$special_db = pc_base::load_model('special_model');
			$info = $special_db->get_one(array('id'=>$_GET['specialid']));
			@extract($info);
			include $this->admin_tpl('content_add');

		}
	}
	
	/**
	 * 信息修改,暫未啟用
	 */
	public function edit() {

		$_GET['specialid'] = intval($_GET['specialid']);
		$_GET['id'] = intval($_GET['id']);
		if (!$_GET['specialid'] || !$_GET['id']) showmessage(L('illegal_action'), HTTP_REFERER);
		if (isset($_POST['dosubmit']) || isset($_POST['dosubmit_continue'])) {
			$info = $this->check($_POST['info'], 'info', 'edit', $_POST['data']['content']); //驗證數據的合法性
			//處理外部鏈接更換情況
			$r = $this->db->get_one(array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			
			if ($r['islink']!=$info['islink']) { //當外部鏈接和原來差別時進行操作
				// 向數據統計表添加數據
				$count = pc_base::load_model('hits_model');
				$hitsid = 'special-c-'.$_GET['specialid'].'-'.$_GET['id'];
				$count->delete(array('hitsid'=>$hitsid));
				$this->data_db->delete(array('id'=>$_GET['id']));
				if ($info['islink']) {
					$info['url'] = $_POST['linkurl'];
					$info['isdata'] = 0;
				} else {
					$data = $this->check($_POST['data'], 'data');
					$data['id'] = $_GET['id'];
					$this->data_db->insert($data);
					$count->insert(array('hitsid'=>$hitsid));
				} 
			}
			//處理外部鏈接情況
			if ($info['islink']) {
				$info['url'] = $_POST['linkurl'];
				$info['isdata'] = 0;
			} else {
				$info['isdata'] = 1;
			} 
			$html = pc_base::load_app_class('html', 'special');
			if ($info['isdata']) {
				$data = $this->check($_POST['data'], 'data');
				$this->data_db->update($data, array('id'=>$_GET['id']));
				$url = $html->_create_content($_GET['id']);
				if ($url[0]) {
					$info['url'] = $url[0];
					$searchid = $this->search_api($_GET['id'], $data, $info['title'], 'update', $info['inputtime']);
					$this->db->update(array('url'=>$url[0], 'searchid'=>$searchid), array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
				}
			} else {
				$this->db->update(array('url'=>$info['url']), array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			}
			$this->db->update($info, array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			//更新附件狀態
			if(pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				if ($info['thumb']) {
					$this->attachment_db->api_update($info['thumb'],'special-c-'.$_GET['id'], 1);
				}
				$this->attachment_db->api_update(stripslashes($data['content']),'special-c-'.$_GET['id']);
			}
			$html->_index($_GET['specialid'], 20, 5);
			$html->_list($info['typeid'], 20, 5);
			showmessage(L('content_edit_success'), HTTP_REFERER, '', '', 'setTimeout("window.close()", 2000)');
		} else {
			$info = $this->db->get_one(array('id'=>$_GET['id'], 'specialid'=>$_GET['specialid']));
			if($info['isdata']) $data = $this->data_db->get_one(array('id'=>$_GET['id']));
			$rs = $this->type_db->select(array('parentid'=>$_GET['specialid'], 'siteid'=>$this->get_siteid()), 'typeid, name');
			$types = array();
			foreach ($rs as $r) {
				$types[$r['typeid']] = $r['name'];
			}
			//獲取站點模板信息
			pc_base::load_app_func('global', 'admin');
			$template_list = template_list($this->siteid, 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$special_db = pc_base::load_model('special_model');
			$s_info = $special_db->get_one(array('id'=>$_GET['specialid']));
			@extract($s_info);
			include $this->admin_tpl('content_edit');
		}
	}

	
	/**
	 * 檢查表題是否重復
	 */
	public function public_check_title() {
		if ($_GET['data']=='' || (!$_GET['specialid'])) return '';
		if (pc_base::load_config('system', 'charset')=='gbk') {
			$title = safe_replace(iconv('UTF-8', 'GBK', $_GET['data']));
		} else $title = $_GET['data'];
		$specialid = intval($_GET['specialid']);
		$r = $this->db->get_one(array('title'=>$title, 'specialid'=>$specialid));
		if ($r) {
			exit('1');
		} else {
			exit('0');
		}
	}
	
	/**
	 * 專題信息列表(需檢查整理)
	 */
	public function init() {

		$_GET['specialid'] = intval($_GET['specialid']);

		$db_part = pc_base::load_model('partition_model');
		$temp_arrpid = $db_part->get_one('`catid`='.$_GET['specialid'], 'arrparentid');
		$temp_arrpid = explode(',', $temp_arrpid['arrparentid']);
		if( !empty($temp_arrpid[1]) ){
			$the_parentid = $temp_arrpid[1];
		}

		//信息列表面包屑
		$curr_parent_name = '';
		foreach( $temp_arrpid as $v_arrpid ){
			if( $v_arrpid == 0 ){ continue; }
			$temp_arr_catname = $db_part->get_one( '`catid`='.$v_arrpid,'catname' );
			$conn_str = $curr_parent_name ? ' &gt; ' : '';
			$curr_parent_name .= $conn_str.$temp_arr_catname['catname'];
		}
		$temp_arr_catname = $db_part->get_one('`catid`='.$_GET['specialid'], 'catname');

		$conn_str = $curr_parent_name ? ' &gt; ' : '';
		$curr_parent_name .= $conn_str.$temp_arr_catname['catname'];

		if(!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);
		
		$page = max(intval($_GET['page']), 1);
		//$data_games = $this->db_partition_games->listinfo(array('part_id'=>$_GET['specialid']), '`listorder` ASC , `id` DESC', $page);
		$data_games = $this->db_partition_games->listinfo(array('part_id'=>$_GET['specialid']), '`inputtime` DESC' , $page);
		foreach( $data_games as $key=>$value ){
			$this->db_content->set_model($value['modelid']);
			$datas[$key] = $this->db_content->get_one( array('id'=>$value['gameid']) );
			$sort_name = $this->db_model->get_one( array('modelid'=>$value['modelid']), 'name'  );

			//這裡不合適,需要改->www_categorys
			$datas[$key]['sort_name'] = $sort_name['name'];
			$datas[$key]['sort_value'] = $value['modelid'];
			$datas[$key]['listorder'] = $value['listorder'];
		}

		$pages = $this->db_partition_games->pages;

		$big_menu = array( array('javascript:openwinx(\'?m=partition&c=content&a=add&parentid='.$_GET['parentid'].'&partition_id='.$_GET['specialid'].'\',\'\');void(0);', L('add_content')),array('javascript:window.top.art.dialog({id:\'import\',iframe:\'?m=partition&c=partition&a=import&specialid='.$_GET['specialid'].'\', title:\''.L('import_content').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'import\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'import\'}).close()});void(0);', L('import_content')));

		include $this->admin_tpl('content_list');
	}

	
	/**
	 * 信息排序 信息調用時按排序從小到大排列(待修改整理)
	 */
	public function listorder() {
		//分區id
		$_GET['specialid'] = intval($_GET['specialid']);
		if (!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);

		foreach ($_POST['listorders'] as $id => $v) {
			$this->db_partition_games->update(array('listorder'=>$v), array('gameid'=>$id, 'part_id'=>$_GET['specialid']));
		}
		showmessage(L('operation_success'), HTTP_REFERER);
	}
	

	/**
	 * 刪除子分區下信息(Over)
	 */
	public function delete() {

		if (!isset($_POST['id']) || empty($_POST['id']) || !$_GET['specialid']) {
			showmessage(L('illegal_action'), HTTP_REFERER);
		}

		$specialid = $_GET['specialid'];
		if( is_array($_POST['id'])  ){
			foreach( $_POST['id'] as $value  ){
				$sid = explode('-',$value);
				$this->db_partition_games->delete( array('part_id'=>$specialid, 'gameid'=>$sid[0], 'modelid'=>$sid[1])  );
			}	
		}elseif( is_numeric( $_POST['id']  )  ){
			$sid = explode('-',$POST['id']);
			$this->db_partition_games->delete( array('part_id'=>$specialid, 'gameid'=>$sid[0], 'modelid'=>$sid[1])  );
		}

		/*
		$special = pc_base::load_model('special_model');
		$info = $special->get_one(array('id'=>$specialid));
		$special_api = pc_base::load_app_class('special_api', 'special');
		if (is_array($_POST['id'])) {
			foreach ($_POST['id'] as $sid) {
				$sid = intval($sid);
				$special_api->_delete_content($sid, $info['siteid'], $info['ishtml']);
				if(pc_base::load_config('system','attachment_stat')) {
					$keyid = 'special-c-'.$sid;
					$this->attachment_db = pc_base::load_model('attachment_model');
					$this->attachment_db->api_delete($keyid);
				}
			}
		} elseif (is_numeric($_POST['id'])){
			$id = intval($_POST['id']);
			$special_api->_delete_content($id, $info['siteid'], $info['ishtml']);
			if(pc_base::load_config('system','attachment_stat')) {
				$keyid = 'special-c-'.$id;
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_delete($keyid);
			}
		}*/

		showmessage(L('operation_success'), HTTP_REFERER);
	}


	
	/**
	 * 添加到全站搜索
	 * @param intval $id 文章ID
	 * @param array $data 數組
	 * @param string $title 標題
	 * @param string $action 動作
	 */
	private function search_api($id = 0, $data = array(), $title, $action = 'update', $addtime) {
		$this->search_db = pc_base::load_model('search_model');
		$siteid = $this->get_siteid();
		$type_arr = getcache('type_module_'.$siteid,'search');
		$typeid = $type_arr['special'];
		if($action == 'update') {
			$fulltextcontent = $data['content'];
			return $this->search_db->update_search($typeid ,$id, $fulltextcontent,$title, $addtime);
		} elseif($action == 'delete') {
			$this->search_db->delete_search($typeid ,$id);
		}
	}
	
	/**
	 * 表單驗證
	 * @param array $data 表單數據
	 * @param string $type 按數據表數據判斷
	 * @param string $action 在添加時會加上默認數據
	 * @return array 數據檢驗後返回的數組
	 */
	private function check($data = array(), $type = 'info', $action = 'add', $content = '') {
		if ($type == 'info') {
			if (!$data['title']) showmessage(L('title_no_empty'), HTTP_REFERER);
			if (!$data['typeid']) showmessage(L('no_select_type'), HTTP_REFERER);
			$data['inputtime'] = $data['inputtime'] ? strtotime($data['inputtime']) : SYS_TIME;
			$data['islink'] = $data['islink'] ? intval($data['islink']) : 0;
			$data['style'] = '';
			if ($data['style_color']) {
				$data['style'] .= 'color:#00FF99;';
			} 
			if ($data['style_font_weight']) {
				$data['style'] .= 'font-weight:bold;';
			}
			
			//截取簡介
			if ($_POST['add_introduce'] && $data['description']=='' && !empty($content)) {
				$content = stripslashes($content);
				$introcude_length = intval($_POST['introcude_length']);
				$data['description'] = str_cut(str_replace(array("\r\n","\t"), '', strip_tags($content)),$introcude_length);
			}
			
			//自動提取縮略圖
			if (isset($_POST['auto_thumb']) && $data['thumb'] == '' && !empty($content)) {
				$content = $content ? $content : stripslashes($content);
				$auto_thumb_no = intval($_POST['auto_thumb_no']) * 3;
				if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
					
					$data['thumb'] = $matches[$auto_thumb_no][0];
				}
			}
			unset($data['style_color'], $data['style_font_weight']);
			if ($action == 'add') {
				$data['updatetime'] = SYS_TIME;
				$data['username'] = param::get_cookie('admin_username');
				$data['userid'] = $_SESSION['userid'];
			}
		} elseif ($type == 'data') {
			if (!$data['content']) showmessage(L('content_no_empty'), HTTP_REFERER);
		}
		return $data;
	}


	/**
	 * 同時發布到其他欄目
	 */
	public function add_othors() {
		$show_header = '';
		$partition_id = intval($_GET['partition_id']);
		$parentid = intval($_GET['parentid']);
		//獲取頂級專區的詳情
		$partition_array = $this->partition_db->get_one(array("catid"=>$parentid),'*');

		$sitelist = getcache('sitelist','commons');
		$siteid = $_GET['siteid'];
		include $this->admin_tpl('add_othors');

	}

	//獲取當前專區下的欄目
	public function public_getsite_categorys(){
		$partition_id = intval($_GET['partition_id']);
		// $siteid = intval($_GET['siteid']);
		// $this->categorys = getcache('category_content_'.$siteid,'commons'); 

		$models = getcache('model','commons');
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;'; 

		$categorys = array(); 


		$parentid = intval($_GET['parentid']); 

        if( !$parentid ){
            $result = $this->partition_db->select("`module`='partition'", '*', '', '`listorder` DESC');
        }else{
            $result = $this->partition_db->select("`module`='partition' AND `arrparentid` like '%".$parentid."%'", '*', '', '`listorder` ASC');
            $tabnum = 0;
            foreach( $result as $key=>$value ){
                if( $value['parentid']==$parentid ){
                    $result[$key]['parentid'] = 0;
                }
                if ($value['is_tab'] == 1) {
                    $tabnum++;
                    $result[$key]['catname'] .= ' <span class="red">[TAB'.$tabnum.']</span>';
                }
                if ($value['is_tab2'] == 1) {
                    $tabnum++;
                    $result[$key]['catname'] .= ' <span class="green">[TAB'.$tabnum.']</span>';
                }
                $this->categorys = $result;
                $result[$key]['arrparentid'] = $this->get_arrparentid( $value['catid'] );
                $result[$key]['arrchildid'] = $this->get_arrchildid( $value['catid'] );
                $result[$key]['son_show'] = 1;
            }
        }

        if(!empty($result)) {
            foreach($result as $r) {

                //管理菜單,ok
                $r['str_manage'] = '';

                //顯示子分區,ok
                $show_detail = empty($parentid) ? 0 : 1;
                if(!$show_detail) {//是否顯示子分區的情況,ok

                    //獲取指定父分區下的子分區
                    if($r['parentid']!=$parentid) continue;

                    //與構造樹的類有關, 保留就好
                    $r['parentid'] = 0;

                    $r['str_manage'] .= '<a href="?m=partition&c=partition&a=init&parentid='.$r['catid'].'&s='.$r['type'].'&pc_hash='.$_SESSION['pc_hash'].'">'.L('manage_sub_category').'</a> | ';

                }
                $temp_parentid = $r['parentid'];  

                if( !$show_detail ){//專區名加鏈接
                    $r['catname'] = '<a href="?m=partition&c=partition&a=init&parentid='.$r['catid'].'&s='.$r['type'].'&pc_hash='.$_SESSION['pc_hash'].'">'.$r['catname'].'</a>';
                }else{//子欄目加鏈接
                    $r['catname'] = $r['catname'];
                }
                $r['click'] = $r['child'] ? '' : "onclick=\"select_list(this,'".safe_replace($r['catname'])."',".$r['catid'].")\" class='cu' title='".L('click_to_select')."'";

                //ok
                $categorys[$r['catid']] = $r;
            }
        }

        $str  = "<tr \$click >
                <td align='center'>\$id</td>
                <td style='\$style'>\$spacer\$catname</td>
                <td align='center'>\$modelname</td>
            </tr>";


        //構造分區樹相關,ok
        $tree->init($categorys);
        $categorys = $tree->get_tree(0, $str);
		echo $categorys;
	}


    /**
     *
     * 獲取父分區ID列表,ok
     * @param integer $catid              欄目ID
     * @param array $arrparentid          父目錄ID
     * @param integer $n                  查找的層次
     */
    private function get_arrparentid($catid, $arrparentid = '', $n = 1) {
        if($n > 5 || !is_array($this->categorys) || !isset($this->categorys[$catid])) return false;
        $parentid = $this->categorys[$catid]['parentid'];
        $arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
        if($parentid) {
            $arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
        } else {
            $this->categorys[$catid]['arrparentid'] = $arrparentid;
        }
        $parentid = $this->categorys[$catid]['parentid'];
        return $arrparentid;
    }

    /**
     *
     * 獲取子欄目ID列表,ok
     * @param $catid 欄目ID
     */
    private function get_arrchildid($catid) {
        $arrchildid = $catid;
        if(is_array($this->categorys)) {
            foreach($this->categorys as $id => $cat) {
                if($cat['parentid'] && $id != $catid && $cat['parentid']==$catid) {
                    $arrchildid .= ','.$this->get_arrchildid($id);
                }
            }
        }
        return $arrchildid;
    }


    /**
    * 查看當前專區所有的文章，並進行分頁
    */
    public function init_all(){
	    $partitionid = intval($_GET['partitionid']);
	    if(!$partitionid){
	    showmessage('請通過正常的路徑查看文章列表 ！',HTTP_REFERER);
	    }
	    //查詢當前專區下所有子欄目（只限最小子欄目）
	    $where = array();
	    $result = array();
	    $result = $this->partition_db->select("`module`='partition' AND `arrparentid` like '%0,".$partitionid.",%'", '*', '', '`listorder` ASC');
	    if(is_array($result)){
			foreach( $result as $key=>$value ){
				if($value['child']==0){
					$where[] =$value['catid'];
				}
			}
	    }

	    $partition_game_where = to_sqls($where,'','part_id');
		$page = max(intval($_GET['page']), 1);
		//查詢專區的文章
		$partition_game_datas = $this->db_partition_games->listinfo($partition_game_where,'inputtime desc',$page,20);
		if(is_array($partition_game_datas) && !empty($partition_game_datas)){
	        foreach( $partition_game_datas as $key=>$value ){
				$this->db->set_model($value['modelid']);
				$datas[$key] = $this->db->get_one( array('id'=>$value['gameid']) );
				$sort_name = $this->db_model->get_one( array('modelid'=>$value['modelid']), 'name'  );

				//這裡不合適,需要改->www_categorys
				$datas[$key]['sort_name'] = $sort_name['name'];
				$datas[$key]['sort_value'] = $value['modelid'];
				$datas[$key]['listorder'] = $value['listorder'];
			}
		}
        $pages = $this->db_partition_games->pages;

        // $big_menu = array( array('javascript:openwinx(\'?m=partition&c=content&a=add&parentid='.$_GET['parentid'].'&partition_id='.$_GET['specialid'].'\',\'\');void(0);', L('add_content')),array('javascript:window.top.art.dialog({id:\'import\',iframe:\'?m=partition&c=partition&a=import&specialid='.$_GET['specialid'].'\', title:\''.L('import_content').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'import\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'import\'}).close()});void(0);', L('import_content')));

        include $this->admin_tpl('content_list_all');
    }


    //專區文章後，更新URL為真正的當前專區URL ，供新聞源抓取使用
    public function make_partition_url($parentid,$catid='1317',$contentid){
    	if(!$parentid || !$catid || !$contentid){
    		return false;
    	}
    	$partition_array = $this->partition_db->get_one(array("catid"=>$parentid));
    	$domain_dir = $partition_array['domain_dir'];
    	$is_domain = $partition_array['is_domain'];
    	if($is_domain==1){
    		$url = "http://".$domain_dir.".mofang.com.tw/".$catid.'_'.$contentid.'.html';
    	}else{
    		$url = "http://www.mofang.com.tw/".$domain_dir.'/'.$catid.'_'.$contentid.'.html';
    	}
    	return $url;
    }



}

