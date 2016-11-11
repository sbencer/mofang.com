<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

/**
 * 
 * ------------------------------------------
 * video import class
 * ------------------------------------------
 * 
 * 導入KU6視頻
 *  
 * @copyright	CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 * 
 */
pc_base::load_app_class('admin', 'admin', 0);
pc_base::load_sys_class('form', 0, 0);
pc_base::load_app_func('global', 'video'); 
pc_base::load_sys_class('push_factory', '', 0);

class import extends admin {
	
	public $db,$module_db; 
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('video_store_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->userid = $_SESSION['userid'];
		pc_base::load_app_class('ku6api', 'video', 0);
		pc_base::load_app_class('v', 'video', 0);
		$this->v =  new v($this->db);
		
		//獲取短信平台配置信息
		$this->setting = getcache('video');
		if(empty($this->setting) && ROUTE_A!='setting') {
			showmessage(L('video_setting_not_succfull'), 'index.php?m=video&c=video&a=setting&meunid='.$_GET['meunid']);
		}
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}
	
	/**
	* 執行視頻導入 
	*/
	public function doimport(){
		$importdata = $_POST['importdata'];
		$select_category = intval($_POST['select_category']);//欄目ID
		$is_category = intval($_POST['is_category']);//是否導入欄目
 		$siteid = get_siteid();
		$ids = $_POST['ids'];
		$datas = array();
 		if(is_array($ids)){
 			foreach ($_POST['importdata'] as $vv) {//重組勾選數據
				if(in_array($vv['vid'], $ids)) {
					$datas[] = $vv;
				}
			}
			
			$video_store_db = pc_base::load_model('video_store_model');
			$content_model = pc_base::load_model('content_model');
			$content_model->set_catid($select_category);
			$CATEGORYS = getcache('category_content_'.$siteid,'commons');
			$modelid = $CATEGORYS[$select_category]['modelid'];// 所選視頻欄目對應的modelid
			$model_field = pc_base::load_model('sitemodel_field_model');
			$r = $model_field->get_one(array('modelid'=>$modelid, 'formtype'=>'video'), 'field');
			$fieldname = $r['field'];//查出視頻字段
			
			//導入推薦位使用
			$this->push = push_factory::get_instance()->get_api('admin');
  			//循環勾選數據，進行請求ku6vms入庫接口進行入庫，成功後插入本系統對應欄目，並自動進行video_content對應關系 
			$new_s = array();
 			foreach ($datas as $data) {
  				$data['cid'] = $select_category;
				$data['import'] = 1;
				$data['channelid'] = 1;
				$return_data = array();
  				$return_data = $this->ku6api->vms_add($data);//插入VMS,返回能播放使用的vid
				//$new_s[] = $return_data;
   				$vid = $return_data['vid'];
				if(!$vid){
					showmessage('導入VMS系統時，發生錯誤！',HTTP_REFERER);
				}
  				//入本機視頻庫
				
				$video_data = array();
				$video_data['title'] = str_cut($data['title'],80,false);
				$video_data['vid'] = $vid;
				$video_data['keywords'] = str_cut($data['tag'],36);
				$video_data['description'] = str_cut($data['desc'],200);
				$video_data['status'] = $data['status'];
				$video_data['addtime'] = $data['uploadtime'] ? substr($data['uploadtime'],0,10) : SYS_TIME;
				$video_data['picpath'] = safe_replace( format_url($data['picpath']) );
 				$video_data['timelen'] = intval($data['timelen']);
				$video_data['size'] = intval($data['size']); 
				$video_data['channelid'] = 1; 
				
				$videoid = $video_store_db->insert($video_data, true);//插入視頻庫
 				
				if($is_category==1){//視頻直接發布到指定欄目
					//組合POST數據
					//根據模型id，得到視頻字段名
					$content_data = array();
					
					$content_data[$fieldname] = 1;
					$content_data['catid'] = $select_category;
					$content_data['title'] = str_cut($data['title'],80,' '); 
					$content_data['content'] = $data['desc']; 
					$content_data['description'] = str_cut($data['desc'],198,' '); 
					$content_data['keywords'] = str_cut($data['tag'],38,' ');
					$content_data = array_filter($content_data,'rtrim');
					$content_data['thumb'] = $data['picpath']; 
					$content_data['status'] = 99;  
					//組合POST數據,入庫時會自動對應關系 
					$_POST[$fieldname.'_video'][1] = array('videoid'=>$videoid, 'listorder'=>1); 
					//調接口，插入數據庫
					$cid = $content_model->add_content($content_data); 
					
					//入推薦位
					$position = $_POST['sub']['posid'];
					if($position){
						$info = array();//組成提交信息數據
						$pos_content_data = $content_data;
						$pos_content_data['id'] = $cid;
						$pos_content_data['inputtime'] = SYS_TIME;
						$pos_content_data['updatetime'] = SYS_TIME;
						$info[$cid]= $pos_content_data;//信息數據
						
						$pos_array = array();//推薦位ID，要求是數組下面使用
						$pos_array[] = $position;
						
						$post_array = '';//position 所用
						$post_array['modelid'] = $modelid;
						$post_array['catid'] = $select_category;
						$post_array['id'] = $cid; 
						$post_array['posid'] = $pos_array;
						$post_array['dosubmit'] = '提交';
						$post_array['pc_hash'] = $_GET['pc_hash'];
						 
						$this->push->position_list($info, $post_array);//調用admin position_list()方法
					}
					
					//更新點擊次數 
					if ($data['viewcount']) {
						$views = intval($data['viewcount']);
						$hitsid = 'c-'.$modelid.'-'.$cid;
						$count = pc_base::load_model('hits_model');
						$count->update(array('views'=>$views), array('hitsid'=>$hitsid));
					} 
				}
				 
  			}
			$page = intval($_POST['page']) + 1;
			if($_POST['fenlei'] || $_POST['keyword']){
				$forward = "?m=video&c=video&a=import_ku6video&menuid=".$_POST['menuid']."&fenlei=".$_POST['fenlei']."&srctype=".$_POST['srctype']."&videotime=".$_POST['videotime']."&keyword=".$_POST['keyword']."&dosubmit=%CB%D1%CB%&page=".$page;
			}else{
				$forward = "?m=video&c=video&a=import_ku6video&menuid=".$_POST['menuid'];
			}
			
     		showmessage('KU6視頻導入成功，正在返回！',$forward);
		}else{
 			showmessage('請選擇要導入的視頻！',HTTP_REFERER);
		}
	} 
	
	/**
	* 獲取站點欄目數據
	*/
	 
	/**
	 * 
	 * 視頻列表
	 */
	public function init() {
		$where = '1';
		$page = $_GET['page'];
		$pagesize = 20;
		if (isset($_GET['type'])) {
			if ($_GET['type']==1) {
				$where .= ' AND `videoid`=\''.$_GET['q'].'\'';
			} else {
				$where .= " AND `title` LIKE '%".$_GET['q']."%'";
			}
		}
		if (isset($_GET['start_time'])) {
			$where .= ' AND `addtime`>=\''.strtotime($_GET['start_time']).'\'';
		}
		if (isset($_GET['end_time'])) {
			$where .= ' AND `addtime`<=\''.strtotime($_GET['end_time']).'\'';
		}
		if (isset($_GET['status'])) {
			$status = intval($_GET['status']);
			$where .= ' AND `status`=\''.$status.'\'';
		}
		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$pages = $this->db->pages;
		include $this->admin_tpl('video_list');		
	}   
}

?>