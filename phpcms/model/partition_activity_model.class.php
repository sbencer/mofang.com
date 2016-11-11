<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class partition_activity_model extends model {
	
	public $table_name;
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		
		$this->db_setting = 'default';
		$this->table_name = 'partition_activity';
		parent::__construct();
	}

	public function is_online($partid) {
		$partition_info = $this->get_one(array('catid'=>$partid));
		return $partition_info['is_online'] == 1;
	}

	public function get_info_url($catid, $id, $partid) {
		$partition_url = $this->get_partition_url($partid);
		$info_url = "$partition_url/{$catid}_{$id}.html";
		return $info_url;
	}

    /*
     * 獲取專區url->這裡未啟用->如需啟用需根據規則調整代碼
     *
     **/
	public function get_partition_url($partid) {
		$partition_url = '';
		$partition_info = $this->get_one(array('catid'=>$partid));
		if( $partition_info['is_domain'] ){
			$partition_url = 'http://'.$partition_info['domain_dir'].'.mofang.com.tw';
		} else {
			//$partition_url = 'http://www.mofang.com.tw/p/'.$partition_info['domain_dir'];
			//去掉P，解決多次301跳轉的問題
			$partition_url = 'http://www.mofang.com.tw/'.$partition_info['domain_dir'];
		}
		return $partition_url;
	}
}
?>
