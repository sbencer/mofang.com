<?php
/**
 * search_api.class.php 專題執行接口類
 * 
 */
defined('IN_PHPCMS') or exit('No permission resources.');

class search_api {
	private $db, $c;
	
	public function __construct() {
		$this->db = pc_base::load_model('special_content_model');
		$this->c = pc_base::load_model('special_c_data_model');
	}
	
	/**
	 * 獲取內容接口
	 * @param intval $pagesize 每頁個數
	 * @param intval $page 當前頁數
	 */
	public function fulltext_api($pagesize = 100, $page = 1) {
		$result = $r = $data = $tem = array();
		$offset = ($page-1)*$pagesize;
		$result = $this->db->select(array('isdata'=>1), '`id`, `specialid`, `title`, `short_title`, `thumb`, `keywords`, `description`,
		 `url`, `username`, `inputtime`', $offset.','.$pagesize, '`id` ASC');
		foreach ($result as $r) {
			$d = $this->c->get_one(array('id'=>$r['id']), '`content`, `author`');
			$tem = $r;
			$tem['_id_'] = $r['specialid'].'-'.$r['id'].'-'.$r['id'];
			$tem['content'] = $d['content'];
			$tem['author'] = $d['author'];
			
			$data[$r['id']] = $tem;
		}
		return $data;
	}
	
	/**
	 * 計算總數接口
	 */
	public function total() {
		$r = $this->db->get_one(array('isdata'=>1), 'COUNT(*) AS num');
		return $r['num'];
	}
	
	/**
	 * 獲取專題下內容數據
	 * @param string/intval $ids 多個id用“,”分開
	 */
	public function get_search_data($ids) {
		$where = to_sqls($ids, '', 'id');
		$data = $this->db->select($where, '`id`, `title`, `thumb`, `description`, `url`, `inputtime`', '', '', '', 'id');
		return $data;
	}
	
}