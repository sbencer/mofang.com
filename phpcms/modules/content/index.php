<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型緩存路徑
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
pc_base::load_app_func('util','content');
pc_base::load_sys_class('form', '', 0);
class index {
    private $db;
    function __construct() {

        $this->db = pc_base::load_model('content_model');
        $this->daily_db = pc_base::load_model('staticstics_model');
        $this->_userid = param::get_cookie('_userid');
        $this->_username = param::get_cookie('_username');
        $this->_groupid = param::get_cookie('_groupid');

        // 檢測手機端並跳轉
        if ($_GET['a'] != 'ajax_lists' && $_GET['test'] !='mobile' && $_GET['comefrom'] != 'mofangapp') {
           $this->check_mobile();
        }
        
        $this->wap_url = wap_url("http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");

        $this->_cached_action = array('init', 'lists', 'show', 'iosgames','ajax_lists');

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
                $html = preg_replace('/pic([0,1,2])\.mofang.com\//i','pic$1.mofang.com.tw/',$html);
                $html = preg_replace('/sts([0,1,2])\.mofang.com\//i','sts$1.mofang.com.tw/',$html);
                echo $html;
                exit();
            }
            $this->_ob_started = 1;
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
            setcache($this->_cache_key, $html, '', 'memcache', 'html', 1800);
            delcache($this->_cache_lock_key, '', 'memcache', 'html');
        }
        if ($this->_ob_started) {
            ob_end_clean();
        }

        $html = preg_replace('/pic([0,1,2])\.mofang.com\//i','pic$1.mofang.com.tw/',$html);
        $html = preg_replace('/sts([0,1,2])\.mofang.com\//i','sts$1.mofang.com.tw/',$html);
        echo $html;
    }

    //首頁
    public function init() {
        if(isset($_GET['siteid'])) {
            $siteid = intval($_GET['siteid']);
        } else {
            $siteid = 1;
        }
        $siteid = $GLOBALS['siteid'] = max($siteid,1);
        define('SITEID', $siteid);
        $_userid = $this->_userid;
        $_username = $this->_username;
        $_groupid = $this->_groupid;
        $sitelist  = getcache('sitelist','commons');
        //SEO
        $site = $sitelist[$siteid];
        $SEO['site_title'] = isset($site['site_title']) && !empty($site['site_title']) ? $site['site_title'] : $site['name'];
        $SEO['keyword'] = $site['keywords'];
        $SEO['description'] = $site['description'];
        $default_style = $sitelist[$siteid]['default_style'];
        $CATEGORYS = getcache('category_content_'.$siteid,'commons');
        $is_index = true;

        require(PC_PATH."init/smarty.php");
        
        if($_GET['format'] == 'json') {
            include template('content','index_json',$default_style);
        } elseif ( is_mobile() || is_wap() || $_GET['wap']) {  
            $smarty = use_v4();
            $smarty->assign("SEO",$SEO);
            $smarty->display('wap_tw/index.tpl');
        } else {
            $smarty = use_v4();
            $smarty->assign("SEO",$SEO);
            $smarty->assign("wap_url",$this->wap_url);

            //$smarty->display('tw_mofang/index.tpl');
            
           
             
             //判斷是「直播廣場」and「推薦欄位是：隱藏區塊」
             $pdmdb = pc_base::load_model('position_data_model');
             $num_rows = $pdmdb->get_one(array('catid'=>"10000296", "posid"=>"10000013"));
         			if($num_rows == "")
         				$smarty->assign("show_video_class","show_class");  //顯示
         			else
         				$smarty->assign("show_video_class","hide_class"); //不顯示

            $smarty->display('tw_mofang/v4/index.tpl'); //by sbencer
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
        $_groupid = $this->_groupid;

        $page = intval($_GET['page']);
        $page = max($page,1);
        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$catid];
        $CATEGORYS = getcache('category_content_'.$siteid,'commons');

        if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
        $this->category = $CAT = $CATEGORYS[$catid];
        $this->category_setting = $CAT['setting'] = string2array($this->category['setting']);
        $siteid = $GLOBALS['siteid'] = $CAT['siteid'];

        $MODEL = getcache('model','commons');
        extract($CAT);

        // 檢查文章是否屬於專區，如果屬於專區，直接跳轉到專區
        if (!is_wap() && !is_mobile()  && !$_GET['format'] == 'json' && empty($_GET['from'])) {
            $pgdb = pc_base::load_model('partition_games_model');
            $part_id = $pgdb->get_one(array('modelid'=>$modelid, "gameid"=>$id));
            if ($part_id) {
                $pdb = pc_base::load_model('partition_model');
                $ret = $pdb->get_one(array('catid'=>$part_id['part_id']));
                $part_parentids = explode(',', $ret['arrparentid']);
                $topid = $part_parentids[1];
                if ($pdb->is_online($topid) && $catid!=134 && $catid!=20) {
                    $part_info_url = $pdb->get_info_url($catid, $id, $topid);
                    // 攻略助手专区跳转保留模板参数
                    if($_GET['comefrom']=='mofangapp'){
                        if($_GET['style']==2){
                            $part_info_url = $part_info_url."?comefrom=mofangapp&wap=1&style=2";
                        }else{
                            $part_info_url = $part_info_url."?comefrom=mofangapp&wap=1&style=1";
                        }
                    }
                    header('HTTP/1.0 301');
                    header('Location: '.$part_info_url);
                    exit;
                }
            }
        }

        $tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
        $r = $this->db->get_one(array('id'=>$id));
        if(!$r || $r['status'] != 99) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

        $this->db->table_name = $tablename.'_data';
        $r2 = $this->db->get_one(array('id'=>$id));
        $rs = $r2 ? array_merge($r,$r2) : $r;

        //再次重新賦值，以數據庫為準
        $catid = $CATEGORYS[$r['catid']]['catid'];
        $modelid = $CATEGORYS[$catid]['modelid'];

        require_once CACHE_MODEL_PATH.'content_output.class.php';
        $content_output = new content_output($modelid,$catid,$CATEGORYS);
        $data = $content_output->get($rs);
        extract($data);

        //檢查文章會員組權限
        if($groupids_view && is_array($groupids_view) && 1==2 ) { //by sbnecer，暫時強制跳離
        		//by Sbencer 不曉得為什麼要取cookie的groupid
            $_groupid = param::get_cookie('_groupid');
            $_groupid = intval($_groupid);
            if(!$_groupid) {
                $forward = urlencode(get_url());
                showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
            }
            if(!in_array($_groupid,$groupids_view)) showmessage(L('no_priv'));
        } else {
            //根據欄目訪問權限判斷權限
            $_priv_data = $this->_category_priv($catid);
            if($_priv_data=='-1') {
                $forward = urlencode(get_url());
                showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
            } elseif($_priv_data=='-2') {
                showmessage(L('no_priv'));
            }
        }
        if(module_exists('comment')) {
            $allow_comment = isset($allow_comment) ? $allow_comment : 1;
        } else {
            $allow_comment = 0;
        }
        
        //閱讀收費 類型
        $paytype = $rs['paytype'];
        $readpoint = $rs['readpoint'];
        $allow_visitor = 1;
        if($readpoint || $this->category_setting['defaultchargepoint']) {
            if(!$readpoint) {
                $readpoint = $this->category_setting['defaultchargepoint'];
                $paytype = $this->category_setting['paytype'];
            }

            //檢查是否支付過
            $allow_visitor = self::_check_payment($catid.'_'.$id,$paytype);
            if(!$allow_visitor) {
                $http_referer = urlencode(get_url());
                $allow_visitor = sys_auth($catid.'_'.$id.'|'.$readpoint.'|'.$paytype).'&http_referer='.$http_referer;
            } else {
                $allow_visitor = 1;
            }
        }

        //URL規則
        $show_ruleid = $CAT['show_ruleid'];
        $urlrules = getcache('urlrules','commons');
        $urlrules = str_replace('|', '~',$urlrules[$show_ruleid]);
        $tmp_urls = explode('~',$urlrules);
        $tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
        preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
        if(!empty($_urls[1])) {
            foreach($_urls[1] as $_v) {
                $GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
            }
        }
        define('URLRULE', $urlrules);
        $GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
        $GLOBALS['URL_ARRAY']['catdir'] = $catdir;
        $GLOBALS['URL_ARRAY']['catid'] = $catid;

        //最頂級欄目ID
        $arrparentid = explode(',', $CAT['arrparentid']);
        $top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;

        $template = $template ? $template : $CAT['setting']['show_template'];
        if(!$template) $template = 'show';
        
        $template = "v4/article"; //by Sbencer

        $template_m = $template_m ? $template_m : $CAT['setting']['show_m_template'];
        if(!$template_m) $template_m = '';

        define('STYLE',$CAT['setting']['template_list']);
        if(isset($rs['paginationtype'])) {
            $paginationtype = $rs['paginationtype'];
            $maxcharperpage = $rs['maxcharperpage'];
        }
        $pages = $titles = '';
        if($rs['paginationtype']==1) {
            //自動分頁
            if($maxcharperpage < 10) $maxcharperpage = 500;
            $contentpage = pc_base::load_app_class('contentpage');
            $content = $contentpage->get_data($content,$maxcharperpage);
        }
        if($rs['paginationtype']!=0) {
            //手動分頁
            $CONTENT_POS = strpos($content, '[page]');
            if($CONTENT_POS !== false) {
                $this->url = pc_base::load_app_class('url', 'content');

                $contents = array_filter(explode('[page]', $content));
                $pagenumber = count($contents);
                //文章開頭有[page]時，頁碼-1
                if ($CONTENT_POS<7) {
                    $pagenumber--;
                }
                //當有子標題時，根據[/page]計算頁碼數
                if (strpos($content, '[/page]')!==false) {
                    $pagenumber = substr_count($content, '[/page]');
                }

                for($i=1; $i<=$pagenumber; $i++) {
                    $pageurls[$i] = $this->url->show($id, $i, $catid, $rs['inputtime']);
                }

                $END_POS = strpos($content, '[/page]');
                if($END_POS !== false) {
                    if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
                        foreach($m[1] as $k=>$v) {
                            $p = $k+1;
                            $titles[$p]['title'] = strip_tags($v);
                            $titles[$p]['url'] = $pageurls[$p][0];
                        }
                    }
                }
                //如果編輯有插入輪播圖ID的話執行===>>
                $is_find = strpos($content, "[/img_ids]");
                if($is_find !== false) {
                    if(preg_match_all("|\[img_ids\](.*)\[/img_ids\]|U", $content, $m, PREG_PATTERN_ORDER)) {
                     foreach($m[1] as $k=>$v) {
                            $p = $k+1;
                            $imgs[$p]['title'] = strip_tags($v);
                            $imgs[$p]['url'] = $pageurls[$p][0];
                        }
                       if(!empty($imgs[1]['title'])){
                           $imgs = explode(",", $imgs[1]['title']);// 獲取輪播圖庫ID
                           $imgs_new_data = get_tuji_data($imgs);
                       };
                    }
                    
                }
                //<<===獲取結束
                

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
                    $content = explode('[/page]', $content);

                    $content = trim($content[1]);
                    if(strpos($content,'</p>')===0) {
                        $content = '<p>'.$content;
                    }
                    if(stripos($content,'<p>')===0) {
                        $content = $content.'</p>';
                    }
                }
            }
        }else{
		  //如果編輯有插入輪播圖ID的話執行===>>
                $is_find = strpos($content, "[/img_ids]");
                if($is_find !== false) {
                    if(preg_match_all("|\[img_ids\](.*)\[/img_ids\]|U", $content, $m, PREG_PATTERN_ORDER)) {
                     foreach($m[1] as $k=>$v) {
                            $p = $k+1;
                            $imgs[$p]['title'] = strip_tags($v);
                            $imgs[$p]['url'] = $pageurls[$p][0];
                        }
                       if(!empty($imgs[1]['title'])){
                           $imgs = explode(",", $imgs[1]['title']);// 獲取輪播圖庫ID
                           $imgs_new_data = get_tuji_data($imgs);
                       };
                    }
                    
                }
                //<<===獲取結束
		}
        $content = preg_replace("|\[page](.*)\[/page\]|U",'',$content);
        $content = preg_replace("|\[img_ids](.*)\[/img_ids\]|U",'',$content); //去掉內容頁的傳入的id 

        $full_content = $contents?join('', $contents):$content;
        //SEO
        $seo_keywords = '';

        if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
        $SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
        $site_title = '魔方遊戲網';
        $SEO['title'] = $title . '-' . $this->category['catname'] . '-' . $site_title;

        $this->db->table_name = $tablename;
        //上一頁
        $previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
        //下一頁
        $next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99");

        if(empty($previous_page)) {
            $previous_page = array('title'=>L('first_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page').'\');');
        }

        if(empty($next_page)) {
            $next_page = array('title'=>L('last_page'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page').'\');');
        }

        require(PC_PATH."init/smarty.php");
        if ($_GET['format'] == 'json') {
            echo json_encode($data);
        } elseif (is_mobile()) {
            if ($this->category['modelid'] == '11') {
                include template('content','html5_video');
            } elseif ($this->category['modelid'] == '26') {
                include template('content','html5_pics_review', 'ios');
            } else {
                if (!empty($template_m)) {
                    include template('mobile',$template_m);
                } else {
                    include template('content','html5');
                }
            }
       } elseif (is_wap() || $_GET['wap'] == 1) {

            $smarty = use_v4();
            $smarty->assign("SEO",$SEO);

            $cont_info = array_merge($CATEGORYS[$catid], $rs, $data);

            // 數據處理
            if(!empty($cont_info['relation_game'])) $cont_info['relation_game'] = explode("|", $cont_info['relation_game']);// 關聯遊戲
            $cont_info['keywords'] = keyword_arr($cont_info['keywords'],0,3);// 關鍵字 by jozh
            // $cont_info['content'] = $this->_keylinks($cont_info['content']); // 關聯標簽的處理 by wangguanqing
            $cont_info['full_content'] = $cont_info['content'] = preg_replace("/alt=\".*?\"/i","alt=\"$title\" title=\"$title\"",$cont_info['content']);// 圖片alt的處理 by wangguanqing

            // 基礎數據
            foreach ($cont_info as $_k=>$_v) {
                $smarty->assign("$_k", $_v);
            }

            $smarty->assign("youtubeid",$youtube_id);
            
            if ($modelid == '11') {
                $video_o = array('v17173_id', 'vqq_id', 'tudou_id', 'v56_id', 'youkuid', 'letv_id',);
                foreach ($video_o as $_k=>$_v) {
                    $smarty->assign("$_v", $$_v);
                }
            }

            //有此字段，則顯示關聯遊戲
            if(!empty($rs['relation_game'])){
                $relation_game = explode("|", $rs['relation_game']);
                $smarty->assign("relation_game_array",$relation_game);
            }
            $smarty->assign("comment_article_url",$comment_article_url);
            //內容
            $smarty->assign("content",$content);
            // 閱讀章節
            $smarty->assign("titles",$titles);
            // 內容分頁
            $smarty->assign("pages",$pages);
            // 當前頁碼
            $smarty->assign("pagenumber",$pagenumber);
            // 上一頁下一頁
            $smarty->assign("previous_page",$previous_page);
            
            $my_wap =true;
            $smarty->assign("my_wap",$my_wap);
            $smarty->assign("description",$rs['description']);

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
                if ($modelid == '1') {
                    $smarty->display('wap_tw/show_article.tpl');
                } elseif ($modelid == '3') {
                    $smarty->display('wap_tw/photo_detail.tpl');
                } elseif ($modelid == '11' || $modelid == '17') {
                    $smarty->display('wap_tw/show_video.tpl');
                } else {
                    $smarty->display('wap_tw/details.tpl');
                }
            }
        } else {
            $smarty = use_v4();

            //SEO信息赋值SEO
            $smarty->assign("SEO",$SEO);
            //栏目配置赋值
            $smarty->assign($CAT);
            //基本信息赋值(数据库值)
            $smarty->assign($rs);
            //基本信息赋值(output处理)
            $smarty->assign($data);
            
            $smarty->assign("wap_url",$this->wap_url);
            $smarty->assign('top_parentid',$top_parentid);

            $smarty->assign("imgs_new_data",$imgs_new_data);
            //分页相關
            $smarty->assign("content",$content);
            $smarty->assign("pagenumber",$pagenumber);
            $smarty->assign("titles",$titles);
            //圖文相關
            $smarty->assign("pics",$pics);
            $smarty->assign("tags",$tags);
            $smarty->assign("full_content",$full_content);
            $smarty->assign("pages",$pages);
            $smarty->assign("previous_page",$previous_page);
            $smarty->assign("next_page",$next_page);
            $smarty->assign("relate_article_array",$relate_article_array);
            $smarty->assign("allow_comment",$allow_comment);
				
						

            //判斷是否有勾選「限制級」 by sbencer 
            if($groupids_view[0] == 9)
            	$smarty->assign("restricted","show_class");
            else
            	$smarty->assign("restricted","hide_class");
                
                
            //有此字段，則顯示關聯遊戲
            if(!empty($rs['relation_game'])){
                $relation_game = explode("|", $rs['relation_game']);
                $smarty->assign("relation_game_array",$relation_game);
            }
            
            //增加對關聯鏈接/圖片ALT的處理 @wangguanqing 
            /*$content = $this->_keylinks($content); 
            $content = preg_replace("/alt=\".*?\"/i","alt=\"$title\"",$content);
            $smarty->assign("content",$content);
            $smarty->assign("template",$template);
            $smarty->assign("siteid",$siteid);
            */
	
	
            //$templates = STYLE.DIRECTORY_SEPARATOR.$template.'.tpl';
            //強制都使用tw_mofang by sbencer
            $templates = "tw_mofang/" .$template.'.tpl';
       
            
            if($smarty->templateExists($templates)) {
                header('new_tpl:true');
                $smarty->display($templates);
                return;
            }

            // 模版名称对应关系
            $v4 = array(
                'show_pingce'=>'show_pingce_news',
                'show_moke'=>'show_moke',
                'show_www_news'=>'show',
                'show_ios_news'=>'show',
                'show_android_news'=>'show',
                'show_chanye_news'=>'show',
                'show_video'=>'show_video',
                'show'=>'show',
                'show_picture'=>'show',
            );
            if (true) {
                $test_v4 = array(
                    'show_pic_content'=>'details',
                    'show_sycp'=>'pingce',
                );
                $v4 = array_merge($v4, $test_v4);
            }
            if (array_key_exists($template, $v4)) {
                if ($template != 'show_pic_content') {
                    $template = $v4[$template];
                    $smarty->display('tw_mofang/'.$template.'.tpl');
                } elseif (true) {
                    $smarty->display('picture/details.tpl');
                }
            } else {
                include template('content',$template);
            }
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
        //  if($keywords) $keywords = strpos(',',$keywords) === false ? explode(' ',$keywords) : explode(',',$keywords);
        // if($link_mode && !empty($keywords)) { 
        //     foreach($keywords as $keyword) {
        //         $linkdatas[] = $keyword;
        //     }
        // } else {
        //     $linkdatas = getcache('keylink','commons');
        // }

        $linkdatas = getcache('keylink','commons');
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
    
    //列表頁
    public function lists() {
        $catid = $_GET['catid'] = intval($_GET['catid']); 
        //301 跳轉判斷 
        // $_SERVER['REDIRECT_URL']
        $request_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url_array = explode("-", $request_url);
        $url_count = count($url_array);
        if($url_count>1){
            $url_301 = getcache('301','commons');//跳轉配置文件
            if($url_301[$url_array[0]]!=""){
                //匹配到數據，則重新組成新的URL地址，進行301跳轉
                $page = max(intval($_GET['page']),1);
                $new_url = $url_301[$url_array[0]].'-'.$page.'.html';
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$new_url);
            }
        }

        $_priv_data = $this->_category_priv($catid);
        if($_priv_data=='-1') {
            $forward = urlencode(get_url());
            showmessage(L('login_website'),APP_PATH.'index.php?m=member&c=index&a=login&forward='.$forward);
        } elseif($_priv_data=='-2') {
            showmessage(L('no_priv'));
        }
        $_userid = $this->_userid;
        $_username = $this->_username;
        $_groupid = $this->_groupid;
        if(!$catid) showmessage(L('category_not_exists'),'blank');
        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$catid];
        $CATEGORYS = getcache('category_content_'.$siteid,'commons');
        if(!isset($CATEGORYS[$catid])) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
        $CAT = $CATEGORYS[$catid];
        $siteid = $GLOBALS['siteid'] = $CAT['siteid'];
        extract($CAT);
        $setting = string2array($setting);
        //SEO
        if(!$setting['meta_title']) $setting['meta_title'] = $catname;
        $SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
        $site_title = '魔方遊戲網';
        $cat_parentids = explode(',', $this->category['arrparentid']);
        if (count($cat_parentids) > 1) {
            $top_parentid = $cat_parentids[1];
        }
        switch ( $top_parentid ) {
            case 80:
                $site_title = '魔方蘋果遊戲網';
                break;
            case 100:
                $site_title = '魔方安卓遊戲網';
                break;
            case 121:
                $site_title = '魔方手遊產業網';
                break;
            default:
                break;
        }
        if ($parentid != 0 && !in_array($catid, array(173, 174, 175, 176, 178)) ) {
            $SEO['title'] = $catname . ' - ' . $site_title;
        } else {
            $SEO['title'] = $setting['meta_title'];
        }


        define('STYLE',$setting['template_list']);
        $page = max(intval($_GET['page']),1);

        //模板相关数据查询
        $mobile_forbid = $setting['mobile_forbid'] ? $setting['mobile_forbid'] : false;
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
            //URL規則
            $urlrules = getcache('urlrules','commons');
            $urlrules = str_replace('|', '~',$urlrules[$category_ruleid]);
            $tmp_urls = explode('~',$urlrules);
            $tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
            preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
            if(!empty($_urls[1])) {
                foreach($_urls[1] as $_v) {
                    $GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
                }
            }
            define('URLRULE', $urlrules);
            $GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
            $GLOBALS['URL_ARRAY']['catdir'] = $catdir;
            $GLOBALS['URL_ARRAY']['catid'] = $catid;

            require(PC_PATH."init/smarty.php");
            
            if ((is_mobile() || is_wap() || $_GET['wap']) && !$mobile_forbid) {//移動模版渲染
                $smarty = use_v4();
                $smarty->assign("SEO",$SEO);

                $smarty->assign("modelid",$modelid);

                $this->template = $template = $child ? $template : $template_list;
                $template = explode('_',$template);
                if(count($template)==2 && $template[0]=='category'){
                    $tpl = $template[1].'.tpl';
                }else{
                    $tpl = 'list/list.tpl';
                }

                $smarty->assign('top_parentid',$top_parentid);
                if ($this->template == 'category_video') {
                    $smarty->display('wap_tw/category_video.tpl');
                } elseif ($this->template == 'list_video') {
                    $smarty->display('wap_tw/list_video.tpl');
                } elseif ($this->template == 'category_zone') {
                    $smarty->display('wap_tw/list_gonglue.tpl');
                } elseif ($this->template == 'category_tuji' && $this->template == 'list_pic') {
                    $smarty->display('wap_tw/photo.tpl');
                } elseif($this->template == 'list_pregister' || $this->template == 'category_befor') {
                    $smarty->display('wap_tw/list_pregister.tpl');
                } elseif($this->template == 'list_rank' || $this->template == 'category_rank') {
                    $smarty->display('wap_tw/ranking.tpl');
                } else if($catid == 10000149) {
                    $smarty->display('tw_zt_cj/wap.tpl');
                } else if($catid == 10000231) {
                    $smarty->display('tw_tgs/category_m.tpl');
                } else {
                    $smarty->display('wap_tw/list_article.tpl');
                }
            } else {
                //模版渲染方式選擇
                $smarty = use_v4();

                //傳值
                $smarty->assign("SEO",$SEO);
                $smarty->assign("wap_url",$this->wap_url);
                $smarty->assign("CATEGORYS",$CATEGORYS);
                $smarty->assign('top_parentid',$top_parentid);
                $smarty->assign("catids",$catids);
                $smarty->assign("page",$page);
                $smarty->assign("catid",$catid);

               // $templates = STYLE.DIRECTORY_SEPARATOR.$template.'.tpl';
                
                $templates = 'tw_mofang/v4/list.tpl'; //by Sbencer 
                
                          
                if($smarty->templateExists($templates)) {
                    header('new_tpl:true');
                    $smarty->display($templates);
                    return;
                }

                //判斷當前欄目DIR是否唯一，如果唯一則分頁的首頁需要為index.html
                $page_need_index = page_need_index($catdir);
                if($page_need_index==1){
                    $smarty->assign("page_need_index",'yes');
                }else{
                    $smarty->assign("page_need_index",'no');
                }

                if ( $catid == 10000083) { // TGA專題
                    $smarty->display('tgs_huodong/index.tpl');
                } elseif ( $catid == 10000149) { // Unity專題
                    $smarty->display('tgs_huodong/index.tpl');
                } elseif ( $catid == 10000123) { // Unity專題
                    $smarty->display('tw_zt_unity/index.tpl');
                } elseif ( $catid == 1482) { // 產業年會專題
                    $smarty->display('cgiac_2014/index.tpl');
                } else {
                    $v4 = array(
                        'category_heji'=>'category_heji',
                        'list_heji'=>'list_heji',
                        'list_pingce'=>'list_pingce',
                        'list_moke'=>'list_fwbk',
                        'list_topic'=>'list_topic',
                        'category_chanye'=>'category_chanye',
                        'list'=>'list',
                        'category'=>'list',
                        'category_video'=>'category_video',
                        'list_video'=>'list',
                        'category_zone'=>'list_zone',
                        'list_zone'=>'list_zone',
                        'list_picture'=>'list',
                        'list_pregister'=>'befor_login',
                        'category_pregister'=>'befor_login',
                        'list_rank' => 'rank_list',
                    );
                                
                    if (array_key_exists($template, $v4)) {
                        if ($template != 'list_pic' && $template != 'category_tuji') {
                            $template = $v4[$template];
                            $smarty->display('tw_mofang/'.$template.'.tpl');
                        } else {
                            $smarty->display('picture/index.tpl');
                        }
                    } else {
                        // 蘋果、安卓、魔方攻略助手列表、對話實錄
                        if ( in_array($catid,array(80,100,277,255)) ) {
                            include template('content',$template);
                        } else {
                            $smarty->display('content/list_www_news.tpl');
                        }
                    }
                }
            }
        } else {
        //單網頁
            $this->page_db = pc_base::load_model('page_model');
            $r = $this->page_db->get_one(array('catid'=>$catid));
            if($r) extract($r);
            $template = $setting['page_template'] ? $setting['page_template'] : 'page';
            $arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
            if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
            $arrchild_arr = explode(',',$arrchild_arr);
            array_shift($arrchild_arr);
            $keywords = $keywords ? $keywords : $setting['meta_keywords'];
            $SEO = seo($siteid, 0, $title,$setting['meta_description'],$keywords);
            include template('content',$template);
        }
    }

    public function ajax_lists() {
        
        $catid = $_GET['catid'] = strpos(trim($_GET['catid']),",")? $_GET['catid']:intval($_GET['catid']);
        $typeid = intval($_GET['typeid']);
        $ctag = pc_base::load_app_class('content_tag','content',1);
        
        $_userid = $this->_userid;
        $_username = $this->_username;
        $_groupid = $this->_groupid;

        if(!$catid) showmessage(L('category_not_exists'),'blank');

        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$catid];
        $CATEGORYS = getcache('category_content_'.$siteid,'commons');

        $page = intval($_GET['page']);
        if ($page < 1) $page = 1;
        $pagesize = intval($_GET['pagesize']);
        if ($pagesize < 1) $pagesize = 10;
        $start = ($page-1) * $pagesize;

        $data = array();
        $data['catid'] = $catid;
        $data['limit'] = "$start,$pagesize";
        $data['order'] = 'inputtime DESC';
        
        $lists = array();
        if( in_array($catid,array(983,1006)) ){// 活動禮包返回數據處理
            $data['field'] = 'id,title,description,starttime,deadtime,thumb,url';
            $data['limit'] = 2;
            $data['order'] = 'inputtime DESC';

            $lists = $ctag->lists($data);

            // 數據處理
            if($lists){
                $new_lists = array();
                foreach($lists as $k => $v){
                    foreach($v as $_k => $_v){
                        if($_k == 'title'){
                             $new_lists[$k]['name'] = $_v;
                        }elseif($_k == 'thumb'){
                            $new_lists[$k]['icon'] = $_v;
                        }else{
                            $new_lists[$k][$_k] = $_v;
                        }
                        $new_lists[$k]['deadline'] = strtotime($v['deadtime'])-strtotime($v['starttime']);
                        unset($new_lists[$k]['starttime']);
                        unset($new_lists[$k]['deadtime']);
                    }
                }
                $lists = $new_lists;
            }
        } elseif ( in_array($catid, array(173,174,175,176,178)) ) {// 圖片站數據處理
            $data['typeid'] = $typeid;
            $data['moreinfo'] = 1;
            $lists = $ctag->type_lists($data);
        } else {    
            $lists = $ctag->lists($data);
            foreach ($lists as $k=>$v) {
                if ($v['thumb']) {
                    $lists[$k]['thumb'] = qiniuthumb($v['thumb'], 260, 146);
                    $lists[$k]['inputtime'] = date("Y-m-d",$v['inputtime']);
                    $lists[$k]['description'] = mb_substr($v['description'],0,30) . '...';
                    $lists[$k]['view_times'] = get_views('c-'.$CATEGORYS[$v['catid']]['modelid'].'-'.$v['id']);
                }
            }
        }
        $callbackname = isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : ( isset($_GET['callback']) ? $_GET['callback'] : '' );
        if(!empty($_GET['sub'])){
            $arr = array();
            foreach($lists as $k=>$v){
                $v['description']=str_cut(mftrim($v['description'].description),80);
                $v['inputtime'] = date("Y-m-d",$v['inputtime']);
                $arr[]=$v;
            }
            unset($lists);
            $lists=$arr;
        }
        if ($callbackname) {
            if($_GET['new_t']){
                echo $this->fromats($lists,$callbackname,$_GET['new_t']);
            }else{
                echo $callbackname.'('.json_encode($lists).')';
            }
            
        } else {
            if($_GET['new_t']){
                echo $this->fromats($lists,$callbackname,$_GET['new_t']);
            }else{
                echo json_encode($lists);
            }
           
        }
    }
    /*
    *根據前段的AJAX更多框架擴展 有待優化
    *
    */
    protected function fromats($list,$callbackname='',$new_t){
        if(!empty($new_t)){ //如果需要改DIV
            switch ($new_t) {
                case 'tgc_jj'://TGCList獲取更多
                    if(!empty($list)){
                        foreach ($list as $key => $value) {
                            $div .= "<div class='list-article'><dl><dt><img src='".$value['thumb']."'alt='".$value['title']."'></dt><dd><h3><a href='".$value['url']."'title='".$value['title']."'target='_blank'>".mb_strimwidth($value['title'],0,40,'...')."</a><span class='headline-time'>".date('Y-m-d',$value['inputtime'])."</span></h3><p>".mb_strimwidth($value['description'],0,60,'...')."</p></dd></dl></div>";
                       // $div = "<div>2<div><div>2<div><div>2<div><div>2<div>";
                        }
                     }
                     $arr['code'] =0;
                     $arr['data']['html'] = $div;
                     $arr['data']['nextUrl']="index.php?m=content&c=index&a=ajax_lists&tpl=list&catid=".$_GET['catid']."&pagesize=".$_GET['pagesize']."&page=".(intval($_GET['page'])+1)."&new_t=tgc_jj";
                     if($callbackname){
                        return $callbackname.'('.json_encode($arr).')';
                     }else{
                         return json_encode($arr);
                     }
                    break;

                case 'tgc_girl': //TGC girl獲取更多
                    if(!empty($list)){
                        $div ='<ul>';
                        foreach ($list as $key => $value) {
                            //$div .= "<div class='list-article'><dl><dt><img src='".$value['thumb']."'alt='".$value['title']."'></dt><dd><h3><a href='".$value['url']."'title='".$value['title']."'target='_blank'>".mb_strimwidth($value['title'],0,40,'...')."</a><span class='headline-time'>".date('Y-m-d',$value['inputtime'])."</span></h3><p>".mb_strimwidth($value['description'],0,60,'...')."</p></dd></dl></div>";
                       $div.="<li><a href='".$value['url']."' title='".$value['title']."'><img src='".$value['thumb']."'><span>".mb_strimwidth($value['title'],0,40,'...')."</span></a></li>";
                        }
                        $div.="</ul>";
                     }
                     $arr['code'] =0;
                     $arr['data']['html'] = $div;
                     $arr['data']['nextUrl']="index.php?m=content&c=index&a=ajax_lists&tpl=list&catid=".$_GET['catid']."&pagesize=".$_GET['pagesize']."&page=".(intval($_GET['page'])+1)."&new_t=tgc_girl";
                     if($callbackname){
                        return $callbackname.'('.json_encode($arr).')';
                     }else{
                         return json_encode($arr);
                     }
                    break;
                    case 'tgc_baoliao': //TGC 爆料獲取更多
                    if(!empty($list)){
                        
                        foreach ($list as $key => $value) {
                            $div .= "<div class='list-article'><dl><dt><img src='".$value['thumb']."'alt='".$value['title']."'></dt><dd><h3><a href='".$value['url']."'title='".$value['title']."'target='_blank'>".mb_strimwidth($value['title'],0,40,'...')."</a><span class='headline-time'>".date('Y-m-d',$value['inputtime'])."</span></h3><p>".mb_strimwidth($value['description'],0,60,'...')."</p></dd></dl></div>";
                      // $div.="<li><a href='".$value['url']."' title='".$value['title']."'><img src='".$value['thumb']."'><span>".mb_strimwidth($value['title'],0,40,'...')."</span></a></li>";
                        }
                     }
                     $arr['code'] =0;
                     $arr['data']['html'] = $div;
                     $arr['data']['nextUrl']="index.php?m=content&c=index&a=ajax_lists&tpl=list&catid=".$_GET['catid']."&pagesize=".$_GET['pagesize']."&page=".(intval($_GET['page'])+1)."&new_t=tgc_baoliao";
                     if($callbackname){
                        return $callbackname.'('.json_encode($arr).')';
                     }else{
                         return json_encode($arr);
                     }
                    break;
                    case 'tgc_video': //TGC video 獲取更多

                    if(!empty($list)){
                        $div='<ul>';
                        foreach ($list as $key => $value) {
                      // $div .= "<li><a href='".$value['url']."' target='_blank'><img src='".$value['thumb']."' alt='".{$value['title']}."'><b></b></a><p>".mb_strimwidth($value['title'],0,40,'...')."</p></li>";
                        $div.="<li><a href='".$value['url']."'><img src='".$value['thumb']."' alt='".$value['title']."'><b></b></a><p>".mb_strimwidth($value['title'],0,35,'...')."</p></li>";
                        }
                        $div.='</ul>';
                     }
                     $arr['code'] =0;
                     $arr['data']['html'] = $div;
                     $arr['data']['nextUrl']="index.php?m=content&c=index&a=ajax_lists&tpl=list&catid=".$_GET['catid']."&pagesize=".$_GET['pagesize']."&page=".(intval($_GET['page'])+1)."&new_t=tgc_video";
                     if($callbackname){
                        return $callbackname.'('.json_encode($arr).')';
                     }else{
                         return json_encode($arr);
                     }
                    break;
                default:
                    # code...
                    break;
            }
        }
    }


    /**
     * 列表頁獲取更多
     */
    public function content_json_list() {
        $modelid = $_GET['modelid'];
        $this->db->set_model($modelid);
        $catid = $_GET['catid'];
        
        $sign = $_GET['sign'];
        if($sign){
            if (!empty($_GET['month'])) {
                if($_GET['month']==2){
                   $_GET['month'] = intval( date('m',time()) );
                }
                $click_num = intval(date('m',time())) - intval($_GET['month']);
                $date = date('Y-m-d', strtotime("-".$click_num." month"));
                $limit = 31;
            }else{
                if ($sign=='default') {
                    $date = 'now';
                    $limit = 6;
                } elseif ($sign=='this') {
                    $date = 'now';
                    $limit = 31;
                } else {
                    $click_num = intval($_GET['click_num']);
                    $date = date('Y-m-d', strtotime("-".$click_num." month"));
                    $limit = 31;
                }
            }
            $date = getthemonth($date,'false');

            if (strpos($catid, ',')) {
                $catids_str = addslashes(trim($catid));
                $sql = "status=99 AND catid IN ($catids_str)";
            } elseif($this->category[$catid]['child']) {
                $catids_str = $this->category[$catid]['arrchildid'];
                $pos = strpos($catids_str,',')+1;
                $catids_str = substr($catids_str, $pos);
                $sql = "status=99 AND catid IN ($catids_str)";
            } else {
                $sql = "status=99 AND catid='$catid'";
            }
            $sql .= ' AND (`inputtime` BETWEEN '.$date[0].' AND '.$date[1].') ORDER BY `inputtime` DESC limit '.$limit;

            $result = $this->db->select($sql);
            if(!empty($result)) {
                $re_new = array();
                foreach($result as $rs) {
                    if(CHARSET=='gbk') {
                        foreach($rs as $key=>$r) {
                            $rs[$key] = iconv('gbk','utf-8',$r);
                        }
                    }
                    $re_new[] = $rs;
                }
                
                if(count($re_new)==6 && $limit==6){
                    array_pop($re_new);
                    $load_style = 2;
                }else{
                    $load_style = 1;
                }
                require(PC_PATH."init/smarty.php");
                $smarty = use_v4();
                if($re_new){
                    $smarty->assign("pingce_data",$re_new);
                }else{
                    $load_style = 0;
                }
                $data['data'] = $smarty->fetch('content/widget_list_pingce.tpl');
                $data['load_style'] = $load_style;
                echo json_encode($data);
            }else{
                exit('0');
            }
        }else{
            $limit = $_GET['page']*$_GET['num'].','.$_GET['num'];
            $sql = 'catid='.$_GET['catid'].' ORDER BY `inputtime` DESC limit '.$limit;

            $result = $this->db->select($sql);

            if(!empty($result)) {
                $data = array();
                foreach($result as $rs) {
                    if(CHARSET=='gbk') {
                        foreach($rs as $key=>$r) {
                            $rs[$key] = iconv('gbk','utf-8',$r);
                        }
                    }
                    $data[] = $rs;
                }
                if(count($data)==0) exit('0');
                //避免混淆，單獨數據處理
                foreach($data as $key => $val){
                    $data[$key]['url'] = wap_url($val['url']);
                    $data[$key]['inputtime'] = date('m-d',$val['inputtime']);
                }
                echo json_encode($data);
            } else {
                //沒有數據
                exit('0');
            }
        }
    }

    /**
     * 前台獲取不需要緩存的數據
     * @param mood    頂踩、數據
     *        comment 評論數據
     *        sarcasm 吐槽數據
     *        hit     瀏覽點擊量
     */
    public function ajax_nocache(){
        if (strpos($_GET['id'], '|')){
            $id = end(explode('|', $_GET['id']));
            $catid = reset(explode('|', $_GET['id']));
        } else {
            $id = $_GET['id'];
            $catid = $_GET['catid'];
        }

        $type = $_GET['type'] ? : 'all';
        $callback = isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : ( isset($_GET['callback']) ? $_GET['callback'] : '' );
        $data = array();

        $data = get_statics(array('catid'=>$catid, 'id'=>$id, 'type'=>$type));

        if ($callback) {
            echo $callback.'('.json_encode($data).')';
        } else {
            echo json_encode($data);
        }
    }

    /**
     * 欄目下文章隨機推薦
     */
    public function ajax_recommend(){
        $catid = intval($_GET['catid']);
        $id = intval($_GET['id']);
        $limit = intval($_GET['num']);
        $lists = array();

        $ctag = pc_base::load_app_class('content_tag','content',1);
        $lists = $ctag->recommend(array('catid'=>$catid, 'id'=>$id, 'limit'=>$limit));
        $callback_name = isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : ( isset($_GET['callback']) ? $_GET['callback'] : '' );

        if ($lists) {
            if ($callback_name) {
                echo $callback_name.'('.json_encode($lists).')';
            } else {
                echo json_encode($lists);
            }
        }
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

    /**
     * 檢查支付狀態
     */
    protected function _check_payment($flag,$paytype) {
        $_userid = $this->_userid;
        $_username = $this->_username;
        if(!$_userid) return false;
        pc_base::load_app_class('spend','pay',0);
        $setting = $this->category_setting;
        $repeatchargedays = intval($setting['repeatchargedays']);
        if($repeatchargedays) {
            $fromtime = SYS_TIME - 86400 * $repeatchargedays;
            $r = spend::spend_time($_userid,$fromtime,$flag);
            if($r['id']) return true;
        }
        return false;
    }

    /**
     * 檢查閱讀權限
     *
     */
    protected function _category_priv($catid) {
        $catid = intval($catid);
        if(!$catid) return '-2';
        $_groupid = $this->_groupid;
        $_groupid = intval($_groupid);
        if($_groupid==0) $_groupid = 8;
        $this->category_priv_db = pc_base::load_model('category_priv_model');
        $result = $this->category_priv_db->select(array('catid'=>$catid,'is_admin'=>0,'action'=>'visit'));
        if($result) {
            if(!$_groupid) return '-1';
            foreach($result as $r) {
                if($r['roleid'] == $_groupid) return '1';
            }
            return '-2';
        } else {
            return '1';
        }
    }

    /**
     * 手機端檢測並跳轉
     *
     */
    protected function check_mobile() {
        $catid = intval($_GET['catid']);

        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$catid];
        $CATEGORYS = getcache('category_content_'.$siteid,'commons');

        $CAT = $CATEGORYS[$catid];
        $TEMPLA = string2array($CAT['setting']);
        $index = ROUTE_A."_m_template";

        $request_url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        // 栏目设置启动移动页+设备是移动端+域名是web链接 实现跳转
        if ((ROUTE_A == 'init' || $CAT['ismobile']) && isMobile() && !preg_match("/^m\./", $_SERVER['HTTP_HOST'])) {
            $mobile_url = wap_url($request_url);
            if($mobile_url==$request_url){
                return true;
            } 
            header('Location: ' . $mobile_url);
            exit;
        }
        // 手机端非首页未启用移动栏目则回跳www
        if ((ROUTE_A != 'init' && !$CAT['ismobile']) && isMobile() && preg_match("/^m\./", $_SERVER['HTTP_HOST'])) {
            $mobile_url = pc_url($request_url);
            header('Location: ' . $mobile_url);
            exit;
        }
        // 非手机端检测跳转www
        if (!isMobile() && preg_match("/^m\./", $_SERVER['HTTP_HOST'])) {
            $mobile_url = pc_url($request_url);
            header('Location: ' . $mobile_url);
            exit;
        }
    }

    public function scripts (){
        $tpl = $_GET['t'];
        $debug = $_GET['debug'];
        if(!isset($tpl)){
            exit();
        }
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $name ="common/$tpl.tpl";
        if(isset($debug)){
            $html = $smarty->display($name);
        }else{
            $html = $smarty->fetch($name);
            header('Content-type:application/x-javascript');
            echo "document.write(".json_encode($html).");";
        }
    }

    // 網站地圖
    public function map(){
        $parents_catid = 1122;
        $parents_array = subcat($parents_catid);
        $parents_array = array_reverse($parents_array); //數組反轉
        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$parents_catid];
        $CATEGORYS = getcache('category_content_'.$siteid,'commons');

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4(); 
        $smarty->assign("SEO",$SEO);
        $smarty->assign("$CATEGORYS",$CATEGORYS);
        $smarty->assign('parents_catid',$parents_catid);
        $smarty->assign('parents_array',$parents_array);
 
        $smarty->assign("description",$description); 
        $smarty->display('content/mapsite.tpl'); 

    }

    /*
    * 返回JS格式的列表頁供編輯制作靜態頁面調用
    * num = 10 
    * type = article 
    * str_len = 20; 默認字符長度
    * show_time = yes 默認不顯示時間 
    */
    public function lists_js(){
        $catid = $_GET['catid'] = intval($_GET['catid']);
        $type = $_GET['type']? $_GET['type']: 'article';
        $show_time = $_GET['show_time']? $_GET['show_time']: 'no';
        $type_array = array('article','images');
        if(!in_array($type, $type_array)){
            return false;exit;
        }
        $pagesize = $_GET['num'] ? intval($_GET['num']) : 10;
        if($_GET['str_len']){
            $str_len = intval($_GET['str_len']) ;
        }
        $string = '';
        $new_array =array();
        $this->db->set_catid($catid);
        $where = array("catid"=>$catid,"status"=>99);
        $array = $this->db->select($where, 'id,catid,title,url,thumb,inputtime', $pagesize,'id desc');
        $string .= "<ul>";
        if(!empty($array)){
            foreach ($array as $key => $value) {
                # code...
                if($str_len>0){
                    $title = str_cut($value['title'],$str_len,false);
                }else{
                    $title = $value['title'];
                }
                if($show_time=='yes'){
                    $time_str = "<span>".date("m-d",$value['inputtime'])."</span>";
                }
                if($type=='article'){
                    $string .='<li><a href="'.$value['url'].'" target="_blank">'.$title.'</a>'.$time_str.'</li>';
                }else{
                    $string .='<li><a href="'.$value['url'].'" target="_blank"><img src="'.$value['thumb'].'" alt="'.$title.'"><span>'.$title.'</span></a></li>';
                }
            }
        }
        $string .= "</ul>";
        if($_GET['test']=='test'){
            print_r($string);exit;
        }
        echo "document.write('$string');";
    }
    
}
