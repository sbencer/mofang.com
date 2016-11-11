<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class app_package_model extends model {
	private $att_index_db;
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'app_package';
		parent::__construct();
	}
	
	public function api_add($uploadedfile) {
		$uploadfield = array();
		$uploadfield = $uploadedfile;
		unset($uploadfield['fn']);
		$uploadfield = new_addslashes($uploadfield);
		$this->insert($uploadfield);
		$aid = $this->insert_id();
		$uploadedfile['aid'] = $aid;
		return $aid;
	}
	/**
	 * 附件更新接口.
	 * @param string $content 可傳入空，html，數組形式url，url地址，傳入空時，以cookie方式記錄。
	 * @param string 傳入附件關系表中的組裝id
	 * @isurl intval 為本地地址時設為1,以cookie形式管理時設置為2
	 */
	public function api_update($content, $keyid, $isurl = 0) {
		if(pc_base::load_config('system','attachment_stat') == 0) return false;
		$keyid = trim($keyid);
		$isurl = intval($isurl);
		if($isurl==2 || empty($content)) {
			$this->api_update_cookie($keyid);
		} else {
			$att_index_db = pc_base::load_model('attachment_index_model');
			$upload_url = pc_base::load_config('system','upload_url');
			if(strpos($upload_url,'://')!==false) {
				$pos = strpos($upload_url,"/",8);
				$domain = substr($upload_url,0,$pos).'/';
				$dir_name = substr($upload_url,$pos+1);
			}
			if($isurl == 0) {
				$pattern = '/(href|src)=\"(.*)\"/isU';
				preg_match_all($pattern,$content,$matches);
				if(is_array($matches) && !empty($matches)) {
					$att_arr = array_unique($matches[2]);
					foreach ($att_arr as $_k=>$_v) $att_arrs[$_k] = md5(str_replace(array($domain,$dir_name), '', $_v));
				}
			} elseif ($isurl == 1) {
				if(is_array($content)) {
					$att_arr = array_unique($content);
					foreach ($att_arr as $_k=>$_v) $att_arrs[$_k] = md5(str_replace(array($domain,$dir_name), '', $_v));
				} else {
					$att_arrs[] = md5(str_replace(array($domain,$dir_name), '', $content));
				}
			}
			$att_index_db->delete(array('keyid'=>$keyid));	
			if(is_array($att_arrs) && !empty($att_arrs)) {
				foreach ($att_arrs as $r) {
					$infos = $this->get_one(array('authcode'=>$r),'aid');
					if($infos){
						$this->update(array('status'=>1),array('id'=>$infos['aid']));
						$att_index_db->insert(array('keyid'=>$keyid,'aid'=>$infos['aid']));
					}
				}
			}
		}
		param::set_cookie('att_json','');
		return true;
	}
	/*
	 * cookie 方式關聯附件yu130511
	 */
	private function api_update_cookie($keyid) {
		if(pc_base::load_config('system','attachment_stat') == 0) return false;
		//從keyid中獲得pid和cid
		$ids = explode('-',$keyid);
		$pid = $ids[2];
		$cid = $ids[1];
		
		$att_json = param::get_cookie('att_json');
		if($att_json) {
			$att_cookie_arr = explode('||', $att_json);
			$att_cookie_arr = array_unique($att_cookie_arr);
		} else {
			return false;
		}
		foreach ($att_cookie_arr as $_att_c) $att[] = json_decode($_att_c,true);
		foreach ($att as $_v) {
			//文章發表完成後更新附件信息
			$this->update(array('pid'=>$pid,'cid'=>$cid),array('id'=>$_v['aid']));
		}		
	}
	/*
	 * 附件刪除接口
	 * @param string 傳入附件關系表中的組裝id
	 */
	public function api_delete($keyid) {
		if(pc_base::load_config('system','attachment_stat') == 0) return false;
		$keyid = trim($keyid);
		if($keyid=='') return false;
		$att_index_db = pc_base::load_model('attachment_index_model');
		$attachment = pc_base::load_sys_class('attachment');
		$info = $att_index_db->select(array('keyid'=>$keyid),'aid');
		if($info) {
			$att_index_db->delete(array('keyid'=>$keyid));
			foreach ($info as $_v) {
				if(!$att_index_db->get_one(array('aid'=>$_v['aid']))) {
					$attachment->delete(array('aid'=>$_v['aid']));
				}
			}
			return true;
		} else {
			return false;
		}		
	}
}
?>