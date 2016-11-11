<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('form','',0);
pc_base::load_sys_class('format','',0);
class index {
    function __construct() {
        $this->db = pc_base::load_model('search_model');
        $this->partition_db = pc_base::load_model('partition_model');
        $this->relationgames_db = pc_base::load_model('partition_relationgames_model');
        $this->content_db = pc_base::load_model('content_model');
    }

    /**
     * 關鍵詞搜索
     */
    public function new_init() {
        //獲取siteid
        $siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
        $SEO = seo($siteid);
        $type = trim(strip_tags($_GET['type']));
        if (!in_array($type, array('all', 'news', 'game', 'video', 'topic','libao'))){
            $type = 'all';
        }
        $status = $type;

        $urlrule = "http://www.mofang.com/tag/{\$keyword}-{\$type}-{\$page}.html";

        //搜索配置
        $search_setting = getcache('search');
        $setting = $search_setting[$siteid];

        $search_model = getcache('search_model_'.$siteid);
        $type_module = getcache('type_module_'.$siteid);

        // 搜索前變量初始化
        $totalnums = $gamesnums = $videosnums = $newsnums = 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = intval($_GET['pagesize'])?:10;
        $start = ($page-1)*$pagesize;
        $callback = $_GET['callback'] ? : '';
        $data = array();

        // 檢驗服務器是否正常
        if ( !is_test_server() ) {
            $solr = pc_base::load_app_class('apache_solr_service', '', 0);
            $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
            
            if (!$solr->ping()) {
                $status = 0;

                require(PC_PATH."init/smarty.php");
                $smarty = use_v4();

                $smarty->assign("SEO",$SEO);
                $smarty->assign("search_q",$search_q);
                $smarty->assign("totalnums",$totalnums);
                $smarty->assign("siteid",$siteid);
                $smarty->assign("status",$status);
                $smarty->assign("type",$type);

                $smarty->display('sear/index.tpl');
                exit;
            }
        }

        if(isset($_GET['q'])) {
            if(trim($_GET['q'])=='') {
                header('Location: '.APP_PATH.'index.php?m=search&type='.$type);exit;
            }

            // 關鍵字處理
            $q = safe_replace(trim($_GET['q']));
            $q = htmlspecialchars(strip_tags($q));
            $q = str_replace('%', '', $q);    //過濾'%'，用戶全文搜索
            $search_q = str_replace('/', '', $q);    //搜索原內容
            $keyword = substr($q, 0, 60); //截取關鍵字 @數據表長度所困@

            // SEO信息重寫
            $SEO['title'] = $keyword.'資訊合集-安卓iOS版下載攻略視頻修改輔助-魔方網';
            $SEO['keyword'] = $keyword.','.$keyword.'新聞,'.$keyword.'下載,'.$keyword.'安卓,'.$keyword.'iOS,'.$keyword.'攻略,'.$keyword.'視頻';
            $SEO['description'] = '魔方網'.$keyword.'最新資訊大全，包括最新新聞、安卓iOS下載、攻略、視頻、修改、輔助及相關玩家心得分享。';
            if ( !is_test_server() ){
                session_start();
                if ( !empty($keyword) && ($_SESSION['search_keyword'] !=$search_q || $_SESSION['search_limit'] < time()) ) {
                    // session 確保關鍵字統計
                    $_SESSION['search_keyword'] = $search_q;
                    $_SESSION['search_limit'] = time() + 10;
                    // 超出時間限制或者改變關鍵字時，更新關鍵字數據庫
                    $this->hits($keyword);
                }
            }

            if (get_magic_quotes_gpc() == 1) {
                $query = stripslashes($q);
            }

            if ($type != 'all') {
                if ($type == 'topic') {
                    // 專區
                    $topic = array();
                    $where .= "`catname` like '%{$q}%' AND `parentid` = 0";
                    $infos = $this->partition_db->listinfo($where,'',$page,20) ? : array();
                    $totalnums = count($infos);
                    if ($infos) {
                        foreach ($infos as $k=>$v) {
                            $is_domain = $v['is_domain'];
                            $domain_dir = $v['domain_dir'];
                            $topic[$k]['url'] = $is_domain ? 'http://'.$domain_dir.'.mofang.com' : 'http://www.mofang.com/'.$domain_dir.'/';
                            $topic[$k]['title'] = $v['catname'];

                            $setting = string2array($v['setting']);
                            $topic[$k]['description'] = $setting['meta_description'];
                            $topic[$k]['icon'] = $setting['app_down']['image'];

                            $catid = $v['catid'];
                            $new_gameid = null;
                            $game_info = $this->relationgames_db->listinfo(array('part_id'=>$catid));
                            foreach ($game_info as $_k=>$_v) {
                                $req_url = 'http://game.mofang.com/api/web/GetGameInfoByOldId?type='.$_v['modelid'].'&id='.$_v['gameid'];
                                $req_data = json_decode(mf_curl_get($req_url), true);

                                if ( $req_data['data'] ) {
                                    $new_gameid = $req_data['data']['id'];
                                    break;
                                } else {
                                    continue;
                                }
                            }
                            $topic[$k]['game_url'] = $new_gameid ?  'http://game.mofang.com/info/'.$new_gameid.'.html' : 'javascript:;';
                        }
                    }
                    $data = $topic;


                    if($_GET['test']){
                        var_dump($topic);
                    }
                } elseif ($type == 'game' || $type == 'libao') {
                    //使用李偉搜索接口,根據參數來傳遞
                    $send_data = array(
                            'keywords'=>$q,
                            'size'=>$pagesize,
                            'page'=>$page,
                        );
                    $requires = http_build_query($send_data);
                    $datas = $this->get_search_game($requires);
                    $data = $datas['data'];
                    $totalnums = $datas['total'];

                    if($_GET['test']){
                        var_dump($datas);
                    }
                } elseif( !is_test_server() ) {
                    if ($type == 'news') {
                        $additionalParameters['sort'] = 'inputtime desc';
                        $additionalParameters['fq'][] = "types:news";
                    } else if ($type == 'video') {
                        $additionalParameters['fq'][] = "types:video";
                    }

                    try {
                        $result = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                    } catch (Exception $e) {
                        $status = 0;
                        
                        require(PC_PATH."init/smarty.php");
                        $smarty = use_v4();

                        $smarty->assign("SEO",$SEO);
                        $smarty->assign("search_q",$search_q);
                        $smarty->assign("totalnums",$totalnums);
                        $smarty->assign("siteid",$siteid);
                        $smarty->assign("status",$status);
                        $smarty->assign("type",$type);

                        $smarty->display('sear/index.tpl');
                        exit;
                    }

                    if ($result) {
                        $totalnums = (int) $result->response->numFound;
                    }

                    foreach ($result->response->docs as $key=> $doc) {
                        foreach ($doc as $field => $value) {
                            $data[$key][$field] = $value;
                        }
                    }
                }

                foreach($data as $_k=>$_v) {
                    if ($type == 'game' || $type == 'topic') {
                        // $tag_ids = explode('-', $_v['_id_']);
                        // $data[$_k]['tags'] = linktags($tag_ids[0], $tag_ids[1]);
                    } elseif ($type == 'video') {
                        $data[$_k]['description'] = strip_tags($_v['description']);
                    } else {
                        $data[$_k]['description'] = strip_tags($_v['content']);
                    }
                    $data[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                }

                $totalnums = $totalnums ? :0;
                if ($totalnums == 0) {
                    $status = 0;
                }
               //-->禮包標簽數據

                 // 屈龍發號接口
                if ($data) {
                    foreach ($data as $_k=>$_v) {
                        $gameid[] = $_v['id'];
                    }
                    $send_data = array(
                            'appkey'=>'10006',
                            'expire' => time() + 3600*24,
                            'offset' => $start,// 下一頁開始位置
                            'limit' => $pagesize,// 每頁個數
                            'game_id' => $gameid,
                        );
                    $send_data['sign'] = getsign($send_data);

                    $requires = http_build_query($send_data);
                    $datas = $this->get_search_libao($requires);
                    $libao = $datas['data'];
                }
                  

            } else {
                // 專區
                $topic = array();
                $where .= "`catname` like '%{$q}%' AND `parentid` = 0";
                $infos = $this->partition_db->listinfo($where,'',$page,20) ? : array();
                $topicnums = count($infos);
                if ($infos) {
                    foreach ($infos as $k=>$v) {
                        $is_domain = $v['is_domain'];
                        $domain_dir = $v['domain_dir'];
                        $topic[$k]['url'] = $is_domain ? 'http://'.$domain_dir.'.mofang.com' : 'http://www.mofang.com/'.$domain_dir.'/';
                        $topic[$k]['title'] = $v['catname'];

                        $setting = string2array($v['setting']);
                        $topic[$k]['description'] = $setting['meta_description'];
                        $topic[$k]['icon'] = $setting['app_down']['image'];

                        $catid = $v['catid'];
                        $new_gameid = null;
                        $new_gameicon = null;
                        $game_info = $this->relationgames_db->listinfo(array('part_id'=>$catid));
                        foreach ($game_info as $_k=>$_v) {
                            $req_url = 'http://game.mofang.com/api/web/GetGameInfoByOldId?type='.$_v['modelid'].'&id='.$_v['gameid'];
                            $req_data = json_decode(mf_curl_get($req_url), true);

                            if ( $req_data['data'] ) {
                                $new_gameid = $req_data['data']['id'];
                                $new_gameicon = $req_data['data']['icon'];
                                break;
                            } else {
                                continue;
                            }
                        }
                        $topic[$k]['game_url'] = $new_gameid ?  'http://game.mofang.com/info/'.$new_gameid.'.html' : 'javascript:;';
                        $topic[$k]['icon'] = $new_gameicon;
                    }
                }
                // $pages = $this->partition_db->pages;

                // 李偉遊戲接口
                $send_data = array(
                        'keywords'=>$q,
                        'size'=>$pagesize,
                        'page'=>$page,
                    );
                $requires = http_build_query($send_data);
                $datas = $this->get_search_game($requires);
                $game = $datas['data'];
                $gamesnums = $datas['total'];

                // 屈龍發號接口
                if ($game) {
                    foreach ($game as $_k=>$_v) {
                        $gameid[] = $_v['id'];
                    }
                    $send_data = array(
                            'appkey'=>'10006',
                            'expire' => time() + 3600*24,
                            'offset' => $start,// 下一頁開始位置
                            'limit' => $pagesize,// 每頁個數
                            'game_id' => $gameid,
                        );
                    $send_data['sign'] = getsign($send_data);

                    $requires = http_build_query($send_data);
                    $datas = $this->get_search_libao($requires);
                    $libao = $datas['data'];
                    //獲取對應禮包數組
                    foreach ($game as $key => $value) {
                        $send['appkey']='10006';
                        $send['expire']=time() + 3600*24;
                        $send['offset']=0;
                        $send['limit']=10;
                        $send['game_id']=intval($value['id']);
                        $send['sign'] = getsign($send);
                        $requires = http_build_query($send);
                        unset($send);
                        $libaos = $this->get_search_libao($requires);
                        $libao_arr[$value['id']]=$libaos['data'][0];
                    }
                    //ddd($libao_arr);
                }

                // 視頻
                if ( !is_test_server() ){
                    try {
                        $additionalParameters = array();
                        $additionalParameters['sort'] = 'inputtime desc';
                        $additionalParameters['fq'][] = "types:video";
                        $videos = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                    } catch (Exception $e) {
                        $status = 0;
                        
                        require(PC_PATH."init/smarty.php");
                        $smarty = use_v4();

                        $smarty->assign("SEO",$SEO);
                        $smarty->assign("search_q",$search_q);
                        $smarty->assign("totalnums",$totalnums);
                        $smarty->assign("siteid",$siteid);
                        $smarty->assign("status",$status);
                        $smarty->assign("type",$type);

                        $smarty->display('sear/index.tpl');
                        exit;
                    }

                    if($videos) {
                        $videosnums = (int) $videos->response->numFound;
                    }

                    foreach ($videos->response->docs as $key=> $doc) {
                        foreach ($doc as $field => $value) {
                            $video[$key][$field] = $value;
                        }
                    }

                    foreach ($video as $_k=>$_v) {
                        $video[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                        $video[$_k]['description'] = strip_tags($_v['description']);
                    }
                }

                // 新聞
                if ( !is_test_server() ){
                    try {

                        $additionalParameters = array();
                        $additionalParameters['sort'] = 'inputtime desc';
                        $additionalParameters['fq'][] = "types:news";
                        $news = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                        if($_GET['test']=='test'){
                            print_r($news);exit;
                        }
                        
                    } catch (Exception $e) {
                        $status = 0;
                        
                        require(PC_PATH."init/smarty.php");
                        $smarty = use_v4();

                        $smarty->assign("SEO",$SEO);
                        $smarty->assign("search_q",$search_q);
                        $smarty->assign("totalnums",$totalnums);
                        $smarty->assign("siteid",$siteid);
                        $smarty->assign("status",$status);
                        $smarty->assign("type",$type);

                        $smarty->display('sear/index.tpl');
                        exit;
                    }

                    if($news) {
                        $newsnums = (int) $news->response->numFound;
                    }

                    foreach ($news->response->docs as $key=> $doc)
                    {
                        foreach ($doc as $field => $value) {
                            $new[$key][$field] = $value;
                        }
                    }

                    foreach($new as $_k=>$_v) {
                        $new[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                        $new[$_k]['description'] = strip_tags($_v['content']);
                    }
                }

                // 合並結果，總數中沒有加禮包數
                $totalnums = $topicnums + $gamesnums + $videosnums + $newsnums;
                if ($totalnums == 0) {
                    $status = 0;
                }

                $data['topic'] = $topic;
                $data['games'] = $game;
                $data['video'] = $video;
                $data['news'] = $new;
                $data['libao'] = $libao;
                foreach($data as $_type=>$_data){
                    if(in_array($_type, array('games', 'news', 'topic'))){
                        if ($_data){
                            foreach($_data as $_k=>$_v){
                                $data[$_type][$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                            }
                        }
                    }
                }
            }

            $execute_time = execute_time();
            $pages = isset($pages) ? $pages : '';
        } else {
            $status = 0;
        }
        if($type =='libao'){
            $status='libao';
        }
        // 調試
        if ($_GET['test']) {
            var_dump($type, $status);exit;
        }

        // ajax返回數據
        if ($callback) {
            echo $callback.'('.json_encode($data).')';
            exit;
        }

        // 渲染頁面
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();

        // 基礎參數賦值
        $smarty->assign("SEO",$SEO);
        $smarty->assign("search_q",$search_q);
        $smarty->assign("totalnums",$totalnums);
        $smarty->assign("topicnums",$topicnums);
        $smarty->assign("gamesnums",$gamesnums);
        $smarty->assign("videosnums",$videosnums);
        $smarty->assign("newsnums",$newsnums);
        $smarty->assign("siteid",$siteid);
        $smarty->assign("status",$status);
        $smarty->assign("type",$type);

        // 數據參數賦值
        $smarty->assign("data",$data);
        
        $smarty->assign("libao_list",$libao);//根據ID對應禮包參數
        $smarty->assign("page",$page);
        $smarty->assign("pagesize",$pagesize);
        $smarty->assign("urlrule",$urlrule);
        $smarty->assign("mfpage",array('keyword'=>$search_q, 'type'=>$type));

        if (is_wap() || is_mobile() || $_GET['wap']) {
            $smarty->display('wap/search_show.tpl');
        } else {
            $smarty->display('sear/index.tpl');
        }
    }

    /**
     * 李偉遊戲接口
     * @author Jozh liu
     */
    public function get_search_game($send_data){
        $game_api = "http://game.mofang.com/api/web/getgamelist?".$send_data;
        $datas = mf_curl_get($game_api);
        $datas = json_decode($datas,true);
        $game = $datas['data']['data'];
        if(is_array($game)){
            foreach ($game as $key => $value) {
                $game[$key]['url'] = 'http://game.mofang.com/info/'.$value['id'].'.html';
                $game[$key]['title'] = $value['name'];
                $game[$key]['brief'] = $value['comment'];
                $game[$key]['score'] = round($value['score']/2);
            }
        } else {
            $game = array();
        }

        $total = $datas['data']['total']; 
        $return = array(
                'data'=>$game,
                'total'=>$total,
            );
        return $return;
    }

    /**
     * 屈龍發號接口
     * @author Jozh liu
     */
    public function get_search_libao($send_data){
        $libao_api = "http://fahao.mofang.com/api/v1/gift/list?".$send_data;
        $datas = mf_curl_get($libao_api);
        $datas = json_decode($datas,true);
        
        $libao = $datas['data'];
        if ($libao) {
            foreach ($libao as $_k=>$_v) {
                $end_time = strtotime($_v['end_time']);
                if ($end_time < time()) {
                    $libao[$_k]['lifetime'] = '已過期';
                } else {
                    $libao[$_k]['lifetime'] = left_time($end_time, time(), 2);
                }
            }
        }
        $return = array(
                'data'=>$libao,
            );

        return $return;
    }

    /**
     * 關鍵詞搜索備份
     */
    public function init() {

        //獲取siteid
        $siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
        $SEO = seo($siteid);

        $keyword = $_GET['q'];
        // SEO信息重寫
        $SEO['title'] = "魔方網-手機遊戲綜合情報攻略網|Search {$keyword}";
        $SEO['keyword'] = "手遊,手機遊戲,手機遊戲免費下載,android遊戲,iphone遊戲,安卓蘋果遊戲,{$keyword}攻略,破解,line遊戲,mobile game,{$keyword}";
        $SEO['description'] = "魔方網_最專業的手機遊戲情報攻略站,提供iOS/Android/手機遊戲限免情報,手機遊戲下載,手機遊戲新聞和破解情報以及豐富多樣的論壇交流.";

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $smarty->assign("SEO",$SEO);

        if (is_mobile() || is_wap() || $_GET['wap']) {//移動模版渲染
            $smarty->display('wap_tw/search.tpl');
        } else {
            $smarty->display('tw_mofang/search.tpl');
        }
        exit;

        $status = trim(strip_tags($_GET['type']));
        if (!in_array($status, array('all', 'news', 'game', 'video'))){
            $status = 'all';
        }
        $type = $status;
        $partition = intval(trim($_GET['p']))?:0;
        $json = intval($_GET['json'])?:0;

        if($partition && is_int($partition)){
            $urlrule = "http://www.mofang.com/tag/".$partition."/{\$keyword}-{\$type}-{\$page}.html";
        }else{
            $urlrule = "http://www.mofang.com/tag/{\$keyword}-{\$type}-{\$page}.html";
        }

        $this->db->query("select catname,is_domain from www_partition where catid={$partition}");
        $p_setting = $this->db->fetch_array();
        $partition_name = $p_setting[0]['catname'];
        $is_domain = $p_setting[0]['is_domain'];

        if ($json !=0 && $partition != 0) {
            $this->db->query("select setting from www_partition where catid={$partition}");
            $partition_setting = $this->db->fetch_array();
            $setting = string2array($partition_setting[0]['setting']);
            $card_db_name = $setting['card_db_ename'];
            foreach($setting['button_v2'] as $button) {
                if ($button['button_type'] == 1) {
                    $show_catid[] = $button['button_value'];
                } else if ($button['button_type'] == 2) {
                    $card_db_jh[] = $button['button_value'];
                }
            }
            if ($in = implode(',', $show_catid)) {
                $this->db->query("SELECT catid FROM www_partition WHERE parentid IN ($in) OR catid IN ($in)");
                foreach($this->db->fetch_array() as $val) {
                    $specialid[] = 'specialid:'.$val['catid'];
                }
            }
        }
        //搜索配置
        $search_setting = getcache('search');
        $setting = $search_setting[$siteid];

        $search_model = getcache('search_model_'.$siteid);
        $type_module = getcache('type_module_'.$siteid);

        if (!is_test_server()) {
            $solr = pc_base::load_app_class('apache_solr_service', '', 0);
            $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
            
            //備注：檢驗服務器是否正常？
            if (!$solr->ping()) {
                $totalnums = $status = 0;
                include template('search','index');
                exit;
            }
        }
        if(isset($_GET['q'])) {
            if(trim($_GET['q'])=='') {
                header('Location: '.APP_PATH.'index.php?m=search&type='.$type);exit;
            }

            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $pagesize = intval($_GET['pagesize'])?:10;
            $q = safe_replace(trim($_GET['q']));
            $q = htmlspecialchars(strip_tags($q));
            $q = str_replace('%', '', $q);    //過濾'%'，用戶全文搜索
            $search_q = str_replace('/', '', $q);    //搜索原內容
            
            $keyword = substr($q, 0, 60); //截取關鍵字 @數據表長度所困@

            session_start();
            if (!empty($keyword) && ($_SESSION['search_keyword'] !=$search_q || $_SESSION['search_limit'] < time())) {
                // session 確保關鍵字統計
                $_SESSION['search_keyword'] = $search_q;
                $_SESSION['search_limit'] = time() + 10;
                // 超出時間限制或者改變關鍵字時，更新關鍵字數據庫
                $this->hits($keyword);
                
            }

            $solr = pc_base::load_app_class('apache_solr_service', '', 0);
            $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
            if (!$solr->ping()) {
                $totalnums = $status = 0;
                include    template('search','index');
                exit;
            }

            $start = ($page-1)*$pagesize;
            $query = isset($_REQUEST['q']) ? $_REQUEST['q'] : false;
            $results = false;

            if (get_magic_quotes_gpc() == 1)
            {
                $query = stripslashes($q);
            }

            if ($type != 'all') {

                if ($type == 'game') {
                    $additionalParameters['fq'][] = "types:game";
                } else {
                    //$additionalParameters['sort'] = 'inputtime desc';
                }

                if ($type == 'news') {
                    $additionalParameters['fq'][] = "types:news";
                } else if ($type == 'video') {
                    $additionalParameters['fq'][] = "types:video";
                }
                
                if ($partition) {
                    $additionalParameters['fq'][] = "partition:{$partition}";
                }
                /* ($type == 'part') {
                    if ($partition) {
                        $additionalParameters['fq'][] = "partition:{$partition}";
                    } else {
                        $additionalParameters['fq'][] = "partition:0";
                    }
                }*/

                try
                {
                    $result = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                }
                catch (Exception $e)
                {
                    $totalnums = $status = 0;
                    include template('search','index');
                    exit();
                }

                if($result) {
                    $totalnums = (int) $result->response->numFound;
                }

                foreach ($result->response->docs as $key=> $doc)
                {
                    foreach ($doc as $field => $value) {
                        $data[$key][$field] = $value;
                    }
                }

                foreach($data as $_k=>$_v) {
                    if ($type == 'game') {
                        $tag_ids = explode('-', $_v['_id_']);
                        $data[$_k]['tags'] = linktags($tag_ids[0], $tag_ids[1]);
                    }
                    $data[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                    if ($type == 'video') {
                        $data[$_k]['description'] = strip_tags($_v['description']);
                    } else {
                        $data[$_k]['description'] = strip_tags($_v['content']);
                    }

                }

                $totalnums = $totalnums?:0;
                if ($totalnums == 0) $status = 0;

            } else {

                //使用李偉搜索接口,根據參數來傳遞
                // if($_GET['test']==1){
                    $game_api = "http://game.mofang.com/api/web/getgamelist?keywords=".$q."&size＝5";
                    $datas = mf_curl_get($game_api);
                    $datas = json_decode($datas,true);
                    $game = $datas['data']['data'];
                    $gamesnums = $datas['data']['total']; 
                    if(is_array($game)){
                        foreach ($game as $key => $value) {
                            # code...
                            $game[$key]['title'] = $value['name'];
                            $game[$key]['brief'] = $value['comment'];
                        }
                    }
                // }else{
                //     try
                //     {
                //         $additionalParameters = array();
                //         $additionalParameters['fq'][] = "types:game";
                //         if ($partition) {
                //             $additionalParameters['fq'][] = "partition:{$partition}";
                //         }
                //         if ($json) {
                //             $additionalParameters['fq'][] = implode(' || ', $specialid);
                //             //$games = $solr->search("title:{$q}", $start, $pagesize, $additionalParameters);
                //         }
                //         $games = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                        
                //     }
                //     catch (Exception $e)
                //     {
                //         $totalnums = $status = 0;
                //         include template('search','index');
                //         exit();
                //     }

                //     if($games) {
                //         $gamesnums = (int) $games->response->numFound;
                //     }

                //     foreach ($games->response->docs as $key=> $doc)
                //     {
                //         foreach ($doc as $field => $value) {
                //             $game[$key][$field] = $value;
                //         }
                //     }

                //     foreach($game as $_k=>$_v) {
                //         $tag_ids = explode('-', $_v['_id_']);
                //         $game[$_k]['tags'] = linktags($tag_ids[0], $tag_ids[1]);
                //         $game[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                //     } 
                // }

                


                try
                {
                    $additionalParameters = array();
                    //$additionalParameters['sort'] = 'inputtime desc';
                    $additionalParameters['fq'][] = "types:video";
                    if ($partition) {
                        $additionalParameters['fq'][] = "partition:{$partition}";
                    }
                    if ($json) {
                        $additionalParameters['fq'][] = implode(' || ', $specialid);
                        //$videos = $solr->search("title:{$q}", $start, $pagesize, $additionalParameters);
                    }
                    $videos = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                    
                }
                catch (Exception $e)
                {
                    $totalnums = $status = 0;
                    include template('search','index');
                    exit();
                }

                if($videos) {
                    $videosnums = (int) $videos->response->numFound;
                }

                foreach ($videos->response->docs as $key=> $doc)
                {
                    foreach ($doc as $field => $value) {
                        $video[$key][$field] = $value;
                    }
                }

                foreach($video as $_k=>$_v) {
                    $video[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                    $video[$_k]['description'] = strip_tags($_v['description']);
                }

                try
                {
                    $additionalParameters = array();
                    //$additionalParameters['sort'] = 'inputtime desc';
                    $additionalParameters['fq'][] = "types:news";
                    if ($partition) {
                        $additionalParameters['fq'][] = "partition:{$partition}";
                    }
                    if ($json) {
                        $additionalParameters['fq'][] = implode(' || ', $specialid);
                        //$news = $solr->search("title:{$q}", $start, $pagesize, $additionalParameters);
                    }
                    $news = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                    
                }
                catch (Exception $e)
                {
                    $totalnums = $status = 0;
                    include template('search','index');
                    exit();
                }

                if($news) {
                    $newsnums = (int) $news->response->numFound;
                }

                foreach ($news->response->docs as $key=> $doc)
                {
                    foreach ($doc as $field => $value) {
                        $new[$key][$field] = $value;
                    }
                }

                foreach($new as $_k=>$_v) {
                    $new[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                    $new[$_k]['description'] = strip_tags($_v['content']);
                }

                $totalnums = $gamesnums+$videosnums+$newsnums;
                if ($totalnums == 0) $status = 0;

                $data['games'] = $game;
                $data['video'] = $video;
                $data['news'] = $new;
            }

            $execute_time = execute_time();
            $pages = isset($pages) ? $pages : '';

        } else {
            $totalnums = $status = 0;
        }
        if ($json) {
            $callback_name = $_GET['jsonpcallback'] ? : ( $_GET['callback'] ? : '' ) ;
            if($callback_name){
                if( isset($_GET['keyword']) && !empty($_GET['keyword']) ){
                    $keywords = $_GET['keyword'];
                }else{
                    $this->db->query('select `keywords` from www_news where `catid`='.$_GET['catid'].' and `id` ='.$_GET['contid']);
                    $keywords = $this->db->fetch_array();
                    $keywords = explode(',',$keywords[0]['keywords']);
                }
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $pagesize = intval($_GET['pagesize'])?:10;
                $start = ($page-1)*$pagesize;
                foreach($keywords as $q){
                    if (!is_test_server()) {
                        //文章
                        try
                        {
                            $additionalParameters = array();
                            //$additionalParameters['sort'] = 'inputtime desc';
                            $additionalParameters['fq'][] = "types:news";
                            if ($partition) {
                                $additionalParameters['fq'][] = "partition:{$partition}";
                            }
                            if ($json) {
                                $additionalParameters['fq'][] = implode(' || ', $specialid);
                                //$news = $solr->search("title:{$q}", $start, $pagesize, $additionalParameters);
                            }
                            $news = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                        }
                        catch (Exception $e)
                        {
                            $totalnums = $status = 0;
                            include template('search','index');
                            exit();
                        }
                        foreach ($news->response->docs as $key=> $doc)
                        {
                            foreach ($doc as $field => $value) {
                                $new[$key][$field] = $value;
                            }
                        }
                        $new = $new ?:array();
                        //視頻
                        try
                        {
                            $additionalParameters = array();
                            //$additionalParameters['sort'] = 'inputtime desc';
                            $additionalParameters['fq'][] = "types:video";
                            if ($partition) {
                                $additionalParameters['fq'][] = "partition:{$partition}";
                            }
                            if ($json) {
                                $additionalParameters['fq'][] = implode(' || ', $specialid);
                                //$videos = $solr->search("title:{$q}", $start, $pagesize, $additionalParameters);
                            }
                            $videos = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                        }
                        catch (Exception $e)
                        {
                            $totalnums = $status = 0;
                            include template('search','index');
                            exit();
                        }
                        foreach ($videos->response->docs as $key=> $doc)
                        {
                            foreach ($doc as $field => $value) {
                                $video[$key][$field] = $value;
                            }
                        }
                        $video = $video ?:array();
                        //圖片
                        try
                        {
                            $additionalParameters = array();
                            $additionalParameters['fq'][] = "types:picture";
                            if ($partition) {
                                $additionalParameters['fq'][] = "partition:{$partition}";
                            }
                            if ($json) {
                                $additionalParameters['fq'][] = implode(' || ', $specialid);
                                //$pictures = $solr->search("title:{$q}", $start, $pagesize, $additionalParameters);
                            }
                            $pictures = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                            
                        }
                        catch (Exception $e)
                        {
                            $totalnums = $status = 0;
                            include template('search','index');
                            exit();
                        }
                        foreach ($pictures->response->docs as $key=> $doc) {
                            foreach ($doc as $field => $value) {
                                $picture[$key][$field] = $value;
                            }
                        }
                        $picture= $picture ?:array();
                        $datas[] = array_merge($new,$video,$picture);
                    }
                }
                // 把三維數組重組成二維數組
                $data_all = array();
                if ($datas) {
                    foreach($datas as $v){
                        foreach($v as $val){
                            array_push($data_all,$val);
                        }
                    }
                }
                // 把二維數組中的每個一維元素id做其鍵值
                if ($data_all) {
                    foreach($data_all as $v){
                        $nk = $v['id'];
                        $data[$nk] = $v;
                    }
                }
                sort($data);
                //處理數據
                $return = array();
                foreach($data as $k => $v) {
                    if($v['id'] != $_GET['contid']){
                        $re['id'] = $v['id'];
                        $re['catid'] = $v['catid'];
                        if($v['catid'] == $_GET['catid']){
                            if ($is_domain) {
                                $re['url'] = 'http://'.$_GET['pname'].'.mofang.com/'.$v['catid'].'_'.$v['id'].'.html';
                            } else {
                                $re['url'] = 'http://www.mofang.com/'.$_GET['pname'].'/'.$v['catid'].'_'.$v['id'].'.html';
                            }
                            $re['title'] = strip_tags($v['title']);
                            $re['shortname'] = $v['shortname'];
                            $re['thumb'] = $v['thumb'];
                            $re['updatetime'] = $v['inputtime'];
                            $re['modelid'] = $v['modelid'];
                            $return[] = $re;
                        }
                    }
                }
                if ($json == 2) {
                    echo json_encode($return);
                } else {
                    echo $callback_name.'('.json_encode($return).')';
                }
            }else{
                try
                {
                    $additionalParameters = array();
                    $additionalParameters['fq'][] = "types:picture";
                    if ($partition) {
                        $additionalParameters['fq'][] = "partition:{$partition}";
                    }
                    if ($json) {
                        $additionalParameters['fq'][] = implode(' || ', $specialid);
                        //$pictures = $solr->search("title:{$q}", $start, $pagesize, $additionalParameters);
                    }
                    $pictures = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                    
                }
                catch (Exception $e)
                {
                    $totalnums = $status = 0;
                    include template('search','index');
                    exit();
                }
                foreach ($pictures->response->docs as $key=> $doc) {
                    foreach ($doc as $field => $value) {
                        $picture[$key][$field] = $value;
                    }
                }
                foreach ($pictures->response->docs as $key=> $doc) {
                    foreach ($doc as $field => $value) {
                        $picture[$key][$field] = $value;
                    }
                }
                $data['picture'] = $picture;
                $return = array();
                //$card_db_name = "nhyx";
                $ds_name = implode('|', $card_db_jh);
                //$ds_name = "card_zbsjj";
                if ($card_db_name && $ds_name) {
                    $cards = mf_curl_get("http://api.db.games.mofang.com/?c=api&m=card_search&db_name={$card_db_name}&ds_name={$ds_name}&search={$q}");
                    $card_json = json_decode($cards);
                    if ($card_json->count > 0 && !empty($card_json->data)) {
                        foreach($card_json->data as $card) {
                            $return[] = $card;
                        }
                    }
                }
                foreach($data as $type=>$vals) {
                    foreach($vals as $v) {
                        $re['id'] = $v['id'];
                        $re['catid'] = $v['catid'];
                        $re['url'] = $v['url'];
                        $re['title'] = strip_tags($v['title']);
                        $re['shortname'] = $v['shortname'];
                        $re['thumb'] = $v['thumb'];
                        $re['updatetime'] = $v['inputtime'];
                        $re['modelid'] = $v['modelid'];
                        $return[] = $re;
                    }
                }
                echo json_encode($return);
            }
        } else {
            include    template('search','index');
        }
    }

    /**
     * 專區json請求的搜索 return
     * @author Jozh liu
     */
    public function json_init() {
        // 獲取siteid
        $siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
        $SEO = seo($siteid);

        $type = trim(strip_tags($_GET['type']));
        if ( !in_array($type, array('all', 'news', 'game', 'video')) ){
            $type = 'all';
        }

        $partition = intval(trim($_GET['p']))?:0;
        $json = intval($_GET['json'])?:0;

        $this->db->query("select catname from www_partition where catid={$partition}");
        $catname = $this->db->fetch_array();
        $partition_name = $catname[0]['catname'];

        if ( $json !=0 && $partition != 0) {
            $this->db->query("select setting from www_partition where catid={$partition}");
            $partition_setting = $this->db->fetch_array();
            $setting = string2array($partition_setting[0]['setting']);
            $card_db_name = $setting['card_db_ename'];
            foreach($setting['button_v2'] as $button) {
                if ($button['button_type'] == 1) {
                    $show_catid[] = $button['button_value'];
                } else if ($button['button_type'] == 2) {
                    $card_db_jh[] = $button['button_value'];
                }
            }
            if ($in = implode(',', $show_catid)) {
                $this->db->query("SELECT catid FROM www_partition WHERE parentid IN ($in) OR catid IN ($in)");
                foreach($this->db->fetch_array() as $val) {
                    $specialid[] = 'specialid:'.$val['catid'];
                }
            }
        }

        //搜索配置
        $search_setting = getcache('search');
        $setting = $search_setting[$siteid];

        $search_model = getcache('search_model_'.$siteid);
        $type_module = getcache('type_module_'.$siteid);

        // 查詢前初始化變量
        $totalnums = 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = intval($_GET['pagesize'])?:10;
        $start = ($page-1)*$pagesize;
        $data = array();

        // 檢驗solr服務器是否正常
        if (!strpos($_SERVER['HTTP_HOST'], 'test')) {
            $solr = pc_base::load_app_class('apache_solr_service', '', 0);
            $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
            
            if (!$solr->ping()) {
                echo json_encode($data);
                exit;
            }
        }

        $callback_name = $_GET['jsonpcallback'];

        // 返回方式
        if ( $callback_name ) {
            if ( isset($_GET['keyword']) && !empty($_GET['keyword']) ) {
                $keywords = $_GET['keyword'];
            } else {
                $this->db->query('select `keywords` from www_news where `catid`='.$_GET['catid'].' and `id` ='.$_GET['contid']);
                $keywords = $this->db->fetch_array();
                $keywords = explode(',',$keywords[0]['keywords']);
            }

            foreach($keywords as $q){
                //文章
                try {
                    $additionalParameters = array();
                    $additionalParameters['fq'][] = implode(' || ', $specialid);
                    $news = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                } catch (Exception $e) {
                    echo json_encode($data);
                    exit;
                }

                foreach ($news->response->docs as $key=> $doc) {
                    foreach ($doc as $field => $value) {
                        $new[$key][$field] = $value;
                    }
                }
                $new = $new ? : array();
                $datas[] = array_merge($new, array());
            }
            // 把三維數組重組成二維數組
            $data_all = array();
            foreach($datas as $v){
                foreach($v as $val){
                    array_push($data_all,$val);
                }
            }
            // 把二維數組中的每個一維元素id做其鍵值
            foreach($data_all as $v){
                $nk = $v['id'];
                $data[$nk] = $v;
            }
            sort($data);
            //處理數據
            $return = array();
            foreach($data as $k => $v) {
                if($v['id'] != $_GET['contid']){
                    $re['id'] = $v['id'];
                    $re['catid'] = $v['catid'];
                    if($v['catid'] == $_GET['catid']){
                        $re['url'] = 'http://www.mofang.com/'.$_GET['pname'].'/'.$v['catid'].'_'.$v['id'].'.html';
                        $re['title'] = strip_tags($v['title']);
                        $re['shortname'] = $v['shortname'];
                        $re['thumb'] = $v['thumb'];
                        $re['updatetime'] = $v['inputtime'];
                        $re['modelid'] = $v['modelid'];
                        $return[] = $re;
                    }
                }
            }
            echo $callback_name.'('.json_encode($return).')';
        }else{
            try {
                $additionalParameters = array();
                if ($partition) {
                    $additionalParameters['fq'][] = "partition:{$partition}";
                }
                if ($json) {
                    $additionalParameters['fq'][] = implode(' || ', $specialid);
                }
                $news = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
                
            } catch (Exception $e) {
                echo json_encode($data);
                exit;
            }
            foreach ($news->response->docs as $key=> $doc) {
                foreach ($doc as $field => $value) {
                    $new[$key][$field] = $value;
                }
            }
            $data['new'] = $new;
            $return = array();
            $ds_name = implode('|', $card_db_jh);

            if ($card_db_name && $ds_name) {
                $cards = mf_curl_get("http://api.db.games.mofang.com/?c=api&m=card_search&db_name={$card_db_name}&ds_name={$ds_name}&search={$q}");
                $card_json = json_decode($cards);
                if ($card_json->count > 0 && !empty($card_json->data)) {
                    foreach($card_json->data as $card) {
                        $return[] = $card;
                    }
                }
            }

            foreach($data as $type=>$vals) {
                foreach($vals as $v) {
                    $re['id'] = $v['id'];
                    $re['catid'] = $v['catid'];
                    $re['url'] = $v['url'];
                    $re['title'] = strip_tags($v['title']);
                    $re['shortname'] = $v['shortname'];
                    $re['thumb'] = $v['thumb'];
                    $re['updatetime'] = $v['inputtime'];
                    $re['modelid'] = $v['modelid'];
                    $return[] = $re;
                }
            }
            echo json_encode($return);
        }
    }
    /**
     * 專區搜索 display
     * @author Jozh liu
     */
    public function partition_init() {
        $host = $_SERVER['HTTP_HOST'];

        // 獲取siteid
        $siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
        $SEO = seo($siteid);

        $partition = intval(trim($_GET['p']))?:0;


        // 查詢專區名稱
        $this->db->query("select catname from www_partition where catid={$partition}");
        $catname = $this->db->fetch_array();
        $partition_name = $catname[0]['catname'];

        // 查專區中配置的供搜索的欄目
        if ($partition != 0) {
            $this->db->query("select setting from www_partition where catid={$partition}");
            $partition_setting = $this->db->fetch_array();
            $setting = string2array($partition_setting[0]['setting']);
            $card_db_name = $setting['card_db_ename'];
            foreach($setting['button_v2'] as $button) {
                if ($button['button_type'] == 1) {
                    $show_catid[] = $button['button_value'];
                } else if ($button['button_type'] == 2) {
                    $card_db_jh[] = $button['button_value'];
                }
            }
            if ($in = implode(',', $show_catid)) {
                $this->db->query("SELECT catid FROM www_partition WHERE parentid IN ($in) OR catid IN ($in)");
                foreach($this->db->fetch_array() as $val) {
                    $specialid[] = 'specialid:'.$val['catid'];
                }
            }
        }

        //搜索配置
        $search_setting = getcache('search');
        $setting = $search_setting[$siteid];

        $search_model = getcache('search_model_'.$siteid);
        $type_module = getcache('type_module_'.$siteid);

        // 分頁時使用
        $urlrule = "http://www.mofang.com/tag/".$partition."/{\$keyword}-{\$type}-{\$page}.html";

        // 查詢前初始化變量
        $totalnums = 0;
        $type = $status = 'part';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = intval($_GET['pagesize'])?:10;
        $start = ($page-1)*$pagesize;
        $data = array();

        // 查詢
        if(trim($_GET['q'])=='') {
            header('Location: '.APP_PATH.'index.php?m=search&type=all');exit;
        }else{
            $q = safe_replace(trim($_GET['q']));
            $q = htmlspecialchars(strip_tags($q));
            $q = str_replace('%', '', $q); // 過濾'%'，用戶全文搜索
            $search_q = str_replace('/', '', $q); // 搜索原內容
            $keyword = substr($q, 0, 60); // 截取關鍵字，數據表長度所困

            // SEO信息重寫
            $SEO['title'] = $keyword.'_'.$partition_name.'專區_魔方網';
            $SEO['keyword'] = $keyword.','.$partition_name.'專區';
            $SEO['description'] = '魔方網'.$partition_name.'專區最新'.$keyword.'資訊合集，更多'.$partition_name.'遊戲攻略、視頻、禮包活動，敬請訪問魔方網'.$partition_name.'專區。';
            // 讀取緩存數據並統計搜索次數，測試環境不執行
            if (!strpos($host, 'test')) {
                session_start();
                if (!empty($keyword) && ($_SESSION['search_keyword'] !=$search_q || $_SESSION['search_limit'] < time())) {
                    // session 確保關鍵字統計
                    $_SESSION['search_keyword'] = $search_q;
                    $_SESSION['search_limit'] = time() + 10;
                    // 超出時間限制或者改變關鍵字時，更新關鍵字數據庫
                    $this->hits($keyword);
                }
            }

            // 檢驗solr服務器是否正常
            $solr = pc_base::load_app_class('apache_solr_service', '', 0);
            $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
            
            if (!$solr->ping()) {
                require(PC_PATH."init/smarty.php");
                $smarty = use_v4();
                $smarty->assign("SEO",$SEO);
                $smarty->assign("search_q",$q);
                $smarty->assign("partition_name",$partition_name);
                $smarty->assign("totalnums",$totalnums);
                $smarty->assign("type",$type);
                $smarty->display('sear/index.tpl');
                exit;
            }

            if (get_magic_quotes_gpc() == 1) {
                $query = stripslashes($q);
            }

            if ($partition) {
                $additionalParameters['fq'][] = "partition:{$partition}";
            }

            try {
                $result = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
            } catch (Exception $e) {
                require(PC_PATH."init/smarty.php");
                $smarty = use_v4();
                $smarty->assign("SEO",$SEO);
                $smarty->assign("search_q",$q);
                $smarty->assign("partition_name",$partition_name);
                $smarty->assign("totalnums",$totalnums);
                $smarty->assign("type",$type);
                $smarty->display('sear/index.tpl');
                exit;
            }

            if($result) {
                $totalnums = (int) $result->response->numFound;
            }

            foreach ($result->response->docs as $key=> $doc) {
                foreach ($doc as $field => $value) {
                    $data[$key][$field] = $value;
                }
            }

            // 處理返回數據
            foreach($data as $_k=>$_v) {
                if ($type == 'game') {
                    $tag_ids = explode('-', $_v['_id_']);
                    $data[$_k]['tags'] = linktags($tag_ids[0], $tag_ids[1]);
                }
                $data[$_k]['title'] = str_replace($q, '<span class="sColor">'.$q.'</span>', $_v['title']);
                if ($type == 'video') {
                    $data[$_k]['description'] = strip_tags($_v['description']);
                } else {
                    $data[$_k]['description'] = strip_tags($_v['content']);
                }
            }

            if ($totalnums == 0) {
                $status = 0;
            }
        }

        // 調試
        if ($_GET['test']) {
            var_dump($type, $status);exit;
        }

        // 渲染頁面
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();

        // 基礎參數賦值
        $smarty->assign("SEO",$SEO);
        $smarty->assign("search_q",$search_q);
        $smarty->assign("siteid",$siteid);
        $smarty->assign("partition_name",$partition_name);
        $smarty->assign("type",$type);

        // 數據參數賦值
        $smarty->assign("totalnums",$totalnums);
        $smarty->assign("status",$status);
        $smarty->assign("data",$data);
        $smarty->assign("page",$page);
        $smarty->assign("pagesize",$pagesize);
        $smarty->assign("mfpage",array('keyword'=>$search_q, 'type'=>$type));

        $smarty->display('sear/index.tpl');
    }

    /**
     * 提示搜索接口
     * TODO 暫時未啟用，用的是google的接口
     */
    public function public_suggest_search() {
        //關鍵詞轉換為拼音
        pc_base::load_sys_func('iconv');
        $pinyin = gbk_to_pinyin($q);
        if(is_array($pinyin)) {
            $pinyin = implode('', $pinyin);
        }
        $this->keyword_db = pc_base::load_model('search_keyword_model');
        $suggest = $this->keyword_db->select("pinyin like '$pinyin%'", '*', 10, 'searchnums DESC');

        foreach($suggest as $v) {
            echo $v['keyword']."\n";
        }
    }

    /**
     * 點擊次數統計
     * @param $contentid
     */
    function hits($keyword) {
        $db = pc_base::load_model('search_keyword_model');
        $r = $db->get_one(array('keyword'=>$keyword));
        if($r) {
            //關鍵詞搜索數+1
            $views = $r['views'] + 1;
            $hourviews = (date('YmdH', $r['updatetime']) == date('YmdH', strtotime('-1 hour'))) ? $r['nowviews'] : $r['hourviews'];
            $nowviews = (date('YmdH', $r['updatetime']) == date('YmdH', SYS_TIME)) ? ($r['nowviews']+1) : 1;
            $dayviews = (date('Ymd', $r['updatetime']) == date('Ymd', SYS_TIME)) ? ($r['dayviews'] + 1) : 1;
            $weekviews = (date('YW', $r['updatetime']) == date('YW', SYS_TIME)) ? ($r['weekviews'] + 1) : 1;
            $monthviews = (date('Ym', $r['updatetime']) == date('Ym', SYS_TIME)) ? ($r['monthviews'] + 1) : 1;
            $sql = array('views'=>$views,'hourviews'=>$hourviews,'nowviews'=>$nowviews,'dayviews'=>$dayviews,'weekviews'=>$weekviews,'monthviews'=>$monthviews,'updatetime'=>SYS_TIME);
            return $db->update($sql, array('keyword'=>$keyword));
        } else {
            //新關鍵詞插入
            $views = 1;
            $hourviews = 1;
            $nowviews = 1;
            $dayviews = 1;
            $weekviews = 1;
            $monthviews = 1;
            $sql = array('keyword'=>$keyword,'views'=>$views,'hourviews'=>$hourviews,'nowviews'=>$nowviews,'dayviews'=>$dayviews,'weekviews'=>$weekviews,'monthviews'=>$monthviews,'updatetime'=>SYS_TIME);
            return $db->insert($sql);
        }
    }
}

