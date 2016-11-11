<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class search_stats extends admin {
	function __construct() {
		parent::__construct();
		$this->siteid = $this->get_siteid();
        $this->db = pc_base::load_model('search_keyword_model');
        $this->page = intval($_GET['page'])?:1;
        $this->perpage = 16;

	}

    function init() {
        $updatetime = mktime(date('H'),0,0,date('m'),date('d'),date('Y'));
        $where = "updatetime > $updatetime";
        $datas = $this->db->listinfo($where,'hourviews desc',$this->page,$this->perpage);
		$pages = $this->db->pages;
        include $this->admin_tpl('search_stats');
    }

    function day_stats() {
        $updatetime = mktime(0,0,0,date('m'),date('d'),date('Y'));
        $where = "updatetime > $updatetime";
        $datas = $this->db->listinfo($where,'dayviews desc',$this->page,$this->perpage);
		$pages = $this->db->pages;
        include $this->admin_tpl('search_stats');
    }

    function week_stats() {
        $updatetime = mktime(0,0,0,date('m'),date('d')-date('w')+1,date('Y'));
        $where = "updatetime > $updatetime";
        $datas = $this->db->listinfo($where,'weekviews desc',$this->page,$this->perpage);
		$pages = $this->db->pages;
        include $this->admin_tpl('search_stats');
    }

    function month_stats() {
        $updatetime = mktime(0,0,0,date('m'),1,date('Y'));
        $where = "updatetime > $updatetime";
        $datas = $this->db->listinfo($where,'monthviews desc',$this->page,$this->perpage);
		$pages = $this->db->pages;
        include $this->admin_tpl('search_stats');
    }

	
}
?>
