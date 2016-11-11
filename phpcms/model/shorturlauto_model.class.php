<?php
/**
 * 短连接10进制表
 */
define('IN_CHECKCODE',true);
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);

class shorturlauto_model extends model {
    /**
     * 常规构造函数
     */
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'default';
        $this->table_name = 'shorturlauto';
        $this->is_master = 'yes';
        parent::__construct();
    }
}