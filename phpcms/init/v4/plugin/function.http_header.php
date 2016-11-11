<?php
/**
 *           File:  compiler.setheader.php
 *         Author:  shen zhou(shenzhou1982@gmail.com)
 *       Modifier:  shen zhou(shenzhou1982@gmail.com)
 *       Modified:  2011-10-26 15:14:52
 *    Description: 設置httpresponse的頭部
 *    參數：
 *          type:設置返回類型，默認是html，其它類型為：html/json/javascript/xml/js
 *              其中js=javascript；
 *          charset:設置編碼：默認是utf-8編碼
 *      Copyright:  (c) 2011-2021 baidu.inc
 * @example
 *      {%http_header type="json" charset="utf-8"%}
 * @param $params
 * @param $smarty
 */

function smarty_function_http_header($params, &$smarty) {
    $DEFAULT_MIME = 'html';
    $DEFAULT_CHARSET = 'utf-8';
    $type = (empty($params['type'])) ? $DEFAULT_MIME : $params['type'];
    $charset = (empty($params['charset'])) ? $DEFAULT_CHARSET : $params['charset']; //UTF-8 ? GBK
    $mimeTypes = array(
        'html' => 'text/html',
        'json' => 'application/json',
        'javascript' => 'application/x-javascript',
        'js' => 'application/x-javascript',
        'xml' => 'text/xml',
        'stream' => 'application/octet-stream'
    );
    if (array_key_exists($type, $mimeTypes)) {
        $mime = $mimeTypes[$type];
    } else {
        $mime = "text/plain";
    }
    header("Content-Type:$mime; charset=$charset;");
}


