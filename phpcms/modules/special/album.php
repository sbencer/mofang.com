<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format', '', 0);
pc_base::load_app_func('global', 'video');

/**
 * 
 * ----------------------------
 * album class
 * ----------------------------
 * 
 * An open source application development framework for PHP 5.0 or newer
 * 
 * This class 主要負責通過vms將酷6的專輯列表呈現給用戶。用戶可以選擇專輯導入到cms專題，並將專輯裡面的內容一並導入過來
 * @package	PHPCMS V9.1.16
 * @author		chenxuewang
 * @copyright	CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 *
 */

class album extends admin {
	
	private $db;
	
	/**
	 * Function __construct
	 * 初始化數據模型
	 */
	public function __construct() {
		parent::__construct();
		$this->special_api = pc_base::load_app_class('special_api', 'special');
		$this->db = pc_base::load_model('special_model');
		pc_base::load_app_func('global', 'video');
		//讀取視頻庫的配置信息
		$this->setting = getcache('video', 'video');
		if (!module_exists('video')) {
			showmessage(L('please_setting_video_info'), 'index.php?m=admin&c=module&a=init');
		}
		if (!$this->setting) showmessage(L('please_not_setting_info'), 'index.php?m=video&c=video&a=setting');
		pc_base::load_app_class('ku6api', 'video', 0);
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}
	
	/**
	 * Function import
	 * 專輯列表
	 */
	public function import() {
		$id = $_POST['id'] ? $_POST['id'] : ($_GET['id'] ? intval($_GET['id']) : 0);
		if ($id) {
			$postdata = array();
			if (is_array($id)) {
				foreach ($id as $albumid) {
					$info = $this->ku6api->get_album_info($albumid);
					$specialid = $this->special_api->importfalbum($info);
					if ($specialid) {
						$postdata[] = array('specialid'=>$specialid, 'id'=>$albumid);
					}
				}
			} else {
				$info = $this->ku6api->get_album_info($id);
				$specialid = $this->special_api->importfalbum($info);
				if ($specialid) {
					$postdata[] = array('specialid'=>$specialid, 'id'=>$id);
				}
			}
			$result = $this->ku6api->add_album_subscribe($postdata);
			if ($result) showmessage(L('album_add_success'), 'index.php?m=special&c=special');
			else showmessage(L('operation_failure'));
		} else {
			$page = max(intval($_GET['page']), 1);
			$pagesize = 6;
			//列出已載入的專輯
			$res = $this->db->select("`aid`!=0",'`aid`');
			$imported = array();
			if (is_array($res) && !empty($res)) {
				foreach ($res as $r) {
					$imported[] = $r['aid'];
				}
			}
			$ku6channels = $this->ku6api->get_ku6_channels();
			$albums = $this->ku6api->get_albums($page, $pagesize);
			$number = $albums['count'];
			$infos = $albums['data'];
			$pages = pages($number, $page, $pagesize);
			include $this->admin_tpl('album_list');
		}
	}
	
	/**
	 * Function content_list
	 * 某專輯下的視頻列表
	 */
	public function content_list() {
		$id = intval($_GET['id']);
		if (!$id) showmessage(L('illegal_parameters'));
		$page = max(intval($_GET['page']), 1);
		$pagesize = 15;
		$video_list = $this->ku6api->get_album_videoes($id, $page, $pagesize);
		$number = $video_list['count'];
		$infos = $video_list['list'];
		$pages = pages($number, $page, $pagesize);
		
		include $this->admin_tpl('album_video_list');
	}
}