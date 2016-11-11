<?php
/**
 * 提供給加加官網 http://jiajia.mofang.com 活動列表數據
 * @author Jozhliu
 * 2014-07-04
 */
$db = pc_base::load_model('content_model');
$db->set_model('32');
$lists = $db->select(array('catid'=>1049), '`title`, `thumb`, `url`, `startofevent`, `endofevent`, `description`', '5', '`inputtime` DESC');

foreach($lists as $k => $v){
    foreach($v as $_k=>$_v){
        if(strtotime($v['startofevent'])>time()){
            $near[$k]['status'] = '即將開始';
            if(in_array($_k,array('startofevent','endofevent'))){
                $near[$k][$_k] = date('m月d日',strtotime($_v));
            }else{
                $near[$k][$_k] = $_v;
            }
        }elseif(strtotime($v['startofevent'])<time() && strtotime($v['endofevent'])>time()){
            $now[$k]['status'] = '進行中';
            if(in_array($_k,array('startofevent','endofevent'))){
                $now[$k][$_k] = date('m月d日',strtotime($_v));
            }else{
                $now[$k][$_k] = $_v;
            }
        }elseif(strtotime($v['endofevent'])<time()){
            $ago[$k]['status'] = '已結束';
            if(in_array($_k,array('startofevent','endofevent'))){
                $ago[$k][$_k] = date('m月d日',strtotime($_v));
            }else{
                $ago[$k][$_k] = $_v;
            }
        }
    }
}
sort($near) ? : $near = array();
sort($now) ? : $now = array();
sort($ago) ? : $ago = array();
$list_info = array_merge($near, $now, $ago);
echo json_encode($list_info);
