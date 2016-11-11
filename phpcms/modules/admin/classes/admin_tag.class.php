<?php
class admin_tag {

    private $appkey = '10005';
    private $secret = '59d37a2a4d60a22a4d673a00b1a14236';
    private $recommend_url = "http://fahao.mofang.com.tw/api/v1/gift/recommend?";
    private $lasest_games_url = "http://game.mofang.com.tw/api/web/GetGameByType?";

	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('admin_model');
		$this->content_db = pc_base::load_model('content_model');
	}

    /**                                                                                                                                                                               * 初始化模型
     * @param $catid
     */
    public function set_modelid($catid) {
        static $CATS;            
        $siteids = getcache('category_content','commons');
        if(!$siteids[$catid]) return false;
        $siteid = $siteids[$catid];
        if ($CATS[$siteid]) {
            $this->category = $CATS[$siteid];
        } else {
            $CATS[$siteid] = $this->category = getcache('category_content_'.$siteid,'commons');
        }            
        if($this->category[$catid]['type']!=0) return false;
        $this->modelid = $this->category[$catid]['modelid'];
        $this->content_db->set_model($this->modelid);
        $this->tablename = $this->content_db->table_name;
        if(empty($this->category)) {
            return false;
        } else {
            return true;
        }    
    }   

    public function userinfo($data) {
        $catid = 10000050;
        $this->set_modelid($catid);
        $outhorname = $data['outhorname'];
        if($this->category[$catid]['child']) {
            $catids_str = $this->category[$catid]['arrchildid'];
            $pos = strpos($catids_str,',')+1;
            $catids_str = substr($catids_str, $pos);
            $sql = "status=99 AND catid IN ($catids_str) AND outhorname='{$outhorname}'";
            $count = $this->content_db->count($sql);
        } else {
            $count = $this->content_db->count(array('outhorname'=>$data['outhorname'], 'status'=>99));
        }
        $result = $this->db->select(array('username'=>$data['outhorname']),'username,avatars,description');
        $result[0]['count'] = $count ?: 0; 
        return $result;
    }

	/**
	 * 可視化標簽
	 */
	public function pc_tag() {
		$positionlist = getcache('position','commons');
		$sites = pc_base::load_app_class('sites','admin');
		$sitelist = $sites->pc_tag_list();

		foreach ($positionlist as $_v) if($_v['siteid'] == get_siteid() || $_v['siteid'] == 0) $poslist[$_v['posid']] = $_v['name'];
		return array(
			'action'=>array('lists'=>L('list','', 'content'),'position'=>L('position','', 'content'), 'category'=>L('subcat', '', 'content'), 'relation'=>L('related_articles', '', 'content'), 'hits'=>L('top', '', 'content')),
			'lists'=>array(
				'catid'=>array('name'=>L('catid', '', 'content'),'htmltype'=>'input_select_category','data'=>array('type'=>0),'validator'=>array('min'=>1)),
				'order'=>array('name'=>L('sort', '', 'content'), 'htmltype'=>'select','data'=>array('id DESC'=>L('id_desc', '', 'content'), 'updatetime DESC'=>L('updatetime_desc', '', 'content'), 'listorder ASC'=>L('listorder_asc', '', 'content'))),
				'thumb'=>array('name'=>L('thumb', '', 'content'), 'htmltype'=>'radio','data'=>array('0'=>L('all_list', '', 'content'), '1'=>L('thumb_list', '', 'content'))),
				'moreinfo'=>array('name'=>L('moreinfo', '', 'content'), 'htmltype'=>'radio', 'data'=>array('1'=>L('yes'), '0'=>L('no')))
			),
			'position'=>array(
				'posid'=>array('name'=>L('posid', '', 'content'),'htmltype'=>'input_select','data'=>$poslist,'validator'=>array('min'=>1)),
				'catid'=>array('name'=>L('catid', '', 'content'),'htmltype'=>'input_select_category','data'=>array('type'=>0),'validator'=>array('min'=>0)),
				'thumb'=>array('name'=>L('thumb', '', 'content'), 'htmltype'=>'radio','data'=>array('0'=>L('all_list', '', 'content'), '1'=>L('thumb_list', '', 'content'))),
				'order'=>array('name'=>L('sort', '', 'content'), 'htmltype'=>'select','data'=>array('listorder DESC'=>L('listorder_desc', '', 'content'),'listorder ASC'=>L('listorder_asc', '', 'content'),'id DESC'=>L('id_desc', '', 'content'))),
			),
			'category'=>array(
				'siteid'=>array('name'=>L('siteid'), 'htmltype'=>'input_select', 'data'=>$sitelist),
				'catid'=>array('name'=>L('catid', '', 'content'), 'htmltype'=>'input_select_category', 'data'=>array('type'=>0))
			),
			'relation'=>array(
				'catid'=>array('name'=>L('catid', '', 'content'), 'htmltype'=>'input_select_category', 'data'=>array('type'=>0), 'validator'=>array('min'=>1)),
				'order'=>array('name'=>L('sort', '', 'content'), 'htmltype'=>'select','data'=>array('id DESC'=>L('id_desc', '', 'content'), 'updatetime DESC'=>L('updatetime_desc', '', 'content'), 'listorder ASC'=>L('listorder_asc', '', 'content'))),
				'relation'=>array('name'=>L('relevant_articles_id', '', 'content'), 'htmltype'=>'input'),
				'keywords'=>array('name'=>L('key_word', '', 'content'), 'htmltype'=>'input')
			),
			'hits'=>array(
				'catid'=>array('name'=>L('catid', '', 'content'), 'htmltype'=>'input_select_category', 'data'=>array('type'=>0), 'validator'=>array('min'=>1)),
				'day'=>array('name'=>L('day_select', '', 'content'), 'htmltype'=>'input', 'data'=>array('type'=>0)),
			),

		);
	}

}
