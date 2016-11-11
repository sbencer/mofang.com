<?php
class import_test {
	/**
	 * 通用數據轉換程序
	 * 
	 * @param $timestamp
	 * @param $showtime
	 */
	 var $con;
	 /*
	 *	測試數據庫連接
 	 */
	public static function testdb($dbtype, $dbhost, $dbuser, $dbpw, $dbname) {
			global $con;
   			$db_conf = array();
			$db_conf['import_array'] = array();
			$db_conf['import_array']['type']= $dbtype;
			$db_conf['import_array']['hostname']= $dbhost;
			$db_conf['import_array']['username']= $dbuser;
			$db_conf['import_array']['password']= $dbpw;
			$db_conf['import_array']['database']= $dbname;
			//$db_conf['import_array']['charset']= $import_info[dbcharset];
			//返回一個當前配置所需要的數據庫連接  
			pc_base::load_sys_class('db_factory');
			$thisdb = db_factory::get_instance($db_conf)->get_database('import_array');
			$link = $thisdb->connect();
	 		if($link){
	 			return 'OK';
	 		}else {
	 			return 'false';
	 		}
		 
	}
}
?>