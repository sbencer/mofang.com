<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class sarcasm_setting_model extends model {
	public $table_name;
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'sarcasm';
		$this->table_name = 'sarcasm_setting';
		parent::__construct();
	}
	
	/**
	 * 按站點ID返回站點配置情況
	 * @param integer $siteid 站點ID
	 */
	public function site($siteid) {
		return $this->get_one(array('siteid'=>$siteid));
	}
}
?>
