<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class sarcasm_check_model extends model {
	public $table_name;
	public $old_table_name;
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'sarcasm';
		$this->table_name = $this->old_table_name = 'sarcasm_check';
		parent::__construct();
	}
}
?>
