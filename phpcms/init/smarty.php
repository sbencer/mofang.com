<?php

/*
 * require(PC_PATH."init/smarty.php");
 * mfe_version(3);
 * $smarty->display("index.tpl");
 */

// 是否使用smarty調試模式
define("MFE_SMART_DEBUG",0);

function mfe_version($n){
    // phpcms/templates/$n/
    define('MFE_SMARTY_TEMPLATES',
        dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.
        "templates".DIRECTORY_SEPARATOR."v$n".DIRECTORY_SEPARATOR);
    require(PC_PATH."init/v$n/smarty.php");
    return $smarty;
}

/*
 * 調用v3模版
 * @deprecated
 */
function use_v3(){
    return mfe_version(3);
}
/*
 * 調用v4模版
 * @deprecated
 */
function use_v4(){
    return mfe_version(4);
}
