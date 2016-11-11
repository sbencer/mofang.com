<?php
//投票對象
$type = addslashes($_GET['type']);
$num = $_GET['num'];
$vote_arr = array('nixi','jinji','julebu','juesha','baxi','fifa');

$content = file_get_contents(dirname(__FILE__) . '/world_cup_vote.txt');

//如果傳值，則讀取並自增返回
if($type && in_array($type,$vote_arr) && !$num){
    $content_arr = explode(' ',$content);
    foreach($content_arr as $k=>$v){
        $one = explode(',',$v);
        if($one[0] == $type){
            $one[1]++;
        }
        $content_arr[$k] = implode(',',$one);
    }
    $new_content = implode(' ',$content_arr);
    file_put_contents(dirname(__FILE__) . '/world_cup_vote.txt', $new_content);
    echo 1;
}elseif($num && $type){//傳值兩個參數，則讀取並重寫返回
    $content_arr = explode(' ',$content);
    foreach($content_arr as $k=>$v){
        $one = explode(',',$v);
        if($one[0] == $type){
            $one[1] = $num;
        }
        $content_arr[$k] = implode(',',$one);
    }
    $new_content = implode(' ',$content_arr);
    file_put_contents(dirname(__FILE__) . '/world_cup_vote.txt', $new_content);
    echo 'ok';
}else{//沒傳值，則讀取返回
    echo $content; 
}

