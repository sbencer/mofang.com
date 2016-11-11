<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 短信發送接口
 */
pc_base::load_app_class('smsapi', 'sms', 0); //引入smsapi類
$sms_report_db = pc_base::load_model('sms_report_model');
$mobile = $_GET['mobile'];
$siteid = $_REQUEST['siteid'] ? $_REQUEST['siteid'] : 1;
$sms_setting = getcache('sms','sms');
$sitelist = getcache('sitelist', 'commons');
$sitename = $sitelist[$siteid]['name'];
if(!preg_match('/^1([0-9]{9})/',$mobile)) exit('mobile phone error');
if(intval($sms_setting[$siteid]['sms_enable']) == 0) exit(1); //短信功能關閉

//檢查一個小時內發短信次數是還超過3次
$posttime = SYS_TIME-3600;
$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
$num = $sms_report_db->count($where);
if($num > 2) {
	exit(1);//一小時內發送短信數量超過限制 3 條
}

$sms_uid = $sms_setting[$siteid]['userid'];//短信接口用戶ID
$sms_pid = $sms_setting[$siteid]['productid'];//產品ID
$sms_passwd = $sms_setting[$siteid]['sms_key'];//32位密碼
$smsapi = new smsapi($sms_uid, $sms_pid, $sms_passwd); //初始化接口類

$id_code = random(6);//唯一嗎，用於擴展驗證
$send_txt = '尊敬的用戶您好，您在'.$sitename.'的注冊驗證碼為：'.$id_code.'，驗證碼有效期為5分鐘。'; 
$content = safe_replace($send_txt);
$sent_time = intval($_POST['sendtype']) == 2 && !empty($_POST['sendtime'])  ? trim($_POST['sendtime']) : date('Y-m-d H:i:s',SYS_TIME);
$smsapi->send_sms($mobile, $content, $sent_time, CHARSET,$id_code); //發送短信
exit(1);
?>