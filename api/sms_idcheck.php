<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 短信驗證接口
 */
 if($_GET['action']=='id_code') {
 	$sms_report_db = pc_base::load_model('sms_report_model');
	$mobile_verify = $_GET['mobile_verify'];
 	if(!$mobile_verify || preg_match("/[^a-z0-9]+/i",$mobile_verify)) exit();
	$mobile = $_GET['mobile'];
	if($mobile){
 		if(!preg_match('/^1([0-9]{10})$/',$mobile)) exit('check phone error');
		$posttime = SYS_TIME-600;
		$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
		$r = $sms_report_db->get_one($where,'id,id_code','id DESC');
		if($r && $r['id_code']==$mobile_verify) {
			//驗證通過後，將驗證碼置為空，防止重復利用！
			$sms_report_db->update(array('id_code'=>''),$where);
			exit('1');
		} else {
			exit('0');
		}
	}else{
		/*用戶自發短信驗證判斷，不再傳遞mobile值，只判斷10分鐘內這個驗證碼是否存在，存在即認為此碼對應的手機號為你所有*/
		$posttime = SYS_TIME-600;
		$where = "`id_code`='$mobile_verify' AND `posttime`>'$posttime'";
		$r = $sms_report_db->get_one($where,'id_code','id DESC');
		if(is_array($r)){
 			exit('1');
		}else{
			exit('0');
		}
  	}
}	