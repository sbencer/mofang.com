<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class message_model extends model {
	function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'message';
		$this->_username = param::get_cookie('_username');
		$this->_userid = param::get_cookie('_userid');
		parent::__construct();
	}
	
	/**
	 * 
	 * 檢查當前用戶短消息相關權限
	 * @param  $userid 用戶ID
	 */
	public function messagecheck($userid){
		$member_arr = get_memberinfo($this->_userid);
		$groups = getcache('grouplist','member');
 		if($groups[$member_arr['groupid']]['allowsendmessage']==0){
			showmessage('對不起你沒有權限發短消息',HTTP_REFERER);
		}else {
			//判斷是否到限定條數
			$num = $this->get_membermessage($this->_username);
			if($num>=$groups[$member_arr['groupid']]['allowmessage']){
				showmessage('你的短消息條數已達最大值!',HTTP_REFERER);
			}
		}
	}
	
	/**
	 * 
	 * 獲取用戶發消息信息 ...
	 */
	public function get_membermessage($username){
 		$arr = $this->select(array('send_from_id'=>$username));
 		return count($arr);
	}
	
	public function add_message($tousername,$username,$subject,$content) {
			$message = array ();
			$message['send_from_id'] = $username;
			$message['send_to_id'] = $tousername;
			$message['subject'] = $subject;
			$message['content'] = $content;
			$message['message_time'] = SYS_TIME;
			$message['status'] = '1';
			$message['folder'] = 'inbox';

			if($message['send_from_id']==""){
				$message['send_from_id'] = $this->_username;
			}
			if(empty($message['content'])){
				showmessage('發信內空不能為空！',HTTP_REFERER);
			}
			
			$messageid = $this->insert($message,true);
			if(!$messageid){
				return FALSE;
			}else {
				return true;
			}
	}
	
}
?>