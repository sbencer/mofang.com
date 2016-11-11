<?php
/**
 *  index.php PHPCMS 入口
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */
file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'debug.php') && require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'debug.php');

//PHPCMS根目錄
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);


$domain = str_ireplace( '.mofang.com', '', $_SERVER['HTTP_HOST'] );

//判斷URL是否為http://www.mofang.com/news/這樣的目錄結構
/*
$REQUEST_URI = getRequestUri();  
$array = explode("/", $REQUEST_URI); 
$url_count = count($array);

if($url_count==3){
  if($array[2]==''){
    if($array[1]!='kaice' && $array[1]!='tx'){
      define('NEWS_NAME', $array[1]);
    }
  }elseif($_GET['disablecached']!=''||$_GET['ptest']==1|| $_GET['refreshcached']!=''){
      define('NEWS_NAME', $array[1]);
  }
}
*/

include PHPCMS_PATH.'/phpcms/base.php';
pc_base::creat_app(); 
#phpinfo();
/**準確的在各種環境下獲得重寫的url**/
function getRequestUri(){
  if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { 
     // check this first so IIS will catch 
     $requestUri = $_SERVER['HTTP_X_REWRITE_URL']; 
   } elseif (isset($_SERVER['REDIRECT_URL'])) { 
     // Check if using mod_rewrite 
     $requestUri = $_SERVER['REDIRECT_URL']; 
   } elseif (isset($_SERVER['REQUEST_URI'])) { 
     $requestUri = $_SERVER['REQUEST_URI']; 
   } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { 
     // IIS 5.0, PHP as CGI 
     $requestUri = $_SERVER['ORIG_PATH_INFO']; 
     if (!empty($_SERVER['QUERY_STRING'])) { 
       $requestUri .= '?' . $_SERVER['QUERY_STRING']; 
     } 
   } 
   return $requestUri; 
}
?>
