<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
* 導出最近新加、有關聯關系的遊戲信息，供編輯在新的產品庫中進行入庫 
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-3).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 


$MODEL = getcache('model','commons');
// $modelid = $modelid_array[$type]; //計算當前查詢MODELID值
$content_db= pc_base::load_model('content_model');
$gameout_db= pc_base::load_model('gameout_model');
$content_db->set_model(21);	

$page = 1; 
$pagesize= 15; 
$start = 0;   
while($start>=0){
	$offset = $pagesize*($page-1);
	$limit = "$offset,$pagesize";
	$rs = $content_db->query("select id,title,icon,url,package_name from www_androidgames where status=99 ORDER BY id desc limit $limit");
	$data = $content_db->fetch_array(); 
	if(!empty($data)){
		//循環查詢該遊戲是否關聯信息
		foreach ($data as $key => $value) {
			if($value['newid']==0){//不在以前1390多的數據裡面。
				//查詢是否有關聯關系，波及2個表，news,www_videos 表 
				$content_db->set_model(1);	
				$query = '|21-'.$value['id'].'|';
				// $content_search_result = $content_db->query("select id,title from www_news where `gameid`='$query'");
				// $result = $content_db->fetch_array(); 
				$content_search_result = $content_db->get_one(array("gameid"=>$query),'id');
				//從視頻表中查詢是否有關聯
				$video_rs = $content_db->query("select id from www_video where `gameid`='$query'");
				$video_search_result = $content_db->fetch_array(); 
				//文章和視頻只要關聯了一個，即表示需要去新庫進行添加
				if(!empty($content_search_result) || !empty($video_search_result)){
					//插入數據庫
					$array = array();
					$array['gameid'] = $value['id'];
					$array['title'] = $value['title'];
					$array['icon'] = $value['icon'];
					$array['url'] = $value['url'];
					$array['package_name'] = $value['package_name'];
					$array['status'] = 0;
					$gameout_db->insert($array);
				} 
			}
		}
		$page = $page+1;
		$start = 0;
	}else{
		//結果為空，說明查詢已經到最後
		echo '查詢全部結果！';
		$start = -1;
		exit();
	}
}
 
  
?>