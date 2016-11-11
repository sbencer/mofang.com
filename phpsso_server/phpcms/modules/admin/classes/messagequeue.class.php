<?php

class messagequeue {
	
	private $db;
	
	private static function get_db() {
		return pc_base::load_model('messagequeue_model');
	}
	
	/**
	 * 添加隊列信息
	 */
	public static function add($operation, $noticedata_send) {
		$db = self::get_db();
		$noticedata_send['action'] = $operation;
		$noticedata_send_string = array2string($noticedata_send);
		
		if ($noticeid = $db->insert(array('operation'=>$operation, 'noticedata'=>$noticedata_send_string, 'dateline'=>SYS_TIME), 1)) {
			self::notice($operation, $noticedata_send, $noticeid);
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * 通知應用
	 */
	public static function notice($operation, $noticedata, $noticeid) {
		$db = self::get_db();
		$applist = getcache('applist', 'admin');
		foreach($applist as $k=>$v) {
			//由於編碼轉換會改變notice_send的值，所以每次循環需要重新賦值noticedate_send
			$noticedata_send = $noticedata;
			
			//應用添加用戶時不重復通知該應用
			if(isset($noticedata_send['appname']) && $noticedata_send['appname'] == $v['name']) {
				$appstatus[$k] = 1;
				continue;
			}
			
			$url = $v['url'].$v['apifilename'];

			if (CHARSET != $v['charset'] && isset($noticedata_send['action']) && $noticedata_send['action'] == 'member_add') {
				if(isset($noticedata_send['username']) && !empty($noticedata_send['username'])) {
					if(CHARSET == 'utf-8') {	//判斷phpsso字符集是否為utf-8編碼
						//應用字符集如果是utf-8，並且用戶名是utf-8編碼，轉換用戶名為phpsso字符集，如果為英文，is_utf8返回false，不進行轉換
						if(!is_utf8($noticedata_send['username'])) {
							$noticedata_send['username'] = iconv(CHARSET, $v['charset'], $noticedata_send['username']);
						}
					} else {
						if(!is_utf8($noticedata_send['username'])) {
							$noticedata_send['username'] = iconv(CHARSET, $v['charset'], $noticedata_send['username']);
						}
					}
				}
			}
			$tmp_s = strstr($url, '?') ? '&' : '?';
			$status = ps_send($url.$tmp_s.'appid='.$k, $noticedata_send, $v['authkey']);
			if ($status == 1) {
				$appstatus[$k] = 1;
			} else {
				$appstatus[$k] = 0;
			}
		}

		$db->update(array('totalnum'=>'+=1', 'appstatus'=>json_encode($appstatus)), array('id'=>$noticeid));
	}
}
?>