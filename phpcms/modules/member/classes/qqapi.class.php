<?php

class qqapi{

	private $appid,$appkey,$callback;
	
	public function __construct($appid, $appkey, $callback){
		$this->appid = $appid;
		$this->appkey = $appkey;
		$this->callback = $callback;
	}
	
	//重定向登錄
	public function redirect_to_login()
	{
		//獲取auth code url
		$redirect = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=".$this->appid."&redirect_uri=".urlencode($this->callback)."&state=test";
		header("Location:$redirect");
	}
	
	//獲取access token
	public function get_access_token(){

		$auth_code = $_GET['code'];

		$redirect = 'https://graph.qq.com/oauth2.0/token';
		$redirect .= "?grant_type=authorization_code&client_id=".$this->appid."&client_secret=".$this->appkey."&code=".$auth_code."&redirect_uri=".urlencode($this->callback);
		
		$token_info = file_get_contents( $redirect  );
		$token_info_array = explode('&', $token_info );
		$info_array = array();
		foreach( $token_info_array as $key=>$value  ){
			$temp = explode('=', $value);
			$info_array[$temp[0]] = $temp[1];
		}
		return  $info_array;
	}

	//獲取用戶登錄 openid
	public function get_openid(){
		$token_info = $this->get_access_token();
		$url = 'https://graph.qq.com/oauth2.0/me?access_token='.$token_info['access_token'];
		$openid_info = file_get_contents( $url );
		
		$start = strpos( $openid_info, '{'  );
		$end = strpos( $openid_info, '}'  );
		$len = ($end+1) - $start;
		$str = substr( $openid_info, $start, $len  );
		$str = json_decode( $str, true );	

		$this->access_token = $token_info['access_token'];
		$this->openid = $str['openid'];
	
		return $str;
	}	

	 /*
	 * 獲取用戶信息
	 */
	public function get_user_info(){
		$url = "https://graph.qq.com/user/get_user_info";
		$url .= "?oauth_consumer_key=".$this->appid."&access_token=".$this->access_token."&openid=".$this->openid;

		$content = file_get_contents( $url );
		$arr = json_decode($content, true);

		return $arr;
	}
}
?>
