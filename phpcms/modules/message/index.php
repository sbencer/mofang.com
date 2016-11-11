<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('foreground','member');//加載foreground 應用類. 自動判斷是否登陸.
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class index extends foreground {
	function __construct() {
		parent::__construct();
		$this->message_db = pc_base::load_model('message_model');
		$this->message_group_db = pc_base::load_model('message_group_model');
		$this->message_data_db = pc_base::load_model('message_data_model');
		$this->_username = param::get_cookie('_username');
		$this->_userid = param::get_cookie('_userid');
		$this->_groupid = get_memberinfo($this->_userid,'groupid');
		pc_base::load_app_func('global');
		//定義站點ID常量，選擇模版使用
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : get_siteid();
  		define("SITEID",$siteid);
  	}

	public function init() {
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$where = array('send_to_id'=>$this->_username,'replyid'=>'0');
 		$infos = $this->message_db->listinfo($where,$order = 'messageid DESC',$page, 10);
 		$infos = new_html_special_chars($infos);
 		$pages = $this->message_db->pages;
		include template('message', 'inbox');
	}
	
	
	/**
	 * 發送消息 
	 */
	public function send() {
		//判斷當前會員，是否可發，短消息．
		$this->message_db->messagecheck($this->_userid);
		if(isset($_POST['dosubmit'])) {
			$username = $this->_username;
			$tousername = $_POST['info']['send_to_id'];
			$subject = new_html_special_chars($_POST['info']['subject']);
			$content = new_html_special_chars($_POST['info']['content']);
			$this->message_db->add_message($tousername,$username,$subject,$content,true);
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$show_validator = $show_scroll = $show_header = true;
			include template('message', 'send');
		}
	}
	
	/*
	 *判斷收件人是否存在 
	 */
	public function public_name() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? (pc_base::load_config('system', 'charset') == 'gbk' ? iconv('utf-8', 'gbk', trim($_GET['username'])) : trim($_GET['username'])) : exit('0');
		$member_interface = pc_base::load_app_class('member_interface', 'member');
		if ($username) {
			$username = safe_replace($username);
			//判斷收件人不能為自己
			if($username == $this->_username){
				exit('0');
			}
			$data = $member_interface->get_member_info($username, 2);
			if ($data!='-1') {
				exit('1');
			} else {
				exit('0');
			}
		} else {
			exit('0');
		}
		
	}
	
	/**
	 * 發件箱
	 */
	public function outbox() { 
		$where = array('send_from_id'=>$this->_username,'del_type'=>'0');
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->message_db->listinfo($where,$order = 'messageid DESC',$page, $pages = '8');
		$infos = new_html_special_chars($infos);
		$pages = $this->message_db->pages;
		include template('message', 'outbox');
	}
	
	/**
	 * 收件箱
	 */
	public function inbox() { 
		$where = array('send_to_id'=>$this->_username,'folder'=>'inbox');
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->message_db->listinfo($where,$order = 'messageid DESC',$page, $pages = '8'); 
		$infos = new_html_special_chars($infos);
		if (is_array($infos) && !empty($infos)) {
			foreach ($infos as $infoid=>$info){ 
				$reply_num = $this->message_db->count(array("replyid"=>$info['messageid']));
				$infos[$infoid]['reply_num'] = $reply_num;
	 		}
		}
		$pages = $this->message_db->pages;
		include template('message', 'inbox');
	}
	
	/**
	 * 群發郵件
	 */
	public function group() { 
		//查詢自己有權限看的消息
  		$where = array('typeid'=>1,'groupid'=>$this->_groupid,'status'=>1);
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
		$infos = $this->message_group_db->listinfo($where,$order = 'id DESC',$page, $pages = '8');
		$infos = new_html_special_chars($infos);
		$status = array();
		if (is_array($infos) && !empty($infos)) {
			foreach ($infos as $info){
				$d = $this->message_data_db->select(array('userid'=>$this->_userid,'group_message_id'=>$info['id']));
	 			if(!$d){
	 				$status[$info['id']] = 0;//未讀 紅色
	 			}else {
	 				$status[$info['id']] = 1;
	 			}
			}
		}
 		$pages = $this->message_group_db->pages;
		include template('message', 'group');
	}
	
	/**
	 * 刪除收件箱-短消息 
	 * @param	intval	$sid	短消息ID，遞歸刪除(修改狀態為outbox)
	 */
	public function delete() {
		if((!isset($_GET['messageid']) || empty($_GET['messageid'])) && (!isset($_POST['messageid']) || empty($_POST['messageid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['messageid'])){
				foreach($_POST['messageid'] as $messageid_arr) {
					$messageid_arr = intval($messageid_arr);
					$this->message_db->update(array('folder'=>'outbox'),array('messageid'=>$messageid_arr,'send_to_id'=>$this->_username));
				}
				showmessage(L('operation_success'), HTTP_REFERER);
			}
 		}
	}
	
	/**
	 * 刪除發件箱 - 短消息 
	 * @param	intval	$sid	短消息ID，遞歸刪除( 修改狀態為del_type =1 )
	 */
	public function del_type() {
		if((!isset($_POST['messageid']) || empty($_POST['messageid']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
				if(is_array($_POST['messageid'])){
					foreach($_POST['messageid'] as $messageid_arr) {
						$messageid_arr = intval($messageid_arr);
 						$this->message_db->update(array('del_type'=>'1'),array('messageid'=>$messageid_arr,'send_from_id'=>$this->_username));
					}
					showmessage(L('operation_success'), HTTP_REFERER);
				} 
		}
	}
	
	/**
	 * 查看短消息 - 對當前用戶是否有權限查看
	 */
	public function check_user($messageid,$where){
		$username = $this->_username;
		$messageid = intval($messageid);
		if($where=="to"){
			$result = $this->message_db->get_one(array("send_to_id"=>$username,"messageid"=>$messageid));
		}else{
			$result = $this->message_db->get_one(array("send_from_id"=>$username,"messageid"=>$messageid));
		}
 		if(!$result){//不是當前用戶的消息，不能查看
			showmessage('請勿非法訪問！', HTTP_REFERER);echo '0';
 		} 
	}
	
	
	/**
	 * 查看短消息
	 */
	public function read() { 
		if((!isset($_GET['messageid']) || empty($_GET['messageid'])) && (!isset($_POST['messageid']) || empty($_POST['messageid']))) return false;
		$messageid = $_GET['messageid'] ? $_GET['messageid'] : $_POST['messageid'];
		$messageid = intval($messageid);
		//判斷是否屬於當前用戶
		$check_user = $this->check_user($messageid,'to'); 
		
 		//查看過修改狀態 為 0 
		$this->message_db->update(array('status'=>'0'),array('messageid'=>$messageid));
		//查詢消息詳情
		$infos = $this->message_db->get_one(array('messageid'=>$messageid));
		if($infos['send_from_id']!='SYSTEM') $infos = new_html_special_chars($infos);
		//查詢回復消息
		$where = array('replyid'=>$infos['messageid']);
		$reply_infos = $this->message_db->listinfo($where,$order = 'messageid ASC',$page, $pages = '10');
		$show_validator = $show_scroll = $show_header = true;
		include template('message', 'read');
	}
	
	/**
	 * 查看自己發的短消息
	 */
	public function read_only() { 
		$messageid = $_GET['messageid'] ? $_GET['messageid'] : $_POST['messageid'];
		$messageid = intval($messageid);
		if(!$messageid || empty($messageid)){
			showmessage('請勿非法訪問！', HTTP_REFERER);
		}
		//判斷是否屬於當前用戶
		$check_user = $this->check_user($messageid,'from'); 
		
		//查詢消息詳情
		$infos = $this->message_db->get_one(array('messageid'=>$messageid));
		$infos = new_html_special_chars($infos);
		//查詢回復消息
		$where = array('replyid'=>$infos['messageid']);
		$reply_infos = $this->message_db->listinfo($where,$order = 'messageid ASC',$page, $pages = '10');
		$show_validator = $show_scroll = $show_header = true;
		include template('message', 'read_only');
	}
	
	/**
	 * 查看系統短消息
	 */
	public function read_group(){
		if((!isset($_GET['group_id']) || empty($_GET['group_id'])) && (!isset($_POST['group_id']) || empty($_POST['group_id']))) return false;
		//查詢消息詳情
		$infos = $this->message_group_db->get_one(array('id'=>$_GET['group_id']));
		$infos = new_html_special_chars($infos);
		if(!is_array($infos))showmessage(L('message_not_exist'),'blank');
		//檢查查看表是否有記錄,無則向message_data 插入瀏覽記錄  
		$check = $this->message_data_db->select(array('userid'=>$this->_userid,'group_message_id'=>$_GET['group_id']));
		if(!$check){
			$this->message_data_db->insert(array('userid'=>$this->_userid,'group_message_id'=>$_GET['group_id']));
		}
 		include template('message', 'read_group');
	}
	
	/**
	 * 回復短消息 
	 */
	public function reply() {
		if(isset($_POST['dosubmit'])) {
			$messageid = intval($_POST['info']['replyid']);
			//判斷當前會員，是否可發，短消息．
			$this->message_db->messagecheck($this->_userid);
			//檢查此消息是否有權限回復 
			$this->check_user($messageid,'to');
			$info = array();
			
 			$info['send_from_id'] = $this->_username;
			$info['message_time'] = SYS_TIME;
			$info['status'] = '1';
			$info['folder'] = 'inbox';
			$info['content'] = safe_replace($_POST['info']['content']);
			$info['subject'] = safe_replace($_POST['info']['subject']);
			$info['replyid'] = intval($_POST['info']['replyid']);
			if(empty($_POST['info']['send_to_id'])) {
				showmessage(L('user_noempty'),HTTP_REFERER);
			} else {
				$info['send_to_id'] = $_POST['info']['send_to_id'];
			}
			$messageid = $this->message_db->insert($info,true);
			if(!$messageid) return FALSE; 
			showmessage(L('operation_success'),HTTP_REFERER);
			
		} else {
			$show_validator = $show_scroll = $show_header = true; 
			include template('message', 'send');
		}

	}
	 
	
}	
?>	