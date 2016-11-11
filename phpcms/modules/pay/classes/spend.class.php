<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 消費記錄類使用說明
 * @author chenzhouyu
 * 
 * 直接使用pc_base::load_app_class('spend', 'pay', 0);
 * 進行加載。
 * 使用spend::amonut()進行金錢的消費
 * spend::point()進行積分消費
 * 當函數返回的結果為false是，可使用spend::get_msg()獲取錯誤原因
 * 
 */
class spend {
	
	//數據庫連接
	protected static $db;
	
	//錯誤代碼
	public static $msg;
	
	/**
	 * 數據庫連接
	 */
	protected  static function connect() {
		self::$db = pc_base::load_model("pay_spend_model");
	}
	
	/**
	 * 按用戶名、時間、標識查詢是否有消費記錄
	 * @param integer $userid      用戶名
	 * @param integer $time        時間。  從指定時間到現在的時間範圍內。
	 * @param string $logo   標識
	 */
	public static function spend_time($userid, $time, $logo) {
		if (empty(self::$db)) {
			self::connect();
		}
		return self::$db->get_one("`userid` = '$userid' AND `creat_at` BETWEEN '$time' AND '".SYS_TIME."' AND `logo` = '$logo'");
	}
	
	/**
	 * 添加金錢消費記錄
	 * @param integer $value          消費金額
	 * @param string $msg             消費信息
	 * @param integer $userid         用戶ID
	 * @param string $username        用戶名
	 * @param integer $op_userid      操作人
	 * @param string $op_username     操作人用戶名
	 * @param string $logo            特殊標識，如文章消費時，可以對文章進行標識，以滿足在一段時間內，都可以再次的使用
	 */
	public static function amount($value, $msg, $userid = '', $username = '', $op_userid = '', $op_username = '', $logo = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid, 'type'=>1, 'value'=>$value, 'op_userid'=>$op_userid, 'op_username'=>$op_username, 'msg'=>$msg,'logo'=>$logo));
	}
	
	/**
	 * 添加積分消費記錄
	 * @param integer $value          消費金額
	 * @param string $msg             消費信息
	 * @param integer $userid         用戶ID
	 * @param string $username        用戶名
	 * @param integer $op_userid      操作人
	 * @param string $op_username     操作人用戶名
	 * @param string $logo            特殊標識，如文章消費時，可以對文章進行標識，以滿足在一段時間內，都可以再次的使用
	 */
	public static function point($value, $msg, $userid = '', $username = '', $op_userid = '', $op_username = '', $logo = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid, 'type'=>2, 'value'=>$value, 'op_userid'=>$op_userid, 'op_username'=>$op_username, 'msg'=>$msg,'logo'=>$logo));
	}
	
	/**
	 * 添加消費記錄
	 * @param array $data 添加消費記錄參數
	 */
	private static function _add($data) {
		$data['userid'] = isset($data['userid']) && intval($data['userid']) ? intval($data['userid']) : 0;
		$data['username'] = isset($data['username']) ? trim($data['username']) : '';
		$data['op_userid'] = isset($data['op_userid']) && intval($data['op_userid']) ? intval($data['op_userid']) : 0;
		$data['op_username'] = isset($data['op_username']) ? trim($data['op_username']) : '';
		$data['type'] = isset($data['type']) && intval($data['type']) ? intval($data['type']) : 0;
		$data['value'] = isset($data['value']) && intval($data['value']) ? abs(intval($data['value'])) : 0;
		$data['msg'] = isset($data['msg']) ? trim($data['msg']) : '';
		$data['logo'] = isset($data['logo']) ? trim($data['logo']) : '';
		$data['creat_at'] = SYS_TIME;
		
		//檢察消費類型
		if (!in_array($data['type'], array(1,2))) {
			return false;
		}
		
		//檢察消費描述
		if (empty($data['msg'])) {
			self::$msg = 1;
			return false;
		}
		
		//檢察消費金額
		if (empty($data['value'])) {
			self::$msg = 2;
			return false;
		}
		
		//檢察userid和username並償試再次的獲取
		if (empty($data['userid']) || empty($data['username'])) {
			if (defined('IN_ADMIN')) {
				self::$msg = 3;
				return false;
			} elseif (!$data['userid'] = param::get_cookie('_userid') || !$data['username'] = param::get_cookie('_username')) {
				self::$msg = 3;
				return false;
			} else {
				self::$msg = 3;
				return false;
			}
		}
		
		//檢察op_userid和op_username並償試再次的獲取
		if (defined('IN_ADMIN') && (empty($data['op_userid']) || empty($data['op_username']))) {
			$data['op_username'] = param::get_cookie('admin_username');
			$data['op_userid'] = param::get_cookie('userid');
		}
		
		//數據庫連接
		if (empty(self::$db)) {
			self::connect();
		}
		$member_db = pc_base::load_model('member_model');
		
		//判斷用戶的金錢或積分是否足夠。
		if (!self::_check_user($data['userid'], $data['type'], $data['value'], $member_db)) {
			self::$msg = 6;
			return false;
		} 
				
		$sql = array();
		if ($data['type'] == 1) {//金錢方式消費
			$sql = array('amount'=>"-=".$data['value']);
		} elseif ($data['type'] == 2) { //積分方式消費
			$sql = array('point'=>'-='.$data['value']);
		} else {
			self::$msg = 7;
			return false;
		}
		
		//進入數據庫操作
		if ($member_db->update($sql, array('userid'=>$data['userid'], 'username'=>$data['username'])) && self::$db->insert($data)) {
			self::$msg = 0;
			return true;
		} else {
			self::$msg = 8;
			return false;
		}
	}
	
/**
 * 判斷用戶的金錢、積分是否足夠
 * @param integer $userid    用戶ID
 * @param integer $type      判斷（1：金錢，2：積分）
 * @param integer $value     數量
 * @param $db                數據庫連接
 */
	private static function _check_user($userid, $type, $value, &$db) {
		if ($user = $db->get_one(array('userid'=>$userid), '`amount`, `point`')) {
			if ($type == 1) { //金錢消費
				if ($user['amount'] < $value) {
					return false;
				} else {
					return true;
				}
			} elseif ($type == 2) { //積分
				if ($user['point'] < $value) {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * 
	 * 獲取詳細的報錯信息
	 */
	public static function get_msg() {
		$msg = self::$msg;
		$arr = array(
			'1' => L('spend_msg_1', '', 'pay'),
			'2' => L('spend_msg_2', '', 'pay'),
			'3' => L('spend_msg_3', '', 'pay'),
			'6' => L('spend_msg_6', '', 'pay'),
			'7' => L('spend_msg_7', '', 'pay'),
			'8' => L('spend_msg_8', '', 'pay'),
		);
		return isset($arr[$msg]) ? $arr[$msg] : false;
	}
}