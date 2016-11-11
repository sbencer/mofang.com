<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
  * 為合作伙伴提供新增加視頻，對應的包名及樂視ID等信息。
  */

$videoBack = $_GET['videoBack'];
$page = max(intval($_GET['page']), 1);
// $pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 2;
$pagesize = 20;
$offset = $pagesize*($page-1);
$limit = "$offset,$pagesize";

$select_catid = 472; //指定欄目ID，只搜索指定遊戲視頻攻略大全
$modelid_array = array(20,21);
$MODEL = getcache('model','commons');
// $modelid = $modelid_array[$type]; //計算當前查詢MODELID值
$content_db= pc_base::load_model('content_model');
$content_db->set_catid($select_catid);	
$query_sql =  "select video.id, video.catid, video.title, video.description, video.gameid, video.inputtime, video.updatetime, video.videotime, video_d.letv_id from  www_video as video,www_video_data as video_d where  video.id = video_d.id and  video.`gameid`!='' and video_d.letv_id!='' ORDER BY video.id desc limit $limit"; 
$sql_return = $content_db->query($query_sql);
$rs = $content_db->fetch_array(); 

$datas =  array();
if(!empty($rs)){
	foreach ($rs as $key => $value) {
		//獲取關聯的遊戲ID及TYPEID值  
		$search_array = explode("-", $value['gameid']);
		$type = str_replace('|','',$search_array[0]);
		$old_gameid = str_replace('|','',$search_array[1]);
		//根據關鍵的遊戲ID，查詢包名(李偉接口)
		$request_api = "http://game.mofang.com/api/web/GetGamePackagesByOldId?type=".$type."&id=".$old_gameid;
		$api_datas = mf_curl_get($request_api);
		$api_datas = json_decode($api_datas,true);
		$value['package_name'] =  $api_datas['data'];
		// $value['package_name'] = 'package_name';
		$datas[] = $value;
	}
} 
$err_info['code'] = 0;
$err_info['msg'] = 'ok';
$err_info['data'] = $datas;
$return = json_encode($err_info);
if($videoBack){
	echo $videoBack."($return)";
}else{
	echo $return;
}
exit;
  
?>