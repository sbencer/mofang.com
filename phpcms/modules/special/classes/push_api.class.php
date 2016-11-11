<?php
/**
 * push_api.class.php 專題推送接口類
 * 
 */
defined('IN_PHPCMS') or exit('No permission resources.');

class push_api {
	private $special_api;
	
	public function __construct() {
		$this->special_api = pc_base::load_app_class('special_api', 'special');
	}
	
	/**
	 * 信息推薦至專題接口
	 * @param array $param 屬性 請求時，為模型、欄目數組。 例：array('modelid'=>1, 'catid'=>12); 提交添加為二維信息數據 。例：array(1=>array('title'=>'多發發送方法', ....))
	 * @param array $arr 參數 表單數據，只在請求添加時傳遞。
	 * @return 返回專題的下拉列表 
	 */
	public function _push_special($param = array(), $arr = array()) {
		return $this->special_api->_get_special($param, $arr);
	}
	
	public function _get_type($specialid) {
		return $this->special_api->_get_type($specialid);
	}
}
?>