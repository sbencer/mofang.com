<?php

/* 請定義模板目錄宏 MFE_SMARTY_TEMPLATES!! */

// MFE_LOCAL : 本地調試服務器
// MFE_TEMPLATES_BASE :smarty 模板路徑


if(!defined('MFE_LOCAL') && !defined('MFE_SMARTY_TEMPLATES')){
    throw new Exception("MFE_SMARTY_TEMPLATES not defined");
    exit();
}

// 插件目錄
defined("MFE_BASE_PATH") || DEFINE('MFE_BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
// 模板目錄 mfe工具 v4 fis本地調試使用 /templates/v4/
defined("MFE_LOCAL") || DEFINE('MFE_SMARTY_TEMPLATES', MFE_BASE_PATH."templates".DIRECTORY_SEPARATOR."v4".DIRECTORY_SEPARATOR);
// 是否啟啟用模板調試
defined("MFE_SMERT_DEBUG") || define("MFE_SMART_DEBUG",0);

require_once (MFE_BASE_PATH."smarty".DIRECTORY_SEPARATOR."Smarty.class.php");
$smarty = new Smarty();
$smarty->setConfigDir(MFE_BASE_PATH."config");
$smarty->setCacheDir(MFE_BASE_PATH."cache");
$smarty->setCompileDir(PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR."templates_c".DIRECTORY_SEPARATOR."v4");
$smarty->addPluginsDir(MFE_BASE_PATH."plugin");
$smarty->setLeftDelimiter("{");
$smarty->setRightDelimiter("}");

$smarty->setTemplateDir(MFE_SMARTY_TEMPLATES);
$smarty->addConfigDir(MFE_SMARTY_TEMPLATES."fis_config");
$smarty->php_handling = SMARTY_PHP_ALLOW ;
$smarty->debugging_ctrl = 'URL';
//$smarty->force_compile = true;

function test_data($params,&$smarty) {
    $c1 = $params['c1'];
    $c2 = $params['c2'];
    $c3 = $params['c3'];
    $r = array();
    if (isset($c3)) {
        for ($i = 0; $i < $c3; $i++) {
            $r[$i] = test_data(array(
                "c1"=>$c1,
                "c2"=>$c2
            ));
        }
    }else if(isset($c2)) {
        for ($i = 0; $i < $c2; $i++) {
            $r[$i] = test_data(array(
                "c1"=>$c1
            ));
        }
    }else{
        for ($i = 0; $i < $c1; $i++) {
            $r[$i] = array();
        }
    }
    if (isset($smarty)) {
        $smarty->assign("data",$r);
        return "";
    }else{
        return $r;
    }
}
$smarty->registerPlugin('function','test_data', test_data);

