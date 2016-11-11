<?php
/**
 * PHP SDK for weibo.com (using OAuth2)
 *
 * @author Elmer Zhang <freeboy6716@gmail.com>
 */

/**
 * @ignore
 */
class OAuthException extends Exception {
	// pass
}


/**
 * 新浪微博 OAuth 認證類(OAuth2)
 *
 * 授權機制說明請大家參考微博開放平台文檔：{@link http://open.weibo.com/wiki/Oauth2}
 *
 * @package sae
 * @author Elmer Zhang
 * @version 1.0
 */
class SaeTOAuthV2 {
	/**
	 * @ignore
	 */
	public $client_id;
	/**
	 * @ignore
	 */
	public $client_secret;
	/**
	 * @ignore
	 */
	public $access_token;
	/**
	 * @ignore
	 */
	public $refresh_token;
	/**
	 * Contains the last HTTP status code returned.
	 *
	 * @ignore
	 */
	public $http_code;
	/**
	 * Contains the last API call.
	 *
	 * @ignore
	 */
	public $url;
	/**
	 * Set up the API root URL.
	 *
	 * @ignore
	 */
	public $host = "https://api.weibo.com/2/";
	/**
	 * Set timeout default.
	 *
	 * @ignore
	 */
	public $timeout = 30;
	/**
	 * Set connect timeout.
	 *
	 * @ignore
	 */
	public $connecttimeout = 30;
	/**
	 * Verify SSL Cert.
	 *
	 * @ignore
	 */
	public $ssl_verifypeer = FALSE;
	/**
	 * Respons format.
	 *
	 * @ignore
	 */
	public $format = 'json';
	/**
	 * Decode returned json data.
	 *
	 * @ignore
	 */
	public $decode_json = TRUE;
	/**
	 * Contains the last HTTP headers returned.
	 *
	 * @ignore
	 */
	public $http_info;
	/**
	 * Set the useragnet.
	 *
	 * @ignore
	 */
	public $useragent = 'Sae T OAuth2 v0.1';

	/**
	 * print the debug info
	 *
	 * @ignore
	 */
	public $debug = FALSE;

	/**
	 * boundary of multipart
	 * @ignore
	 */
	public static $boundary = '';

	/**
	 * Set API URLS
	 */
	/**
	 * @ignore
	 */
	function accessTokenURL()  { return 'https://api.weibo.com/oauth2/access_token'; }
	/**
	 * @ignore
	 */
	function authorizeURL()    { return 'https://api.weibo.com/oauth2/authorize'; }

	/**
	 * construct WeiboOAuth object
	 */
	function __construct($client_id, $client_secret, $access_token = NULL, $refresh_token = NULL) {
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->access_token = $access_token;
		$this->refresh_token = $refresh_token;
	}

	/**
	 * authorize接口
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/Oauth2/authorize Oauth2/authorize}
	 *
	 * @param string $url 授權後的回調地址,站外應用需與回調地址一致,站內應用需要填寫canvas page的地址
	 * @param string $response_type 支持的值包括 code 和token 默認值為code
	 * @param string $state 用於保持請求和回調的狀態。在回調時,會在Query Parameter中回傳該參數
	 * @param string $display 授權頁面類型 可選範圍:
	 *  - default		默認授權頁面
	 *  - mobile		支持html5的手機
	 *  - wap1.2		wap1.2頁面
	 *  - wap2.0		wap2.0頁面
	 *  - apponweibo	站內應用專用,站內應用不傳display參數,並且response_type為token時,默認使用改display.授權後不會返回access_token，只是輸出js刷新站內應用父框架
	 * @param bool $forcelogin 是否強制用戶重新登錄，true：是，false：否。默認false。
	 * @param string $language 授權頁語言，缺省為中文簡體版，en為英文版。英文版測試中，開發者任何意見可反饋至 @微博API
	 * @return array
	 */
	function getAuthorizeURL( $url, $response_type = 'code', $state = NULL, $display = NULL, $forcelogin = NULL, $language = NULL ) {
		$params = array();
		$params['client_id'] = $this->client_id;
		$params['redirect_uri'] = $url;
		$params['response_type'] = $response_type;
		$params['state'] = $state;
		$params['display'] = $display;
		$params['forcelogin'] = $forcelogin;
		$params['language'] = $language;
		return $this->authorizeURL() . "?" . http_build_query($params);
	}

	/**
	 * access_token接口
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/OAuth2/access_token OAuth2/access_token}
	 *
	 * @param string $type 請求的類型,可以為:code, password, token
	 * @param array $keys 其他參數：
	 *  - 當$type為code時： array('code'=>..., 'redirect_uri'=>...)
	 *  - 當$type為password時： array('username'=>..., 'password'=>...)
	 *  - 當$type為token時： array('refresh_token'=>...)
	 * @return array
	 */
	function getAccessToken( $type = 'code', $keys ) {
		$params = array();
		$params['client_id'] = $this->client_id;
		$params['client_secret'] = $this->client_secret;
		if ( $type === 'token' ) {
			$params['grant_type'] = 'refresh_token';
			$params['refresh_token'] = $keys['refresh_token'];
		} elseif ( $type === 'code' ) {
			$params['grant_type'] = 'authorization_code';
			$params['code'] = $keys['code'];
			$params['redirect_uri'] = $keys['redirect_uri'];
		} elseif ( $type === 'password' ) {
			$params['grant_type'] = 'password';
			$params['username'] = $keys['username'];
			$params['password'] = $keys['password'];
		} else {
			throw new OAuthException("wrong auth type");
		}

		$response = $this->oAuthRequest($this->accessTokenURL(), 'POST', $params);
		$token = json_decode($response, true);
		if ( is_array($token) && !isset($token['error']) ) {
			$this->access_token = $token['access_token'];
			$this->refresh_token = $token['refresh_token'];
		} else {
			throw new OAuthException("get access token failed." . $token['error']);
		}
		return $token;
	}

	/**
	 * 解析 signed_request
	 *
	 * @param string $signed_request 應用框架在加載iframe時會通過向Canvas URL post的參數signed_request
	 *
	 * @return array
	 */
	function parseSignedRequest($signed_request) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);
		$sig = self::base64decode($encoded_sig) ;
		$data = json_decode(self::base64decode($payload), true);
		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') return '-1';
		$expected_sig = hash_hmac('sha256', $payload, $this->client_secret, true);
		return ($sig !== $expected_sig)? '-2':$data;
	}

	/**
	 * @ignore
	 */
	function base64decode($str) {
		return base64_decode(strtr($str.str_repeat('=', (4 - strlen($str) % 4)), '-_', '+/'));
	}

	/**
	 * 讀取jssdk授權信息，用於和jssdk的同步登錄
	 *
	 * @return array 成功返回array('access_token'=>'value', 'refresh_token'=>'value'); 失敗返回false
	 */
	function getTokenFromJSSDK() {
		$key = "weibojs_" . $this->client_id;
		if ( isset($_COOKIE[$key]) && $cookie = $_COOKIE[$key] ) {
			parse_str($cookie, $token);
			if ( isset($token['access_token']) && isset($token['refresh_token']) ) {
				$this->access_token = $token['access_token'];
				$this->refresh_token = $token['refresh_token'];
				return $token;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * 從數組中讀取access_token和refresh_token
	 * 常用於從Session或Cookie中讀取token，或通過Session/Cookie中是否存有token判斷登錄狀態。
	 *
	 * @param array $arr 存有access_token和secret_token的數組
	 * @return array 成功返回array('access_token'=>'value', 'refresh_token'=>'value'); 失敗返回false
	 */
	function getTokenFromArray( $arr ) {
		if (isset($arr['access_token']) && $arr['access_token']) {
			$token = array();
			$this->access_token = $token['access_token'] = $arr['access_token'];
			if (isset($arr['refresh_token']) && $arr['refresh_token']) {
				$this->refresh_token = $token['refresh_token'] = $arr['refresh_token'];
			}

			return $token;
		} else {
			return false;
		}
	}

	/**
	 * GET wrappwer for oAuthRequest.
	 *
	 * @return mixed
	 */
	function get($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'GET', $parameters);
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response, true);
		}
		return $response;
	}

	/**
	 * POST wreapper for oAuthRequest.
	 *
	 * @return mixed
	 */
	function post($url, $parameters = array(), $multi = false) {
		$response = $this->oAuthRequest($url, 'POST', $parameters, $multi );
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response, true);
		}
		return $response;
	}

	/**
	 * DELTE wrapper for oAuthReqeust.
	 *
	 * @return mixed
	 */
	function delete($url, $parameters = array()) {
		$response = $this->oAuthRequest($url, 'DELETE', $parameters);
		if ($this->format === 'json' && $this->decode_json) {
			return json_decode($response, true);
		}
		return $response;
	}

	/**
	 * Format and sign an OAuth / API request
	 *
	 * @return string
	 * @ignore
	 */
	function oAuthRequest($url, $method, $parameters, $multi = false) {

		if (strrpos($url, 'http://') !== 0 && strrpos($url, 'https://') !== 0) {
			$url = "{$this->host}{$url}.{$this->format}";
	}

	switch ($method) {
		case 'GET':
			$url = $url . '?' . http_build_query($parameters);
			return $this->http($url, 'GET');
		default:
			$headers = array();
			if (!$multi && (is_array($parameters) || is_object($parameters)) ) {
				$body = http_build_query($parameters);
			} else {
				$body = self::build_http_query_multi($parameters);
				$headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
			}
			return $this->http($url, $method, $body, $headers);
	}
	}

	/**
	 * Make an HTTP request
	 *
	 * @return string API results
	 * @ignore
	 */
	function http($url, $method, $postfields = NULL, $headers = array()) {
		$this->http_info = array();
		$ci = curl_init();
		/* Curl settings */
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
		curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_ENCODING, "");
		curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
		curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 1);
		curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
		curl_setopt($ci, CURLOPT_HEADER, FALSE);

		switch ($method) {
			case 'POST':
				curl_setopt($ci, CURLOPT_POST, TRUE);
				if (!empty($postfields)) {
					curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
					$this->postdata = $postfields;
				}
				break;
			case 'DELETE':
				curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
				if (!empty($postfields)) {
					$url = "{$url}?{$postfields}";
				}
		}

		if ( isset($this->access_token) && $this->access_token )
			$headers[] = "Authorization: OAuth2 ".$this->access_token;

		if ( !empty($this->remote_ip) ) {
			if ( defined('SAE_ACCESSKEY') ) {
				$headers[] = "SaeRemoteIP: " . $this->remote_ip;
			} else {
				$headers[] = "API-RemoteIP: " . $this->remote_ip;
			}
		} else {
			if ( !defined('SAE_ACCESSKEY') ) {
				$headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
			}
		}
		curl_setopt($ci, CURLOPT_URL, $url );
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );

		$response = curl_exec($ci);
		$this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ci));
		$this->url = $url;

		if ($this->debug) {
			echo "=====post data======\r\n";
			var_dump($postfields);

			echo "=====headers======\r\n";
			print_r($headers);

			echo '=====request info====='."\r\n";
			print_r( curl_getinfo($ci) );

			echo '=====response====='."\r\n";
			print_r( $response );
		}
		curl_close ($ci);
		return $response;
	}

	/**
	 * 開啟調試信息
	 *
	 * 開啟調試信息後，SDK會將每次請求微博API所發送的POST Data、Headers以及請求信息、返回內容輸出出來。
	 *
	 * @access public
	 * @param bool $enable 是否開啟調試信息
	 * @return void
	 */
	function set_debug( $enable )
	{
		$this->debug = $enable;
	}

	/**
	 * Get the header info to store.
	 *
	 * @return int
	 * @ignore
	 */
	function getHeader($ch, $header) {
		$i = strpos($header, ':');
		if (!empty($i)) {
			$key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
			$value = trim(substr($header, $i + 2));
			$this->http_header[$key] = $value;
		}
		return strlen($header);
	}

	/**
	 * @ignore
	 */
	public static function build_http_query_multi($params) {
		if (!$params) return '';

		uksort($params, 'strcmp');

		$pairs = array();

		self::$boundary = $boundary = uniqid('------------------');
		$MPboundary = '--'.$boundary;
		$endMPboundary = $MPboundary. '--';
		$multipartbody = '';

		foreach ($params as $parameter => $value) {

			if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
				$url = ltrim( $value, '@' );
				$content = file_get_contents( $url );
				$array = explode( '?', basename( $url ) );
				$filename = $array[0];

				$multipartbody .= $MPboundary . "\r\n";
				$multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
				$multipartbody .= "Content-Type: image/unknown\r\n\r\n";
				$multipartbody .= $content. "\r\n";
			} else {
				$multipartbody .= $MPboundary . "\r\n";
				$multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
				$multipartbody .= $value."\r\n";
			}

		}

		$multipartbody .= $endMPboundary;
		return $multipartbody;
	}
}


/**
 * 新浪微博操作類V2
 *
 * 使用前需要先手工調用saetv2.ex.class.php <br />
 *
 * @package sae
 * @author Easy Chen, Elmer Zhang,Lazypeople
 * @version 1.0
 */
class SaeTClientV2
{
	/**
	 * 構造函數
	 *
	 * @access public
	 * @param mixed $akey 微博開放平台應用APP KEY
	 * @param mixed $skey 微博開放平台應用APP SECRET
	 * @param mixed $access_token OAuth認證返回的token
	 * @param mixed $refresh_token OAuth認證返回的token secret
	 * @return void
	 */
	function __construct( $akey, $skey, $access_token, $refresh_token = NULL)
	{
		$this->oauth = new SaeTOAuthV2( $akey, $skey, $access_token, $refresh_token );
	}

	/**
	 * 開啟調試信息
	 *
	 * 開啟調試信息後，SDK會將每次請求微博API所發送的POST Data、Headers以及請求信息、返回內容輸出出來。
	 *
	 * @access public
	 * @param bool $enable 是否開啟調試信息
	 * @return void
	 */
	function set_debug( $enable )
	{
		$this->oauth->debug = $enable;
	}

	/**
	 * 設置用戶IP
	 *
	 * SDK默認將會通過$_SERVER['REMOTE_ADDR']獲取用戶IP，在請求微博API時將用戶IP附加到Request Header中。但某些情況下$_SERVER['REMOTE_ADDR']取到的IP並非用戶IP，而是一個固定的IP（例如使用SAE的Cron或TaskQueue服務時），此時就有可能會造成該固定IP達到微博API調用頻率限額，導致API調用失敗。此時可使用本方法設置用戶IP，以避免此問題。
	 *
	 * @access public
	 * @param string $ip 用戶IP
	 * @return bool IP為非法IP字符串時，返回false，否則返回true
	 */
	function set_remote_ip( $ip )
	{
		if ( ip2long($ip) !== false ) {
			$this->oauth->remote_ip = $ip;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 獲取最新的公共微博消息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/public_timeline statuses/public_timeline}
	 *
	 * @access public
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @param int $base_app 是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @return array
	 */
	function public_timeline( $page = 1, $count = 50, $base_app = 0 )
	{
		$params = array();
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get('statuses/public_timeline', $params);//可能是接口的bug不能補全
	}

	/**
	 * 獲取當前登錄用戶及其所關注用戶的最新微博消息。
	 *
	 * 獲取當前登錄用戶及其所關注用戶的最新微博消息。和用戶登錄 http://weibo.com 後在“我的首頁”中看到的內容相同。同friends_timeline()
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/home_timeline statuses/home_timeline}
	 *
	 * @access public
	 * @param int $page 指定返回結果的頁碼。根據當前登錄用戶所關注的用戶數及這些被關注用戶發表的微博數，翻頁功能最多能查看的總記錄數會有所不同，通常最多能查看1000條左右。默認值1。可選。
	 * @param int $count 每次返回的記錄數。缺省值50，最大值200。可選。
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的微博消息（即比since_id發表時間晚的微博消息）。可選。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的微博消息。可選。
	 * @param int $base_app 是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @param int $feature 過濾類型ID，0：全部、1：原創、2：圖片、3：視頻、4：音樂，默認為0。
	 * @return array
	 */
	function home_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $base_app = 0, $feature = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);

		return $this->oauth->get('statuses/home_timeline', $params);
	}

	/**
	 * 獲取當前登錄用戶及其所關注用戶的最新微博消息。
	 *
	 * 獲取當前登錄用戶及其所關注用戶的最新微博消息。和用戶登錄 http://weibo.com 後在“我的首頁”中看到的內容相同。同home_timeline()
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/friends_timeline statuses/friends_timeline}
	 *
	 * @access public
	 * @param int $page 指定返回結果的頁碼。根據當前登錄用戶所關注的用戶數及這些被關注用戶發表的微博數，翻頁功能最多能查看的總記錄數會有所不同，通常最多能查看1000條左右。默認值1。可選。
	 * @param int $count 每次返回的記錄數。缺省值50，最大值200。可選。
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的微博消息（即比since_id發表時間晚的微博消息）。可選。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的微博消息。可選。
	 * @param int $base_app 是否基於當前應用來獲取數據。1為限制本應用微博，0為不做限制。默認為0。可選。
	 * @param int $feature 微博類型，0全部，1原創，2圖片，3視頻，4音樂. 返回指定類型的微博信息內容。轉為為0。可選。
	 * @return array
	 */
	function friends_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $base_app = 0, $feature = 0 )
	{
		return $this->home_timeline( $since_id, $max_id, $count, $page, $base_app, $feature);
	}

	/**
	 * 獲取用戶發布的微博信息列表
	 *
	 * 返回用戶的發布的最近n條信息，和用戶微博頁面返回內容是一致的。此接口也可以請求其他用戶的最新發表微博。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/user_timeline statuses/user_timeline}
	 *
	 * @access public
	 * @param int $page 頁碼
	 * @param int $count 每次返回的最大記錄數，最多返回200條，默認50。
	 * @param mixed $uid 指定用戶UID或微博暱稱
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的微博消息（即比since_id發表時間晚的微博消息）。可選。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的提到當前登錄用戶微博消息。可選。
	 * @param int $base_app 是否基於當前應用來獲取數據。1為限制本應用微博，0為不做限制。默認為0。
	 * @param int $feature 過濾類型ID，0：全部、1：原創、2：圖片、3：視頻、4：音樂，默認為0。
	 * @param int $trim_user 返回值中user信息開關，0：返回完整的user信息、1：user字段僅返回uid，默認為0。
	 * @return array
	 */
	function user_timeline_by_id( $uid = NULL , $page = 1 , $count = 50 , $since_id = 0, $max_id = 0, $feature = 0, $trim_user = 0, $base_app = 0)
	{
		$params = array();
		$params['uid']=$uid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['trim_user'] = intval($trim_user);

		return $this->oauth->get( 'statuses/user_timeline', $params );
	}


	/**
	 * 獲取用戶發布的微博信息列表
	 *
	 * 返回用戶的發布的最近n條信息，和用戶微博頁面返回內容是一致的。此接口也可以請求其他用戶的最新發表微博。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/user_timeline statuses/user_timeline}
	 *
	 * @access public
	 * @param string $screen_name 微博暱稱，主要是用來區分用戶UID跟微博暱稱，當二者一樣而產生歧義的時候，建議使用該參數
	 * @param int $page 頁碼
	 * @param int $count 每次返回的最大記錄數，最多返回200條，默認50。
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的微博消息（即比since_id發表時間晚的微博消息）。可選。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的提到當前登錄用戶微博消息。可選。
	 * @param int $feature 過濾類型ID，0：全部、1：原創、2：圖片、3：視頻、4：音樂，默認為0。
	 * @param int $trim_user 返回值中user信息開關，0：返回完整的user信息、1：user字段僅返回uid，默認為0。
	 * @param int $base_app 是否基於當前應用來獲取數據。1為限制本應用微博，0為不做限制。默認為0。
	 * @return array
	 */
	function user_timeline_by_name( $screen_name = NULL , $page = 1 , $count = 50 , $since_id = 0, $max_id = 0, $feature = 0, $trim_user = 0, $base_app = 0 )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['trim_user'] = intval($trim_user);

		return $this->oauth->get( 'statuses/user_timeline', $params );
	}



	/**
	 * 批量獲取指定的一批用戶的timeline
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/timeline_batch statuses/timeline_batch}
	 *
	 * @param string $screen_name  需要查詢的用戶暱稱，用半角逗號分隔，一次最多20個
	 * @param int    $count        單頁返回的記錄條數，默認為50。
	 * @param int    $page  返回結果的頁碼，默認為1。
	 * @param int    $base_app  是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @param int    $feature   過濾類型ID，0：全部、1：原創、2：圖片、3：視頻、4：音樂，默認為0。
	 * @return array
	 */
	function timeline_batch_by_name( $screen_name, $page = 1, $count = 50, $feature = 0, $base_app = 0)
	{
		$params = array();
		if (is_array($screen_name) && !empty($screen_name)) {
			$params['screen_name'] = join(',', $screen_name);
		} else {
			$params['screen_name'] = $screen_name;
		}
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		return $this->oauth->get('statuses/timeline_batch', $params);
	}

	/**
	 * 批量獲取指定的一批用戶的timeline
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/timeline_batch statuses/timeline_batch}
	 *
	 * @param string $uids  需要查詢的用戶ID，用半角逗號分隔，一次最多20個。
	 * @param int    $count        單頁返回的記錄條數，默認為50。
	 * @param int    $page  返回結果的頁碼，默認為1。
	 * @param int    $base_app  是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @param int    $feature   過濾類型ID，0：全部、1：原創、2：圖片、3：視頻、4：音樂，默認為0。
	 * @return array
	 */
	function timeline_batch_by_id( $uids, $page = 1, $count = 50, $feature = 0, $base_app = 0)
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		$params['count'] = intval($count);
		$params['page'] = intval($page);
		$params['base_app'] = intval($base_app);
		$params['feature'] = intval($feature);
		return $this->oauth->get('statuses/timeline_batch', $params);
	}


	/**
	 * 返回一條原創微博消息的最新n條轉發微博消息。本接口無法對非原創微博進行查詢。
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/repost_timeline statuses/repost_timeline}
	 *
	 * @access public
	 * @param int $sid 要獲取轉發微博列表的原創微博ID。
	 * @param int $page 返回結果的頁碼。
	 * @param int $count 單頁返回的最大記錄數，最多返回200條，默認50。可選。
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的記錄（比since_id發表時間晚）。可選。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的記錄。可選。
	 * @param int $filter_by_author 作者篩選類型，0：全部、1：我關注的人、2：陌生人，默認為0。
	 * @return array
	 */
	function repost_timeline( $sid, $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0 )
	{
		$this->id_format($sid);

		$params = array();
		$params['id'] = $sid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['filter_by_author'] = intval($filter_by_author);

		return $this->request_with_pager( 'statuses/repost_timeline', $page, $count, $params );
	}

	/**
	 * 獲取當前用戶最新轉發的n條微博消息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/repost_by_me statuses/repost_by_me}
	 *
	 * @access public
	 * @param int $page 返回結果的頁碼。
	 * @param int $count  每次返回的最大記錄數，最多返回200條，默認50。可選。
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的記錄（比since_id發表時間晚）。可選。
	 * @param int $max_id  若指定此參數，則返回ID小於或等於max_id的記錄。可選。
	 * @return array
	 */
	function repost_by_me( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager('statuses/repost_by_me', $page, $count, $params );
	}

	/**
	 * 獲取@當前用戶的微博列表
	 *
	 * 返回最新n條提到登錄用戶的微博消息（即包含@username的微博消息）
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/mentions statuses/mentions}
	 *
	 * @access public
	 * @param int $page 返回結果的頁序號。
	 * @param int $count 每次返回的最大記錄數（即頁面大小），不大於200，默認為50。
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的微博消息（即比since_id發表時間晚的微博消息）。可選。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的提到當前登錄用戶微博消息。可選。
	 * @param int $filter_by_author 作者篩選類型，0：全部、1：我關注的人、2：陌生人，默認為0。
	 * @param int $filter_by_source 來源篩選類型，0：全部、1：來自微博、2：來自微群，默認為0。
	 * @param int $filter_by_type 原創篩選類型，0：全部微博、1：原創的微博，默認為0。
	 * @return array
	 */
	function mentions( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0, $filter_by_type = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['filter_by_author'] = $filter_by_author;
		$params['filter_by_source'] = $filter_by_source;
		$params['filter_by_type'] = $filter_by_type;

		return $this->request_with_pager( 'statuses/mentions', $page, $count, $params );
	}


	/**
	 * 根據ID獲取單條微博信息內容
	 *
	 * 獲取單條ID的微博信息，作者信息將同時返回。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/show statuses/show}
	 *
	 * @access public
	 * @param int $id 要獲取已發表的微博ID, 如ID不存在返回空
	 * @return array
	 */
	function show_status( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->get('statuses/show', $params);
	}

	/**
	 * 根據微博id號獲取微博的信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/show_batch statuses/show_batch}
	 *
	 * @param string $ids 需要查詢的微博ID，用半角逗號分隔，最多不超過50個。
	 * @return array
	 */
    function show_batch( $ids )
	{
		$params=array();
		if (is_array($ids) && !empty($ids)) {
			foreach($ids as $k => $v) {
				$this->id_format($ids[$k]);
			}
			$params['ids'] = join(',', $ids);
		} else {
			$params['ids'] = $ids;
		}
		return $this->oauth->get('statuses/show_batch', $params);
	}

	/**
	 * 通過微博（評論、私信）ID獲取其MID
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/querymid statuses/querymid}
	 *
	 * @param int|string $id  需要查詢的微博（評論、私信）ID，批量模式下，用半角逗號分隔，最多不超過20個。
	 * @param int $type  獲取類型，1：微博、2：評論、3：私信，默認為1。
	 * @param int $is_batch 是否使用批量模式，0：否、1：是，默認為0。
	 * @return array
	 */
	function querymid( $id, $type = 1, $is_batch = 0 )
	{
		$params = array();
		$params['id'] = $id;
		$params['type'] = intval($type);
		$params['is_batch'] = intval($is_batch);
		return $this->oauth->get( 'statuses/querymid',  $params);
	}

	/**
	 * 通過微博（評論、私信）MID獲取其ID
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/queryid statuses/queryid}
	 *
	 * @param int|string $mid  需要查詢的微博（評論、私信）MID，批量模式下，用半角逗號分隔，最多不超過20個。
	 * @param int $type  獲取類型，1：微博、2：評論、3：私信，默認為1。
	 * @param int $is_batch 是否使用批量模式，0：否、1：是，默認為0。
	 * @param int $inbox  僅對私信有效，當MID類型為私信時用此參數，0：發件箱、1：收件箱，默認為0 。
	 * @param int $isBase62 MID是否是base62編碼，0：否、1：是，默認為0。
	 * @return array
	 */
	function queryid( $mid, $type = 1, $is_batch = 0, $inbox = 0, $isBase62 = 0)
	{
		$params = array();
		$params['mid'] = $mid;
		$params['type'] = intval($type);
		$params['is_batch'] = intval($is_batch);
		$params['inbox'] = intval($inbox);
		$params['isBase62'] = intval($isBase62);
		return $this->oauth->get('statuses/queryid', $params);
	}

	/**
	 * 按天返回熱門微博轉發榜的微博列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/hot/repost_daily statuses/hot/repost_daily}
	 *
	 * @param int $count 返回的記錄條數，最大不超過50，默認為20。
	 * @param int $base_app 是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @return array
	 */
	function repost_daily( $count = 20, $base_app = 0)
	{
		$params = array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get('statuses/hot/repost_daily',  $params);
	}

	/**
	 * 按周返回熱門微博轉發榜的微博列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/hot/repost_weekly statuses/hot/repost_weekly}
	 *
	 * @param int $count 返回的記錄條數，最大不超過50，默認為20。
	 * @param int $base_app 是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @return array
	 */
	function repost_weekly( $count = 20,  $base_app = 0)
	{
		$params = array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get( 'statuses/hot/repost_weekly',  $params);
	}

	/**
	 * 按天返回熱門微博評論榜的微博列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/hot/comments_daily statuses/hot/comments_daily}
	 *
	 * @param int $count 返回的記錄條數，最大不超過50，默認為20。
	 * @param int $base_app 是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @return array
	 */
	function comments_daily( $count = 20,  $base_app = 0)
	{
		$params =  array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get( 'statuses/hot/comments_daily',  $params);
	}

	/**
	 * 按周返回熱門微博評論榜的微博列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/hot/comments_weekly statuses/hot/comments_weekly}
	 *
	 * @param int $count 返回的記錄條數，最大不超過50，默認為20。
	 * @param int $base_app 是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * @return array
	 */
	function comments_weekly( $count = 20, $base_app = 0)
	{
		$params =  array();
		$params['count'] = intval($count);
		$params['base_app'] = intval($base_app);
		return $this->oauth->get( 'statuses/hot/comments_weekly', $params);
	}


	/**
	 * 轉發一條微博信息。
	 *
	 * 可加評論。為防止重復，發布的信息與最新信息一樣話，將會被忽略。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/repost statuses/repost}
	 *
	 * @access public
	 * @param int $sid 轉發的微博ID
	 * @param string $text 添加的評論信息。可選。
	 * @param int $is_comment 是否在轉發的同時發表評論，0：否、1：評論給當前微博、2：評論給原微博、3：都評論，默認為0。
	 * @return array
	 */
	function repost( $sid, $text = NULL, $is_comment = 0 )
	{
		$this->id_format($sid);

		$params = array();
		$params['id'] = $sid;
		$params['is_comment'] = $is_comment;
		if( $text ) $params['status'] = $text;

		return $this->oauth->post( 'statuses/repost', $params  );
	}

	/**
	 * 刪除一條微博
	 *
	 * 根據ID刪除微博消息。注意：只能刪除自己發布的信息。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/destroy statuses/destroy}
	 *
	 * @access public
	 * @param int $id 要刪除的微博ID
	 * @return array
	 */
	function delete( $id )
	{
		return $this->destroy( $id );
	}

	/**
	 * 刪除一條微博
	 *
	 * 刪除微博。注意：只能刪除自己發布的信息。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/destroy statuses/destroy}
	 *
	 * @access public
	 * @param int $id 要刪除的微博ID
	 * @return array
	 */
	function destroy( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'statuses/destroy',  $params );
	}


	/**
	 * 發表微博
	 *
	 * 發布一條微博信息。
	 * <br />注意：lat和long參數需配合使用，用於標記發表微博消息時所在的地理位置，只有用戶設置中geo_enabled=true時候地理位置信息才有效。
	 * <br />注意：為防止重復提交，當用戶發布的微博消息與上次成功發布的微博消息內容一樣時，將返回400錯誤，給出錯誤提示：“40025:Error: repeated weibo text!“。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/update statuses/update}
	 *
	 * @access public
	 * @param string $status 要更新的微博信息。信息內容不超過140個漢字, 為空返回400錯誤。
	 * @param float $lat 緯度，發表當前微博所在的地理位置，有效範圍 -90.0到+90.0, +表示北緯。可選。
	 * @param float $long 經度。有效範圍-180.0到+180.0, +表示東經。可選。
	 * @param mixed $annotations 可選參數。元數據，主要是為了方便第三方應用記錄一些適合於自己使用的信息。每條微博可以包含一個或者多個元數據。請以json字串的形式提交，字串長度不超過512個字符，或者數組方式，要求json_encode後字串長度不超過512個字符。具體內容可以自定。例如：'[{"type2":123}, {"a":"b", "c":"d"}]'或array(array("type2"=>123), array("a"=>"b", "c"=>"d"))。
	 * @return array
	 */
	function update( $status, $lat = NULL, $long = NULL, $annotations = NULL )
	{
		$params = array();
		$params['status'] = $status;
		if ($lat) {
			$params['lat'] = floatval($lat);
		}
		if ($long) {
			$params['long'] = floatval($long);
		}
		if (is_string($annotations)) {
			$params['annotations'] = $annotations;
		} elseif (is_array($annotations)) {
			$params['annotations'] = json_encode($annotations);
		}

		return $this->oauth->post( 'statuses/update', $params );
	}

	/**
	 * 發表圖片微博
	 *
	 * 發表圖片微博消息。目前上傳圖片大小限制為<5M。
	 * <br />注意：lat和long參數需配合使用，用於標記發表微博消息時所在的地理位置，只有用戶設置中geo_enabled=true時候地理位置信息才有效。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/upload statuses/upload}
	 *
	 * @access public
	 * @param string $status 要更新的微博信息。信息內容不超過140個漢字, 為空返回400錯誤。
	 * @param string $pic_path 要發布的圖片路徑, 支持url。[只支持png/jpg/gif三種格式, 增加格式請修改get_image_mime方法]
	 * @param float $lat 緯度，發表當前微博所在的地理位置，有效範圍 -90.0到+90.0, +表示北緯。可選。
	 * @param float $long 可選參數，經度。有效範圍-180.0到+180.0, +表示東經。可選。
	 * @return array
	 */
	function upload( $status, $pic_path, $lat = NULL, $long = NULL )
	{
		$params = array();
		$params['status'] = $status;
		$params['pic'] = '@'.$pic_path;
		if ($lat) {
			$params['lat'] = floatval($lat);
		}
		if ($long) {
			$params['long'] = floatval($long);
		}

		return $this->oauth->post( 'statuses/upload', $params, true );
	}


	/**
	 * 指定一個圖片URL地址抓取後上傳並同時發布一條新微博
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/statuses/upload_url_text statuses/upload_url_text}
	 *
	 * @param string $status  要發布的微博文本內容，內容不超過140個漢字。
	 * @param string $url    圖片的URL地址，必須以http開頭。
	 * @return array
	 */
	function upload_url_text( $status,  $url )
	{
		$params = array();
		$params['status'] = $status;
		$params['url'] = $url;
		return $this->oauth->post( 'statuses/upload', $params, true );
	}


	/**
	 * 獲取表情列表
	 *
	 * 返回新浪微博官方所有表情、魔法表情的相關信息。包括短語、表情類型、表情分類，是否熱門等。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/emotions emotions}
	 *
	 * @access public
	 * @param string $type 表情類別。"face":普通表情，"ani"：魔法表情，"cartoon"：動漫表情。默認為"face"。可選。
	 * @param string $language 語言類別，"cnname"簡體，"twname"繁體。默認為"cnname"。可選
	 * @return array
	 */
	function emotions( $type = "face", $language = "cnname" )
	{
		$params = array();
		$params['type'] = $type;
		$params['language'] = $language;
		return $this->oauth->get( 'emotions', $params );
	}


	/**
	 * 根據微博ID返回某條微博的評論列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/comments/show comments/show}
	 *
	 * @param int $sid 需要查詢的微博ID。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $since_id 若指定此參數，則返回ID比since_id大的評論（即比since_id時間晚的評論），默認為0。
	 * @param int $max_id  若指定此參數，則返回ID小於或等於max_id的評論，默認為0。
	 * @param int $filter_by_author 作者篩選類型，0：全部、1：我關注的人、2：陌生人，默認為0。
	 * @return array
	 */
	function get_comments_by_sid( $sid, $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0 )
	{
		$params = array();
		$this->id_format($sid);
		$params['id'] = $sid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_author'] = $filter_by_author;
		return $this->oauth->get( 'comments/show',  $params );
	}


	/**
	 * 獲取當前登錄用戶所發出的評論列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/comments/by_me comments/by_me}
	 *
	 * @param int $since_id 若指定此參數，則返回ID比since_id大的評論（即比since_id時間晚的評論），默認為0。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的評論，默認為0。
	 * @param int $count  單頁返回的記錄條數，默認為50。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @param int $filter_by_source 來源篩選類型，0：全部、1：來自微博的評論、2：來自微群的評論，默認為0。
	 * @return array
	 */
	function comments_by_me( $page = 1 , $count = 50, $since_id = 0, $max_id = 0,  $filter_by_source = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_source'] = $filter_by_source;
		return $this->oauth->get( 'comments/by_me', $params );
	}

	/**
	 * 獲取當前登錄用戶所接收到的評論列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/comments/to_me comments/to_me}
	 *
	 * @param int $since_id 若指定此參數，則返回ID比since_id大的評論（即比since_id時間晚的評論），默認為0。
	 * @param int $max_id  若指定此參數，則返回ID小於或等於max_id的評論，默認為0。
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @param int $filter_by_author 作者篩選類型，0：全部、1：我關注的人、2：陌生人，默認為0。
	 * @param int $filter_by_source 來源篩選類型，0：全部、1：來自微博的評論、2：來自微群的評論，默認為0。
	 * @return array
	 */
	function comments_to_me( $page = 1 , $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0)
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_author'] = $filter_by_author;
		$params['filter_by_source'] = $filter_by_source;
		return $this->oauth->get( 'comments/to_me', $params );
	}

	/**
	 * 最新評論(按時間)
	 *
	 * 返回最新n條發送及收到的評論。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/comments/timeline comments/timeline}
	 *
	 * @access public
	 * @param int $page 頁碼
	 * @param int $count 每次返回的最大記錄數，最多返回200條，默認50。
	 * @param int $since_id 若指定此參數，則只返回ID比since_id大的評論（比since_id發表時間晚）。可選。
	 * @param int $max_id 若指定此參數，則返回ID小於或等於max_id的評論。可選。
	 * @return array
	 */
	function comments_timeline( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager( 'comments/timeline', $page, $count, $params );
	}


	/**
	 * 獲取最新的提到當前登錄用戶的評論，即@我的評論
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/comments/mentions comments/mentions}
	 *
	 * @param int $since_id 若指定此參數，則返回ID比since_id大的評論（即比since_id時間晚的評論），默認為0。
	 * @param int $max_id  若指定此參數，則返回ID小於或等於max_id的評論，默認為0。
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @param int $filter_by_author  作者篩選類型，0：全部、1：我關注的人、2：陌生人，默認為0。
	 * @param int $filter_by_source 來源篩選類型，0：全部、1：來自微博的評論、2：來自微群的評論，默認為0。
	 * @return array
	 */
	function comments_mentions( $page = 1, $count = 50, $since_id = 0, $max_id = 0, $filter_by_author = 0, $filter_by_source = 0)
	{
		$params = array();
		$params['since_id'] = $since_id;
		$params['max_id'] = $max_id;
		$params['count'] = $count;
		$params['page'] = $page;
		$params['filter_by_author'] = $filter_by_author;
		$params['filter_by_source'] = $filter_by_source;
		return $this->oauth->get( 'comments/mentions', $params );
	}


	/**
	 * 根據評論ID批量返回評論信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/comments/show_batch comments/show_batch}
	 *
	 * @param string $cids 需要查詢的批量評論ID，用半角逗號分隔，最大50
	 * @return array
	 */
	function comments_show_batch( $cids )
	{
		$params = array();
		if (is_array( $cids) && !empty( $cids)) {
			foreach($cids as $k => $v) {
				$this->id_format($cids[$k]);
			}
			$params['cids'] = join(',', $cids);
		} else {
			$params['cids'] = $cids;
		}
		return $this->oauth->get( 'comments/show_batch', $params );
	}


	/**
	 * 對一條微博進行評論
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/comments/create comments/create}
	 *
	 * @param string $comment 評論內容，內容不超過140個漢字。
	 * @param int $id 需要評論的微博ID。
	 * @param int $comment_ori 當評論轉發微博時，是否評論給原微博，0：否、1：是，默認為0。
	 * @return array
	 */
	function send_comment( $id , $comment , $comment_ori = 0)
	{
		$params = array();
		$params['comment'] = $comment;
		$this->id_format($id);
		$params['id'] = $id;
		$params['comment_ori'] = $comment_ori;
		return $this->oauth->post( 'comments/create', $params );
	}

	/**
	 * 刪除當前用戶的微博評論信息。
	 *
	 * 注意：只能刪除自己發布的評論，發部微博的用戶不可以刪除其他人的評論。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/statuses/comment_destroy statuses/comment_destroy}
	 *
	 * @access public
	 * @param int $cid 要刪除的評論id
	 * @return array
	 */
	function comment_destroy( $cid )
	{
		$params = array();
		$params['cid'] = $cid;
		return $this->oauth->post( 'comments/destroy', $params);
	}


	/**
	 * 根據評論ID批量刪除評論
	 *
	 * 注意：只能刪除自己發布的評論，發部微博的用戶不可以刪除其他人的評論。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/comments/destroy_batch comments/destroy_batch}
	 *
	 * @access public
	 * @param string $ids 需要刪除的評論ID，用半角逗號隔開，最多20個。
	 * @return array
	 */
	function comment_destroy_batch( $ids )
	{
		$params = array();
		if (is_array($ids) && !empty($ids)) {
			foreach($ids as $k => $v) {
				$this->id_format($ids[$k]);
			}
			$params['cids'] = join(',', $ids);
		} else {
			$params['cids'] = $ids;
		}
		return $this->oauth->post( 'comments/destroy_batch', $params);
	}


	/**
	 * 回復一條評論
	 *
	 * 為防止重復，發布的信息與最後一條評論/回復信息一樣話，將會被忽略。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/comments/reply comments/reply}
	 *
	 * @access public
	 * @param int $sid 微博id
	 * @param string $text 評論內容。
	 * @param int $cid 評論id
	 * @param int $without_mention 1：回復中不自動加入“回復@用戶名”，0：回復中自動加入“回復@用戶名”.默認為0.
     * @param int $comment_ori	  當評論轉發微博時，是否評論給原微博，0：否、1：是，默認為0。
	 * @return array
	 */
	function reply( $sid, $text, $cid, $without_mention = 0, $comment_ori = 0 )
	{
		$this->id_format( $sid );
		$this->id_format( $cid );
		$params = array();
		$params['id'] = $sid;
		$params['comment'] = $text;
		$params['cid'] = $cid;
		$params['without_mention'] = $without_mention;
		$params['comment_ori'] = $comment_ori;

		return $this->oauth->post( 'comments/reply', $params );

	}

	/**
	 * 根據用戶UID或暱稱獲取用戶資料
	 *
	 * 按用戶UID或暱稱返回用戶資料，同時也將返回用戶的最新發布的微博。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/users/show users/show}
	 *
	 * @access public
	 * @param int  $uid 用戶UID。
	 * @return array
	 */
	function show_user_by_id( $uid )
	{
		$params=array();
		if ( $uid !== NULL ) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}

		return $this->oauth->get('users/show', $params );
	}

	/**
	 * 根據用戶UID或暱稱獲取用戶資料
	 *
	 * 按用戶UID或暱稱返回用戶資料，同時也將返回用戶的最新發布的微博。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/users/show users/show}
	 *
	 * @access public
	 * @param string  $screen_name 用戶UID。
	 * @return array
	 */
	function show_user_by_name( $screen_name )
	{
		$params = array();
		$params['screen_name'] = $screen_name;

		return $this->oauth->get( 'users/show', $params );
	}

	/**
	 * 通過個性化域名獲取用戶資料以及用戶最新的一條微博
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/users/domain_show users/domain_show}
	 *
	 * @access public
	 * @param mixed $domain 用戶個性域名。例如：lazypeople，而不是http://weibo.com/lazypeople
	 * @return array
	 */
	function domain_show( $domain )
	{
		$params = array();
		$params['domain'] = $domain;
		return $this->oauth->get( 'users/domain_show', $params );
	}

	 /**
	 * 批量獲取用戶信息按uids
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/users/show_batch users/show_batch}
	 *
	 * @param string $uids 需要查詢的用戶ID，用半角逗號分隔，一次最多20個。
	 * @return array
	 */
	function users_show_batch_by_id( $uids )
	{
		$params = array();
		if (is_array( $uids ) && !empty( $uids )) {
			foreach( $uids as $k => $v ) {
				$this->id_format( $uids[$k] );
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->get( 'users/show_batch', $params );
	}

	/**
	 * 批量獲取用戶信息按screen_name
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/users/show_batch users/show_batch}
	 *
	 * @param string  $screen_name 需要查詢的用戶暱稱，用半角逗號分隔，一次最多20個。
	 * @return array
	 */
	function users_show_batch_by_name( $screen_name )
	{
		$params = array();
		if (is_array( $screen_name ) && !empty( $screen_name )) {
			$params['screen_name'] = join(',', $screen_name);
		} else {
			$params['screen_name'] = $screen_name;
		}
		return $this->oauth->get( 'users/show_batch', $params );
	}


	/**
	 * 獲取用戶的關注列表
	 *
	 * 如果沒有提供cursor參數，將只返回最前面的5000個關注id
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/friends friendships/friends}
	 *
	 * @access public
	 * @param int $cursor 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @param int $count 單頁返回的記錄條數，默認為50，最大不超過200。
	 * @param int $uid  要獲取的用戶的ID。
	 * @return array
	 */
	function friends_by_id( $uid, $cursor = 0, $count = 50 )
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		$params['uid'] = $uid;

		return $this->oauth->get( 'friendships/friends', $params );
	}


	/**
	 * 獲取用戶的關注列表
	 *
	 * 如果沒有提供cursor參數，將只返回最前面的5000個關注id
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/friends friendships/friends}
	 *
	 * @access public
	 * @param int $cursor 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @param int $count 單頁返回的記錄條數，默認為50，最大不超過200。
	 * @param string $screen_name  要獲取的用戶的 screen_name
	 * @return array
	 */
	function friends_by_name( $screen_name, $cursor = 0, $count = 50 )
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		$params['screen_name'] = $screen_name;
		return $this->oauth->get( 'friendships/friends', $params );
	}


	/**
	 * 獲取兩個用戶之間的共同關注人列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/friends/in_common friendships/friends/in_common}
	 *
	 * @param int $uid  需要獲取共同關注關系的用戶UID
	 * @param int $suid  需要獲取共同關注關系的用戶UID，默認為當前登錄用戶。
	 * @param int $count  單頁返回的記錄條數，默認為50。
	 * @param int $page  返回結果的頁碼，默認為1。
	 * @return array
	 */
	function friends_in_common( $uid, $suid = NULL, $page = 1, $count = 50 )
	{
		$params = array();
		$params['uid'] = $uid;
		$params['suid'] = $suid;
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'friendships/friends/in_common', $params  );
	}

	/**
	 * 獲取用戶的雙向關注列表，即互粉列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/friends/bilateral friendships/friends/bilateral}
	 *
	 * @param int $uid  需要獲取雙向關注列表的用戶UID。
	 * @param int $count  單頁返回的記錄條數，默認為50。
	 * @param int $page  返回結果的頁碼，默認為1。
	 * @param int $sort  排序類型，0：按關注時間最近排序，默認為0。
	 * @return array
	 **/
	function bilateral( $uid, $page = 1, $count = 50, $sort = 0 )
	{
		$params = array();
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['page'] = $page;
		$params['sort'] = $sort;
		return $this->oauth->get( 'friendships/friends/bilateral', $params  );
	}

	/**
	 * 獲取用戶的雙向關注uid列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/friends/bilateral/ids friendships/friends/bilateral/ids}
	 *
	 * @param int $uid  需要獲取雙向關注列表的用戶UID。
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page  返回結果的頁碼，默認為1。
	 * @param int $sort  排序類型，0：按關注時間最近排序，默認為0。
	 * @return array
	 **/
	function bilateral_ids( $uid, $page = 1, $count = 50, $sort = 0)
	{
		$params = array();
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['page'] = $page;
		$params['sort'] = $sort;
		return $this->oauth->get( 'friendships/friends/bilateral/ids',  $params  );
	}

	/**
	 * 獲取用戶的關注列表uid
	 *
	 * 如果沒有提供cursor參數，將只返回最前面的5000個關注id
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/friends/ids friendships/friends/ids}
	 *
	 * @access public
	 * @param int $cursor 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @param int $count 每次返回的最大記錄數（即頁面大小），不大於5000, 默認返回500。
	 * @param int $uid 要獲取的用戶 UID，默認為當前用戶
	 * @return array
	 */
	function friends_ids_by_id( $uid, $cursor = 0, $count = 500 )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		return $this->oauth->get( 'friendships/friends/ids', $params );
	}

	/**
	 * 獲取用戶的關注列表uid
	 *
	 * 如果沒有提供cursor參數，將只返回最前面的5000個關注id
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/friends/ids friendships/friends/ids}
	 *
	 * @access public
	 * @param int $cursor 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @param int $count 每次返回的最大記錄數（即頁面大小），不大於5000, 默認返回500。
	 * @param string $screen_name 要獲取的用戶的 screen_name，默認為當前用戶
	 * @return array
	 */
	function friends_ids_by_name( $screen_name, $cursor = 0, $count = 500 )
	{
		$params = array();
		$params['cursor'] = $cursor;
		$params['count'] = $count;
		$params['screen_name'] = $screen_name;
		return $this->oauth->get( 'friendships/friends/ids', $params );
	}


	/**
	 * 批量獲取當前登錄用戶的關注人的備注信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/friends/remark_batch friendships/friends/remark_batch}
	 *
	 * @param string $uids  需要獲取備注的用戶UID，用半角逗號分隔，最多不超過50個。
	 * @return array
	 **/
	function friends_remark_batch( $uids )
	{
		$params = array();
		if (is_array( $uids ) && !empty( $uids )) {
			foreach( $uids as $k => $v) {
				$this->id_format( $uids[$k] );
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->get( 'friendships/friends/remark_batch', $params  );
	}

	/**
	 * 獲取用戶的粉絲列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param int $uid  需要查詢的用戶UID
	 * @param int $count 單頁返回的記錄條數，默認為50，最大不超過200。
	 * @param int $cursor false 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @return array
	 **/
	function followers_by_id( $uid , $cursor = 0 , $count = 50)
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers', $params  );
	}

	/**
	 * 獲取用戶的粉絲列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param string $screen_name  需要查詢的用戶的暱稱
	 * @param int  $count 單頁返回的記錄條數，默認為50，最大不超過200。
	 * @param int  $cursor false 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @return array
	 **/
	function followers_by_name( $screen_name, $cursor = 0 , $count = 50 )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers', $params  );
	}

	/**
	 * 獲取用戶的粉絲列表uid
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param int $uid 需要查詢的用戶UID
	 * @param int $count 單頁返回的記錄條數，默認為50，最大不超過200。
	 * @param int $cursor 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @return array
	 **/
	function followers_ids_by_id( $uid, $cursor = 0 , $count = 50 )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers/ids', $params  );
	}

	/**
	 * 獲取用戶的粉絲列表uid
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/followers friendships/followers}
	 *
	 * @param string $screen_name 需要查詢的用戶screen_name
	 * @param int $count 單頁返回的記錄條數，默認為50，最大不超過200。
	 * @param int $cursor 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @return array
	 **/
	function followers_ids_by_name( $screen_name, $cursor = 0 , $count = 50 )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'friendships/followers/ids', $params  );
	}

	/**
	 * 獲取優質粉絲
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/followers/active friendships/followers/active}
	 *
	 * @param int $uid 需要查詢的用戶UID。
	 * @param int $count 返回的記錄條數，默認為20，最大不超過200。
     * @return array
	 **/
	function followers_active( $uid,  $count = 20)
	{
		$param = array();
		$this->id_format($uid);
		$param['uid'] = $uid;
		$param['count'] = $count;
		return $this->oauth->get( 'friendships/followers/active', $param);
	}


	/**
	 * 獲取當前登錄用戶的關注人中又關注了指定用戶的用戶列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/friends_chain/followers friendships/friends_chain/followers}
	 *
	 * @param int $uid 指定的關注目標用戶UID。
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @return array
	 **/
	function friends_chain_followers( $uid, $page = 1, $count = 50 )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'friendships/friends_chain/followers',  $params );
	}

	/**
	 * 返回兩個用戶關系的詳細情況
	 *
	 * 如果源用戶或目的用戶不存在，將返回http的400錯誤
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/show friendships/show}
	 *
	 * @access public
	 * @param mixed $target_id 目標用戶UID
	 * @param mixed $source_id 源用戶UID，可選，默認為當前的用戶
	 * @return array
	 */
	function is_followed_by_id( $target_id, $source_id = NULL )
	{
		$params = array();
		$this->id_format($target_id);
		$params['target_id'] = $target_id;

		if ( $source_id != NULL ) {
			$this->id_format($source_id);
			$params['source_id'] = $source_id;
		}

		return $this->oauth->get( 'friendships/show', $params );
	}

	/**
	 * 返回兩個用戶關系的詳細情況
	 *
	 * 如果源用戶或目的用戶不存在，將返回http的400錯誤
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/show friendships/show}
	 *
	 * @access public
	 * @param mixed $target_name 目標用戶的微博暱稱
	 * @param mixed $source_name 源用戶的微博暱稱，可選，默認為當前的用戶
	 * @return array
	 */
	function is_followed_by_name( $target_name, $source_name = NULL )
	{
		$params = array();
		$params['target_screen_name'] = $target_name;

		if ( $source_name != NULL ) {
			$params['source_screen_name'] = $source_name;
		}

		return $this->oauth->get( 'friendships/show', $params );
	}

	/**
	 * 關注一個用戶。
	 *
	 * 成功則返回關注人的資料，目前最多關注2000人，失敗則返回一條字符串的說明。如果已經關注了此人，則返回http 403的狀態。關注不存在的ID將返回400。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/create friendships/create}
	 *
	 * @access public
	 * @param int $uid 要關注的用戶UID
	 * @return array
	 */
	function follow_by_id( $uid )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		return $this->oauth->post( 'friendships/create', $params );
	}

	/**
	 * 關注一個用戶。
	 *
	 * 成功則返回關注人的資料，目前的最多關注2000人，失敗則返回一條字符串的說明。如果已經關注了此人，則返回http 403的狀態。關注不存在的ID將返回400。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/create friendships/create}
	 *
	 * @access public
	 * @param string $screen_name 要關注的用戶暱稱
	 * @return array
	 */
	function follow_by_name( $screen_name )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		return $this->oauth->post( 'friendships/create', $params);
	}


	/**
	 * 根據用戶UID批量關注用戶
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/friendships/create_batch friendships/create_batch}
	 *
	 * @param string $uids 要關注的用戶UID，用半角逗號分隔，最多不超過20個。
	 * @return array
	 */
	function follow_create_batch( $uids )
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->post( 'friendships/create_batch', $params);
	}

	/**
	 * 取消關注某用戶
	 *
	 * 取消關注某用戶。成功則返回被取消關注人的資料，失敗則返回一條字符串的說明。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/destroy friendships/destroy}
	 *
	 * @access public
	 * @param int $uid 要取消關注的用戶UID
	 * @return array
	 */
	function unfollow_by_id( $uid )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		return $this->oauth->post( 'friendships/destroy', $params);
	}

	/**
	 * 取消關注某用戶
	 *
	 * 取消關注某用戶。成功則返回被取消關注人的資料，失敗則返回一條字符串的說明。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/destroy friendships/destroy}
	 *
	 * @access public
	 * @param string $screen_name 要取消關注的用戶暱稱
	 * @return array
	 */
	function unfollow_by_name( $screen_name )
	{
		$params = array();
		$params['screen_name'] = $screen_name;
		return $this->oauth->post( 'friendships/destroy', $params);
	}

	/**
	 * 更新當前登錄用戶所關注的某個好友的備注信息
	 *
	 * 只能修改當前登錄用戶所關注的用戶的備注信息。否則將給出400錯誤。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/friendships/remark/update friendships/remark/update}
	 *
	 * @access public
	 * @param int $uid 需要修改備注信息的用戶ID。
	 * @param string $remark 備注信息。
	 * @return array
	 */
	function update_remark( $uid, $remark )
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		$params['remark'] = $remark;
		return $this->oauth->post( 'friendships/remark/update', $params);
	}

	/**
	 * 獲取當前用戶最新私信列表
	 *
	 * 返回用戶的最新n條私信，並包含發送者和接受者的詳細資料。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/direct_messages direct_messages}
	 *
	 * @access public
	 * @param int $page 頁碼
	 * @param int $count 每次返回的最大記錄數，最多返回200條，默認50。
	 * @param int64 $since_id 返回ID比數值since_id大（比since_id時間晚的）的私信。可選。
	 * @param int64 $max_id 返回ID不大於max_id(時間不晚於max_id)的私信。可選。
	 * @return array
	 */
	function list_dm( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager( 'direct_messages', $page, $count, $params );
	}

	/**
	 * 獲取當前用戶發送的最新私信列表
	 *
	 * 返回登錄用戶已發送最新50條私信。包括發送者和接受者的詳細資料。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/direct_messages/sent direct_messages/sent}
	 *
	 * @access public
	 * @param int $page 頁碼
	 * @param int $count 每次返回的最大記錄數，最多返回200條，默認50。
	 * @param int64 $since_id 返回ID比數值since_id大（比since_id時間晚的）的私信。可選。
	 * @param int64 $max_id 返回ID不大於max_id(時間不晚於max_id)的私信。可選。
	 * @return array
	 */
	function list_dm_sent( $page = 1, $count = 50, $since_id = 0, $max_id = 0 )
	{
		$params = array();
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}

		return $this->request_with_pager( 'direct_messages/sent', $page, $count, $params );
	}


	/**
	 * 獲取與當前登錄用戶有私信往來的用戶列表，與該用戶往來的最新私信
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/direct_messages/user_list direct_messages/user_list}
	 *
	 * @param int $count  單頁返回的記錄條數，默認為20。
	 * @param int $cursor 返回結果的遊標，下一頁用返回值裡的next_cursor，上一頁用previous_cursor，默認為0。
	 * @return array
	 */
	function dm_user_list( $count = 20, $cursor = 0)
	{
		$params = array();
		$params['count'] = $count;
		$params['cursor'] = $cursor;
		return $this->oauth->get( 'direct_messages/user_list', $params );
	}

	/**
	 * 獲取與指定用戶的往來私信列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/direct_messages/conversation direct_messages/conversation}
	 *
	 * @param int $uid 需要查詢的用戶的UID。
	 * @param int $since_id 若指定此參數，則返回ID比since_id大的私信（即比since_id時間晚的私信），默認為0。
	 * @param int $max_id  若指定此參數，則返回ID小於或等於max_id的私信，默認為0。
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page  返回結果的頁碼，默認為1。
	 * @return array
	 */
	function dm_conversation( $uid, $page = 1, $count = 50, $since_id = 0, $max_id = 0)
	{
		$params = array();
		$this->id_format($uid);
		$params['uid'] = $uid;
		if ($since_id) {
			$this->id_format($since_id);
			$params['since_id'] = $since_id;
		}
		if ($max_id) {
			$this->id_format($max_id);
			$params['max_id'] = $max_id;
		}
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'direct_messages/conversation', $params );
	}

	/**
	 * 根據私信ID批量獲取私信內容
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/direct_messages/show_batch direct_messages/show_batch}
	 *
	 * @param string  $dmids 需要查詢的私信ID，用半角逗號分隔，一次最多50個
	 * @return array
	 */
	function dm_show_batch( $dmids )
	{
		$params = array();
		if (is_array($dmids) && !empty($dmids)) {
			foreach($dmids as $k => $v) {
				$this->id_format($dmids[$k]);
			}
			$params['dmids'] = join(',', $dmids);
		} else {
			$params['dmids'] = $dmids;
		}
		return $this->oauth->get( 'direct_messages/show_batch',  $params );
	}

	/**
	 * 發送私信
	 *
	 * 發送一條私信。成功將返回完整的發送消息。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/direct_messages/new direct_messages/new}
	 *
	 * @access public
	 * @param int $uid 用戶UID
	 * @param string $text 要發生的消息內容，文本大小必須小於300個漢字。
	 * @param int $id 需要發送的微博ID。
	 * @return array
	 */
	function send_dm_by_id( $uid, $text, $id = NULL )
	{
		$params = array();
		$this->id_format( $uid );
		$params['text'] = $text;
		$params['uid'] = $uid;
		if ($id) {
			$this->id_format( $id );
			$params['id'] = $id;
		}
		return $this->oauth->post( 'direct_messages/new', $params );
	}

	/**
	 * 發送私信
	 *
	 * 發送一條私信。成功將返回完整的發送消息。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/direct_messages/new direct_messages/new}
	 *
	 * @access public
	 * @param string $screen_name 用戶暱稱
	 * @param string $text 要發生的消息內容，文本大小必須小於300個漢字。
	 * @param int $id 需要發送的微博ID。
	 * @return array
	 */
	function send_dm_by_name( $screen_name, $text, $id = NULL )
	{
		$params = array();
		$params['text'] = $text;
		$params['screen_name'] = $screen_name;
		if ($id) {
			$this->id_format( $id );
			$params['id'] = $id;
		}
		return $this->oauth->post( 'direct_messages/new', $params);
	}

	/**
	 * 刪除一條私信
	 *
	 * 按ID刪除私信。操作用戶必須為私信的接收人。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/direct_messages/destroy direct_messages/destroy}
	 *
	 * @access public
	 * @param int $did 要刪除的私信主鍵ID
	 * @return array
	 */
	function delete_dm( $did )
	{
		$this->id_format($did);
		$params = array();
		$params['id'] = $did;
		return $this->oauth->post('direct_messages/destroy', $params);
	}

	/**
	 * 批量刪除私信
	 *
	 * 批量刪除當前登錄用戶的私信。出現異常時，返回400錯誤。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/direct_messages/destroy_batch direct_messages/destroy_batch}
	 *
	 * @access public
	 * @param mixed $dids 欲刪除的一組私信ID，用半角逗號隔開，或者由一組評論ID組成的數組。最多20個。例如："4976494627, 4976262053"或array(4976494627,4976262053);
	 * @return array
	 */
	function delete_dms( $dids )
	{
		$params = array();
		if (is_array($dids) && !empty($dids)) {
			foreach($dids as $k => $v) {
				$this->id_format($dids[$k]);
			}
			$params['ids'] = join(',', $dids);
		} else {
			$params['ids'] = $dids;
		}

		return $this->oauth->post( 'direct_messages/destroy_batch', $params);
	}



	/**
	 * 獲取用戶基本信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/basic account/profile/basic}
	 *
	 * @param int $uid  需要獲取基本信息的用戶UID，默認為當前登錄用戶。
	 * @return array
	 */
	function account_profile_basic( $uid = NULL  )
	{
		$params = array();
		if ($uid) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}
		return $this->oauth->get( 'account/profile/basic', $params );
	}

	/**
	 * 獲取用戶的教育信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/education account/profile/education}
	 *
	 * @param int $uid  需要獲取教育信息的用戶UID，默認為當前登錄用戶。
	 * @return array
	 */
	function account_education( $uid = NULL )
	{
		$params = array();
		if ($uid) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}
		return $this->oauth->get( 'account/profile/education', $params );
	}

	/**
	 * 批量獲取用戶的教育信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/education_batch account/profile/education_batch}
	 *
	 * @param string $uids 需要獲取教育信息的用戶UID，用半角逗號分隔，最多不超過20。
	 * @return array
	 */
	function account_education_batch( $uids  )
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}

		return $this->oauth->get( 'account/profile/education_batch', $params );
	}


	/**
	 * 獲取用戶的職業信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/career account/profile/career}
	 *
	 * @param int $uid  需要獲取教育信息的用戶UID，默認為當前登錄用戶。
	 * @return array
	 */
	function account_career( $uid = NULL )
	{
		$params = array();
		if ($uid) {
			$this->id_format($uid);
			$params['uid'] = $uid;
		}
		return $this->oauth->get( 'account/profile/career', $params );
	}

	/**
	 * 批量獲取用戶的職業信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/career_batch account/profile/career_batch}
	 *
	 * @param string $uids 需要獲取教育信息的用戶UID，用半角逗號分隔，最多不超過20。
	 * @return array
	 */
	function account_career_batch( $uids )
	{
		$params = array();
		if (is_array($uids) && !empty($uids)) {
			foreach($uids as $k => $v) {
				$this->id_format($uids[$k]);
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}

		return $this->oauth->get( 'account/profile/career_batch', $params );
	}

	/**
	 * 獲取隱私信息設置情況
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/get_privacy account/get_privacy}
	 *
	 * @access public
	 * @return array
	 */
	function get_privacy()
	{
		return $this->oauth->get('account/get_privacy');
	}

	/**
	 * 獲取所有的學校列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/school_list account/profile/school_list}
	 *
	 * @param array $query 搜索選項。格式：array('key0'=>'value0', 'key1'=>'value1', ....)。支持的key:
	 *  - province	int		省份範圍，省份ID。
	 *  - city		int		城市範圍，城市ID。
	 *  - area		int		區域範圍，區ID。
	 *  - type		int		學校類型，1：大學、2：高中、3：中專技校、4：初中、5：小學，默認為1。
	 *  - capital	string	學校首字母，默認為A。
	 *  - keyword	string	學校名稱關鍵字。
	 *  - count		int		返回的記錄條數，默認為10。
	 * 參數keyword與capital二者必選其一，且只能選其一。按首字母capital查詢時，必須提供province參數。
	 * @access public
	 * @return array
	 */
	function school_list( $query )
	{
		$params = $query;

		return $this->oauth->get( 'account/profile/school_list', $params );
	}

	/**
	 * 獲取當前登錄用戶的API訪問頻率限制情況
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/rate_limit_status account/rate_limit_status}
	 *
	 * @access public
	 * @return array
	 */
	function rate_limit_status()
	{
		return $this->oauth->get( 'account/rate_limit_status' );
	}

	/**
	 * OAuth授權之後，獲取授權用戶的UID
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/get_uid account/get_uid}
	 *
	 * @access public
	 * @return array
	 */
	function get_uid()
	{
		return $this->oauth->get( 'account/get_uid' );
	}


	/**
	 * 更改用戶資料
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/basic_update account/profile/basic_update}
	 *
	 * @access public
	 * @param array $profile 要修改的資料。格式：array('key1'=>'value1', 'key2'=>'value2', .....)。
	 * 支持修改的項：
	 *  - screen_name		string	用戶暱稱，不可為空。
	 *  - gender	i		string	用戶性別，m：男、f：女，不可為空。
	 *  - real_name			string	用戶真實姓名。
	 *  - real_name_visible	int		真實姓名可見範圍，0：自己可見、1：關注人可見、2：所有人可見。
	 *  - province	true	int		省份代碼ID，不可為空。
	 *  - city	true		int		城市代碼ID，不可為空。
	 *  - birthday			string	用戶生日，格式：yyyy-mm-dd。
	 *  - birthday_visible	int		生日可見範圍，0：保密、1：只顯示月日、2：只顯示星座、3：所有人可見。
	 *  - qq				string	用戶QQ號碼。
	 *  - qq_visible		int		用戶QQ可見範圍，0：自己可見、1：關注人可見、2：所有人可見。
	 *  - msn				string	用戶MSN。
	 *  - msn_visible		int		用戶MSN可見範圍，0：自己可見、1：關注人可見、2：所有人可見。
	 *  - url				string	用戶博客地址。
	 *  - url_visible		int		用戶博客地址可見範圍，0：自己可見、1：關注人可見、2：所有人可見。
	 *  - credentials_type	int		證件類型，1：身份證、2：學生證、3：軍官證、4：護照。
	 *  - credentials_num	string	證件號碼。
	 *  - email				string	用戶常用郵箱地址。
	 *  - email_visible		int		用戶常用郵箱地址可見範圍，0：自己可見、1：關注人可見、2：所有人可見。
	 *  - lang				string	語言版本，zh_cn：簡體中文、zh_tw：繁體中文。
	 *  - description		string	用戶描述，最長不超過70個漢字。
	 * 填寫birthday參數時，做如下約定：
	 *  - 只填年份時，採用1986-00-00格式；
	 *  - 只填月份時，採用0000-08-00格式；
	 *  - 只填某日時，採用0000-00-28格式。
	 * @return array
	 */
	function update_profile( $profile )
	{
		return $this->oauth->post( 'account/profile/basic_update',  $profile);
	}


	/**
	 * 設置教育信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/edu_update account/profile/edu_update}
	 *
	 * @access public
	 * @param array $edu_update 要修改的學校信息。格式：array('key1'=>'value1', 'key2'=>'value2', .....)。
	 * 支持設置的項：
	 *  - type			int		學校類型，1：大學、2：高中、3：中專技校、4：初中、5：小學，默認為1。必填參數
	 *  - school_id	`	int		學校代碼，必填參數
	 *  - id			string	需要修改的教育信息ID，不傳則為新建，傳則為更新。
	 *  - year			int		入學年份，最小為1900，最大不超過當前年份
	 *  - department	string	院系或者班別。
	 *  - visible		int		開放等級，0：僅自己可見、1：關注的人可見、2：所有人可見。
	 * @return array
	 */
	function edu_update( $edu_update )
	{
		return $this->oauth->post( 'account/profile/edu_update',  $edu_update);
	}

	/**
	 * 根據學校ID刪除用戶的教育信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/edu_destroy account/profile/edu_destroy}
	 *
	 * @param int $id 教育信息裡的學校ID。
	 * @return array
	 */
	function edu_destroy( $id )
	{
		$this->id_format( $id );
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'account/profile/edu_destroy', $params);
	}

	/**
	 * 設置職業信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/car_update account/profile/car_update}
	 *
	 * @param array $car_update 要修改的職業信息。格式：array('key1'=>'value1', 'key2'=>'value2', .....)。
	 * 支持設置的項：
	 *  - id			string	需要更新的職業信息ID。
	 *  - start			int		進入公司年份，最小為1900，最大為當年年份。
	 *  - end			int		離開公司年份，至今填0。
	 *  - department	string	工作部門。
	 *  - visible		int		可見範圍，0：自己可見、1：關注人可見、2：所有人可見。
	 *  - province		int		省份代碼ID，不可為空值。
	 *  - city			int		城市代碼ID，不可為空值。
	 *  - company		string	公司名稱，不可為空值。
	 * 參數province與city二者必選其一<br />
	 * 參數id為空，則為新建職業信息，參數company變為必填項，參數id非空，則為更新，參數company可選
	 * @return array
	 */
	function car_update( $car_update )
	{
		return $this->oauth->post( 'account/profile/car_update', $car_update);
	}

	/**
	 * 根據公司ID刪除用戶的職業信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/profile/car_destroy account/profile/car_destroy}
	 *
	 * @access public
	 * @param int $id  職業信息裡的公司ID
	 * @return array
	 */
	function car_destroy( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'account/profile/car_destroy', $params);
	}

	/**
	 * 更改頭像
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/avatar/upload account/avatar/upload}
	 *
	 * @param string $image_path 要上傳的頭像路徑, 支持url。[只支持png/jpg/gif三種格式, 增加格式請修改get_image_mime方法] 必須為小於700K的有效的GIF, JPG圖片. 如果圖片大於500像素將按比例縮放。
	 * @return array
	 */
	function update_profile_image( $image_path )
	{
		$params = array();
		$params['image'] = "@{$image_path}";

		return $this->oauth->post('account/avatar/upload', $params);
	}

	/**
	 * 設置隱私信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/account/update_privacy account/update_privacy}
	 *
	 * @param array $privacy_settings 要修改的隱私設置。格式：array('key1'=>'value1', 'key2'=>'value2', .....)。
	 * 支持設置的項：
	 *  - comment	int	是否可以評論我的微博，0：所有人、1：關注的人，默認為0。
	 *  - geo		int	是否開啟地理信息，0：不開啟、1：開啟，默認為1。
	 *  - message	int	是否可以給我發私信，0：所有人、1：關注的人，默認為0。
	 *  - realname	int	是否可以通過真名搜索到我，0：不可以、1：可以，默認為0。
	 *  - badge		int	勳章是否可見，0：不可見、1：可見，默認為1。
	 *  - mobile	int	是否可以通過手機號碼搜索到我，0：不可以、1：可以，默認為0。
	 * 以上參數全部選填
	 * @return array
	 */
	function update_privacy( $privacy_settings )
	{
		return $this->oauth->post( 'account/update_privacy', $privacy_settings);
	}


	/**
	 * 獲取當前用戶的收藏列表
	 *
	 * 返回用戶的發布的最近20條收藏信息，和用戶收藏頁面返回內容是一致的。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/favorites favorites}
	 *
	 * @access public
	 * @param  int $page 返回結果的頁碼，默認為1。
	 * @param  int $count 單頁返回的記錄條數，默認為50。
	 * @return array
	 */
	function get_favorites( $page = 1, $count = 50 )
	{
		$params = array();
		$params['page'] = intval($page);
		$params['count'] = intval($count);

		return $this->oauth->get( 'favorites', $params );
	}


	/**
	 * 根據收藏ID獲取指定的收藏信息
	 *
	 * 根據收藏ID獲取指定的收藏信息。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/favorites/show favorites/show}
	 *
	 * @access public
	 * @param int $id 需要查詢的收藏ID。
	 * @return array
	 */
	function favorites_show( $id )
	{
		$params = array();
		$this->id_format($id);
		$params['id'] = $id;
		return $this->oauth->get( 'favorites/show', $params );
	}


	/**
	 * 根據標簽獲取當前登錄用戶該標簽下的收藏列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/favorites/by_tags favorites/by_tags}
	 *
	 *
	 * @param int $tid  需要查詢的標簽ID。'
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @return array
	 */
	function favorites_by_tags( $tid, $page = 1, $count = 50)
	{
		$params = array();
		$params['tid'] = $tid;
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'favorites/by_tags', $params );
	}


	/**
	 * 獲取當前登錄用戶的收藏標簽列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/favorites/tags favorites/tags}
	 *
	 * @access public
	 * @param int $count 單頁返回的記錄條數，默認為50。
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @return array
	 */
	function favorites_tags( $page = 1, $count = 50)
	{
		$params = array();
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'favorites/tags', $params );
	}


	/**
	 * 收藏一條微博信息
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/favorites/create favorites/create}
	 *
	 * @access public
	 * @param int $sid 收藏的微博id
	 * @return array
	 */
	function add_to_favorites( $sid )
	{
		$this->id_format($sid);
		$params = array();
		$params['id'] = $sid;

		return $this->oauth->post( 'favorites/create', $params );
	}

	/**
	 * 刪除微博收藏。
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/favorites/destroy favorites/destroy}
	 *
	 * @access public
	 * @param int $id 要刪除的收藏微博信息ID.
	 * @return array
	 */
	function remove_from_favorites( $id )
	{
		$this->id_format($id);
		$params = array();
		$params['id'] = $id;
		return $this->oauth->post( 'favorites/destroy', $params);
	}


	/**
	 * 批量刪除微博收藏。
	 *
	 * 批量刪除當前登錄用戶的收藏。出現異常時，返回HTTP400錯誤。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/favorites/destroy_batch favorites/destroy_batch}
	 *
	 * @access public
	 * @param mixed $fids 欲刪除的一組私信ID，用半角逗號隔開，或者由一組評論ID組成的數組。最多20個。例如："231101027525486630,201100826122315375"或array(231101027525486630,201100826122315375);
	 * @return array
	 */
	function remove_from_favorites_batch( $fids )
	{
		$params = array();
		if (is_array($fids) && !empty($fids)) {
			foreach ($fids as $k => $v) {
				$this->id_format($fids[$k]);
			}
			$params['ids'] = join(',', $fids);
		} else {
			$params['ids'] = $fids;
		}

		return $this->oauth->post( 'favorites/destroy_batch', $params);
	}


	/**
	 * 更新一條收藏的收藏標簽
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/favorites/tags/update favorites/tags/update}
	 *
	 * @access public
	 * @param int $id 需要更新的收藏ID。
	 * @param string $tags 需要更新的標簽內容，用半角逗號分隔，最多不超過2條。
	 * @return array
	 */
	function favorites_tags_update( $id,  $tags )
	{
		$params = array();
		$params['id'] = $id;
		if (is_array($tags) && !empty($tags)) {
			foreach ($tags as $k => $v) {
				$this->id_format($tags[$k]);
			}
			$params['tags'] = join(',', $tags);
		} else {
			$params['tags'] = $tags;
		}
		return $this->oauth->post( 'favorites/tags/update', $params );
	}

	/**
	 * 更新當前登錄用戶所有收藏下的指定標簽
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/favorites/tags/update_batch favorites/tags/update_batch}
	 *
	 * @param int $tid  需要更新的標簽ID。必填
	 * @param string $tag  需要更新的標簽內容。必填
	 * @return array
	 */
	function favorites_update_batch( $tid, $tag )
	{
		$params = array();
		$params['tid'] = $tid;
		$params['tag'] = $tag;
		return $this->oauth->post( 'favorites/tags/update_batch', $params);
	}

	/**
	 * 刪除當前登錄用戶所有收藏下的指定標簽
	 *
	 * 刪除標簽後，該用戶所有收藏中，添加了該標簽的收藏均解除與該標簽的關聯關系
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/favorites/tags/destroy_batch favorites/tags/destroy_batch}
	 *
	 * @param int $tid  需要更新的標簽ID。必填
	 * @return array
	 */
	function favorites_tags_destroy_batch( $tid )
	{
		$params = array();
		$params['tid'] = $tid;
		return $this->oauth->post( 'favorites/tags/destroy_batch', $params);
	}

	/**
	 * 獲取某用戶的話題
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/trends trends}
	 *
	 * @param int $uid 查詢用戶的ID。默認為當前用戶。可選。
	 * @param int $page 指定返回結果的頁碼。可選。
	 * @param int $count 單頁大小。缺省值10。可選。
	 * @return array
	 */
	function get_trends( $uid = NULL, $page = 1, $count = 10 )
	{
		$params = array();
		if ($uid) {
			$params['uid'] = $uid;
		} else {
			$user_info = $this->get_uid();
			$params['uid'] = $user_info['uid'];
		}
		$this->id_format( $params['uid'] );
		$params['page'] = $page;
		$params['count'] = $count;
		return $this->oauth->get( 'trends', $params );
	}


	/**
	 * 判斷當前用戶是否關注某話題
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/trends/is_follow trends/is_follow}
	 *
	 * @access public
	 * @param string $trend_name 話題關鍵字。
	 * @return array
	 */
	function trends_is_follow( $trend_name )
	{
		$params = array();
		$params['trend_name'] = $trend_name;
		return $this->oauth->get( 'trends/is_follow', $params );
	}

	/**
	 * 返回最近一小時內的熱門話題
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/trends/hourly trends/hourly}
	 *
	 * @param  int $base_app 是否基於當前應用來獲取數據。1表示基於當前應用來獲取數據，默認為0。可選。
	 * @return array
	 */
	function hourly_trends( $base_app = 0 )
	{
		$params = array();
		$params['base_app'] = $base_app;

		return $this->oauth->get( 'trends/hourly', $params );
	}

	/**
	 * 返回最近一天內的熱門話題
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/trends/daily trends/daily}
	 *
	 * @param int $base_app 是否基於當前應用來獲取數據。1表示基於當前應用來獲取數據，默認為0。可選。
	 * @return array
	 */
	function daily_trends( $base_app = 0 )
	{
		$params = array();
		$params['base_app'] = $base_app;

		return $this->oauth->get( 'trends/daily', $params );
	}

	/**
	 * 返回最近一周內的熱門話題
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/trends/weekly trends/weekly}
	 *
	 * @access public
	 * @param int $base_app 是否基於當前應用來獲取數據。1表示基於當前應用來獲取數據，默認為0。可選。
	 * @return array
	 */
	function weekly_trends( $base_app = 0 )
	{
		$params = array();
		$params['base_app'] = $base_app;

		return $this->oauth->get( 'trends/weekly', $params );
	}

	/**
	 * 關注某話題
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/trends/follow trends/follow}
	 *
	 * @access public
	 * @param string $trend_name 要關注的話題關鍵詞。
	 * @return array
	 */
	function follow_trends( $trend_name )
	{
		$params = array();
		$params['trend_name'] = $trend_name;
		return $this->oauth->post( 'trends/follow', $params );
	}

	/**
	 * 取消對某話題的關注
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/trends/destroy trends/destroy}
	 *
	 * @access public
	 * @param int $tid 要取消關注的話題ID。
	 * @return array
	 */
	function unfollow_trends( $tid )
	{
		$this->id_format($tid);

		$params = array();
		$params['trend_id'] = $tid;

		return $this->oauth->post( 'trends/destroy', $params );
	}

	/**
	 * 返回指定用戶的標簽列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/tags tags}
	 *
	 * @param int $uid 查詢用戶的ID。默認為當前用戶。可選。
	 * @param int $page 指定返回結果的頁碼。可選。
	 * @param int $count 單頁大小。缺省值20，最大值200。可選。
	 * @return array
	 */
	function get_tags( $uid = NULL, $page = 1, $count = 20 )
	{
		$params = array();
		if ( $uid ) {
			$params['uid'] = $uid;
		} else {
			$user_info = $this->get_uid();
			$params['uid'] = $user_info['uid'];
		}
		$this->id_format( $params['uid'] );
		$params['page'] = $page;
		$params['count'] = $count;
		return $this->oauth->get( 'tags', $params );
	}

	/**
	 * 批量獲取用戶的標簽列表
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/tags/tags_batch tags/tags_batch}
	 *
	 * @param  string $uids 要獲取標簽的用戶ID。最大20，逗號分隔。必填
	 * @return array
	 */
	function get_tags_batch( $uids )
	{
		$params = array();
		if (is_array( $uids ) && !empty( $uids )) {
			foreach ($uids as $k => $v) {
				$this->id_format( $uids[$k] );
			}
			$params['uids'] = join(',', $uids);
		} else {
			$params['uids'] = $uids;
		}
		return $this->oauth->get( 'tags/tags_batch', $params );
	}

	/**
	 * 返回用戶感興趣的標簽
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/tags/suggestions tags/suggestions}
	 *
	 * @access public
	 * @param int $count 單頁大小。缺省值10，最大值10。可選。
	 * @return array
	 */
	function get_suggest_tags( $count = 10)
	{
		$params = array();
		$params['count'] = intval($count);
		return $this->oauth->get( 'tags/suggestions', $params );
	}

	/**
	 * 為當前登錄用戶添加新的用戶標簽
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/tags/create tags/create}
	 *
	 * @access public
	 * @param mixed $tags 要創建的一組標簽，每個標簽的長度不可超過7個漢字，14個半角字符。多個標簽之間用逗號間隔，或由多個標簽構成的數組。如："abc,drf,efgh,tt"或array("abc", "drf", "efgh", "tt")
	 * @return array
	 */
	function add_tags( $tags )
	{
		$params = array();
		if (is_array($tags) && !empty($tags)) {
			$params['tags'] = join(',', $tags);
		} else {
			$params['tags'] = $tags;
		}
		return $this->oauth->post( 'tags/create', $params);
	}

	/**
	 * 刪除標簽
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/tags/destroy tags/destroy}
	 *
	 * @access public
	 * @param int $tag_id 標簽ID，必填參數
	 * @return array
	 */
	function delete_tag( $tag_id )
	{
		$params = array();
		$params['tag_id'] = $tag_id;
		return $this->oauth->post( 'tags/destroy', $params );
	}

	/**
	 * 批量刪除標簽
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/tags/destroy_batch tags/destroy_batch}
	 *
	 * @access public
	 * @param mixed $ids 必選參數，要刪除的tag id，多個id用半角逗號分割，最多10個。或由多個tag id構成的數組。如：“553,554,555"或array(553, 554, 555)
	 * @return array
	 */
	function delete_tags( $ids )
	{
		$params = array();
		if (is_array($ids) && !empty($ids)) {
			$params['ids'] = join(',', $ids);
		} else {
			$params['ids'] = $ids;
		}
		return $this->oauth->post( 'tags/destroy_batch', $params );
	}


	/**
	 * 驗證暱稱是否可用，並給予建議暱稱
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/register/verify_nickname register/verify_nickname}
	 *
	 * @param string $nickname 需要驗證的暱稱。4-20個字符，支持中英文、數字、"_"或減號。必填
	 * @return array
	 */
	function verify_nickname( $nickname )
	{
		$params = array();
		$params['nickname'] = $nickname;
		return $this->oauth->get( 'register/verify_nickname', $params );
	}



	/**
	 * 搜索用戶時的聯想搜索建議
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/search/suggestions/users search/suggestions/users}
	 *
	 * @param string $q 搜索的關鍵字，必須做URLencoding。必填,中間最好不要出現空格
	 * @param int $count 返回的記錄條數，默認為10。
	 * @return array
	 */
	function search_users( $q,  $count = 10 )
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		return $this->oauth->get( 'search/suggestions/users',  $params );
	}


	/**
	 * 搜索微博時的聯想搜索建議
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/search/suggestions/statuses search/suggestions/statuses}
	 *
	 * @param string $q 搜索的關鍵字，必須做URLencoding。必填
	 * @param int $count 返回的記錄條數，默認為10。
	 * @return array
	 */
	function search_statuses( $q,  $count = 10)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		return $this->oauth->get( 'search/suggestions/statuses', $params );
	}


	/**
	 * 搜索學校時的聯想搜索建議
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/search/suggestions/schools search/suggestions/schools}
	 *
	 * @param string $q 搜索的關鍵字，必須做URLencoding。必填
	 * @param int $count 返回的記錄條數，默認為10。
	 * @param int type 學校類型，0：全部、1：大學、2：高中、3：中專技校、4：初中、5：小學，默認為0。選填
	 * @return array
	 */
	function search_schools( $q,  $count = 10,  $type = 1)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		$params['type'] = $type;
		return $this->oauth->get( 'search/suggestions/schools', $params );
	}

	/**
	 * 搜索公司時的聯想搜索建議
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/search/suggestions/companies search/suggestions/companies}
	 *
	 * @param string $q 搜索的關鍵字，必須做URLencoding。必填
	 * @param int $count 返回的記錄條數，默認為10。
	 * @return array
	 */
	function search_companies( $q, $count = 10)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		return $this->oauth->get( 'search/suggestions/companies', $params );
	}


	/**
	 * ＠用戶時的聯想建議
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/search/suggestions/at_users search/suggestions/at_users}
	 *
	 * @param string $q 搜索的關鍵字，必須做URLencoding。必填
	 * @param int $count 返回的記錄條數，默認為10。
	 * @param int $type 聯想類型，0：關注、1：粉絲。必填
	 * @param int $range 聯想範圍，0：只聯想關注人、1：只聯想關注人的備注、2：全部，默認為2。選填
	 * @return array
	 */
	function search_at_users( $q, $count = 10, $type=0, $range = 2)
	{
		$params = array();
		$params['q'] = $q;
		$params['count'] = $count;
		$params['type'] = $type;
		$params['range'] = $range;
		return $this->oauth->get( 'search/suggestions/at_users', $params );
	}





	/**
	 * 搜索與指定的一個或多個條件相匹配的微博
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/search/statuses search/statuses}
	 *
	 * @param array $query 搜索選項。格式：array('key0'=>'value0', 'key1'=>'value1', ....)。支持的key:
	 *  - q				string	搜索的關鍵字，必須進行URLencode。
	 *  - filter_ori	int		過濾器，是否為原創，0：全部、1：原創、2：轉發，默認為0。
	 *  - filter_pic	int		過濾器。是否包含圖片，0：全部、1：包含、2：不包含，默認為0。
	 *  - fuid			int		搜索的微博作者的用戶UID。
	 *  - province		int		搜索的省份範圍，省份ID。
	 *  - city			int		搜索的城市範圍，城市ID。
	 *  - starttime		int		開始時間，Unix時間戳。
	 *  - endtime		int		結束時間，Unix時間戳。
	 *  - count			int		單頁返回的記錄條數，默認為10。
	 *  - page			int		返回結果的頁碼，默認為1。
	 *  - needcount		boolean	返回結果中是否包含返回記錄數，true：返回、false：不返回，默認為false。
	 *  - base_app		int		是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * needcount參數不同，會導致相應的返回值結構不同
	 * 以上參數全部選填
	 * @return array
	 */
	function search_statuses_high( $query )
	{
		return $this->oauth->get( 'search/statuses', $query );
	}



	/**
	 * 通過關鍵詞搜索用戶
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/search/users search/users}
	 *
	 * @param array $query 搜索選項。格式：array('key0'=>'value0', 'key1'=>'value1', ....)。支持的key:
	 *  - q			string	搜索的關鍵字，必須進行URLencode。
	 *  - snick		int		搜索範圍是否包含暱稱，0：不包含、1：包含。
	 *  - sdomain	int		搜索範圍是否包含個性域名，0：不包含、1：包含。
	 *  - sintro	int		搜索範圍是否包含簡介，0：不包含、1：包含。
	 *  - stag		int		搜索範圍是否包含標簽，0：不包含、1：包含。
	 *  - province	int		搜索的省份範圍，省份ID。
	 *  - city		int		搜索的城市範圍，城市ID。
	 *  - gender	string	搜索的性別範圍，m：男、f：女。
	 *  - comorsch	string	搜索的公司學校名稱。
	 *  - sort		int		排序方式，1：按更新時間、2：按粉絲數，默認為1。
	 *  - count		int		單頁返回的記錄條數，默認為10。
	 *  - page		int		返回結果的頁碼，默認為1。
	 *  - base_app	int		是否只獲取當前應用的數據。0為否（所有數據），1為是（僅當前應用），默認為0。
	 * 以上所有參數全部選填
	 * @return array
	 */
	function search_users_keywords( $query )
	{
		return $this->oauth->get( 'search/users', $query );
	}



	/**
	 * 獲取系統推薦用戶
	 *
	 * 返回系統推薦的用戶列表。
	 * <br />對應API：{@link http://open.weibo.com/wiki/2/suggestions/users/hot suggestions/users/hot}
	 *
	 * @access public
	 * @param string $category 分類，可選參數，返回某一類別的推薦用戶，默認為 default。如果不在以下分類中，返回空列表：<br />
	 *  - default:人氣關注
	 *  - ent:影視名星
	 *  - hk_famous:港台名人
	 *  - model:模特
	 *  - cooking:美食&健康
	 *  - sport:體育名人
	 *  - finance:商界名人
	 *  - tech:IT互聯網
	 *  - singer:歌手
	 *  - writer：作家
	 *  - moderator:主持人
	 *  - medium:媒體總編
	 *  - stockplayer:炒股高手
	 * @return array
	 */
	function hot_users( $category = "default" )
	{
		$params = array();
		$params['category'] = $category;

		return $this->oauth->get( 'suggestions/users/hot', $params );
	}

	/**
	 * 獲取用戶可能感興趣的人
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/suggestions/users/may_interested suggestions/users/may_interested}
	 *
	 * @access public
	 * @param int $page 返回結果的頁碼，默認為1。
	 * @param int $count 單頁返回的記錄條數，默認為10。
	 * @return array
	 * @ignore
	 */
	function suggestions_may_interested( $page = 1, $count = 10 )
	{
		$params = array();
		$params['page'] = $page;
		$params['count'] = $count;
		return $this->oauth->get( 'suggestions/users/may_interested', $params);
	}

	/**
	 * 根據一段微博正文推薦相關微博用戶。
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/suggestions/users/by_status suggestions/users/by_status}
	 *
	 * @access public
	 * @param string $content 微博正文內容。
	 * @param int $num 返回結果數目，默認為10。
	 * @return array
	 */
	function suggestions_users_by_status( $content, $num = 10 )
	{
		$params = array();
		$params['content'] = $content;
		$params['num'] = $num;
		return $this->oauth->get( 'suggestions/users/by_status', $params);
	}

	/**
	 * 熱門收藏
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/suggestions/favorites/hot suggestions/favorites/hot}
	 *
	 * @param int $count 每頁返回結果數，默認20。選填
	 * @param int $page 返回頁碼，默認1。選填
	 * @return array
	 */
	function hot_favorites( $page = 1, $count = 20 )
	{
		$params = array();
		$params['count'] = $count;
		$params['page'] = $page;
		return $this->oauth->get( 'suggestions/favorites/hot', $params);
	}

	/**
	 * 把某人標識為不感興趣的人
	 *
	 * 對應API：{@link http://open.weibo.com/wiki/2/suggestions/users/not_interested suggestions/users/not_interested}
	 *
	 * @param int $uid 不感興趣的用戶的UID。
	 * @return array
	 */
	function put_users_not_interested( $uid )
	{
		$params = array();
		$params['uid'] = $uid;
		return $this->oauth->post( 'suggestions/users/not_interested', $params);
	}



	// =========================================

	/**
	 * @ignore
	 */
	protected function request_with_pager( $url, $page = false, $count = false, $params = array() )
	{
		if( $page ) $params['page'] = $page;
		if( $count ) $params['count'] = $count;

		return $this->oauth->get($url, $params );
	}

	/**
	 * @ignore
	 */
	protected function request_with_uid( $url, $uid_or_name, $page = false, $count = false, $cursor = false, $post = false, $params = array())
	{
		if( $page ) $params['page'] = $page;
		if( $count ) $params['count'] = $count;
		if( $cursor )$params['cursor'] =  $cursor;

		if( $post ) $method = 'post';
		else $method = 'get';

		if ( $uid_or_name !== NULL ) {
			$this->id_format($uid_or_name);
			$params['id'] = $uid_or_name;
		}

		return $this->oauth->$method($url, $params );

	}

	/**
	 * @ignore
	 */
	protected function id_format(&$id) {
		if ( is_float($id) ) {
			$id = number_format($id, 0, '', '');
		} elseif ( is_string($id) ) {
			$id = trim($id);
		}
	}

}
