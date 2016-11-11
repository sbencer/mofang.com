<?php
/**
 * 
 * ----------------------------
 * ku6api class
 * ----------------------------
 * 
 * An open source application development framework for PHP 5.0 or newer
 * 
 * 這是個接口類，主要負責視頻模型跟ku6vms之間的通信
 * @package	PHPCMS V9.1.16
 * @author		chenxuewang
 * @copyright	CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 *
 */

class ku6api {
	public $ku6api_sn, $ku6api_key;
	private $ku6api_url,$http,$xxtea;
	
	/**
	 * 
	 * 構造方法 初始化用戶身份識別碼、加密密鑰等
	 * @param string $ku6api_skey vms系統中的身份識別碼
	 * @param string $ku6api_sn vms系統中配置的通信加密密鑰
	 * 
	 */
	public function __construct($ku6api_sn = '', $ku6api_skey = '') {
		$this->ku6api_skey = $ku6api_skey;
		$this->ku6api_sn = $ku6api_sn;
		if (!$this->ku6api_sn) {
			$this->set_sn();
		}
		$this->ku6api_url = pc_base::load_config('ku6server', 'api_url');
		$this->ku6api_api = pc_base::load_config('ku6server', 'api');
		$this->http = pc_base::load_sys_class('http');
		$this->xxtea = pc_base::load_app_class('xxtea', 'video');
		
	}

	/**
	 * 
	 * 設置身份識別碼及身份密鑰
	 * 
	 */
	private function set_sn() {
		//獲取短信平台配置信息
		$setting = getcache('video', 'video');
		if ($setting['sn'] && $setting['skey']) {
			$this->ku6api_skey = $setting['skey'];
			$this->ku6api_sn = $setting['sn'];
		}
	}
	
	/**
	 * 
	 * vms_add 視頻添加方法 系統中添加視頻是調用，同步添加到vms系統中
	 * @param array $data 添加是視頻信息 視頻標題、介紹等
	 */
	public function vms_add($data = array()) {
		if (is_array($data) && !empty($data)) {
			//處理數據
			$data['tag'] = $this->get_tag($data);
			$data['v'] = 1;
			$data['channelid'] = $data['channelid'] ? intval($data['channelid']) : 1;
			//將gbk編碼轉為utf-8編碼
			if (CHARSET == 'gbk') {
				$data = array_iconv($data);
			}
			$data['sn'] = $this->ku6api_sn;
			$data['method'] = 'VideoAdd';
			$data['posttime'] = SYS_TIME;
			$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
			//向vms post數據，並獲取返回值
			$this->http->post($this->ku6api_url, $data);
			$get_data = $this->http->get_data();
			$get_data = json_decode($get_data, true);
			if($get_data['code'] != 200) {
				$this->error_msg = $get_data['msg'];
				return false;
			}
			return $get_data;
			
		} else {
			$this->error_msg = '';
			return false; 
		}
	}
	
	/**
	 * function vms_edit
	 * 視頻編輯時調用 視頻改變時同步更新vms系統中對應的視頻
	 * @param array $data
	 */
	public function vms_edit($data = array()) {
		if (is_array($data ) && !empty($data)) {
			//處理數據
			$data['tag'] = $this->get_tag($data);
			//將gbk編碼轉為utf-8編碼
			if (CHARSET == 'gbk') {
				$data = array_iconv($data);
			}
			$data['sn'] = $this->ku6api_sn;
			$data['method'] = 'VideoEdit';
			$data['posttime'] = SYS_TIME;
			$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
			//向vms post數據，並獲取返回值
			$this->http->post($this->ku6api_url, $data);
			$get_data = $this->http->get_data();
			$get_data = json_decode($get_data, true);
			if($get_data['code'] != 200) {
				$this->error_msg = $get_data['msg'];
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * function delete_v
	 * 刪除視頻時，通知vms系統接口。
	 * @param string $ku6vid vms系統中ku6vid
	 */
	public function delete_v($ku6vid = '') {
		if (!$ku6vid) return false;
		//構造post數據
		$data['sn'] = $this->ku6api_sn;
		$data['method'] = 'VideoDel';
		$data['posttime'] = SYS_TIME;
		$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
		$data['vid'] = $ku6vid;
		//向vms post數據
		$this->http->post($this->ku6api_url, $data);
		$get_data = $this->http->get_data();
		$get_data = json_decode($get_data, true);
		if($get_data['code'] != 200 && $get_data['code']!=112) {
			$this->error_msg = $get_data['msg'];
			return false;
		}
		return true;
	}
	/**
	 * 
	 * 獲取視頻tag標簽
	 * @param array $data 視頻信息數組
	 * @return string $tag 標簽
	 */
	private function get_tag($data = array()) {
		if (is_array($data) && !empty($data)) {
			if ($data['keywords']) $tag = trim(strip_tags($data['keywords']));
			else $tag = $data['title'];
			return $tag;
		}
	}
	
	/**
	 * function update_video_status_from_vms
	 * 視頻狀態改變接口
	 * @param array $get 視頻信息
	 */
	public function update_video_status_from_vms() {
		if (is_array($_GET) && !empty($_GET)) {
			$size = $_GET['size'];
			$timelen = intval($_GET['timelen']);
			$status = intval($_GET['ku6status']);
			$vid = $_GET['vid'];
			$picpath = format_url($_GET['picpath']);
			//驗證數據
			/* 驗證vid */
			if(!$vid) return json_encode(array('status'=>'101','msg'=>'vid not allowed to be empty'));
			/* 驗證視頻大小 */
			if($size<100) return json_encode(array('status'=>'103','msg'=>'size incorrect'));
			/* 驗證視頻時長 */
			if($timelen<1) return json_encode(array('status'=>'104','msg'=>'timelen incorrect'));
			
			$db = pc_base::load_model('video_store_model');
			$r = $db->get_one(array('vid'=>$vid));
			if ($r) {
				$db->update(array('size'=>$size, 'picpath'=>$picpath, 'status'=>$status), array('vid'=>$vid));
				if ($status==21) {
					$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
					$videoid = $r['videoid'];
					/**
					 * 加載視頻內容對應關系數據模型，檢索與刪除視頻相關的內容。
					 * 在對應關系表中找出對應的內容id，並更新內容的靜態頁
					 */
					$video_content_db = pc_base::load_model('video_content_model');
					$result = $video_content_db->select(array('videoid'=>$videoid));
					if (is_array($result) && !empty($result)) {
						//加載更新html類
						$html = pc_base::load_app_class('html', 'content');
						$content_db = pc_base::load_model('content_model');
						$url = pc_base::load_app_class('url', 'content');
						foreach ($result as $rs) {
							$modelid = intval($rs['modelid']);
							$contentid = intval($rs['contentid']);
							$content_db->set_model($modelid);
							$content_db->update(array('status'=>99), array('id'=>$contentid));
							$table_name = $content_db->table_name;
							$r1 = $content_db->get_one(array('id'=>$contentid));
							/**
							 * 判斷如果內容頁生成了靜態頁，則更新靜態頁
							 */
							if (ishtml($r1['catid'])) {
								$content_db->table_name = $table_name.'_data';
								$r2 = $content_db->get_one(array('id'=>$contentid));
								$r = array_merge($r1, $r2);unset($r1, $r2);
								if($r['upgrade']) {
									$urls[1] = $r['url'];
								} else {
									$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
								}
								$html->show($urls[1], $r, 0, 'edit');
							} else {
								continue;
							}
						}
					}
				} elseif ($data['status']<0 || $data['status']==24) {
					$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
					$videoid = $r['videoid'];
					//$video_store_db->delete(array('vid'=>$vid)); //刪除此視頻
					/**
					 * 加載視頻內容對應關系數據模型，檢索與刪除視頻相關的內容。
					 * 在對應關系表中解除關系，並更新內容的靜態頁
					 */
					$video_content_db = pc_base::load_model('video_content_model');
					$result = $video_content_db->select(array('videoid'=>$videoid));
					if (is_array($result) && !empty($result)) {
						//加載更新html類
						$html = pc_base::load_app_class('html', 'content');
						$content_db = pc_base::load_model('content_model');
						$url = pc_base::load_app_class('url', 'content');
						foreach ($result as $rs) {
							$modelid = intval($rs['modelid']);
							$contentid = intval($rs['contentid']);
							$video_content_db->delete(array('videoid'=>$videoid, 'contentid'=>$contentid, 'modelid'=>$modelid));
							$content_db->set_model($modelid);
							$table_name = $content_db->table_name;
							$r1 = $content_db->get_one(array('id'=>$contentid));
							/**
							 * 判斷如果內容頁生成了靜態頁，則更新靜態頁
							 */
							if (ishtml($r1['catid'])) {
								$content_db->table_name = $table_name.'_data';
								$r2 = $content_db->get_one(array('id'=>$contentid));
								$r = array_merge($rs, $r2);unset($r1, $r2);
								if($r['upgrade']) {
									$urls[1] = $r['url'];
								} else {
									$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
								}
								$html->show($urls[1], $r, 0, 'edit');
							} else {
								continue;
							}
						}
					}
				}
				return json_encode(array('status'=>'200','msg'=>'Success'));
			} else {
				return json_encode(array('status'=>'107','msg'=>'Data is empty!'));
			}
		}
		json_encode(array('status'=>'107','msg'=>'Data is empty!'));
	}
	
	/**
	 * function get_categroys
	 * 將cms系統中視頻模型的欄目取出來，並通過接口傳到vms系統中
	 * @param bloon $isreturn 是否返回option
	 * @param int $catid 被選中的欄目 id
	 */
	public function get_categorys($isreturn = false, $catid = 0) {
		$siteid = get_siteid();
		$sitemodel_field = pc_base::load_model('sitemodel_field_model');
		$result = $sitemodel_field->select(array('formtype'=>'video', 'siteid'=>$siteid), 'modelid');
		if (is_array($result)) {
			$models = '';
			foreach ($result as $r) {
				$models .= $r['modelid'].',';
			}
		}
		$models = substr(trim($models), 0, -1);
		$cat_db = pc_base::load_model('category_model');
		if ($models) {
			$where = '`modelid` IN ('.$models.') AND `type`=0 AND `siteid`=\''.$siteid.'\'';
			$result = $cat_db->select($where, '`catid`, `catname`, `parentid`, `siteid`, `child`');
			if (is_array($result)) {
				$data = $return_data = array();
				foreach ($result as $r) {
					$sitename = $this->get_sitename($r['siteid']);
					$data[] = array('catid'=>$r['catid'], 'catname'=>$r['catname'], 'parentid'=>$r['parentid'], 'siteid'=>$r['siteid'], 'sitename'=>$sitename, 'child'=>$r['child']);
					$r['disabled'] = $r['child'] ? 'disabled' : '';
					if ($r['catid'] == $catid) { 
						$r['selected'] = 'selected';
					}
					$return_data[$r['catid']] = $r;
					
				}
				//將gbk編碼轉為utf-8編碼
				if (strtolower(CHARSET) == 'gbk') {
					$data = array_iconv($data);
				}
				$data = json_encode($data);	
				$postdata['sn'] = $this->ku6api_sn;
				$postdata['method'] = 'UserCat';
				$postdata['posttime'] = SYS_TIME;
				$postdata['token'] = $this->xxtea->encrypt($postdata['posttime'], $this->ku6api_skey);
				$postdata['data'] = $data;
				//向vms post數據，並獲取返回值
				$this->http->post($this->ku6api_url, $postdata);
				$get_data = $this->http->get_data();
				$get_data = json_decode($get_data, true);
				if($get_data['code'] != 200) {
					$this->error_msg = $get_data['msg'];
					return false;
				} elseif ($isreturn) {
					$tree = pc_base::load_sys_class('tree');
					$str  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";

					$tree->init($return_data);
					$string = $tree->get_tree(0, $str);
					return $string;
				} else {
					return true;
				}
			}
		}
		return array();
	}
	
	/**
	 * function get_ku6_channels
	 * 獲取ku6的頻道信息
	 */
	public function get_subscribetype() {
		//構造post數據
		$postdata['method'] = 'SubscribeType';
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		}
		return false;
	}
	
	/**
	 * function get_ku6_channels
	 * 獲取ku6的頻道信息
	 */
	public function get_ku6_channels() {
		//構造post數據
		$postdata['method'] = 'Ku6Channel';
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		}
		return false;
	}
	
	/**
	 * function subscribe 訂閱處理
	 * 該方法將用戶的訂閱信息post到vms裡面記錄
	 * @param array $data 推送信息 例如： array(array('channelid'=>102000, 'catid'=>16371, 'posid'=>8))
	 */
	public function subscribe($datas = array()) {
		//構造post數據
		$postdata['method'] = 'SubscribeAdd';
		$postdata['channelid'] = $datas['channelid'];
		$postdata['catid'] = $datas['catid'];
		$postdata['posid'] = $datas['posid'] ? $datas['posid'] : 0;

		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		}
		return false;
	} 

	/**
	 * function checkusersubscribe 判斷用戶是否已經訂閱
	 */
	public function checkusersubscribe($datas = array()) {
		$postdata['method'] = 'CheckUserSubscribe';
		$postdata['userid'] = $datas['userid'];

		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		}
		return false;
	}	
	
	/**
	 * function subscribe 按用戶訂閱處理
	 * 該方法將用戶的訂閱信息post到vms裡面記錄
	 * @param array $data 推送信息 例如： array(array('userid'=>102000, 'catid'=>16371, 'posid'=>8))
	 */
	public function usersubscribe($datas = array()) {
		//構造post數據
		$postdata['method'] = 'UserSubscribeAdd';
		$postdata['userid'] = $datas['userid'];
		$postdata['catid'] = $datas['catid'];
		$postdata['posid'] = $datas['posid'] ? $datas['posid'] : 0;

		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		}
		return false;
	}	
	
	/**
	 * Function sub_del 刪除訂閱
	 * 用戶刪除訂閱
	 * @param int $id 訂閱id
	 */
	public function sub_del($id = 0) {
		if (!$id) return false;
		//構造post數據
		$postdata['method'] = 'SubscribeDel';
		$postdata['sid'] = $id;
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return true;
		}
		return false;
	}
	
	/**
	 * Function user_sub_del 刪除訂閱用戶
	 * 刪除訂閱用戶
	 * @param int $id 訂閱id
	 */
	public function user_sub_del($id = 0) {
		if (!$id) return false;
		//構造post數據
		$postdata['method'] = 'UserSubscribeDel';
		$postdata['sid'] = $id;
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return true;
		}
		return false;
	}	
	
	/**
	 * fucntion get_subscribe 獲取訂閱
	 * 獲取自己的訂閱信息
	 */	
	public function get_subscribe() {
		//構造post數據
		$postdata['method'] = 'SubscribeSearch';
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		} else {
			return false;
		}
	}
	
	/**
	 * fucntion get_subscribe 獲取用戶訂閱
	 * 獲取用戶自己的訂閱信息
	 */	
	public function get_usersubscribe() {
		//構造post數據
		$postdata['method'] = 'UserSubscribeSearch';
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		} else {
			return false;
		}
	}	
	
	/**
	 * Function flashuploadparam 獲取flash上傳條屬性
	 * 獲取flash上傳條屬性
	 */
	public function flashuploadparam () {
		//構造post數據
		$postdata['method'] = 'GetFlashUploadParam';
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Function get_albums
	 * 獲取ku6專輯列表
	 * @param int $page 當前頁數
	 * @param int $pagesize 每頁數量
	 * @return array 返回專輯數組
	 */
	public function get_albums($page = 1, $pagesize = 20) {
		//構造post數據
		if ($_GET['start_time']) {
			$postdata['start_time'] = strtotime($_GET['start_time']);
		}
		if ($_GET['end_time']) {
			$postdata['end_time'] = strtotime($_GET['end_time']);
		}
		if ($_GET['keyword']) {
			$postdata['key'] = addslashes($_GET['keyword']);
		}
		if ($_GET['categoryid']) {
			$postdata['categoryid'] = intval($_GET['categoryid']);
		}
		$postdata['method'] = 'AlbumList';
		$postdata['start'] = ($page-1)*$pagesize;
		$postdata['size'] = $pagesize;
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * Function get_album_videoes
	 * 獲取某專輯下的視頻列表
	 * @param int $albumid 專輯ID
	 * @param int $page 當前頁
	 * @param int $pagesize 每頁數量
	 * @return array 視頻數組
	 */
	public function get_album_videoes($albumid = 0, $page = 1, $pagesize = 20) {
		//構造post數據
		$postdata['method'] = 'AlbumVideoList';
		$postdata['p'] = $page;
		$postdata['playlistid'] = $albumid;
		$postdata['s'] = $pagesize;
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		} else {
			return false;
		}
	}
	
	/**
	 * Function get_album_info
	 * 獲取專輯的詳細信息
	 * @param int $albumid 專輯id
	 */
	public function get_album_info($albumid = 0) {
		$albumid = intval($albumid);
		if (!$albumid) return false;
		$arr = array('method'=>'GetOneAlbum', 'id'=>$albumid);
		if ($data = $this->post($arr)) {
			return $data['list'];
		} else {
			return false;
		}
	}
	
	/**
	 * Function add_album_subscribe
	 * 添加專輯訂閱
	 * @param array $data 訂閱數組 如：array(0=>array('specialid'=>1, 'id'=>1232131), 1=>array('specialid'=>2, 'id'=>4354323))
	 */
	public function add_album_subscribe($data = array()) {
		if (!is_array($data) || empty($data)) {
			return false;
		}
		//構造post數據
		$postdata['method'] = 'AlbumVideoSubscribe';
		$postdata['data'] = $data;
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Function member_login_vms
	 * 登陸後台同時登陸vms
	 * @param array $data
	 */
	public function member_login_vms() {
		//構造post數據
		$postdata = array();
		$postdata['method'] = 'SynLogin';
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Function check_status
	 * 登陸後台同時登陸vms
	 * @param array $data
	 */
	public function check_status($vid = '') {
		if (!$vid) return false;
		//構造post數據
		$postdata = array();
		$postdata['method'] = 'VideoStatusCheck';
		$postdata['vid'] = $vid;
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * Function http
	 * 執行http post數據到接口
	 * @param array $datas post數據參數 如：array('method'=>'AlbumVideoList', 'p'=>1, 's'=>6,....)
	 */
	private function post($datas = array()) {
		//構造post數據
		$data['sn'] = $this->ku6api_sn;
		$data['posttime'] = SYS_TIME;
		$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
		if (strtolower(CHARSET) == 'gbk') {
			$datas = array_iconv($datas, 'gbk', 'utf-8');
		}
		if (is_array($datas)) {
			foreach ($datas as $_k => $d) {
				if (is_array($d)) {
					$data[$_k] = json_encode($d);
				} else {
					$data[$_k] = $d;
				}
			}
		}
		//向vms post數據，並獲取返回值
		$this->http->post($this->ku6api_url, $data);
		$get_data = $this->http->get_data();
		$get_data = json_decode($get_data, true);
		//成功時vms返回code=200 而ku6返回status=1
		if ($get_data['code'] == 200 || $get_data['status'] == 1) {
			//將gbk編碼轉為utf-8編碼
			if (strtolower(CHARSET) == 'gbk') {
				$get_data = array_iconv($get_data, 'utf-8', 'gbk');
			}
			return $get_data;
		} else {
			return $get_data;
		}
	}
	
	/**
	 * Function CHECK
	 * 向vms發送vid
	 * @param string $vid vid
	 */
	public function check($vid = '') {
		if (!$vid) return false;
		//構造post數據
		$postdata['method'] = 'GetVid';
		$postdata['vid'] = $vid;
		$postdata['url'] = APP_PATH . 'api.php?op=video_api';
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Function vms_update_video 
	 * 更新視頻庫視頻到新系統
	 * @param array $data array of video
	 */
	public function vms_update_video($data = array()) {
		if (empty($data)) return false;
		//構造post數據
		$postdata['method'] = 'VideoUpdate';
		$postdata['data'] = $data;
		//向vms post數據，並獲取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		} else {
			return false;
		}
	}

	/**
	 * Function Preview
	 * 向vms請求vid
	 * @param string $vid vid
	 */
	public function Preview($vid = '') {
		if (!$vid) return false;
		//構造post數據
		$postdata['method'] = 'Preview';
		$postdata['vid'] = $vid;
		//向vms post數據，並獲取返回值
 		if ($data = $this->post($postdata)) {
			return $data;
		} else { 
  			return false;
		}
	}
	
	/**
	 * Function Ku6search
	 * 向vms請求搜索
	 * @param string $vid vid
	 */
	public function Ku6search($keyword,$pagesize,$page,$srctype,$len,$fenlei,$fq) { 
		//構造post數據
		$postdata['method'] = 'search';
		$postdata['pagesize'] = $pagesize;
		$postdata['keyword'] = $keyword;
		$postdata['page'] = $page;
		$postdata['fenlei'] = $fenlei;
		$postdata['srctype'] = $srctype;
		$postdata['len'] = $len;
		$postdata['fq'] = $fq;
		
 		//向vms post數據，並獲取返回值
 		if ($data = $this->post($postdata)) { 
  			return $data;
		} else { 
   			return false;
		}
	}
	/**
	 * Function get_sitename
	 * 獲取站點名稱
	 */
	private function get_sitename($siteid) {
		static $sitelist;
		if (!$sitelist) {
			$sitelist = getcache('sitelist', 'commons');
		}
		return $sitelist[$siteid]['name'];

	}
	
	/**
	 * Function update_vms 
	 * @升級視頻系統，向新系統添加用戶
	 * @param $data POST數據
	 */
	public function update_vms_member($data = array()) {
		if (empty($data)) return false;
		//構造post數據
		$data['sn'] = $this->ku6api_sn;
		$data['skey'] = $this->ku6api_skey;
		$postdata['data'] = json_encode($data);
		$api_url = pc_base::load_config('sub_config','member_add_dir').'MemberUpgrade.php';

		$data = $this->post_api($api_url, $postdata);
		
		//向vms post數據，並獲取返回值
 		if ($data) { 
  			return $data;
		} else { 
			return $data;
   			return false;
		}
	}

	/**
	 * Function testapi
	 * 測試接口配置是否正確
	 */
	public function testapi() {
		$postdata['method'] = 'Test';
		$data = $this->post($postdata);
		if ($data['code']==200) {
			return true;
		} else {
			return false;
		}
	} 
	
	/******************以下為視頻統計使用*****************/
	
	/*
	* 最近視頻播放量走勢圖
	*/
	public function get_stat_bydate($start_time,$end_time,$pagesize,$page){
		//構造post數據
		$postdata['pagesize'] = $pagesize; 
		$postdata['page'] = $page;
		$postdata['start_time'] = $start_time; 
		$postdata['end_time'] = $end_time; 
		$postdata['method'] = 'GetStatBydate'; 
		
 		//向vms post數據，並獲取返回值
		$data = $this->post($postdata);
		return $data;
	}
	
	/*
	* 根據關鍵字來搜索視頻
	*/
	public function get_video_bykeyword($type,$keyword){
		$postdata['type'] = $type; 
		$postdata['keyword'] = $keyword; 
		$postdata['method'] = 'GetVideoBykeyword';  
 		//向vms post數據，並獲取返回值
		$data = $this->post($postdata);  
		if ($data['code']==200) { 
  			return $data;
		} else { 
 			echo '搜索出現錯誤，請聯系管理員!';exit;
   			return false;
		}
	}
	
	/*
	* 查看視頻流量走勢
	*/
	public function show_video_stat($vid){
		if(!$vid) return false;
		$postdata['vid'] = $vid; 
		$postdata['method'] = 'ShowVideoStat';  
 		//向vms post數據，並獲取返回值
		$data = $this->post($postdata);  
		if ($data['code']==200) { 
  			return $data;
		} else { 
 			echo '查看視頻統計出錯，請聯系管理員!'; 
   			return false;
		}
		
	}
	
	/*
	* 視頻流量總體趨勢圖 
	*/
	public function vv_trend(){  
		$postdata['method'] = 'VvTrend';   
		$data = $this->post($postdata);  
		if ($data['code']==200) { 
  			return $data;
		} else { 
 			echo '視頻流量總體趨勢圖!'; 
   			return false;
		} 
	}
	
	
	/*
	* 按時間查看當日視頻播放排行榜，以播放次數倒敘
	* $date 2012-02-03
	*/
	/* 王參加注釋，這個是否還有用？
	public function get_stat_single($date){
		//構造post數據 
		$postdata['method'] = 'get_stat_single';
		$postdata['pagesize'] = $pagesize;
		$postdata['date'] = $date;
		$postdata['page'] = $page; 
		
 		//向vms post數據，並獲取返回值
 		if ($data = $this->post($postdata)) { 
  			return $data;
		} else { 
 			echo '沒有返回查詢時間點的數據！';exit;
   			return false;
		}
	}
	*/
	//完善資料
	public function complete_info($data){
		//構造post數據
		$postdata = $data; 
		$postdata['user_back'] = APP_PATH . 'api.php?op=video_api';   
 		//向vms post數據，並獲取返回值 
		
		$url = $this->ku6api_api."CompleteInfo.php"; 
		$return_data = $this->post_api($url, $postdata);
  		if ($return_data['code']=='200') { 
   			return $return_data['data'];
		} else { 
 			return '-1'; 
		} 
	} 
	
	/*
	* 獲得用戶填寫的詳細資料
	* 返回值：　用戶完善的資料
	*/
	public function Get_Complete_Info($data){
		if (empty($data)) return false; 
		$url = $this->ku6api_api."Get_Complete_Info.php"; 
		$return_data = $this->post_api($url, $data);
   		if ($return_data['code']=='200') { 
   			return $return_data['data'];
		} else { 
  			return false; 
		} 
	}
	
	/*
	* 獲得用戶填寫的詳細資料
	* 返回值：　用戶完善的資料
	*/
	public function check_user_back($url){
		if (empty($url)) return false; 
		$data['url'] = $url;
		$url = $this->ku6api_api."Check_User_Back.php"; 
		$return_data = $this->post_api($url, $data);
   		if ($return_data['code']=='200') { 
   			return 200;
		} else { 
  			return -200; 
		} 
	}
	
	//發送驗證碼到指定郵件
	public function send_code($data){
		if (empty($data)) return false; 
		$new_data['email'] = $data['email'];
		$new_data['url'] = $data['url'];
		$url = $this->ku6api_api."Send_Code.php";  
		$return_data = $this->post_api($url, $new_data); 
    	return $return_data;
	}
	
	//驗證信箱和驗證碼，包含email and  code
	public function check_email_code($data){
		if (empty($data)) return false;  
		$url =  $this->ku6api_api."Check_Email_Code.php";  
		$return_data = $this->post_api($url, $data); 
		if($return_data['code']=='200'){
			return $return_data['data'];
		}else{
			return false;
		} 
	}
	
	
	/**
	 * Function 
	 * 獲取播放器列表
	 */
	public function player_list() {
		$postdata['method'] = 'PlayerList';
		$data = $this->post($postdata);
		if ($data['code']==200) {
			return $data;
		} else {
			return false;
		}
	}
	/**
	 * Function 
	 * 獲取播放器列表
	 */
	public function player_edit($field,$style) {
		$postdata['method'] = 'PlayerEdit';
		$postdata['field'] = $field;
		$postdata['style'] = $style;
		$data = $this->post($postdata);
		if ($data['code']==200) {
			return $data;
		} else {
			return false;
		}
	} 

	/**
	 * FUNCTION post_api
	 * @post數據到api，post方法是post數據到api下面的v5，而post_api是post到api下面
	 * @$data array post數據
	 */
	private function post_api($url = '', $data = array()) {
		if (empty($url) || !preg_match("/^(http:\/\/)?([a-z0-9\.]+)(\/api)(\/[a-z0-9\._]+)/i", $url) || empty($data)) return false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Client SDK ');
		$output = curl_exec($ch);
		$return_data = json_decode($output,true);
   		return $return_data;
	}
}