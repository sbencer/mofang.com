<?php
/**
 *  application.class.php PHPCMS應用程序創建類
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-7
 */
class application {
	
	/**
	 * 構造函數
	 */
	public function __construct() {
		$param = pc_base::load_sys_class('param');

		//增加對index.html規則的處理，遇到此類域名就表示這是個新聞欄目，重新指定
		if(defined("NEWS_NAME")){
			$catname = NEWS_NAME;
        	//讀欄目memcache緩存,沒有再查數據庫
        	$array = getcache("cms_categorydir_".$catname, '', 'memcache', 'html');
        	if(!$array || empty($array)){
        		$category_db = pc_base::load_model('category_model');
        		$array = $category_db->get_one(array('catdir'=>$catname));
				setcache("cms_categorydir_".$catname, $array, '', 'memcache', 'html', 1800);
        	}
        	if(empty($array)){
        		//欄目裡沒有這個目錄，繼續查詢是否是專區的英文標識
        		$partition_array = getcache("cms_partitiondir_".$catname, '', 'memcache', 'html');
        		if(!$partition_array || empty($partition_array)){
        			$partition_db = pc_base::load_model('partition_model');
        			$partition_array = $partition_db->get_one(array("domain_dir"=>$catname),"catid,domain_dir");
					setcache("cms_partitiondir_".$catname, $array, '', 'memcache', 'html', 1800);
        		}
        		
        		if(!empty($partition_array)){
        			define('ROUTE_M', "partition");
					define('ROUTE_C', "index");
					define('ROUTE_A', "init");
					$_GET['p'] = $catname;//專區的英文標注
        		}else{
        			//既不是欄目DIR，也不是專區的英文標識，說明此英文字符無意義，返回404！
        			header("HTTP/1.1 404 Not Found");
	            	exit();
        		}
        	}elseif($array['catid']!=''){
        		//有CATID，說明是主站欄目，獲取CATID，其它走正常的流程
        		$_GET['catid'] = $array['catid'];
        		define('ROUTE_M', $param->route_m());
				define('ROUTE_C', $param->route_c());
				define('ROUTE_A', $param->route_a());
        	}
		}else{
			/*
			* 如果沒有定義NEWS_NAME常量，還走正常的MVC流程。
			* 其中有一種情況比如現在處於第2頁，需要判斷當前欄目的首頁，是不是應該是/index.html的形式
			*/
			define('ROUTE_M', $param->route_m());
			define('ROUTE_C', $param->route_c());
			define('ROUTE_A', $param->route_a());
		}
		$this->init();
	}
	
	/**
	 * 調用件事
	 */
	private function init() {
		$controller = $this->load_controller();
		if (method_exists($controller, ROUTE_A)) {
			if (preg_match('/^[_]/i', ROUTE_A)) {
                header('HTTP/1.1 404');
				exit('You are visiting the action is to protect the private action');
			} else {
				call_user_func(array($controller, ROUTE_A));
			}
		} else {
            header('HTTP/1.1 404');
			exit('Action does not exist.');
		}
	}
	
	/**
	 * 加載控制器
	 * @param string $filename
	 * @param string $m
	 * @return obj
	 */
	private function load_controller($filename = '', $m = '') {
		if (empty($filename)) $filename = ROUTE_C;
		if (empty($m)) $m = ROUTE_M;
		$filepath = PC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.$filename.'.php';
		if (file_exists($filepath)) {
			$classname = $filename;
			include $filepath;
			if ($mypath = pc_base::my_path($filepath)) {
				$classname = 'MY_'.$filename;
				include $mypath;
			}
			if(class_exists($classname)){
				return new $classname;
			}else{
                header('HTTP/1.1 404');
				exit('Controller does not exist.');
 			}
		} else {
            header('HTTP/1.1 404');
			exit('Controller does not exist.');
		}
	}
}
