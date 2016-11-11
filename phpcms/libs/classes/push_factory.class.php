<?php
/**
 *  push_factory.class.php 推送信息工廠類
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-8-2
 */

final class push_factory {
	
	/**
	 *  推送信息工廠類靜態實例
	 */
	private static $push_factory;
	
	/**
	 * 接口實例化列表
	 */
	protected $api_list = array();
	
	/**
	 * 返回當前終級類對象的實例
	 * @return object
	 */
	public static function get_instance() {
		if(push_factory::$push_factory == '') {
			push_factory::$push_factory = new push_factory();
		}
		return push_factory::$push_factory;
	}
	
	/**
	 * 獲取api操作實例
	 * @param string $classname 接口調用的類文件名
	 * @param sting  $module	 模塊名
	 * @return object	 
	 */
	public function get_api($module = 'admin') {
		if(!isset($this->api_list[$module]) || !is_object($this->api_list[$module])) {
			$this->api_list[$module] = pc_base::load_app_class('push_api', $module);
		}
		return $this->api_list[$module];
	}
}