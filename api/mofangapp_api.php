<?php
/**
 * 魔方游戏宝 - APP 
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

// $video_setting = getcache('video','video');

  
// $xxtea = pc_base::load_app_class('xxtea', 'video');
// $token = $_POST['token'];
// $decode_token = $xxtea->decrypt($token,$video_setting['skey']);
// if(empty($_POST['posttime']) || $decode_token != $_POST['posttime']) {
// 	echo json_encode(array('msg'=>'Authentication Failed','code'=>'-2'));
// 	exit;
// }
// $action = $_POST['action'];
// if(isset($_GET['action'])) $action = 'ping';
// 
$action = $_REQUEST['action'];

if (!preg_match('/([^a-z_]+)/i',$action) && file_exists(PHPCMS_PATH.'api/mofangapp_api/'.$action.'.php')) {
	include PHPCMS_PATH.'api/mofangapp_api/'.$action.'.php';
} else {
	exit('mofangapp action does not exist');
}
?>
