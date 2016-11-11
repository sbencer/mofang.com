<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
// header('Content-Type: application/json');

$digg = new digg;
$true_action = trim($_GET['action']);

$return = array();

if(!method_exists($digg,$true_action)){
    $return['code'] = -1;
    $return['message'] = '接口方法不存在，请检查!';
    $return['data'] = "";
} else {
    $return = $digg->$true_action(); 
}
$callback = isset($_GET['jsonpcallback']) ? trim($_GET['jsonpcallback']) : ( isset($_GET['callback']) ? trim($_GET['callback']) : "" );
if($callback){
    echo $callback."(".json_encode($return).")";
}else{
    echo json_encode($return);
}
exit;

/**
  * 方法1 mk_get_digg 通过ztid查询digg表对应字段zt_id 有即为查询 没有插入新数据，返回digg、down值
  * 方法2 up_down_digg 通过ztid &type=digg(顶)||&type=down(踩) 更新对应数据的顶踩数值 并返回最新digg、down值 
  * 
  * 例：1.www.mofang.com/api_v2.php?op=mofang&file=digg&action=mk_get_digg&ztid=$1
  * 例：2.www.mofang.com/api_v2.php?op=mofang&file=digg&action=up_down_digg&ztid=$1&type=$2
  * 2015.8.5 周蕊  
  */
class digg {
	function __construct()
	{
		
	}
	// 获取、插入 顶踩数据 参数ztid 
	public function mk_get_digg(){
		$zt_id = safe_replace($_GET['ztid']);
		$digg = pc_base::load_model('digg_model');
		$re = $digg->get_one(array("zt_id"=>$zt_id));
		if (!$re) {
			$digg->insert(array("zt_id"=>$zt_id,"inputtime"=>time()),true);
		}
		$digg_array = $digg->get_one(array("zt_id"=>$zt_id));

		if($digg_array){
			$new_array['code'] = 0;
			$new_array['message'] = "ok";
			$new_array['data']['digg'] = $digg_array['digg'];
			$new_array['data']['down'] = $digg_array['down'];
		}else{
			$new_array['code'] = 1;
			$new_array['message'] = "ok";
			$new_array['data']['digg'] = 0;
			$new_array['data']['down'] = 0;
		}
		return $new_array;
	}
	// 更新顶踩数据 参数ztid type
	public function up_down_digg(){
		$zt_id = trim($_GET['ztid']);
		$type = trim($_GET['type']);
		$type_array = array("digg","down");
		if(!in_array($type, $type_array)|| !$zt_id){
			echo 0;
			exit;
		}
		$id = intval($_GET['id']);
		$digg = pc_base::load_model('digg_model');
		$digg_array = $digg->get_one(array("zt_id"=>$zt_id));
		if(!$digg_array || empty($digg_array)){
			echo 0;
			exit;
		}
		switch ($type) {
			case 'digg':
				$num = $digg_array['digg']+1;
				$sql = array("digg"=>$num);
				$new_array['code'] = 0;
				$new_array['message'] = "ok";
				$new_array['data']['digg'] = "$num";
				$new_array['data']['down'] = $digg_array['down'];
				break;
			case 'down':
				$num = $digg_array['down']+1;
				$sql = array("down"=>$num);
				$new_array['code'] = 0;
				$new_array['message'] = "ok";
				$new_array['data']['digg'] = $digg_array['digg'];
				$new_array['data']['down'] = "$num";
				break; 
		}
		$digg->update($sql,array("zt_id"=>$zt_id));
		return $new_array;
	}
}