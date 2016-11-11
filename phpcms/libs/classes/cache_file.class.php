<?php

class cache_file {
	
	/*緩存默認配置*/
	protected $_setting = array(
								'suf' => '.cache.php',	/*緩存文件後綴*/
								'type' => 'array',		/*緩存格式：array數組，serialize序列化，null字符串*/
							);
	
	/*緩存路徑*/
	protected $filepath = '';

	/**
	 * 構造函數
	 * @param	array	$setting	緩存配置
	 * @return  void
	 */
	public function __construct($setting = '') {
		$this->get_setting($setting);
	}
	
	/**
	 * 寫入緩存
	 * @param	string	$name		緩存名稱
	 * @param	mixed	$data		緩存數據
	 * @param	array	$setting	緩存配置
	 * @param	string	$type		緩存類型
	 * @param	string	$module		所屬模型
	 * @return  mixed				緩存路徑/false
	 */

	public function set($name, $data, $setting = '', $type = 'data', $module = ROUTE_M) {
		$this->get_setting($setting);
		if(empty($type)) $type = 'data';
		if(empty($module)) $module = ROUTE_M;
		$filepath = CACHE_PATH.'caches_'.$module.'/caches_'.$type.'/';
		$filename = $name.$this->_setting['suf'];
	    if(!is_dir($filepath)) {
			mkdir($filepath, 0777, true);
	    }
	    
	    if($this->_setting['type'] == 'array') {
	    	$data = "<?php\nreturn ".var_export($data, true).";\n?>";
	    } elseif($this->_setting['type'] == 'serialize') {
	    	$data = serialize($data);
	    }
	    if ($module == 'commons' || ($module == 'commons' && substr($name, 0, 16) != 'category_content')) {
		    $db = pc_base::load_model('cache_model');
		    $datas = new_addslashes($data);
		    if ($db->get_one(array('filename'=>$filename, 'path'=>'caches_'.$module.'/caches_'.$type.'/'), '`filename`')) {
		    	$db->update(array('data'=>$datas), array('filename'=>$filename, 'path'=>'caches_'.$module.'/caches_'.$type.'/'));
		    } else {
		    	$db->insert(array('filename'=>$filename, 'path'=>'caches_'.$module.'/caches_'.$type.'/', 'data'=>$datas));
		    }
	    }
	    
	    //是否開啟互斥鎖
		if(pc_base::load_config('system', 'lock_ex')) {
			$file_size = file_put_contents($filepath.$filename, $data, LOCK_EX);
		} else {
			$file_size = file_put_contents($filepath.$filename, $data);
		}
	    
	    return $file_size ? $file_size : 'false';
	}
	
	/**
	 * 獲取緩存
	 * @param	string	$name		緩存名稱
	 * @param	array	$setting	緩存配置
	 * @param	string	$type		緩存類型
	 * @param	string	$module		所屬模型
	 * @return  mixed	$data		緩存數據
	 */
	public function get($name, $setting = '', $type = 'data', $module = ROUTE_M) {
		$this->get_setting($setting);
		if(empty($type)) $type = 'data';
		if(empty($module)) $module = ROUTE_M;
		$filepath = CACHE_PATH.'caches_'.$module.'/caches_'.$type.'/';
		$filename = $name.$this->_setting['suf'];
		if (!file_exists($filepath.$filename)) {
			return false;
		} else {
		    if($this->_setting['type'] == 'array') {
		    	$data = @require($filepath.$filename);
		    } elseif($this->_setting['type'] == 'serialize') {
		    	$data = unserialize(file_get_contents($filepath.$filename));
		    }
		    
		    return $data;
		}
	}
	
	/**
	 * 刪除緩存
	 * @param	string	$name		緩存名稱
	 * @param	array	$setting	緩存配置
	 * @param	string	$type		緩存類型
	 * @param	string	$module		所屬模型
	 * @return  bool
	 */
	public function delete($name, $setting = '', $type = 'data', $module = ROUTE_M) {
		$this->get_setting($setting);
		if(empty($type)) $type = 'data';
		if(empty($module)) $module = ROUTE_M;	
		$filepath = CACHE_PATH.'caches_'.$module.'/caches_'.$type.'/';
		$filename = $name.$this->_setting['suf'];
		if(file_exists($filepath.$filename)) {
			if ($module == 'commons' && substr($name, 0, 16) != 'category_content') {
				$db = pc_base::load_model('cache_model');
		    	$db->delete(array('filename'=>$filename, 'path'=>'caches_'.$module.'/caches_'.$type.'/'));
			}
			return @unlink($filepath.$filename) ? true : false;
		} else {
			return false;
		}
	}
	
	/**
	 * 和系統緩存配置對比獲取自定義緩存配置
	 * @param	array	$setting	自定義緩存配置
	 * @return  array	$setting	緩存配置
	 */
	public function get_setting($setting = '') {
		if($setting) {
			$this->_setting = array_merge($this->_setting, $setting);
		}
	}

	public function cacheinfo($name, $setting = '', $type = 'data', $module = ROUTE_M) {
		$this->get_setting($setting);
		if(empty($type)) $type = 'data';
		if(empty($module)) $module = ROUTE_M;
		$filepath = CACHE_PATH.'caches_'.$module.'/caches_'.$type.'/';
		$filename = $filepath.$name.$this->_setting['suf'];
		
		if(file_exists($filename)) {
			$res['filename'] = $name.$this->_setting['suf'];
			$res['filepath'] = $filepath;
			$res['filectime'] = filectime($filename);
			$res['filemtime'] = filemtime($filename);
			$res['filesize'] = filesize($filename);
			return $res;
		} else {
			return false;
		}
	}

}

?>
