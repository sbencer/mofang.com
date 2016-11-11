<?php

/**
 * 推荐位的  类别   此类别用于 统计点击量
 *
 */
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_app_func('adclass');

class adclass extends admin {
    function __construct() {
        $this->db = pc_base::load_model('adclass_model');
        parent::__construct();
    }

    /**
     * 首页那个
     */
    function init() {
        // 找出来所有的数据
        // $result = $this->db->select($where = '', $data = '*', $limit = '');
        $show_dialog = true;
        //$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=adclass&a=add\', title:\'' . L('adclass_add') . '\', width:\'500\', height:\'360\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('adclass_add'));
        $key = "allAdData_adclass_init";
        if(!($allClass = getcache($key, '', 'memcache', 'html'))){
            $sql = 'select a.id,a.name,a.pid,b.name as parentname from phpcms_adclass a left join phpcms_adclass b on a.pid=b.id';
            $this->db->query($sql);
            $allClass = $this->db->fetch_array();
            if ($allClass) {
                setcache($key, $allClass, '', 'memcache', 'html', 2400);
            }
        }
        $formatAllClass = getAllClass($allClass);
        include $this->admin_tpl('adclass_list');
    }



    /**
     * 编辑一个分类
     */
    public function edit() {

        if (isset($_POST['dosubmit'])) {
            $id = $_POST['id'];
            if (!is_numeric($id) || $id < 0) {
                showmessage(L('operation_failure'));
            }
            $name = empty($_POST['name']) ? '' : trim($_POST['name']);

            if (empty($name) || !isset($_POST['pid']) || !is_numeric($_POST['pid']) || $_POST['pid'] < 0) {
                showmessage(L('operation_failure'));
            }
            $post = array(
                'name' => $name,
                'pid' => $_POST['pid'],
            );
            $rows = $this->db->update($post, 'id=' . $id);
            if ($rows) {
                showmessage(L('operation_success'), '', '', 'add');
            }
        } else {
            $id = $_GET['id'];
            if (!is_numeric($id) || $id < 0) {
                showmessage(L('operation_failure'));
            }
            pc_base::load_sys_class('form');
            $show_header = $show_validator = true;
            // 获取能有子类的，因为这里基本都是二级，所以这里就只获取了pid=0的 可以扩展
            $topClass = $this->db->select($where = 'pid=0', $data = '*', $limit = '');
            $oneClass = $this->db->get_one('id=' . $id);
            include $this->admin_tpl('adclass_edit');
        }
    }
    /**
     * 推薦位添加
     */
    public function add() {
        if (isset($_POST['dosubmit'])) {
            $name = empty($_POST['name']) ? '' : trim($_POST['name']);

            if (empty($name) || !isset($_POST['pid']) || !is_numeric($_POST['pid']) || $_POST['pid'] < 0) {
                showmessage(L('operation_failure'));
            }
            $post = array(
                'name' => $name,
                'pid' => $_POST['pid']
            );
            $insert_id = $this->db->insert($post, true);
            if ($insert_id) {
                showmessage(L('operation_success'), '/index.php?m=admin&c=adclass&a=init&menuid=1730', '3000');
            }
        } else {

            pc_base::load_sys_class('form');
//            $this->sitemodel_db = pc_base::load_model('sitemodel_model');
//            $sitemodel = $sitemodel = array();
//            $sitemodel = getcache('model', 'commons');
//            foreach ($sitemodel as $value) {
//                if ($value['siteid'] == get_siteid()) $modelinfo[$value['modelid']] = $value['name'];
//            }
           // $show_header = $show_validator = true;
            // 获取能有子类的，因为这里基本都是二级，所以这里就只获取了pid=0的 可以扩展
            $key = "adclass_add_topClass";
            if(!($topClass = getcache($key, '', 'memcache', 'html'))){
                $topClass = $this->db->select($where = 'pid=0', $data = '*', $limit = '');
                if ($topClass) {
                    setcache($key, $topClass, '', 'memcache', 'html', 2400);
                }
            }
            include $this->admin_tpl('adclass_add');

        }

    }
}
