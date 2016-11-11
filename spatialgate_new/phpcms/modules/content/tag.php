<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型缓存路径
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

pc_base::load_app_func('util','content');
pc_base::load_sys_class('smarty','',0);

class tag {
	private $db;
    private $_is_wap = false;
	function __construct() {
		$this->db = pc_base::load_model('content_model');
		$this->type_db = pc_base::load_model('type_model');
		$this->type_data_db = pc_base::load_model('type_data_model');

        if(WAP) { //移动端展示判断
            $this->_is_wap = true;
        }
	}
	/**
	 * 按照模型搜索
	 */
	public function init() {
		//if(!isset($_GET['catid'])) showmessage(L('missing_part_parameters'));
		$catid = intval($_GET['catid']);
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$this->categorys = getcache('category_content_'.$siteid,'commons');
		//if(!isset($this->categorys[$catid])) showmessage(L('missing_part_parameters'));
		if(isset($_GET['info']['catid']) && $_GET['info']['catid']) {
			$catid = intval($_GET['info']['catid']);
		} else {
			$_GET['info']['catid'] = 0;
		}
		if(isset($_GET['tag']) && trim($_GET['tag']) != '') {
			$tag = safe_replace(strip_tags($_GET['tag']));
		} else {
			showmessage(L('illegal_operation'));
		}
		$modelid = $this->categorys[$catid]['modelid']?:1;
		$modelid = intval($modelid);
		if(!$modelid) showmessage(L('illegal_parameters'));
		$CATEGORYS = $this->categorys;

		$siteid = $this->categorys[$catid]['siteid'];
		$siteurl = siteurl($siteid);
		$this->db->set_model($modelid);

		$page = $_GET['page'] ? : 1;
		$pagesize = 10;

		$start = ($page-1) * $pagesize;
		$limit = "$start, $pagesize";
		$datas = $infos = array();

		$type = $this->type_db->get_one("`name`='{$tag}'", 'typeid');
		if(!$type){
			header('HTTP/1.1 404 Not Found');
			return;
		}

		$ids = $this->type_data_db->select(array('typeid'=>$type['typeid'], 'modelid'=>$modelid), 'relateid', $limit, 'relateid desc');
		foreach($ids as $v) {
			$id_array[] = $v['relateid'];
		}
		$idstr = implode(',', $id_array) ? : 0;
		$infos = $this->db->listinfo("`status`=99 AND `id` IN ($idstr)",'id DESC');

		$total = $this->type_data_db->count(array('typeid'=>$type['typeid'], 'modelid'=>$modelid));

		if($_GET['ajax'] == 1) {
			echo json_encode($datas);
			return;
		}

		$SEO = seo($siteid, $catid, $tag);

		$smarty = new CSmarty();

		$smarty->assign("SEO", $SEO);
		$smarty->assign("tag", $tag);
		$smarty->assign("data", $infos);

		$smarty->assign("keyword", $tag);
        $smarty->assign("result", $infos);

        $smarty->assign("page", $page);
        $smarty->assign("total", $total);

        if($this->_is_wap) {
            $smarty->display('tw_acg/wap/tag.tpl');
        } else {
            $smarty->display('tw_acg/search.tpl');
        }

		//include template('content','tag');
	}
}
?>
