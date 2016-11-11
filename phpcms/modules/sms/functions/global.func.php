<?php
function sms_status($status = 0,$return_array = 0) {
	$array = array(
			'0'=>'發送成功',
			'1'=>'手機號碼非法',
			'2'=>'用戶存在於黑名單列表',
			'3'=>'接入用戶名或密碼錯誤',
			'4'=>'產品代碼不存在',
			'5'=>'IP非法',
			'6 '=>'源號碼錯誤',
			'7'=>'調用網關錯誤',
			'8'=>'消息長度超過60',
			'9'=>'發送短信內容參數為空',
			'10'=>'用戶已主動暫停該業務',
			'11'=>'wap鏈接地址或域名非法',
			'12'=>'5分鐘內給同一個號碼發送短信超過10條',
			'13'=>'短信模版ID為空',
			'14'=>'禁止發送該消息',
			'-1'=>'每分鐘發給該手機號的短信數不能超過3條',
			'-2'=>'手機號碼錯誤',
			'-11'=>'帳號驗證失敗',
			'-10'=>'SNDA接口沒有返回結果',
		);
	return $return_array ? $array : $array[$status];
}

function checkmobile($mobilephone) {
		$mobilephone = trim($mobilephone);
		if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[01236789]{1}[0-9]{8}$|18[01236789]{1}[0-9]{8}$/",$mobilephone)){  
 			return  $mobilephone;
		} else {    
			return false;
		}
		
}

function get_smsnotice($type = '') {
	$url = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
	$urls = base64_decode('aHR0cDovL3Ntcy5waHBpcC5jb20vYXBpLnBocD9vcD1zbXNub3RpY2UmdXJsPQ==').$url."&type=".$type;
	$content = pc_file_get_contents($urls,5);
	if($content) {
		$content = json_decode($content,true);
		if($content['status']==1) {
			return strtolower(CHARSET)=='gbk' ?iconv('utf-8','gbk',$content['msg']) : $content['msg'];
		}
	}
	$urls = base64_decode('aHR0cDovL3Ntcy5waHBjbXMuY24vYXBpLnBocD9vcD1zbXNub3RpY2UmdXJsPQ==').$url."&type=".$type;
	$content = pc_file_get_contents($urls,3);
	if($content) {
		$content = json_decode($content,true);
		if($content['status']==1) {
			return strtolower(CHARSET)=='gbk' ?iconv('utf-8','gbk',$content['msg']) : $content['msg'];
		}
	}
	return '<font color="red">短信通服務器無法訪問！您將無法使用短信通服務！</font>';
}