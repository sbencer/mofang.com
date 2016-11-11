<?php
/**
 * 評論操作類
 * @author chenzhouyu
 *
 */
class comment {
	//數據庫連接
	private $comment_db, $comment_setting_db, $comment_data_db, $comment_table_db, $comment_check_db;
	
	public $msg_code = 0;
	
	public function __construct() {
		$this->comment_db = pc_base::load_model('comment_model');
		$this->comment_setting_db = pc_base::load_model('comment_setting_model');
		$this->comment_data_db = pc_base::load_model('comment_data_model');
		$this->comment_table_db = pc_base::load_model('comment_table_model');
		$this->comment_check_db = pc_base::load_model('comment_check_model');
	}
	
	/**
	 * 添加評論
	 * @param string $commentid 評論ID
	 * @param integer $siteid 站點ID
	 * @param array $data 內容數組應該包括array('userid'=>用戶ID，'username'=>用戶名,'content'=>內容,'direction'=>方向（0:沒有方向 ,1:正方,2:反方,3:中立）)
	 * @param string $id 回復評論的內容
	 * @param string $title 文章標題
	 * @param string $url 文章URL地址
	 */
	public function add($commentid, $siteid, $data, $id = '', $title = '', $url = '') {
		//開始查詢評論這條評論是否存在。
		$title = new_addslashes($title);
		if (!$comment = $this->comment_db->get_one(array('commentid'=>$commentid, 'siteid'=>$siteid), 'tableid, commentid')) { //評論不存在
			//取得當前可以使用的內容數據表
			$r = $this->comment_table_db->get_one('', 'tableid, total', 'tableid desc');
			$tableid = $r['tableid'];
			if ($r['total'] >= 1000000) {
				//當上一張數據表存的數據已經達到1000000時，創建新的數據存儲表，存儲數據。
				if (!$tableid = $this->comment_table_db->creat_table()) {
					$this->msg_code = 4;
					return false;
				}
			}
			//新建評論到評論總表中。
			$comment_data = array('commentid'=>$commentid, 'siteid'=>$siteid, 'tableid'=>$tableid, 'display_type'=>($data['direction']>0 ? 1 : 0));
			if (!empty($title)) $comment_data['title'] = $title;
			if (!empty($url)) $comment_data['url'] = $url;
			if (!$this->comment_db->insert($comment_data)) {
				$this->msg_code = 5;
				return false;
			}
		} else {//評論存在時
			$tableid = $comment['tableid'];
		}
		if (empty($tableid)) {
			$this->msg_code = 1;
			return false;
		}
		//為數據存儲數據模型設置 數據表名。
		$this->comment_data_db->table_name($tableid);
		//檢查數據存儲表。
		if (!$this->comment_data_db->table_exists('comment_data_'.$tableid)) {
			//當存儲數據表不存時，嘗試創建數據表。
			if (!$tableid = $this->comment_table_db->creat_table($tableid)) {
				$this->msg_code = 2;
				return false;
			}
		}
		//向數據存儲表中寫入數據。	
		$data['commentid'] = $commentid;
		$data['siteid'] = $siteid;
		$data['ip'] = ip();
		$data['status'] = 1;
		$data['creat_at'] = SYS_TIME;
		//對評論的內容進行關鍵詞過濾。
		$data['content'] = strip_tags($data['content']);
		$badword = pc_base::load_model('badword_model');
		$data['content'] = $badword->replace_badword($data['content']);
		if ($id) {
			$r = $this->comment_data_db->get_one(array('id'=>$id));
			if ($r) {
				pc_base::load_sys_class('format', '', 0);
				if ($r['reply']) {
					$data['content'] = '<div class="content">'.str_replace('<span></span>', '<span class="blue f12">'.$r['username'].' '.L('chez').' '.format::date($r['creat_at'], 1).L('release').'</span>', $r['content']).'</div><span></span>'.$data['content'];
				} else {
					$data['content'] = '<div class="content"><span class="blue f12">'.$r['username'].' '.L('chez').' '.format::date($r['creat_at'], 1).L('release').'</span><pre>'.$r['content'].'</pre></div><span></span>'.$data['content'];
				}
				$data['reply'] = 1;
			}
		}
		//判斷當前站點是否需要審核
		$site = $this->comment_setting_db->site($siteid);
		if ($site['check']) {
			$data['status'] = 0;
		}
		$data['content'] = addslashes($data['content']);
		if ($comment_data_id = $this->comment_data_db->insert($data, true)) {
			//需要審核，插入到審核表
			if ($data['status']==0) {
				$this->comment_check_db->insert(array('comment_data_id'=>$comment_data_id, 'siteid'=>$siteid,'tableid'=>$tableid));
			} elseif (!empty($data['userid']) && !empty($site['add_point']) && module_exists('pay')) { //不需要審核直接給用戶添加積分
				pc_base::load_app_class('receipts', 'pay', 0);
				receipts::point($site['add_point'], $data['userid'], $data['username'], '', 'selfincome', 'Comment');
			}
			//開始更新數據存儲表數據總條數
			$this->comment_table_db->edit_total($tableid, '+=1');
			//開始更新評論總表數據總數
			$sql['lastupdate'] = SYS_TIME;
			//只有在評論通過的時候才更新評論主表的評論數
			if ($data['status'] == 1) {
				$sql['total'] = '+=1';
				switch ($data['direction']) {
					case 1: //正方
						$sql['square'] = '+=1';
						break;
					case 2://反方
						$sql['anti'] = '+=1';
						break;
					case 3://中立方
						$sql['neutral'] = '+=1';
						break;
				}
			}
			$this->comment_db->update($sql, array('commentid'=>$commentid));
			if ($site['check']) {
				$this->msg_code = 7;
			} else {
				$this->msg_code = 0;
			}
			return true;
		} else {
			$this->msg_code = 3;
			return false;
		}
	}
	
	/**
	 * 支持評論
	 * @param integer $commentid    評論ID
	 * @param integer $id           內容ID
	 */
	public function support($commentid, $id) {
		if ($data = $this->comment_db->get_one(array('commentid'=>$commentid), 'tableid')) {
			$this->comment_data_db->table_name($data['tableid']);
			if ($this->comment_data_db->update(array('support'=>'+=1'), array('id'=>$id))) {
				$this->msg_code = 0;
				return true;
			} else {
				$this->msg_code = 3;
				return false;
			}
		} else {
			$this->msg_code = 6;
			return false;
		}
	}
	
	/**
	 * 反對評論
	 * @param integer $commentid    評論ID
	 * @param integer $id           內容ID
	 */
	public function oppose($commentid, $id) {
		if ($data = $this->comment_db->get_one(array('commentid'=>$commentid), 'tableid')) {
			$this->comment_data_db->table_name($data['tableid']);
			if ($this->comment_data_db->update(array('oppose'=>'+=1'), array('id'=>$id))) {
				$this->msg_code = 0;
				return true;
			} else {
				$this->msg_code = 3;
				return false;
			}
		} else {
			$this->msg_code = 6;
			return false;
		}
	}
	/**
	 * 更新評論的狀態
	 * @param string $commentid      評論ID 
	 * @param integer $id            內容ID
	 * @param integer $status        狀態{1:通過 ,0:未審核， -1:不通過,將做刪除操作}
	 */
	public function status($commentid, $id, $status = -1) {
		if (!$comment = $this->comment_db->get_one(array('commentid'=>$commentid), 'tableid, commentid')) {
			$this->msg_code = 6;
			return false;
		}
		
		//為數據存儲數據模型設置 數據表名。
		$this->comment_data_db->table_name($comment['tableid']);
		if (!$comment_data = $this->comment_data_db->get_one(array('id'=>$id, 'commentid'=>$commentid))) {
			$this->msg_code = 6;
			return false;
		}
		
		//讀取評論的站點配置信息
		$site = $this->comment_setting_db->get_one(array('siteid'=>$comment_data['siteid']));
		
		
		if ($status == 1) {//通過的時候
			$sql['total'] = '+=1';
			switch ($comment_data['direction']) {
				case 1: //正方
					$sql['square'] = '+=1';
					break;
				case 2://反方
					$sql['anti'] = '+=1';
					break;
				case 3://中立方
					$sql['neutral'] = '+=1';
					break;
			}
			
			//當評論被設置為通過的時候，更新評論總表的數量。
			$this->comment_db->update($sql, array('commentid'=>$comment['commentid']));
			//更新評論內容狀態
			$this->comment_data_db->update(array('status'=>$status), array('id'=>$id, 'commentid'=>$commentid));
			
			//當評論用戶ID不為空，而且站點配置了積分添加項，支付模塊也存在的時候，為用戶添加積分。
			if (!empty($comment_data['userid']) && !empty($site['add_point']) && module_exists('pay')) {
				pc_base::load_app_class('receipts', 'pay', 0);
				receipts::point($site['add_point'], $comment_data['userid'], $comment_data['username'], '', 'selfincome', 'Comment');
			}
			
		} elseif ($status == -1) { //刪除數據
			//如果數據原有狀態為已經通過，需要刪除評論總表中的總數
			if ($comment_data['status'] == 1) {
				$sql['total'] = '-=1';
				switch ($comment_data['direction']) {
					case '1': //正方
						$sql['square'] = '-=1';
						break;
					case '2'://反方
						$sql['anti'] = '-=1';
						break;
					case '3'://中立方
						$sql['neutral'] = '-=1';
						break;
				}
				$this->comment_db->update($sql, array('commentid'=>$comment['commentid']));
			}
			
			//刪除存儲表的數據
			$this->comment_data_db->delete(array('id'=>$id, 'commentid'=>$commentid));
			//刪除存儲表總數記錄,判斷總數是否為0，否則不能再刪除了。
			$this->comment_table_db->edit_total($comment['tableid'], '-=1');
			
			//當評論ID不為空，站點配置了刪除的點數，支付模塊存在的時候，刪除用戶的點數。
			if (!empty($comment_data['userid']) && !empty($site['del_point']) && module_exists('pay')) {
				pc_base::load_app_class('spend', 'pay', 0);
				$op_userid = param::get_cookie('userid');
				$op_username = param::get_cookie('admin_username');
				spend::point($site['del_point'], L('comment_point_del', '', 'comment'), $comment_data['userid'], $comment_data['username'], $op_userid, $op_username);
			}
		}
		
		//刪除審核表中的數據
		$this->comment_check_db->delete(array('comment_data_id'=>$id));
		
		$this->msg_code = 0;
		return true;
	}
	
	/**
	 * 
	 * 刪除評論
	 * @param string $commentid 評論ID
	 * @param intval $siteid 站點ID
	 * @param intval $id 內容ID
	 * @param intval $catid 欄目ID
	 */
	public function del($commentid, $siteid, $id, $catid) {
		if ($commentid != id_encode('content_'.$catid, $id, $siteid)) return false;
		//循環評論內容表刪除commentid的評論內容
		for ($i=1; ;$i++) {
			$table = 'comment_data_'.$i; //構建評論內容存儲表名
			if ($this->comment_data_db->table_exists($table)) { //檢查構建的表名是否存在，如果存在執行刪除操作
				$this->comment_data_db->table_name($i);
				$this->comment_data_db->delete(array('commentid'=>$commentid));
			} else { //不存在，則退出循環
				break;
			}
		}
		$this->comment_db->delete(array('commentid'=>$commentid)); //刪除評論主表的內容
		return true;
	}
	
	/**
	 * 
	 * 獲取報錯的詳細信息。
	 */
	public function get_error() {
		$msg = array('0'=>L('operation_success'),
		'1'=>L('coment_class_php_1'),
		'2'=>L('coment_class_php_2'),
		'3'=>L('coment_class_php_3'),
		'4'=>L('coment_class_php_4'),
		'5'=>L('coment_class_php_5'),
		'6'=>L('coment_class_php_6'),
		'7'=>L('coment_class_php_7'),
		);
		return $msg[$this->msg_code];
	}
}
