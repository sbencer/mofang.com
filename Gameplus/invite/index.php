<?php
	$deviceType = _getDeviceType();		
	try {
		$code = $_GET['code'];
		if (preg_match('/^[a-zA-Z0-9]{6}$/', $code)) {
			$code = strtoupper($code);
			if ($deviceType == 'other'){
				include('./view/pc.php');
			} else {
				include('./view/mobile.php');
			}	
			die;					
		} else {
				throw new Exception('验证码不正确');
		}                        
    } catch (Exception $e) {
        exit($e->getMessage());
    }

    /**
     * 判断设备
     * @return string
     */
    function _getDeviceType() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if ( (stripos($userAgent, "iphone") !== false) || (stripos($userAgent, "ipad") !== false) || (stripos($userAgent, "ipod") !== false) ) {
            return 'ios';
        } else if (stripos($userAgent, "android") !== false) {
            return 'android';
        } else {
            return 'other';
        }
    }

 ?>