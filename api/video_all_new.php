<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
error_reporting(0);
/**
  * 為合作伙伴提供新增加視頻，對應的包名及樂視ID等信息。
  */
$test = $_GET['test'] ? $_GET['test'] : 0;
$videoBack = $_GET['videoBack'];
$page = max(intval($_GET['page']), 1);
$pagesize = 20;
$offset = $pagesize*($page-1);
$limit = "$offset,$pagesize";

$select_catid = 472; //指定欄目ID，只搜索指定遊戲視頻攻略大全
$modelid_array = array(20,21);
$MODEL = getcache('model','commons');
$content_db= pc_base::load_model('content_model');
$content_db->set_catid($select_catid);	

//先取緩存 
$video_lists = 'video_lists_new_'.$page; 
if(!empty($test) || !$video_all_datas = getcache($video_lists, '', 'memcache', 'html')) { 
	$query_sql =  "select video.id, video.title,video.keywords,video.thumb,video.description,video.url, video.updatetime, video.videotime, video.gameid, video_d.letv_id,video_d.relation_game from  www_video as video,www_video_data as video_d where video.`catid`= $select_catid AND (video.`gameid`!='' or video_d.`relation_game`!='') and video.id = video_d.id  and video_d.letv_id!='' ORDER BY video.id desc limit $limit"; 

	$sql_return = $content_db->query($query_sql);
	$rs = $content_db->fetch_array(); 
	if(!empty($rs)){
		foreach ($rs as $key => $value) {
			//根據新ID，獲取包名
			if(!empty($value['relation_game'])){
				$new_gameid = intval($value['relation_game']);
				$game_api = "http://game.mofang.com/api/web/GetGameInfo?id=".$new_gameid;
				$datas = mf_curl_get($game_api);
				$datas = json_decode($datas,true);
				if($datas['code']==0){
					$value['package_name']['android'] =  $datas['data']['package'];
					$value['package_name']['ios'] =  $datas['data']['url_scheme'];
				}
			}else{
				//根據老ID，獲取包名 
				$search_array = explode("-", $value['gameid']);
				$type = str_replace('|','',$search_array[0]);
				$old_gameid = str_replace('|','',$search_array[1]);
				//根據關鍵的遊戲ID，查詢包名(李偉接口)
				$request_api = "http://game.mofang.com/api/web/GetGamePackagesByOldId?type=".$type."&id=".$old_gameid;
				$api_datas = mf_curl_get($request_api);
				$api_datas = json_decode($api_datas,true);
				if($type==21){
					$value['package_name']['android'] =  $api_datas['data'];
				}else{
					$value['package_name']['ios'] =  $api_datas['data'];
				}
			}
			
			$value['uu'] =  'bc8ddac985';
			$value['vu'] =  $value['letv_id'];
			// $datas[] = $value;
		}
	}	
	$video_all_datas = $rs;
	//存入緩存中 
	setcache($video_lists, $rs, '', 'memcache', 'html', 1800);
}else{
	$video_all_datas = getcache($video_lists, '', 'memcache', 'html');
}

$err_info['code'] = 0;
$err_info['msg'] = 'ok';
$err_info['data'] = $video_all_datas;
$return = json_encode($err_info);
if($videoBack){
	echo $videoBack."($return)";
}else{
	echo $return;
}
exit;

  
?>