<?php
/**
 * 給奇虎360的內容聚合接口
 *
 * @date 2014-07-03
 */

defined('IN_PHPCMS') or exit('No permission resources.'); 

define('IS_DEBUG', isset($_GET['debug']) && $_GET['debug']); // 是否開啟調試模式

header('Content-type: text/xml; charset=UTF-8');

require 'qihu/MXMLWriter.php';

// 允許的操作
$allowActs = array(
    'news', 'video',
);

$act = '';
if (!isset($_GET['act']) || !in_array($act = $_GET['act'], $allowActs)) {
    http_response_code(404);
    exit;
}

require 'qihu/'.$act.'.php';
