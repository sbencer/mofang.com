<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
//header('Content-Type: application/json');

/**
 * 其他站點調用魔方主站排行信息的接口
 */

$catid = (trim($_GET['platform']) == 'ios')?20:134;

$limit = intval($_get['num'])?:10;
if($limit <= 0) $limit = 10;
if($limit >= 100) $limit = 100;

$updatetime = mktime(0,0,0,date('m'),date('d'),date('y'));

if($_GET['request'] == '21cn') {
    // $rank_a = get_rank(134,$updatetime,$limit);
    // $data_a = json_decode($rank_a, true);
    // $rank_i = get_rank(20,$updatetime,$limit);
    // $data_i = json_decode($rank_i, true);

    //先從緩存裡取數據，如果沒有，則重新查詢數據庫，並生成緩存供下次直接使用
    if (!$res = getcache('rank_a_ranking', '', 'memcache', 'html')) {
        $rank_a = get_rank(134,$updatetime,$limit);
        $data_a = json_decode($rank_a, true);
        setcache('rank_a_ranking', $rank_a, '', 'memcache', 'html', 1800);
    }else{
        $rank_a = getcache('rank_a_ranking','','memcache','html');
        $data_a = json_decode($rank_a, true);
    }

    if (!$res = getcache('rank_i_ranking', '', 'memcache', 'html')) {
        $rank_i = get_rank(20,$updatetime,$limit);
        $data_i = json_decode($rank_i, true);
        setcache('rank_i_ranking', $rank_i, '', 'memcache', 'html', 1800);
    }else{
        $rank_i = getcache('rank_i_ranking','','memcache','html');
        $data_i = json_decode($rank_i, true);
    }


    require(PC_PATH."init/smarty.php");
    $smarty = use_v4();
    $smarty->assign('rank_i', array_slice($data_i['mf_ranking'],0,6));
    $smarty->assign('rank_a', array_slice($data_a['mf_ranking'],0,6));
    $smarty->display('content/side.tpl');
} else {
    echo get_rank($catid,$updatetime,$limit);
}


/**
 * 獲得排行榜數據，從緩存或者數據庫
 */
function get_rank($catid,$updatetime,$limit) {
    $db = pc_base::load_model(content_model);
    $sql = "select * from www_tmp_rank where updatetime={$updatetime} and model={$catid}";
    $db->query($sql);
    $result = $db->fetch_array(); 
    if($result) {
        $rank = $result[0]['data'];
    } else {
        $rank = ranking($catid,$limit);
        $data = addslashes($rank);
        //增加tmp_rank數據模型，強制走讀寫分離的流程 
        $tmp_rank_db = pc_base::load_model('tmp_rank_model');
        $tmp_array = array();
        $tmp_array['model'] = $catid;
        $tmp_array['data'] = $data;
        $tmp_array['updatetime'] = $updatetime;
        $tmp_rank_db->insert($tmp_array);

        // $result = $db->query("insert into www_tmp_rank (`id`,`model`,`data`,`updatetime`) values(null,{$catid},'{$data}',{$updatetime})");
    }

    return $rank;
}

/**
 * 周榜數據查詢
 */
function ranking($catid,$limit) {
    $ctag = pc_base::load_app_class('content_tag','content',1);

    $rank = $ctag->iosgame_lists(array('catid'=>$catid, 'order'=>'h.weekviews DESC', 'limit'=>$limit));
    foreach($rank as $v) {
        $info['title'] = $v['title'];
        $info['url'] = $v['url'];
        $info['img_url'] = $v['icon'];
        $info['title'] = $v['title'];
        $info['other'] = $v['tags'][2]['tag'];
        $rank_tmp['mf_ranking'][] = $info;
        $info = array();
    }

    return json_encode($rank_tmp);

}

