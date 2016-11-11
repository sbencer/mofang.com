<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class MY_index extends index {

	private $db;
		function __construct() {
		$this->db = pc_base::load_model('content_model');
        if (ROUTE_A != 'toutiao') {
            parent::__construct();
        }
		$this->on_timed();
	}
	//定時發布
	public function on_timed() {
		$this->content_check_db = pc_base::load_model('content_check_model');
		$ids = $this->content_check_db->select('status=21 and inputtime<='.SYS_TIME,'checkid');
		foreach($ids as $k)
		{
			$k1 = explode('-',$k['checkid']);
			$this->db->set_model($k1[2]);
			$this->db->status($k1[1]);
		}
	}

	//列表頁
	public function iosgames() {
		$linktag_db = pc_base::load_model('linktag_model');
		$devices = array('1'=>'iPhone', '2'=>'iPad', '3'=>'通用');
		$device = @$_GET['dv'];
		
        $tagarray = explode('-', $_GET['tag']);
        foreach($tagarray as $tag) {
            $tagstr[] = "'{$tag}'";
        }
        $tagarray = array_filter($tagarray, 'trim');

        $tags_str = implode(',', $tagstr);
        $linktag_db->query("select tag_id from www_linktag where tag_name in ($tags_str)");
        $ids = $linktag_db->fetch_array();
        $linktag_ids = array();
        foreach($ids as $id) {
            $linktag_ids[] = $id['tag_id'];
        }

        // 有不存在的標簽時，404跳轉
        if (count($tagarray) > count($linktag_ids)) {
            header('HTTP/1.1 404 Not Found'); 
            exit;
        }

        $linktag_ids_str = join(',', $linktag_ids);

		$orderby_type = @$_GET['ob'];
		switch ($orderby_type) {
			case 'hits':
				$orderby = 'h.views DESC';
				break;
			case 'score':
				$orderby = 'm.stars DESC';
				break;
			default:
				$orderby = 'd.release_time DESC';
				break;
		}

		$catid = $_GET['catid'] = intval($_GET['catid']);
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
		if(!isset($CATEGORYS[$catid])) showmessage(L('category_not_exists'),'blank');
		$CAT = $CATEGORYS[$catid];
		$siteid = $GLOBALS['siteid'] = $CAT['siteid'];
		extract($CAT);
		$setting = string2array($setting);
		//SEO
		if(!$setting['meta_title']) $setting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
		define('STYLE',$setting['template_list']);
        $page = intval($_GET['page']);
        $tags_seo = implode('', $tagarray);
        if ( $catid == 20 ) {
			$SEO['title'] = $tags_seo.'iOS手機遊戲合集下載大全-魔方蘋果遊戲網';
			$SEO['keyword'] = sprintf('%1$s小遊戲,%1$s手機遊戲,%1$s遊戲下載,%1$siOS遊戲,%1$s遊戲合集',$tags_seo);
			$SEO['description'] = sprintf('魔方網iOS手機遊戲合集之%1$s遊戲下載大全，提供%1$s小遊戲下載、攻略、視頻、新聞及玩家心得分享。',$tags_seo);
		} elseif ( $catid == 134 ) {
			$SEO['title'] = $tags_seo.'安卓手機遊戲合集下載大全-魔方安卓遊戲網';
			$SEO['keyword'] = sprintf('%1$s小遊戲,%1$s手機遊戲,%1$s遊戲下載,%1$s安卓遊戲,%1$s遊戲合集',$tags_seo);
			$SEO['description'] = sprintf('魔方網安卓手機遊戲合集之%1$s遊戲下載大全，提供%1$s小遊戲下載、攻略、視頻、新聞及玩家心得分享。',$tags_seo);
		}

		$template = $setting['category_template'] ? $setting['category_template'] : 'category';
		$template_list = $setting['list_template'] ? $setting['list_template'] : 'list';

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
		parse_str(substr(strstr($_SERVER['REQUEST_URI'], '?'), 1), $urlparams);
		$urlparams['page'] = 'PAGE';
		$urlrules = $CAT['url'] . '?' . http_build_query($urlparams);
		$urlrules = str_replace('PAGE', '{$page}', $urlrules);
		$tmp_urls = explode('~',$urlrules);
		$tmp_urls = isset($tmp_urls[1]) ?  $tmp_urls[1] : $tmp_urls[0];
		preg_match_all('/{\$([a-z0-9_]+)}/i',$tmp_urls,$_urls);
		if(!empty($_urls[1])) {
			foreach($_urls[1] as $_v) {
				$GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
			}
		}
        $urlrules = APP_PATH.'gamelist/';
        if (!empty($tagarray)) {
            $urlrule[] = implode('-', $tagarray);
        }
        if ($orderby_type) {
            $urlrule[] = $orderby_type;
        }
        if ($page) {
            $urlrule[] = '{$page}';
        }
        $urlrules = $urlrules . implode('-', $urlrule) . '.html';

		define('URLRULE', $urlrules);
		$GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
		$GLOBALS['URL_ARRAY']['catdir'] = $catdir;
		$GLOBALS['URL_ARRAY']['catid'] = $catid;
		include template('content',$template);
	}

    /**
     * 安卓遊戲庫包名重復檢測函數
     * GET[] package包名
     * return 查到遊戲返回遊戲標題 查不到返回0
     */
    public function check_android_package() {
        $package_name = trim($_GET['package']);
        $package_info = explode('&', $package_name);
        $pkg = $package_info[0];
        if ($pkg != '') {
            $androidgames_db = pc_base::load_model('content_model');
            $androidgames_db->table_name = $androidgames_db->db_tablepre.'androidgames';
            $info = $androidgames_db->get_one(array('package_name'=>$pkg),'title');
            if ($info) {
                echo $info['title'];
            } else {
                echo 0;
            }
        }
    }

    /**
     * 遊戲搜索查詢接口
     * @param $_GET['modelid'] 搜索模型 20ios 21android
     * @param $_GET['keyword'] 搜索關鍵字 有則搜索，無則全部
     * return 查到遊戲返回遊戲列表 查不到返回0
     */
    public function public_gamelist() {
		pc_base::load_sys_class('format','',0);
		$show_header = '';
		$model_cache = getcache('model','commons');
		$modelids = array(20,21);
		$modelid = intval($_GET['modelid']);
        $page = intval($_GET['page'])?:1;
        $pagesize = intval($_GET['pagesize'])?:12;

        if (in_array($modelid, $modelids)) {
			$this->db->set_model($modelid);

			if(isset($_GET['keywords'])) {
				$keywords = trim($_GET['keywords']);
				if ($this->db->field_exists('en_title')) {
					$where .= "`title` like '%{$keywords}%' OR `en_title` like '%{$keywords}%'";
				} else {
					$where .= "`title` like '%{$keywords}%'";
				}
			}
            $infos = $this->db->listinfo($where,'',$page,$pagesize);
            $total = $this->db->count($where);

            $return['data'] = $infos;
            $return['total'] = $total;
            echo json_encode($return);
        } else {
            echo json_encode(array());
        }
    }

    /**
     * 遊戲詳情查詢接口
     * @param $_GET['modelid'] 搜索模型 20ios 21android
     * @param $_GET['gameid']  遊戲ID 
     * return 查到遊戲返回遊戲詳情
     */
    public function public_gameinfo() {
		pc_base::load_sys_class('format','',0);
		$show_header = '';
		$model_cache = getcache('model','commons');
		$modelids = array(20,21);
		$modelid = intval($_GET['modelid']);
		$gameid = intval($_GET['gameid']);

        if (in_array($modelid, $modelids) && !empty($gameid)) {
			$this->db->set_model($modelid);
			$tablename = $this->db->table_name;
            $r = $this->db->get_one(array('id'=>$gameid));
            if(!$r || $r['status'] != 99) {
                header("HTTP/1.1 404");
            };

            $this->db->table_name = $tablename.'_data';
            $r2 = $this->db->get_one(array('id'=>$gameid));
            $rs = $r2 ? array_merge($r,$r2) : $r;

            echo json_encode($rs);
        } else {
            echo json_encode(array());
        }
	}

    /**
	 * 百度ping功能
	 * @param $data array 備份的數據數組
	 * @param $tablename 數據所屬數據表
	 * @param $file 備份到的文件
     */
    public function baidu_ping() {
        $url = $_GET['url'];
        if(empty($url)) {
            exit();
        } else {
            //echo 'ok';
        }
        $data = "
        <?xml version='1.0' encoding='UTF-8'?>
        <methodCall>
            <methodName>weblogUpdates.extendedPing</methodName>
            <params>
                <param>
                    <value><string>魔方網 - 專業手機遊戲媒體蘋果安卓手遊產業資訊門戶</string></value>
                </param>
                <param>
                    <value><string>http://www.mofang.com</string></value>
                </param>
                <param>
                    <value><string>{$url}</string></value>
                </param>
                <param>
                    <value><string>http://www.mofang.com</string></value>
                </param>
            </params>
        </methodCall>
        ";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://ping.baidu.com/ping/RPC2');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_exec($curl);
        echo "<script>window.close();</script>";
    }

    /**
     * event 活動模板加載方法
     */
    function event() {
        $event_name = trim($_GET['event_name']);
        $page_name = trim($_GET['page_name']);
        require(PC_PATH."init/smarty.php");
        require(PHPCMS_PATH."event/map.conf.php");
        $smarty = use_v4();
        $tpl = "{$map[$event_name]}/{$page_name}.tpl";
        if(file_exists($smarty->joined_template_dir.$tpl)) {
            $smarty->display($tpl);
        } else {
           header("HTTP/1.1 404 Not Found");     
        }
    }

    /**
     * sitemap 網站地圖加載方法
     */
    function sitemap() {
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $smarty->display('content/mapsite.tpl');
    }

    /*
    * 王漫宇 抽獎活動 收集手機號碼 
    */

    public function lottery_huodong_new(){ 
        $tel = $_GET['tel'];
        $id = $_GET['id'];
        $array_code = array('0'=>49,'7'=>49,'3'=>1,'5'=>1);
        $code_num = weight_rand($array_code);

        $json_array['code'] === 0;
        $json_array['message'] = 'Succeed!';
        $json_array['data']['idx_num'] = $code_num;
        if($code_num==0 || $code_num==7){//未中獎
            $json_array['data']['status'] = 0;
            $json_array['data']['message'] = '很遺憾沒有抽中！歡迎關注我們其它的活動！';
        }else{
            $json_array['data']['status'] = 1;
            switch ($code_num) {
                case 3:
                    $json_array['data']['message'] = '恭喜你中獎了！10Q幣！我們客服會盡快和你聯系進行發獎！';
                    break;
                case 5:
                    $json_array['data']['message'] = '恭喜你中獎了！50Q幣！我們客服會盡快和你聯系進行發獎！';
                    break;
                default:
                    $json_array['data']['message'] = '恭喜你中獎了！10Q幣！我們客服會盡快和你聯系進行發獎！';
                    break;
            }
            $lottery_huodong = pc_base::load_model('lottery_huodong_model');
            // $lottery_huodong->get_one(array(""));
            $lottery_huodong->update(array('code'=>$code_num),array("id"=>$id));
        }
        $json_array['data']['award_type'] = 1;
        $json_array['data']['award_id'] = 1;

        $callbackname = isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : ( isset($_GET['callback']) ? $_GET['callback'] : '' );
        
        if ($callbackname) {
            echo $callbackname.'('.json_encode($json_array).')';
        }else{
            echo json_encode($json_array);
        }

        // $return = json_encode($json_array);
        // echo $return; 
    }
    
    public function lottery_huodong(){
            //檢查手機號是否已經抽過獎
            $array['tel'] = intval($_GET['tel']);
            $array['inputtime'] = SYS_TIME;
            $array['status'] = 0;
            $array['code'] = 0;
            if(!$array['tel']){//手機號不對
                echo 0;exit;
            }
            $lottery_huodong = pc_base::load_model('lottery_huodong_model');
            $today_time = strtotime(date('Y-m-d', time()));//今天零點時間
            $sql = ' `tel`='.$array['tel'].' and `inputtime`>'.$today_time;
            $return_array = $lottery_huodong->select($sql,'*');

            $json_array = array();
            $callbackname = isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : ( isset($_GET['callback']) ? $_GET['callback'] : '' );
            if(!empty($return_array)){
                // echo 0;
                // exit;
                $return_id = 0;
            }else{
                $return_id = $lottery_huodong->insert($array,true);
                // echo $return_id;exit;
            }
            if ($callbackname) {
                echo $callbackname.'('.json_encode($return_id).')';
            }else{
                echo json_encode($return_id);
            }
    }
    /**
     * toutiao 頭條新聞內容合作專用
     */
    public function toutiao() {

        $catid = intval($_GET['catid']);
        $id = intval($_GET['id']);

        if(!$catid || !$id) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

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

        $tablename = $this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
        $r = $this->db->get_one(array('id'=>$id));
        if(!$r || $r['status'] != 99) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }

        // 檢查當前瀏覽器是否移動端，如果不是，跳轉到Web版
        if (!isMobile()) {
            header('Location: ' . $r['url']);
            exit;
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


        $content = preg_replace('|\[page\].*?\[/page\]|i', '', $content);
        $content = str_replace('　', '', $content);
        $content = html5_convert(preg_replace('|\[page\]|i', '', $content));
        //SEO
        $seo_keywords = '';
        if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
        $SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
        $site_title = '魔方網';
        $cat_parentids = explode(',', $this->category['arrparentid']);
        if (count($cat_parentids) > 1) {
            $top_parentid = $cat_parentids[1];
        }
        switch ( $top_parentid ) {
            case 80:
                $site_title = '魔方網';
                break;
            case 100:
                $site_title = '魔方網';
                break;
            case 121:
                $site_title = '魔方網';
                break;
            default:
                break;
        }
        $en_title = $en_title?:$title;
        $SEO['title'] = $title . '-' . $this->category['catname'] . '-' . $site_title;
        if (isset($gameid) && $gameid) {
            $gameinfodb = pc_base::load_model('content_model');
            $gameinfodb->set_model($gameid[0]['model_id']);
            $gameinfo = $gameinfodb->get_one(array('id'=>$gameid[0]['content_id']));
            switch ($this->category['catid']) {
                case 81:
                case 182:
                case 101:
                case 188:
                    $SEO['keyword'] = sprintf('%1$s新聞,%2$s', $gameinfo['title'], $SEO['keyword']);
                    break;
                case 82:
                case 183:
                case 102:
                case 189:
                    $SEO['keyword'] = sprintf('%1$s評測,%2$s', $gameinfo['title'], $SEO['keyword']);
                    break;
                case 83:
                case 184:
                case 103:
                case 190:
                    $SEO['keyword'] = sprintf('%1$s攻略,%2$s', $gameinfo['title'], $SEO['keyword']);
                    break;
                case 91:
                case 92:
                case 93:
                case 111:
                case 112:
                case 113:
                    $SEO['keyword'] = sprintf('%1$s視頻,%2$s', $gameinfo['title'], $SEO['keyword']);
                    break;
            }
            if ($shortname) {
                $SEO['keyword'] = $shortname . ',' . $SEO['keyword'];
            }
            $SEO['description'] = mb_strimwidth($description, 0, 360);
        }

        $pubDate = date('m-d H:i', strtotime($inputtime));
        header("Cache-Control: max-age=3600");
        header("Expires: " . gmdate('D, d M Y H:i:s T', time() + 3600));
        echo <<<EOT
<!doctype html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="http://s0.pstatp.com/inapp/TTDefaultCSS.css?ver=20131129">
        <meta charset="utf-8">
        <meta content="initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
        <meta content="telephone=no" name="format-detection">
        <title>{$SEO['title']}</title>
        <meta name="keywords" content="{$SEO['keyword']}">
        <meta name="description" content="{$SEO['description']}">
</head>

<body>
    <div id="TouTiaoBar">
        <a class="logo" id="logo" href="http://m.mofang.com.tw/">
            <img alt="" onerror="TouTiao.hideBar()" src="http://sts0.mofang.com/mofang_logo_toutiao.png" />
        </a>
    </div>
    <header>
      <h1>$title</h1>
      <div class="subtitle">
        <a href="http://m.mofang.com.tw/" id="source">魔方網</a>
        <time>$pubDate</time>
        <a href="#" onclick="TouTiao.showImage(); return false" id="toggle_img" style="display: none;">顯示圖片</a>
      </div>
    </header>
    <article>$content</article>
    <script src="http://s0.pstatp.com/inapp/TTDefaultJS.js"></script>
    <div style="display: none;">    <script type="text/javascript">        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fe3af60d1c25aad4d47d8a0823579751a' type='text/javascript'%3E%3C/script%3E"));    </script>    </div>
</body>
</html>
EOT;

    }


    // 台湾站延时弹窗
    public function tw_dialog() {

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $catid = $catid = intval($_GET['catid']);
        $smarty->assign('catid', $catid);

        if(!empty($catid)){
            $data['code'] = 0;
            $data['message'] = 'OK';
            $data['data'] = $html = $smarty->fetch('tw_mofang/dialog.tpl');
        } else {
            $data['code'] = 1;
            $data['message'] = 'ERROR';
            $data['data'] = '';   
        }

        if($_GET['test'] == 1) {
            echo $html;
        } else {
            echo json_encode($data);
        }


        
    }

    //列表頁
    public function user_lists() {
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

        if ($parentid != 0 && !in_array($catid, array(173, 174, 175, 176, 178)) ) {
            $SEO['title'] = $catname . ' - ' . $site_title;
        } else {
            $SEO['title'] = $setting['meta_title'];
        }


        define('STYLE',$setting['template_list']);
        $page = max(intval($_GET['page']),1);

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
            $outhorname = trim($_GET['outhorname']);
            $urlrules = APP_PATH . 'user/'.$outhorname.'-{$page}.html';
            define('URLRULE', $urlrules);
            $GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
            $GLOBALS['URL_ARRAY']['catdir'] = $catdir;
            $GLOBALS['URL_ARRAY']['catid'] = $catid;

            require(PC_PATH."init/smarty.php");
            
            if (is_mobile() || is_wap() || $_GET['wap']) {//移動模版渲染
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

                //判斷當前欄目DIR是否唯一，如果唯一則分頁的首頁需要為index.html
                $page_need_index = page_need_index($catdir);
                if($page_need_index==1){
                    $smarty->assign("page_need_index",'yes');
                }else{
                    $smarty->assign("page_need_index",'no');
                }

                // cnzz統計代碼
                $smarty->assign("cnzz_code",$this->_cnzz_code);

                $v4 = array(
                    'list'=>'list',
                );
                if (true) {
                    $test_v4 = array(
                        'list_pic'=>'index',
                        'category_tuji'=>'index',
                        );
                    $v4 = array_merge($v4, $test_v4);
                }
                            
                if (array_key_exists($template, $v4)) {
                    if ($template != 'list_pic' && $template != 'category_tuji') {
                        $template = $v4[$template];
                        $smarty->display('tw_mofang/'.$template.'.tpl');
                    } elseif (true) {
                        $smarty->display('picture/index.tpl');
                    }
                } else {
                    // 蘋果、安卓、魔方攻略助手列表、對話實錄
                    if ( in_array($catid,array(80,100,277,255)) ) {
                        include template('content',$template);
                    } else {
                        $smarty->display('tw_mofang/list_user.tpl');
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



}

