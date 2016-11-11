<?php
/**
 *  index.php PHPCMS 入口
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */
 //PHPCMS根目录

define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include PHPCMS_PATH.'/phpcms/base.php';

require 'vendor/autoload.php';

//页面展示方式获取 移动/桌面
// 客户端检测类实例化
$detect = new Mobile_Detect;

$wap = 0;

if($_GET['pc'] == 1) {
    setcookie('pc', md5(time()), time()+3600*24*100, '/'); 
    $_COOKIE['pc'] = 1;
} elseif($_GET['wap'] == 1) {
    setcookie('pc', '', time()-3600*24*100, '/');   
    $wap = 1;
}

if(!$_COOKIE['pc'] && $detect->isMobile()) { 
    $wap = 1;
}

define('WAP', $wap);

pc_base::creat_app();

?>
