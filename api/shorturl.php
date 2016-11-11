<?php
/**
 * 根据传入的短连接，进行统计，然后跳转
 * 参数类型：
 * GET
 * 参数列表：
 * url
 * 返回值：
 * void 无
 */

defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('shorturlService', 'admin', 0);

$url = !isset($_GET['url']) ? '' : trim($_GET['url']);
if ($url == "") {
    exit(json_encode(array(
        'code' => 9002,
        'message' => L('params_error'),
        'data' => array(),
    )));
}

$shorturlService = new shorturlService();
$shortUrl = $shorturlService->jump($url);
