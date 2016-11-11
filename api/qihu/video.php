<?php
define('PAGE_SIZE', 500); // 分頁大小

$db = pc_base::load_model('content_model');
$db->set_model(11); // 視頻模型

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

// 查詢video
$where = 'status=99 AND gameid<>\'\'';
$list = $db->select($where, 'id,title,thumb,keywords,description,url,username,gameid,inputtime', "{$offset},{$psize}", $order, '', 'id');

// 分類獲取gameId
$gameIds = array();
foreach ($list as &$row) {
    // 縮略圖大小
    if ($row['thumb'] != '') {
        $row['thumb'] .= '?imageView2/0/w/168/h/140';
    }

    $tmp = explode('-', trim($row['gameid'], ' |'));
    if (count($tmp) < 2 || !in_array($tmp[0], array('20', '21'))) {
        continue;
    }
    if (false !== ($pos = strpos($tmp[1], '|'))) {
        $tmp[1] = substr($tmp[1], 0, $pos);
    }
    $row['_model'] = $tmp[0];
    $row['_gameid'] = $tmp[1];
    $gameIds[$tmp[0]][$tmp[1]] = $tmp[1];
}

// 獲取game name
$games = array();
foreach ($gameIds as $model => $ids) {
    $db->set_model($model);
    $where = 'id IN('.implode(',', $ids).')';
    $games[$model] = $db->select($where, 'id,title', '', '', '', 'id');
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
$xml->writeElement('update', date('Y-m-d'));
$xml->endElement(); // header

foreach ($list as $id => $row) {
    if (!isset($row['_model'], $games[$row['_model']][$row['_gameid']])) {
        continue;
    }

    $xml->startElement('item');
    $xml->writeElementCData('vname', $row['title']);
    $xml->writeElementCData('gname', $games[$row['_model']][$row['_gameid']]['title']);
    $xml->writeElement('gchannel', 20048);
    $xml->writeElementCData('vurl', $row['url']);
    $xml->writeElementCData('thumb', $row['thumb']);
    $xml->writeElementCData('tag', str_replace(array('，', ','), ' ', $row['keywords']));
    $xml->writeElementCData('author', $row['username']);
    $xml->writeElementCData('from', '魔方網');
    $xml->writeElementCData('vdes', $row['description']);
    //$xml->writeElement('addtime', $row['inputtime']);
    $xml->endElement(); // item
}

$xml->endElement(); // document
$xml->endDocument();
