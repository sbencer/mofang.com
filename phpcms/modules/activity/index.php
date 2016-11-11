<?php 
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global', 'activity');
error_reporting(0);
class index {
	
    private $db;
	
    function __construct() {
        $this->db = pc_base::load_model('activity_model');
        $this->_cached_action = array('init');

        $this->_disable_cache = intval($_GET['disablecached']);
        $this->_refresh_cache = intval($_GET['refreshcached']);
        $this->_ob_started = 0;
        $this->_cached = 0;

        // 前端調試
        if (isset($_SERVER['HTTP_DISABLE_CACHE'])){
            $this->_disable_cache = 1;
        }

        if ( !$this->_disable_cache && in_array(ROUTE_A, $this->_cached_action) ) {
            $base_url = get_url();
            $getvars = $_GET;
            unset($getvars['refreshcached']);
            unset($getvars['disablecached']);
            ksort($getvars);
            $base_url = $_SERVER['HTTP_HOST'] . ROUTE_A . json_encode($getvars);
            $this->_cache_key = sha1($base_url);
            if (is_mobile()) {
                $this->_cache_key .= '_m';
            }
            if ($_GET['format'] == 'json') {
                $this->_cache_key .= '_j';
            }
            if ( !$this->_refresh_cache && ($html = getcache($this->_cache_key, '', 'memcache', 'html')) ) {
                header('Cached: 1');
                $this->_cached = 1;
                echo $html;
                exit;
            }
        }
        $this->_ob_started = 1;
        ob_start();
	}

    function __destruct() {
        if ($this->_ob_started) {
            $html = ob_get_contents();
        }
        if ( !$this->_cached && !$this->_disable_cache && in_array(ROUTE_A, $this->_cached_action) ) {
            setcache($this->_cache_key, $html, '', 'memcache', 'html', 1800);
            delcache($this->_cache_lock_key, '', 'memcache', 'html');
        }
        if ($this->_ob_started) {
            ob_end_clean();
        }
        echo $html;
    }


    /**
     * event 活動模板加載方法
     */
    function init() {
        $activity_name = trim($_GET['activity_name']);
        $page_name = trim($_GET['page_name']);
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();

        $result = $this->db->select(array('domain_dir'=>$activity_name, 'page_name'=>$page_name),'*');
        if($result) extract($result[0]);

        // SEO信息
        $setting = string2array($setting);
        $SEO['title'] = $setting['meta_title'];
        $SEO['keyword'] = $setting['meta_keywords'];
        $SEO['description'] = $setting['meta_description'];
        // 背景圖
        $roulette_bg = $bg_pic; 
        $bg_imgs = string2array($render_pics);
        foreach($bg_imgs as $key=>$val){
            $tmp_arr = getimagesize($val['url']);
            $bg_imgs[$key]['width'] = $tmp_arr[0];
        }

        // 主體區域高度
        $bg_pic = getimagesize($bg_pic);
        $height = $bg_pic[1];

        $float_win = string2array($float_win);
        $weixin = string2array($weixin);
        $roulette = string2array($roulette);

        // 這裡的變量是一個數組對象
        $tem_arr = json_decode($map_setting) ? : array();
        // 處理a鏈接
        if ($tem_arr->a) {
            foreach($tem_arr->a as $key=>$val){
                $new_map_setting['a'][$key]['link'] = $val->link;
                $new_map_setting['a'][$key]['target'] = $val->target;
                $new_map_setting['a'][$key]['left'] = $val->left;
                $new_map_setting['a'][$key]['top'] = $val->top;
                $new_map_setting['a'][$key]['width'] = $val->width;
                $new_map_setting['a'][$key]['height'] = $val->height;
            }
        }
        // 處理flash視頻播放器
        if ($tem_arr->video) {
            foreach ($tem_arr->video as $key=>$val) {
                $new_map_setting['video'][$key]['link'] = $val->link;
                $new_map_setting['video'][$key]['target'] = $val->target;
                $new_map_setting['video'][$key]['left'] = $val->left;
                $new_map_setting['video'][$key]['top'] = $val->top;
                $new_map_setting['video'][$key]['width'] = $val->width;
                $new_map_setting['video'][$key]['height'] = $val->height;
            }
        }

        $smarty->assign("SEO",$SEO);
        $smarty->assign("height",$height);
        $smarty->assign("is_use_ad",$is_use_ad);
        $smarty->assign("is_use_footer",$is_use_footer);
        $smarty->assign("activity_name",$activity_name);
        $smarty->assign("bg_imgs",$bg_imgs);
        $smarty->assign("roulette_bg",$roulette_bg);
        $smarty->assign("float_win",$float_win);
        $smarty->assign("map_setting",$new_map_setting);
        $smarty->assign("weixin",$weixin);
        $smarty->assign("roulette",$roulette);
        $smarty->assign("staticstics_code",$staticstics_code);
    
        if ($roulette['type'] == 0) {
            $page_name = $page_name == 'index' ? 'index' : '00';
            $smarty->display('tongyong_event/'.$page_name.'.tpl');
        } else {
            $page_name = $roulette['type'] == 1 ? 'lp8' : 'lp14';
            $smarty->display('m_tw_zhuanpan_tpl/'.$page_name.'.tpl');
        }
    }
}
?>
