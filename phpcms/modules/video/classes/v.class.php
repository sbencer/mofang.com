<?php
/**
 * 
 * ----------------------------
 * v class
 * ----------------------------
 * 
 * An open source application development framework for PHP 5.0 or newer
 * 
 * 這個類，主要負責視頻模型數據處理
 * @package	PHPCMS V9.1.16
 * @author		chenxuewang
 * @copyright	CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 *
 */

class v {
	
	private $db;
	
	public function __construct(&$db) {
		$this->db = & $db;
	}
	
	/**
	 * 
	 * add 添加視頻方法，將視頻入庫到視頻庫中
	 * @param array $data 視頻信息數據
	 */
	public function add($data = array()) {
		if (is_array($data) && !empty($data)) {
			$data['status'] = 1;
			$data['userid'] = defined('IN_ADMIN') ? 0 : intval(param::get_cookie('_userid'));
			$data['vid'] = safe_replace($data['vid']);
			$vid = $this->db->insert($data, true);
			return $vid ? $vid : false; 
		} else {
			return false;
		}
	}
	
	/**
	 * function edit 
	 * 編輯視頻方法，用戶重新編輯已上傳的視頻
	 * @param array $data 視頻視頻信息數組 包括title description tag vid 等信息
	 * @param int $vid 視頻庫中視頻的主鍵
	 */
	public function edit($data = array(), $vid = 0) {
		if (is_array($data) && !empty($data)) {
			$vid = intval($vid);
			if (!$vid) return false;
			unset($data['vid']);
			$this->db->update($data, "`videoid` = '$vid'");
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * function del_video
	 * 刪除視頻庫中的視頻
	 * @param int $vid 視頻ID
	 */
	public function del_video($vid = 0) {
		$vid = intval($vid);
		if (!$vid) return false;
		//刪除視頻關聯的內容，並更新內容頁
		$this->db->update(array('status'=>'-30'), array('videoid'=>$vid));
		return true;
	}
}
?>