<?php
define('IN_ADMIN', true);
class admin {
	//數據庫連接
	private $db;
	//錯誤代碼
	private $err_code;
	
	/**
	 * 構造函數
	 * @param integer $issuper 是否為超級管理員
	 */
	public function __construct($issuper = 0) {
		$this->db = pc_base::load_model('admin_model');	
		$this->check_admin($issuper);
		pc_base::load_app_func('global');
	}
	
	/**
	 * 管理員權限判斷
	 * @param integer $issuper 是否為超級管理員
	 */
	public function check_admin($issuper = 0) {
		if (ROUTE_C != 'login') {
			if (!$this->get_userid() || !$this->get_username()) {
				$forward = isset($_GET['forward']) ? urlencode($_GET['forward']) : '';
				showmessage(L('relogin'),'?m=admin&c=login&a=init&forward='.$forward);
				unset($forward);
			}
			if ($issuper) {
				$r = $this->get_userinfo();
				if ($r['issuper'] != 1) {
					showmessage(L('eaccess'));
				}
			}
		}
	}
	
	/**
	 * 管理員登陸
	 * @param string $username 用戶名
	 * @param string $password 密碼
	 * @return boolean
	 */
	public function login($username, $password) {
		if (!$this->db) {
			$this->db = pc_base::load_model('admin_model');			
		}
		if ($data = $this->db->get_one(array('username'=>$username))) {
			$password = md5(md5($password).$data['encrypt']);
			if ($password != $data['password']) {
				$this->err_code = 2;
				return false;
			} elseif ($password == $data['password']) {
				$this->db->update(array('ip'=>ip(), 'lastlogin'=>SYS_TIME),array('id'=>$data['id']));
				param::set_cookie('username', $username);
				param::set_cookie('userid', $data['id']);
				return true;
			}
			$this->err_code = 0;
			return false;
		} else {
			$this->err_code = 1;
			return false;
		}
	}
	
	public function log_out() {
		param::set_cookie('username', '');
		param::set_cookie('userid', '');
	}
	
	/**
	 * 獲取當前用戶ID號
	 */
	public function get_userid() {
		return param::get_cookie('userid');
	}
	
	/**
	 * 獲取當前用戶名
	 */
	public function get_username() {
		return param::get_cookie('username');
	}
	
	/**
	 * 獲取當前用戶信息
	 * @param string $filed 獲取指定字段
	 * @param string $enforce 強制更新
	 */
	public function get_userinfo($filed = '', $enforce = 0) {
		static $data;
		if ($data && !$enforce) {
			if($filed && isset($data[$filed])) {
				return $data[$filed];
			} elseif ($filed && !isset($data[$filed])) {
				return false;
			} else {
				return $data;
			}
		}
		$data = $this->db->get_one(array('username'=>$this->get_username(),'id'=>$this->get_userid()));
		if($filed && isset($data[$filed])) {
			return $data[$filed];
		} elseif ($filed && !isset($data[$filed])) {
			return false;
		} else {
			return $data;
		}
	}
	
	/**
	 * 獲取錯誤原因
	 */
	public function get_err() {
		$msg = array(
		'-1'=>L('database_error'),
		'0'=>L('unknown_error'),
		'1'=>L('User_name_could_not_find'),
		'2'=>L('incorrect_password'),
		);
		return $msg[$this->err_code];
	}

	/**
	 * 加載後台模板
	 * @param string $file 文件名
	 * @param string $m 模型名
	 */
	public static function admin_tpl($file, $m = '') {
		$m = empty($m) ? ROUTE_M : $m;
		if(empty($m)) return false;
		return PC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
	}
}