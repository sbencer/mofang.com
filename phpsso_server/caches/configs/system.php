<?php
return array(
//網站路徑
'web_path' => '/www/phpsso_server/',
//Session配置
'session_storage' => 'mysql',
'session_ttl' => 1800,
'session_savepath' => CACHE_PATH.'sessions/',
'session_n' => 0,

//Cookie配置
'cookie_domain' => '', //Cookie 作用域
'cookie_path' => '/', //Cookie 作用路徑
'cookie_pre' => 'pbzsx_', //Cookie 前綴，同一域名下安裝多套系統時，請修改Cookie前綴
'cookie_ttl' => 0, //Cookie 生命周期，0 表示隨瀏覽器進程

'js_path' => 'http://test.mofang.com/www/phpsso_server/statics/js/', //CDN JS
'css_path' => 'http://test.mofang.com/www/phpsso_server/statics/css/', //CDN CSS
'img_path' => 'http://test.mofang.com/www/phpsso_server/statics/images/', //CDN img
'upload_path' => PHPCMS_PATH.'uploadfile/', //上傳文件路徑
'app_path' => 'http://test.mofang.com/www/phpsso_server/',//動態域名配置地址

'charset' => 'utf-8', //網站字符集
'timezone' => 'Etc/GMT-8', //網站時區（只對php 5.1以上版本有效），Etc/GMT-8 實際表示的是 GMT+8
'debug' => 1, //是否顯示調試信息
'admin_log' => 0, //是否記錄後台操作日志
'errorlog' => 0, //是否保存錯誤日志
'gzip' => 1, //是否Gzip壓縮後輸出
'auth_key' => 'XotbK8ytUkXhwO2NwE91', // //Cookie密鑰
'lang' => 'zh-cn',  //網站語言包
'admin_founders' => '1', //網站創始人ID，多個ID逗號分隔
'execution_sql' => 0, //EXECUTION_SQL
//UCenter配置開始
'ucuse'=>'1',//是否開啟UC
'uc_api'=>'http://test.mofang.com/bbs/uc_server',//Ucenter api 地址
'uc_ip'=>'127.0.0.1',//Ucenter api IP
'uc_dbhost'=>'localhost',//Ucenter 數據庫主機名
'uc_dbuser'=>'mofang_test',//Ucenter 數據庫用戶名
'uc_dbpw'=>'mofang_test',//Ucenter 數據庫密碼
'uc_dbname'=>'mofang_test',//Ucenter 數據庫名
'uc_dbtablepre'=>'`mofang_test`.bbs_ucenter_',//Ucenter 數據庫表前綴
'uc_dbcharset'=>'utf8',//Ucenter 數據庫字符集
'uc_appid'=>'2',//應用id(APP ID)
'uc_key'=>'hrBwuvGVbY33',//Ucenter 通信密鑰
);
?>