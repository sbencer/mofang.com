<?php 
	
	/**
	 * 模板風格列表
	 * @param integer $siteid 站點ID，獲取單個站點可使用的模板風格列表
	 * @param integer $disable 是否顯示停用的{1:是,0:否}
	 */
	function template_list($siteid = '', $disable = 0) {
        $tpl_root = pc_base::load_config('system', 'tpl_root');
		$list = glob(PC_PATH.$tpl_root.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);
		$arr = $template = array();
		if ($siteid) {
			$site = pc_base::load_app_class('sites','admin');
			$info = $site->get_by_id($siteid);
			if($info['template']) $template = explode(',', $info['template']);
		}
		foreach ($list as $key=>$v) {
			$dirname = basename($v);
			//if ($siteid && !in_array($dirname, $template)) continue; // 主站欄目模板不再需要後臺指定，默認展示所有模板
			if (file_exists($v.DIRECTORY_SEPARATOR.'config.php')) {
				$arr[$key] = include $v.DIRECTORY_SEPARATOR.'config.php';
				if (!$disable && isset($arr[$key]['disable']) && $arr[$key]['disable'] == 1) {
					unset($arr[$key]);
					continue;
				}
			} else {
				$arr[$key]['name'] = $dirname;
			}
			$arr[$key]['dirname']=$dirname;
		}
		return $arr;
	}
	/**
	 * 設置config文件
	 * @param $config 配屬信息
	 * @param $filename 要配置的文件名稱
	 */
	function set_config($config, $filename="system") {
		$configfile = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.$filename.'.php';
		if(!is_writable($configfile)) showmessage('Please chmod '.$configfile.' to 0777 !');
		$pattern = $replacement = array();
		foreach($config as $k=>$v) {
			if(in_array($k,array('js_path','css_path','img_path','attachment_stat','admin_log','gzip','errorlog','phpsso','phpsso_appid','phpsso_api_url','phpsso_auth_key','phpsso_version','connect_enable', 'upload_url','sina_akey', 'sina_skey', 'snda_enable', 'snda_status', 'snda_akey', 'snda_skey', 'qq_akey', 'qq_skey','qq_appid','qq_appkey','qq_callback','admin_url'))) {
				$v = trim($v);
				$configs[$k] = $v;
				$pattern[$k] = "/'".$k."'\s*=>\s*([']?)[^']*([']?)(\s*),/is";
	        	$replacement[$k] = "'".$k."' => \${1}".$v."\${2}\${3},";					
			}
		}
		$str = file_get_contents($configfile);
		$str = preg_replace($pattern, $replacement, $str);
		return pc_base::load_config('system','lock_ex') ? file_put_contents($configfile, $str, LOCK_EX) : file_put_contents($configfile, $str);		
	}
	
	/**
	 * 獲取系統信息
	 */
	function get_sysinfo() {
		$sys_info['os']             = PHP_OS;
		$sys_info['zlib']           = function_exists('gzclose');//zlib
		$sys_info['safe_mode']      = (boolean) ini_get('safe_mode');//safe_mode = Off
		$sys_info['safe_mode_gid']  = (boolean) ini_get('safe_mode_gid');//safe_mode_gid = Off
		$sys_info['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : L('no_setting');
		$sys_info['socket']         = function_exists('fsockopen') ;
		$sys_info['web_server']     = strpos($_SERVER['SERVER_SOFTWARE'], 'PHP')===false ? $_SERVER['SERVER_SOFTWARE'].'PHP/'.phpversion() : $_SERVER['SERVER_SOFTWARE'];
		$sys_info['phpv']           = phpversion();	
		$sys_info['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
		return $sys_info;
	}

	/**
	 * 檢查目錄可寫性
	 * @param $dir 目錄路徑
	 */
	function dir_writeable($dir) {
		$writeable = 0;
		if(is_dir($dir)) {  
	        if($fp = @fopen("$dir/chkdir.test", 'w')) {
	            @fclose($fp);      
	            @unlink("$dir/chkdir.test"); 
	            $writeable = 1;
	        } else {
	            $writeable = 0; 
	        } 
		}
		return $writeable;
	}
	
	/**
	 * 返回錯誤日志大小，單位MB
	 */
	function errorlog_size() {
		$logfile = CACHE_PATH.'error_log.php';
		if(file_exists($logfile)) {
			return $logsize = pc_base::load_config('system','errorlog') ? round(filesize($logfile) / 1048576 * 100) / 100 : 0;
		} 
		return 0;
	}

?>
