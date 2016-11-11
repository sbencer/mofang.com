<?php
/* 電信 */
function pageVisitCount(){
     $count= "als_ctcc_downnum.txt";
     $num= @file_get_contents($count);
     if ($fp= fopen($count,"w+")){
         flock($fp,LOCK_EX);
         $num++;
         fwrite($fp,$num);
         flock($fp,LOCK_UN);
     }
     return $num;
}
pageVisitCount();
if (preg_match('/\sMicroMessenger\//', $_SERVER['HTTP_USER_AGENT'])) {
     echo '<!DOCTYPE html>
 <html lang="zh-CN">
 <head>
     <meta charset="UTF-8">
     <title>魔方遊戲助手產品下載</title>
     <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
     <meta content="yes" name="apple-mobile-web-app-capable" />
     <meta name="format-detection" content="telephone=no" />
 </head>
 <body>
 <h3>微信用戶如遇無法下載情況，請點擊右上角，選擇在“瀏覽器中打開”後下載。</h3>
 </body>
 </html>';
     //header("Location: {$default_url['weiyun']}");
} else {
    header('Location:http://attach.mofang.com/爆爆愛麗絲公測版_電信_v1.0.0.apk');
}

