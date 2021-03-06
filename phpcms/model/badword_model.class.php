<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class badword_model extends model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'badword';
		parent::__construct();
	}
	
	/**
	 * 敏感詞處理接口
	 * 對傳遞的數據進行處理,並返回 
	 */
	function replace_badword($str) {
		//讀取敏感詞緩存
		$badword_cache = getcache('badword','commons');
		foreach($badword_cache as $data){
 			if($data['replaceword'] == ''){
				$replaceword_new ='*';				
			  } else {
				$replaceword_new = $data['replaceword'];
			}
 			$replaceword[] = ($data['level']=='1') ? $replaceword_new : '';
 			$replace[] = $data['badword'];
		}
		$str = str_replace($replace, $replaceword, $str);
 		return $str;
 	}
}
?>