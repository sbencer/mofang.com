<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-type: text/xml; charset=UTF-8');

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

$psize = 500;
$offset = ($page-1) * 500;

// 查詢news
$where = 'catid IN('.implode(',', array_keys($typeTo360Map)).') AND status=99';
$list = $db->select($where, 'id,catid,title,thumb,keywords,description,url,username,inputtime,shortname', "{$offset},{$psize}", '', '', 'id');

// 查詢news_data


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
    $xml->writeElementCData('source', '');
    $xml->writeElementCData('writer', $row['username']);
    $xml->writeElementCData('thumb', $row['thumb']);
    $xml->writeElementCData('url', $row['url']);
    $xml->writeElementCData('description', $row['description']);
    $xml->writeElementCData('content', 'content');
    $xml->writeElementCData('language', '國內');
    $xml->writeElementCData('addtime', $row['inputtime']);
    $xml->endElement(); // item
}

$xml->endElement(); // document
$xml->endDocument();

class MXMLWriter extends XMLWriter
{
    public function writeElementCData($element, $value)
    {
        $this->startElement($element);
        $this->writeCData($value);
        $this->endElement();
    }
}
