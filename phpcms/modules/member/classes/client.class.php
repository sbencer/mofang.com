<?php

class client {

	private $ps_api_url, $ps_auth_key, $ps_vsersion;
	/**
	 * 析構函數
	 * @param $ps_api_url 接口域名
	 * @param $ps_auth_key 加密密匙
	 */
	public function __construct($ps_api_url='127.0.0.1', $ps_auth_key='', $ps_vsersion='1') {
		$this->ps_api_url = $ps_api_url;
		$this->ps_auth_key = $ps_auth_key;
		$this->ps_vsersion = $ps_vsersion;
	}
	
	/**
	 * 用戶注冊
	 * @param string $username 	用戶名
	 * @param string $password 	密碼
	 * @param string $email		email
	 * @param string $regip		注冊ip
	 * @param string $random	密碼隨機數
	 * @return int {-1:用戶名已經存在 ;-2:email已存在;-3:email格式錯誤;-4:用戶名禁止注冊;-5:郵箱禁止注冊；int(uid):成功}
	 */
	public function ps_member_register($username, $password, $email, $regip='', $random='') {
		if(!$this->_is_email($email)) {
			return -3;
		}
		 
		return $this->_ps_send('register', array('username'=>$username, 'password'=>$password, 'email'=>$email, 'regip'=>$regip, 'random'=>$random));
	}
	/**
	 * 用戶登陸
	 * @param string $username 	用戶名
	 * @param string $password 	密碼
	 * @param int $isemail	email
	 * @return int {-2;密碼錯誤;-1:用戶名不存在;array(userinfo):用戶信息}
	 */
	public function ps_member_login($username, $password, $isemail=0) {
		if($isemail) {
			if(!$this->_is_email($username)) {
				return -3;
			}
			$return = $this->_ps_send('login', array('email'=>$username, 'password'=>$password));
		} else {
			$return = $this->_ps_send('login', array('username'=>$username, 'password'=>$password));
		}
		return $return;
	}
	
	/**
	 * 同步登陸
	 * @param string $uid
	 * @return string javascript用戶同步登陸js
	 */
	public function ps_member_synlogin($uid) {
		$uid = intval($uid);
		return $this->_ps_send('synlogin', array('uid'=>$uid));
	}

	/**
	 * 同步退出
	 * @param string $uid
	 * @return string javascript用戶同步退出js
	 */
	public function ps_member_synlogout() {
		return $this->_ps_send('synlogout', array());
	}
	
	/**
	 * 編輯用戶
	 * @param string $username		用戶名
	 * @param string $email			email
	 * @param string $password		舊密碼
	 * @param string $newpassword	新密碼
	 * @param int $uid				phpsso用戶uid
	 * @param string $random	 	密碼隨機數
	 * @return int {-1:用戶不存在;-2:舊密碼錯誤;-3:email已經存在 ;-4:email格式錯誤;1:成功;0:未作修改,-5:參數格式錯誤}
	 */
	public function ps_member_edit($username, $email, $password='', $newpassword='', $uid='', $random='') {
		if($email && !$this->_is_email($email)) {
			return -4;
		}
		if ((!empty($username) && !is_string($username)) || (!empty($email) && !is_string($email)) || (!empty($password) && !is_string($password)) || (!empty($newpassword) && !is_string($newpassword))) {
			return -5;
		}
		return $this->_ps_send('edit', array('username'=>$username, 'password'=>$password, 'newpassword'=>$newpassword, 'email'=>$email, 'uid'=>$uid, 'random'=>$random));
	}

	/**
	 * 刪除用戶頭像
	 * @param int $uid				phpsso用戶uid
	 * @return int {1:成功;0:失敗}
	 */
	public function ps_deleteavatar($uid) {
		return $this->_ps_send('deleteavatar', array('uid'=>$uid));
	}
	
	/**
	 * 獲取用戶信息
	 * @param $mix 用戶id/用戶名/email
	 * @param $type {1:用戶id;2:用戶名;3:email}
	 * @return $mix {-1:用戶不存在;userinfo:用戶信息}
	 */
	public function ps_get_member_info($mix, $type=1) {
		if($type==1) {
			$userinfo = $this->_ps_send('getuserinfo', array('uid'=>$mix));
		} elseif($type==2) {
			$userinfo = $this->_ps_send('getuserinfo', array('username'=>$mix));
		} elseif($type==3) {
			if(!$this->_is_email($mix)) {
				return -4;
			}
			$userinfo = $this->_ps_send('getuserinfo', array('email'=>$mix));
		}
		if($userinfo) {
			return $userinfo;
		} else {
			return -1;
		}
	}

	/**
	 * 刪除用戶
	 * @param mix {1:用戶id;2:用戶名;3:email} 如果是用戶id可以為數組
	 * @return int {-1:用戶不存在;1:刪除成功}
	 */
	public function ps_delete_member($mix, $type=1) {
		if($type==1) {
			$res = $this->_ps_send('delete', array('uid'=>$mix));
		} elseif($type==2) {
			$res = $this->_ps_send('delete', array('username'=>$mix));
		} elseif($type==3) {
			if(!$this->_is_email($mix)) {
				return -4;
			}
			$res = $this->_ps_send('delete', array('email'=>$mix));
		}
		return $res;
	}
	
	/**
	 * 檢查用戶是否可以注冊
	 * @param string $username
	 * @return int {-4：用戶名禁止注冊;-1:用戶名已經存在 ;1:成功}
	 */
	public function ps_checkname($username) {
		return $this->_ps_send('checkname', array('username'=>$username));
	}

	/**
	 * 檢查郵箱是否可以注冊
	 * @param string $email
	 * @return int {-1:email已經存在 ;-5:郵箱禁止注冊;1:成功}
	 */
	public function ps_checkemail($email) {
		return $this->_ps_send('checkemail', array('email'=>$email));
	}
	
	/**
	 * 獲取應用列表信息
	 */
	public function ps_getapplist() {
		return $this->_ps_send('getapplist', array());
	}

	/**
	 * 獲取積分兌換比例列表
	 */
	public function ps_getcreditlist() {
		return $this->_ps_send('getcredit', array());
	}

	/**
	 * 兌換積分
	 * 用於何其他應用之間積分兌換
	 * @param int $uid			phpssouid
	 * @param int $from			本系統積分類型id
	 * @param int $toappid 		目標系統應用appid
	 * @param int $to			目標系統積分類型id
	 * @param int $credit		本系統扣除積分數
	 * @return bool 			{1:成功;0:失敗}
	 */
	public function ps_changecredit($uid, $from, $toappid, $to, $credit) {
		return $this->_ps_send('changecredit', array('uid'=>$uid, 'from'=>$from, 'toappid'=>$toappid, 'to'=>$to, 'credit'=>$credit));
	}
	
	/**
	 * 根據phpsso uid獲取頭像url
	 * @param int $uid 用戶id
	 * @return array 四個尺寸用戶頭像數組
	 */
	public function ps_getavatar($uid) {
		$dir1 = ceil($uid / 10000);
		$dir2 = ceil($uid % 10000 / 1000);
		$url = $this->ps_api_url.'/uploadfile/avatar/'.$dir1.'/'.$dir2.'/'.$uid.'/';
		$avatar = array('180'=>$url.'180x180.jpg', '90'=>$url.'90x90.jpg', '45'=>$url.'45x45.jpg', '30'=>$url.'30x30.jpg');
		return $avatar;
	}

	/**
	 * 獲取上傳頭像flash的html代碼
	 * @param int $uid 用戶id
	 */
	public function ps_getavatar_upload_html($uid) {
		$auth_data = $this->auth_data(array('uid'=>$uid, 'ps_auth_key'=>$this->ps_auth_key), '', $this->ps_auth_key);
		$upurl = base64_encode($this->ps_api_url.'/index.php?m=phpsso&c=index&a=uploadavatar&auth_data='.$auth_data);
		$str = <<<EOF
				<div id="phpsso_uploadavatar_flash"></div>
				<script language="javascript" type="text/javascript" src="{$this->ps_api_url}/statics/js/swfobject.js"></script>
				<script type="text/javascript">
					var flashvars = {
						'upurl':"{$upurl}&callback=return_avatar&"
					}; 
					var params = {
						'align':'middle',
						'play':'true',
						'loop':'false',
						'scale':'showall',
						'wmode':'window',
						'devicefont':'true',
						'id':'Main',
						'bgcolor':'#ffffff',
						'name':'Main',
						'allowscriptaccess':'always'
					}; 
					var attributes = {
						
					}; 
					swfobject.embedSWF("{$this->ps_api_url}/statics/images/main.swf", "phpsso_uploadavatar_flash", "490", "434", "9.0.0","{$this->ps_api_url}/statics/images/expressInstall.swf", flashvars, params, attributes);

					function return_avatar(data) {
						if(data == 1) {
							window.location.reload();
						} else {
							alert('failure');
						}
					}
				</script> 
EOF;
		return $str;
	}
	/**
	* 字符串加密、解密函數
	*
	*
	* @param	string	$txt		字符串
	* @param	string	$operation	ENCODE為加密，DECODE為解密，可選參數，默認為ENCODE，
	* @param	string	$key		密鑰：數字、字母、下劃線
	* @param	string	$expiry		過期時間
	* @return	string
	*/
	function sys_auth($string, $operation = 'ENCODE', $key = '', $expiry = 0) {
		$key_length = 4;
		$key = md5($key != '' ? $key : $this->ps_auth_key);
		$fixedkey = hash('md5', $key);
		$egiskeys = md5(substr($fixedkey, 16, 16));
		$runtokey = $key_length ? ($operation == 'ENCODE' ? substr(hash('md5', microtime(true)), -$key_length) : substr($string, 0, $key_length)) : ''; 
		$keys = hash('md5', substr($runtokey, 0, 16) . substr($fixedkey, 0, 16) . substr($runtokey, 16) . substr($fixedkey, 16));
		$string = $operation == 'ENCODE' ? sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$egiskeys), 0, 16) . $string : base64_decode(substr($string, $key_length));
		
		$i = 0; $result = '';
		$string_length = strlen($string);
		for ($i = 0; $i < $string_length; $i++){
			$result .= chr(ord($string{$i}) ^ ord($keys{$i % 32}));
		}
		if($operation == 'ENCODE') {
			return $runtokey . str_replace('=', '', base64_encode($result));
		} else {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$egiskeys), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		}
	}

	/**
	* 將數組轉換為字符串
	*
	* @param	array	$data		數組
	* @param	bool	$isformdata	如果為0，則不使用new_stripslashes處理，可選參數，默認為1
	* @return	string	返回字符串，如果，data為空，則返回空
	*/
	public function array2string($data, $isformdata = 1) {
		if($data == '') return '';
		if($isformdata) $data = new_stripslashes($data);
		return var_export($data, TRUE);
	}

	public function auth_data($data) {
		$s = $sep = '';
		foreach($data as $k => $v) {
			if(is_array($v)) {
				$s2 = $sep2 = '';
				foreach($v as $k2 => $v2) {
						$s2 .= "$sep2{$k}[$k2]=".$this->_ps_stripslashes($v2);
					$sep2 = '&';
				}
				$s .= $sep.$s2;
			} else {
				$s .= "$sep$k=".$this->_ps_stripslashes($v);
			}
			$sep = '&';
		}

		$auth_s = 'v='.$this->ps_vsersion.'&appid='.APPID.'&data='.urlencode($this->sys_auth($s));
		return $auth_s;
	}
	
	/**
	 * 發送數據
	 * @param $action 操作
	 * @param $data 數據
	 */
	private function _ps_send($action, $data = null) {
 		return $this->_ps_post($this->ps_api_url."/index.php?m=phpsso&c=index&a=".$action, 500000, $this->auth_data($data));
	}
	
	/**
	 *  post數據
	 *  @param string $url		post的url
	 *  @param int $limit		返回的數據的長度
	 *  @param string $post		post數據，字符串形式username='dalarge'&password='123456'
	 *  @param string $cookie	模擬 cookie，字符串形式username='dalarge'&password='123456'
	 *  @param string $ip		ip地址
	 *  @param int $timeout		連接超時時間
	 *  @param bool $block		是否為阻塞模式
	 *  @return string			返回字符串
	 */
	
	private function _ps_post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 15, $block = true) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;
		$siteurl = $this->_get_url();
		if($post) {
			$out = "POST $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n" ;
			$out .= 'Content-Length: '.strlen($post)."\r\n" ;
			$out .= "Connection: Close\r\n" ;
			$out .= "Cache-Control: no-cache\r\n" ;
			$out .= "Cookie: $cookie\r\n\r\n" ;
			$out .= $post ;
		} else {
			$out = "GET $path HTTP/1.1\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Referer: ".$siteurl."\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		if(!$fp) return '';
	
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
	
		if($status['timed_out']) return '';	
		while (!feof($fp)) {
			if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n"))  break;				
		}
		
		$stop = false;
		while(!feof($fp) && !$stop) {
			$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
			$return .= $data;
			if($limit) {
				$limit -= strlen($data);
				$stop = $limit <= 0;
			}
		}
		@fclose($fp);
		
		//部分虛擬主機返回數值有誤，暫不確定原因，過濾返回數據格式
		$return_arr = explode("\n", $return);
		if(isset($return_arr[1])) {
			$return = trim($return_arr[1]);
		}
		unset($return_arr);
		
		return $return;
	}

	/**
	 * 過濾字符串
	 * @param $string
	 */
	private function _ps_stripslashes($string) {
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		if(MAGIC_QUOTES_GPC) {
			return stripslashes($string);
		} else {
			return $string;
		}
	}
	
	
	/**
	 * 獲取當前頁面完整URL地址
	 */
	private function _get_url() {
		$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER['PHP_SELF'] ? $this->_safe_replace($_SERVER['PHP_SELF']) : $this->_safe_replace($_SERVER['SCRIPT_NAME']);
		$path_info = isset($_SERVER['PATH_INFO']) ? $this->_safe_replace($_SERVER['PATH_INFO']) : '';
		$relate_url = isset($_SERVER['REQUEST_URI']) ? $this->_safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$this->_safe_replace($_SERVER['QUERY_STRING']) : $path_info);
		return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}
	/**
	 * 安全過濾函數
	 *
	 * @param $string
	 * @return string
	 */
	private function _safe_replace($string) {
		$string = str_replace('%20','',$string);
		$string = str_replace('%27','',$string);
		$string = str_replace('%2527','',$string);
		$string = str_replace('*','',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace("'",'',$string);
		$string = str_replace('"','',$string);
		$string = str_replace(';','',$string);
		$string = str_replace('<','&lt;',$string);
		$string = str_replace('>','&gt;',$string);
		$string = str_replace("{",'',$string);
		$string = str_replace('}','',$string);
		$string = str_replace('\\','',$string);
		return $string;
	}
	
	/**
	 * 判斷email格式是否正確
	 * @param $string email
	 */
	private function _is_email($email) {
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
	}
}



?>