<?php
// defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
* 根據後台專區和欄目的配置，把專區下所有文章裡的視頻導入到對應的欄目中（允許多個專區對應一個欄目 ）  
*/ 

define('PHPCMS_PATH', substr(dirname(__FILE__),0,-3).DIRECTORY_SEPARATOR);
include PHPCMS_PATH.'phpcms/base.php'; 
$param = pc_base::load_sys_class('param');
ob_start(); 

$db = pc_base::load_model('partition_model');
$db_content = pc_base::load_model('content_model');
$db_partition_games = pc_base::load_model('partition_games_model');
$db_partition_relationgames = pc_base::load_model('partition_relationgames_model');

$MODEL = getcache('model','commons');

//獲取以前的配置
$old_setting = getcache('partitionid_catid','partition');
$old_setting = array_flip($old_setting);
$new_array = array();
foreach ($old_setting as $key => $value) {
    # code...
    if($value!=''){
        if(strpos($key, '|')){
            $array = explode("|", $key);
            foreach ($array as $key_2 => $value_2) {
                # code...
                $new_array[$value_2] = $value;
            }
        }else{
            $new_array[$key] = $value;
        }
    }
    
}
//循環所有專區文章，對比所在欄目屬於那個專區，進行視頻查找入庫
$db_content->set_model(1);
$pagesize = 20;
$page = 1; 
$start = 0;   
while($start>=0){
    $offset = $pagesize*($page-1);
    $limit = "$offset,$pagesize";
    $rs = $db_partition_games->query("select * from www_partition_games ORDER BY id asc limit $limit");
    $data = $db_partition_games->fetch_array(); 
    if(!empty($data)){
        //判斷文章中是否有視頻，有則按對應關系導入，無則跳過
        foreach ($data as $key => $value) {
            # code...
            // $array = array();
            // $insert_data = array();
            // $title_array = array();
            $insert_data = array();
            $title_array = $db_content->get_content( 81, $value['gameid']);
            if($title_array['content']!=''){
                //過渡是否有youku的視頻
                $content = $title_array['content'];
                preg_match_all("/\<embed.*?src\=\"(.*?)\"[^>]*>/i", $content, $match);
                if(strpos($match[1][0],'youku')){
                    //youku
                    $array = explode("/", $match[1][0]);
                    $insert_data['youkuid'] = $array[5];
                    $is_video = 1;//是視頻
                }elseif(strpos($match[1][0],'56')){
                    //56
                    $array = explode("/", $match[1][0]);
                    $array = explode(".", $array[3]);
                    $insert_data['v56_id'] = $array[0];
                    $is_video = 1;
                }elseif(strpos($match[1][0],'qq')){
                    //qq
                    $array = explode("/", $match[1][0]);
                    $array = explode(".", $array[3]);
                    $insert_data['vqq_id'] = $array[0];
                    $is_video = 1;
                }elseif (strpos($match[1][0],'tudou')) {
                    # 土豆
                    $array = explode("/", $match[1][0]);
                    $insert_data['tudou_id'] = $array[4];
                    $is_video = 1;
                }else{
                    $is_video = 0 ;
                }
                if($is_video==1){
                    $insert_data['title'] = $title_array['title'];
                    // $insert_data['shortname'] = $title_array['shortname'];
                    $insert_data['thumb'] = $title_array['thumb'];
                    $insert_data['keywords'] = $title_array['keywords'];
                    $insert_data['description'] = $title_array['description'];
                    $insert_data['vision'] = 1;//畫質
                    $insert_data['video_category'] = 1;//視頻分類
                    $insert_data['inputtime'] = SYS_TIME;//增加時間
                    $insert_data['status'] = 99;//視頻狀態
                    $insert_data['sysadd'] = 1;//系統添加
                    //統計視頻對應的ID 
                    $partition_array = $db->get_one(array("catid"=>$value['part_id']),'catid,arrparentid,catname');
                    $cat_array = explode(',', $partition_array['arrparentid']);
                    sort($cat_array); //順序排序 ，以0為起啟
                    $insert_data['catid'] = $new_array[$cat_array[1]];//視頻分類
                    if($insert_data['catid']!=''){
                        $db_content->set_model(11);
                        $id = $db_content->add_content($insert_data,1);//入視頻指定欄目 
                        unset($id);
                    }
                }                 
            }
        }
        $page = $page+1;
        $start = 0;
    }else{
        //結果為空，說明查詢已經到最後
        echo '查詢全部結果！';
        $start = -1;
        exit();
    }
}
?>
