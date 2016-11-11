<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
* 把從6.1號關聯遊戲的文章讀出來，把遊戲存入gameout_test表
* 如果遊戲已經存在，則不再重復插入
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-3).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 


$MODEL = getcache('model','commons');
// $modelid = $modelid_array[$type]; //計算當前查詢MODELID值
$content_db= pc_base::load_model('content_model');
$gameout_db= pc_base::load_model('gameout_test_model');
$content_db->set_model(1);	

$page = 1; 
$pagesize= 20; 
$start = 0;   
while($start>=0){
	$offset = $pagesize*($page-1);
	$limit = "$offset,$pagesize";
	$rs = $content_db->query("select id,title,gameid from www_news where `inputtime`>'1401552001' and `gameid`!='' ORDER BY id desc limit $limit");
	$data = $content_db->fetch_array(); 
	if(!empty($data)){
		//對結果循環入庫
		foreach ($data as $key => $value) {
			//安卓的才入庫
			if(strstr($value['gameid'],'21')){
				//查詢遊戲詳情
				$gameid_array = explode("-", $value['gameid']);
				$gameid = intval($gameid_array[1]);
				$rs = $content_db->query("select id,title,icon,url,package_name from www_androidgames where id=".$gameid." and newid=0");
				$game_data = $content_db->fetch_array(); 
				if(!empty($game_data)){
					$array = array();
					$array['gameid'] = $game_data['id'];
					$array['title'] = $game_data['title'];
					$array['icon'] = $game_data['icon'];
					$array['url'] = $game_data['url'];
					$array['package_name'] = $game_data['package_name'];
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