<?php
/**
 *  db_factory.class.php 數據庫工廠類
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */

final class db_factory {
	
	/**
	 * 當前數據庫工廠類靜態實例
	 */
	private static $db_factory;
	
	/**
	 * 數據庫配置列表
	 */
	protected $db_config = array();
	
	/**
	 * 數據庫操作實例化列表
	 */
	protected $db_list = array();
	
	/**
	 * 構造函數
	 */
	public function __construct() {
	}
	
	/**
	 * 返回當前終級類對象的實例
	 * @param $db_config 數據庫配置
	 * @return object
	 */
	public static function get_instance($db_config = '') {
		if($db_config == '') {
			$db_config = pc_base::load_config('database');
		}
		if(db_factory::$db_factory == '') {
			db_factory::$db_factory = new db_factory();
		}
		if($db_config != '' && $db_config != db_factory::$db_factory->db_config) db_factory::$db_factory->db_config = array_merge($db_config, db_factory::$db_factory->db_config);
		return db_factory::$db_factory;
	}
	
	/**
	 * 獲取數據庫操作實例
	 * @param $db_name 數據庫配置名稱
	 */
	public function get_database($db_name) {
		if(!isset($this->db_list[$db_name]) || !is_object($this->db_list[$db_name])) {
			$this->db_list[$db_name] = $this->connect($db_name);
		}
		return $this->db_list[$db_name];
	}
	
	/**
	 *  加載數據庫驅動
	 * @param $db_name 	數據庫配置名稱
	 * @return object
	 */
	public function connect($db_name) {
		$object = null;
		switch($this->db_config[$db_name]['type']) {
			case 'mysql' :
				pc_base::load_sys_class('mysql', '', 0);
				$object = new mysql();
				break;
			case 'mysqli' :
				$object = pc_base::load_sys_class('mysqli');
				break;
			case 'access' :
				$object = pc_base::load_sys_class('db_access');
				break;
			default :
				pc_base::load_sys_class('mysql', '', 0);
				$object = new mysql();
		}
		$object->open($this->db_config[$db_name]);
		return $object;
	}

	/**
	 * 關閉數據庫連接
	 * @return void
	 */
	protected function close() {
		foreach($this->db_list as $db) {
			$db->close();
		}
	}
	
	/**
	 * 析構函數
	 */
	public function __destruct() {
		$this->close();
	}
}
?>