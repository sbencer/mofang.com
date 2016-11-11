<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
pc_base::load_app_func('global','pay');
class receipts {
	
	//數據庫連接
	protected static $db;
	
	/**
	 * 數據庫連接
	 */
	protected  static function connect() {
		self::$db = pc_base::load_model("pay_account_model");
	}
	
	
	/**
	 * 添加金錢入賬記錄
	 * 添加金錢入賬記錄操作放放
	 * @param integer $value 入賬金額
	 * @param integer $userid 用戶ID
	 * @param string $username 用戶名
	 * @param integer $trand_sn 操作訂單ID,默認為自動生成
	 * @param string $pay_type 入賬類型 （可選值  offline 線下充值，recharge 在線充值，selfincome 自助獲取）
	 * @param string $payment 入賬方式  （如後台充值，支付寶，銀行匯款/轉賬等此處為自定義）
	 * @param string $status 入賬狀態  （可選值  succ 默認，入賬成功，error 入賬失敗）注當且僅當為‘succ’時更改member數據
	 * @param string  $op_username 管理員信息
	 */
	public static function amount($value, $userid = '' , $username = '', $trade_sn = '', $pay_type = '', $payment = '', $op_username = '', $status = 'succ', $note = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid,'money'=>$value, 'trade_sn'=>$trade_sn, 'pay_type'=>$pay_type, 'payment'=>$payment, 'status'=>$status, 'type'=>1, 'adminnote'=>$op_username, 'usernote'=>$note));
	}
	
	/**
	 * 添加點數入賬記錄
	 * 添加點數入賬記錄操作放放
	 * @param integer $value 入賬金額
	 * @param integer $userid 用戶ID
	 * @param string $username 用戶名
	 * @param integer $trade_sn 操作訂單ID,默認為自動生成
	 * @param string $pay_type 入賬類型 （可選值  offline 線下充值，recharge 在線充值，selfincome 自助獲取）
	 * @param string $payment 入賬方式  （如後台充值，支付寶，銀行匯款/轉賬等此處為自定義）
	 * @param string $status 入賬狀態  （可選值  succ 默認，入賬成功，failed 入賬失敗）
	 * @param string  $op_username 管理員信息
	 */
	public static function point($value, $userid = '' , $username = '', $trade_sn = '', $pay_type = '', $payment = '', $op_username = '', $status = 'succ', $note = '') {
		return self::_add(array('username'=>$username, 'userid'=>$userid,'money'=>$value, 'trade_sn'=>$trade_sn, 'pay_type'=>$pay_type, 'payment'=>$payment, 'status'=>$status, 'type'=>2, 'adminnote'=>$op_username, 'usernote'=>$note));
	}
	
	/**
	 * 添加入賬記錄
	 * @param array $data 添加入賬記錄參數
	 */
	private static function _add($data) {
		$data['money'] = isset($data['money']) && floatval($data['money']) ? floatval($data['money']) : 0;
		$data['userid'] = isset($data['userid']) && intval($data['userid']) ? intval($data['userid']) : 0;
		$data['username'] = isset($data['username']) ? trim($data['username']) : '';
		$data['trade_sn'] = (isset($data['trade_sn']) && $data['trade_sn']) ? trim($data['trade_sn']) : create_sn();
		$data['pay_type'] = isset($data['pay_type']) ? trim($data['pay_type']) : 'selfincome';
		$data['payment'] = isset($data['payment']) ? trim($data['payment']) : '';
		$data['adminnote'] = isset($data['op_username']) ? trim($data['op_username']) : '';
		$data['usernote'] = isset($data['usernote']) ? trim($data['usernote']) : '';
		$data['status'] = isset($data['status']) ? trim($data['status']) : 'succ';
		$data['type'] = isset($data['type']) && intval($data['type']) ? intval($data['type']) : 0;
		$data['addtime'] = SYS_TIME;
		$data['ip'] = ip();
		
		//檢察消費類型
		if (!in_array($data['type'], array(1,2))) {
			return false;
		}
		
		//檢查入賬類型
		if (!in_array($data['pay_type'], array('offline','recharge','selfincome'))) {
			return false;
		}
		//檢查入賬狀態
		if (!in_array($data['status'], array('succ','error','failed'))) {
			return false;
		}	
				
		//檢查消費描述
		if (empty($data['payment'])) {
			return false;
		}
		
		//檢查消費金額
		if (empty($data['money'])) {
			return false;
		}
	
		//檢查userid和username並償試再次的獲取
		if (empty($data['userid']) || empty($data['username'])) {
			if (defined('IN_ADMIN')) {
				return false;
			} elseif (!$data['userid'] = param::get_cookie('_userid') || !$data['username'] = param::get_cookie('_username')) {
				return false;
			} else {
				return false;
			}
		}
	
		//檢查op_userid和op_username並償試再次的獲取
		if (defined('IN_ADMIN') && empty($data['adminnote'])) {
			$data['adminnote'] = param::get_cookie('admin_username');
		}

		//數據庫連接
		if (empty(self::$db)) {
			self::connect();
		}
		$member_db = pc_base::load_model('member_model');
				
		$sql = array();
		if ($data['type'] == 1) {//金錢方式充值
			$sql = array('amount'=>"+=".$data['money']);
		} elseif ($data['type'] == 2) { //積分方式充值
			$sql = array('point'=>'+='.$data['money']);
		} else {
			return false;
		}
				
		//進入數據庫操作
		$insertid = self::$db->insert($data,true);
		if($insertid && $data['status'] == 'succ') {
			return $member_db->update($sql, array('userid'=>$data['userid'], 'username'=>$data['username'])) ? true : false;
		} else {
			return false;
		}
	}
}