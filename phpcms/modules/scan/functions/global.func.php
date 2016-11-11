<?php
/**
 * 文件掃描
 * @param $filepath     目錄
 * @param $subdir       是否搜索子目錄
 * @param $ex           搜索擴展
 * @param $isdir        是否只搜索目錄
 * @param $md5			是否生成MD5驗證碼
 * @param $enforcement  強制更新緩存
 */
function scan_file_lists($filepath, $subdir = 1, $ex = '', $isdir = 0, $md5 = 0, $enforcement = 0) {
	static $file_list = array();
	if ($enforcement) $file_list = array();
	$flags = $isdir ? GLOB_ONLYDIR : 0;
	$list = glob($filepath.'*'.(!empty($ex) && empty($subdir) ? '.'.$ex : ''), $flags);
	if (!empty($ex)) $ex_num = strlen($ex);
	foreach ($list as $k=>$v) {
		$v1 = str_replace(PHPCMS_PATH, '', $v);
		if ($subdir && is_dir($v)) {
			scan_file_lists($v.DIRECTORY_SEPARATOR, $subdir, $ex, $isdir, $md5);
			continue;
		} 
		if (!empty($ex) && strtolower(substr($v, -$ex_num, $ex_num)) == $ex) {
			if ($md5) {
				$file_list[$v1] = md5_file($v);
			} else {
				$file_list[] = $v1;
			}
			continue;
		} elseif (!empty($ex) && strtolower(substr($v, -$ex_num, $ex_num)) != $ex) {
			unset($list[$k]);
			continue;
		}
	}
	return $file_list;
}

function new_htmlentities($string) {
	$encoding = 'utf-8';
	if(strtolower(CHARSET)=='gbk') $encoding = 'gb2312';
	return htmlentities($string,ENT_COMPAT,$encoding);
}