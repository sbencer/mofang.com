<?php
/**
 * 設置系統常量
 * Jozh Liu
 */
$domain = str_ireplace( '.mofang.com', '', $_SERVER['HTTP_HOST'] );
if ( strpos($domain, 'test') ) {
    define('SITE_URL','http://zc.test.mofang.com/yii/mfapp/');
} else {
    define('SITE_URL','http://www.mofang.com/mfapp/');
}
define('CSS_PATH', SITE_URL.'assets/css/');
define('IMG_PATH', SITE_URL.'assets/img/');
define('JS_PATH', SITE_URL.'assets/js/');
define('PLUGINS_PATH', SITE_URL.'assets/plugins/');
