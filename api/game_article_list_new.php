<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
  * 根據包名查詢相關的文章列表（攻略，教程）
  * 本接口包含對新、老產品庫關聯數據的整合
  */
$test = $_GET['test'] ? $_GET['test'] : 0;
$videoBack = $_GET['videoBack'];
$type = $_GET['type'] ? $_GET['type'] : 1;//1 代表安卓  0： 蘋果 
$package_name = $_GET['package_name'];//包名
$page = max(intval($_GET['page']), 1);
$pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 10;
$offset = $pagesize*($page-1);
$limit = "$offset,$pagesize";

if(empty($package_name)){
	//未取對應的視頻信息 
	$err_info['code'] = -1;
	$err_info['msg'] = '請根據包名來調取對應的文章!';
	$return = json_encode($err_info);
	if($videoBack){
		echo $videoBack."($return)";
	}else{
		echo $return;
	}
	exit();
}

//定義文章數組
$article_array = array();

$modelid_array = array(20,21);
$modelid = $modelid_array[$type]; //計算當前查詢MODELID值
$content_db= pc_base::load_model('content_model');
$content_db->set_model(1);	

//根據包名，查出新、老ID 
$game_search = $type.'-'.$package_name;
$game_search_key = sha1($game_search);
$game_search_key .= '_ids';
if(!$datas = getcache($game_search_key, '', 'memcache', 'html')) { 
	$request_api = "http://game.mofang.com/api/web/GetGameIdsByPackage?type=".$type."&packages=".$package_name;
	$datas = mf_curl_get($request_api);
	$datas = json_decode($datas,true);
	setcache($game_search_key, $datas, '', 'memcache', 'html', 36000);
}else{
	$datas = getcache($game_search_key, '', 'memcache', 'html');
} 

//先讀緩存，不存在再連查 
$game_search = $type.'_'.$package_name;
$game_search_key = sha1($game_search);
$game_search_key .= '_articlelists_'.$page;
if(isset($test) || !$article_array = getcache($game_search_key, '', 'memcache', 'html') ) {  
	//緩存沒有文章列表，則查表獲取列表
	if($datas['code']=='0'){
		//根據新ID,或者老ID的關聯，查出來關聯了此遊戲的文章列表
		$oldgame_query = "|$modelid-".$datas['data']['oldgameid'][0]."|";
		$query_sql = " select content.id, content.catid, content.title, content.shortname,content.keywords,content.thumb,content.description,content.url,content.gameid, content.inputtime,content_d.content,content_d.relation_game from  www_news as content,www_news_data as content_d where content.id = content_d.id and (content.`gameid`='$oldgame_query' or content_d.`relation_game`='".$datas['data']['newgameid']."') ORDER BY content.id desc limit $limit";
		$sql_return = $content_db->query($query_sql);
		$article_array = $content_db->fetch_array();
		//結合返回數據，並寫入緩存
		$err_info['code'] = 0;
		$err_info['msg'] = 'ok';
		$err_info['data'] = $article_array;
		setcache($game_search_key, $article_array, '', 'memcache', 'html', 36000);
	}else{
		//未取對應的視頻信息 
		$err_info['code'] = -2;
		$err_info['msg'] = '此遊戲無關聯文章信息!'; 
	}
}else{
	//直接從緩存中取文章列表
	$article_array = getcache($game_search_key, '', 'memcache', 'html');
	$err_info['code'] = 0;
	$err_info['msg'] = 'ok';
	$err_info['data'] = $article_array;
} 

//測試查看使用
if($_GET['test']=="test"){
	print_r($err_info);exit;
}
$return = json_encode($err_info);
if($videoBack){
	echo $videoBack."($return)";
}else{
	echo $return;
}
exit; 

?>