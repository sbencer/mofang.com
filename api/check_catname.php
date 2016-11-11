<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
*  欄目英文目錄，重復性檢測  
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-3).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 

class check_catname {
    public function __construct() {
        $this->category_db = pc_base::load_model('category_model'); //欄目數據模型
        $this->partition_db = pc_base::load_model('partition_model');
        $this->db_content = pc_base::load_model('content_model');
        $this->cf_catdir_db = pc_base::load_model('cf_catdir_model');
    }

    //主檢查程序
    public function init(){
        $MODEL = getcache('model','commons');
        //循環所有欄目，查詢category表是否有重復的英文目錄，以及專區是否重名
        $array = array();
        $pagesize = 20;
        $page = 1; 
        $start = 0; 
        while($start>=0){
            $offset = $pagesize*($page-1);
            $limit = "$offset,$pagesize";
            $rs = $this->category_db->query("select catid,catname,catdir from www_category where `arrparentid` like '%1014%' ORDER BY catid desc limit $limit");
            $data = $this->category_db->fetch_array(); 
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    $cat_array = array();
                    $cat_array = $this->check_catdir($value['catid'],$value['catdir']);//檢查除了自己，所有重名的欄目信息
                    if(!empty($cat_array)){
                        $new_array = array();
                        $new_array['catid'] = $value['catid'];
                        $new_array['catname'] = $value['catname'];
                        $new_array['catdir'] = $value['catdir'];
                        $new_array['cf_setting'] = array2string($cat_array);
                        // $array[$value['catid']]['catname'] = $value['catname'];
                        // $array[$value['catid']]['catdir'] = $value['catdir'];
                        // $array[$value['catid']]['data'] = $cat_array;
                        $cfid = $this->cf_catdir_db->insert($new_array);
                        setcache('check_catdir_'.$value['catid'], $new_array,'partition');
                    }
                }
                // if(!empty($array)){
                //   setcache('check_catdir_'.$page, $array,'partition');
                // }
                $page = $page+1;
                $start = 0;
            }else{
                //結果為空，說明查詢已經到最後
                echo '查詢全部結果！';
                $start = -1;
                exit();
            }
        }
    }//end init 

    //根據catid,catdir 檢查與其重名的其它欄目信息
    public function check_catdir($catid,$catdir){
        $array = array();
        $array['category_array'] = $this->category_db->select(array("catdir"=>$catdir),'catid,catname,catdir','','','','catid');
        if($array['category_array'][$catid]){
            unset($array['category_array'][$catid]);
        }
        $array['partition_array'] = $this->partition_db->select(array("domain_dir"=>$catdir),'catid,catname,domain_dir');
        if(!empty($array['partition_array']) ||  !empty($array['category_array'])){
            return $array;
        }else{
            return false;
        }
    }
}

$check_catname = new check_catname();
$check_catname->init();

?>
