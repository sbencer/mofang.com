<?php
defined('IN_PHPCMS') or exit('No permission resources.');

//定義在後台
define('IN_ADMIN',true);
class plugin_op {
	private $db,$db_var;
	public function __construct(){
		$this->db_var = pc_base::load_model('plugin_var_model');
		$this->db = pc_base::load_model('plugin_var_model');
	}
	/**
	 * 插件後台模板加載
	 */	
	public function plugin_tpl($file,$identification) {
		return PC_PATH.'plugin'.DIRECTORY_SEPARATOR.$identification.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
	}
	
	/**
	 * 獲取插件自定義變量信息
	 * @param  $pluginid 插件id
	 */
	public function getpluginvar($pluginid){
		if(empty($pluginid)) return flase;
		if($info_var = $this->db_var->select(array('pluginid'=>$pluginid))) {
			foreach ($info_var as $var) {
				$pluginvar[$var['fieldname']] = $var['value'];
			}
		}
		return 	$pluginvar;	
	}
	
	/**
	 * 獲取插件配置
	 * @param  $pluginid 插件id
	 */
	function getplugincfg($pluginid) {
		$info = $this->db->get_one(array('pluginid'=>$pluginid));
		return $info;
	}
}
?>