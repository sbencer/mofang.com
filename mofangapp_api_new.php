<?php
/**
 * 魔方游戏宝 - APP 接口入口文件 
 */
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php';
$param = pc_base::load_sys_class('param');

$action = $_SERVER['REQUEST_URI'];
$a = explode('?', $action);
$b = explode('/', $a[0]);
$b_num = count($b);
$true_action = $b[$b_num-2];


if (!preg_match('/([^a-z_]+)/i',$true_action) && file_exists(PHPCMS_PATH.'api/mofangapp_api/'.$true_action.'.php')) {
    include PHPCMS_PATH.'api/mofangapp_api/'.$true_action.'.php';
} else {
    exit('mofangapp action does not exist');
}
?>
