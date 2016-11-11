<?php
/**
 * 會員前台管理中心、賬號管理、收藏操作類
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('foreground');
pc_base::load_sys_class('format', '', 0);
pc_base::load_sys_class('form', '', 0);

class index extends foreground {

	private $times_db;

	function __construct() {
		parent::__construct();
		$this->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
	}

	public function init() {
		$memberinfo = $this->memberinfo;
		//初始化phpsso
		$phpsso_api_url = $this->_init_phpsso();
		//獲取頭像數組
		$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);

		$grouplist = getcache('grouplist');
		$memberinfo['groupname'] = $grouplist[$memberinfo[groupid]]['name'];
		include template('member', 'index');
	}

	public function register() {
		$this->_session_start();
		//獲取用戶siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定義站點id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}

		//加載用戶模塊配置
		$member_setting = getcache('member_setting');
		if(!$member_setting['allowregister']) {
			showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
		}
		//加載短信模塊配置
 		$sms_setting_arr = getcache('sms','sms');
		$sms_setting = $sms_setting_arr[$siteid];		
		
		header("Cache-control: private");
		if(isset($_POST['dosubmit'])) {
			if($member_setting['enablcodecheck']=='1'){//開啟驗證碼
				if ((empty($_SESSION['connectid']) && $_SESSION['code'] != strtolower($_POST['code'])) || empty($_SESSION['code'])) {
					showmessage(L('code_error'));
				} else {
					$_SESSION['code'] = '';
				}
			}
			
			$userinfo = array();
			$userinfo['encrypt'] = create_randomstr(6);

			$userinfo['username'] = (isset($_POST['username']) && is_username($_POST['username'])) ? $_POST['username'] : exit('0');
			$userinfo['nickname'] = (isset($_POST['nickname']) && is_username($_POST['nickname'])) ? $_POST['nickname'] : '';
			
			$userinfo['email'] = (isset($_POST['email']) && is_email($_POST['email'])) ? $_POST['email'] : exit('0');
			$userinfo['password'] = isset($_POST['password']) ? $_POST['password'] : exit('0');
			
			$userinfo['email'] = (isset($_POST['email']) && is_email($_POST['email'])) ? $_POST['email'] : exit('0');

			$userinfo['modelid'] = isset($_POST['modelid']) ? intval($_POST['modelid']) : 10;
			$userinfo['regip'] = ip();
			$userinfo['point'] = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
			$userinfo['amount'] = $member_setting['defualtamount'] ? $member_setting['defualtamount'] : 0;
			$userinfo['regdate'] = $userinfo['lastdate'] = SYS_TIME;
			$userinfo['siteid'] = $siteid;
			$userinfo['connectid'] = isset($_SESSION['connectid']) ? $_SESSION['connectid'] : '';
			$userinfo['from'] = isset($_SESSION['from']) ? $_SESSION['from'] : '';
			//手機強制驗證

			if($member_setting[mobile_checktype]=='1'){
				//取用戶手機號
				$mobile_verify = $_POST['mobile_verify'] ? intval($_POST['mobile_verify']) : '';
				if($mobile_verify=='') showmessage('請提供正確的手機驗證碼！', HTTP_REFERER);
 				$sms_report_db = pc_base::load_model('sms_report_model');
				$posttime = SYS_TIME-360;
				$where = "`id_code`='$mobile_verify' AND `posttime`>'$posttime'";
				$r = $sms_report_db->get_one($where,'*','id DESC');
 				if(!empty($r)){
					$userinfo['mobile'] = $r['mobile'];
				}else{
					showmessage('未檢測到正確的手機號碼！', HTTP_REFERER);
				}
 			}elseif($member_setting[mobile_checktype]=='2'){
				//獲取驗證碼，直接通過POST，取mobile值
				$userinfo['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : '';
			} 
			if($userinfo['mobile']!=""){
				if(!preg_match('/^1([0-9]{9})/',$userinfo['mobile'])) {
					showmessage('請提供正確的手機號碼！', HTTP_REFERER);
				}
			} 
 			unset($_SESSION['connectid'], $_SESSION['from']);
			
			if($member_setting['enablemailcheck']) {	//是否需要郵件驗證
				$userinfo['groupid'] = 7;
			} elseif($member_setting['registerverify']) {	//是否需要管理員審核
				$modelinfo_str = $userinfo['modelinfo'] = isset($_POST['info']) ? array2string(array_map("safe_replace", new_html_special_chars($_POST['info']))) : '';
				$this->verify_db = pc_base::load_model('member_verify_model');
				unset($userinfo['lastdate'],$userinfo['connectid'],$userinfo['from']);
				$userinfo['modelinfo'] = $modelinfo_str;
				$this->verify_db->insert($userinfo);
				showmessage(L('operation_success'), 'index.php?m=member&c=index&a=register&t=3');
			} else {
				//查看當前模型是否開啟了短信驗證功能
				$model_field_cache = getcache('model_field_'.$userinfo['modelid'],'model');
				if(isset($model_field_cache['mobile']) && $model_field_cache['mobile']['disabled']==0) {
					$mobile = $_POST['info']['mobile'];
					if(!preg_match('/^1([0-9]{10})/',$mobile)) showmessage(L('input_right_mobile'));
					$sms_report_db = pc_base::load_model('sms_report_model');
					$posttime = SYS_TIME-300;
					$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
					$r = $sms_report_db->get_one($where);
					if(!$r || $r['id_code']!=$_POST['mobile_verify']) showmessage(L('error_sms_code'));
				}
				$userinfo['groupid'] = $this->_get_usergroup_bypoint($userinfo['point']);
			}

			if(pc_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$status = $this->client->ps_member_register($userinfo['username'], $userinfo['password'], $userinfo['email'], $userinfo['regip'], $userinfo['encrypt']);
				if($status > 0) {
					$userinfo['phpssouid'] = $status;
					//傳入phpsso為明文密碼，加密後存入phpcms_v9
					$password = $userinfo['password'];
					$userinfo['password'] = password($userinfo['password'], $userinfo['encrypt']);
					$userid = $this->db->insert($userinfo, 1);
					if($member_setting['choosemodel']) {	//如果開啟選擇模型
						//通過模型獲取會員信息					
						require_once CACHE_MODEL_PATH.'member_input.class.php';
				        require_once CACHE_MODEL_PATH.'member_update.class.php';
						$member_input = new member_input($userinfo['modelid']);
						
						$_POST['info'] = array_map('new_html_special_chars',$_POST['info']);
						$user_model_info = $member_input->get($_POST['info']);
						$user_model_info['userid'] = $userid;
	
						//插入會員模型數據
						$this->db->set_model($userinfo['modelid']);
						$this->db->insert($user_model_info);
					}
					
					if($userid > 0) {
						//執行登陸操作
						if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
						$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
						$cookietime = $_cookietime ? TIME + $_cookietime : 0;
						
						if($userinfo['groupid'] == 7) {
							param::set_cookie('_username', $userinfo['username'], $cookietime);
							param::set_cookie('email', $userinfo['email'], $cookietime);							
						} else {
							$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
							$phpcms_auth = sys_auth($userid."\t".$userinfo['password'], 'ENCODE', $phpcms_auth_key);
							
							param::set_cookie('auth', $phpcms_auth, $cookietime);
							param::set_cookie('_userid', $userid, $cookietime);
							param::set_cookie('_username', $userinfo['username'], $cookietime);
							param::set_cookie('_nickname', $userinfo['nickname'], $cookietime);
							param::set_cookie('_groupid', $userinfo['groupid'], $cookietime);
							param::set_cookie('cookietime', $_cookietime, $cookietime);
						}
					}
					//如果需要郵箱認證
					if($member_setting['enablemailcheck']) {
						pc_base::load_sys_func('mail');
						$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key'));
						$code = sys_auth($userid.'|'.$phpcms_auth_key, 'ENCODE', $phpcms_auth_key);
						$url = APP_PATH."index.php?m=member&c=index&a=register&code=$code&verify=1";
						$message = $member_setting['registerverifymessage'];
						$message = str_replace(array('{click}','{url}','{username}','{email}','{password}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url,$userinfo['username'],$userinfo['email'],$password), $message);
 						sendmail($userinfo['email'], L('reg_verify_email'), $message);
						//設置當前注冊賬號COOKIE，為第二步重發郵件所用
						param::set_cookie('_regusername', $userinfo['username'], $cookietime);
						param::set_cookie('_reguserid', $userid, $cookietime);
						param::set_cookie('_reguseruid', $userinfo['phpssouid'], $cookietime);
						showmessage(L('operation_success'), 'index.php?m=member&c=index&a=register&t=2');
					} else {
						//如果不需要郵箱認證、直接登錄其他應用
						$synloginstr = $this->client->ps_member_synlogin($userinfo['phpssouid']);
						showmessage(L('operation_success').$synloginstr, 'index.php?m=member&c=index&a=init');
					}

				}
			} else {
				showmessage(L('enable_register').L('enable_phpsso'), 'index.php?m=member&c=index&a=login');
			}
			showmessage(L('operation_failure'), HTTP_REFERER);
		} else {
			if(!pc_base::load_config('system', 'phpsso')) {
				showmessage(L('enable_register').L('enable_phpsso'), 'index.php?m=member&c=index&a=login');
			}

			if(!empty($_GET['verify'])) {
				$code = isset($_GET['code']) ? trim($_GET['code']) : showmessage(L('operation_failure'), 'index.php?m=member&c=index');
				$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key'));
				$code_res = sys_auth($code, 'DECODE', $phpcms_auth_key);
				$code_arr = explode('|', $code_res);
				$userid = isset($code_arr[0]) ? $code_arr[0] : '';
				$userid = is_numeric($userid) ? $userid : showmessage(L('operation_failure'), 'index.php?m=member&c=index');

				$this->db->update(array('groupid'=>$this->_get_usergroup_bypoint()), array('userid'=>$userid));
				showmessage(L('operation_success'), 'index.php?m=member&c=index');
			} elseif(!empty($_GET['protocol'])) {

				include template('member', 'protocol');
			} else {
				//過濾非當前站點會員模型
				$modellist = getcache('member_model', 'commons');
				foreach($modellist as $k=>$v) {
					if($v['siteid']!=$siteid || $v['disabled']) {
						unset($modellist[$k]);
					}
				}
				if(empty($modellist)) {
					showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
				}
				//是否開啟選擇會員模型選項
				if($member_setting['choosemodel']) {
					$first_model = array_pop(array_reverse($modellist));
					$modelid = isset($_GET['modelid']) && in_array($_GET['modelid'], array_keys($modellist)) ? intval($_GET['modelid']) : $first_model['modelid'];

					if(array_key_exists($modelid, $modellist)) {
						//獲取會員模型表單
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//萬能字段過濾
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}

						$formValidator = $member_form->formValidator;
					}
				}
				$description = $modellist[$modelid]['description'];

				include template('member', 'register');
			}
		}
	}


	/*
	 * 測試郵件配置
	 */
	public function send_newmail() {
		$_username = param::get_cookie('_regusername');
		$_userid = param::get_cookie('_reguserid');
		$_ssouid = param::get_cookie('_reguseruid');
		$newemail = $_GET['newemail'];

		if($newemail==''){//郵箱為空，直接返回錯誤
			return '2';
		}
		$this->_init_phpsso();
		$status = $this->client->ps_checkemail($newemail);
		if($status=='-5'){//郵箱被佔用
			exit('-1');
		}
		if ($status==-1) {
			$status = $this->client->ps_get_member_info($newemail, 3);
			if($status) {
				$status = unserialize($status);	//接口返回序列化，進行判斷
				if (!isset($status['uid']) || $status['uid'] != intval($_ssouid)) {
					exit('-1');
				}
			} else {
				exit('-1');
			}
		}
		//驗證郵箱格式
		pc_base::load_sys_func('mail');
		$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key'));
		$code = sys_auth($_userid.'|'.$phpcms_auth_key, 'ENCODE', $phpcms_auth_key);
		$url = APP_PATH."index.php?m=member&c=index&a=register&code=$code&verify=1";

		//讀取配置獲取驗證信息
		$member_setting = getcache('member_setting');
		$message = $member_setting['registerverifymessage'];
		$message = str_replace(array('{click}','{url}','{username}','{email}','{password}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url,$_username,$newemail,$password), $message);

 		if(sendmail($newemail, L('reg_verify_email'), $message)){
			//更新新的郵箱，用來驗證
 			$this->db->update(array('email'=>$newemail), array('userid'=>$_userid));
			$this->client->ps_member_edit($_username, $newemail, '', '', $_ssouid);
			$return = '1';
		}else{
			$return = '2';
		}
		echo $return;
   	}

	public function account_manage() {
		$memberinfo = $this->memberinfo;
		//初始化phpsso
		$phpsso_api_url = $this->_init_phpsso();
		//獲取頭像數組
		$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);

		$grouplist = getcache('grouplist');
		$member_model = getcache('member_model', 'commons');

		//獲取用戶模型數據
		$this->db->set_model($this->memberinfo['modelid']);
		$member_modelinfo_arr = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
		$model_info = getcache('model_field_'.$this->memberinfo['modelid'], 'model');
		foreach($model_info as $k=>$v) {
			if($v['formtype'] == 'omnipotent') continue;
			if($v['formtype'] == 'image') {
				$member_modelinfo[$v['name']] = "<a href='$member_modelinfo_arr[$k]' target='_blank'><img src='$member_modelinfo_arr[$k]' height='40' widht='40' onerror=\"this.src='$phpsso_api_url/statics/images/member/nophoto.gif'\"></a>";
			} elseif($v['formtype'] == 'datetime' && $v['fieldtype'] == 'int') {	//如果為日期字段
				$member_modelinfo[$v['name']] = format::date($member_modelinfo_arr[$k], $v['format'] == 'Y-m-d H:i:s' ? 1 : 0);
			} elseif($v['formtype'] == 'images') {
				$tmp = string2array($member_modelinfo_arr[$k]);
				$member_modelinfo[$v['name']] = '';
				if(is_array($tmp)) {
					foreach ($tmp as $tv) {
						$member_modelinfo[$v['name']] .= " <a href='$tv[url]' target='_blank'><img src='$tv[url]' height='40' widht='40' onerror=\"this.src='$phpsso_api_url/statics/images/member/nophoto.gif'\"></a>";
					}
					unset($tmp);
				}
			} elseif($v['formtype'] == 'box') {	//box字段，獲取字段名稱和值的數組
				$tmp = explode("\n",$v['options']);
				if(is_array($tmp)) {
					foreach($tmp as $boxv) {
						$box_tmp_arr = explode('|', trim($boxv));
						if(is_array($box_tmp_arr) && isset($box_tmp_arr[1]) && isset($box_tmp_arr[0])) {
							$box_tmp[$box_tmp_arr[1]] = $box_tmp_arr[0];
							$tmp_key = intval($member_modelinfo_arr[$k]);
						}
					}
				}
				if(isset($box_tmp[$tmp_key])) {
					$member_modelinfo[$v['name']] = $box_tmp[$tmp_key];
				} else {
					$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
				}
				unset($tmp, $tmp_key, $box_tmp, $box_tmp_arr);
			} elseif($v['formtype'] == 'linkage') {	//如果為聯動菜單
				$tmp = string2array($v['setting']);
				$tmpid = $tmp['linkageid'];
				$linkagelist = getcache($tmpid, 'linkage');
				$fullname = $this->_get_linkage_fullname($member_modelinfo_arr[$k], $linkagelist);

				$member_modelinfo[$v['name']] = substr($fullname, 0, -1);
				unset($tmp, $tmpid, $linkagelist, $fullname);
			} else {
				$member_modelinfo[$v['name']] = $member_modelinfo_arr[$k];
			}
		}

		include template('member', 'account_manage');
	}

	public function account_manage_avatar() {
		$memberinfo = $this->memberinfo;
		//初始化phpsso
		$phpsso_api_url = $this->_init_phpsso();
		$ps_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$auth_data = $this->client->auth_data(array('uid'=>$this->memberinfo['phpssouid'], 'ps_auth_key'=>$ps_auth_key), '', $ps_auth_key);
		$upurl = base64_encode($phpsso_api_url.'/index.php?m=phpsso&c=index&a=uploadavatar&auth_data='.$auth_data);
		//獲取頭像數組
		$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);

		include template('member', 'account_manage_avatar');
	}

	public function account_manage_security() {
		$memberinfo = $this->memberinfo;
		include template('member', 'account_manage_security');
	}
	
	public function account_manage_info() {
		if(isset($_POST['dosubmit'])) {
			//更新用戶暱稱
			$nickname = isset($_POST['nickname']) && is_username(trim($_POST['nickname'])) ? trim($_POST['nickname']) : '';
			if($nickname) {
				$this->db->update(array('nickname'=>$nickname), array('userid'=>$this->memberinfo['userid']));
				if(!isset($cookietime)) {
					$get_cookietime = param::get_cookie('cookietime');
				}
				$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
				$cookietime = $_cookietime ? TIME + $_cookietime : 0;
				param::set_cookie('_nickname', $nickname, $cookietime);
			}
			require_once CACHE_MODEL_PATH.'member_input.class.php';
			require_once CACHE_MODEL_PATH.'member_update.class.php';
			$member_input = new member_input($this->memberinfo['modelid']);
			$modelinfo = $member_input->get($_POST['info']);

			$this->db->set_model($this->memberinfo['modelid']);
			$membermodelinfo = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
			if(!empty($membermodelinfo)) {
				$this->db->update($modelinfo, array('userid'=>$this->memberinfo['userid']));
			} else {
				$modelinfo['userid'] = $this->memberinfo['userid'];
				$this->db->insert($modelinfo);
			}

			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$memberinfo = $this->memberinfo;
			//獲取會員模型表單
			require CACHE_MODEL_PATH.'member_form.class.php';
			$member_form = new member_form($this->memberinfo['modelid']);
			$this->db->set_model($this->memberinfo['modelid']);

			$membermodelinfo = $this->db->get_one(array('userid'=>$this->memberinfo['userid']));
			$forminfos = $forminfos_arr = $member_form->get($membermodelinfo);

			//萬能字段過濾
			foreach($forminfos as $field=>$info) {
				if($info['isomnipotent']) {
					unset($forminfos[$field]);
				} else {
					if($info['formtype']=='omnipotent') {
						foreach($forminfos_arr as $_fm=>$_fm_value) {
							if($_fm_value['isomnipotent']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
							}
						}
						$forminfos[$field]['form'] = $info['form'];
					}
				}
			}

			$formValidator = $member_form->formValidator;

			include template('member', 'account_manage_info');
		}
	}

	public function account_manage_password() {
		if(isset($_POST['dosubmit'])) {
			$updateinfo = array();
			if(!is_password($_POST['info']['password'])) {
				showmessage(L('password_format_incorrect'), HTTP_REFERER);
			}
			if($this->memberinfo['password'] != password($_POST['info']['password'], $this->memberinfo['encrypt'])) {
				showmessage(L('old_password_incorrect'), HTTP_REFERER);
			}
			//修改會員郵箱
			if($this->memberinfo['email'] != $_POST['info']['email'] && is_email($_POST['info']['email'])) {
				$email = $_POST['info']['email'];
				$updateinfo['email'] = $_POST['info']['email'];
			} else {
				$email = '';
			}
			$newpassword = password($_POST['info']['newpassword'], $this->memberinfo['encrypt']);
			$updateinfo['password'] = $newpassword;

			$this->db->update($updateinfo, array('userid'=>$this->memberinfo['userid']));
			if(pc_base::load_config('system', 'phpsso')) {
				//初始化phpsso
				$this->_init_phpsso();
				$res = $this->client->ps_member_edit('', $email, $_POST['info']['password'], $_POST['info']['newpassword'], $this->memberinfo['phpssouid'], $this->memberinfo['encrypt']);
				$message_error = array('-1'=>L('user_not_exist'), '-2'=>L('old_password_incorrect'), '-3'=>L('email_already_exist'), '-4'=>L('email_error'), '-5'=>L('param_error'));
				if ($res) showmessage($message_error[$res]);
			}

			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$show_validator = true;
			$memberinfo = $this->memberinfo;

			include template('member', 'account_manage_password');
		}
	}

	public function account_manage_upgrade() {
		$memberinfo = $this->memberinfo;
		$grouplist = getcache('grouplist');
		if(empty($grouplist[$memberinfo['groupid']]['allowupgrade'])) {
			showmessage(L('deny_upgrade'), HTTP_REFERER);
		}
		if(isset($_POST['upgrade_type']) && intval($_POST['upgrade_type']) < 0) {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}

		if(isset($_POST['upgrade_date']) && intval($_POST['upgrade_date']) < 0) {
			showmessage(L('operation_failure'), HTTP_REFERER);
		}

		if(isset($_POST['dosubmit'])) {
			$groupid = isset($_POST['groupid']) ? intval($_POST['groupid']) : showmessage(L('operation_failure'), HTTP_REFERER);

			$upgrade_type = isset($_POST['upgrade_type']) ? intval($_POST['upgrade_type']) : showmessage(L('operation_failure'), HTTP_REFERER);
			$upgrade_date = !empty($_POST['upgrade_date']) ? intval($_POST['upgrade_date']) : showmessage(L('operation_failure'), HTTP_REFERER);

			//消費類型，包年、包月、包日，價格
			$typearr = array($grouplist[$groupid]['price_y'], $grouplist[$groupid]['price_m'], $grouplist[$groupid]['price_d']);
			//消費類型，包年、包月、包日，時間
			$typedatearr = array('366', '31', '1');
			//消費的價格
			$cost = $typearr[$upgrade_type]*$upgrade_date;
			//購買時間
			$buydate = $typedatearr[$upgrade_type]*$upgrade_date*86400;
			$overduedate = $memberinfo['overduedate'] > SYS_TIME ? ($memberinfo['overduedate']+$buydate) : (SYS_TIME+$buydate);

			if($memberinfo['amount'] >= $cost) {
				$this->db->update(array('groupid'=>$groupid, 'overduedate'=>$overduedate, 'vip'=>1), array('userid'=>$memberinfo['userid']));
				//消費記錄
				pc_base::load_app_class('spend','pay',0);
				spend::amount($cost, L('allowupgrade'), $memberinfo['userid'], $memberinfo['username']);
				showmessage(L('operation_success'), 'index.php?m=member&c=index&a=init');
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}

		} else {

			$groupid = isset($_GET['groupid']) ? intval($_GET['groupid']) : '';
			//初始化phpsso
			$phpsso_api_url = $this->_init_phpsso();
			//獲取頭像數組
			$avatar = $this->client->ps_getavatar($this->memberinfo['phpssouid']);


			$memberinfo['groupname'] = $grouplist[$memberinfo[groupid]]['name'];
			$memberinfo['grouppoint'] = $grouplist[$memberinfo[groupid]]['point'];
			unset($grouplist[$memberinfo['groupid']]);
			include template('member', 'account_manage_upgrade');
		}
	}

	public function login() {
		$this->_session_start();
		//獲取用戶siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定義站點id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}

		if(isset($_POST['dosubmit'])) {
			if(empty($_SESSION['connectid'])) {
				//判斷驗證碼
				$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);
				if ($_SESSION['code'] != strtolower($code)) {
					showmessage(L('code_error'), HTTP_REFERER);
				}
			}

			$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : showmessage(L('username_empty'), HTTP_REFERER);
			$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : showmessage(L('password_empty'), HTTP_REFERER);
			$cookietime = intval($_POST['cookietime']);
			$synloginstr = ''; //同步登陸js代碼

			if(pc_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$status = $this->client->ps_member_login($username, $password);
				$memberinfo = unserialize($status);

				if(isset($memberinfo['uid'])) {
					//查詢帳號
					$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
					if(!$r) {
						//插入會員詳細信息，會員不存在 插入會員
						$info = array(
									'phpssouid'=>$memberinfo['uid'],
						 			'username'=>$memberinfo['username'],
						 			'password'=>$memberinfo['password'],
						 			'encrypt'=>$memberinfo['random'],
						 			'email'=>$memberinfo['email'],
						 			'regip'=>$memberinfo['regip'],
						 			'regdate'=>$memberinfo['regdate'],
						 			'lastip'=>$memberinfo['lastip'],
						 			'lastdate'=>$memberinfo['lastdate'],
						 			'groupid'=>$this->_get_usergroup_bypoint(),	//會員默認組
						 			'modelid'=>10,	//普通會員
									);

						//如果是connect用戶
						if(!empty($_SESSION['connectid'])) {
							$userinfo['connectid'] = $_SESSION['connectid'];
						}
						if(!empty($_SESSION['from'])) {
							$userinfo['from'] = $_SESSION['from'];
						}
						unset($_SESSION['connectid'], $_SESSION['from']);

						$this->db->insert($info);
						unset($info);
						$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
					}
					$password = $r['password'];
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
 				} else {
					if($status == -1) {	//用戶不存在
						showmessage(L('user_not_exist'), 'index.php?m=member&c=index&a=login');
					} elseif($status == -2) { //密碼錯誤
						showmessage(L('password_error'), 'index.php?m=member&c=index&a=login');
					} else {
						showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
					}
				}

			} else {
				//密碼錯誤剩余重試次數
				$this->times_db = pc_base::load_model('times_model');
				$rtime = $this->times_db->get_one(array('username'=>$username));
				if($rtime['times'] > 4) {
					$minute = 60 - floor((SYS_TIME - $rtime['logintime']) / 60);
					showmessage(L('wait_1_hour', array('minute'=>$minute)));
				}

				//查詢帳號
				$r = $this->db->get_one(array('username'=>$username));

				if(!$r) showmessage(L('user_not_exist'),'index.php?m=member&c=index&a=login');

				//驗證用戶密碼
				$password = md5(md5(trim($password)).$r['encrypt']);
				if($r['password'] != $password) {
					$ip = ip();
					if($rtime && $rtime['times'] < 5) {
						$times = 5 - intval($rtime['times']);
						$this->times_db->update(array('ip'=>$ip, 'times'=>'+=1'), array('username'=>$username));
					} else {
						$this->times_db->insert(array('username'=>$username, 'ip'=>$ip, 'logintime'=>SYS_TIME, 'times'=>1));
						$times = 5;
					}
					showmessage(L('password_error', array('times'=>$times)), 'index.php?m=member&c=index&a=login', 3000);
				}
				$this->times_db->delete(array('username'=>$username));
			}

			//如果用戶被鎖定
			if($r['islock']) {
				showmessage(L('user_is_lock'));
			}

			$userid = $r['userid'];
			$groupid = $r['groupid'];
			$username = $r['username'];
			$nickname = empty($r['nickname']) ? $username : $r['nickname'];

			$updatearr = array('lastip'=>ip(), 'lastdate'=>SYS_TIME);
			//vip過期，更新vip和會員組
			if($r['overduedate'] < SYS_TIME) {
				$updatearr['vip'] = 0;
			}

			//檢查用戶積分，更新新用戶組，除去郵箱認證、禁止訪問、遊客組用戶、vip用戶，如果該用戶組不允許自助升級則不進行該操作
			if($r['point'] >= 0 && !in_array($r['groupid'], array('1', '7', '8')) && empty($r[vip])) {
				$grouplist = getcache('grouplist');
				if(!empty($grouplist[$r['groupid']]['allowupgrade'])) {
					$check_groupid = $this->_get_usergroup_bypoint($r['point']);

					if($check_groupid != $r['groupid']) {
						$updatearr['groupid'] = $groupid = $check_groupid;
					}
				}
			}

			//如果是connect用戶
			if(!empty($_SESSION['connectid'])) {
				$updatearr['connectid'] = $_SESSION['connectid'];
			}
			if(!empty($_SESSION['from'])) {
				$updatearr['from'] = $_SESSION['from'];
			}
			unset($_SESSION['connectid'], $_SESSION['from']);

			$this->db->update($updatearr, array('userid'=>$userid));

			if(!isset($cookietime)) {
				$get_cookietime = param::get_cookie('cookietime');
			}
			$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
			$cookietime = $_cookietime ? SYS_TIME + $_cookietime : 0;

			$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
			$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);

			param::set_cookie('auth', $phpcms_auth, $cookietime);
			param::set_cookie('_userid', $userid, $cookietime);
			param::set_cookie('_username', $username, $cookietime);
			param::set_cookie('_groupid', $groupid, $cookietime);
			param::set_cookie('_nickname', $nickname, $cookietime);
			//param::set_cookie('cookietime', $_cookietime, $cookietime);
			$forward = isset($_POST['forward']) && !empty($_POST['forward']) ? urldecode($_POST['forward']) : 'index.php?m=member&c=index';
			showmessage(L('login_success').$synloginstr, $forward);
		} else {
			$setting = pc_base::load_config('system');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? urlencode($_GET['forward']) : '';

			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);

			include template('member', 'login');
		}
	}

	public function logout() {
		$setting = pc_base::load_config('system');
		//snda退出
		if($setting['snda_enable'] && param::get_cookie('_from')=='snda') {
			param::set_cookie('_from', '');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? urlencode($_GET['forward']) : '';
			$logouturl = 'https://cas.sdo.com/cas/logout?url='.urlencode(APP_PATH.'index.php?m=member&c=index&a=logout&forward='.$forward);
			header('Location: '.$logouturl);
		} else {
			$synlogoutstr = '';	//同步退出js代碼
			if(pc_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$synlogoutstr = $this->client->ps_member_synlogout();
			}

			param::set_cookie('auth', '');
			param::set_cookie('_userid', '');
			param::set_cookie('_username', '');
			param::set_cookie('_groupid', '');
			param::set_cookie('_nickname', '');
			param::set_cookie('cookietime', '');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index&a=login';
			showmessage(L('logout_success').$synlogoutstr, $forward);
		}
	}

	/**
	 * 我的收藏
	 *
	 */
	public function favorite() {
		$this->favorite_db = pc_base::load_model('favorite_model');
		$memberinfo = $this->memberinfo;
		if(isset($_GET['id']) && trim($_GET['id'])) {
			$this->favorite_db->delete(array('userid'=>$memberinfo['userid'], 'id'=>intval($_GET['id'])));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$page = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
			$favoritelist = $this->favorite_db->listinfo(array('userid'=>$memberinfo['userid']), 'id DESC', $page, 10);
			$pages = $this->favorite_db->pages;

			include template('member', 'favorite_list');
		}
	}

	/**
	 * 我的好友
	 */
	public function friend() {
		$memberinfo = $this->memberinfo;
		$this->friend_db = pc_base::load_model('friend_model');
		if(isset($_GET['friendid'])) {
			$this->friend_db->delete(array('userid'=>$memberinfo['userid'], 'friendid'=>intval($_GET['friendid'])));
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			//初始化phpsso
			$phpsso_api_url = $this->_init_phpsso();

			//我的好友列表userid
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$friendids = $this->friend_db->listinfo(array('userid'=>$memberinfo['userid']), '', $page, 10);
			$pages = $this->friend_db->pages;
			foreach($friendids as $k=>$v) {
				$friendlist[$k]['friendid'] = $v['friendid'];
				$friendlist[$k]['avatar'] = $this->client->ps_getavatar($v['phpssouid']);
				$friendlist[$k]['is'] = $v['is'];
			}
			include template('member', 'friend_list');
		}
	}

	/**
	 * 積分兌換
	 */
	public function change_credit() {
		$memberinfo = $this->memberinfo;
		//加載用戶模塊配置
		$member_setting = getcache('member_setting');
		$this->_init_phpsso();
		$setting = $this->client->ps_getcreditlist();
		$outcredit = unserialize($setting);
		$setting = $this->client->ps_getapplist();
		$applist = unserialize($setting);

		if(isset($_POST['dosubmit'])) {
			//本系統積分兌換數
			$fromvalue = intval($_POST['fromvalue']);
			//本系統積分類型
			$from = $_POST['from'];
			$toappid_to = explode('_', $_POST['to']);
			//目標系統appid
			$toappid = $toappid_to[0];
			//目標系統積分類型
			$to = $toappid_to[1];
			if($from == 1) {
				if($memberinfo['point'] < $fromvalue) {
					showmessage(L('need_more_point'), HTTP_REFERER);
				}
			} elseif($from == 2) {
				if($memberinfo['amount'] < $fromvalue) {
					showmessage(L('need_more_amount'), HTTP_REFERER);
				}
			} else {
				showmessage(L('credit_setting_error'), HTTP_REFERER);
			}

			$status = $this->client->ps_changecredit($memberinfo['phpssouid'], $from, $toappid, $to, $fromvalue);
			if($status == 1) {
				if($from == 1) {
					$this->db->update(array('point'=>"-=$fromvalue"), array('userid'=>$memberinfo['userid']));
				} elseif($from == 2) {
					$this->db->update(array('amount'=>"-=$fromvalue"), array('userid'=>$memberinfo['userid']));
				}
				showmessage(L('operation_success'), HTTP_REFERER);
			} else {
				showmessage(L('operation_failure'), HTTP_REFERER);
			}
		} elseif(isset($_POST['buy'])) {
			if(!is_numeric($_POST['money']) || $_POST['money'] < 0) {
				showmessage(L('money_error'), HTTP_REFERER);
			} else {
				$money = intval($_POST['money']);
			}

			if($memberinfo['amount'] < $money) {
				showmessage(L('short_of_money'), HTTP_REFERER);
			}
			//此處比率讀取用戶配置
			$point = $money*$member_setting['rmb_point_rate'];
			$this->db->update(array('point'=>"+=$point"), array('userid'=>$memberinfo['userid']));
			//加入消費記錄，同時扣除金錢
			pc_base::load_app_class('spend','pay',0);
			spend::amount($money, L('buy_point'), $memberinfo['userid'], $memberinfo['username']);
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			$credit_list = pc_base::load_config('credit');

			include template('member', 'change_credit');
		}
	}

	//mini登陸條
	public function mini() {
		$_username = param::get_cookie('_username');
		$_userid = param::get_cookie('_userid');
		$siteid = isset($_GET['siteid']) ? intval($_GET['siteid']) : '';
		//定義站點id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}

		$snda_enable = pc_base::load_config('system', 'snda_enable');
		include template('member', 'mini');
	}

	/**
	 * 初始化phpsso
	 * about phpsso, include client and client configure
	 * @return string phpsso_api_url phpsso地址
	 */
	private function _init_phpsso() {
		pc_base::load_app_class('client', '', 0);
		define('APPID', pc_base::load_config('system', 'phpsso_appid'));
		$phpsso_api_url = pc_base::load_config('system', 'phpsso_api_url');
		$phpsso_auth_key = pc_base::load_config('system', 'phpsso_auth_key');
		$this->client = new client($phpsso_api_url, $phpsso_auth_key);
		return $phpsso_api_url;
	}

	protected function _checkname($username) {
		$username =  trim($username);
		if ($this->db->get_one(array('username'=>$username))){
			return false;
		}
		return true;
	}

	private function _session_start() {
		$session_storage = 'session_'.pc_base::load_config('system','session_storage');
		pc_base::load_sys_class($session_storage);
	}

	/*
	 * 通過linkageid獲取名字路徑
	 */
	protected function _get_linkage_fullname($linkageid,  $linkagelist) {
		$fullname = '';
		if($linkagelist['data'][$linkageid]['parentid'] != 0) {
			$fullname = $this->_get_linkage_fullname($linkagelist['data'][$linkageid]['parentid'], $linkagelist);
		}
		//所在地區名稱
		$return = $fullname.$linkagelist['data'][$linkageid]['name'].'>';
		return $return;
	}

	/**
	 *根據積分算出用戶組
	 * @param $point int 積分數
	 */
	protected function _get_usergroup_bypoint($point=0) {
		$groupid = 2;
		if(empty($point)) {
			$member_setting = getcache('member_setting');
			$point = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
		}
		$grouplist = getcache('grouplist');

		foreach ($grouplist as $k=>$v) {
			$grouppointlist[$k] = $v['point'];
		}
		arsort($grouppointlist);

		//如果超出用戶組積分設置則為積分最高的用戶組
		if($point > max($grouppointlist)) {
			$groupid = key($grouppointlist);
		} else {
			foreach ($grouppointlist as $k=>$v) {
				if($point >= $v) {
					$groupid = $tmp_k;
					break;
				}
				$tmp_k = $k;
			}
		}
		return $groupid;
	}

	/**
	 * 檢查用戶名
	 * @param string $username	用戶名
	 * @return $status {-4：用戶名禁止注冊;-1:用戶名已經存在 ;1:成功}
	 */
	public function public_checkname_ajax() {
		$username = isset($_GET['username']) && trim($_GET['username']) ? trim($_GET['username']) : exit(0);
		if(CHARSET != 'utf-8') {
			$username = iconv('utf-8', CHARSET, $username);
			$username = addslashes($username);
		}
		$username = safe_replace($username);
		//首先判斷會員審核表
		$this->verify_db = pc_base::load_model('member_verify_model');
		if($this->verify_db->get_one(array('username'=>$username))) {
			exit('0');
		}

		$this->_init_phpsso();
		$status = $this->client->ps_checkname($username);

		if($status == -4 || $status == -1) {
			exit('0');
		} else {
			exit('1');
		}
	}

	/**
	 * 檢查用戶暱稱
	 * @param string $nickname	暱稱
	 * @return $status {0:已存在;1:成功}
	 */
	public function public_checknickname_ajax() {
		$nickname = isset($_GET['nickname']) && trim($_GET['nickname']) ? trim($_GET['nickname']) : exit('0');
		if(CHARSET != 'utf-8') {
			$nickname = iconv('utf-8', CHARSET, $nickname);
			$nickname = addslashes($nickname);
		}
		//首先判斷會員審核表
		$this->verify_db = pc_base::load_model('member_verify_model');
		if($this->verify_db->get_one(array('nickname'=>$nickname))) {
			exit('0');
		}
		if(isset($_GET['userid'])) {
			$userid = intval($_GET['userid']);
			//如果是會員修改，而且NICKNAME和原來優質一致返回1，否則返回0
			$info = get_memberinfo($userid);
			if($info['nickname'] == $nickname){//未改變
				exit('1');
			}else{//已改變，判斷是否已有此名
				$where = array('nickname'=>$nickname);
				$res = $this->db->get_one($where);
				if($res) {
					exit('0');
				} else {
					exit('1');
				}
			}
 		} else {
			$where = array('nickname'=>$nickname);
			$res = $this->db->get_one($where);
			if($res) {
				exit('0');
			} else {
				exit('1');
			}
		}
	}

	/**
	 * 檢查郵箱
	 * @param string $email
	 * @return $status {-1:email已經存在 ;-5:郵箱禁止注冊;1:成功}
	 */
	public function public_checkemail_ajax() {
		$this->_init_phpsso();
		$email = isset($_GET['email']) && trim($_GET['email']) ? trim($_GET['email']) : exit(0);

		$status = $this->client->ps_checkemail($email);
		if($status == -5) {	//禁止注冊
			exit('0');
		} elseif($status == -1) {	//用戶名已存在，但是修改用戶的時候需要判斷郵箱是否是當前用戶的
			if(isset($_GET['phpssouid'])) {	//修改用戶傳入phpssouid
				$status = $this->client->ps_get_member_info($email, 3);
				if($status) {
					$status = unserialize($status);	//接口返回序列化，進行判斷
					if (isset($status['uid']) && $status['uid'] == intval($_GET['phpssouid'])) {
						exit('1');
					} else {
						exit('0');
					}
				} else {
					exit('0');
				}
			} else {
				exit('0');
			}
		} else {
			exit('1');
		}
	}

	public function public_sina_login() {
		define('WB_AKEY', pc_base::load_config('system', 'sina_akey'));
		define('WB_SKEY', pc_base::load_config('system', 'sina_skey'));
		// pc_base::load_app_class('weibooauth', '' ,0);
		pc_base::load_app_class('saetv2', '' ,0);
		$this->_session_start();
		$callback_url = APP_PATH.'index.php?m=member&c=index&a=public_sina_login&callback=1';

		if(isset($_GET['callback']) && trim($_GET['callback'])) {
			$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
			if (isset($_REQUEST['code'])) {
				$keys = array();

				$state = $_REQUEST['state'];
				if ( empty($state) || $state !== $_SESSION['weibo_state'] ) {
					showmessage('非法的請求', $_SESSION['referer']);
				}
				unset($_SESSION['weibo_state']);

				$keys['code'] = $_REQUEST['code'];
				$keys['redirect_uri'] = $callback_url;
				try {
					$token = $o->getAccessToken( 'code', $keys ) ;
				} catch (OAuthException $e) {
					showmessage('獲取新浪微博授權失敗', $_SESSION['referer']);
				}
			} else {
				showmessage('獲取新浪微博授權失敗', $_SESSION['referer']);
			}

			if ($token) {
				$_SESSION['weibo_token'] = $token;
			}
			$c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['weibo_token']['access_token']);
			//獲取用戶信息
			$weibo_uid = $c->get_uid();
			$me = $c->show_user_by_id($weibo_uid['uid']);
			if(CHARSET != 'utf-8') {
				$me['name'] = iconv('utf-8', CHARSET, $me['name']);
				$me['location'] = iconv('utf-8', CHARSET, $me['location']);
				$me['description'] = iconv('utf-8', CHARSET, $me['description']);
				$me['screen_name'] = iconv('utf-8', CHARSET, $me['screen_name']);
			}
			if(empty($me['id'])) {
				//showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
				showmessage(L('login_failure'), 'index.php');
			} else {
 				//檢查connect會員是否綁定，已綁定直接登錄，未綁定提示注冊/綁定頁面
				$where = array('connectid'=>$me['id'], 'from'=>'sina');
				$r = $this->db->get_one($where);

				//connect用戶已經綁定本站用戶
				if(!empty($r)) {
					//讀取本站用戶信息，執行登錄操作

					$password = $r['password'];
					$this->_init_phpsso();
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));

					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;

					$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
					$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);

					param::set_cookie('auth', $phpcms_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					//$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php';
					showmessage(L('login_success').$synloginstr, $forward);

				} else {
 					//彈出綁定注冊頁面
					$_SESSION = array();
					$_SESSION['connectid'] = $me['id'];
					$_SESSION['from'] = 'sina';
					//$_SESSION['avatar'] = $me['avatar_large'];
					$_SESSION['avatar'] = $me['avatar_large'];
					$connect_username = $me['name'];

					//加載用戶模塊配置
					$member_setting = getcache('member_setting');
					if(!$member_setting['allowregister']) {
						//showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
						showmessage(L('deny_register'), 'index.php');
					}

					//獲取用戶siteid
					$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
					//過濾非當前站點會員模型
					$modellist = getcache('member_model', 'commons');
					foreach($modellist as $k=>$v) {
						if($v['siteid']!=$siteid || $v['disabled']) {
							unset($modellist[$k]);
						}
					}
					if(empty($modellist)) {
						showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
					}

					$modelid = 10; //設定默認值
					if(array_key_exists($modelid, $modellist)) {
						//獲取會員模型表單
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//萬能字段過濾
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}

						$formValidator = $member_form->formValidator;
					}
					include template('member', 'connect');
				}
			}
		} else {
			$_SESSION['referer'] = $_SERVER['HTTP_REFERER'];
			$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
			$state = uniqid('weibo_', true);
			$_SESSION['weibo_state'] = $state;
			$url = $o->getAuthorizeURL($callback_url, 'code', $state);
			header("Location: $url");
		}
	}

	/**
	 * 盛大通行證登陸
	 */
	public function public_snda_login() {
		define('SNDA_AKEY', pc_base::load_config('system', 'snda_akey'));
		define('SNDA_SKEY', pc_base::load_config('system', 'snda_skey'));
		define('SNDA_CALLBACK', urlencode(APP_PATH.'index.php?m=member&c=index&a=public_snda_login&callback=1'));

		pc_base::load_app_class('OauthSDK', '' ,0);
		$this->_session_start();
		if(isset($_GET['callback']) && trim($_GET['callback'])) {

			$o = new OauthSDK(SNDA_AKEY, SNDA_SKEY, SNDA_CALLBACK);
			$code = $_REQUEST['code'];
			$accesstoken = $o->getAccessToken($code);

			if(is_numeric($accesstoken['sdid'])) {
				$userid = $accesstoken['sdid'];
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}

			if(!empty($userid)) {

				//檢查connect會員是否綁定，已綁定直接登錄，未綁定提示注冊/綁定頁面
				$where = array('connectid'=>$userid, 'from'=>'snda');
				$r = $this->db->get_one($where);

				//connect用戶已經綁定本站用戶
				if(!empty($r)) {
					//讀取本站用戶信息，執行登錄操作
					$password = $r['password'];
					$this->_init_phpsso();
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;

					$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
					$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);

					param::set_cookie('auth', $phpcms_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					param::set_cookie('_from', 'snda');
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success').$synloginstr, $forward);
				} else {
					//彈出綁定注冊頁面
					$_SESSION = array();
					$_SESSION['connectid'] = $userid;
					$_SESSION['from'] = 'snda';
					$connect_username = $userid;
					include template('member', 'connect');
				}
			}
		} else {
			$o = new OauthSDK(SNDA_AKEY, SNDA_SKEY, SNDA_CALLBACK);
			$accesstoken = $o->getSystemToken();
			$aurl = $o->getAuthorizeURL();

			include template('member', 'connect_snda');
		}

	}


	/**
	 * QQ號碼登錄
	 * 該函數為QQ登錄回調地址
	 */
	public function public_qq_loginnew(){

                $appid = pc_base::load_config('system', 'qq_appid');
                $appkey = pc_base::load_config('system', 'qq_appkey');
                $callback = pc_base::load_config('system', 'qq_callback');
                pc_base::load_app_class('qqapi','',0);
                $info = new qqapi($appid,$appkey,$callback);
                $this->_session_start();
                if(!isset($_GET['code'])){
                         $info->redirect_to_login();
                }else{
			//獲取access token
			$openid_info = $info->get_openid();
			$_SESSION['openid'] = $openid_info['openid'];
			if(!empty( $openid_info['openid']  )){
				$r = $this->db->get_one(array('connectid'=>$openid_info['openid'],'from'=>'qq'));
				 if(!empty($r)){

					//QQ已存在於數據庫，則直接轉向登陸操作
					$password = $r['password'];
					$this->_init_phpsso();
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
					$userid = $r['userid'];	
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;
					$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
					$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);
					param::set_cookie('auth', $phpcms_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					//$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php';
					showmessage(L('login_success').$synloginstr, $forward);
				}else{
					//未存在於數據庫中，跳去完善資料頁面。頁面預置用戶名（QQ返回是UTF8編碼，如有需要進行轉碼）
					$user = $info->get_user_info();
 					$_SESSION['connectid'] = $_SESSION['openid'];
					$_SESSION['from'] = 'qq';
					$_SESSION['avatar'] = $user['figureurl_qq_2'];
					if(CHARSET != 'utf-8') {//轉編碼
						$connect_username = iconv('utf-8', CHARSET, $user['nickname']);
					}
 					include template('member', 'connect');
				}
			}
                }
    }

	/**
	 * QQ微博登錄
	 */
	public function public_qq_login() {
		define('QQ_AKEY', pc_base::load_config('system', 'qq_akey'));
		define('QQ_SKEY', pc_base::load_config('system', 'qq_skey'));
		pc_base::load_app_class('qqoauth', '' ,0);
		$this->_session_start();
		if(isset($_GET['callback']) && trim($_GET['callback'])) {
			$o = new WeiboOAuth(QQ_AKEY, QQ_SKEY, $_SESSION['keys']['oauth_token'], $_SESSION['keys']['oauth_token_secret']);
			$_SESSION['last_key'] = $o->getAccessToken($_REQUEST['oauth_verifier']);

			if(!empty($_SESSION['last_key']['name'])) {
				//檢查connect會員是否綁定，已綁定直接登錄，未綁定提示注冊/綁定頁面
				$where = array('connectid'=>$_REQUEST['openid'], 'from'=>'qq');
				$r = $this->db->get_one($where);

				//connect用戶已經綁定本站用戶
				if(!empty($r)) {
					//讀取本站用戶信息，執行登錄操作
					$password = $r['password'];
					$this->_init_phpsso();
					$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
					$userid = $r['userid'];
					$groupid = $r['groupid'];
					$username = $r['username'];
					$nickname = empty($r['nickname']) ? $username : $r['nickname'];
					$this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;

					$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
					$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);

					param::set_cookie('auth', $phpcms_auth, $cookietime);
					param::set_cookie('_userid', $userid, $cookietime);
					param::set_cookie('_username', $username, $cookietime);
					param::set_cookie('_groupid', $groupid, $cookietime);
					param::set_cookie('cookietime', $_cookietime, $cookietime);
					param::set_cookie('_nickname', $nickname, $cookietime);
					param::set_cookie('_from', 'snda');
					$forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
					showmessage(L('login_success').$synloginstr, $forward);
				} else {
					//彈出綁定注冊頁面
					$_SESSION = array();
					$_SESSION['connectid'] = $_REQUEST['openid'];
					$_SESSION['from'] = 'qq';
					$connect_username = $_SESSION['last_key']['name'];

					//加載用戶模塊配置
					$member_setting = getcache('member_setting');
					if(!$member_setting['allowregister']) {
						showmessage(L('deny_register'), 'index.php?m=member&c=index&a=login');
					}

					//獲取用戶siteid
					$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
					//過濾非當前站點會員模型
					$modellist = getcache('member_model', 'commons');
					foreach($modellist as $k=>$v) {
						if($v['siteid']!=$siteid || $v['disabled']) {
							unset($modellist[$k]);
						}
					}
					if(empty($modellist)) {
						showmessage(L('site_have_no_model').L('deny_register'), HTTP_REFERER);
					}

					$modelid = 10; //設定默認值
					if(array_key_exists($modelid, $modellist)) {
						//獲取會員模型表單
						require CACHE_MODEL_PATH.'member_form.class.php';
						$member_form = new member_form($modelid);
						$this->db->set_model($modelid);
						$forminfos = $forminfos_arr = $member_form->get();

						//萬能字段過濾
						foreach($forminfos as $field=>$info) {
							if($info['isomnipotent']) {
								unset($forminfos[$field]);
							} else {
								if($info['formtype']=='omnipotent') {
									foreach($forminfos_arr as $_fm=>$_fm_value) {
										if($_fm_value['isomnipotent']) {
											$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'], $info['form']);
										}
									}
									$forminfos[$field]['form'] = $info['form'];
								}
							}
						}

						$formValidator = $member_form->formValidator;
					}
					include template('member', 'connect');
				}
			} else {
				showmessage(L('login_failure'), 'index.php?m=member&c=index&a=login');
			}
		} else {
			$oauth_callback = APP_PATH.'index.php?m=member&c=index&a=public_qq_login&callback=1';
			$oauth_nonce = md5(SYS_TIME);
			$oauth_signature_method = 'HMAC-SHA1';
			$oauth_timestamp = SYS_TIME;
			$oauth_version = '1.0';

			$url = "https://open.t.qq.com/cgi-bin/request_token?oauth_callback=$oauth_callback&oauth_consumer_key=".QQ_AKEY."&oauth_nonce=$oauth_nonce&oauth_signature=".QQ_SKEY."&oauth_signature_method=HMAC-SHA1&oauth_timestamp=$oauth_timestamp&oauth_version=$oauth_version";
			$o = new WeiboOAuth(QQ_AKEY, QQ_SKEY);

			$keys = $o->getRequestToken(array('callback'=>$oauth_callback));
			$_SESSION['keys'] = $keys;
			$aurl = $o->getAuthorizeURL($keys['oauth_token'] ,false , $oauth_callback);

			include template('member', 'connect_qq');
		}

	}


	//QQ登錄功能
	public function public_qq_login2(){
                $appid = pc_base::load_config('system', 'qq_appid');
                $appkey = pc_base::load_config('system', 'qq_appkey');
                $callback = pc_base::load_config('system', 'qq_callback');
                pc_base::load_app_class('qqapi','',0);
                $info = new qqapi($appid,$appkey,$callback);
                $this->_session_start();
                if(!isset($_GET['oauth_token'])){
                        $info->redirect_to_login();
                }else{
                        $info->get_openid();
                        if(!empty($_SESSION['openid'])){
                                $r = $this->db->get_one(array('connectid'=>$_SESSION['openid'],'from'=>'qq'));
                                if(!empty($r)){
                                        //登陸
                                        $password = $r['password'];
                                        $this->_init_phpsso();
                                        $synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
                                        $userid = $r['userid'];
                                        $groupid = $r['groupid'];
                                        $username = $r['username'];
                                        $nickname = empty($r['nickname']) ? $username : $r['nickname'];
                                        $this->db->update(array('lastip'=>ip(), 'lastdate'=>SYS_TIME, 'nickname'=>$me['name']), array('userid'=>$userid));
                                        if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
                                        $_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime: 0);
                                        $cookietime = $_cookietime ? TIME + $_cookietime : 0;
                                        $phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
                                        $phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);
                                        param::set_cookie('auth', $phpcms_auth, $cookietime);
                                        param::set_cookie('_userid', $userid, $cookietime);
                                        param::set_cookie('_username', $username, $cookietime);
                                        param::set_cookie('_groupid', $groupid, $cookietime);
                                        param::set_cookie('cookietime', $_cookietime, $cookietime);
                                        param::set_cookie('_nickname', $nickname, $cookietime);
                                        $forward = isset($_GET['forward']) && !empty($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index';
                                        showmessage(L('login_success').$synloginstr, $forward);
                                }else{
                                        $user = $info->get_user_info();
                                        $_SESSION['connectid'] = $_SESSION['openid'];
                                        $_SESSION['from'] = 'qq';
                                        $connect_username = $user['nickname'];
                                        include template('member', 'connect');
                                }
                        }
                }
        }
	/**
	 * 找回密碼
	 * 新增加短信找回方式
	 */
	public function public_forget_password () {

		$email_config = getcache('common', 'commons');

		//SMTP MAIL 二種發送模式
 		if($email_config['mail_type'] == '1'){
			if(empty($email_config['mail_user']) || empty($email_config['mail_password'])) {
				showmessage(L('email_config_empty'), HTTP_REFERER);
			}
		}
		$this->_session_start();
		$member_setting = getcache('member_setting');
		if(isset($_POST['dosubmit'])) {
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}

			$memberinfo = $this->db->get_one(array('email'=>$_POST['email']));
			if(!empty($memberinfo['email'])) {
				$email = $memberinfo['email'];
			} else {
				showmessage(L('email_error'), HTTP_REFERER);
			}

			pc_base::load_sys_func('mail');
			$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);

			$code = sys_auth($memberinfo['userid']."\t".SYS_TIME, 'ENCODE', $phpcms_auth_key);

			$url = APP_PATH."index.php?m=member&c=index&a=public_forget_password&code=$code";
			$message = $member_setting['forgetpassword'];
			$message = str_replace(array('{click}','{url}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url), $message);
			//獲取站點名稱
			$sitelist = getcache('sitelist', 'commons');

			if(isset($sitelist[$memberinfo['siteid']]['name'])) {
				$sitename = $sitelist[$memberinfo['siteid']]['name'];
			} else {
				$sitename = 'PHPCMS_V9_MAIL';
			}
			sendmail($email, L('forgetpassword'), $message, '', '', $sitename);
			showmessage(L('operation_success'), 'index.php?m=member&c=index&a=login');
		} elseif($_GET['code']) {
			$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key'));
			$hour = date('y-m-d h', SYS_TIME);
			$code = sys_auth($_GET['code'], 'DECODE', $phpcms_auth_key);
			$code = explode("\t", $code);

			if(is_array($code) && is_numeric($code[0]) && date('y-m-d h', SYS_TIME) == date('y-m-d h', $code[1])) {
				$memberinfo = $this->db->get_one(array('userid'=>$code[0]));
				
				if(empty($memberinfo['phpssouid'])) {
					showmessage(L('operation_failure'), 'index.php?m=member&c=index&a=login');
				}
				$updateinfo = array();
				$password = random(8,"23456789abcdefghkmnrstwxy");
				$updateinfo['password'] = password($password, $memberinfo['encrypt']);
				
				$this->db->update($updateinfo, array('userid'=>$code[0]));
				if(pc_base::load_config('system', 'phpsso')) {
					//初始化phpsso
					$this->_init_phpsso();
					$this->client->ps_member_edit('', $email, '', $password, $memberinfo['phpssouid'], $memberinfo['encrypt']);
				}
				$email = $memberinfo['email'];
				//獲取站點名稱
				$sitelist = getcache('sitelist', 'commons');		
				if(isset($sitelist[$memberinfo['siteid']]['name'])) {
					$sitename = $sitelist[$memberinfo['siteid']]['name'];
				} else {
					$sitename = 'PHPCMS_V9_MAIL';
				}
				pc_base::load_sys_func('mail');
				sendmail($email, L('forgetpassword'), "New password:".$password, '', '', $sitename);
				showmessage(L('operation_success').L('newpassword').':'.$password);

			} else {
				showmessage(L('operation_failure'), 'index.php?m=member&c=index&a=login');
			}

		} else {
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);

			include template('member', 'forget_password');
		}
	}

	/**
	*通過手機修改密碼
	*方式：用戶發送HHPWD afei985#821008 至 1065788 ，PHPCMS進行轉發到網站運營者指定的回調地址，在回調地址程序進行密碼修改等操作,處理成功時給用戶發條短信確認。
	*phpcms 以POST方式傳遞相關數據到回調程序中
	*要求：網站中會員系統，mobile做為主表字段，並且唯一（如已經有手機號碼，把號碼字段轉為主表字段中）
	*/

	public function public_changepwd_bymobile(){
		$phone = $_REQUEST['phone'];
		$msg = $_REQUEST['msg'];
		$sms_key = $_REQUEST['sms_passwd'];
		$sms_pid = $_REQUEST['sms_pid'];
		if(empty($phone) || empty($msg) || empty($sms_key) || empty($sms_pid)){
			return false;
		}
		if(!preg_match('/^1([0-9]{9})/',$phone)) {
			return false;
		}
		//判斷是否PHPCMS請求的接口
		pc_base::load_app_func('global','sms');
		pc_base::load_app_class('smsapi', 'sms', 0);
		$this->sms_setting_arr = getcache('sms');
		$siteid = $_REQUEST['siteid'] ? $_REQUEST['siteid'] : 1;
		if(!empty($this->sms_setting_arr[$siteid])) {
			$this->sms_setting = $this->sms_setting_arr[$siteid];
		} else {
			$this->sms_setting = array('userid'=>'', 'productid'=>'', 'sms_key'=>'');
		}
		if($sms_key != $this->sms_setting['sms_key'] || $sms_pid != $this->sms_setting['productid']){
			return false;
		}
		//取用戶名
		$msg_array = explode("@@",$str);
		$newpwd = $msg_array[1];
		$username = $msg_array[2];
		$array = $this->db->get_one(array('mobile'=>$phone,'username'=>$username));
		if(empty($array)){
			echo 1;
		}else{
			$result = $this->db->update(array('password'=>$newpwd),array('mobile'=>$phone,'username'=>$username));
			if($result){
				//修改成功，發送短信給用戶回執
 				//檢查短信余額
				if($this->sms_setting['sms_key']) {
					$smsinfo = $this->smsapi->get_smsinfo();
				}
				if($smsinfo['surplus'] < 1) {
 					echo 1;
				}else{
 					$this->smsapi = new smsapi($this->sms_setting['userid'], $this->sms_setting['productid'], $this->sms_setting['sms_key']);
					$content = '你好,'.$username.',你的新密碼已經修改成功：'.$newpwd.' ,請妥善保存！';
					$return = $this->smsapi->send_sms($phone, $content, SYS_TIME, CHARSET);
					echo 1;
				}
 			}
		}
	}

	/**
	 * 手機短信方式找回密碼
	 */
	public function public_forget_password_mobile () {
 		$email_config = getcache('common', 'commons');
		$this->_session_start();
		$member_setting = getcache('member_setting');
		if(isset($_POST['dosubmit'])) {
		//處理提交申請，以手機號為準
			if ($_SESSION['code'] != strtolower($_POST['code'])) {
				showmessage(L('code_error'), HTTP_REFERER);
			}
			$mobile = $_POST['mobile'];
			$mobile_verify = intval($_POST['mobile_verify']);
			$password = $_POST['password'];
			$pwdconfirm = $_POST['pwdconfirm'];
			if($password != $pwdconfirm){
				showmessage(L('passwords_not_match'), HTTP_REFERER);
			}
			//驗證手機號和傳遞的驗證碼是否匹配
			$sms_report_db = pc_base::load_model('sms_report_model');
			$sms_report_array = $sms_report_db->get_one(array("mobile">$mobile,'in_code'=>$mobile_verify));
			if(empty($sms_report_array)){
				showmessage("手機和驗證碼不對應，請通過正常渠道修改密碼！", HTTP_REFERER);
			}
			//更新密碼
			$updateinfo = array();
			$updateinfo['password'] = $password;
 			$this->db->update($updateinfo, array('userid'=>$this->memberinfo['userid']));
			if(pc_base::load_config('system', 'phpsso')) {
				//初始化phpsso
				$this->_init_phpsso();
				$res = $this->client->ps_member_edit('', $email, $_POST['info']['password'], $_POST['info']['newpassword'], $this->memberinfo['phpssouid'], $this->memberinfo['encrypt']);
			}



			$memberinfo = $this->db->get_one(array('email'=>$_POST['email']));
			if(!empty($memberinfo['email'])) {
				$email = $memberinfo['email'];
			} else {
				showmessage(L('email_error'), HTTP_REFERER);
			}

			pc_base::load_sys_func('mail');
			$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);

			$code = sys_auth($memberinfo['userid']."\t".SYS_TIME, 'ENCODE', $phpcms_auth_key);

			$url = APP_PATH."index.php?m=member&c=index&a=public_forget_password&code=$code";
			$message = $member_setting['forgetpassword'];
			$message = str_replace(array('{click}','{url}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url), $message);
			//獲取站點名稱
			$sitelist = getcache('sitelist', 'commons');

			if(isset($sitelist[$memberinfo['siteid']]['name'])) {
				$sitename = $sitelist[$memberinfo['siteid']]['name'];
			} else {
				$sitename = 'PHPCMS_V9_MAIL';
			}
			sendmail($email, L('forgetpassword'), $message, '', '', $sitename);
			showmessage(L('operation_success'), 'index.php?m=member&c=index&a=login');
		} else {
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
			$siteinfo = siteinfo($siteid);
 			include template('member', 'forget_password_mobile');
		}
	}

	public function ajax_login() {

		//$_GET['forward'] = siteurl(1).'/index.php';
		//print_r( $_GET['forward']  );

		$this->_session_start();
		//獲取用戶siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定義站點id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}

		
		if(empty($_SESSION['connectid'])) {
			//判斷驗證碼
			$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : ajax_showmessage(1, L('input_code'), HTTP_REFERER);
			if ($_SESSION['code'] != strtolower($code)) {
				ajax_showmessage(1, L('code_error'), HTTP_REFERER);
			}
		}
		

		$username = isset($_POST['username']) && trim($_POST['username']) ? trim($_POST['username']) : ajax_showmessage(1, L('username_empty'), HTTP_REFERER);
		$password = isset($_POST['password']) && trim($_POST['password']) ? trim($_POST['password']) : ajax_showmessage(1, L('password_empty'), HTTP_REFERER);
		$avatar = (isset($_POST['connect_avatar']) && intval($_POST['connect_avatar'])) ? (isset($_SESSION['avatar']) ? $_SESSION['avatar'] : '') : '';
		


		$cookietime = intval($_POST['cookietime']);
		$synloginstr = ''; //同步登陸js代碼

		if(pc_base::load_config('system', 'phpsso')) {
			$this->_init_phpsso();
			$status = $this->client->ps_member_login($username, $password);
			$memberinfo = unserialize($status);

			if(isset($memberinfo['uid'])) {

				
				if( !empty($avatar)  ){//頭像信息
					$mem_model = pc_base::load_model('member_model');
					//$mem_model->set_model();
					$avatar_data['avatar'] = $avatar;
					$mem_model->update( $avatar_data, '`userid`='.$memberinfo['uid']  );
				}


				//查詢帳號
				$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
				//print_r($r);
				//echo "test";

				if(!$r) {
					//插入會員詳細信息，會員不存在 插入會員
					$info = array(
								'phpssouid'=>$memberinfo['uid'],
								'username'=>$memberinfo['username'],
								'password'=>$memberinfo['password'],
								'encrypt'=>$memberinfo['random'],
								'email'=>$memberinfo['email'],
								'regip'=>$memberinfo['regip'],
								'regdate'=>$memberinfo['regdate'],
								'lastip'=>$memberinfo['lastip'],
								'lastdate'=>$memberinfo['lastdate'],
								'groupid'=>$this->_get_usergroup_bypoint(),	//會員默認組
								'modelid'=>10,	//普通會員
								);

					//如果是connect用戶
					if(!empty($_SESSION['connectid'])) {
						$userinfo['connectid'] = $_SESSION['connectid'];
					}
					if(!empty($_SESSION['from'])) {
						$userinfo['from'] = $_SESSION['from'];
					}
					unset($_SESSION['connectid'], $_SESSION['from']);

					$this->db->insert($info);
					unset($info);
					$r = $this->db->get_one(array('phpssouid'=>$memberinfo['uid']));
				}
				$password = $r['password'];
				$synloginstr = $this->client->ps_member_synlogin($r['phpssouid']);
			} else {
				if($status == -1) {	//用戶不存在
					//ajax_showmessage(1, L('user_not_exist'), 'index.php?m=member&c=index&a=login');
					ajax_showmessage(1, L('user_not_exist'), 'index.php');
				} elseif($status == -2) { //密碼錯誤
					//ajax_showmessage(1, L('password_error'), 'index.php?m=member&c=index&a=login');
					ajax_showmessage(1, L('password_error'), 'index.php');
				} else {
					//ajax_showmessage(1, L('login_failure'), 'index.php?m=member&c=index&a=login');
					ajax_showmessage(1, L('login_failure'), 'index.php');
				}
			}

		} else {
			//密碼錯誤剩余重試次數
			$this->times_db = pc_base::load_model('times_model');
			$rtime = $this->times_db->get_one(array('username'=>$username));
			if($rtime['times'] > 4) {
				$minute = 60 - floor((SYS_TIME - $rtime['logintime']) / 60);
				ajax_showmessage(1, L('wait_1_hour', array('minute'=>$minute)));
			}

			//查詢帳號
			$r = $this->db->get_one(array('username'=>$username));

			//if(!$r) ajax_showmessage(1, L('user_not_exist'),'index.php?m=member&c=index&a=login');
			if(!$r) ajax_showmessage(1, L('user_not_exist'),'index.php');

			//驗證用戶密碼
			$password = md5(md5(trim($password)).$r['encrypt']);
			if($r['password'] != $password) {
				$ip = ip();
				if($rtime && $rtime['times'] < 5) {
					$times = 5 - intval($rtime['times']);
					$this->times_db->update(array('ip'=>$ip, 'times'=>'+=1'), array('username'=>$username));
				} else {
					$this->times_db->insert(array('username'=>$username, 'ip'=>$ip, 'logintime'=>SYS_TIME, 'times'=>1));
					$times = 5;
				}
				//ajax_showmessage(1, L('password_error', array('times'=>$times)), 'index.php?m=member&c=index&a=login', 3000);
				ajax_showmessage(1, L('password_error', array('times'=>$times)), 'index.php', 3000);
			}
			$this->times_db->delete(array('username'=>$username));
		}

		//如果用戶被鎖定
		if($r['islock']) {
			ajax_showmessage(1, L('user_is_lock'));
		}

		$userid = $r['userid'];
		$groupid = $r['groupid'];
		$username = $r['username'];
		$nickname = empty($r['nickname']) ? $username : $r['nickname'];

		$updatearr = array('lastip'=>ip(), 'lastdate'=>SYS_TIME);
		//vip過期，更新vip和會員組
		if($r['overduedate'] < SYS_TIME) {
			$updatearr['vip'] = 0;
		}

		//檢查用戶積分，更新新用戶組，除去郵箱認證、禁止訪問、遊客組用戶、vip用戶，如果該用戶組不允許自助升級則不進行該操作
		if($r['point'] >= 0 && !in_array($r['groupid'], array('1', '7', '8')) && empty($r[vip])) {
			$grouplist = getcache('grouplist');
			if(!empty($grouplist[$r['groupid']]['allowupgrade'])) {
				$check_groupid = $this->_get_usergroup_bypoint($r['point']);

				if($check_groupid != $r['groupid']) {
					$updatearr['groupid'] = $groupid = $check_groupid;
				}
			}
		}

		//如果是connect用戶
		if(!empty($_SESSION['connectid'])) {
			$updatearr['connectid'] = $_SESSION['connectid'];
		}
		if(!empty($_SESSION['from'])) {
			$updatearr['from'] = $_SESSION['from'];
		}
		unset($_SESSION['connectid'], $_SESSION['from']);

		$this->db->update($updatearr, array('userid'=>$userid));

		if(!isset($cookietime)) {
			$get_cookietime = param::get_cookie('cookietime');
		}
		$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
		$cookietime = $_cookietime ? SYS_TIME + $_cookietime : 0;

		$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
		$phpcms_auth = sys_auth($userid."\t".$password, 'ENCODE', $phpcms_auth_key);

		param::set_cookie('auth', $phpcms_auth, $cookietime);
		param::set_cookie('_userid', $userid, $cookietime);
		param::set_cookie('_username', $username, $cookietime);
		param::set_cookie('_groupid', $groupid, $cookietime);
		param::set_cookie('_nickname', $nickname, $cookietime);
		//param::set_cookie('cookietime', $_cookietime, $cookietime);
		//$forward = isset($_POST['forward']) && !empty($_POST['forward']) ? urldecode($_POST['forward']) : 'index.php?m=member&c=index';
		$forward = isset($_POST['forward']) && !empty($_POST['forward']) ? urldecode($_POST['forward']) : 'index.php';
		ajax_showmessage(0, L('login_success').$synloginstr, $forward);
	}

	public function ajax_logout() {
		$setting = pc_base::load_config('system');
		//snda退出
		if($setting['snda_enable'] && param::get_cookie('_from')=='snda') {
			param::set_cookie('_from', '');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? urlencode($_GET['forward']) : '';
			$logouturl = 'https://cas.sdo.com/cas/logout?url='.urlencode(APP_PATH.'index.php?m=member&c=index&a=logout&forward='.$forward);
			header('Location: '.$logouturl);
		} else {
			$synlogoutstr = '';	//同步退出js代碼
			if(pc_base::load_config('system', 'phpsso')) {
				$this->_init_phpsso();
				$synlogoutstr = $this->client->ps_member_synlogout();
			}

			param::set_cookie('auth', '');
			param::set_cookie('_userid', '');
			param::set_cookie('_username', '');
			param::set_cookie('_groupid', '');
			param::set_cookie('_nickname', '');
			param::set_cookie('cookietime', '');
			$forward = isset($_GET['forward']) && trim($_GET['forward']) ? $_GET['forward'] : 'index.php?m=member&c=index&a=login';

			if( $_GET['code']  ){
				$_GET['forward'] = siteurl(1).'/index.php';
			}
			ajax_showmessage(0, L('logout_success').$synlogoutstr, $forward);
		}
	}

	public function ajax_register() {
		$this->_session_start();
		//獲取用戶siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		//定義站點id常量
		if (!defined('SITEID')) {
		   define('SITEID', $siteid);
		}

		//加載用戶模塊配置
		$member_setting = getcache('member_setting');
		if(!$member_setting['allowregister']) {
			ajax_showmessage(1, L('deny_register'), 'index.php?m=member&c=index&a=login');
		}
		//加載短信模塊配置
 		$sms_setting_arr = getcache('sms','sms');
		$sms_setting = $sms_setting_arr[$siteid];

		header("Cache-control: private");
		
		if($member_setting['enablcodecheck']=='1'){//開啟驗證碼
			if (empty($_SESSION['connectid']) && $_SESSION['code'] != strtolower($_POST['code'])) {
				ajax_showmessage(1, L('code_error'));
			}
		}

		$userinfo = array();
		$userinfo['encrypt'] = create_randomstr(6);

		$userinfo['username'] = (isset($_POST['username']) && is_username($_POST['username'])) ? $_POST['username'] : ajax_showmessage(1, L('username_format_incorrect'));
		$userinfo['nickname'] = (isset($_POST['nickname']) && is_username($_POST['nickname'])) ? $_POST['nickname'] : '';

		$userinfo['email'] = (isset($_POST['email']) && is_email($_POST['email'])) ? $_POST['email'] : ajax_showmessage(1, L('email_format_incorrect'));
		$userinfo['connectid'] = isset($_SESSION['connectid']) ? $_SESSION['connectid'] : '';
		$userinfo['from'] = isset($_SESSION['from']) ? $_SESSION['from'] : '';
		$userinfo['avatar'] = (isset($_POST['connect_avatar']) && intval($_POST['connect_avatar'])) ? (isset($_SESSION['avatar']) ? $_SESSION['avatar'] : '') : '';
		$userinfo['password'] = isset($_POST['password']) ? $_POST['password'] : ($userinfo['connectid']?uniqid():ajax_showmessage(1, L('password_can_not_be_empty')));

		$userinfo['modelid'] = isset($_POST['modelid']) ? intval($_POST['modelid']) : 10;
		$userinfo['regip'] = ip();
		$userinfo['point'] = $member_setting['defualtpoint'] ? $member_setting['defualtpoint'] : 0;
		$userinfo['amount'] = $member_setting['defualtamount'] ? $member_setting['defualtamount'] : 0;
		$userinfo['regdate'] = $userinfo['lastdate'] = SYS_TIME;
		$userinfo['siteid'] = $siteid;
		//手機強制驗證


		if($member_setting['mobile_checktype']=='1'){
			//取用戶手機號
			$mobile_verify = $_POST['mobile_verify'] ? intval($_POST['mobile_verify']) : '';
			if($mobile_verify=='') ajax_showmessage(1, '請提供正確的手機驗證碼！', HTTP_REFERER);
			$sms_report_db = pc_base::load_model('sms_report_model');
			$posttime = SYS_TIME-360;
			$where = "`id_code`='$mobile_verify' AND `posttime`>'$posttime'";
			$r = $sms_report_db->get_one($where,'*','id DESC');
			if(!empty($r)){
				$userinfo['mobile'] = $r['mobile'];
			}else{
				ajax_showmessage(1, '未檢測到正確的手機號碼！', HTTP_REFERER);
			}
		}elseif($member_setting['mobile_checktype']=='2'){
			//獲取驗證碼，直接通過POST，取mobile值
			$userinfo['mobile'] = isset($_POST['mobile']) ? $_POST['mobile'] : '';
		}
		if($userinfo['mobile']!=""){
			if(!preg_match('/^1([0-9]{9})/',$userinfo['mobile'])) {
				ajax_showmessage(1, '請提供正確的手機號碼！', HTTP_REFERER);
			}
		}
		unset($_SESSION['connectid'], $_SESSION['from']);

		if($member_setting['enablemailcheck']) {	//是否需要郵件驗證
			$userinfo['groupid'] = 7;
		} elseif($member_setting['registerverify']) {	//是否需要管理員審核
			$userinfo['modelinfo'] = isset($_POST['info']) ? array2string($_POST['info']) : '';
			$this->verify_db = pc_base::load_model('member_verify_model');
			unset($userinfo['lastdate'],$userinfo['connectid'],$userinfo['from']);
			$userinfo = array_map('htmlspecialchars',$userinfo);
			$this->verify_db->insert($userinfo);
			ajax_showmessage(0, L('operation_success'), 'index.php?m=member&c=index&a=register&t=3');
		} else {
			//查看當前模型是否開啟了短信驗證功能
			$model_field_cache = getcache('model_field_'.$userinfo['modelid'],'model');
			if(isset($model_field_cache['mobile']) && $model_field_cache['mobile']['disabled']==0) {
				$mobile = $_POST['info']['mobile'];
				if(!preg_match('/^1([0-9]{10})/',$mobile)) ajax_showmessage(1, L('input_right_mobile'));
				$sms_report_db = pc_base::load_model('sms_report_model');
				$posttime = SYS_TIME-300;
				$where = "`mobile`='$mobile' AND `posttime`>'$posttime'";
				$r = $sms_report_db->get_one($where);
				if(!$r || $r['id_code']!=$_POST['mobile_verify']) ajax_showmessage(1, L('error_sms_code'));
			}
			$userinfo['groupid'] = $this->_get_usergroup_bypoint($userinfo['point']);
		}

		//echo "test";
	
		//print_r( $userinfo );	
		//exit();

		if(pc_base::load_config('system', 'phpsso')) {
			$this->_init_phpsso();
			$status = $this->client->ps_member_register($userinfo['username'], $userinfo['password'], $userinfo['email'], $userinfo['regip'], $userinfo['encrypt']);
			if($status > 0) {
				$userinfo['phpssouid'] = $status;
				//傳入phpsso為明文密碼，加密後存入phpcms_v9
				$password = $userinfo['password'];
				$userinfo['password'] = password($userinfo['password'], $userinfo['encrypt']);
				$userid = $this->db->insert($userinfo, 1);
				//echo 'asadsda'.$userid;
				//exit();
				if($member_setting['choosemodel']) {	//如果開啟選擇模型
					//通過模型獲取會員信息
					require_once CACHE_MODEL_PATH.'member_input.class.php';
					require_once CACHE_MODEL_PATH.'member_update.class.php';
					$member_input = new member_input($userinfo['modelid']);

					$_POST['info'] = array_map('htmlspecialchars',$_POST['info']);
					$user_model_info = $member_input->get($_POST['info']);
					$user_model_info['userid'] = $userid;

					//插入會員模型數據
					$this->db->set_model($userinfo['modelid']);
					$this->db->insert($user_model_info);
				}

				if($userid > 0) {
					//執行登陸操作
					if(!$cookietime) $get_cookietime = param::get_cookie('cookietime');
					$_cookietime = $cookietime ? intval($cookietime) : ($get_cookietime ? $get_cookietime : 0);
					$cookietime = $_cookietime ? TIME + $_cookietime : 0;

					if($userinfo['groupid'] == 7) {
						param::set_cookie('_username', $userinfo['username'], $cookietime);
						param::set_cookie('email', $userinfo['email'], $cookietime);
					} else {
						$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key').$this->http_user_agent);
						$phpcms_auth = sys_auth($userid."\t".$userinfo['password'], 'ENCODE', $phpcms_auth_key);

						param::set_cookie('auth', $phpcms_auth, $cookietime);
						param::set_cookie('_userid', $userid, $cookietime);
						param::set_cookie('_username', $userinfo['username'], $cookietime);
						param::set_cookie('_nickname', $userinfo['nickname'], $cookietime);
						param::set_cookie('_groupid', $userinfo['groupid'], $cookietime);
						param::set_cookie('cookietime', $_cookietime, $cookietime);
					}
				}
				//如果需要郵箱認證
				if($member_setting['enablemailcheck']) {
					pc_base::load_sys_func('mail');
					$phpcms_auth_key = md5(pc_base::load_config('system', 'auth_key'));
					$code = sys_auth($userid.'|'.$phpcms_auth_key, 'ENCODE', $phpcms_auth_key);
					$url = APP_PATH."index.php?m=member&c=index&a=register&code=$code&verify=1";
					$message = $member_setting['registerverifymessage'];
					$message = str_replace(array('{click}','{url}','{username}','{email}','{password}'), array('<a href="'.$url.'">'.L('please_click').'</a>',$url,$userinfo['username'],$userinfo['email'],$password), $message);
					sendmail($userinfo['email'], L('reg_verify_email'), $message);
					//設置當前注冊賬號COOKIE，為第二步重發郵件所用
					param::set_cookie('_regusername', $userinfo['username'], $cookietime);
					param::set_cookie('_reguserid', $userid, $cookietime);
					param::set_cookie('_reguseruid', $userinfo['phpssouid'], $cookietime);
					ajax_showmessage(0, L('operation_success'), 'index.php?m=member&c=index&a=register&t=2');
				} else {
					//如果不需要郵箱認證、直接登錄其他應用
					$synloginstr = $this->client->ps_member_synlogin($userinfo['phpssouid']);
					ajax_showmessage(0, L('operation_success').$synloginstr, 'index.php?m=member&c=index&a=init');
				}

			}
		} else {
			ajax_showmessage(1, L('enable_register').L('enable_phpsso'), 'index.php?m=member&c=index&a=login');
		}
		ajax_showmessage(1, L('operation_failure'), HTTP_REFERER);
	}
}
?>
