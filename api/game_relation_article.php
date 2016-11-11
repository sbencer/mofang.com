<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
  * 根據新遊戲ID，查詢指定欄目的文章列表  - 李偉產品庫詳情頁使用 
  * 其它說明： 因需要的欄目下文章關聯遊戲的比較少，暫時以遊戲名，匹配標題進行查詢，並做緩存，以後文章增加，使用關聯的新庫ID進行查詢
  */

// $test = $_GET['test'] ? $_GET['test'] : 0;
// $type = $_GET['type'] ? $_GET['type'] : 1;//1 代表安卓  0： 蘋果 
// $package_name = $_GET['package_name'];//包名
// $page = max(intval($_GET['page']), 1);
// $pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 10;
// $offset = $pagesize*($page-1);
// $limit = "$offset,$pagesize";

//開始
$videoBack = $_GET['videoBack'];
$gameid = intval($_GET['gameid']);
$catid = intval($_GET['catid']);
$game_name = $_GET['gamename'];
$number = intval($_GET['number']);
$test = $_GET['test']= 'test';


if(!$game_name || !$gameid || !$catid || !in_array($catid, array('1023','689','687'))){
	//未取對應的文章信息 
	$err_info['code'] = -1;
	$err_info['msg'] = '請根據遊戲名和遊戲ID來調取對應的文章!';
	$return = json_encode($err_info);
	if($videoBack){
		echo $videoBack."($return)";
	}else{
		echo $return;
	}
	exit();
}


//先獲取緩存 
$game_search = $gameid.'-'.$catid.'-article';
$game_search_key = sha1($game_search);
$game_search_key .= '_lists';

if($test=='test'){
	$catids['1023'] = ' `catid` in (1157,1311,1393,1454)';//評測
    $catids['689'] = ' `catid` in (1019, 83, 184, 103, 190)';//攻略
    $catids['687'] = ' `catid` in (81, 182, 101, 188, 1149, 1150, 1166, 1167)';//新聞

	//定義文章數組
	$article_array = array();
	$content_db= pc_base::load_model('content_model');
	$content_db->set_model(1);	
	$sql = $catids[$catid]." AND `status`=99 AND `title` like '%$game_name%' ";
	$article_array = $content_db->select($sql,'id,catid,title,thumb,description,url,inputtime',$number,'id desc');
	//組成返回數據
	$err_info['code'] = 0;
	$err_info['msg'] = 'ok';
	$err_info['data'] = $article_array;
	//寫緩存
	setcache($game_search_key, $article_array, '', 'memcache', 'html', 7200);
}else{
	if(!$datas = getcache($game_search_key, '', 'memcache', 'html')) {
	    $catids['1023'] = ' `catid` in (1157,1311,1393,1454)';//評測
	    $catids['689'] = ' `catid` in (1019, 83, 184, 103, 190)';//攻略
	    $catids['687'] = ' `catid` in (81, 182, 101, 188, 1149, 1150, 1166, 1167)';//新聞

		//定義文章數組
		$article_array = array();
		$content_db= pc_base::load_model('content_model');
		$content_db->set_model(1);	
		$sql = $catids[$catid]." AND `status`=99 AND `title` like '%$game_name%' ";
		$article_array = $content_db->select($sql,'id,catid,title,thumb,description,url,inputtime',$number,'id desc');
		//組成返回數據
		$err_info['code'] = 0;
		$err_info['msg'] = 'ok';
		$err_info['data'] = $article_array;
		//寫緩存
		setcache($game_search_key, $article_array, '', 'memcache', 'html', 7200);
	}else{
		$datas = getcache($game_search_key, '', 'memcache', 'html');
		$err_info['code'] = 0;
		$err_info['msg'] = 'ok';
		$err_info['data'] = $datas;
	}
}



$return = json_encode($err_info);
if($videoBack){
	echo $videoBack."($return)";
}else{
	echo $return;
}
exit; 

?>