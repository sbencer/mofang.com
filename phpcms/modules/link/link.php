<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class link extends admin {
	function __construct() {
		parent::__construct();
		$this->M = new_html_special_chars(getcache('link', 'commons'));
		$this->db = pc_base::load_model('link_model');
		$this->db2 = pc_base::load_model('type_model');
	}

	public function init() {
		if($_GET['typeid']!=''){
			$where = array('typeid'=>intval($_GET['typeid']),'siteid'=>$this->get_siteid());
		}else{
			$where = array('siteid'=>$this->get_siteid());
		}
 		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db->listinfo($where,$order = 'listorder DESC,linkid DESC',$page, $pages = '9');
		$pages = $this->db->pages;
		$types = $this->db2->listinfo(array('module'=>ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
		$types = new_html_special_chars($types);
 		$type_arr = array ();
 		foreach($types as $typeid=>$type){
			$type_arr[$type['typeid']] = $type['name'];
		}
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=link&c=link&a=add\', title:\''.L('link_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('link_add'));
		include $this->admin_tpl('link_list');
	}

	/*
	 *判斷標題重復和驗證 
	 */
	public function public_name() {
		$link_title = isset($_GET['link_name']) && trim($_GET['link_name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['link_name'])) : trim($_GET['link_name'])) : exit('0');
			
		$linkid = isset($_GET['linkid']) && intval($_GET['linkid']) ? intval($_GET['linkid']) : '';
		$data = array();
		if ($linkid) {

			$data = $this->db->get_one(array('linkid'=>$linkid), 'name');
			if (!empty($data) && $data['name'] == $link_title) {
				exit('1');
			}
		}
		if ($this->db->get_one(array('name'=>$link_title), 'linkid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	 
	//添加分類時，驗證分類名是否已存在
	public function public_check_name() {
		$type_name = isset($_GET['type_name']) && trim($_GET['type_name']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['type_name'])) : trim($_GET['type_name'])) : exit('0');
		$type_name = safe_replace($type_name);
 		$typeid = isset($_GET['typeid']) && intval($_GET['typeid']) ? intval($_GET['typeid']) : '';
 		$data = array();
		if ($typeid) {
 			$data = $this->db2->get_one(array('typeid'=>$typeid), 'name');
			if (!empty($data) && $data['name'] == $type_name) {
				exit('1');
			}
		}
		if ($this->db2->get_one(array('name'=>$type_name), 'typeid')) {
			exit('0');
		} else {
			exit('1');
		}
	}
	 
	//添加友情鏈接
 	public function add() {
 		if(isset($_POST['dosubmit'])) {
			$_POST['link']['addtime'] = SYS_TIME;
			$_POST['link']['siteid'] = $this->get_siteid();
			if(empty($_POST['link']['name'])) {
				showmessage(L('sitename_noempty'),HTTP_REFERER);
			} else {
				$_POST['link']['name'] = safe_replace($_POST['link']['name']);
			}
			if ($_POST['link']['logo']) {
				$_POST['link']['logo'] = safe_replace($_POST['link']['logo']);
			}
			$data = new_addslashes($_POST['link']);
			$linkid = $this->db->insert($data,true);
			if(!$linkid) return FALSE; 
 			$siteid = $this->get_siteid();
	 		//更新附件狀態
			if(pc_base::load_config('system','attachment_stat') & $_POST['link']['logo']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['link']['logo'],'link-'.$linkid,1);
			}
			showmessage(L('operation_success'),HTTP_REFERER,'', 'add');
		} else {
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
 			$siteid = $this->get_siteid();
			$types = $this->db2->get_types($siteid);
			
			//print_r($types);exit;
 			include $this->admin_tpl('link_add');
		}

	}
	
	/**
	 * 說明:異步更新排序 
	 * @param  $optionid
	 */
	public function listorder_up() {
		$result = $this->db->update(array('listorder'=>'+=1'),array('linkid'=>$_GET['linkid']));
		if($result){
			echo 1;
		} else {
			echo 0;
		}
	}
	
	//更新排序
 	public function listorder() {
		if(isset($_POST['dosubmit'])) {
			foreach($_POST['listorders'] as $linkid => $listorder) {
				$linkid = intval($linkid);
				$this->db->update(array('listorder'=>$listorder),array('linkid'=>$linkid));
			}
			showmessage(L('operation_success'),HTTP_REFERER);
		} 
	}
	
	//添加友情鏈接分類
 	public function add_type() {
		if(isset($_POST['dosubmit'])) {
			if(empty($_POST['type']['name'])) {
				showmessage(L('typename_noempty'),HTTP_REFERER);
			}
			$_POST['type']['siteid'] = $this->get_siteid(); 
			$_POST['type']['module'] = ROUTE_M;
 			$this->db2 = pc_base::load_model('type_model');
			$typeid = $this->db2->insert($_POST['type'],true);
			if(!$typeid) return FALSE;
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_validator = $show_scroll = true;
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=link&c=link&a=add\', title:\''.L('link_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('link_add'));
 			include $this->admin_tpl('link_type_add');
		}

	}
	
	/**
	 * 刪除分類
	 */
	public function delete_type() {
		if((!isset($_GET['typeid']) || empty($_GET['typeid'])) && (!isset($_POST['typeid']) || empty($_POST['typeid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['typeid'])){
				foreach($_POST['typeid'] as $typeid_arr) {
 					$this->db2->delete(array('typeid'=>$typeid_arr));
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}else{
				$typeid = intval($_GET['typeid']);
				if($typeid < 1) return false;
				$result = $this->db2->delete(array('typeid'=>$typeid));
				if($result)
				{
					showmessage(L('operation_success'),HTTP_REFERER);
				}else {
					showmessage(L("operation_failure"),HTTP_REFERER);
				}
			}
		}
	}
	
	//:分類管理
 	public function list_type() {
		$this->db2 = pc_base::load_model('type_model');
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'listorder DESC',$page, $pages = '10');
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=link&c=link&a=add\', title:\''.L('link_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('link_add'));
		$pages = $this->db2->pages;
		include $this->admin_tpl('link_list_type');
	}
 
	public function edit() {
		if(isset($_POST['dosubmit'])){
 			$linkid = intval($_GET['linkid']);
			if($linkid < 1) return false;
			if(!is_array($_POST['link']) || empty($_POST['link'])) return false;
			if((!$_POST['link']['name']) || empty($_POST['link']['name'])) return false;
			$this->db->update($_POST['link'],array('linkid'=>$linkid));
			//更新附件狀態
			if(pc_base::load_config('system','attachment_stat') & $_POST['link']['logo']) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['link']['logo'],'link-'.$linkid,1);
			}
			showmessage(L('operation_success'),'?m=link&c=link&a=edit','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			$types = $this->db2->listinfo(array('module'=> ROUTE_M,'siteid'=>$this->get_siteid()),$order = 'typeid DESC');
 			$type_arr = array ();
			foreach($types as $typeid=>$type){
				$type_arr[$type['typeid']] = $type['name'];
			}
			//解出鏈接內容
			$info = $this->db->get_one(array('linkid'=>$_GET['linkid']));
			if(!$info) showmessage(L('link_exit'));
			extract($info); 
 			include $this->admin_tpl('link_edit');
		}

	}
	
	/**
	 * 修改友情鏈接 分類
	 */
	public function edit_type() {
		if(isset($_POST['dosubmit'])){ 
			$typeid = intval($_GET['typeid']); 
			if($typeid < 1) return false;
			if(!is_array($_POST['type']) || empty($_POST['type'])) return false;
			if((!$_POST['type']['name']) || empty($_POST['type']['name'])) return false;
			$this->db2->update($_POST['type'],array('typeid'=>$typeid));
			showmessage(L('operation_success'),'?m=link&c=link&a=list_type','', 'edit');
			
		}else{
 			$show_validator = $show_scroll = $show_header = true;
			//解出分類內容
			$info = $this->db2->get_one(array('typeid'=>$_GET['typeid']));
			if(!$info) showmessage(L('linktype_exit'));
			extract($info);
			include $this->admin_tpl('link_type_edit');
		}

	}

	/**
	 * 刪除友情鏈接  
	 * @param	intval	$sid	友情鏈接ID，遞歸刪除
	 */
	public function delete() {
  		if((!isset($_GET['linkid']) || empty($_GET['linkid'])) && (!isset($_POST['linkid']) || empty($_POST['linkid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['linkid'])){
				foreach($_POST['linkid'] as $linkid_arr) {
 					//批量刪除友情鏈接
					$this->db->delete(array('linkid'=>$linkid_arr));
					//更新附件狀態
					if(pc_base::load_config('system','attachment_stat')) {
						$this->attachment_db = pc_base::load_model('attachment_model');
						$this->attachment_db->api_delete('link-'.$linkid_arr);
					}
				}
				showmessage(L('operation_success'),'?m=link&c=link');
			}else{
				$linkid = intval($_GET['linkid']);
				if($linkid < 1) return false;
				//刪除友情鏈接
				$result = $this->db->delete(array('linkid'=>$linkid));
				//更新附件狀態
				if(pc_base::load_config('system','attachment_stat')) {
					$this->attachment_db = pc_base::load_model('attachment_model');
					$this->attachment_db->api_delete('link-'.$linkid);
				}
				if($result){
					showmessage(L('operation_success'),'?m=link&c=link');
				}else {
					showmessage(L("operation_failure"),'?m=link&c=link');
				}
			}
			showmessage(L('operation_success'), HTTP_REFERER);
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
		$data = $m_db->select(array('module'=>'link'));
		$setting = string2array($data[0]['setting']);
		$now_seting = $setting[$siteid]; //當前站點配置
		if(isset($_POST['dosubmit'])) {
			//多站點存儲配置文件
 			$setting[$siteid] = $_POST['setting'];
  			setcache('link', $setting, 'commons');  
			//更新模型數據庫,重設setting 數據. 
  			$m_db = pc_base::load_model('module_model'); //調用模塊數據模型
			$set = array2string($setting);
			$m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
			showmessage(L('setting_updates_successful'), '?m=link&c=link&a=init');
		} else {
			@extract($now_seting);
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=link&c=link&a=add\', title:\''.L('link_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('link_add'));
 			include $this->admin_tpl('setting');
		}
	}
	
  	//批量審核申請 ...
 	public function check_register(){
		if(isset($_POST['dosubmit'])) {
			if((!isset($_GET['linkid']) || empty($_GET['linkid'])) && (!isset($_POST['linkid']) || empty($_POST['linkid']))) {
				showmessage(L('illegal_parameters'), HTTP_REFERER);
			} else {
				if(is_array($_POST['linkid'])){//批量審核
					foreach($_POST['linkid'] as $linkid_arr) {
						$this->db->update(array('passed'=>1),array('linkid'=>$linkid_arr));
					}
					showmessage(L('operation_success'),'?m=link&c=link');
				}else{//單個審核
					$linkid = intval($_GET['linkid']);
					if($linkid < 1) return false;
					$result = $this->db->update(array('passed'=>1),array('linkid'=>$linkid));
					if($result){
						showmessage(L('operation_success'),'?m=link&c=link');
					}else {
						showmessage(L("operation_failure"),'?m=link&c=link');
					}
				}
			}
		}else {//讀取未審核列表
			$where = array('siteid'=>$this->get_siteid(),'passed'=>0);
			$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
			$infos = $this->db->listinfo($where,'linkid DESC',$page, $pages = '9');
			$pages = $this->db->pages;
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=link&c=link&a=add\', title:\''.L('link_add').'\', width:\'700\', height:\'450\'}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('link_add'));
			include $this->admin_tpl('check_register_list');
		}
		
	}
	
 	//單個審核申請
 	public function check(){
		if((!isset($_GET['linkid']) || empty($_GET['linkid'])) && (!isset($_POST['linkid']) || empty($_POST['linkid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else { 
			$linkid = intval($_GET['linkid']);
			if($linkid < 1) return false;
			//刪除友情鏈接
			$result = $this->db->update(array('passed'=>1),array('linkid'=>$linkid));
			if($result){
				showmessage(L('operation_success'),'?m=link&c=link');
			}else {
				showmessage(L("operation_failure"),'?m=link&c=link');
			}
			 
		}
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
 
 
	
}
?>