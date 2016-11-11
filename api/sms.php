<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 短信發送接口
 */
pc_base::load_app_class('smsapi', 'sms', 0); //引入smsapi類
$sms_report_db = pc_base::load_model('sms_report_model');
$mobile = $_GET['mobile'];
$siteid = get_siteid() ? get_siteid() : 1 ;
$sms_setting = getcache('sms','sms');
if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) exit('mobile phone error');
$posttime = SYS_TIME-86400;
$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
$num = $sms_report_db->count($where);
if($num > 3) {
	exit('-1');//當日發送短信數量超過限制 3 條
}
//同一IP 24小時允許請求的最大數
$allow_max_ip = 10;//正常注冊相當於 10 個人
$ip = ip();
$where = "`ip`='$ip' AND `posttime`>'$posttime'";
$num = $sms_report_db->count($where);
if($num >= $allow_max_ip) {
	exit('-3');//當日單IP 發送短信數量超過 $allow_max_ip
}
if(intval($sms_setting[$siteid]['sms_enable']) == 0) exit('-99'); //短信功能關閉
$sms_uid = $sms_setting[$siteid]['userid'];//短信接口用戶ID
$sms_pid = $sms_setting[$siteid]['productid'];//產品ID
$sms_passwd = $sms_setting[$siteid]['sms_key'];//32位密碼

$id_code = random(6);//唯一嗎，用於擴展驗證
//$send_txt = '尊敬的用戶您好，您在'.$sitename.'的注冊驗證碼為：'.$id_code.'，驗證碼有效期為5分鐘。';
$send_txt = $id_code;

$send_userid = intval($_GET['send_userid']);//操作者id


$smsapi = new smsapi($sms_uid, $sms_pid, $sms_passwd); //初始化接口類
$smsapi->get_price(); //獲取短信剩余條數和限制短信發送的ip地址
$mobile = explode(',',$mobile);

$tplid = 1;
$sent_time = intval($_POST['sendtype']) == 2 && !empty($_POST['sendtime'])  ? trim($_POST['sendtime']) : date('Y-m-d H:i:s',SYS_TIME);
$smsapi->send_sms($mobile, $send_txt, $sent_time, CHARSET,$id_code,$tplid); //發送短信
//echo $smsapi->statuscode; 由於服務器延遲的問題，先返回發送成功的提示，以免頁面等待時候過長，體驗不好
echo 0;
?>