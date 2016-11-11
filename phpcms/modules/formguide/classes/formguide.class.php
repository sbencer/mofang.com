<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型原型存儲路徑
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'formguide'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
//模型緩存路徑
define('CACHE_MODEL_PATH',PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
/**
 * 更新form表單模型類
 * @author 
 *
 */
class formguide {

	public function __construct() {
		
	}
	
	/**
	 * 更新模型緩存方法
	 */
	public function public_cache() {
		require MODEL_PATH.'fields.inc.php';
		//更新內容模型類：表單生成、入庫、更新、輸出
		$classtypes = array('form','input','update','output');
		foreach($classtypes as $classtype) {
			$cache_data = file_get_contents(MODEL_PATH.'formguide_'.$classtype.'.class.php');
			$cache_data = str_replace('}?>','',$cache_data);
			foreach($fields as $field=>$fieldvalue) {
				if(file_exists(MODEL_PATH.$field.DIRECTORY_SEPARATOR.$classtype.'.inc.php')) {
					$cache_data .= file_get_contents(MODEL_PATH.$field.DIRECTORY_SEPARATOR.$classtype.'.inc.php');
				}
			}
			$cache_data .= "\r\n } \r\n?>";
			file_put_contents(CACHE_MODEL_PATH.'formguide_'.$classtype.'.class.php',$cache_data);
			@chmod(CACHE_MODEL_PATH.'formguide_'.$classtype.'.class.php',0777);
		}
		return true;
	}
}
?>