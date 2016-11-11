<?php
/**
 * 會員接口
 *
 */
class member_interface {
	//數據庫連接
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('member_model');
	}
	
	/**
	 * 獲取用戶信息
	 * @param $username 用戶名
	 * @param $type {1:用戶id;2:用戶名;3:email}
	 * @return $mix {-1:用戶不存在;userinfo:用戶信息}
	 */
	public function get_member_info($mix, $type=1) {
		$mix = safe_replace($mix);
		if($type==1) {
			$userinfo = $this->db->get_one(array('userid'=>$mix));
		} elseif($type==2) {
			$userinfo = $this->db->get_one(array('username'=>$mix));
		} elseif($type==3) {
			if(!$this->_is_email($mix)) {
				return -4;
			}
			$userinfo = $this->db->get_one(array('email'=>$mix));
		}
		if($userinfo) {
			return $userinfo;
		} else {
			return -1;
		}
	}
	
	/**
	 * 將文章加入收藏夾
	 * @param int $cid 文章id
	 * @param int $userid 會員id
	 * @param string $title 文章標題
	 * @param $mix {-1:加入失敗;$id:加入成功，返回收藏id}
	 */
	public function add_favorite($cid, $userid, $title) {
		$cid = intval($cid);
		$userid = intval($userid);
		$title = safe_replace($title);
		$this->favorite_db = pc_base::load_model('favorite_model');
		$id = $this->favorite_db->insert(array('title'=>$title,'userid'=>$userid, 'cid'=>$cid, 'adddate'=>SYS_TIME), 1);
		if($id) {
			return $id;
		} else {
			return -1;
		}
	}

	/**
	 * 根據uid增加用戶積分
	 * @param int $userid	用戶id
	 * @param int $point	點數
	 * @return boolean
	 */
	public function add_point($userid, $point) {
		$point = intval($point);
		return $this->db->update(array('point'=>"+=$point"), array('userid'=>$userid));
	}
}