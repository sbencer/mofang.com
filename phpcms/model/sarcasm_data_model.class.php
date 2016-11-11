<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class sarcasm_data_model extends model {
	public $table_name;
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'sarcasm';
		$this->table_name = '';
		parent::__construct();
	}
	
	/**
	 * 設置評論數據表
	 * @param integer $id 數據表ID
	 */
	public function table_name($id) {
		$this->table_name = $this->db_config[$this->db_setting]['tablepre'].'sarcasm_data_'.$id;
		return $this->table_name;
	}
}
?>
