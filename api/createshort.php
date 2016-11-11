<?php
/**
 * 创建短连接接口
 * 参数类型：GET
 * 参数列表：
 * url 原始url
 * cid 类型id
 * 返回值：
 * json格式
 */
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('shorturlService', 'admin', 0);
//pc_base::load_app_class('shorturlDefine', 'admin', 0);

// 可以有两种方式来访问
if (isset($_POST['json'])) {
    $p = json_decode(stripslashes($_POST['json']), true);
} else {
    $p = $_POST;
}

if (!isset($p['url']) || !isset($p['cid']) || !isset($p['web']) || !is_numeric($p['web']) || $p['web'] < 1 || count($p['url']) != count($p['cid'])) {
    exit(json_encode(array(
        'code' => 9001,
        'message' => L('params_error'),
        'data' => array(),
    )));
}

$url = $p['url'];
$cid = $p['cid'];
$web = $p['web'];

if (empty($url) || empty($cid)) {
    exit(json_encode(array(
        'code' => 9002,
        'message' => L('params_error'),
        'data' => array(),
    )));
}
$shorturlService = new shorturlService();
$shortUrl = array();
foreach ($url as $index => $one) {
    $shortUrl[$one] = MCDomain::SHORT_LINK . '/' . $shorturlService->add($one, $cid[$index], $web);
}
// todo 这里可以优化成把所有的sql都取出来，一次执行，而不是每次执行一个
if ($shortUrl) {
    exit(json_encode(array(
        'code' => 0,
        'message' => 'success',
        'data' => array(
            'shorturl' => $shortUrl,
        ),
    )));
}