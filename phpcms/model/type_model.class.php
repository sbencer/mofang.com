<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class type_model extends model {
	function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'type';
		parent::__construct();
	}
	
	/**
	 * 說明: 查詢對應模塊下的分類
	 * @param $m  模塊名稱
	 */
	function get_types($siteid){
		if(!ROUTE_M) return FALSE;
		return $this->select(array('module'=> ROUTE_M,'siteid'=>$siteid),'*','',$order = 'typeid ASC');
	}
}
?>