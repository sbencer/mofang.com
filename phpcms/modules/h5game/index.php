<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class index{
	function __construct() {
		$this->db = pc_base::load_model('content_model');
        $this->position_h5game_db = pc_base::load_model('position_h5game_model');
        $this->h5game_db = pc_base::load_model('h5game_model');
        $this->check_mobile();

	}
	public function init() {
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $SEO['title'] = 'h5遊戲_html5小遊戲_休閒小遊戲_flash小遊戲-魔方網';
        $SEO['keyword'] = 'h5遊戲,html5小遊戲,休閒小遊戲,flash小遊戲';
        $SEO['description'] = '魔方網h5遊戲專區提供海量在線h5小遊戲，好玩的flash小遊戲，益智休閒小遊戲。找好玩的html5小遊戲，歡迎來魔方網h5遊戲庫';

        //按條件查查詢內容
        $sql = ' `status`=99';
        if($_GET['categoryid']!=0){
            $sql .= ' AND `category`='.intval($_GET['categoryid']);
            $categoryid = intval($_GET['categoryid']);
        }else{
            $categoryid = 0;
        }
        if($_GET['system_type']){
            $system_type = $_GET['system_type'];
            switch ($_GET['system_type']) {
                case 'android':
                    $sql .= ' AND `android`=1';
                    break;
                case 'ios':
                    $sql .= ' AND `ios`=1';
                    break;
                case 'ipad':
                    $sql .= ' AND `ipad`=1';
                    break;    
            }
        }else{
            $system_type = 'all';
        }

        $page = max(intval($_GET['page']),1);
        $pagesize = 16;
        $urlrule = 'list-{$system_type}-{$categoryid}-{$page}.html#game';
        $url_array = array("system_type"=>$system_type,"categoryid"=>$categoryid,"page"=>$page);
        $array = $this->h5game_db->listinfo($sql, $order = 'id desc', $page, $pagesize, '', $setpages = 10,'',$array = array());
        $total = $this->h5game_db->number;
        $pages = $this->h5game_db->pages;
        $smarty->assign("SEO",$SEO); 
        $smarty->assign("array",$array); 
        $smarty->assign("total",$total); 
        $smarty->assign("page",$page); 
        $smarty->assign("pagesize",$pagesize); 
        $smarty->assign("pages",$pages); 
        $smarty->assign("urlrule",$urlrule); 
        $smarty->assign("url_array",$url_array); 
        $smarty->assign("system_type",$system_type); 
        $smarty->assign("categoryid",$categoryid); 
        if(is_mobile() || is_wap() || $_GET['wap']){
            if($system_type=='all' && $categoryid==0){//如果有系統類型或者欄目ID等參數，則說明是列表頁
                $smarty->display('h5_game/m_index.tpl');
            }else{
                $smarty->display('h5_game/m_list.tpl');
            }
        }else{
            $smarty->display('h5_game/index.tpl');
        }
	}

    //列表頁
    public function lists(){
        $type = $_GET['type'];
        $page = max(intval($_GET['page']),1);
        if(!$type || $type==''){
            showmessage('請正確訪問！',HTTP);
        }
        $sql = array();
        switch ($type) {
            case 'android':
                # code...
                $sql = array("android"=>1,"status"=>99);
                $listorder = 'id desc';
                $catename = '安卓遊戲';
                $SEO['title'] = '安卓遊戲_好玩的安卓遊戲_安卓小遊戲大全-魔方網';
                $SEO['description'] = '魔方網h5遊戲頻道,提供最新最好玩的在線安卓小遊戲,魔方網h5安卓小遊戲涵蓋各種各樣的小遊戲,包括射擊、角色扮演等安卓小遊戲。歡迎廣大愛好安卓小遊戲的家來玩哦。';
                $SEO['keyword'] = '安卓遊戲,好玩的安卓遊戲,h5小遊戲';

                break;
            case 'ios':
                # code...
                $sql = array("ios"=>1,"status"=>99);
                $listorder = 'id desc';
                $catename = 'IOS遊戲';
                $SEO['title'] = 'iOS遊戲_好玩的iOS遊戲_iOS小遊戲大全-魔方網';
                $SEO['description'] = '魔方網h5遊戲頻道,提供最新最好玩的在線iOS小遊戲,魔方網h5iOS小遊戲涵蓋各種各樣的小遊戲,包括射擊、角色扮演等iOS小遊戲。歡迎廣大愛好iOS小遊戲的家來玩哦。';
                $SEO['keyword'] = 'iOS遊戲,好玩的iOS遊戲,h5小遊戲';
                break;
            case 'hot':
                # code...
                $sql = array("status"=>99);
                $listorder = 'hot desc';
                $catename = '最多人玩';
                $SEO['title'] = '熱門小遊戲_熱門h5遊戲-魔方網';
                $SEO['description'] = '魔方網h5遊戲頻道提供熱門h5遊戲，熱門小遊戲。找好玩的html5小遊戲，歡迎來魔方網h5遊戲庫';
                $SEO['keyword'] = '熱門h5遊戲,熱門小遊戲';
                break;    
            case 'new':
                # code...
                $sql = array("status"=>99);
                $listorder = 'id desc';
                $catename = '最新遊戲';
                $SEO['title'] = '最新小遊戲_最新h5遊戲-魔方網';
                $SEO['description'] = '魔方網h5遊戲頻道提供最新h5遊戲，最新小遊戲。找好玩的html5小遊戲，歡迎來魔方網h5遊戲庫。';
                $SEO['keyword'] = '最新h5遊戲,最新小遊戲';
                break;    
        }
        $pagesize = 24;
        $array = $this->h5game_db->listinfo($sql, $listorder, $page, $pagesize, '', $setpages = 5,$urlrule='',$array = array());

        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        
        $urlrule = 'type-'.$type.'-{$page}.html';

        $total = $this->h5game_db->number;
        $pages = $this->h5game_db->pages;
        $smarty->assign("SEO",$SEO); 
        $smarty->assign("array",$array); 
        $smarty->assign("total",$total); 
        $smarty->assign("page",$page); 
        $smarty->assign("pagesize",$pagesize); 
        $smarty->assign("pages",$pages); 
        $smarty->assign("catename",$catename); 
        $smarty->assign("urlrule",$urlrule); 
        // $smarty->assign("url_array",$url_array); 
        // $smarty->assign("system_type",$system_type); 
        // $smarty->assign("categoryid",$categoryid);
        if(is_mobile() ||is_wap() || $_GET['wap']){
            $smarty->display('h5_game/m_details.tpl');
        }else{
            $smarty->display('h5_game/list.tpl');
        }
    }

    //內容頁
    public function show(){
        $id = intval($_GET['id']);
        if($id<1){
            showmessage("請通過正常途經訪問",HTTP_REFERER);
        }
        $array = $this->h5game_db->get_one(array("id"=>$id));
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $SEO['title'] = $array['gamename'].'魔方網H5小遊戲 - ';
        $SEO['description'] = $array['content'];
        $SEO['keyword'] = $array['description'];

        if(!empty($array)){
            foreach ($array as $key => $value) {
                # 所有數據進行smarty 賦值
                $smarty->assign("$key",$value);  
            }
        }
        $category_array = array('1'=>'休閒遊戲','2'=>'益智遊戲');
        $smarty->assign("SEO",$SEO);  
        $smarty->assign("category_array",$category_array); 
        // $smarty->assign("category_name",$category_array[$categoryid]); 

        if(is_mobile() || is_wap() || $_GET['wap']){
            $smarty->display('h5_game/m_details.tpl');
        }else{
            $smarty->display('h5_game/detail.tpl');
        }



    }

    //搜索
    public function search(){
        $keywords = $_REQUEST['q'];
        $sql = " `gamename` like '%$keywords%'";
        $array = $this->h5game_db->select($sql,'*',20,'id desc');
        require(PC_PATH."init/smarty.php");
        $smarty = use_v4();
        $SEO['title'] = 'H5小遊戲 魔方網';
        $SEO['description'] = 'H5小遊戲簡介';
        $SEO['keyword'] = 'H5小遊戲 魔方網遊戲試玩';
        $category_array = array('1'=>'休閒遊戲','2'=>'益智遊戲');

        $smarty->assign("SEO",$SEO); 
        $smarty->assign("keywords",$keywords); 
        $smarty->assign("array",$array); 
        $smarty->assign("category_array",$category_array); 

        $smarty->display('h5_game/search.tpl');
    }


    /**
     * 列表頁獲取更多
     */
    public function content_json_list() {
        $positionid = $_GET['positionid'];
        $number = $_GET['number']?intval($_GET['number']) : 4;
        $page = $_GET['page'] ? intval($_GET['page']) : 1 ;
        $new_page = $page + 1;
        $limit = $page*$number.','.$number;
        $array = $this->position_h5game_db->select(array("positionid"=>$positionid,"status"=>99),'*',$limit,'listorder asc');

        

        if(!empty($array)){
            foreach ($array as $key => $value) {
                # code...
                $h5game_array = $this->h5game_db->get_one(array("id"=>$value['gameid']));
                $array[$key]['gamename'] = $h5game_array['gamename'];
                $array[$key]['link'] = $h5game_array['link'];
                $array[$key]['link'] = $h5game_array['link'];
                $array[$key]['icon'] = $h5game_array['icon'];
                $array[$key]['android'] = $h5game_array['android'];
                $array[$key]['ios'] = $h5game_array['ios'];
                $array[$key]['ipad'] = $h5game_array['ipad'];
                $array[$key]['id'] = $h5game_array['id'];
                $array[$key]['hot'] = $h5game_array['hot'];
            }
            //通過fetch 直接獲取數據結構，並組成json格式 
            require(PC_PATH."init/smarty.php");
            $smarty = use_v4(); 
            $smarty->assign("positionid",$positionid); 
            $smarty->assign("page",$page); 
            $smarty->assign("number",$number); 
            $smarty->assign("array",$array); 
            $html = $smarty->fetch('h5_game/widget/widget_wap_position.tpl');

            $return = array();
            $return['code'] = 0;
            $return['data']['nextUrl'] = '?m=h5game&c=index&a=content_json_list&positionid='.$positionid.'&number='.$number.'&page='.$new_page;
            $return['data']['html'] = $html;
            // echo json_encode($return);

        }else{
            $return = array();
            $return['code'] = 0;
            $return['data']['nextUrl'] = '';
            $return['data']['html'] = '';
            // echo json_encode($return);
        } 
        //判斷JSONP
        $callbackname = isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : ( isset($_GET['callback']) ? $_GET['callback'] : '' );
        if ($callbackname) {
            echo $callbackname.'('.json_encode($return).')';
        }else{
            echo json_encode($return);
        }

    }

    //獲取當前欄目下更多遊戲
    public function fenlei_game() {
        $SEO['title'] = 'H5小遊戲 魔方網';
        $SEO['description'] = 'H5小遊戲簡介';
        $SEO['keyword'] = 'H5小遊戲 魔方網遊戲試玩';

        //按條件查查詢內容
        $sql = ' `status`=99';
        if($_GET['categoryid']!=0){
            $sql .= ' AND `category`='.intval($_GET['categoryid']);
            $categoryid = intval($_GET['categoryid']);
        }else{
            $categoryid = 0;
        }
        if($_GET['system_type']){
            $system_type = $_GET['system_type'];
            switch ($_GET['system_type']) {
                case 'android':
                    $sql .= ' AND `android`=1';
                    break;
                case 'ios':
                    $sql .= ' AND `ios`=1';
                    break;
                case 'ipad':
                    $sql .= ' AND `ipad`=1';
                    break;    
            }
        }else{
            $system_type = 'all';
        }

        $page = max(intval($_GET['page']),1);
        $new_page = $page + 1;
        $number = $_GET['number']?intval($_GET['number']) : 14;
        $limit = $page*$number.','.$number;
 

        $array = $this->h5game_db->select($sql,'*',$limit,'id desc'); 
        if(!empty($array)){
            require(PC_PATH."init/smarty.php");
            $smarty = use_v4();
            $smarty->assign("SEO",$SEO); 
            $smarty->assign("array",$array); 
            $smarty->assign("system_type",$system_type); 
            $smarty->assign("categoryid",$categoryid); 
            $html = $smarty->fetch('h5_game/widget/widget_wap_position.tpl');

            $return = array();
            $return['code'] = 0;
            $return['data']['nextUrl'] = '?m=h5game&c=index&a=fenlei_game&system_type='.$system_type.'&categoryid='.$categoryid.'&number=14&page='.$new_page;
            $return['data']['html'] = $html;
            // echo json_encode($return); 
        }else{
            $return = array();
            $return['code'] = 0;
            $return['data']['nextUrl'] = '';
            $return['data']['html'] = '';
            // echo json_encode($return);
        }
        //判斷JSONP
        $callbackname = isset($_GET['jsonpcallback']) ? $_GET['jsonpcallback'] : ( isset($_GET['callback']) ? $_GET['callback'] : '' );
        if ($callbackname) {
            echo $callbackname.'('.json_encode($return).')';
        }else{
            echo json_encode($return);
        }

    }

    //移動端檢測跳轉
    protected function check_mobile() {
        $request_url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        if (isMobile() && !preg_match("/^m\./", $_SERVER['HTTP_HOST'])) {
            $mobile_url = wap_url($request_url);
            if($mobile_url==$request_url){
                return true;
            } 
            header('Location: ' . $mobile_url);
            exit;
        }
        if (!isMobile() && preg_match("/^m\./", $_SERVER['HTTP_HOST'])) {
            $mobile_url = pc_url($request_url);
            header('Location: ' . $mobile_url);
            exit;
        }
    }




}
