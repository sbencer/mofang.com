<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');

/**
 * 魔方其他站點調用PHPCMS信息的接口
 * http://www.mofang.com/api.php?op=relation&a=news&num='.$limit.'&gameid='.$gameId&type=new; 
 */

$action = trim($_GET['a']);
if(in_array($action, array('news', 'video', 'zone', 'helper', 'video_new'))) {
    $limit = intval($_GET['num'])?:5;
    //$gameinfo['model_id'] = intval($_GET['modelid']);
    //$gameinfo['content_id'] = intval($_GET['gameid']);
    $gameinfo = intval($_GET['gameid']);
    $game_type = $_GET['type'] ? $_GET['type'] : 'old';
    $from = $_GET['from'] ? $_GET['from'] : 'fahao';
    if(!in_array($game_type, array("new","old"))){
         exit('Parameter error');
    }
    if($game_type=='old'){
        if(!$gameinfo['model_id'] || !$gameinfo['content_id']) {
            exit('Parameter is not complete');
        }
    }
    echo $action($gameinfo,$limit,$game_type, $from);
} elseif (in_array($action,array('game'))) {
    $appid = intval($_GET['appid']);
    if(!$appid) {
        exit('Parameter is not complete');
    }
    echo $action($appid);
} else {
    echo init();
}


/**
 * 未注冊方法 無權限提示
 */
function init() {
    exit('No permission resources.');
}

/**
 * 最新關聯資訊數據調用
 */
function news($gameinfo,$limit,$game_type, $from) {
    $ctag = pc_base::load_app_class('content_tag','content',1);
    $data = $ctag->gameinfo_lists(array('catid'=>'10000050', 'gameid'=>array($gameinfo), 'order'=>'inputtime DESC','limit'=>$limit,'thumb'=>1,'game_type'=>$game_type));
    if($from != "fahao") {
        if($data) {
            $return['code'] = 0;    
            $return['data'] = $data;    
        } else {
            $return['code'] = 1;    
            $return['data'] = array();    
        }
    } else {
        $return = $data;    
    }
    return json_encode($return);
}

/**
 * 最新關聯視頻數據調用
 */
function video($gameinfo,$limit,$game_type, $from) {
    $ctag = pc_base::load_app_class('content_tag','content',1);
    $data = $ctag->gameinfo_lists(array('catid'=>'10000058', 'gameid'=>array($gameinfo), 'order'=>'inputtime DESC','limit'=>$limit,'thumb'=>1, 'moreinfo'=>1,'game_type'=>$game_type));
    if($from != "fahao") {
        if($data) {
            $return['code'] = 0;    
            $return['data'] = $data;    
        } else {
            $return['code'] = 1;    
            $return['data'] = array();    
        }
    } else {
        $return = $data;    
    }
    return json_encode($return);
}

/**
 * 關聯專區調用
 */
function zone($gameinfo,$limit,$game_type) {
    $ctag = pc_base::load_app_class('content_tag','content',1);
    $data = $ctag->gameinfo_lists(array('catid'=>'10000070', 'gameid'=>array($gameinfo), 'order'=>'inputtime DESC','limit'=>$limit,'thumb'=>1, 'moreinfo'=>1,'game_type'=>$game_type));
    if($data) {
        $return['code'] = 0;    
        $return['data'] = $data;    
    } else {
        $return['code'] = 1;    
        $return['data'] = array();    
    }
    return json_encode($return);
}

/**
 * 關聯助手調用
 */
function helper($gameinfo,$limit,$game_type) {
    $ctag = pc_base::load_app_class('content_tag','content',1);
    $data = $ctag->gameinfo_lists(array('catid'=>'277', 'gameid'=>array($gameinfo), 'order'=>'inputtime DESC','limit'=>$limit,'thumb'=>1, 'moreinfo'=>1,'game_type'=>$game_type));
    $data = array_values($data);
    if($data) {
        $return['code'] = 0;    
        $iospackage = array_values(string2array($data[0]['iospackage']));
        $andpackage = array_values(string2array($data[0]['andpackage']));
        $data[0]['iospackage'] = $iospackage[0]?:'';
        $data[0]['andpackage'] = $andpackage[0]?:'';
        $return['data'] = $data;    
    } else {
        $return['code'] = 1;    
        $return['data'] = array();    
    }
    return json_encode($return);
}

/**
 * 依關聯新庫ID，查詢遊戲對應視頻，查472 473欄目下
 */
function video_new($gameinfo,$limit='1',$game_type='new') {
    $relation_game_db = pc_base::load_model('relation_game_model');
    $sql = ' `gameid`='.$gameinfo['content_id'].' AND catid in(472,473)';
    $array = $relation_game_db->select($sql,'*',$gameinfo['num'],'addtime desc');
    if(!empty($array)){//數據不為空，查視頻標題等信息
        $content_db = pc_base::load_model('content_model');
        $content_db->set_model(11);
        foreach ($array as $key => $value) {
            $video_array = $content_db->get_content($value['catid'],$value['id']);
            $array[$key]['title'] = $video_array['title'];
            $array[$key]['description'] = $video_array['description'];
            $array[$key]['keywords'] = $video_array['keywords'];
            $array[$key]['url'] = $video_array['url'];
            $array[$key]['updatetime'] = $video_array['updatetime'];
            $array[$key]['thumb'] = $video_array['thumb'];
            $array[$key]['letv_id'] = $video_array['letv_id'];
            $array[$key]['youkuid'] = $video_array['youkuid'];
            $array[$key]['tudou_id'] = $video_array['tudou_id'];

            $array[$key]['v56_id'] = $video_array['v56_id'];
            $array[$key]['v17173_id'] = $video_array['v17173_id'];
            $array[$key]['vqq_id'] = $video_array['vqq_id'];
        }
        
    }
    
    //組成返回數據
    $return_array = array();
    $return_array['code'] = 0;
    $return_array['msg'] = 'ok';
    $return_array['data'] = $array;

    //JSON返回
    $return = json_encode($return_array);
    return $return; 
}


/**
 * 根據appid查詢gameid
 */
function game($appid,$catid=134) {
    $ctag = pc_base::load_app_class('content_tag','content',1);
    $gameinfo = $ctag->lists(array('where'=>"appid={$appid}",'catid'=>$catid,'limit'=>1));
    if($gameinfo) {
        foreach($gameinfo as $id=>$null) {
            return $id;
        }
    } else {
        return 0;
    }
}

