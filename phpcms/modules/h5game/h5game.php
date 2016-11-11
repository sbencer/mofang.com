<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class h5game extends admin{
	public function __construct(){
		parent::__construct();
		$this->db = pc_base::load_model('h5game_model');
		$this->content_db = pc_base::load_model('content_model');
	}

	public function init(){
		
		pc_base::load_sys_class('format', '', 0);
		$page=$_GET['page']?$_GET['page']:'1';
		$keywords = $_GET['keywords'];
		if($keywords!=''){
			$where = " `gamename` like '%$keywords%'" ;
		}else{
			$where = '';
		}
		$records=$this->db->listinfo($where,'`id` DESC',$page,$pagesize=6); 
		// $big_menu = array('?m=kaifu&c=admin_kaifu&a=add', L('kaifu_add'));//頂部列表
		$pages=$this->db->pages;
		include $this->admin_tpl('h5game_list');
	} 

	/*
	* 使用新產品庫的開服活動添加程序 
	* 新關聯的new_gameid ，新增加一個字段
	*/
	public function add(){
		if(isset($_POST['dosubmit'])){
			$info = $_POST['info'];
			if(empty($info['gamename']) || empty($info['link']) || empty($info['icon'])){
				showmessage('遊戲名和鏈接是必須的！','?m=h5game&c=h5game&a=add');
			}
			$info['comefrom'] = 0;//手動添加的數據
			$insertid=$this->db->insert($info); 
			if($insertid){
				showmessage('添加成功！','?m=h5game&c=h5game');
			}else{
				showmessage('添加失敗！','?m=h5game&c=h5game');
			}
		}else{
			$show_dialog=1;
			pc_base::load_sys_class('form','',0);
			$show_validator = $show_scroll = $show_header = true;
			pc_base::load_sys_class('form', '', 0);
			include $this->admin_tpl('h5game_add'); 
		}
	}
 

	public function delete() {
		if((!isset($_GET['id']) || empty($_GET['id']))&&(!isset($_POST['id']) || empty($_POST['id']))) {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		} else {
			if(is_array($_POST['id'])){
				foreach($_POST['id'] as $id_arr) {
					$this->db->delete(array('id'=>$id_arr));
				}
				showmessage(L('operation_success'),'?m=kaifu&c=admin_kaifu');
			}else{
				$id = intval($_GET['id']);
				if($id < 1) return false;					
				$this->db->delete(array('id'=>$id)); 
				showmessage(L('刪除成功！'), HTTP_REFERER);
			}
		}
	}
	
	public function edit(){
		if(isset($_POST['dosubmit'])){
			$info = $_POST['info'];
			if(empty($info['gamename']) || empty($info['link']) || empty($info['icon'])){
				showmessage('遊戲名和鏈接是必須的！',HTTP_REFERER);
			}
			$this->db->update($info,array("id"=>$_POST['info']['id']));
			showmessage(L('operation_success'),'?m=h5game&c=h5game');	
		}else{
			pc_base::load_sys_class('form', '', 0);
			$info = $this->db->get_one(array('id'=>$_GET['id']));
			if(!$info) showmessage('請選擇正確的遊戲信息！',HTTP_REFERER); 
			extract($info);
			include $this->admin_tpl('h5game_edit');
		}
	} 
  

	//導入接口文件

	public function import_h5game(){
		$meng_url = "http://meng.mofang.com/h5games/";
		$game_api = "http://meng.mofang.com/openinterface/GetGameList.ashx?version=1.01&market=apple&issupportandroid=1&pagesize=200";
		$datas = mf_curl_get($game_api);
		$datas = json_decode($datas,true);
		if(!empty($datas['array']) && $datas['isnotpass']==1) {
			foreach ($datas['array'] as $key => $value) {
				//判斷是否已經入庫,存在更新一下欄目的ID值（以前有些欄目ID為0）
				$search = $this->db->get_one(array("gamename"=>$value['Title'],"comefrom"=>1));
				if($search['gamename']!=''){
					//更新欄目ID
					switch ($value['Category']) {
						case '休閒益智':
							# code...
							$true_categoryid = 1;
							break;
						case '益智類':
							# code...
							$true_categoryid = 2;
							break;
						case '冒險類':
							# code...
							$true_categoryid = 3;
							break;
						case '體育類':
							# code...
							$true_categoryid = 4;
							break;
						case '射擊類':
							# code...
							$true_categoryid = 5;
							break;
						case '策略類':
							# code...
							$true_categoryid = 6;
							break;	
						case '敏捷類':
							# code...
							$true_categoryid = 7;
							break;	
						default:
							$true_categoryid = 1;
							break;	
					}
					$this->db->update(array("category"=>$true_categoryid),array("id"=>$search['id']));
					//看是否重新下載壓縮包 
					$new_icon = $meng_url.urlencode($value['Title'])."/i.jpg";
					$new_downloadlink = $meng_url.urlencode($value['Title'])."/index.zip";
					$down_zip = $this->get_zip($value['Title'],$new_icon,$new_downloadlink);
					continue; 
				}

				switch ($value['Category']) {
					case '休閒益智':
						# code...
						$true_categoryid = 1;
						break;
					case '益智類':
						# code...
						$true_categoryid = 2;
						break;
					case '冒險類':
						# code...
						$true_categoryid = 3;
						break;
					case '體育類':
						# code...
						$true_categoryid = 4;
						break;
					case '射擊類':
						# code...
						$true_categoryid = 5;
						break;
					case '策略類':
						# code...
						$true_categoryid = 6;
						break;	
					case '敏捷類':
						# code...
						$true_categoryid = 7;
						break;	
					default:
						$true_categoryid = 1;
						break;	 
				}
				$array = array();
				$array['gamename'] = $value['Title'];
				$array['content'] = $value['Intro'];
				$array['description'] = $value['Intro'];
				$array['size'] = $value['DownloadSize'];
				$array['icon'] = str_replace('meng', 'h5', $value['Img']);
				$array['link'] = str_replace('meng', 'h5', $value['Link']);
				$array['downloadLink'] = $value['DownloadLink'];
				$array['score'] = $value['Score'];
				$array['addtime'] = SYS_TIME;
				$array['status'] = 99;
				$array['category'] = $true_categoryid;
				$array['ios'] = $value['IsSupportIOS'];
				$array['android'] = $value['IsSupportAndroid'];
				$array['wp'] = $value['IsSupportWP'];
				$array['ipad'] = $value['IsSupportIpad'];
				$array['tag'] = $value['Tag'];
				$array['hot'] = $value['Hot'];

				//下載解壓文件，並復制到相應位置 
				$new_icon = $meng_url.urlencode($value['Title'])."/i.jpg";
				$new_downloadlink = $meng_url.urlencode($value['Title'])."/index.zip";
				$down_zip = $this->get_zip($value['Title'],$new_icon,$new_downloadlink);
				if($down_zip){
					echo $gamename."- 導入成功！<br>";
				}else{
					echo $gamename." - 導入失敗！正在繼續中..<br>";
				}
				$this->db->insert($array);
			}
			showmessage('H5小遊戲採集/導入成功！',HTTP_REFERER);
		}
	}

	//下載遠程的文件和圖片
	public function get_zip($gamename,$img,$downloadLink){
		$source_dir = PHPCMS_PATH.'h5games'.DIRECTORY_SEPARATOR;
		$new_dir = $source_dir.$gamename;
		if(is_dir($new_dir)){
			return false;
		}else{
			if(!mkdir($new_dir)){
				return false;
			}else{
				echo $new_dir."創建成功了！";
			}
		}
		
		// $open_dir = opendir($new_dir);
		// exec("cd ".$new_dir);
		// chdir($new_dir);
		// file_get_contents($downloadLink);exit;

		//下載圖片
		$pic_data = @file_get_contents($img);
		$pic_name = $new_dir.DIRECTORY_SEPARATOR.'i.jpg';
		$pic_file = @fopen($pic_name, "w");
        @fputs($pic_file, $pic_data);
        @fclose($pic_file);

		// 下載遠程壓縮包
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $downloadLink);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        $destination = $new_dir.DIRECTORY_SEPARATOR.'index.zip';
        $file = @fopen($destination, "w");
        @fputs($file, $data);
        @fclose($file);
        exec("cd ".$new_dir." && unzip index.zip && chmod 777 ".$new_dir." -R");
        return true;
	}

	//推薦位管理 
	public function position(){
		$positionid = intval($_GET['positionid']);
		$this->position_db = pc_base::load_model('position_h5game_model');
		if(isset($_GET['dosubmit'])){  
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->position_db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage('排序成功！正在返回！',HTTP_REFERER); 
		}else{
			pc_base::load_sys_class('form', '', 0);
			//查詢當前推薦位所有信息
			$array = $this->position_db->select(array("positionid"=>$positionid),'*','','listorder asc');
			if(is_array($array)){
				foreach ($array as $key => $value) {
					# code...
					$h5game_array = $this->db->get_one(array("id"=>$value['gameid']));
					$array[$key]['gamename'] = $h5game_array['gamename'];
					$array[$key]['link'] = $h5game_array['link'];
					$array[$key]['icon'] = $h5game_array['icon'];
				}
			}
			include $this->admin_tpl('h5game_position'); 
		}
	}

	//刪除推薦位裡面的信息
	public function position_delete(){
		$this->position_db = pc_base::load_model('position_h5game_model');
		$id = $_GET['id'];
		$this->position_db->delete(array('id'=>$id));
		showmessage('刪除∂ß成功！正在返回！',HTTP_REFERER); 
	}

	//推薦到指定位置
	public function push(){
		if ($_POST['dosubmit']) { 
			$info = array();
			$ids = explode('|', $_POST['ids']);
			$posid = $_POST['posid'];
			if(empty($posid)){
				showmessage('請選擇推薦位！',HTTP_REFERER); 
			}
			//加載推薦位數據模模型
			$position_db = pc_base::load_model('position_h5game_model');
			if(is_array($ids)) {
				foreach($ids as $id) {
					foreach ($posid as $key => $value) {
						#把信息插入所選推薦位
						$array['positionid'] = $value;
						$array['gameid'] = $id;//遊戲ID
						$array['listorder'] = $id;//排序值默認為遊戲ID，前台正序
						$array['status'] = 99;//排序值默認為遊戲ID，前台正序
						$position_db->insert($array);	
					}
				}
			}
			showmessage('操作成功！', '', '', 'push');
		} else {
			// pc_base::load_app_func('global', 'template');
			// $html = $this->push->{$_GET['action']}(array('modelid'=>$_GET['modelid'], 'catid'=>$_GET['catid']));
			$ids = $_GET['ids'];//獲取推薦選擇的遊戲ID
			$tpl = isset($_GET['tpl']) ? 'push_to_category' : 'push_list';
			include $this->admin_tpl($tpl);
		}
	}


}
?>
