<?php
/**
 *  cache_factory.class.php 緩存工廠類
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */

final class cache_factory {
	
	/**
	 * 當前緩存工廠類靜態實例
	 */
	private static $cache_factory;
	
	/**
	 * 緩存配置列表
	 */
	protected $cache_config = array();
	
	/**
	 * 緩存操作實例化列表
	 */
	protected $cache_list = array();
	
	/**
	 * 構造函數
	 */
	function __construct() {
	}
	
	/**
	 * 返回當前終級類對象的實例
	 * @param $cache_config 緩存配置
	 * @return object
	 */
	public static function get_instance($cache_config = '') {

		if(cache_factory::$cache_factory == '') {
			cache_factory::$cache_factory = new cache_factory();
			if(!empty($cache_config)) {
				cache_factory::$cache_factory->cache_config = $cache_config;
			}
		}
		return cache_factory::$cache_factory;
	}
	
	/**
	 * 獲取緩存操作實例
	 * @param $cache_name 緩存配置名稱
	 */
	public function get_cache($cache_name) {
		if(!isset($this->cache_list[$cache_name]) || !is_object($this->cache_list[$cache_name])) {
			$this->cache_list[$cache_name] = $this->load($cache_name);
		}
		return $this->cache_list[$cache_name];
	}
	
	/**
	 *  加載緩存驅動
	 * @param $cache_name 	緩存配置名稱
	 * @return object
	 */
	public function load($cache_name) {
		$object = null;
		if(isset($this->cache_config[$cache_name]['type'])) {
			switch($this->cache_config[$cache_name]['type']) {
				case 'file' :
					$object = pc_base::load_sys_class('cache_file');
					break;
				case 'memcache' :
					define('MEMCACHE_HOST', $this->cache_config[$cache_name]['hostname']);
					define('MEMCACHE_PORT', $this->cache_config[$cache_name]['port']);
					define('MEMCACHE_TIMEOUT', $this->cache_config[$cache_name]['timeout']);
					define('MEMCACHE_DEBUG', $this->cache_config[$cache_name]['debug']);
					
					$object = pc_base::load_sys_class('cache_memcache');
					break;
				case 'apc' :
					$object = pc_base::load_sys_class('cache_apc');
					break;
				default :
					$object = pc_base::load_sys_class('cache_file');
			}
		} else {
			$object = pc_base::load_sys_class('cache_file');
		}
		return $object;
	}

}
?>