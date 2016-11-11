<?php
/**
 * 魔方API 入口文件 
 */ 

define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php';
$param = pc_base::load_sys_class('param');  

//安全过滤
$action = safe_replace($_GET['action']);
$op = safe_replace($_GET['op']);
$file = safe_replace($_GET['file']);
$action = remove_xss($action);
$op = remove_xss($op);
$file = remove_xss($file);

if(!$action || !$op || !$file){
	exit('Operation can not be empty');
}

if (!preg_match('/([^a-z_]+)/i',$op) && file_exists(PHPCMS_PATH.'api/'.$op.'/'.$file.'.php')) {
	include PHPCMS_PATH.'api/'.$op.'/'.$file.'.php';
} else {
	exit('API handler does not exist');
}





