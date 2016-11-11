<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
*  專區英文目錄全站重復性檢測  
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
        $this->cf_partitiondir_db = pc_base::load_model('cf_partitiondir_model');
    }

    //主檢查程序
    public function init(){
        $MODEL = getcache('model','commons');
        //循環所有專區主欄目，查詢www_partition表是否有重復的英文目錄，以及與欄目是否重名
        $array = array();
        $pagesize = 20;
        $page = 1; 
        $start = 0; 
        while($start>=0){
            $offset = $pagesize*($page-1);
            $limit = "$offset,$pagesize";
            $rs = $this->partition_db->query("select catid,catname,domain_dir from www_partition where `parentid`='0' ORDER BY catid desc limit $limit");
            $data = $this->partition_db->fetch_array(); 
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    $cat_array = array();
                    $cat_array = $this->check_catdir($value['catid'],$value['domain_dir']);//檢查除了自己，所有重名的欄目信息
                    if(!empty($cat_array)){
                        $new_array = array();
                        $new_array['catid'] = $value['catid'];
                        $new_array['catname'] = $value['catname'];
                        $new_array['domain_dir'] = $value['domain_dir'];
                        $new_array['cf_setting'] = array2string($cat_array);
                        // $array[$value['catid']]['catname'] = $value['catname'];
                        // $array[$value['catid']]['catdir'] = $value['catdir'];
                        // $array[$value['catid']]['data'] = $cat_array;
                        $cfid = $this->cf_partitiondir_db->insert($new_array);
                        setcache('check_partition_'.$value['domain_dir'], $new_array,'partition');
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
        if(!empty($array['category_array'])){
           return  $array['category_array'];    
        }else{
           return false;
        }
        // if($array['category_array'][$catid]){
        //     unset($array['category_array'][$catid]);
        // }
        // $array['partition_array'] = $this->partition_db->select(array("domain_dir"=>$catdir),'catid,catname,domain_dir');
        // if(!empty($array['partition_array']) ||  !empty($array['category_array'])){
        //     return $array;
        // }else{
        //     return false;
        // }
    }
}

$check_catname = new check_catname();
$check_catname->init();

?>
