<?php
/**
 * 提供給淘寶的手遊全攻略數據，導入excel文件
 * @author Jozhliu
 * 2014-07-15
 */
$db = pc_base::load_model('content_model');
$db->set_model(11);
$lists = $db->select("`catid` = 472 and `title` like '手遊全攻略%'", 'id,title,thumb,keywords,description,url,gameid,videotime,shortname', '1500', '`inputtime` DESC');
$db->table_name = $db->table_name.'_data';
foreach($lists as $k => $v){
    $re = $db->get_one(array('id'=>$v['id']), 'letv_id');
    $lists[$k]['letv_id'] = $re['letv_id'];
}

exportexcel($lists, array(id,title,thumb,keywords,description,url,gameid,videotime,shortname,letv_id), 'new_game_video');

/**
*   導出數據為excel表格
*   @param $data    一個二維數組,結構如同從數據庫查出來的數組
*   @param $title   excel的第一行標題,一個數組,如果為空則沒有標題
*   @param $filename 下載的文件名
*   @examlpe
    exportexcel($arr,array('id','賬戶','密碼','暱稱'),'文件名!');
*/
function exportexcel($data=array(),$title=array(),$filename='report'){
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //導出xls 開始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            $title[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
            }
            $data[$key]=implode("\t", $data[$key]);

        }
        echo implode("\n",$data);
    }
}

