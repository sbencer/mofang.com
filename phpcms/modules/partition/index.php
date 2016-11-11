<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型緩存路徑
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','partition');
pc_base::load_sys_class('form', '', 0);
class index {
	private $db;

	function __construct() {

        //model
		$this->db_content = pc_base::load_model('content_model');
		$this->db_partition = pc_base::load_model('partition_model');
		$this->db_partition_game = pc_base::load_model('partition_games_model');
        $this->db_search = pc_base::load_model('search_model');
        //專區模版測試目錄
        $this->is_ptest = $_GET['ptest'] ? $_GET['ptest'] : 0 ;
        if($this->is_ptest==1){
            $this->ptest_dir = 's_test';
        }else{
            $this->ptest_dir = 's';
        }

        //用戶信息
		$this->_userid = param::get_cookie('_userid');
		$this->_username = param::get_cookie('_username');

        //緩存參數
        //$this->_cached_action = array('init', 'lists', 'show', 'card_list', 'card_detail');
        $this->_cached_action = array('init', 'lists', 'show');
        $this->_disable_cache = intval($_GET['disablecached']);
        $this->_refresh_cache = intval($_GET['refreshcached']);
        $this->_ob_started = 0;
        $this->_cached = 0;

        //專區浮窗
        $this->partition_setting = getcache('partition','commons');
        $this->floating_url = "http://www.mofang.com.tw/index.php?m=partition&c=index&a=floating&p=".$_GET['p'];

        // 前端調試
        if (isset($_SERVER['HTTP_DISABLE_CACHE'])){
            $this->_disable_cache = 1;
        }

        //內嵌訪問
        $this->_embed = isset($_GET['embed']) ? 1 : 0;

		$partition_info = $this->db_partition->get_one("`domain_dir`='".$_GET['p']."'");

        //專區名
        $GLOBALS['part_name'] = $partition_info['catname'];
        $GLOBALS['part_id'] = $partition_info['catid'];
        $GLOBALS['part_dir'] = $this->domain_dir = $partition_info['domain_dir'];

        //需增加按listorder排序處理
        $tem_setting = string2array($partition_info['setting']);

        //关联BBS的ID
        $GLOBALS['bbs_id'] = $partition_info['bbs_id'];
        $GLOBALS['is_newbbs'] = $tem_setting['is_newbbs'];

        //新專區模板
        $this->is_general_template = $tem_setting['is_general_template'];
        $this->is_mobile_template = $tem_setting['is_mobile_template'];
        $this->is_new_template = $tem_setting['template_type'];
        
        foreach($tem_setting as $key => $val) {
            $GLOBALS[$key] = $val;   
        }

        if(!$tem_setting['is_go_up']){
            $GLOBALS['is_go_up'] = 0;
        }else{
            $GLOBALS['is_go_up'] = 1;
        }
        if($tem_setting['module_setting']){
            $module_setting = keysort($tem_setting['module_setting'],'listorder');

            // 以type為鍵，便於前台調用
            foreach($tem_setting['module_setting'] as $val) {
                $tmp[$val['type']] = $val;    
            }
            $GLOBALS['module_setting_type'] = $tmp;
        }

        if($_GET['test']=='yes'){
           var_dump($GLOBALS['module_setting']);
        }
        //導航
        if( is_array($GLOBALS['tem_setting']['nav'])){
            usort( $GLOBALS['tem_setting']['nav'], "partition_list_cmp_listorder" );
        }

		if( !$partition_info || !isset($_GET['p']) || !$partition_info['domain_dir'] ){
			header('HTTP/1.0 404 Not Found');
			exit();
			showmessage('參數異常!','blank');
		}
		if( !$partition_info['is_online'] && !is_mobile() ){//上線狀態
			header('HTTP/1.0 404 Not Found');
			exit();
		}

        $www_url = get_category_url('www').'/';
        $base_domain = pc_base::load_config('domains','base_domain');

		//二級域名跳轉
		$domain = str_ireplace( $base_domain, '', $_SERVER['HTTP_HOST'] );
        $if_redirect = 0;

        // 部分方法提供給前台json調用
        $json_list = array('content_json_list');

        if ( !in_array(ROUTE_A, $json_list)){
            if( !strpos($domain, 'test') && !strstr($_SERVER['HTTP_HOST'], pc_base::load_config('domains', 'mobile_domain'))){//測試機和移動端url不啟用
                if( !$partition_info['is_domain'] && ($domain==$partition_info['domain_dir']) ){//未開啟二級域名訪問
                    $if_redirect = 1;
                    $base_redirect_url = $www_url.$partition_info['domain_dir'];
                }else if( $partition_info['is_domain'] && $partition_info['domain_dir']!=$domain && $partition_info['domain_dir'].'.m'!=$domain ){//開啟二級訪問域名
                    if($this->is_ptest==1){
                        //如果ptest=1，則不使用二級域名跳轉
                        $if_redirect = 0;
                        $base_redirect_url = $www_url.$partition_info['domain_dir'];
                    }else{
                        $if_redirect = 1;
                        $base_redirect_url = 'http://'.$partition_info['domain_dir'].$base_domain;
                    }
                }
                if($if_redirect){//跳轉
                    $redirect_url='';
                    switch(ROUTE_A){
                        case 'init':
                            $redirect_url= $base_redirect_url.'/';
                            break;
                        case 'lists':
                            $catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
                            $page_html = isset($_GET['page']) ? '_'.intval($_GET['page']) : '_1';
                            $redirect_url= $base_redirect_url.'/list_'.$catid.$page_html.'.html';
                            break;
                        case 'show':
                            $catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
                            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                            $page_html = isset($_GET['page']) ? '_'.intval($_GET['page']) : '';
                            $redirect_url= $base_redirect_url.'/'.$catid.'_'.$id.$page_html.'.html';
                            break;
                    }
                    if($redirect_url!=''){
                        header('HTTP/1.0 301 Moved Permanently');
                        header('Location: '.$redirect_url);
                        exit();
                    }
                }
            }
        }

		$GLOBALS['use_domain_dir'] = $_GET['p'];

        //是否啟用二級域名
		$GLOBALS['is_domain'] = $partition_info['is_domain'] ? 1 : 0;

        if ( !is_test_server() && $GLOBALS['is_mobile_template'] && $_GET['comefrom'] != 'mofangapp') {
            $this->check_mobile();
        }

        if ( $GLOBALS['is_domain'] == 1 ){
            $this->wap_url = 'http://' . $_GET['p'] . '.m.mofang.com.tw' . $_SERVER['REQUEST_URI'];
        } else {
            $this->wap_url = 'http://m.mofang.com.tw' . $_SERVER['REQUEST_URI'];
        }

        //模板基本設置
        $this->template_basic_set = array();
        $this->template_basic_set = $this->template_basic_var();

        //緩存(如果是編輯測試模版ptest=1也不使用緩存)
        if ( !$this->_disable_cache && in_array(ROUTE_A, $this->_cached_action) && !$this->is_ptest ) {
            $base_url = get_url();
            $getvars = $_GET;
            unset($getvars['refreshcached']);
            unset($getvars['disablecached']);
            ksort($getvars);
            $base_url = $_SERVER['HTTP_HOST'] . ROUTE_A . json_encode($getvars);
            $this->_cache_key = sha1($base_url);
            if (is_mobile()) {//mobile
                $this->_cache_key .= '_m';
            }
            if (is_wap() || isMobile()) {//wap
                $this->_cache_key .= '_wap';
            }
            if ($this->_embed) {//內嵌訪問
                $this->_cache_key .= '_embed';
            }
            if ( !$this->_refresh_cache && ($html = getcache($this->_cache_key, '', 'memcache', 'html')) ) {
                header('Cached: 1');
                $this->_cached = 1;
                $html = preg_replace('/pic([0,1,2])\.mofang.com\//i','pic$1.mofang.com.tw/',$html);
                $html = preg_replace('/sts([0,1,2])\.mofang.com\//i','sts$1.mofang.com.tw/',$html);
                echo $html;
                exit();
            }
            if($this->_refresh_cache){//刷新緩存
                delcache($this->_cache_key, '', 'memcache', 'html');
            }
            $this->_ob_started = 1;
            ob_start();
        }

	}

    /**
     * 手機端檢測並跳轉
     * @author Jozh liu
     */
    protected function check_mobile() {
        $request_url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        if ( isMobile() && (!preg_match("/^m\./", $_SERVER['HTTP_HOST']) && !preg_match("/\.m\./", $_SERVER['HTTP_HOST'])) ) {
            if ( $GLOBALS['is_domain'] == 1 ){
                $wap_url = 'http://' . $_GET['p'] . '.m.mofang.com.tw' . $_SERVER['REQUEST_URI'];
            } else {
                $wap_url = 'http://m.mofang.com.tw' . $_SERVER['REQUEST_URI'];
            }
        }
        if ( !isMobile() && (preg_match("/^m\./", $_SERVER['HTTP_HOST']) || preg_match("/\.m\./", $_SERVER['HTTP_HOST'])) ) {
            if ( $GLOBALS['is_domain'] == 1 ){
                $web_url = 'http://' . $_GET['p'] . '.mofang.com.tw' . $_SERVER['REQUEST_URI'];
            } else {
                $web_url = 'http://www.mofang.com.tw'. $_SERVER['REQUEST_URI'];
            }
        }

        $target_url = $wap_url ? : ( $web_url ? : false ) ;

        if (!$target_url) {
            return true;
        } else {
            header('Location: ' . $target_url);
            exit;
        }
    }

    function __destruct() {
        if ($this->_ob_started) {
            $html = ob_get_contents();
        }

        if ($_SERVER['SERVER_NAME'] == 'www.dev.mofang.com.tw')  {
            $html = preg_replace(array('/www\.test\.mofang\.com\.tw/','/www\.mofang\.com\.tw/'), 'www.dev.mofang.com.tw',$html);
        } elseif($_SERVER['SERVER_NAME'] == 'www.test.mofang.com.tw') {
            $html = preg_replace(array('/www\.test\.mofang\.com\.tw/','/www\.mofang\.com\.tw/'), 'www.test.mofang.com.tw',$html);
        }

        if ( !$this->_cached && !$this->_disable_cache && in_array(ROUTE_A, $this->_cached_action) ) {
            setcache($this->_cache_key, $html, '', 'memcache', 'html', 600);
            delcache($this->_cache_lock_key, '', 'memcache', 'html');
        }
        if ($this->_ob_started) {
            ob_end_clean();
        }

        $html = preg_replace('/pic([0,1,2])\.mofang.com\//i','pic$1.mofang.com.tw/',$html);
        $html = preg_replace('/sts([0,1,2])\.mofang.com\//i','sts$1.mofang.com.tw/',$html);

        echo $html;
    }


    /*
     * 模板配置變量傳值處理
     *
     **/
    private function template_basic_var(){

        //新專區模板(Smarty)
        $v3_template_path = pc_base::load_config('system','v3_template_path');
    	$template_basic_set['v3_template_path'] = $v3_template_path;
    	$template_basic_set['tem_new_index'] = $GLOBALS['tem_new']['index'];
    	$template_basic_set['tem_new_list'] = $GLOBALS['tem_new']['list'];
    	$template_basic_set['tem_new_content'] = $GLOBALS['tem_new']['content'];
                    
        //自定义专区模板(web)
        $template_basic_set['tem_new_index_2'] = $GLOBALS['tem_new_2']['index'];
        $template_basic_set['tem_new_list_2'] = $GLOBALS['tem_new_2']['list'];
        $template_basic_set['tem_new_content_2'] = $GLOBALS['tem_new_2']['content'];

        //自定义专区模板(wap)
        $template_basic_set['tem_new_index_2m'] = $GLOBALS['tem_new_2']['m_index'];
        $template_basic_set['tem_new_list_2m'] = $GLOBALS['tem_new_2']['m_list'];
        $template_basic_set['tem_new_content_2m'] = $GLOBALS['tem_new_2']['m_content'];

        //測試狀態中的專區新模版
        $template_basic_set['tem_new_test_index'] = $GLOBALS['tem_new_test']['index'];
        $template_basic_set['tem_new_test_list'] = $GLOBALS['tem_new_test']['list'];
        $template_basic_set['tem_new_test_content'] = $GLOBALS['tem_new_test']['content'];

        // 專區id
    	$template_basic_set['partition_id'] = $GLOBALS['part_id'];
    	$template_basic_set['partname'] = $GLOBALS['part_name'];
    	$template_basic_set['dir_name'] = $GLOBALS['part_dir'];
        //卡牌库id
    	$template_basic_set['card_db_ename'] = $GLOBALS['card_db_ename'];
        //论坛id
    	$template_basic_set['bbs_id'] = $GLOBALS['bbs_id'];
    	$template_basic_set['is_newbbs'] = $GLOBALS['is_newbbs'];
    	//模版設置
    	$template_basic_set['partition_type'] = $GLOBALS['tem_setting']['partition_type'];//模版色調
    	$template_basic_set['partition_color'] = $GLOBALS['tem_setting']['partition_color'];

    	//背景图与头图配置
    	$template_basic_set['web_background'] = $GLOBALS['web_background'];//背景图
    	$template_basic_set['web_bg_url'] = $GLOBALS['web_bg_url'];//背景图链接
    	$template_basic_set['web_header'] = $GLOBALS['web_header'];// 头图链接
    	$template_basic_set['no_pic'] = $GLOBALS['no_pic'];// 縮略圖默認圖片

    	//$template_basic_set['nav_height'] = $GLOBALS['tem_setting']['nav_height'];//導航高度
    	$template_basic_set['nav_height'] = 106;//導航高度,添加專區搜索全部設置為最大高度
    	//搜索設置
    	$template_basic_set['is_search'] = $GLOBALS['is_search'];//搜索狀態
    	$template_basic_set['search_code'] = $GLOBALS['search_code'];//搜索代碼
        //大導航
        $part_nav = $GLOBALS['tem_setting']['nav'];
        if( is_array($part_nav) ){
            krsort($part_nav);
        }
        $template_basic_set['part_nav'] = $part_nav;
        //小導航
        $GLOBALS['tem_setting']['littlenav']['id_list'] = $GLOBALS['tem_setting']['littlenav']['id_list']===null ? array() : $GLOBALS['tem_setting']['littlenav']['id_list'];
        $GLOBALS['tem_setting']['littlenav']['list_id'] = $GLOBALS['tem_setting']['littlenav']['list_id']===null ? array() : $GLOBALS['tem_setting']['littlenav']['list_id'];
        $little_nav = array_merge($GLOBALS['tem_setting']['littlenav']['id_list'],$GLOBALS['tem_setting']['littlenav']['list_id']);
        foreach($little_nav as $k => $v){
            $ks=$v['listorder'];
            $little_nav[$ks]=$v;
            unset($little_nav[0]);
        }
        $template_basic_set['little_nav'] = $little_nav;
        //快捷導航
        foreach($GLOBALS['tem_setting']['fastnav'] as $val) {
            $template_basic_set['fast_nav'][$val['listorder']] = $val;    
        }
        //bbs相關
        $template_basic_set['bbs_nav_url'] = $GLOBALS['tem_setting']['bbs_nav_url'] ? $GLOBALS['tem_setting']['bbs_nav_url'] : '';//專區論壇入口
        $template_basic_set['bbs_cat_api_url'] = $GLOBALS['tem_setting']['bbs_cat_api_url'] ? $GLOBALS['tem_setting']['bbs_cat_api_url'] : '';//論壇熱貼接口
        $template_basic_set['mf_libao_url'] = $GLOBALS['tem_setting']['mf_libao_url'] ? $GLOBALS['tem_setting']['mf_libao_url'] : '';//魔方遊戲禮包
        $template_basic_set['qq_qun_url'] = $GLOBALS['tem_setting']['qq_qun_url'] ? $GLOBALS['tem_setting']['qq_qun_url'] : array();//qq群idkey
        // 資訊
        $template_basic_set['news_arr'] = $GLOBALS['tem_setting']['news'] ? $GLOBALS['tem_setting']['news'] : '';
        //輪播圖
        $template_basic_set['slide_id'] = $GLOBALS['tem_setting']['slide']['catid'] ? $GLOBALS['tem_setting']['slide']['catid'] : null;
        $template_basic_set['slide_nums'] = $GLOBALS['tem_setting']['slide']['nums'] ? $GLOBALS['tem_setting']['slide']['nums'] : 0;
        //輕鬆一刻->視頻
        $template_basic_set['videos'] = $GLOBALS['tem_setting']['videos']['catid'] ? $GLOBALS['tem_setting']['videos']['catid'] : null;

        //模塊排序
        $column = $GLOBALS['tem_setting']['column'] ? : array();
        foreach ($column as $k => $v) {
        	$column[$k] = $v['listorder'];
        }
        $column = array_flip($column);
        ksort($column);
        $template_basic_set['column'] = $column ;
        //新手攻略與指南
		$template_basic_set['gls_arr'] = $GLOBALS['tem_setting']['gls'] ? $GLOBALS['tem_setting']['gls'] : '';
		$template_basic_set['guideline'] = $GLOBALS['tem_setting']['guide'] ? $GLOBALS['tem_setting']['guide'] : '';
		$template_basic_set['guideline']['guide_type'] = $GLOBALS['tem_setting']['guide']['guide_type']===null ? 0 : $GLOBALS['tem_setting']['guide']['guide_type'];
		$template_basic_set['newgls_guide_disable_type'] = $GLOBALS['tem_setting']['newgls_guide_disable_type']===null ? 0 : $GLOBALS['tem_setting']['newgls_guide_disable_type'];
		//副本信息與攻略
		$template_basic_set['team_arr'] = $GLOBALS['tem_setting']['team'] ? $GLOBALS['tem_setting']['team'] : '';
		$template_basic_set['team_arr']['team_type'] = $GLOBALS['tem_setting']['team']['team_type']===null ? 0 :$GLOBALS['tem_setting']['team']['team_type'];
		//pvp攻略與視頻
		$template_basic_set['pvp_arr'] = $GLOBALS['tem_setting']['pvp'] ? $GLOBALS['tem_setting']['pvp'] : '';
		//遊戲視頻、圖鑑、圖集
		$template_basic_set['video'] = $GLOBALS['tem_setting']['video'] ? $GLOBALS['tem_setting']['video'] : '';
		$template_basic_set['tujian_arr'] = $GLOBALS['tem_setting']['tujian'] ? $GLOBALS['tem_setting']['tujian'] : array();
		$template_basic_set['tujian_topic_disable_type'] = $GLOBALS['tem_setting']['tujian_topic_disable_type'];
        $template_basic_set['tuji_arr'] = $GLOBALS['tem_setting']['tuji'] ? $GLOBALS['tem_setting']['tuji'] : array();

        //專題4圖
        $template_basic_set['part_topic_pic'] = $GLOBALS['tem_setting']['topic_pic'] ? $GLOBALS['tem_setting']['topic_pic'] : array();
        //統計代碼
        $template_basic_set['statistical_code'] = $GLOBALS['tem_setting']['statistical_code'];
        //友情鏈接
        $template_basic_set['link'] = $GLOBALS['tem_setting']['partlink'] ? $GLOBALS['tem_setting']['partlink'] : array();
        $template_basic_set['link']['type'] = $GLOBALS['tem_setting']['partlink']['type']===null ? 2 : $GLOBALS['tem_setting']['partlink']['type'];
        //文章內鏈
        $template_basic_set['keylink'] = $GLOBALS['tem_setting']['keylink'] ? $GLOBALS['tem_setting']['keylink'] : array();
        //內嵌頁
        $template_basic_set['neiqian_list'] = $GLOBALS['tem_setting']['neiqian_list'] ? $GLOBALS['tem_setting']['neiqian_list'] : array();
        $template_basic_set['neiqian_list']['partname'] = $GLOBALS['use_domain_dir'];
        //iframe內嵌其他頁面
        $template_basic_set['iframe_links'] = $GLOBALS['tem_setting']['iframelink'];

        //內容/列表頁熱門攻略及視頻配置
        $template_basic_set['hot_gls'] = $GLOBALS['tem_setting']['hot_gls'];
        $template_basic_set['hot_video'] = $GLOBALS['tem_setting']['hot_video'];
  
        // 浮層信息配置
        $template_basic_set['is_float'] = $GLOBALS['tem_setting']['is_float'];
        $template_basic_set['floating'] = $GLOBALS['tem_setting']['floating'];

        $template_basic_set['is_ad'] = $GLOBALS['tem_setting']['is_ad'];
        $template_basic_set['banner_ad'] = $GLOBALS['tem_setting']['banner_ad'];


        return $template_basic_set;
    }

	//首頁
	public function init() {
		$GLOBALS['use_domain_dir'] = $_GET['p'];
        $partition_name = $GLOBALS['part_name']; //當前的part名字
		$SEO = seo_info($_GET['p']);
        //通用模板設置
        extract($this->template_basic_set);
        
        if($this->is_general_template){ //smarty模板
            require(PC_PATH."init/smarty.php");

            if($this->is_new_template !=0 || $_GET['new_tpl'] == 1 || $GLOBALS['wap_setting']['new_template'] == 1) {
                $smarty = use_v4();
            } else {
                $smarty = use_v3();
            }

            $smarty->assign("SEO",$SEO);
            $smarty->assign("wap_url",$this->wap_url);

            if ($_GET['test']=='mobile') {
                $smarty->assign("partition_id",$GLOBALS['partition_id']);
                $smarty->assign("part_name",$GLOBALS['part_name']);
                $smarty->assign("bbs_nav_url",$bbs_nav_url);

                foreach($this->template_basic_set as $key => $val){
                    $smarty->assign($key,$val);
                }

                // 移动端配置赋值
                $smarty->assign($GLOBALS['wap_setting']);

                $smarty->display('mobile/tyong/index.tpl');
            } elseif(($_GET['wap'] == 1) || (is_mobile() || is_wap() || isMobile()) && $this->is_mobile_template){//移動端訪問
                $smarty->assign("part_name",$GLOBALS['part_name']);
                $smarty->assign("bbs_nav_url",$bbs_nav_url);
                
                foreach($this->template_basic_set as $key => $val){
                    $smarty->assign($key,$val);
                }

                // 移动端配置赋值
                $smarty->assign($GLOBALS['wap_setting']);

                //老专区模板的使用v3模板
                if($GLOBALS['wap_setting']['new_template'] == 1) {
                    $smarty->display('twm_tyong/new_edition/index.tpl');
                } elseif($this->is_new_template == 0) {
                    $smarty->display('mobile/tyong/index.tpl');
                } elseif($this->is_new_template == 2 && !empty($tem_new_index_2m) && $smarty->templateExists($tem_new_index_2m)) {
                    $smarty->display($tem_new_index_2m);
                } else {
                    //新专区与自定义未指定模板的使用v3模板
                    $smarty->display('twm_tyong/index.tpl');
                }
            }else{ //選擇通用模版 
                //浮窗功能
                /*$smarty->assign('floating_url',$this->floating_url);
                if($this->partition_setting['is_partition']){
                    $smarty->assign('is_partition',1);
                }else{
                    $smarty->assign('is_partition',0);
                }*/ 
                foreach($this->template_basic_set as $key => $val){
                    $smarty->assign($key,$val);
                }

                $smarty->assign("module_setting",$GLOBALS['module_setting']);
                $smarty->assign("module_setting_type",$GLOBALS['module_setting_type']);
                $smarty->assign("partition_name",$partition_name);
                //專區測試模版選擇 
                if($this->is_ptest==1){
                    /*
                        通過函數處理頁面的js css等鏈接
                    */
                    $return_content = $this->get_partition_content($smarty, $_GET['p'],$tem_new_test_index); 
                    echo $return_content; exit();

                    // $pp = "/statics/s_test/partition/".$_GET['p'];
                    // $smarty->assign('pp',$pp);
                    // $content = $smarty->fetch($this->ptest_dir.'/partition/'.$_GET['p'].'/'.$tem_new_test_index);
        
                    // $module = "partition/".$GLOBALS['use_domain_dir'];

                    // $base_path = "/statics/s_test/".$module;
                    // $source = PHPCMS_PATH.'statics/s_test';
                    // preg_match_all('/((\.\.|\.)\/(img|css|js|images)\/.*\.(js|css|jpg|png|gif|swf|htc))/i',$content,$matches);
                    // $files = $matches[1];
                    // foreach ($files as $file) {
                    //     $s_file = str_replace(array("../","./"),"",$file);
                    //     $resource_filename = $source."/".$module."/".$s_file;
                    //     if(!file_exists($resource_filename)){
                    //         continue;
                    //     }
                    //     $pos_num = strripos($s_file,'.');
                    //     $ext = substr($s_file, $pos_num);//取出文件 後綴
                    //     $first = substr($s_file, 0,$pos_num);//取出文件 後綴
                    //     // list($name,$ext) = split("\.",$s_file);
                    //     $s = $base_path."/".$first.$ext;  
                    //     $content = str_replace(array($file),$s,$content);
                    // }
                    // echo $content; exit();
                    // $smarty->display($this->ptest_dir.'/partition/'.$_GET['p'].'/'.$tem_new_test_index);
                    // exit;
                }

                if($_GET['new_tpl'] == 1) {
                    $smarty->display('tw_tyong/index.tpl');
                    return;
                }

                if($this->is_new_template==1){ 

                    //新模版
                    //$smarty->display($tem_new_index);
                    $smarty->display('tw_tyong/index.tpl');
                }elseif($this->is_new_template==2 && !empty($tem_new_index_2)){
                    //自定義模版程序  
                    //$smarty->display($this->ptest_dir.'/partition/'.$_GET['p'].'/'.$tem_new_index_2);
                    $smarty->display($tem_new_index_2);
                }else{
                    $temp_sign = strpos($this->template_basic_set['partition_type'], '_new');
                    if ($temp_sign) {
                        $smarty->display('tongyong_template/index.tpl'); // 新通用模版
                    } else {
                        $smarty->display('tyong/index.tpl'); // 通用模版
                    }
                }
            }
        } else {
		    $template_file = $GLOBALS['use_domain_dir'].'_index';
            include template('partition', $template_file);    
        }
    }

	//內容頁
	public function show() {

		$catid = intval($_GET['catid']);
		$id = intval($_GET['id']);

		if(!$catid || !$id) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

		$_userid = $this->_userid;
		$_username = $this->_username;

		$page = intval($_GET['page']);
		$page = max($page,1);
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];

        //這裡肯定需要重構,這個變量2.5M大小
        //這段貌似沒什麼用
        //對主站有用,對專區內容頁沒用
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');

		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
		$this->category = $CAT = $CATEGORYS[$catid];
		$this->category_setting = $CAT['setting'] = string2array($this->category['setting']);
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];

		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];

		//訪問專區文章時增加瀏覽量
		/*$db_hits = pc_base::load_model('hits_model');
		$hits_data = array('views'=>'+=1','dayviews'=>'+=1','weekviews'=>'+=1','monthviews'=>'+=1');
		$hits_where['hitsid'] = 'c-'.$modelid.'-'.$id;
		$hits_where['catid'] = $catid;
		$db_hits->update($hits_data,$hits_where);*/

		//主表
		$tablename = $this->db_content->table_name = $this->db_content->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db_content->get_one(array('id'=>$id));
		if(!$r || $r['status'] != 99) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

		//附表
		$this->db_content->table_name = $tablename.'_data';
		$r2 = $this->db_content->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;

		//再次重新賦值，以數據庫為準
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];

        if (true) {
            require_once CACHE_MODEL_PATH.'content_output.class.php';
            $content_output = new content_output($modelid,$catid,$CATEGORYS);
            $data = $content_output->get($rs);
        } else {
            $data = $rs;
        }
		extract($data);
        if ($_GET['format'] === 'json') {
            echo json_encode($data);
            exit;
        }
        if ($islink && $url) {
            $this->_disable_cache = 1;
            header('Location: ' . $url);
            exit;
        }
        //評論
		if(module_exists('comment')) {
			$allow_comment = isset($allow_comment) ? $allow_comment : 1;
		} else {
			$allow_comment = 0;
		}
        if ($allow_comment) {
            $comment_article_id = 'content_'.$catid.'-'.$id.'-1';
            $comment_article_title = $title;
            $comment_article_url = partition_url().$catid.'_'.$id.'.html';
        }

		//最頂級欄目ID
		$arrparentid = explode(',', $CAT['arrparentid']);
		$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;

		$template = $template ? $template : $CAT['setting']['show_template'];
		if(!$template) $template = 'show';

		//define('STYLE',$CAT['setting']['template_list']);
		if(isset($rs['paginationtype'])) {
			$paginationtype = $rs['paginationtype'];
			$maxcharperpage = $rs['maxcharperpage'];
		}
		$pages = $titles = '';

        // SEO信息
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$SEO = seo_partition_detail($_GET['p'], $siteid, '', $title, $description, $seo_keywords);
        $SEO['title'] = $title . '_魔方網' . $GLOBALS['part_name'] . '專區';

		if($rs['paginationtype']==1) {
			//自動分頁
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = pc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
		if($rs['paginationtype']!=0) {
			//手動分頁
			$CONTENT_NAV = strpos($content, '[page=');
			$CONTENT_POS = strpos($content, '[page]');
            if ($CONTENT_NAV !== false) {
				$this->url = pc_base::load_app_class('url2', 'partition');
				$contents = array_filter(explode('[page=', $content));
				$pagenumber = count($contents);
				for($i=1; $i<$pagenumber; $i++) {
					$navpages[$i] = $this->url->show($id, $i, $catid, $rs['inputtime']);
				}

                $search = "/\[page=(.*)\]/";

                if( preg_match_all($search, $content, $result) ) {
                    foreach($result[1] as $k=>$v) {
                        foreach($navpages as $_k=>$_v) {
                            if ( $_k == ($k+1) ) {
                                $txtnavs[$_k]['title'] = $v;
                                $txtnavs[$_k]['url'] = $_v[1] ? : ($_v[2] ? : '');
                                if( $_k == $page && $page != 1 ) {
                                    $SEO['title'] = $GLOBALS['part_name'] . $v . '_魔方網' . $GLOBALS['part_name'] . '專區';
                                }
                            }
                        }
                    }
                }
                $content = preg_replace($search, '', $content);
            }
			if($CONTENT_POS !== false) {
				$this->url = pc_base::load_app_class('url2', 'partition');
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->show($id, $i, $catid, $rs['inputtime']);
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				//當不存在 [/page]時，則使用下面分頁
				$pages = content_pages($pagenumber,$page, $pageurls);
				//判斷[page]出現的位置是否在第一位
				if($CONTENT_POS<7) {
					$content = $contents[$page];
				} else {
					if ($page==1 && !empty($titles)) {
						$content = $title.'[/page]'.$contents[$page-1];
					} else {
						$content = $contents[$page-1];
					}
				}
				if($titles) {
					list($title, $content) = explode('[/page]', $content);
					$content = trim($content);
					if(strpos($content,'</p>')===0) {
						$content = '<p>'.$content;
					}
					if(stripos($content,'<p>')===0) {
						$content = $content.'</p>';
					}
				}
			}
		}
        $full_content = $contents?join('', $contents):$content;

		$this->db_content->table_name = $tablename;

		//前一篇&後一篇
        $temp_pid = $this->db_partition->get_one("`domain_dir`='".$_GET['p']."'", 'catid');
        $channel_ids = $this->db_partition->select("`arrparentid` LIKE '%".$temp_pid['catid']."%'",'catid');
        $channel_ids_str = '';
        foreach( $channel_ids as $keyi=>$vali ){
            $channel_ids_str .= ','.$vali['catid'];
        }
        $channel_ids_str = trim($channel_ids_str, ',');

        $f_id = $this->db_partition_game->get_one("`gameid`=".$id.' AND `part_id` IN ('.$channel_ids_str.')','part_id');
        if(!$f_id['part_id']){//無關聯文章,返回404
            header('HTTP/1.0 404 Not Found');
            exit();
        }
        $c_id = $this->db_partition_game->get_one("`gameid`=".$id.' AND `part_id`='.$f_id['part_id'],'id');

        $pre_id = $this->db_partition_game->get_one("`id`<".$c_id['id']." AND `part_id` IN(".$f_id['part_id'].")",'modelid,gameid', '`id` DESC');
        $next_id = $this->db_partition_game->get_one("`id`>".$c_id['id']." AND `part_id` IN(".$f_id['part_id'].")",'modelid,gameid', '`id` ASC');

        //上一頁
        if($pre_id['gameid']){
            $this->db_content->set_model($pre_id['modelid']);
            $previous_page = $this->db_content->get_one("`id`=".$pre_id['gameid'], 'catid,id,title');
            $pre_url['url'] = get_info_url($previous_page['catid'], $previous_page['id']);
            $pre_url['title'] = $previous_page['title'];
        }else{
            $pre_url['url'] = "javascript:void(0)";
            $pre_url['title'] = "沒有了!";
        }

        //下一頁
        if($next_id['gameid']){
            $this->db_content->set_model($next_id['modelid']);
            $next_page = $this->db_content->get_one("`id`=".$next_id['gameid'], 'catid,id,title');
            $next_url['url'] = get_info_url($next_page['catid'], $next_page['id']);
            $next_url['title'] = $next_page['title'];
        }else{
            $next_url['url'] = "javascript:void(0)";
            $next_url['title'] = "沒有了!";
        }

        // 文章欄目id
        $info_where['modelid'] = $CAT['modelid'];
        $info_where['gameid'] = $id;
        $info_part_id = $this->db_partition_game->get_one( $info_where, 'part_id' );
        $info_part_id = $info_part_id['part_id'];

		//相關文章
         if( true ){
            $info_where['modelid'] = $CAT['modelid'];
            $info_where['gameid'] = $id;
            $info_part_id = $this->db_partition_game->get_one( $info_where, 'part_id' );
            $info_part_id = $info_part_id['part_id'];
            /*if(!isset($info_part_id)){//无关联文章,返回404
                header('HTTP/1.0 404 Not Found');
                exit();
            }*/
            $relate_ids = $this->db_partition_game->select('`part_id`='.$info_part_id, 'modelid,gameid', 6);
        }else{
            $relate = explode('|', trim($rs['relation'], '|'));
            foreach($relate as $id){
                $relate_ids[] = $this->db_partition_game->get_one('`id`='.$id, 'modelid,gameid');
            }
        }

        $relate_article_array = array();
        if( $relate_ids ){
            foreach( $relate_ids as $r_key=>$r_value ){
                $this->db_content->set_model($r_value['modelid']);

                $info_list_item = $this->db_content->get_one('`id`='.$r_value['gameid'], 'id,catid,url,title,inputtime' );
                //需要增加short_name判空条件
                $info_list_item['url'] = get_info_url($info_list_item['catid'], $info_list_item['id']);
                $relate_article_array[] = $info_list_item;
            }
        }

		$tpl_file = $GLOBALS['use_domain_dir'].'_content';

		$content = force_balance_tags($content);

        //文章類型
		$cont_type_re = $this->db_partition->get_one('`catid`='.$info_part_id, 'cont_type');
        $cont_type = $cont_type_re['cont_type'];

        //通用模板設置
        extract($this->template_basic_set);

        if($this->is_general_template){//通用模板
            require(PC_PATH."init/smarty.php");

            if($this->is_new_template !=0 || $_GET['new_tpl'] == 1 || $GLOBALS['wap_setting']['new_template'] == 1) {
                $smarty = use_v4();
            } else {
                $smarty = use_v3();
            }
            $smarty->assign("SEO",$SEO);
            $smarty->assign("wap_url",$this->wap_url);

            if ($_GET['test']=='mobile') {
                $smarty->assign("part_name",$GLOBALS['part_name']);

                foreach($this->template_basic_set as $key => $val){
                    $smarty->assign($key,$val);
                }
                foreach($GLOBALS['wap_setting'] as $key=>$val){
                    $smarty->assign($key,$val);
                }
                $smarty->assign("rs",$rs);
                $smarty->assign("id",$id);
                $smarty->assign("modelid",$modelid);
                $smarty->assign("youkuid",$youkuid);
                $smarty->assign("pics",$pics);

                $content = $this->_un_include($content);
                $smarty->assign("content",$content);
                $smarty->assign("pages",$pages);
                $smarty->assign("pre_url",$pre_url);
                $smarty->assign("next_url",$next_url);
                $smarty->assign("info_part_id",$info_part_id);
                $smarty->assign("relate_article_array",$relate_article_array);
                $smarty->assign("allow_comment",$allow_comment);

                $smarty->display('mobile/tyong/content.tpl');
            } elseif (is_mobile()) {
                if($modelid == 11) {//視頻攻略
                    include template('content','html5_video');
                }elseif ( $modelid == 26 ) {//多圖攻略
                    include template('content','html5_pics_review', 'ios');
                }else{//增加h5判斷處理
                    include template('content','html5');
                }
            } elseif(($_GET['wap'] == 1) ||  isMobile() && $this->is_mobile_template ) {
                // 赋值数据库字段值
                $smarty->assign($rs);
                // 专区名称赋值
                $smarty->assign("part_name",$GLOBALS['part_name']);
                // 模板基本信息赋值
                $smarty->assign($this->template_basic_set);
                // wap相关设定赋值
                $smarty->assign($GLOBALS['wap_setting']);
                // 其他属性赋值
                $smarty->assign("keywords",$keywords);
                $smarty->assign("id",$id);
                $smarty->assign("modelid",$modelid);
                $smarty->assign("youkuid",$youkuid);
                $smarty->assign("pics",$pics);
                $smarty->assign("content",$content);
                $smarty->assign("pages",$pages);
                $smarty->assign("pre_url",$pre_url);
                $smarty->assign("next_url",$next_url);
                $smarty->assign("info_part_id",$info_part_id);
                $smarty->assign("relate_article_array",$relate_article_array);
                $smarty->assign("allow_comment",$allow_comment);

                // 游戏宝模版渲染
                if ($_GET['comefrom'] == 'mofangapp') {
                    if ($modelid == '1') {
                        if($_GET['style']==2){
                            $smarty->display('twm_tyong/yxb_details_white.tpl');
                        }else{
                            $smarty->display('twm_tyong/yxb_details.tpl');
                        }
                    } elseif($modelid == '11' || $modelid == '17') {
                        $smarty->display('twm_tyong/yxb_video.tpl');
                    }
                } else {
                    if($GLOBALS['wap_setting']['new_template'] == 1) {
                        $smarty->display('twm_tyong/new_edition/detail.tpl');
                    } elseif($this->is_new_template == 0) {
                        $smarty->display('mobile/tyong/content.tpl');
                    } elseif($this->is_new_template==2 && !empty($tem_new_content_2m) && $smarty->templateExists($tem_new_content_2m)) {
                        $smarty->display($tem_new_content_2m);
                    } else {
                        $smarty->display('twm_tyong/content.tpl');
                    }
                }
            } else {//通用模板

                //浮窗功能
                /*$smarty->assign('floating_url',$this->floating_url);
                if($this->partition_setting['is_partition']){
                    $smarty->assign('is_partition',1);
                }else{
                    $smarty->assign('is_partition',0);
                } */ 

                $smarty->assign("module_setting",$GLOBALS['module_setting']);
                $smarty->assign("module_setting_type",$GLOBALS['module_setting_type']);

                foreach($this->template_basic_set as $key => $val){
                   $smarty->assign($key,$val);
                }

                // 全部数据库数据赋值
                $smarty->assign($data);
                
                // 个性化数据覆盖
                $smarty->assign("rs",$rs);
                $smarty->assign("id",$id);
                $smarty->assign("modelid",$modelid);
                $smarty->assign("youkuid",$youkuid);
                $smarty->assign("pics",$pics);
                $smarty->assign("tag",json_encode($keywords));
                //增加簡介的定義wangguanqing
                $smarty->assign("title",$title);
                $smarty->assign("keywords",$keywords);
                $smarty->assign("thumb",$thumb);
                $smarty->assign("description",$description);

                //增加對關聯鏈接/圖片ALT的處理 @wangguanqing
                //$content = $this->_keylinks($content);
                $content = preg_replace("/alt=\".*?\"/i","alt=\"$title\"",$content);
                $content = $this->_include($content);

                $smarty->assign("username",$username);
                $smarty->assign("content",$content);
                $smarty->assign("pages",$pages);
                $smarty->assign("txtnavs",$txtnavs);
                $smarty->assign("pre_url",$pre_url);
                $smarty->assign("next_url",$next_url);
                $smarty->assign("info_part_id",$info_part_id);
                $smarty->assign("relate_article_array",$relate_article_array);
                $smarty->assign("allow_comment",$allow_comment);

                //文章類型
                $smarty->assign("cont_type",$cont_type);

                // 評論相關
                $smarty->assign("comment_article_id",$comment_article_id);
                $smarty->assign("comment_article_title",$comment_article_title);
                $smarty->assign("comment_article_url",$comment_article_url);

                /***如果測試，則調專區測試模版 ，並指定靜態文件的地址供$pp 供頁面使用 **/
                if($this->is_ptest==1){
                    /*
                        通過函數處理頁面的js css等鏈接
                    */
                    $return_content = $this->get_partition_content($smarty, $_GET['p'],$tem_new_test_content); 
                    echo $return_content; 
                    exit(); 
                }

                if($_GET['new_tpl'] == 1) {
                    $smarty->display('tw_tyong/detail.tpl');
                    return;
                }

                /**選擇新模版或自定義模版，如沒有指定對應模版，則自動選擇默認通用模版**/
                if($this->is_new_template==1){
                    /*** 
                    以下代碼需要改造（需要取當前文章所在欄目的配置，如重新定義了內容頁的樣式，則渲染定義的模版，否則渲染通用的content.tpl），請勿刪除!!
                    if($template_info['template_type']==1 && !empty($template_info['tem_new']['content'])){
                        //當前欄目有獨立的列表頁模版配置 
                        $smarty->display($template_info['tem_new']['content']); 
                    }else{
                        //本欄目沒有設置模版，沿用專區通用的模版設置
                        $smarty->display($tem_new_content); 
                    }
                    */
                    //新模版 
                    //$smarty->display($tem_new_content); 
                    $smarty->display('tw_tyong/detail.tpl');
                }elseif($this->is_new_template==2 && !empty($tem_new_content_2)){
                    /**
                    * 以下代碼也需要改造，同上處理方法
                    **/
                    //自定義模版程序 
                    //$smarty->display($this->ptest_dir.'/partition/'.$_GET['p'].'/'.$tem_new_content_2);
                    $smarty->display($tem_new_content_2); 
                }else{
                    //通用模版處理程序（包含選擇了新模版/自定義模版，但並沒有填寫內容模版的情況，自動調用通用模版）
                    $temp_sign = strpos($this->template_basic_set['partition_type'], '_new');
                    if ($temp_sign) {
                        $smarty->display('tongyong_template/detail.tpl');
                    } else {
                        $smarty->display('tyong/content.tpl');
                    }
                }
            }
        } else {
		    $template_file = $GLOBALS['use_domain_dir'].'_content';
            include template('partition', $template_file);    
        }
	}


    /**
    * 關鍵字外鏈接的處理程序
    **/

    function _base64_encode($t,$str) {
        return $t."\"".base64_encode($str)."\"";
    }
    function _base64_decode($t,$str) {
        return $t."\"".base64_decode($str)."\"";
    }
    function _keylinks($txt, $replacenum = '',$link_mode = 1) {
        $search = "/(alt\s*=\s*|title\s*=\s*)[\"|\'](.+?)[\"|\']/ise";
        $replace = "\$this->_base64_encode('\\1','\\2')";
        $replace1 = "\$this->_base64_decode('\\1','\\2')";
        $txt = preg_replace($search, $replace, $txt);

        $keylinks = $this->template_basic_set['keylink'];
        foreach($keylinks as $_k=>$_v){
            $linkdatas[$_k][] = $_v['title'];
            $linkdatas[$_k][] = $_v['url'];
        }
        if($linkdatas) {
            $word = $replacement = array();
            foreach($linkdatas as $v) {
                if($link_mode && $keywords) {
                    $word1[] = '/(?!(<a.*?))' . preg_quote($v, '/') . '(?!.*<\/a>)/s';
                    $word2[] = $v;
                    $replacement[] = '<a href="javascript:;" onclick="show_ajax(this)" class="keylink">'.$v.'</a>';
                } else {
                    $word1[] = '/(?!(<a.*?))' . preg_quote($v[0], '/') . '(?!.*<\/a>)/s';
                    $word2[] = $v[0];
                    $replacement[] = '<a href="'.$v[1].'" target="_blank" class="keylink"><span style="color:#ff0000;">'.$v[0].'</span></a>';
                }
            }
            if($replacenum != '') {
                $txt = preg_replace($word1, $replacement, $txt, 1);
            } else {
                 foreach ($word2 as $word2key => $var) {//循環要替換的字符串
                    $pos = strpos($txt, $var);
                    if ($pos === false) {
                        continue;
                    }
                    $txt = substr_replace($txt, $replacement[$word2key], $pos, strlen($var));
                }
            }
        }
        $txt = preg_replace($search, $replace1, $txt,1);
        return $txt;
    }

    /**
     * 提供給編輯使用的INC功能
     * 規範填寫[INC=*]
     */
    public function _include($content) {
        $search = "/\[INC=(.*)\]/";
        preg_match_all($search, $content, $result);

        // 獲取include中url的內容
        foreach($result[1] as $k=>$v){
            $re[$k] = file_get_contents($v) ? :'<a href="'.$v.'" style="display:none;"></a>';// 無內容則添加隱藏的a鏈接，以供排錯
        }
        // 使用連接中內容替換源代碼
        foreach ($result[0] as $k=>$v) {
            foreach ($re as $_k=>$_v) {
                if ($_k == $k) {
                    $sear = addcslashes($result[0][$k], '[');
                    $sear = addcslashes($sear, ']');
                    $sear = addcslashes($sear, '/');
                    $sear = '/'.$sear.'/';

                    $content = preg_replace($sear, $re[$k], $content);
                }
            }
        }

        return $content;
    }
    /**
     * 去除文章內的INC引用，應用於移動端
     * 
     */
    public function _un_include($content) {
        $search = "/\[INC=(.*)\]/";
        $content = preg_replace($search, '', $content);

        return $content;
    }

    /*
     * 卡牌數據庫列表頁
     *
     */
    public function card_list(){

        // 銷毀CMS的路由參數
        unset($_GET['m'],$_GET['c'],$_GET['a']);
        $domain_dir = $_GET['p'];

        $dbid = $GLOBALS['card_db_ename'];
        $setid = intval($_GET['setid'])?:0;

        $other_condition = '/dbid/'.$dbid.'/setid/'.$setid;

        // 加載卡牌數據庫
        $card_api = pc_base::load_config('api','card_api');
        $api_url = $card_api.'/gettables'.$other_condition;
        if ($_GET['url']) {
            var_dump($api_url);
        }
        $table_info = mf_curl_get($api_url);
        $table_info = json_decode($table_info, true);

        // 列表展现方式及字段查询
        $show_type = 0;
        if($table_info['code'] == 0) {
            $show_info = $table_info['data']['type'];
            $show_type = $show_info['show_type'];
            unset($show_info['select']['icon']);
            $field_names = array_values($show_info['select']); 
            unset($show_info['select']['name']);
            $field_keys = array_keys($show_info['select']); 
            if(empty($field_keys)) {
                $other_condition .= '/select/name,icon';
            } else {
                $other_condition .= '/select/'.implode(',', $field_keys).',name,icon';
            }
        }

        // 篩選條件獲取
        $filter_fields = array_keys($table_info['data']['info']);
        foreach($filter_fields as $key) {
            if(!empty($_GET[$key])) {
                if(is_array($_GET[$key])) {
                    $min = $_GET[$key]['min']?:0;
                    $max = $_GET[$key]['max']?:0;
                    if($min || $max) {
                        $filter[] = $key.'|'.$min.':'.$max;
                    }
                } else {
                    $str_pos = strrpos($_GET[$key], ",");
                    $str_len = strlen($_GET[$key]);
                    if(($str_pos+1) == $str_len) {
                        $filt_key = substr($_GET[$key], 0, $str_pos);
                    }
                    $filter[] = $key.'|'.$filt_key;    
                }
            }
        }
        if($filter) {
            $other_condition .= '/filter/'.implode('::', $filter);
        }

        // 根據加載不同模板，讀取不同數量的數據
        if($show_type == 1) {
            $other_condition .= '/size/28';    
        } else {
            $other_condition .= '/size/10';    
        }
        $page = intval($_GET['page'])?:1;
        $other_condition .= '/page/'.$page;

        // 加載卡牌數據庫
        $card_api = pc_base::load_config('api','card_api');
        $api_url = $card_api.'/getitems'.$other_condition;
        if ($_GET['url']) {
            var_dump($api_url);
        }
        $list_info = mf_curl_get($api_url);
        $list_info = json_decode($list_info, true);
        //echo "<pre>";
        //var_dump($list_info);exit;

        // 數據賦值
        $CARD['table_list'] = $table_info['data']['list'];
        $CARD['table_info'] = $table_info['data']['info'];

        $CARD['field_keys'] = $field_keys;
        $CARD['field_names'] = $field_names;

        $CARD['card_size'] = $list_info['pages']['pageSize'] ? : 0;
        $CARD['card_total'] = $list_info['pages']['itemCount'] ? : 0;
        $CARD['card_data'] = $list_info['data'];

		$temp_part_info = $this->db_partition->get_one('`domain_dir`="'.$domain_dir.'"', 'catname');
		$catname = $temp_part_info['catname'];

        if($_GET['condition'] == 'hero'){
            $SEO['title'] = $catname.'卡牌庫_'.$catname.'英雄庫-魔方網';
            $SEO['keyword'] = $catname.'卡牌庫,'.$catname.'英雄庫,'.$catname;
            $SEO['description'] = $catname.'刀塔傳奇卡牌庫為魔方網玩家提供全面的刀塔傳奇英雄庫資料，致力於打最專業，最全的刀塔傳奇卡牌庫。';
        }elseif($_GET['condition'] == 'card_type'){
            $SEO['title'] = $catname.'卡牌庫_'.$catname.'裝備庫-魔方網';
            $SEO['keyword'] = $catname.'卡牌庫,'.$catname.'裝備庫,'.$catname;
            $SEO['description'] = $catname.'刀塔傳奇卡牌庫為魔方網玩家提供全面的刀塔傳奇英雄庫資料，致力於打最專業，最全的刀塔傳奇卡牌庫。';
        } else {
            $SEO['title'] = $catname.'卡牌庫_'.$catname.'英雄庫-魔方網';
            $SEO['keyword'] = $catname.'卡牌庫,'.$catname.'英雄庫,'.$catname;
            $SEO['description'] = $catname.'卡牌庫為魔方網玩家提供全面的'.$catname.'英雄庫資料，致力於打最專業，最全的'.$catname.'卡牌庫。';
        }

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();

        foreach($this->template_basic_set as $key => $val){
           $smarty->assign($key,$val);
        }

        $smarty->assign("SEO",$SEO);

        foreach($CARD as $key=>$val){
            $smarty->assign($key,$val);
        }
        $smarty->assign("type_array",$type_array);
        $smarty->assign("station_array",$station_array);
        $smarty->assign("attribute_array",$attribute_array);
        $smarty->assign("equipment_quality",$equipment_quality);
        $smarty->assign("equipment_type",$equipment_type);

        if($_GET['condition'] == 'hero'){
            $smarty->display('dotachuanqi/yx_index.tpl');
        } elseif ($_GET['condition'] == 'card_type') {
            $smarty->display('dotachuanqi/zb_index.tpl');
        }
        if($show_type == 1) {
            $smarty->display('tw_tyong/list_cardp.tpl');
        } else {
            $smarty->display('tw_tyong/list_cardl.tpl');
        }
    }

    /*
     * 卡牌數據庫詳情頁
     *
     */
    public function card_detail(){
        // 基礎數據
        $type_array = array('力量', '敏捷', '智力');
        $station_array = array('前排', '中排', '後排');
        $star_array = array('一星', '兩星', '三星', '四星', '五星');
        $attribute_array = array('肉盾', '輔助', '治療', '單控', '法傷', '群控', '輸出', '群傷', '沉默', '菜刀', '切後排', '負面狀態', '能量消除', '新手必備', '遠征必備', 'JJC必備', '藏寶地穴');
        // 加載卡牌數據庫
        $card_api = pc_base::load_config('api','card_api');
        if($_GET['condition'] == 'equipment'){
            $_GET['condition'] = 'card_type';
        }

        unset($_GET['m'],$_GET['c'],$_GET['a']);

        foreach($_GET as $k_sp=>$v_sp){
            if($k_sp == 'p'){
                $other_condition .= '/db_name/'.$v_sp;
                //unset($_GET['p']);
            }else{
                $other_condition .= '/'.$k_sp.'/'.$v_sp;
            }
        }
        $api_url = $card_api.'/getitemhtml'.$other_condition;
        if ($_GET['url']) {
            var_dump($api_url);
        }
        $item_info = mf_curl_get($api_url);
        $item_info = json_decode($item_info, true);

        if($item_info['code'] == 0) {
            $card_info = $item_info['data']['info'];
            $card_html = $item_info['data']['html'];
        } else {
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        // 數據處理
        if($_GET['condition'] == 'hero'){
            foreach($item_info['herodw'] as $key => $val) {
                $item_info['herodw'][$key] = array($val, $attribute_array[$val]);
            }
            $item_info['type'] = array('id'=>$item_info['type'], 'name'=>$type_array[$item_info['type']]);
            $item_info['csxj'] = $star_array[$item_info['csxj']];
            $item_info['zw'] = array('id'=>$item_info['zw'], 'name'=>$station_array[$item_info['zw']]);
        }

        // 數據賦值
        $CARD['card_info'] = $card_info;
        $CARD['card_html'] = $card_html;

		$temp_part_info = $this->db_partition->get_one('`domain_dir`="'.$_GET['p'].'"', 'catname');
		$catname = $temp_part_info['catname'];

        $SEO['title'] = $card_info['name'].'-'.$catname.'卡牌庫-魔方網';
        $SEO['keyword'] = $catname.'卡牌庫,'.$card_info['name'].','.$card_info['character'].','.$card_info['profession'];
        $SEO['description'] = $catname.'卡牌庫為魔方網玩家提供最全的'.$card_info['name'].'資料，玩家可以對'.$card_info['name'].'進行數據查詢和對比分析等相關操作。';

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();

        $smarty->assign("SEO",$SEO);

        foreach($this->template_basic_set as $key => $val){
           $smarty->assign($key,$val);
        }

        foreach($CARD as $key=>$val){
            $smarty->assign($key,$val);
        }

        if($_GET['condition'] == 'hero'){
            $smarty->display('dotachuanqi/yx_detail.tpl');
        } elseif ($_GET['condition'] == 'card_type') {
            $smarty->display('dotachuanqi/zb_detail.tpl');
        }

        $smarty->display('tw_tyong/show_card.tpl');
    }

    /**
      * 鎖鏈戰記新手專題
      * @author jozh liu
      */
    public function cczt(){
        include template('partition', 'cc_zt');
    }

	//列表頁
	public function lists() {
		$catid = $_GET['catid'] = intval($_GET['catid']);

		$_userid = $this->_userid;
		$_username = $this->_username;

		if(!$catid) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

		$temp_part_info = $this->db_partition->get_one('`catid`='.$catid, 'catname,arrparentid,setting');
		$catname = $temp_part_info['catname'];

		//SEO
        $setting = string2array($temp_part_info['setting']);
        $SEO = seo_info($_GET['p'], $catid);
        $SEO['title'] = empty($setting['meta_title']) ? $catname . '_魔方網' . $GLOBALS['part_name'] . '專區' : $setting['meta_title'];
        $SEO['keyword'] = !empty($setting['meta_keywords']) ? $setting['meta_keywords'] : '';
        $SEO['description'] = !empty($setting['meta_description']) ? $setting['meta_description'] : '';

		//define('STYLE',$setting['template_list']);
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;

		$template = $setting['category_template'] ? $setting['category_template'] : 'category';
		$template_list = $setting['list_template'] ? $setting['list_template'] : 'list';

		if($type==0) {
			$template = $child ? $template : $template_list;
			$arrparentid = explode(',', $arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
			$array_child = array();
			$self_array = explode(',', $arrchildid);
			//獲取一級欄目ids
			foreach ($self_array as $arr) {
				if($arr!=$catid && $CATEGORYS[$arr][parentid]==$catid) {
					$array_child[] = $arr;
				}
			}
			$arrchildid = implode(',', $array_child);

			$template_file = $GLOBALS['use_domain_dir'].'_list';
            //下面這段主針對爐石專區的
			if( strstr($temp_part_info['arrparentid'], '241') || $catid==241 || strstr($temp_part_info['arrparentid'], '242') || $catid==242 ){
				$template_file = $GLOBALS['use_domain_dir'].'_video';
			}

			//新模板規則
			$template_info = string2array($temp_part_info['setting']);
			if( !$template_info['template_list'] ){//老專區不適用新規則
                if($template_info['list_template']&&$template_info['list_template']!='請選擇'){//勾選
                    $template_file =  $template_info['list_template'];
                }else if($template_info['list_template']=='請選擇'){//通用模板
                    $template_file = $template_file;
                }
			}
            //通用模板設置
            extract($this->template_basic_set);

            if($this->is_general_template){//通用模板

                require(PC_PATH."init/smarty.php");

                if($this->is_new_template !=0 || $_GET['new_tpl'] == 1 || $GLOBALS['wap_setting']['new_template'] == 1) {
                    $smarty = use_v4();
                } else {
                    $smarty = use_v3();
                }
                $smarty->assign("SEO",$SEO);
                $smarty->assign("wap_url",$this->wap_url);

                if ($_GET['test']=='mobile') {
                    $smarty->assign("part_name",$GLOBALS['part_name']);
                    
                    foreach($this->template_basic_set as $key => $val){
                        $smarty->assign($key,$val);
                    }
                    foreach($GLOBALS['wap_setting'] as $key=>$val){
                        $smarty->assign($key,$val);
                    }
                    $smarty->assign("catname",$catname);
                    $smarty->display('mobile/tyong/list.tpl');
                } elseif(($_GET['wap'] == 1) || (is_wap()||is_mobile()||isMobile()) && $this->is_mobile_template){
                    $smarty->assign("part_name",$GLOBALS['part_name']);

                    foreach($this->template_basic_set as $key => $val){
                        $smarty->assign($key,$val);
                    }
                    foreach($GLOBALS['wap_setting'] as $key=>$val){
                        $smarty->assign($key,$val);
                    }
                    $smarty->assign("catname",$catname);

                    //內嵌效果程序,渲染完以後停止向下執行 
                    if( !empty($neiqian_list['list']['partid']) && $neiqian_list['list']['partid']==$catid){
                        // 字体与高端按终端匹配
                        $font = explode('|',$neiqian_list['list']['font']);
                        $height = explode('|',$neiqian_list['list']['height']);
                        $neiqian_list['list']['font'] = $font[1]?:$font[0];
                        $neiqian_list['list']['height'] = $height[1]?:$height[0];

                        $smarty->assign("neiqian_list",$neiqian_list);
                        $smarty->display('tyong/neiqian.tpl');
                        exit();
                    }

                    if($GLOBALS['wap_setting']['new_template'] == 1) {
                        $smarty->display('twm_tyong/new_edition/list.tpl');
                    } elseif($this->is_new_template == 0) {
                        $smarty->display('mobile/tyong/list.tpl');
                    } elseif($this->is_new_template==2 && !empty($tem_new_list_2m) && $smarty->templateExists($tem_new_list_2m)) {
                        $smarty->display($tem_new_list_2m);
                    } else {
                        $smarty->display('twm_tyong/list.tpl');
                    }
                }else{//通用模板

                    //浮窗功能
                    /*$smarty->assign('floating_url',$this->floating_url);
                    if($this->partition_setting['is_partition']){
                        $smarty->assign('is_partition',1);
                    }else{
                        $smarty->assign('is_partition',0);
                    } */ 

                    $smarty->assign("info_part_id", (string)$catid);
                    $smarty->assign("module_setting",$GLOBALS['module_setting']);
                    $smarty->assign("module_setting_type",$GLOBALS['module_setting_type']);

                    foreach($this->template_basic_set as $key => $val ){
                        $smarty->assign($key,$val);
                    }

                    //內嵌效果程序,渲染完以後停止向下執行 
                    if( !empty($neiqian_list['list']['partid']) && $neiqian_list['list']['partid']==$catid){
                        // 字体与高端按终端匹配
                        $font = explode('|',$neiqian_list['list']['font']);
                        $height = explode('|',$neiqian_list['list']['height']);
                        $neiqian_list['list']['font'] = $font[0];
                        $neiqian_list['list']['height'] = $height[0];

                        $smarty->assign("neiqian_list",$neiqian_list);
                        $smarty->display('tyong/neiqian.tpl');
                        exit();
                    }

                    //專區測試模版選擇 
                    if($this->is_ptest==1){

                        /*
                            通過函數處理頁面的js css等鏈接
                        */
                        $return_content = $this->get_partition_content($smarty, $_GET['p'],$tem_new_test_list);
                        echo $return_content; 
                        exit();
                    }

                    //$template_info 為當前欄目所模版配置
                    if($this->is_new_template==1){
                        /*if($template_info['template_type']==1 && !empty($template_info['tem_new']['list'])){
                            //當前欄目有獨立的列表頁模版配置 
                            $smarty->display($template_info['tem_new']['list']); 
                        }else{
                            //本欄目沒有設置模版，沿用專區通用的模版設置
                            $smarty->display($tem_new_list); 
                        }*/
                        $smarty->display('tw_tyong/list.tpl');
                    }elseif($this->is_new_template==2 && !empty($tem_new_list_2)){
                        //自定義模版,如果當前欄目又重新定義了列表頁的模版，則渲染定的模版，如果沒有填寫，則沿用專區通用的列表頁。 
                        //$new_list_tpl = $template_info['tem_new_2']['list'] ? $template_info['tem_new_2']['list'] : $tem_new_list_2; 
                        //$smarty->display($this->ptest_dir.'/partition/'.$_GET['p'].'/'.$new_list_tpl);
                        $cont_type_re = $this->db_partition->get_one('`catid`='.$catid, 'cont_type');
                        $cont_type = $cont_type_re['cont_type'];

                        if($cont_type == 3) {
                            $tpl = strtolower('twz_'.$this->domain_dir.'/list_card.tpl');
                            if($smarty->templateExists($tpl)) {
                                $smarty->display($tpl); 
                                exit;
                            }
                        } elseif($cont_type == 6) {
                            $tpl = strtolower('twz_'.$this->domain_dir.'/list_team.tpl');
                            if($smarty->templateExists($tpl)) {
                                $smarty->display($tpl); 
                                exit;
                            }
                        }
                        //文章類型
                        $smarty->display($tem_new_list_2); 
                    }else{
                        //選擇通用模版
                        $temp_sign = strpos($this->template_basic_set['partition_type'], '_new');
                        if ($temp_sign) {
                            $smarty->display('tongyong_template/list.tpl'); // 新通用模版
                        } else {
                            $smarty->display('tyong/list.tpl');
                        }
                    }
                }
            } else {
                $template_file = $GLOBALS['use_domain_dir'].'_list';
                include template('partition', $template_file);
            }
        }
	}

    public function neiqian(){
		$catid = $_GET['catid'] = intval($_GET['catid']);
		$_userid = $this->_userid;
		$_username = $this->_username;

		if(!$catid) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

		$temp_part_info = $this->db_partition->get_one('`catid`='.$catid, 'catname,arrparentid,setting');
		$catname = $temp_part_info['catname'];

		//SEO
        $setting = string2array($temp_part_info['setting']);

        extract($this->template_basic_set);
        require(PC_PATH."init/smarty.php");
        $smarty = use_v3();
        $smarty->assign("SEO",$SEO);

        $smarty->display($setting['tem_new']['list']);
    }

	public function ajax_content_item(){
		$id = intval($_GET['id']);
		$this->db_content->set_model(1);
		$this->db_content->table_name .= '_data';
		$temp_content = $this->db_content->get_one('`id`='.$id, 'content');
		echo $temp_content['content'];
	}

	/*
	 * ajax獲取內容列表
	 *
	 **/
	public function content_json_list(){
		$currpage = $_GET['currpage'] ? $_GET['currpage'] : 1;
		$pagenum = $_GET['pagenum'] ? $_GET['pagenum'] : 30;

		$date_format = $_GET['date_format'] ? intval($_GET['date_format']) : 1;

        if(strpos($_GET['partid'], ',')) {
		    $temp_arrchildid = $this->db_partition->get_one('`catid` IN ('.$_GET['partid'].')', 'arrchildid');
        } else {
		    $temp_arrchildid = $this->db_partition->get_one('`catid`='.$_GET['partid'], 'arrchildid');
        }
		$part_info_ids = $this->db_partition_game->listinfo('`part_id` IN ('.$temp_arrchildid['arrchildid'].')', '`inputtime` DESC,`listorder` DESC', $currpage, $pagenum);
		$content_total = $this->db_partition_game->count('`part_id` IN ('.$temp_arrchildid['arrchildid'].')');
		$part_info_array = array();
		foreach( $part_info_ids as $key=>$value ){
			$this->db_content->set_model($value['modelid']);
			$temp1 = $this->db_content->get_one('`id`='.$value['gameid']);
            switch( $date_format ){
                case 1:
			        $temp1['inputtime'] = date('Y-m-d H:i:s', $temp1['inputtime']);
                case 2:
			        $temp1['inputtime'] = date('m-d', $temp1['inputtime']);
                case 3:
                    $weekarray=array("日","一","二","三","四","五","六");
			        $temp1['inputtime'] = date('Y/m/d', $temp1['inputtime']).'('.$weekarray[date("w", strtotime($inputtime))].')';
            }
			$temp1['url'] = get_info_url($temp1['catid'],$temp1['id']);
			$this->db_content->table_name .= '_data';
			$temp2 = $this->db_content->get_one('`id`='.$value['gameid']);

			$part_info_array[] = array_merge($temp1, $temp2);
		}
		$part_info_array_end['count_all'] = $content_total;
		$part_info_array_end['contents'] = $part_info_array;

        $callback = $_GET['callback'];
        $response = json_encode($part_info_array_end);

        // jsonp 調用,360靜態頁面時增加
        if (isset($callback)) {
            $response = $callback."(".$response.");";
        }
        echo $response;
	}

	/*
	 * ajax 獲取圖鑑子分類列表
	 *
	 */
	public function get_tujian_list(){
		$currpage = $_POST['currpage'] ? $_POST['currpage'] : 1;
		$pagenum = $_POST['pagenum'] ? $_POST['pagenum'] : 30;

		$date_format = $_POST['date_format'] ? intval($_POST['date_format']) : 1;

		$temp_arrchildid = $this->db_partition->get_one('`catid`='.$_POST['partid'], 'arrchildid');
		$part_info_ids = $this->db_partition_game->listinfo('`part_id` IN ('.$temp_arrchildid['arrchildid'].')', '`inputtime` DESC,`listorder` DESC', $currpage, $pagenum);
		$content_total = $this->db_partition_game->count('`part_id` IN ('.$temp_arrchildid['arrchildid'].')');
		$part_info_array = array();
		foreach( $part_info_ids as $key=>$value ){
			$this->db_content->set_model($value['modelid']);
			$temp1 = $this->db_content->get_one('`id`='.$value['gameid']);
            switch( $date_format ){
                case 1:
			        $temp1['inputtime'] = date('Y-m-d H:i:s', $temp1['inputtime']);
                case 2:
			        $temp1['inputtime'] = date('m-d', $temp1['inputtime']);
            }
			$temp1['url'] = get_info_url($temp1['catid'],$temp1['id']);
			$this->db_content->table_name .= '_data';
			$temp2 = $this->db_content->get_one('`id`='.$value['gameid']);

			$part_info_array[] = array_merge($temp1, $temp2);
		}
		$part_info_array_end['count_all'] = $content_total;
		$part_info_array_end['contents'] = $part_info_array;

        $callback = $_GET['callback'];
        $response = json_encode($part_info_array_end);

        // jsonp 調用,360靜態頁面時增加
        if (isset($callback)) {
            $response = $callback."(".$response.");";
        }
        echo $response;
	}

	//JSON 輸出
	public function json_list() {
		if($_GET['type']=='keyword' && $_GET['modelid'] && $_GET['keywords']) {
		//根據關鍵字搜索
			$modelid = intval($_GET['modelid']);
			$id = intval($_GET['id']);

			$MODEL = getcache('model','commons');
			if(isset($MODEL[$modelid])) {
				$keywords = safe_replace(htmlspecialchars($_GET['keywords']));
				$keywords = addslashes(iconv('utf-8','gbk',$keywords));
				$this->db->set_model($modelid);
				$result = $this->db->select("keywords LIKE '%$keywords%'",'id,title,url',10);
				if(!empty($result)) {
					$data = array();
					foreach($result as $rs) {
						if($rs['id']==$id) continue;
						if(CHARSET=='gbk') {
							foreach($rs as $key=>$r) {
								$rs[$key] = iconv('gbk','utf-8',$r);
							}
						}
						$data[] = $rs;
					}
					if(count($data)==0) exit('0');
					echo json_encode($data);
				} else {
					//沒有數據
					exit('0');
				}
			}
		}

	}
    public function solr(){
        //搜索配置
        $search_setting = getcache('search');
        $setting = $search_setting[$siteid];

        $solr = pc_base::load_app_class('apache_solr_service', 'search', 1);
        $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);

        //連接服務器
        if (!$solr->ping()) {
            $totalnums = $status = 0;
            include template('search','index');
            exit;
        }
    }

    //圖鑑調用配套模版 
    public function tujian_detail(){
        $catid = intval($_GET['catid']);
        require(PC_PATH."init/smarty.php");
        $smarty = use_v3();
        // SEO yx
        $yx['title'] = '刀塔傳奇%card%英雄圖鑑';
        $yx['keyword'] = '%card%初始屬性,%card%屬性成長,%card%技能,%card%裝備,%card%怎麼獲得';
        $yx['description'] = '魔方網刀塔傳奇數據庫為玩家提供%card%英雄相關基礎資料、初始屬性、屬性成長、英雄技能、英雄裝備及怎麼獲得等圖鑑,更多其他英雄圖鑑請搜索查詢。';
        // SEO zb
        $zb['title'] = '刀塔傳奇%card%裝備圖鑑';
        $zb['keyword'] = '%card%屬性,%card%合成公式,%card%怎麼獲得';
        $zb['description'] = '魔方網刀塔傳奇數據庫為玩家提供%card%裝備相關基礎資料、合成公式、可裝備英雄及獲得途徑怎麼獲得方法等圖鑑,更多其他裝備圖鑑請搜索查詢。';
        $file = './phpcms/templates/v4/dtcq/yxtj/' . $catid . '.tpl';
        if(file_exists($file)) {
            // 判斷靜態頁是否存在
            $content = file_get_contents($file);
            preg_match('/刀塔傳奇(.*?)(.{6})圖鑑/i', $content,  $match);
            // 根據類型加載不同seo信息
            if($match[2] == '英雄') {
                $smarty->assign("SEO",$yx);
            } else {
                $smarty->assign("SEO",$zb);
            }
            // 渲染模板
            $smarty->assign("tpl_id",$catid);
            $html = $smarty->fetch('dotachuanqi/tujian_detail.tpl');
            // seo個性信息替換
            $html = preg_replace('/%card%/i', $match[1], $html);
            // 輸出頁面
            echo $html;
        } else {
			header('HTTP/1.0 404 Not Found');
			exit();
        }
    }

    //浮窗
    public function floating(){
        require(PC_PATH."init/smarty.php");
        $smarty = use_v3();
        $partition_setting = getcache('partition','commons');
        if($partition_setting['is_partition']==1){
            foreach($partition_setting as $key => $val){
                $smarty->assign($key,$val);
            }
        }
        $smarty->display('popup_box/index.tpl'); // 通用模版
    }

    //返回處理過 - 自定義模版內容
    public function get_partition_content($smarty,$p,$tpl){
        // 此處不需要重新定義smarty 
        $pp = "/statics/s_test/partition/".$p;
        $smarty->assign('pp',$pp);
        $content = $smarty->fetch($this->ptest_dir.'/partition/'.$p.'/'.$tpl);
        $module = "partition/".$GLOBALS['use_domain_dir'];
        $base_path = "/statics/s_test/".$module;
        $source = PHPCMS_PATH.'statics/s_test';
        preg_match_all('/((\.\.|\.)\/(img|css|js|images)\/.*\.(js|css|jpg|png|gif|swf|htc))/i',$content,$matches);
        $files = $matches[1];
        foreach ($files as $file) {
            $s_file = str_replace(array("../","./"),"",$file);
            $resource_filename = $source."/".$module."/".$s_file;
            if(!file_exists($resource_filename)){
                continue;
            }
            $pos_num = strripos($s_file,'.');
            $ext = substr($s_file, $pos_num);//取出文件 後綴
            $first = substr($s_file, 0,$pos_num);//取出文件 後綴
            $s = $base_path."/".$first.$ext;  
            $content = str_replace(array($file),$s,$content);
        }
        return $content;
    }

    /**
     *
     */
	public function search() {
		$GLOBALS['use_domain_dir'] = $_GET['p'];
        $partition_name = $GLOBALS['part_name']; //當前的part名字
		$SEO = seo_info($_GET['p']);
        //通用模板設置
        extract($this->template_basic_set);
		$template_file = $GLOBALS['use_domain_dir'].'_index';

        $partition_info = $this->db_partition->get_one("`domain_dir`='".$_GET['p']."'");

        //專區名
        $GLOBALS['part_name'] = $partition_info['catname'];
        $GLOBALS['part_id'] = $partition_info['catid'];
        $GLOBALS['part_dir'] = $partition_info['domain_dir'];

        //需增加按listorder排序處理
        $tem_setting = string2array($partition_info['setting']);

        //新專區模板
        $this->is_mobile_template = $tem_setting['is_mobile_template'];
        $this->is_new_template = $tem_setting['template_type'];
        $GLOBALS['tem_new'] = $tem_setting['tem_new'];
        $GLOBALS['tem_new_2'] = $tem_setting['tem_new_2'];// 自定義模版配置
    	$GLOBALS['tem_new_test'] = $tem_setting['tem_new_test'];// 自定義模版配置

        $GLOBALS['tem_setting'] = $tem_setting['tem_setting'];
        $GLOBALS['wap_setting'] = $tem_setting['wap_setting'];

        $GLOBALS['is_search'] = $tem_setting['is_search'];
        $GLOBALS['search_code'] = $tem_setting['search_code'];

		require(PC_PATH."init/smarty.php");
        if($this->is_new_template !=0) {
            $smarty = use_v4();
        } else {
            $smarty = use_v3();
        }

        //浮窗功能
        /*$smarty->assign('floating_url',$this->floating_url);
        if($this->partition_setting['is_partition']){
            $smarty->assign('is_partition',1);
        }else{
            $smarty->assign('is_partition',0);
        } */ 
        foreach($this->template_basic_set as $key => $val){
            $smarty->assign($key,$val);
        }
        
        $smarty->assign("module_setting",$GLOBALS['module_setting']);
        $smarty->assign("partition_name",$partition_name);
        $smarty->assign("SEO",$SEO);
        $smarty->assign("wap_url",$this->wap_url);

        if($this->is_new_template == 0){ //smarty模板
            $smarty->display('tyong/search.tpl');
        } else {
            if($this->is_new_template == 1) {
                    $template_name = 'tw_tyong';
            } else {
                $template_arr = explode('/', $GLOBALS['tem_new_2']['index']);
                if(is_array($template_arr)) {
                    $template_name = $template_arr[0];
                }
            }
            $smarty->display($template_name.'/search.tpl');
        }
    }

}
?>
