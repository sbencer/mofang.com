<?php
class card {
	static $server_url = 'http://safe.phpcms.cn/index.php';

	/**
	 * 到遠程服務器上去取KEY
	 */
	public static function get_key() {
		
		return self::_get_data('?op=key&release='.self::get_release());
	}

	public static function get_release() {
		return pc_base::load_config('version','pc_release');
	}
	
	/**
	 * 卡片的顯示地址
	 * @param $sn 口令卡編號
	 */
	public static function get_pic($sn) {
		$key = self::get_key();
		return self::$server_url.'?op=card&release='.self::get_release().'&key='.urlencode($key).'&code='.urlencode(self::sys_auth("sn=$sn", 'ENCODE', $key));
	}
	
	/**
	 * 申請新的卡片
	 * @return 返回卡片的sn
	 */
	public static function creat_card() {
		$key = self::get_key();
		return self::_get_data('?op=creat_card&release='.self::get_release().'&key='.urlencode($key));
	}
	
	/**
	 * 解除口令卡綁定
	 * @param string $sn 口令卡編號
	 */
	public static function remove_card($sn) {
		$key = self::get_key();
		return self::_get_data('?op=remove&release='.self::get_release().'&key='.urlencode($key).'&code='.urlencode(self::sys_auth("sn=$sn", 'ENCODE', $key)));
	}
	
	/**
	 * 請求口令驗證碼
	 * @param string $sn 口令卡編號
	 */
	public static function authe_rand($sn) {
		$key = self::get_key();
		$data = self::_get_data('?op=authe_request&release='.self::get_release().'&key='.urlencode($key).'&code='.urlencode(self::sys_auth("sn=$sn", 'ENCODE', $key)));
		return array('rand'=>$data,'url'=>self::$server_url.'?op=show_rand&release='.self::get_release().'&key='.urlencode($key).'&code='.urlencode(self::sys_auth("rand=$data", 'ENCODE', $key)));
	}
	
	/**
	 * 驗證動態口令
	 * @param string $sn     口令卡編號
	 * @param string $code   用戶輸入口令
	 * @param string $rand   隨機碼
	 */
	public static function verification($sn, $code, $rand) {
		$key = self::get_key();
		return self::_get_data('?op=verification&release='.self::get_release().'&key='.urlencode($key).'&code='.urlencode(self::sys_auth("sn=$sn&code=$code&rand=$rand", 'ENCODE', $key)), 'index.php?m=admin&c=index&a=public_card');
	} 
	
	/**
	 * 請求遠程數據
	 * @param string $url       需要請求的地址。
	 * @param string $backurl   返回地址
	 */
	private static function _get_data($url, $backurl = '') {
		if ($data = @file_get_contents(self::$server_url.$url)) {
			$data = json_decode($data, true);
			
			//如果系統是GBK的系統，把UTF8轉碼為GBK
			if (pc_base::load_config('system', 'charset') == 'gbk') {
				$data =  array_iconv($data, 'utf-8', 'gbk');
			}
			
			if ($data['status'] != 1) {
				showmessage($data['msg'], $backurl);
			} else {
				return $data['msg'];
			}
		} else {
			showmessage(L('your_server_it_may_not_have_access_to').self::$server_url.L('_please_check_the_server_configuration'));
		}
	}

	private function sys_auth($txt, $operation = 'ENCODE', $key = '') {
		$key	= $key ? $key : 'oqjtioxiWRWKLEQJLKj';
		$txt	= $operation == 'ENCODE' ? (string)$txt : base64_decode($txt);
		$len	= strlen($key);
		$code	= '';
		for($i=0; $i<strlen($txt); $i++){
			$k		= $i % $len;
			$code  .= $txt[$i] ^ $key[$k];
		}
		$code = $operation == 'DECODE' ? $code : base64_encode($code);
	return $code;
}
}