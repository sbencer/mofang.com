<?php
class comment_tag {
	//數據庫連接
	private $comment_db, $comment_setting_db, $comment_data_db, $comment_table_db;
	
	public function __construct() {
		$this->comment_db = pc_base::load_model('comment_model');
		$this->comment_setting_db = pc_base::load_model('comment_setting_model');
		$this->comment_data_db = pc_base::load_model('comment_data_model');
		$this->comment_table_db = pc_base::load_model('comment_table_model');
	}
	
	/**
	 * 
	 * PC標簽數據數量計算函數
	 * @param array $data PC標簽中的配置參數傳入
	 */
	public function count($data) {
		if($data['action']=='get_comment') return 0;
		$commentid = $data['commentid'];
		if (empty($commentid)) return false;
		$siteid = $data['siteid'];
		if (empty($siteid)) {
			pc_base::load_app_func('global', 'comment');
			list($module,$contentid, $siteid) = decode_commentid($commentid);
		}
		$comment = $this->comment_db->get_one(array('commentid'=>$commentid, 'siteid'=>$siteid));
		if (!$comment) return false;
		//是否按評論方向獲取
		$direction = isset($data['direction']) && intval($data['direction']) ? intval($data['direction']) : 0;
		switch ($direction) {
			case 1://正方
				return $comment['square'];
				break;
			case 2://反方
				return $comment['anti'];
				break;
			case 3://中立方
				return $comment['neutral'];
				break;
			default://獲取所有
				return $comment['total'];
		}
	}
	
	/**
	 * 
	 * 獲取評論總表信息
	 * @param array $data PC標簽中的配置參數傳入
	 */
	public function get_comment($data) {
		$commentid = $data['commentid'];
		if (empty($commentid)) return false;
        $comment = $this->comment_db->get_one(array('commentid'=>$commentid));
        if (!$comment) return false;
		//設置存儲數據表
        $this->comment_data_db->table_name($comment['tableid']);
        $result = $this->comment_data_db->get_one(array('commentid'=>$commentid),"sum(`oppose`+`support`) as sum");
        $comment['sum'] = $result['sum'];   //表態數查詢=所有評論的頂採總和
        return $comment;
	}
	
	/**
	 * 
	 * 獲取評論數據
	 * @param array $data PC標簽中的配置參數傳入
	 */
	public function lists($data) {
		$commentid = $data['commentid'];
		if (empty($commentid)) return false;
		$siteid = $data['siteid'];
		if (empty($siteid)) {
			pc_base::load_app_func('global', 'comment');
			list($module,$contentid, $siteid) = decode_commentid($commentid);
		}
		$comment = $this->comment_db->get_one(array('commentid'=>$commentid, 'siteid'=>$siteid));
		if (!$comment) return false;
		//設置存儲數據表
		$this->comment_data_db->table_name($comment['tableid']);
				
		$hot = 'id';
		if (isset($data['hot']) && !empty($data['hot'])) {
			$hot = 'support+oppose desc, id';
		}
		
		//是否按評論方向獲取
		$direction = isset($data['direction']) && intval($data['direction']) ? intval($data['direction']) : 0;
		if (!in_array($direction, array(0,1,2,3))) {
			$direction = 0;
		}
		
		switch ($direction) {
			case 1://正方
				$sql = array('commentid'=>$commentid, 'direction'=>1, 'status'=>1);
				break;
			case 2://反方
				$sql = array('commentid'=>$commentid, 'direction'=>2, 'status'=>1);
				break;
			case 3://中立方
				$sql = array('commentid'=>$commentid, 'direction'=>3, 'status'=>1);
				break;
			default://獲取所有
				$sql = array('commentid'=>$commentid, 'status'=>1);
		}
        $sql = array('commentid'=>$commentid, 'status'=>1);
        $return = $this->comment_data_db->select($sql, '*', $data['limit'], $hot.' desc ');
        $count = $this->comment_data_db->count($sql, '*', $data['limit'], $hot.' desc ');
        if( isset($data['total']) && $data['total'] == 1 ){
            return array('data'=>$return,'total'=>$count);
        }else{
            return $return; 
        }
	}
	
	/**
	 * 
	 * 評論排行榜
	 * @param array $data PC標簽中的配置參數傳入
	 */
	public function bang($data) {
		$data['limit'] = intval($data['limit']);
		if (!isset($data['limit']) || empty($data['limit'])) {
			$data['limit'] = 10;
		} 
		$sql =  array();
		$data['siteid'] = intval($data['siteid']);
		if (isset($data['siteid']) && !empty($data['siteid'])) {
			$sql = array('siteid'=>$data['siteid']);
		}
		return $this->comment_db->select($sql, "*", $data['limit'], "total desc");
	}
	
	/**
	 * 
	 * PC標簽，可視化顯示參數配置。
	 */
	public function pc_tag() {
		$sites = pc_base::load_app_class('sites','admin');
		$sitelist = $sites->pc_tag_list();
		return array(
			'action'=>array('lists'=>L('list','', 'comment'), 'get_comment'=>L('comments_on_the_survey', '', 'comment'), 'bang'=>L('comment_bang', '', 'comment')),
			'lists'=>array(
						'commentid'=>array('name'=>L('comments_id', '', 'comment'),'htmltype'=>'input', 'validator'=>array('min'=>1)),
						'siteid'=>array('name'=>L('site_id', '', 'comment'),'htmltype'=>'input_select', 'data'=>$sitelist,'validator'=>array('min'=>1)),
						'direction'=>array('name'=>L('comments_direction', '', 'comment'), 'htmltype'=>'select', 'data'=>array('0'=>L('jiushishuo', '', 'comment'), '1'=>L('tetragonal', '', 'comment'), '2'=>L('cons', '', 'comment'), '3'=>L('neutrality', '', 'comment'))),
						'hot'=>array('name'=>L('sort', '', 'comment'), 'htmltype'=>'select','data'=>array('0'=>L('new', '', 'comment'), '1'=>L('hot', '', 'comment'))),
					),
			'get_comment'=>array('commentid'=>array('name'=>L('comments_id', '', 'comment'),'htmltype'=>'input', 'defaultdata'=>'$commentid')),
		);
	}
}
