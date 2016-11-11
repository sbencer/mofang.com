<?php
define('PAGE_SIZE', 500); // 分頁大小

// 類型映射為360的分類
$typeTo360Map = array(
    81 => 20075,
    82 => 20073,
    83 => 20056,
    101 => 20074,
    102 => 20073,
    103 => 20056,
    122 => 20053,
    125 => 20054,
    126 => 20055,
);

$db = pc_base::load_model('content_model');
$db->set_model(1); // 文章模型

$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
$page < 1 && $page = 1;

$psize = PAGE_SIZE;
$offset = ($page-1) * $psize;

$startTime = microtime(true);

// 參數中的type會影響接口的行為
$order = '';
if (isset($_GET['type'])) {
    switch ($_GET['type']) {
    case 'delta' : // 影響排序
        $order = 'id DESC';
        break;
    default :
        http_response_code(404);
        exit;
    }
}

// 查詢news
$where = 'catid IN('.implode(',', array_keys($typeTo360Map)).') AND status=99';
$list = $db->select($where, 'id,catid,title,thumb,keywords,description,url,username,inputtime,shortname', "{$offset},{$psize}", $order, '', 'id');

if ($list) {
    // 查詢news_data
    $db->table_name = $db->table_name.'_data';
    $where = 'id IN('.implode(',', array_keys($list)).')';
    $listExt = $db->select($where, 'id,content', '', '', '', 'id');
}

IS_DEBUG && header('Query-Time: '.(microtime(true)-$startTime));

// XML Format
$xml = new MXMLWriter();
$xml->openUri('php://output');
//$xml->openMemory();
$xml->setIndent(true);

$xml->startDocument('1.0', 'UTF-8');
$xml->startElement('document');

$xml->startElement('header');
$xml->writeElement('version', 0.1);
$xml->writeElement('website', 'www.mofang.com');
$xml->writeElement('op', 'add');
$xml->endElement(); // header

foreach ($list as $id => $row) {
    $xml->startElement('item');
    $xml->writeElement('typeid1', 20046);
    $xml->writeElement('typeid2', $typeTo360Map[$row['catid']]);
    $xml->writeElementCData('title', $row['title']);
    $xml->writeElementCData('stitle', $row['shortname']);
    $xml->writeElementCData('keywords', $row['keywords']);
    $xml->writeElementCData('writer', $row['username']);
    $xml->writeElementCData('source', '魔方網');
    $xml->writeElementCData('thumb', $row['thumb']);
    $xml->writeElementCData('url', $row['url']);
    $xml->writeElementCData('description', $row['description']);
    $xml->writeElementCData('content', $listExt[$row['id']]['content']);
    $xml->writeElement('language', '國內');
    $xml->writeElement('addtime', $row['inputtime']);
    $xml->endElement(); // item
}

$xml->endElement(); // document
$xml->endDocument();
