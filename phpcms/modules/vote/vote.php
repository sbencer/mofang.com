<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class vote extends admin {
	private $db2, $db;
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('vote', 'commons'));
		$this->db = pc_base::load_model('vote_subject_model');
		$this->db2 = pc_base::load_model('vote_option_model');
	}

	public function init() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo(array('siteid'=>$this->get_siteid()),'subjectid DESC',$page, '14');
		$pages = $this->db->pages;
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=vote&c=vote&a=add\', title:\''.L('vote_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('vote_add'));
		include $this->admin_tpl('vote_list'); 
 	}

	/*
	 *判斷標題重復和驗證 
	 */
	public function public_name() {
		$subject_title = isset($_GET['subject_title']) && trim($_GET['subject_title']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['subject_title'])) : trim($_GET['subject_title'])) : exit('0');
		$subjectid = isset($_GET['subjectid']) && intval($_GET['subjectid']) ? intval($_GET['subjectid']) : '';
		$data = array();
		if ($subjectid) {
			$data = $this->db->get_one(array('subjectid'=>$subjectid), 'subject');
			if (!empty($data) && $data['subject'] == $subject_title) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('subject'=>$subject_title), 'subjectid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
	/*
	 *判斷結束時間是否比當前時間小  
	 */
	public function checkdate() {
		$nowdate = date('Y-m-d',SYS_TIME);
		$todate = $_GET['todate'];
		if($todate > $nowdate){
			exit('1');
		}else {
			exit('0');
		}
	}
	
	/**
	 * 添加投票
	 */
	public function add() {
		//讀取配置文件
		$data = array();
		$data = $this->M;
		$siteid = $this->get_siteid();//當前站點
		if(isset($_POST['dosubmit'])) {
			
			$_POST['subject']['addtime'] = SYS_TIME;
			$_POST['subject']['siteid'] = $this->get_siteid();
			if(empty($_POST['subject']['subject'])) {
				showmessage(L('vote_title_noempty'),'?m=vote&c=vote&a=add');
			}
 			//記錄選項條數 optionnumber 
			$_POST['subject']['optionnumber'] = count($_POST['option']);
			$_POST['subject']['template'] = $_POST['vote_subject']['vote_tp_template'];
 			
			$subjectid = $this->db->insert($_POST['subject'],true);
			if(!$subjectid) return FALSE; //返回投票ID值, 以備下面添加對應選項用,不存在返回錯誤
			//添加選項操作
			$this->db2->add_options($_POST['option'],$subjectid,$this->get_siteid());
			//生成JS文件
			$this->update_votejs($subjectid);
			if(isset($_POST['from_api'])&& $_POST['from_api']) {
				showmessage(L('operation_success'),'?m=vote&c=vote&a=add','100', '',"window.top.$('#voteid').val('".$subjectid."');window.top.art.dialog({id:'addvote'}).close();");
			} else {
				showmessage(L('operation_success'),'?m=vote&c=vote','','add');
 			}
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			@extract($data[$siteid]);
			//模版
			pc_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$template_list = template_list($siteid, 0);
			$site = pc_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			include $this->admin_tpl('vote_add');
		}

	}

	/**
	 * 編輯投票
	 */
	public function edit() {

		if(isset($_POST['dosubmit'])){
			//驗證數據正確性
				$subjectid = intval($_GET['subjectid']);
				if($subjectid < 1) return false;
				if(!is_array($_POST['subject']) || empty($_POST['subject'])) return false;
				if((!$_POST['subject']['subject']) || empty($_POST['subject']['subject'])) return false;
 				$this->db2->update_options($_POST['option']);//先更新已有 投票選項,再添加新增加投票選項
				if(is_array($_POST['newoption'])&&!empty($_POST['newoption'])){
					$siteid = $this->get_siteid();//新加選項站點ID
					$this->db2->add_options($_POST['newoption'],$subjectid,$siteid);
				}
				//模版 
				$_POST['subject']['template'] = $_POST['vote_subject']['vote_tp_template'];
				
				$_POST['subject']['optionnumber'] = count($_POST['option'])+count($_POST['newoption']);
	 			$this->db->update($_POST['subject'],array('subjectid'=>$subjectid));//更新投票選項總數
				$this->update_votejs($subjectid);//生成JS文件
				showmessage(L('operation_success'),'?m=vote&c=vote&a=edit','', 'edit');
			}else{
				$show_validator = $show_scroll = $show_header = true;
				pc_base::load_sys_class('form', '', 0);
				
				//解出投票內容
				$info = $this->db->get_one(array('subjectid'=>$_GET['subjectid']));
				if(!$info) showmessage(L('operation_success'));
				extract($info);
					
				//解出投票選項
				$this->db2 = pc_base::load_model('vote_option_model');
				$options = $this->db2->get_options($_GET['subjectid']);
				
				//模版
				pc_base::load_app_func('global', 'admin');
				$siteid = $this->get_siteid();
				$template_list = template_list($siteid, 0);
				$site = pc_base::load_app_class('sites','admin');
				$info = $site->get_by_id($siteid);
				foreach ($template_list as $k=>$v) {
					$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
					unset($template_list[$k]);
				}
	
				include $this->admin_tpl('vote_edit');
		}

	}

	/**
	 * 刪除投票 
	 * @param	intval	$sid	投票的ID，遞歸刪除
	 */
	public function delete() {
		if((!isset($_GET['subjectid']) || empty($_GET['subjectid'])) && (!isset($_POST['subjectid']) || empty($_POST['subjectid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
				
			if(is_array($_POST['subjectid'])){
				foreach($_POST['subjectid'] as $subjectid_arr) {
					//刪除對應投票的選項
					$this->db2 = pc_base::load_model('vote_option_model');
					$this->db2->del_options($subjectid_arr);
					$this->db->delete(array('subjectid'=>$subjectid_arr));
				}
				showmessage(L('operation_success'),'?m=vote&c=vote');
			}else{
				$subjectid = intval($_GET['subjectid']);
				if($subjectid < 1) return false;
				//刪除對應投票的選項
				$this->db2 = pc_base::load_model('vote_option_model');
				$this->db2->del_options($subjectid);

				//刪除投票
				$this->db->delete(array('subjectid'=>$subjectid));
				$result = $this->db->delete(array('subjectid'=>$subjectid));
				if($result)
				{
					showmessage(L('operation_success'),'?m=vote&c=vote');
				}else {
					showmessage(L("operation_failure"),'?m=vote&c=vote');
				}
			}
				
			showmessage(L('operation_success'), HTTP_REFERER);
		}
	}
	/**
	 * 說明:刪除對應投票選項
	 * @param  $optionid
	 */
	public function del_option() {
		$result = $this->db2->del_option($_GET['optionid']);
		if($result) {
			echo 1;
		} else {
			echo 0;
		}
	} 
	
	
	/**
	 * 投票模塊配置
	 */
	public function setting() {
		//讀取配置文件
		$data = array();
 		$siteid = $this->get_siteid();//當前站點 
		//更新模型數據庫,重設setting 數據. 
		$m_db = pc_base::load_model('module_model');
		$data = $m_db->select(array('module'=>'vote'));
		$setting = string2array($data[0]['setting']);
		$now_seting = $setting[$siteid]; 
 		if(isset($_POST['dosubmit'])) {
			//多站點存儲配置文件
			$siteid = $this->get_siteid();//當前站點
			$setting[$siteid] = $_POST['setting'];
  			setcache('vote', $setting, 'commons');  
			//更新模型數據庫,重設setting 數據. 
 			$set = array2string($setting);
			$m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
			showmessage(L('setting_updates_successful'), '?m=vote&c=vote&a=init');
		} else {
			@extract($now_seting);
			pc_base::load_sys_class('form', '', 0);
			//模版
			pc_base::load_app_func('global', 'admin');
			$siteid = $this->get_siteid();
			$template_list = template_list($siteid, 0);
			$site = pc_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			include $this->admin_tpl('setting');
		}
	}


	/**
	 * 檢查表單數據
	 * @param	Array	$data	表單傳遞過來的數組
	 * @return Array	檢查後的數組
	 */
	private function check($data = array()) {
		if($data['name'] == '') showmessage(L('name_plates_not_empty'));
		if(!isset($data['width']) || $data['width']==0) {
			showmessage(L('plate_width_not_empty'), HTTP_REFERER);
		} else {
			$data['width'] = intval($data['width']);
		}
		if(!isset($data['height']) || $data['height']==0) {
			showmessage(L('plate_height_not_empty'), HTTP_REFERER);
		} else {
			$data['height'] = intval($data['height']);
		}
		return $data;
	}
		
	/**
	 * 投票結果統計
	 */
	public function statistics() {
			$subjectid = intval($_GET['subjectid']);
			if(!$subjectid){
				showmessage(L('illegal_operation'));
			}
			$show_validator = $show_scroll = $show_header = true;
 			//獲取投票信息
			$sdb = pc_base::load_model('vote_data_model'); //加載投票統計的數據模型
        	$infos = $sdb->select("subjectid = $subjectid",'data');	
          	//新建一數組用來存新組合數據
        	$total = 0;
        	$vote_data =array();
			$vote_data['total'] = 0 ;//所有投票選項總數
			$vote_data['votes'] = 0 ;//投票人數
			//循環每個會員的投票記錄
			foreach($infos as $subjectid_arr) {
					extract($subjectid_arr);
 					$arr = string2array($data);
 					foreach($arr as $key => $values){
 						$vote_data[$key]+=1;
					}
  					$total += array_sum($arr);
					$vote_data['votes']++ ;
			}
 			$vote_data['total'] = $total ;
 			//取投票選項
			$options = $this->db2->get_options($subjectid);	
			include $this->admin_tpl('vote_statistics');	
	}
	
	/**
	 * 投票會員統計
	 */
	public function statistics_userlist() {
			$subjectid = $_GET['subjectid'];
			if(empty($subjectid)) return false;
 			$show_validator = $show_scroll = $show_header = true;
			$where = array ("subjectid" => $subjectid);
			$sdb = pc_base::load_model('vote_data_model'); //調用統計的數據模型
 			$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			$infos = $sdb->listinfo($where,'time DESC',$page,'7');
			$pages = $sdb->pages;
			include $this->admin_tpl('vote_statistics_userlist');
	}
	
	/**
	 * 說明:生成JS投票代碼
	 * @param $subjectid 投票ID
	 */
	function update_votejs($subjectid){
 			if(!isset($subjectid)||intval($subjectid) < 1) return false;
			//解出投票內容
			$info = $this->db->get_subject($subjectid);
			if(!$info) showmessage(L('not_vote'));
			extract($info);
 			//解出投票選項
			$options = $this->db2->get_options($subjectid);
 			ob_start();
 			include template('vote', $template);
			$voteform = ob_get_contents();
			ob_clean() ;
	        @file_put_contents(CACHE_PATH.'vote_js/vote_'.$subjectid.'.js', $this->format_js($voteform));
	        
	}
	
	/**
	 * 更新js
	 */
	public function create_js() {
 		$infos = $this->db->select(array('siteid'=>$this->get_siteid()), '*');
		if(is_array($infos)){
			foreach($infos as $subjectid_arr) {
				$this->update_votejs($subjectid_arr['subjectid']);
			}
		}
		showmessage(L('operation_success'),'?m=vote&c=vote');
	}
	
	/**
	 * 說明:對字符串進行處理
	 * @param $string 待處理的字符串
	 * @param $isjs 是否生成JS代碼
	 */
	function format_js($string, $isjs = 1){
		$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}
	
	/**
	 * 投票調用代碼
	 * 
	 */ 
 	public function public_call() {
 		$_GET['subjectid'] = intval($_GET['subjectid']);
		if(!$_GET['subjectid']) showmessage(L('illegal_action'), HTTP_REFERER, '', 'call');
		$r = $this->db->get_one(array('subjectid'=>$_GET['subjectid']));
		include $this->admin_tpl('vote_call');
	}
	/**
	 * 信息選擇投票接口
	 */
	public function public_get_votelist() {
		$infos = $this->db->listinfo(array('siteid'=>$this->get_siteid()),'subjectid DESC',$page,'10');
		$target = isset($_GET['target']) ? $_GET['target'] : '';
		include $this->admin_tpl('get_votelist');
	}
	
}
?>