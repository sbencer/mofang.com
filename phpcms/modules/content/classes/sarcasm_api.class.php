<?php
defined('IN_PHPCMS') or exit('No permission resources.');
if (!module_exists('sarcasm')) showmessage(L('module_not_exists'));
class sarcasm_api {
	private $db;
	function __construct() {
		$this->db = pc_base::load_model('content_model');
	}
	
	/**
	 * 獲取評論信息
	 * @param $module      模型
	 * @param $contentid   文章ID
	 * @param $siteid      站點ID
	 */
	function get_info($module, $contentid, $siteid) {
		list($module, $catid) = explode('_', $module);
		if (empty($contentid) || empty($catid)) {
			return false;
		}
		$this->db->set_catid($catid);
		$r = $this->db->get_one(array('catid'=>$catid, 'id'=>$contentid), '`title`');
		$category = getcache('category_content_'.$siteid, 'commons');
		$model = getcache('model', 'commons');
		
		$cat = $category[$catid];
		$data_info = array();
		if ($cat['type']==0) {
			if ($model[$cat['modelid']]['tablename']) {
				$this->db->table_name = $this->db->db_tablepre.$model[$cat['modelid']]['tablename'].'_data';
				$data_info = $this->db->get_one(array('id'=>$contentid));
			}
		}
		if ($r) {
			return array('title'=>$r['title'], 'url'=>go($catid, $contentid, 1), 'allow_sarcasm'=>(isset($data_info['allow_comment']) ? $data_info['allow_comment'] : 1));
		} else {
			return false;
		}
	}
}
