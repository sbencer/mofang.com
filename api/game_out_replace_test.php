<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
* 請求李偉新接口， 傳遞包名和老的遊戲ID，由李偉新接口更新老遊戲ID到新庫中  
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-3).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 


$MODEL = getcache('model','commons');
$content_db= pc_base::load_model('content_model');
$gameout_db= pc_base::load_model('gameout_test_model');
$content_db->set_model(21);	

$page = 1; 
$pagesize= 20; 
$start = 0;   
$num = 1;
while($start>=0){
	$offset = $pagesize*($page-1);
	$limit = "$offset,$pagesize";
	$rs = $gameout_db->query("select id,gameid,package_name,status from www_gameout ORDER BY id desc limit $limit");
	$data = $gameout_db->fetch_array(); 
	if(!empty($data)){
		foreach ($data as $key => $value) {
			if($value['status']==0){
				//請求李偉接口，傳遞數據
				$package_name = strtolower($value['package_name']);
				$request_api = "http://game.mofang.com/api/web/SaveOldGameId?package_name=".$package_name."&old_gameid=".$value['gameid'];
				$datas = mf_curl_get($request_api);
				$datas = json_decode($datas,true);
				//code=0李偉已經更新成功，本地要更新newid 
				if($datas['code']=='0') {
					//更新newid值，到andriogame表中
					$newid = $datas['data']['game_id'];
					$content_db->update(array("newid"=>$newid),array("id"=>$value['gameid']));
					$gameout_db->update(array("status"=>4),array("id"=>$value['id']));
					$num++;
				}
			}
			
		}
		$page = $page+1;
		$start = 0;
	}else{
		//結果為空，說明替換已經到最後
		echo '過慮結束！！！共更新新產品庫'.$num.'條記錄！';
		$start = -1;
		exit();
	}
}
 
  
?>