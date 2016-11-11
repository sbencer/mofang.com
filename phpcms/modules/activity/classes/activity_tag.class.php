<?php
/**
 * raiders_tag.class.php 專區標簽調用類
 * @author 
 *
 */
class activity_tag {
	private $db, $c;
	
	public function __construct() {
		$this->db = pc_base::load_model('raiders_model');
		$this->c = pc_base::load_model('raiders_data_model');
	}
	
	/**
	 * lists調用方法
	 * @param array $data 標簽配置傳遞過來的配置數組，根據配置生成sql
	 */
	public function lists($data) {
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		$where .= "`siteid`='".$siteid."'";
		if ($data['elite']) $where .= " AND `elite`='1'";
		if ($data['thumb']) $where .= " AND `thumb`!=''"; 
		if ($data['disable']) {
			$where .= " AND `disabled`='".$data['disable']."'";
		}else{
			$where .= " AND `disabled`='0'";//默認顯示，正常顯示的專區。
		}
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC, `id` DESC', '`listorder` DESC, `id` DESC');
		return $this->db->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
	}
	
	/**
	 * 視頻專區列表 video_lists
	 * @param array $data 標簽配置傳遞過來的配置數組，根據配置生成sql
	 */
	public function video_lists($data) {
		$siteid = $data['siteid'] ? intval($data['siteid']) : get_siteid();
		$where .= "`siteid`='".$siteid."'";
		if ($data['elite']) $where .= " AND `elite`='1'";
		if ($data['thumb']) $where .= " AND `thumb`!=''"; 
		if ($data['disable']) {
			$where .= " AND `disabled`='".$data['disable']."'";
		}else{
			$where .= " AND `disabled`='0'";//默認顯示，正常顯示的專區。
		}
		$where .=" AND `isvideo`='1'";
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC, `id` DESC', '`listorder` DESC, `id` DESC');
		return $this->db->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
	}
	
	/**
	 * 標簽中計算分頁的方法
	 * @param array $data 標簽配置數組，根據數組計算出分頁
	 */
	public function count($data) {
		$where = '1';
		if($data['action'] == 'lists') {
			$where = '1';
			if ($data['siteid']) $where .= " AND `siteid`='".$data['siteid']."'";
			if ($data['elite']) $where .= " AND `elite`='1'";
			if ($data['thumb']) $where .= " AND `thumb`!=''"; 
			$r = $this->db->get_one($where, 'COUNT(id) AS total');
		} elseif ($data['action'] == 'content_list') {
			if ($data['raidersid']) $where .= " AND `raidersid`='".$data['raidersid']."'";
			if ($data['typeid']) $where .= " AND `typeid`='".$data['typeid']."'";
			if ($data['thumb']) $where .= " AND `thumb`!=''";
			$r = $this->c->get_one($where, 'COUNT(id) AS total');
		} elseif ($data['action'] == 'hits') {
			$hitsid = 'raiders-c';
			if ($data['raidersid']) $hitsid .= $data['raidersid'].'-';
			else $hitsid .= '%-';
			$hitsid = $hitsid .= '%';
			$hits_db = pc_base::load_model('hits_model');
			$sql = "hitsid LIKE '$hitsid'";
			$r = $hits_db->get_one($sql, 'COUNT(*) AS total');
		}elseif($data['action'] == 'video_lists') {
			$where = '1';
			if ($data['siteid']) $where .= " AND `siteid`='".$data['siteid']."'";
			if ($data['elite']) $where .= " AND `elite`='1'";
			if ($data['thumb']) $where .= " AND `thumb`!=''"; 
			$where .=" AND `isvideo`='1'";
			$r = $this->db->get_one($where, 'COUNT(id) AS total');
		}
		return $r['total'];
	}
	
	/**
	 * 點擊排行調用方法
	 * @param array $data 標簽配置數組
	 */
	public function hits($data) {
		$hitsid = 'raiders-c-';
		if ($data['raidersid']) $hitsid .= $data['raidersid'].'-';
		else $hitsid .= '%-';
		$hitsid = $hitsid .= '%';
		$this->hits_db = pc_base::load_model('hits_model');
		$sql = "hitsid LIKE '$hitsid'";
		$listorders = array('views DESC', 'yesterdayviews DESC', 'dayviews DESC', 'weekviews DESC', 'monthviews DESC');
		$result = $this->hits_db->select($sql, '*', $data['limit'], $listorders[$data['listorder']]);
		foreach ($result as $key => $r) {
			$ids = explode('-', $r['hitsid']);
			$id = $ids[3];
			$re = $this->c->get_one(array('id'=>$id));
			$result[$key]['title'] = $re['title'];
			$result[$key]['url'] = $re['url'];
		}
		return $result;
	}
	
	/**
	 * 內容列表調用方法
	 * @param array $data 標簽配置數組
	 */
	public function content_list($data) {
		$where = '1';
		if ($data['raidersid']) $where .= " AND `raidersid`='".$data['raidersid']."'";
		if ($data['typeid']) $where .= " AND `typeid`='".$data['typeid']."'";
		if ($data['thumb']) $where .= " AND `thumb`!=''";
		$listorder = array('`id` ASC', '`id` DESC', '`listorder` ASC', '`listorder` DESC');
		$result = $this->c->select($where, '*', $data['limit'], $listorder[$data['listorder']]);
		if (is_array($result)) {
			foreach($result as $k => $r) {
				if ($r['curl']) {
					$content_arr = explode('|', $r['curl']);
					$r['url'] = go($content_arr['1'], $content_arr['0']);
				}
				$res[$k] = $r;
			}
		} else {
			$res = array();
		}
		return $res;
	}
	
	/**
	 * 獲取專區分類方法
	 * @param intval $raidersid 專區ID
	 * @param string $value 默認選中值
	 * @param intval $id onchange影響HTML的ID
	 * 
	 */
	public function get_type($raidersid = 0, $value = '', $id = '') {
		$type_db = pc_base::load_model('type_model');
		$data = $arr = array();
		$data = $type_db->select(array('module'=>'raiders', 'parentid'=>$raidersid));
		pc_base::load_sys_class('form', '', 0);
		foreach($data as $r) {
			$arr[$r['typeid']] = $r['name'];
		}
		$html = $id ? ' id="typeid" onchange="$(\'#'.$id.'\').val(this.value);"' : 'name="typeid", id="typeid"';
		return form::select($arr, $value, $html, L('please_select'));
	}
	
	/**
	 * 標簽生成方法
	 */
	public function pc_tag() {
		//獲取站點
		$sites = pc_base::load_app_class('sites','admin');
		$sitelist = $sites->pc_tag_list();
		
		$result = getcache('raiders', 'commons');
		if(is_array($result)) {
			$raiderss = array(L('please_select'));
			foreach($result as $r) {
				if($r['siteid']!=get_siteid()) continue;
				$raiderss[$r['id']] = $r['title'];
			}
		}
		return array(
			'action'=>array('lists'=>L('raiders_list', '', 'raiders'), 'content_list'=>L('content_list', '', 'raiders'), 'hits'=>L('hits_order','','raiders')),
			'lists'=>array(
				'siteid'=>array('name'=>L('site_id','','comment'), 'htmltype'=>'input_select', 'data'=>$sitelist),
				'elite'=>array('name'=>L('iselite', '', 'raiders'), 'htmltype'=>'radio', 'defaultvalue'=>'0', 'data'=>array(L('no'), L('yes'))),
				'thumb'=>array('name'=>L('get_thumb', '', 'raiders'), 'htmltype'=>'radio','defaultvalue'=>'0','data'=>array(L('no'), L('yes'))),
				'listorder'=>array('name'=>L('order_type', '', 'raiders'), 'htmltype'=>'select', 'defaultvalue'=>'3', 'data'=>array(L('id_asc', '', 'raiders'), L('id_desc', '','raiders'), L('order_asc','','raiders'), L('order_desc', '','raiders'))),
			),
			'content_list'=>array(
				'raidersid'=>array('name'=>L('raiders_id','','raiders'),'htmltype'=>'input_select', 'data'=>$raiderss, 'ajax'=>array('name'=>L('for_type','','raiders'), 'action'=>'get_type', 'id'=>'typeid')),
				'thumb'=>array('name'=>L('content_thumb','','raiders'),'htmltype'=>'radio','defaultvalue'=>'0','data'=>array(L('no'), L('yes'))),
				'listorder'=>array('name'=>L('order_type', '', 'raiders'), 'htmltype'=>'select', 'defaultvalue'=>'3', 'data'=>array(L('id_asc', '', 'raiders'), L('id_desc', '','raiders'), L('order_asc','','raiders'), L('order_desc', '','raiders'))),
			),
			'hits' => array(
				'raidersid' => array('name'=>L('raiders_id','','raiders'), 'htmltype'=>'input_select', 'data'=>$raiderss),
				'listorder' => array('name' => L('order_type', '', 'raiders'), 'htmltype' => 'select', 'data'=>array(L('total','','raiders'), L('yesterday', '','raiders'), L('today','','raiders'), L('week','','raiders'), L('month','','raiders'))),
			),
		);
	}
}
?>