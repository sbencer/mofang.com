<?php

/**
 * [魔方游戏宝 v1] 接口
 * 王官庆  star time: 2013-10-17
 * 频道相关的接口
 * 一、 get_channel 获取频道列表 （支持用户频道获取）
 * 二、change_user_channel 修改用户选择频道
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
$channel = new channel;
$action = $_SERVER['REQUEST_URI'];
$a = explode('?', $action);
$b = explode('/', $a[0]);
$b_num = count($b); 
$true_action = $b[$b_num-1]; 
if(!method_exists($channel,$true_action)){
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
$channel->$true_action($_GET);

class channel {

	function __construct() { 
    }

    /**
     * 获取频道列表 （支持用户选择频道的获取）
     */
    function get_channel($get_data) {
        $userid = intval($get_data['userid']);//用户ID  
		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序


		//定义文章数组
		$article_array = array(); 
		$user_channel_db= pc_base::load_model('app_user_channel_model');
		$channel_db= pc_base::load_model('app_channel_model');

		$ordertype_array = array("listorder asc","id asc");


		$channel_array = array();
		$userchannel_array = array();

		//所有开放状态的频道
		$channel_array = $channel_db->listinfo(array("status"=>1), $ordertype_array[$ordertype], 1, 30,'id');
		if($userid){
			// 按用户查询
			$user_channel_array = $user_channel_db->get_one(array("userid"=>$userid), '*');
			if($user_channel_array){
				// 用户关注的频道
				$user_channel = explode(',', $user_channel_array['channelid']);
				foreach ($user_channel as $key => $value) {
					# code...
					if($channel_array[$value]){
						$new_u_channel[$value] = $channel_array[$value];
					}
					
				}
				//处理后添加的锁定频道（此时未存在于用户的关注频道里）
				foreach ($channel_array as $k => $val) {
					# code...
					if($val['is_lock']==1 && !in_array($val['id'], $new_u_channel)){
						$new_u_channel[$val['id']] = $val;
					}
				}
				// 求未关注的频道
				$user_channel = $new_u_channel;
				$other_channel  = 	array_diff_key($channel_array, $new_u_channel); 
			}else{
				//获取默认显示频道作为用户初始数据
				$user_channel = $channel_db->listinfo(array("default"=>1,"status"=>1), $ordertype_array[$ordertype], 1, 6,'id');
				//未关注频道，为所有频道
				$other_channel = array_diff_key($channel_array,$user_channel);
			}
			
		}else{
			//无用户USERID
			$user_channel = $channel_db->listinfo(array("default"=>1,"status"=>1), $ordertype_array[$ordertype], 1, 6,'id');
			$other_channel = array_diff_key($channel_array,$user_channel);//未关注频道，为所有频道
		}

		/**
		 * 过滤数据去除索引，做JSON
		 */
		if(!empty($user_channel)){
			foreach ($user_channel as $key => $value) {
				# code...
				$n_u_channel[] = $value;
			}
		}

		if(!empty($other_channel)){
			foreach ($other_channel as $key => $value) {
				# code...
				$n_o_channel[] = $value;
			}
		}


		$return = array();
		$return['code'] = 0;
		$return['message'] = '数据返回正常!';
		$return['data']['userid'] = $user_channel_array['userid'];
		$return['data']['user_channel'] = $n_u_channel;
		$return['data']['other_channel'] = $n_o_channel;
		$return = json_encode($return);

		if($get_data['test']=='test'){
			print_r($article_array);exit;
		}else{
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
		}
    }


    /**
     * 修改用户所选频道
     */
    
    function change_user_channel($get_data){
    	$userid = intval($get_data['userid']);//用户ID  
		$ids = safe_replace($get_data['user_channelid']);//用户选择的频道  


		//定义文章数组
		$article_array = array(); 
		$user_channel_db= pc_base::load_model('app_user_channel_model');
		$channel_db= pc_base::load_model('app_channel_model');

		$ordertype_array = array("listorder asc","id asc");


		$channel_array = array();
		$userchannel_array = array();

		if($userid){
			// 按用户查询
			$user_channel_array = $user_channel_db->get_one(array("userid"=>$userid), '*');
			if($user_channel_array && !empty($user_channel_array)){
				$user_channel_db->update(array("channelid"=>$ids),array('userid'=>$userid));
			}else{
				$into_data['userid'] = $userid;
				$into_data['channelid'] = $ids;
				$into_data['status'] = 1;
				$user_channel_db->insert($into_data,1); 
			}
		}else{
			//无用户
			$return = array();
			$return['code'] = -1;
			$return['message'] = '输入参数异常!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}

		$return = array();
		$return['code'] = 0;
		$return['message'] = '用户频道更新成功!';
		$return['data']= '';
		$return = json_encode($return);
		
		if($callback){
			echo $callback."($return)";
		}else{
			echo $return;
		}
		exit();
    }

}
?>	