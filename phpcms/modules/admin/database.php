<?php
@set_time_limit(0);
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class database extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->userid = $_SESSION['userid'];
		pc_base::load_sys_class('db_factory');
		pc_base::load_sys_class('form');
		pc_base::load_sys_func('dir');	
	}
	/**
	 * 數據庫導出
	 */
	public function export() {
		$database = pc_base::load_config('database');
		$dosubmit = isset($_POST['dosubmit']) ? $_POST['dosubmit'] : $_GET['dosubmit'];
		if($dosubmit) {
			if($_GET['pdo_select']=='' && $_POST['pdo_select'] =='') showmessage(L('select_pdo'));
			$tables = $_POST['tables'] ? $_POST['tables'] : $_GET['tables'];
			$sqlcharset = $_POST['sqlcharset'] ? $_POST['sqlcharset'] :$_GET['sqlcharset'];
			$sqlcompat = $_POST['sqlcompat'] ? $_POST['sqlcompat'] : $_GET['sqlcompat'];
			$sizelimit = $_POST['sizelimit'] ? $_POST['sizelimit'] : $_GET['sizelimit'];
			$fileid = $_POST['fileid'] ? $_POST['fileid'] : trim($_GET['fileid']);
			$random = $_POST['random'] ? $_POST['random'] : trim($_GET['random']);
			$tableid = $_POST['tableid'] ? $_POST['tableid'] : trim($_GET['tableid']);
			$startfrom = $_POST['startfrom'] ? $_POST['startfrom'] : trim($_GET['startfrom']);
			$tabletype = $_POST['tabletype'] ? $_POST['tabletype'] : trim($_GET['tabletype']);
			$this->pdo_name = $_POST['pdo_select'] ? $_POST['pdo_select'] : trim($_GET['pdo_select']);			
			$this->db = db_factory::get_instance($database)->get_database($this->pdo_name);
			$r = $this->db->version();
			$this->export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$action,$fileid,$random,$tableid,$startfrom,$tabletype);
		} else {
			foreach($database as $name=>$value) {
				$pdos[$name] = $value['database'].'['.$value['hostname'].']';
			}
			if($_GET['pdoname']) {
				delcache('bakup_tables','commons');
				$pdo_name = trim($_GET['pdoname']);
				$r = array();
				$db = db_factory::get_instance($database)->get_database($pdo_name);
				$tbl_show = $db->query("SHOW TABLE STATUS FROM `".$database[$pdo_name]['database']."`");
				while(($rs = $db->fetch_next()) != false) {
					$r[] = $rs;
				}
				$infos = $this->status($r,$database[$pdo_name]['tablepre']);
				$db->free_result($tbl_show);
			}
			include $this->admin_tpl('database_export');			
		}
	}
	
	/**
	 * 數據庫導入
	 */
	public function import() {
		$database = pc_base::load_config('database');
		if($_GET['dosubmit']) {
			$admin_founders = explode(',',pc_base::load_config('system','admin_founders'));
			if(!in_array($this->userid,$admin_founders)) {
				showmessage(L('only_fonder_operation'));
			}			
			$this->pdo_name = $_GET['pdoname'];
			$pre = trim($_GET['pre']);
			$this->fileid = trim($_GET['fileid']);
			$this->db_charset = $database[$this->pdo_name]['charset'];
			$this->db_tablepre = $database[$pdo_name]['tablepre'];
			$this->db = db_factory::get_instance($database)->get_database($this->pdo_name);
			$this->import_database($pre);
		} else {
			$$pdos = $others = array();
			foreach($database as $name=>$value) {
				$pdos[$name] = $value['database'].'['.$value['hostname'].']';
			}
			$pdoname = $_GET['pdoname'] ? $_GET['pdoname'] : key($pdos);
			$sqlfiles = glob(CACHE_PATH.'bakup/'.$pdoname.'/*.sql');
			if(is_array($sqlfiles)) {
				asort($sqlfiles);
				$prepre = '';
				$info = $infos = $other = $others = array();
				foreach($sqlfiles as $id=>$sqlfile) {
					if(preg_match("/(phpcmstables_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i",basename($sqlfile),$num)) {
						$info['filename'] = basename($sqlfile);
						$info['filesize'] = round(filesize($sqlfile)/(1024*1024), 2);
						$info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
						$info['pre'] = $num[1];
						$info['number'] = $num[2];
						if(!$id) $prebgcolor = '#CFEFFF';
						if($info['pre'] == $prepre) {
						 $info['bgcolor'] = $prebgcolor;
						} else {
						 $info['bgcolor'] = $prebgcolor == '#CFEFFF' ? '#F1F3F5' : '#CFEFFF';
						}
						$prebgcolor = $info['bgcolor'];
						$prepre = $info['pre'];
						$infos[] = $info;
					} else {
						$other['filename'] = basename($sqlfile);
						$other['filesize'] = round(filesize($sqlfile)/(1024*1024),2);
						$other['maketime'] = date('Y-m-d H:i:s',filemtime($sqlfile));
						$others[] = $other;
					}
				}
			}
			$show_validator = true;
			include $this->admin_tpl('database_import');
		}
	}
	
	/**
	 * 備份文件下載
	 */
	public function public_down() {
		$admin_founders = explode(',',pc_base::load_config('system','admin_founders'));
		if(!in_array($this->userid,$admin_founders)) {
			showmessage(L('only_fonder_operation'));
		}	
		$datadir = $_GET['pdoname'];
		$filename = $_GET['filename'];
		$fileext = fileext($filename);
		if($fileext != 'sql') {
			showmessage(L('only_sql_down'));
		}
		file_down(CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$datadir.DIRECTORY_SEPARATOR.$filename);
	}
	
	/**
	 * 數據庫修復、優化
	 */
	public function public_repair() {
		$database = pc_base::load_config('database');
		$tables = $_POST['tables'] ? $_POST['tables'] : trim($_GET['tables']);
		$operation = trim($_GET['operation']);
		$pdo_name = trim($_GET['pdo_name']);
		$this->db = db_factory::get_instance($database)->get_database($pdo_name);
		$tables = is_array($tables) ? implode(',',$tables) : $tables;
		if($tables && in_array($operation,array('repair','optimize'))) {
			$this->db->query("$operation TABLE $tables");
			showmessage(L('operation_success'),'?m=admin&c=database&a=export&pdoname='.$pdo_name);
		} elseif ($tables && $operation == 'showcreat') {						
			$this->db->query("SHOW CREATE TABLE $tables");
			$structure = $this->db->fetch_next();
			$structure = $structure['Create Table'];
			$show_header = true;
			include $this->admin_tpl('database_structure');					
		} else {
			showmessage(L('select_tbl'),'?m=admin&c=database&a=export&pdoname='.$pdo_name);
		}
	}
	
	/**
	 * 備份文件刪除
	 */
	public function delete() {
		$filenames = $_POST['filenames'];
		$pdo_name = $_GET['pdoname'];
		$bakfile_path = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$pdo_name.DIRECTORY_SEPARATOR;
		if($filenames) {
			if(is_array($filenames)) {
				foreach($filenames as $filename) {
					if(fileext($filename)=='sql') {
						@unlink($bakfile_path.$filename);
					}
				}
				showmessage(L('operation_success'),'?m=admin&c=database&a=import&pdoname='.$pdo_name);
			} else {
				if(fileext($filenames)=='sql') {
					@unlink($bakfile_path.$filename);
					showmessage(L('operation_success'),'?m=admin&c=database&a=import&pdoname='.$pdo_name);
				}
			}
		} else {
			showmessage(L('select_delfile'));	
		}				
	}
	/**
	 * 獲取數據表
	 * @param unknown_type 數據表數組
	 * @param unknown_type 表前綴
	 */
	private function status($tables,$tablepre) {
		$phpcms = array();
		$other = array();
		foreach($tables as $table) {
			$name = $table['Name'];
			$row = array('name'=>$name,'rows'=>$table['Rows'],'size'=>$table['Data_length']+$row['Index_length'],'engine'=>$table['Engine'],'data_free'=>$table['Data_free'],'collation'=>$table['Collation']);
			if(strpos($name, $tablepre) === 0) {
				$phpcms[] = $row;
			} else {
				$other[] = $row;
			}				
		}
		return array('phpcmstables'=>$phpcms, 'othertables'=>$other);
	}
	
	/**
	 * 數據庫導出方法
	 * @param unknown_type $tables 數據表數據組
	 * @param unknown_type $sqlcompat 數據庫兼容類型
	 * @param unknown_type $sqlcharset 數據庫字符
	 * @param unknown_type $sizelimit 卷大小
	 * @param unknown_type $action 操作
	 * @param unknown_type $fileid 卷標
	 * @param unknown_type $random 隨機字段
	 * @param unknown_type $tableid 
	 * @param unknown_type $startfrom 
	 * @param unknown_type $tabletype 備份數據庫類型 （非phpcms數據與phpcms數據）
	 */
	private function export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$action,$fileid,$random,$tableid,$startfrom,$tabletype) {
		$dumpcharset = $sqlcharset ? $sqlcharset : str_replace('-', '', CHARSET);

		$fileid = ($fileid != '') ? $fileid : 1;		
		if($fileid==1 && $tables) {
			if(!isset($tables) || !is_array($tables)) showmessage(L('select_tbl'));
			$random = mt_rand(1000, 9999);
			setcache('bakup_tables',$tables,'commons');
		} else {
			if(!$tables = getcache('bakup_tables','commons')) showmessage(L('select_tbl'));
		}
		if($this->db->version() > '4.1'){
			if($sqlcharset) {
				$this->db->query("SET NAMES '".$sqlcharset."';\n\n");
			}
			if($sqlcompat == 'MYSQL40') {
				$this->db->query("SET SQL_MODE='MYSQL40'");
			} elseif($sqlcompat == 'MYSQL41') {
				$this->db->query("SET SQL_MODE=''");
			}
		}
		
		$tabledump = '';

		$tableid = ($tableid!= '') ? $tableid - 1 : 0;
		$startfrom = ($startfrom != '') ? intval($startfrom) : 0;
		for($i = $tableid; $i < count($tables) && strlen($tabledump) < $sizelimit * 1000; $i++) {
			global $startrow;
			$offset = 100;
			if(!$startfrom) {
				if($tables[$i]!=DB_PRE.'session') {
					$tabledump .= "DROP TABLE IF EXISTS `$tables[$i]`;\n";
				}
				$createtable = $this->db->query("SHOW CREATE TABLE `$tables[$i]` ");
				$create = $this->db->fetch_next();
				$tabledump .= $create['Create Table'].";\n\n";
				$this->db->free_result($createtable);
							
				if($sqlcompat == 'MYSQL41' && $this->db->version() < '4.1') {
					$tabledump = preg_replace("/TYPE\=([a-zA-Z0-9]+)/", "ENGINE=\\1 DEFAULT CHARSET=".$dumpcharset, $tabledump);
				}
				if($this->db->version() > '4.1' && $sqlcharset) {
					$tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=[a-zA-Z0-9]+/", "DEFAULT CHARSET=".$sqlcharset, $tabledump);
				}
				if($tables[$i]==DB_PRE.'session') {
					$tabledump = str_replace("CREATE TABLE `".DB_PRE."session`", "CREATE TABLE IF NOT EXISTS `".DB_PRE."session`", $tabledump);
				}
			}

			$numrows = $offset;
			while(strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
				if($tables[$i]==DB_PRE.'session' || $tables[$i]==DB_PRE.'member_cache') break;
				$sql = "SELECT * FROM `$tables[$i]` LIMIT $startfrom, $offset";
				$numfields = $this->db->num_fields($sql);
				$numrows = $this->db->num_rows($sql);
				$fields_name = $this->db->get_fields($tables[$i]);
				$rows = $this->db->query($sql);
				$name = array_keys($fields_name);
				$r = array();
				while ($row = $this->db->fetch_next()) {
					$r[] = $row;
					$comma = "";
					$tabledump .= "INSERT INTO `$tables[$i]` VALUES(";
					for($j = 0; $j < $numfields; $j++) {
						$tabledump .= $comma."'".mysql_escape_string($row[$name[$j]])."'";
						$comma = ",";
					}
					$tabledump .= ");\n";
				}
				$this->db->free_result($rows);
				$startfrom += $offset;
				
			}
			$tabledump .= "\n";
			$startrow = $startfrom;
			$startfrom = 0;
		}
		if(trim($tabledump)) {
			$tabledump = "# phpcms bakfile\n# version:PHPCMS V9\n# time:".date('Y-m-d H:i:s')."\n# type:phpcms\n# phpcms:http://www.phpcms.cn\n# --------------------------------------------------------\n\n\n".$tabledump;
			$tableid = $i;
			$filename = $tabletype.'_'.date('Ymd').'_'.$random.'_'.$fileid.'.sql';
			$altid = $fileid;
			$fileid++;
			$bakfile_path = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name;
			if(!dir_create($bakfile_path)) {
				showmessage(L('dir_not_be_created'));
			}
			$bakfile = $bakfile_path.DIRECTORY_SEPARATOR.$filename;
			if(!is_writable(CACHE_PATH.'bakup')) showmessage(L('dir_not_be_created'));
			file_put_contents($bakfile, $tabledump);
			@chmod($bakfile, 0777);
			if(!EXECUTION_SQL) $filename = L('bundling').$altid.'#';
			showmessage(L('bakup_file')." $filename ".L('bakup_write_succ'), '?m=admin&c=database&a=export&sizelimit='.$sizelimit.'&sqlcompat='.$sqlcompat.'&sqlcharset='.$sqlcharset.'&tableid='.$tableid.'&fileid='.$fileid.'&startfrom='.$startrow.'&random='.$random.'&dosubmit=1&tabletype='.$tabletype.'&allow='.$allow.'&pdo_select='.$this->pdo_name);
		} else {
		   $bakfile_path = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name.DIRECTORY_SEPARATOR;
		   file_put_contents($bakfile_path.'index.html','');
		   delcache('bakup_tables','commons');
		   showmessage(L('bakup_succ'),'?m=admin&c=database&a=import&pdoname='.$this->pdo_name);
		}
	}
	/**
	 * 數據庫恢復
	 * @param unknown_type $filename
	 */
	private function import_database($filename) {
		if($filename && fileext($filename)=='sql') {
			$filepath = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name.DIRECTORY_SEPARATOR.$filename;
			if(!file_exists($filepath)) showmessage(L('database_sorry')." $filepath ".L('database_not_exist'));
			$sql = file_get_contents($filepath);
			sql_execute($sql);
			showmessage("$filename ".L('data_have_load_to_database'));
		} else {
			$fileid = $this->fileid ? $this->fileid : 1;
			$pre = $filename;
			$filename = $filename.$fileid.'.sql';
			$filepath = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.$this->pdo_name.DIRECTORY_SEPARATOR.$filename;
			if(file_exists($filepath)) {
				$sql = file_get_contents($filepath);
				$this->sql_execute($sql);
				$fileid++;
				showmessage(L('bakup_data_file')." $filename ".L('load_success'),"?m=admin&c=database&a=import&pdoname=".$this->pdo_name."&pre=".$pre."&fileid=".$fileid."&dosubmit=1");
			} else {
				showmessage(L('data_recover_succ'),'?m=admin&c=database&a=import');
			}
		}
	}
	
	/**
	 * 執行SQL
	 * @param unknown_type $sql
	 */
 	private function sql_execute($sql) {
	    $sqls = $this->sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->db->query($sql);
				}
			}
		} else {
			$this->db->query($sqls);
		}
		return true;
	}
	

 	private function sql_split($sql) {
		if($this->db->version() > '4.1' && $this->db_charset) {
			$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$this->db_charset,$sql);
		}
		if($this->db_tablepre != "phpcms_") $sql = str_replace("`phpcms_", '`'.$this->db_tablepre, $sql);
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}			
}
?>