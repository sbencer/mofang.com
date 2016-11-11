<?php 

/**
 * 生成隨機字符串
 * @param string $lenth 長度
 * @return string 字符串
 */
function create_randomstr($lenth = 6) {
	return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
 * 
 * @param $password 密碼
 * @param $random 隨機數
 */
function create_password($password='', $random='') {
	if(empty($random)) {
		$array['random'] = create_randomstr();
		$array['password'] = md5(md5($password).$array['random']);
		return $array;
	}
	return md5(md5($password).$random);
}

?>