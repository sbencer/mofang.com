<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);

/**
 * 推荐位的  类别   此类别用于 统计点击量
 */

class adclass_model extends model {

    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'default';
        $this->table_name = 'adclass';
        parent::__construct();
    }

}


