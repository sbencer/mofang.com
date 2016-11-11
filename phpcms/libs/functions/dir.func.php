<?php 
/**
* 轉化 \ 為 /
* 
* @param	string	$path	路徑
* @return	string	路徑
*/
function dir_path($path) {
	$path = str_replace('\\', '/', $path);
	if(substr($path, -1) != '/') $path = $path.'/';
	return $path;
}
/**
* 創建目錄
* 
* @param	string	$path	路徑
* @param	string	$mode	屬性
* @return	string	如果已經存在則返回true，否則為flase
*/
function dir_create($path, $mode = 0777) {
	if(is_dir($path)) return TRUE;
	$ftp_enable = 0;
	$path = dir_path($path);
	$temp = explode('/', $path);
	$cur_dir = '';
	$max = count($temp) - 1;
	for($i=0; $i<$max; $i++) {
		$cur_dir .= $temp[$i].'/';
		if (@is_dir($cur_dir)) continue;
		@mkdir($cur_dir, 0777,true);
		@chmod($cur_dir, 0777);
	}
	return is_dir($path);
}
/**
* 拷貝目錄及下面所有文件
* 
* @param	string	$fromdir	原路徑
* @param	string	$todir		目標路徑
* @return	string	如果目標路徑不存在則返回false，否則為true
*/
function dir_copy($fromdir, $todir) {
	$fromdir = dir_path($fromdir);
	$todir = dir_path($todir);
	if (!is_dir($fromdir)) return FALSE;
	if (!is_dir($todir)) dir_create($todir);
	$list = glob($fromdir.'*');
	if (!empty($list)) {
		foreach($list as $v) {
			$path = $todir.basename($v);
			if(is_dir($v)) {
				dir_copy($v, $path);
			} else {
				copy($v, $path);
				@chmod($path, 0777);
			}
		}
	}
    return TRUE;
}
/**
* 轉換目錄下面的所有文件編碼格式
* 
* @param	string	$in_charset		原字符集
* @param	string	$out_charset	目標字符集
* @param	string	$dir			目錄地址
* @param	string	$fileexts		轉換的文件格式
* @return	string	如果原字符集和目標字符集相同則返回false，否則為true
*/
function dir_iconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
	if($in_charset == $out_charset) return false;
	$list = dir_list($dir);
	foreach($list as $v) {
		if (pathinfo($v, PATHINFO_EXTENSION) == $fileexts && is_file($v)){
			file_put_contents($v, iconv($in_charset, $out_charset, file_get_contents($v)));
		}
	}
	return true;
}
/**
* 列出目錄下所有文件
* 
* @param	string	$path		路徑
* @param	string	$exts		擴展名
* @param	array	$list		增加的文件列表
* @return	array	所有滿足條件的文件
*/
function dir_list($path, $exts = '', $list= array()) {
	$path = dir_path($path);
	$files = glob($path.'*');
	foreach($files as $v) {
		if (!$exts || pathinfo($v, PATHINFO_EXTENSION) == $exts) {
			$list[] = $v;
			if (is_dir($v)) {
				$list = dir_list($v, $exts, $list);
			}
		}
	}
	return $list;
}
/**
* 設置目錄下面的所有文件的訪問和修改時間
* 
* @param	string	$path		路徑
* @param	int		$mtime		修改時間
* @param	int		$atime		訪問時間
* @return	array	不是目錄時返回false，否則返回 true
*/
function dir_touch($path, $mtime = TIME, $atime = TIME) {
	if (!is_dir($path)) return false;
	$path = dir_path($path);
	if (!is_dir($path)) touch($path, $mtime, $atime);
	$files = glob($path.'*');
	foreach($files as $v) {
		is_dir($v) ? dir_touch($v, $mtime, $atime) : touch($v, $mtime, $atime);
	}
	return true;
}
/**
* 目錄列表
* 
* @param	string	$dir		路徑
* @param	int		$parentid	父id
* @param	array	$dirs		傳入的目錄
* @return	array	返回目錄列表
*/
function dir_tree($dir, $parentid = 0, $dirs = array()) {
	global $id;
	if ($parentid == 0) $id = 0;
	$list = glob($dir.'*');
	foreach($list as $v) {
		if (is_dir($v)) {
            $id++;
			$dirs[$id] = array('id'=>$id,'parentid'=>$parentid, 'name'=>basename($v), 'dir'=>$v.'/');
			$dirs = dir_tree($v.'/', $id, $dirs);
		}
	}
	return $dirs;
}

/**
* 刪除目錄及目錄下面的所有文件
* 
* @param	string	$dir		路徑
* @return	bool	如果成功則返回 TRUE，失敗則返回 FALSE
*/
function dir_delete($dir) {
	$dir = dir_path($dir);
	if (!is_dir($dir)) return FALSE;
	$list = glob($dir.'*');
	foreach($list as $v) {
		is_dir($v) ? dir_delete($v) : @unlink($v);
	}
    return @rmdir($dir);
}

?>