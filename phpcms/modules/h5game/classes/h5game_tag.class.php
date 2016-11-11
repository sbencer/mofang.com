<?php
defined('IN_PHPCMS') or exit('No permission resources.');
class h5game_tag {
	private $db,$position_h5game_db;

	public function __construct(){
		$this->db = pc_base::load_model('h5game_model');
		$this->position_h5game_db = pc_base::load_model('position_h5game_model');
	}

	/*
	* H5小遊戲推薦位
	*/
	public function position_new($data){
		$positionid = intval($data['positionid']);
		$number = intval($data['number']);
		$array = $this->position_h5game_db->select(array("positionid"=>$positionid,"status"=>99),'*',$number,'listorder asc');
		if(!empty($array)){
			foreach ($array as $key => $value) {
				# code...
				$h5game_array = $this->db->get_one(array("id"=>$value['gameid']));
				$array[$key]['gamename'] = $h5game_array['gamename'];
				$array[$key]['link'] = $h5game_array['link'];
				$array[$key]['icon'] = $h5game_array['icon'];
				$array[$key]['android'] = $h5game_array['android'];
				$array[$key]['ios'] = $h5game_array['ios'];
				$array[$key]['ipad'] = $h5game_array['ipad'];
				$array[$key]['id'] = $h5game_array['id'];
				$array[$key]['hot'] = $h5game_array['hot'];
			}
		}
		return $array;
	}

	//遊戲推薦
	public function tuijian($data){
		$type = intval($data['type']);
		$number = intval($data['number']);
		switch ($type) {
			case 'android':
				$sql = array("android"=>1,"status"=>99);
				break;
			case 'ios':
				$sql = array("ios"=>1,"status"=>99);
				break;
			default:
				$sql = array("android"=>1,"status"=>99);
				break;
		}
		$array = $this->db->select($sql,'*',$number,'hot desc'); 
		return $array;
	}

	//獲取按熱點排序
	public function get_hotlist($data){
		$number = intval($data['number']); 
		$sql = ' `status`=99';
		$array = $this->db->select($sql,'*',$number,'hot desc'); 
		return $array;
	}

	//可能喜歡玩的遊戲
	public function get_like($data){
		$categoryid = $data['categoryid'];
		$number = $data['number'];
		$array = $this->db->select(array('category'=>$categoryid,'status'=>99),'*',$number,'id desc');
		//如果本欄目下內容太少，或者沒有從全庫查最近的遊戲
		if(empty($array)){
			$array = $this->db->select(array('status'=>99),'*',$number,'id desc');
		}
		return $array;
	}

	/*
	* H5小遊戲列表頁
	*/
	public function lists_new($data){
		$categoryid = intval($data['categoryid']);
		$number = intval($data['number']);
		$page = intval($data['page']);
		$system_type = $data['system_type'] ? $data['system_type'] : 'all';
		
		//初始查詢SQL
		// $sql = '';
		// if(!isset($_GET['type']) && isset($data['part'])){
		// if($system_type=='all'){
		// }

		$array = $this->position_h5game_db->select(array("positionid"=>$positionid,"status"=>99),'*',$number,'listorder asc');
		if(!empty($array)){
			foreach ($array as $key => $value) {
				# code...
				$h5game_array = $this->db->get_one(array("id"=>$value['gameid']));
				$array[$key]['gamename'] = $h5game_array['gamename'];
				$array[$key]['link'] = $h5game_array['link'];
				$array[$key]['icon'] = $h5game_array['icon'];
				$array[$key]['android'] = $h5game_array['android'];
				$array[$key]['ios'] = $h5game_array['ios'];
				$array[$key]['ipad'] = $h5game_array['ipad'];
			}
		}
		return $array;
	}
 

	

}
?>
