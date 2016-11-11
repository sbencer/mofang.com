<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
/**
 * 點擊統計
 */

$action = !empty($_GET['a'])?$_GET['a']:'init'; 

$defense = new partner();
$defense->$action();

class partner {
    private $db;
    public function __construct() {
        $this->db = pc_base::load_model('content_model');

        $this->type = $_GET['type']?:'new';
        $this->start = intval($_GET['start'])?:0;
        $this->end = intval($_GET['end'])?:time();
        $this->catid = $this->check_cat();
    }

    /**
     * 初始化模型
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
        $this->db->set_model($this->modelid);
        $this->tablename = $this->db->table_name;
        if(empty($this->category)) {
            return false;
        } else {
            return true;
        }
    }

    function init() {

    }

    /**
     * 獲取當前分類下對應的欄目ids
     */
    function check_cat() {
        $categorys = array('news', 'strategy', 'video');
        $catids = array('news'=>'101,188,125', 'strategy'=>'103,190', 'video'=>'472,473,474,475,477');
        $category = strtolower($_GET['category'])?:'';
        if (in_array($category, $categorys)) {
            $this->category = $category;
            return $catids[$category];
        } else {
            $this->category = 'all';
            return $catids;
        }
    }

    /**
     * 獲取某一時段之後的所有文章數目
     */
    public function getall_num() {
        $data['category'] = $this->category;
        $data['total'] = 0;
        if ($this->category == 'all') {
            foreach ($this->catid as $catids) {
                $data['total'] += $this->all_num($catids);
            }
        } else {
            $data['total'] = $this->all_num($this->catid);
        }
        echo json_encode($data);
    }

    /**
     * 獲取某一時段之後的所有文章的數目
     */
    private function all_num($catids) {
        $cat = intval($catids);
        $this->set_modelid($cat);
        $where = "status=99 AND catid IN ($catids) AND inputtime > $this->start";
        $count = $this->db->count($where);
        return $count;
    }
    
    /**
     * 獲取某分類下全部內容
     */
    public function getall($catids) {

        if ($this->category == 'all') {
            echo json_encode(array('code'=>'1','info'=>'category error'));
            exit;
        }

        $page = intval($_GET['page']);
        if ($page < 1) $page = 1;
        $pagesize = intval($_GET['limit']);
        if ($pagesize < 1) $pagesize = 1000;
        $start = ($page-1) * $pagesize;

        $cat = intval($this->catid);
        $this->set_modelid($cat);
        $where = "status=99 AND catid IN ($this->catid) AND inputtime > $this->start ORDER BY inputtime DESC LIMIT $start,$pagesize";

        $lists = $this->db->select($where, 'catid,id,title,url,thumb,description,inputtime');
        $return = array();
        foreach ($lists as $key=>$list) {
            $return[$key]['uniqid'] = $list['catid'].'0'.$list['id'];
            $return[$key]['title'] = $list['title'];
            $return[$key]['url'] = $list['url']."?from=sogou";
            $return[$key]['img'] = $list['thumb'];
            $return[$key]['summary'] = trim($list['description']);
            $return[$key]['datetime'] = date('Y-m-d h:i:s',$list['inputtime']);
        }
        
        echo json_encode($return);
    }

    /**
     * 獲取某分類下全部內容
     */
    public function getall_old() {

        $page = intval($_GET['page']);
        if ($page < 1) $page = 1;
        $pagesize = intval($_GET['limit']);
        if ($pagesize < 1) $pagesize = 1000;
        $start = ($page-1) * $pagesize;

        $ctag = pc_base::load_app_class('content_tag','content',1);
        $data = array();
        $data['catid'] = $this->catid;
        $data['limit'] = "$start,$pagesize";
        $data['order'] = 'inputtime DESC';

        $lists = $ctag->lists($data);
        $return = array();
        foreach ($lists as $key=>$list) {
            $return[$key]['uniqid'] = $list['id'];
            $return[$key]['title'] = $list['title'];
            $return[$key]['url'] = $list['url']."?from=sogou";
            $return[$key]['img'] = $list['thumb'];
            $return[$key]['summary'] = $list['description'];
            $return[$key]['datetime'] = date('Y-m-d h:i:s',$list['inputtime']);
        }
        echo json_encode($return);
    }

    /**
     * 獲取 新增/更新 內容條目數量
     */
    private function update_num($catids) {

        $cat = intval($catids);
        $this->set_modelid($cat);

        if ($this->type == 'update') {
            $where = "status=99 AND catid IN ($catids) AND updatetime >= $this->start AND updatetime <= $this->end AND inputtime != updatetime";
        } else {
            $where = "status=99 AND catid IN ($catids) AND inputtime >= $this->start AND inputtime <= $this->end";
        }

        $count = $this->db->count($where);
        return $count;
    }

    /**
     * 獲取全部 新增/更新 內容條目數量
     */
    function getupdate_num() {
        $data['category'] = $this->category;
        $data['total'] = 0;
        if ($this->category == 'all') {
            foreach ($this->catid as $catids) {
                $data['total'] += $this->update_num($catids);
            }
        } else {
            $data['total'] = $this->update_num($this->catid);
        }
        echo json_encode($data);
    }

    /**
     * 獲取 新增/更新 內容
     */
    public function getupdate() {

        if ($this->category == 'all') {
            echo json_encode(array('code'=>'1','info'=>'category error'));
            exit;
        }

        $page = intval($_GET['page']);
        if ($page < 1) $page = 1;
        $pagesize = intval($_GET['limit']);
        if ($pagesize < 1) $pagesize = 1000;
        $start = ($page-1) * $pagesize;

        $cat = intval($this->catid);
        $this->set_modelid($cat);
        if ($this->type == 'update') {
            $where = "status=99 AND catid IN ($this->catid) AND updatetime >= $this->start AND updatetime <= $this->end AND inputtime != updatetime ORDER BY inputtime DESC LIMIT $start,$pagesize";
        } else {
            $where = "status=99 AND catid IN ($this->catid) AND inputtime >= $this->start AND inputtime <= $this->end ORDER BY inputtime DESC LIMIT $start,$pagesize";
        }

        $lists = $this->db->select($where, 'catid,id,title,url,thumb,description,inputtime');
        $return = array();
        foreach ($lists as $key=>$list) {
            $return[$key]['uniqid'] = $list['catid'].'0'.$list['id'];
            $return[$key]['title'] = $list['title'];
            $return[$key]['url'] = $list['url']."?from=sogou";
            $return[$key]['img'] = $list['thumb'];
            $return[$key]['summary'] = trim($list['description']);
            $return[$key]['datetime'] = date('Y-m-d h:i:s',$list['inputtime']);
        }
        
        echo json_encode($return);
    }

    /**
     * 獲取下架內容
     */
    public function getbroken() {

        if ($this->category == 'all') {
            echo json_encode(array('code'=>'1','info'=>'category error'));
            exit;
        }

        $page = intval($_GET['page']);
        if ($page < 1) $page = 1;
        $pagesize = intval($_GET['limit']);
        if ($pagesize < 1) $pagesize = 10000;
        $start = ($page-1) * $pagesize;

        $cat = intval($this->catid);
        $this->set_modelid($cat);
        $where = "status != 99 AND catid IN ($this->catid) AND inputtime > $this->start ORDER BY inputtime DESC LIMIT $start,$pagesize";

        $lists = $this->db->select($where, 'catid,id,title,url');
        $str['total'] = count($lists);
        $return = array();
        foreach ($lists as $key=>$list) {
            $return[$key]['uniqid'] = $list['catid'].'0'.$list['id'];
            $return[$key]['title'] = $list['title'];
            $return[$key]['url'] = $list['url']."?from=sogou";
        }

        $str['ids'] = json_encode($return);
        
        echo json_encode($str);

    } 

}
