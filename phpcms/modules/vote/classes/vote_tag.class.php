<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class vote_tag {
 	public function __construct() {
		$this->subject_db = pc_base::load_model('vote_subject_model');
		$this->option_db = pc_base::load_model('vote_option_model');
	}
	
	/**
	 * 顯示
	 * @param  $data 
	 */
	public function show($data) {
		$subjectid = $data['subjectid'];//投票ID
		if($subjectid){
			if(is_int($subjectid)) return false;
			$sql = array('subjectid'=>$subjectid);
		}else {
			$sql = '';
		}
		return $this->subject_db->select($sql, '*', $data['limit']);
	}
	
	/**
	 * 其它投票
	 * @param  $data 
	 */
	public function other_vote($data) {
		$siteid = $_GET['siteid'];
		$sql = array('siteid'=>$siteid); 
		return $this->subject_db->select($sql, '*', $data['limit'], $data['order']);
	} 
	
	/**
	 * 投票熱度排行 
	 * @param  $data 傳入的數組參數
	 */
	public function hits($data) {
		$siteid = intval($data['siteid']);
		$enabled = $data['enabled']?$data['enabled'] : 1;//狀態:是否啟用
		if (empty($siteid)){
			$siteid = get_siteid();
		}
		switch ($enabled) {
			case all://不限
				$sql = array('siteid'=>$siteid); 
				break; 
			default://默認按選擇項
				$sql = array('siteid'=>$siteid,'enabled'=>$enabled); 
		}
		return $this->subject_db->select($sql, '*', $data['limit'], 'votenumber '.$data['order']);
	} 
	
	/**
	 * 
	 * 投票列表
	 * @param $data 數組參數
	 */
	public function lists($data) {
		$siteid = intval($data['siteid']);
		$enabled = $data['enabled']?$data['enabled'] : 1;//狀態:是否啟用
		$order = $data['order']?$data['order'] : 'subjectid desc';//狀態:是否啟用
		if (empty($siteid)){
			$siteid = get_siteid();
		}
		switch ($enabled) {
			case all://不限
				$sql = array('siteid'=>$siteid); 
				break; 
			default://默認按選擇項
				$sql = array('siteid'=>$siteid,'enabled'=>$enabled); 
		}
 		return $this->subject_db->select($sql, '*', $data['limit'], $order);
	}	

	/**
	 * 投票概況
	 */
	public function get_vote($data) {
		$subjectid = intval($data['subjectid']);
		if (empty($subjectid)) return false;
  		return  $this->subject_db->get_one(array('subjectid'=>$subjectid));
	}
	
	/**
	 * 計數
	 */
	public function count($data) {
		if(isset($data['where'])) {
			$sql = $data['where'];
		} else {
				$siteid = intval($data['siteid']);
				$enabled = $data['enabled']?$data['enabled'] : 1;//狀態:是否啟用
				if (empty($siteid)){
					$siteid = get_siteid();
				}
				switch ($enabled) {
					case all://不限
						$sql = array('siteid'=>$siteid); 
						break; 
					default://默認按選擇項
						$sql = array('siteid'=>$siteid,'enabled'=>$enabled); 
				}
		 		return $this->subject_db->count($sql); 
		}		 		
	}
	 
	/**
	 * pc 標簽調用
	 */
	public function pc_tag() {
		$sites = pc_base::load_app_class('sites','admin');
		$sitelist = $sites->pc_tag_list();
		return array(
			'action'=>array('lists'=>L('list','', 'comment'),'get_vote'=>L('vote_overview','','vote')),
			'lists'=>array(
						'siteid'=>array('name'=>L('site_id', '', 'comment'),'htmltype'=>'input_select', 'data'=>$sitelist,'validator'=>array('min'=>1)),
 						'enabled'=>array('name'=>L('vote_status','','vote'), 'htmltype'=>'select', 'data'=>array('all'=>L('vote_Lockets','','vote'),'1'=>L('vote_use','','vote'), '0'=>L('vote_lock','','vote'))),
						'order'=>array('name'=>L('sort', '', 'comment'), 'htmltype'=>'select','data'=>array('subjectid desc'=>L('subjectid_desc', '', 'vote'), 'subjectid asc'=>L('subjectid_asc', '', 'vote'))),
					),
		    'get_vote'=>array(
						'subjectid'=>array('name'=>L('vote_voteid','','vote'),'htmltype'=>'input', 'validator'=>array('min'=>1)), 
					),
		);
	}
}