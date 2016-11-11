<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
* 重新過濾一下導出的數據，裡面有些已經有關聯關系。  
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
	$rs = $gameout_db->query("select id,gameid from www_gameout ORDER BY id desc limit $limit");
	$data = $gameout_db->fetch_array(); 
	if(!empty($data)){
		foreach ($data as $key => $value) {
			//取的數據查一下andgames表，對應的newid是否為0，不為0.則設為3
			$array = $content_db->get_one(array("id"=>$value['gameid']),'newid');
			if($array['newid']!=0){
				$gameout_db->update(array("status"=>3),array("id"=>$value['id'])); 
				echo '查到一條newid不為空的數據，對應ID是：'.$value['id'].' gameid是：'.$value['gameid'];
			}
		}
	}else{
		//結果為空，說明查詢已經到最後
		echo '過慮結束！！！';
		$start = -1;
		exit();
	}
}
	




 
 
  
?>