<?php
/**
 * 短连接
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_class('shorturlService', 'admin', 0);
pc_base::load_app_class('shorturlDefine', 'admin', 0);
pc_base::load_app_func('adclass');

class shorturl extends admin {
    /**
     *
     */
    function __construct() {
        $this->db = pc_base::load_model('shorturl_model');
        $this->shorturlauto = pc_base::load_model('shorturlauto_model');
        parent::__construct();
    }

    /**
     * 列表页
     */
    public function shortUrlList() {
        $page = max(intval($_GET['page']), 1);
        $infos = $this->db->listinfo('', '`id` DESC', $page, 15);
        $allClassData = getAllAdData();
        foreach ($allClassData as $val) {
            $simpleClassData[$val['id']] = $val['name'];
        }
        foreach ($infos as $index => $one) {
            $infos[$index]['cname'] = $simpleClassData[$one['cid']];
        }
        include $this->admin_tpl('shorturl_list');
    }

    /**
     * 添加
     */
    public function shortUrlAdd() {
        if (!empty($_POST)) {

            $url = empty($_POST['url']) ? '' : trim($_POST['url']);
            if (empty($url) || !isset($_POST['cid']) || !is_numeric($_POST['cid']) || $_POST['cid'] < 0) {
                showmessage(L('operation_failure'));
            }
            $shorturlService = new shorturlService();
            $shortUrl = $shorturlService->add($url, $_POST['cid'], $_POST['web']);
            if ($shortUrl) {
                showmessage(L('operation_success'), '', '', '');
            }
        } else {
            pc_base::load_sys_class('form');
            // $show_header = $show_validator = true;
            // 获取所有的
            $allClass = getAllAdData();
            $formatAllClass = getAllClass($allClass);

            include $this->admin_tpl('shorturl_add');
        }
    }

    /**
     * 删除 短连接
     */
    public function shortUrlDelete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] <= 0) {
            exit("参数不正确");
        }
        $id = $_GET['id'];
        $shorturlService = new shorturlService();

        if ($shorturlService->shorturlDelete($id)) {
            showmessage(L('operation_success'), '?m=admin&c=shorturl&a=shortUrlList', '', '');
        } else {
            showmessage(L('operation_fail'), 'goback', '', '');
        }

    }
}