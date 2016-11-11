<?php

/**
 * [魔方游戏宝 v1] 接口
 * 王官庆  star time: 2015-5-1
 * 点击统计
 * 一、 增加-点击统计次数接口
 * 二、 获取-点击统计次数接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
$count = new count;
$action = $_SERVER['REQUEST_URI'];
$a = explode('?', $action);
$b = explode('/', $a[0]);
$b_num = count($b); 
$true_action = $b[$b_num-1]; 
if(!method_exists($count,$true_action)){
	$return = array();
	$return['code'] = -1;
	$return['message'] = '接口不存在，请检查!';
	$return['data'] = '';
	$return = json_encode($return);
	if($callback){
		echo $callback."($return)";
	}else{
		echo $return;
	}
	exit;
}
$count->$true_action($_GET);

class count {

	function __construct() { 
    }

    /**
     * 增加点击统计次数
     */
    function set_count($get_data) {
    	$modelid = intval($get_data['modelid']);
    	$id = intval($get_data['id']);

    	if(!$modelid || !$id){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '参数不正确!';
			$return['data'] = '';
			$return = json_encode($return);
			echo $return;exit;
    	}

		$hitsid = 'c-'.$modelid.'-'.$id;
		$db = pc_base::load_model('hits_model');

		
		$redis_db = pc_base::load_model('redis_model');
		$click_num = $redis_db->redis_get("cms:art:click:".$hitsid);
		if(!$click_num){//不存在此key
			$r = $db->get_one(array('hitsid'=>$hitsid));
			if(!$r){
				$return = array();
				$return['code'] = -1;
				$return['message'] = '未取到正常的统计数据!';
				$return['data'] = '';
				$return = json_encode($return);
				echo $return;exit;
			}else{
				//查出来数据入set中，有了就不再增加，没有就入set
				$redis_db->redis_sadd("cms:art:click:set",$hitsid);
				// $a = $redis_db->redis_sismember("cms:art:click:set",$hitsid); 
				$redis_db->redis_set("cms:art:click:".$hitsid,$r['views']+1);
			}
		}else{
			$click_num = $redis_db->redis_incr("cms:art:click:".$hitsid);
		}

		//余下直接返回，redis to mysql 由定时任务执行

		$return = array();
		$return['code'] = 0;
		$return['message'] = '点击统计更新正确!';
		$return['data'] = '';
		$return = json_encode($return);
		echo $return;
		exit();
		
    }

}
?>	