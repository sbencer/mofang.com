<?php

/**
 * [魔方游戏宝 v1] 接口
 * 王官庆  star time: 2015-10-17
 * 接口说明：
 * bbs_to_catid（） 根据扎堆游戏的ID，获取对应攻略下面的文章列表
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
     * 根据bbsid获取对应的攻略ID 
     */
    function bbs_to_catid($get_data) {
        $bbsid = intval($get_data['bbsid']);//论坛ID
        $page = max(intval($get_data['page']),1);//分页
		$callback = safe_replace($get_data['callback']);
		$pagesize = $get_data['pagesize'] ? intval($get_data['pagesize']) : 15 ;//每页条数

        if(!$bbsid){
        	$return = array();
			$return['code'] = -1;
			$return['message'] = '请传递论坛ID!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
        }
		//获取游戏对应的攻略栏目ID
		$array = array(); 
		$app_bbstocatid_db= pc_base::load_model('app_bbstocatid_model'); 
		$array = $app_bbstocatid_db->get_one(array("bbsid"=>$bbsid));
		if(!$array || empty($array)){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '无对应的攻略信息，请添加!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}

		//加载专区的数据模型
		$this->db_partition = pc_base::load_model('partition_model');
        $this->db_partition_games = pc_base::load_model('partition_games_model');
        $this->db_content = pc_base::load_model('content_model');

		//获取对应栏目下的文章列表信息
		$temp_arrchildid = $this->db_partition->get_one('`catid`='.$array['catid'], 'arrchildid');

		//如果专区不存在此栏目，则直接返回空数组
	    $new_data = array();
		if(empty($temp_arrchildid) || $temp_arrchildid['arrchildid']==''){
			$part_info_ids = $this->db_partition_games->listinfo('`part_id` IN ('.$temp_arrchildid['arrchildid'].') AND `status`=99', 'inputtime desc ', $page, $pagesize);

	        $part_info_array = array();
	        foreach( $part_info_ids as $key=>$value ){
	            $this->db_content->set_model($value['modelid']);
	            $part_info_array[] = $this->db_content->get_one('`id`='.$value['gameid'], 'id,catid,url,title,shortname,thumb,description,updatetime');
	        }
	        foreach ($part_info_array as $key => $value) {
	        	# code...
	        	$new_data[$key] = $value;
	        	$new_data[$key]['modelid'] = 1;
	        	$new_data[$key]['url'] = $value['url'].'?wap=1&comefrom=mofangapp';
	        }
		}

        //数据返回
		$return = array();
		$return['code'] = 0;
		$return['message'] = '数据返回正常!';
		$return['data'] = $new_data;
		$return = json_encode($return);
		//jsonp
		if($callback){
			echo $callback."($return)";
		}else{
			echo $return;
		}
		exit();
    }
 

}
?>	