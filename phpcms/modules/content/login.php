<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型緩存路徑
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
pc_base::load_sys_class('form', '', 0);
class login {

    function __construct() {
    }
    public function init() {
        $SEO['title'] = '魔方網用戶登錄';
        $SEO['keyword'] = '魔方網,禮包,獨家禮包';
        $SEO['description'] = '魔方網提供最專業的遊戲新聞資訊，定時發放熱門獨家禮包';

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $smarty->assign("SEO",$SEO);
        
        if ( is_mobile() || is_wap() || $_GET['wap']) {
            $smarty->display('wap_tw/login.tpl');
        }
    }
}
