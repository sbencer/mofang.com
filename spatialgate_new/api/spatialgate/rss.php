<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

$rss = new rss;
$true_action = trim($_GET['action']);

$return = array();

if(!method_exists($rss,$true_action)){
    $return['code'] = -1;
    $return['message'] = '接口方法不存在，请检查!';
    $return['data'] = "";
} else {
    $return = $rss->$true_action(); 
} 
exit;

/**
  *  rss相关接口
  *  wangguanqing@mofang.com 
  *  直接输出XML，不再进行json转化
  */
class rss {
	function __construct() {
		$this->db = pc_base::load_model('content_model');
		
	}
	// 指定栏目ID生成RSS，$page $pagesize 等参数  
	public function get_rss_bycatid(){
		$catid = intval($_GET['catid']);
		$page = $_GET['page'] ? intval($_GET['page']) : 1;
		$pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 20;
		if(!$catid){
			$return['code'] = -2;
		    $return['message'] = '栏目ID为空!请检查！';
		    $return['data'] = "";
		    return $return;
		}

		pc_base::load_app_class('rssbuilder_new','content','','0');  
		$sitedomain = 'http://www.spatialgate.com.tw';  //获取站点域名
		$MODEL = getcache('model','commons');
	    $encoding   =  CHARSET;
	    $about      =  'http://www.spatialgate.com.tw/';
	    // $about      =  SITE_PROTOCOL.SITE_URL;
	    $title      =  '魔方网';
	    $description = 'description';
	    $image_link =  "<![CDATA[ http://www.spatialgate.com.tw/ ]]> ";
	    $image_title =  "<![CDATA[ 次元角落 - 情报 ]]> ";
	    $image_url =  "<![CDATA[ http://sts0.mofang.com.tw/statics/v4/tw_acg/img/acg_logo_5992ce4.png ]]> ";
	    $category   =  '';
	    $cache      =  60;
	    $rssfile    = new RSSBuilder($encoding, $about, $title, '', $image_link, $image_title, $image_url, $category, '');
	    $publisher  =  '';
	    $creator    =  SITE_PROTOCOL.SITE_URL;
	    $date       =  date('r');
	    $rssfile->addDCdata(); 

	    // $this->db->table_name = $this->db->db_tablepre.'news';
		$this->db->set_model(1);
	    $sql = array('catid'=>$catid,"status"=>99);
	    $info = $this->db->listinfo($sql,$order = 'id desc ',  $page, $pagesize);

		foreach ($info as $arr) {
			//获取文章详情
			$array = array();
			$this->db->set_model(1);
			$r = $this->db->get_content($arr['catid'],$arr['id']);
		    //添加项目
	        $about          =  $link = (strpos($r['url'], 'http://') !== FALSE || strpos($r['url'], 'https://') !== FALSE) ? "<![CDATA[".$r['url']."]]> " : (($content_html == 1) ? "<![CDATA[".substr($sitedomain,0,-1).$r['url']."]]> " : "<![CDATA[".substr(APP_PATH,0,-1).$r['url']."]]> ");
	        $title          =   "<![CDATA[".$r['title']."]]> ";
	        $description    =  "<![CDATA[".$r['content']."]]> ";
	        $subject        =  '';
	        $date           =  date('D, d M Y H:i:s' , $r['inputtime']);
	        $author         =  '次元角落';
	        $comments       =  '';//注释;
	        // $rssfile->addItem('',$id, $title, $link, $description, $subject, $date,	$author, $comments, $image,$catname,$gamename);

	        $rssfile->addItem('', $id,$title, $link, $description, $subject, $date,	$author, $comments, $image);
		}	
		$version = '2.00';
    	$rssfile->outputRSS($version);

	}

	//获取专区的栏目RSS输出 $partition,$catid
	public function get_rss_bypartition(){
		$catids = safe_replace($_GET['catids']);
		$page = $_GET['page'] ? intval($_GET['page']) : 1;
		$pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 20;

		//判断专区和CATID是否存在
		if(!$catids){
			$return['code'] = -2;
		    $return['message'] = '专区或栏目不存在!请检查！';
		    $return['data'] = "";
		    return $return;
		}

		pc_base::load_app_class('rssbuilder_new','content','','0');  
		$sitedomain = 'http://www.mfoang.com.tw';  //获取站点域名
		$MODEL = getcache('model','commons');
	    $encoding   =  CHARSET;
	    $about      =  'http://www.mofang.com.tw/';
	    // $about      =  SITE_PROTOCOL.SITE_URL;
	    $title      =  '魔方网';
	    $description = 'description';
	    $image_link =  "<![CDATA[ http://www.mofang.com/ ]]> ";
	    $image_title =  "<![CDATA[ 魔方网 - 专区 ]]> ";
	    $image_url =  "<![CDATA[ http://sts0.mofang.com.tw/statics/v4/common/img/hw/v1/log_tw_4b2189c.png ]]> ";
	    $category   =  '';
	    $cache      =  60;
	    $rssfile    = new RSSBuilder($encoding, $about, $title, '', $image_link, $image_title, $image_url, $category, '');
	    $publisher  =  '';
	    $creator    =  SITE_PROTOCOL.SITE_URL;
	    $date       =  date('r');
	    $rssfile->addDCdata(); 

	    // $this->db->table_name = $this->db->db_tablepre.'news';
	    //获取专区栏目下的文章内容
	    $partition_games_db = pc_base::load_model('partition_games_model');
	    if(strpos('|', $catids)){//多栏目数据获取
	    	$catids = trim($catids);
	    	$catids = trim($catids,'|');//去除空格及前后的|号
	    	$ids = explode('|', $catids);
	    	$ids = implode(',',$ids);

	    	$sql = " `part_id` in ($ids)";
	    }else{//单独栏目
	    	$sql = array('part_id'=>$catids);
	    }
	    $info = $partition_games_db->listinfo($sql,$order = 'id desc ',  $page, $pagesize);

	    //获取栏目名称
	    $partition_db = pc_base::load_model('partition_model');

		foreach ($info as $arr) {
			//获取栏目名称+游戏名称
			$cat_array =  $this->get_partition($arr['part_id']);

			//获取文章详情
			$array = array();
			$this->db->set_model(1);
			$con_arr = $this->db->get_one(array('id'=>$arr['gameid']),'id,catid');
			$r = $this->db->get_content($con_arr['catid'],$con_arr['id']);
		    //添加项目
	        $about          =  $link = (strpos($r['url'], 'http://') !== FALSE || strpos($r['url'], 'https://') !== FALSE) ? "<![CDATA[".$r['url']."]]> " : (($content_html == 1) ? "<![CDATA[".substr($sitedomain,0,-1).$r['url']."]]> " : "<![CDATA[".substr(APP_PATH,0,-1).$r['url']."]]> ");
	        $id          =   "<![CDATA[".$r['id']."]]> ";
	        $image          =   "<![CDATA[".$r['thumb']."]]> ";
	        $catname          =   "<![CDATA[".$cat_array['catname']."]]> ";//栏目名称
	        $gamename          =   "<![CDATA[".$cat_array['gamename']."]]> ";//游戏名称
	        $title          =   "<![CDATA[".$r['title']."]]> ";
	        $description    =  "<![CDATA[".$r['content']."]]> ";
	        $subject        =  '';
	        $date           =  date('D, d M Y H:i:s' , $r['inputtime']);
	        $author         =  '魔方网台湾站';
	        $comments       =  '';//注释;

	        $rssfile->addItem('',$id, $title, $link, $description, $subject, $date,	$author, $comments, $image,$catname,$gamename);
		}	
		$version = '2.00';
    	$rssfile->outputRSS($version);
	}


	//根据子栏目ID，获取专区名称
	public function get_partition($partid){
		$partid = intval($partid);
	    $partition_db = pc_base::load_model('partition_model');
	    //子栏目数据
	    $partition_array = $partition_db->get_one(array('catid'=>$partid));
	    // $ids = str_replace('0,', '', $partition_array['arrparentid']);
	    $id_array = explode(',', $partition_array['arrparentid']);
	    // $partenid = min($id_array);
	    $array = $partition_db->get_one(array('catid'=>$id_array[1]));
	    $new_array = array();
	    $new_array['catname'] = $partition_array['catname'];
	    $new_array['gamename'] = $array['catname'];
	    return $new_array;
	}
	 
}