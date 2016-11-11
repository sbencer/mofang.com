<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型緩存路徑
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
//定義在單獨操作內容的時候，同時更新相關欄目頁面
define('RELATION_HTML',true);

pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
pc_base::load_app_func('util');
pc_base::load_sys_class('format','',0);

class content extends admin {
	private $db,$priv_db,$tag_db,$linktag_to_content;
	public $siteid,$categorys;
	public function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('content_model');
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		//權限判斷
		if(isset($_GET['catid']) && $_SESSION['roleid'] != 1 && ROUTE_A !='pass' && strpos(ROUTE_A,'public_')===false) {
			$catid = intval($_GET['catid']);
			$this->priv_db = pc_base::load_model('category_priv_model');
			$action = $this->categorys[$catid]['type']==0 ? ROUTE_A : 'init';
			//增加對當前賬號，對當前欄目，進行當前 action是否有權限的檢查（如果不指定roleid進行查詢，肯定是可以查到數據，所以以前方法判斷無效）
			$priv_datas = $this->priv_db->get_one(array('catid'=>$catid,'is_admin'=>1,'action'=>$action,'roleid'=>$_SESSION['roleid']));
			if(!$priv_datas) showmessage(L('permission_to_operate'),'blank');
		}
	}

	public function init() {
		$show_header = $show_dialog  = $show_pc_hash = '';
		if(isset($_GET['catid']) && $_GET['catid'] && $this->categorys[$_GET['catid']]['siteid']==$this->siteid) {
			$catid = $_GET['catid'] = intval($_GET['catid']);
			$category = $this->categorys[$catid];
			$modelid = $category['modelid'];
			$model_arr = getcache('model', 'commons');
			$MODEL = $model_arr[$modelid];
			unset($model_arr);
			$admin_username = param::get_cookie('admin_username');
			//查詢當前的工作流
			$setting = string2array($category['setting']);
			$workflowid = $setting['workflowid'];
			$workflows = getcache('workflow_'.$this->siteid,'commons');
			$workflows = $workflows[$workflowid];
			$workflows_setting = string2array($workflows['setting']);

			//將有權限的級別放到新數組中
			$admin_privs = array();
			foreach($workflows_setting as $_k=>$_v) {
				if(empty($_v)) continue;
				foreach($_v as $_value) {
					if($_value==$admin_username) $admin_privs[$_k] = $_k;
				}
			}
			//工作流審核級別
			$workflow_steps = $workflows['steps'];
			$workflow_menu = '';
			$steps = isset($_GET['steps']) ? intval($_GET['steps']) : 0;
			//工作流權限判斷
			if($_SESSION['roleid']!=1 && $steps && !in_array($steps,$admin_privs) && $steps != 21) showmessage(L('permission_to_operate'));
			$this->db->set_model($modelid);
			//是否存在關聯遊戲字段
			$exists_gameid = $this->db->field_exists('gameid');
			//是否調用新的產品庫
			$relation_game = $this->db->field_exists('relation_game');
			if($this->db->table_name==$this->db->db_tablepre) showmessage(L('model_table_not_exists'));;
			$status = $steps ? $steps : 99;
			if(isset($_GET['reject'])) $status = 0;
			$where = 'catid='.$catid.' AND status='.$status;
			// 查看自己的文章
			$username = $_GET['user'];
			if(isset($username)){
				$where .= " AND username='{$username}'";
			}
			//標簽檢查
			if(isset($_GET['checktags'])) {
				$where .= " AND `linktags` = '2'";
			}
			//搜索
			if(isset($_GET['start_time']) && $_GET['start_time']) {
				$start_time = strtotime($_GET['start_time']);
				$where .= " AND `inputtime` > '$start_time'";
			}
			if(isset($_GET['end_time']) && $_GET['end_time']) {
				$end_time = strtotime($_GET['end_time']);
				$where .= " AND `inputtime` < '$end_time'";
			}
			if($start_time>$end_time) showmessage(L('starttime_than_endtime'));
			if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
				$type_array = array('title','description','username');
				$searchtype = intval($_GET['searchtype']);
				if($searchtype < 3) {
					$searchtype = $type_array[$searchtype];
					$keyword = strip_tags(trim($_GET['keyword']));
					$where .= " AND `$searchtype` like '%$keyword%'";
				} elseif($searchtype==3) {
					$keyword = intval($_GET['keyword']);
					$where .= " AND `id`='$keyword'";
				}
			}
			if(isset($_GET['posids']) && !empty($_GET['posids'])) {
				$posids = $_GET['posids']==1 ? intval($_GET['posids']) : 0;
				$where .= " AND `posids` = '$posids'";
			}
			if($_GET['steps'] == 21){
				$datas = $this->db->listinfo($where,'inputtime asc',$_GET['page']);
			}else{
				$datas = $this->db->listinfo($where,'inputtime desc',$_GET['page']);
			}
			$pages = $this->db->pages;
			$pc_hash = $_SESSION['pc_hash'];
			for($i=1;$i<=$workflow_steps;$i++) {
				if($_SESSION['roleid']!=1 && !in_array($i,$admin_privs)) continue;
				$current = $steps==$i ? 'class=on' : '';
				$r = $this->db->get_one(array('catid'=>$catid,'status'=>$i));
				$newimg = $r ? '<img src="'.IMG_PATH.'icon/new.png" style="padding-bottom:2px" onclick="window.location.href=\'?m=content&c=content&a=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&pc_hash='.$pc_hash.'\'">' : '';
				$workflow_menu .= '<a href="?m=content&c=content&a=&menuid='.$_GET['menuid'].'&catid='.$catid.'&steps='.$i.'&pc_hash='.$pc_hash.'" '.$current.' ><em>'.L('workflow_'.$i).$newimg.'</em></a><span>|</span>';
			}
			if($workflow_menu) {
				$current = isset($_GET['reject']) ? 'class=on' : '';
				$workflow_menu .= '<a href="?m=content&c=content&a=&menuid='.$_GET['menuid'].'&catid='.$catid.'&pc_hash='.$pc_hash.'&reject=1" '.$current.' ><em>'.L('reject').'</em></a><span>|</span>';
			}
			//$ = 153fc6d28dda8ca94eaa3686c8eed857;獲取模型的thumb字段配置信息
			$model_fields = getcache('model_field_'.$modelid, 'model');
			$setting = string2array($model_fields['thumb']['setting']);
			$args = '1,'.$setting['upload_allowext'].','.$setting['isselectimage'].','.$setting['images_width'].','.$setting['images_height'].','.$setting['watermark'];
			$authkey = upload_key($args);
			$template = $MODEL['admin_list_template'] ? $MODEL['admin_list_template'] : 'content_list';
			include $this->admin_tpl($template);
		} else {
			include $this->admin_tpl('content_quick');
		}
	}

	//獲取父分區下欄目
	public function ajax_partition(){
		//echo $_POST['catid'];
		echo form::select_partition(1,$_POST['catid'],'category_content_'.$this->siteid,0,'name="info[part_id]"','',0,-1,1);
	}

	public function add() {
		if(isset($_POST['dosubmit']) || isset($_POST['dosubmit_continue'])) {
			//暫時關閉首頁自動生成功能
			//define('INDEX_HTML',true);
			$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
			if(trim($_POST['info']['title'])=='') showmessage(L('title_is_empty'));
			$category = $this->categorys[$catid];
			if($category['type']==0) {
				$modelid = $this->categorys[$catid]['modelid'];
				$this->db->set_model($modelid);
				//如果該欄目設置了工作流，那麼必須走工作流設定
				$setting = string2array($category['setting']);
				$workflowid = $setting['workflowid'];
				if($workflowid && $_POST['status']!=99) {
					//如果用戶是超級管理員，那麼則根據自己的設置來發布
					$_POST['info']['status'] = $_SESSION['roleid']==1 ? intval($_POST['status']) : 1;
				} else {
					$_POST['info']['status'] = 99;
				}
 
				//分區id
				$part_id = $_POST['info']['part_id'];
				unset( $_POST['info']['part_id'] );

				$content_id = $this->db->add_content($_POST['info']);

				/**
				* 如果關聯遊戲產品庫，則把對應關系入庫 
				* 王官慶 2014.6.22 
				*/
				$relation_game = trim($_POST['info']['relation_game']);
				if(!empty($relation_game)){
					//遊戲與信息對應關系入對應關系庫
					$relation_game_db = pc_base::load_model('relation_game_model');
					$relation_array = explode("|", $relation_game);
					foreach ($relation_array as $value) {
						if(!empty($value)){
							$relation_game_array['gameid'] = intval($value);
							$relation_game_array['id'] = $content_id;
							$relation_game_array['catid'] = $catid;
							$relation_game_array['modelid'] = $modelid;
							$relation_game_array['addtime'] = SYS_TIME;
							$relation_game_db->insert($relation_game_array);
						}
					}
				}

				if( $part_id ){//fuck,該死的bug
					//加入分區關聯
					$db_partition_games = pc_base::load_model('partition_games_model');
					//$db_category = pc_base::load_model('category_model');
					$db_category = pc_base::load_model('partition_model');
					$temp_modelid = $db_category->get_one( '`catid`='.$_POST['info']['catid'], 'modelid' );
					$partition_data['part_id'] = $part_id;
					//$partition_data['modelid'] = $temp_modelid['modelid'];
					$partition_data['modelid'] = $modelid;
					$partition_data['gameid'] = $content_id;
					$db_partition_games->insert( $partition_data );
				}

				//增加成功，推送到百度收錄 
				$content_array = $this->db->get_one(array('id'=>$content_id));
				$url_array = pathinfo($content_array['url']);
				$str = str_replace("http://","",$url_array['dirname']);
				$strdomain = explode("/",$str);
				$domain = $strdomain[0];
				//向百度推送文章信息
				$baidu_return = tobaidu($content_array['url'],$domain);

				if(isset($_POST['dosubmit'])) {
					showmessage(L('add_success').L('2s_close'),'blank','','','function set_time() {$("#secondid").html(1);}setTimeout("set_time()", 500);setTimeout("window.close()", 1200);');
				} else {
					showmessage(L('add_success'),HTTP_REFERER);
				}
			} else {
				//單網頁
				$this->page_db = pc_base::load_model('page_model');
				$style_font_weight = $_POST['style_font_weight'] ? 'font-weight:'.strip_tags($_POST['style_font_weight']) : '';
				$_POST['info']['style'] = strip_tags($_POST['style_color']).';'.$style_font_weight;

				if($_POST['edit']) {
					$this->page_db->update($_POST['info'],array('catid'=>$catid));
				} else {
					$catid = $this->page_db->insert($_POST['info'],1);
				}
				$this->page_db->create_html($catid,$_POST['info']);
				$forward = HTTP_REFERER;
			}

			showmessage(L('add_success'),$forward);
		} else {
			$show_header = $show_dialog = $show_validator = '';
			//設置cookie 在附件添加處調用
			param::set_cookie('module', 'content');
			if(isset($_GET['catid']) && $_GET['catid']) {
				$catid = $_GET['catid'] = intval($_GET['catid']);
				param::set_cookie('catid', $catid);
				$category = $this->categorys[$catid];
				if($category['type']==0) {
					$modelid = $category['modelid'];
					//取模型ID，依模型ID來生成對應的表單
					require CACHE_MODEL_PATH.'content_form.class.php';
					$content_form = new content_form($modelid,$catid,$this->categorys);
					$forminfos = $content_form->get();
 					$formValidator = $content_form->formValidator;
					$setting = string2array($category['setting']);
					$workflowid = $setting['workflowid'];
					$workflows = getcache('workflow_'.$this->siteid,'commons');
					$workflows = $workflows[$workflowid];
					$workflows_setting = string2array($workflows['setting']);
					$nocheck_users = $workflows_setting['nocheck_users'];
					$admin_username = param::get_cookie('admin_username');
					if(!empty($nocheck_users) && in_array($admin_username, $nocheck_users)) {
						$priv_status = true;
					} else {
						$priv_status = false;
					}
					include $this->admin_tpl('content_add');
				} else {
					//單網頁
					$this->page_db = pc_base::load_model('page_model');
					$r = $this->page_db->get_one(array('catid'=>$catid));
					if($r) {
						extract($r);
						$style_arr = explode(';',$style);
						$style_color = $style_arr[0];
						$style_font_weight = $style_arr[1] ? substr($style_arr[1],12) : '';
					}
					include $this->admin_tpl('content_page');
				}
			} else {
				include $this->admin_tpl('content_add');
			}
			header("Cache-control: private");
		}
	}

	public function edit() {
			//設置cookie 在附件添加處調用
			param::set_cookie('module', 'content');
			if(isset($_POST['dosubmit']) || isset($_POST['dosubmit_continue'])) {
				//define('INDEX_HTML',true);
				$id = $_POST['info']['id'] = intval($_POST['id']);
				$catid = $_POST['info']['catid'] = intval($_POST['info']['catid']);
				if(trim($_POST['info']['title'])=='') showmessage(L('title_is_empty'));

				$modelid = $this->categorys[$catid]['modelid'];
				$this->db->set_model($modelid);

				/**
				* 如果關聯遊戲產品庫，則把對應關系入庫 
				* 王官慶 2014.6.22 
				*/
				$new_relation_name = '';
				$relation_game = trim($_POST['info']['relation_game']);
                //遊戲與信息對應關系入對應關系庫
                $relation_game_db = pc_base::load_model('relation_game_model');
                //删除原来的游戏关联 yzg
                $relation_game_db->delete(array('catid'=>$catid,'id'=>$id));
				if(!empty($relation_game)){
					$relation_array = explode("|", $relation_game);
					$array_num = count($relation_array);
					$i = 1 ;
					foreach ($relation_array as $value) {

						if(!empty($value)){
							//判斷該遊戲是否已經不在新庫（李偉會合並新庫，以前的關聯的遊戲已經丟失）
							$game_api = "http://game.mofang.com.tw/api/game/info?id=".$value;
							$datas = mf_curl_get($game_api);
							$datas = json_decode($datas,true);
							if($datas['code']==1) {
								$i++;
								continue;
							}else{
								//判斷是否已經存在關聯關系，未存在入庫。已經存在不處理
								$search_data = $relation_game_db->select(array("gameid"=>$value,"id"=>$id),'gameid');
								if(empty($search_data)){
									//未搜索到，說明關聯關系不存在，則入庫
									$relation_game_array['gameid'] = intval($value);
									$relation_game_array['id'] = $id;
									$relation_game_array['catid'] = $catid;
									$relation_game_array['modelid'] = $modelid;
									$relation_game_array['addtime'] = SYS_TIME;
									$relation_game_db->insert($relation_game_array);
								}
								//組成新的relation_name　存入視頻表中
								if($i==$array_num){
									$new_relation_name .=$value;
								}else{
									$new_relation_name .=$value.'|';
								}
								$i++;
							}
						}
					}
				}

				$_POST['info']['relation_game'] = $new_relation_name;
                
				$this->db->edit_content($_POST['info'],$id);

				if(isset($_POST['dosubmit'])) {
					showmessage(L('update_success').L('2s_close'),'blank','','','function set_time() {$("#secondid").html(1);}setTimeout("set_time()", 500);setTimeout("window.close()", 1200);');
				} else {
					showmessage(L('update_success'),HTTP_REFERER);
				}
			} else {
				$show_header = $show_dialog = $show_validator = '';
				//從數據庫獲取內容
				$id = intval($_GET['id']);
				if(!isset($_GET['catid']) || !$_GET['catid']) showmessage(L('missing_part_parameters'));
				$catid = $_GET['catid'] = intval($_GET['catid']);

				$this->model = getcache('model', 'commons');

				param::set_cookie('catid', $catid);
				$category = $this->categorys[$catid];
				$modelid = $category['modelid'];

				$this->db->table_name = $this->db->db_tablepre.$this->model[$modelid]['tablename'];
				$r = $this->db->get_one(array('id'=>$id));
				$this->db->table_name = $this->db->table_name.'_data';
				$r2 = $this->db->get_one(array('id'=>$id));
				if(!$r2) showmessage(L('subsidiary_table_datalost'),'blank');
				$data = array_merge($r,$r2);
				$data = array_map('htmlspecialchars_decode',$data);
				require CACHE_MODEL_PATH.'content_form.class.php';
				$content_form = new content_form($modelid,$catid,$this->categorys);

				$forminfos = $content_form->get($data);
				$formValidator = $content_form->formValidator;
				include $this->admin_tpl('content_edit');
			}
			header("Cache-control: private");
	}

	/**
	 *
	 * 獲取父分區ID列表,ok
	 * @param integer $catid              欄目ID
	 * @param array $arrparentid          父目錄ID
	 * @param integer $n                  查找的層次
	 */
	private function get_arrparentid($catid, $arrparentid = '', $n = 1) {
		if($n > 5 || !is_array($this->categorys) || !isset($this->categorys[$catid])) return false;
		$parentid = $this->categorys[$catid]['parentid'];
		$arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		if($parentid) {
			$arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
		} else {
			$this->categorys[$catid]['arrparentid'] = $arrparentid;
		}
		$parentid = $this->categorys[$catid]['parentid'];
		return $arrparentid;
	}

	/**
	 *
	 * 刪除
	 *
	 */
	public function delete() {
		if(isset($_GET['dosubmit'])) {
			$catid = intval($_GET['catid']);
			if(!$catid) showmessage(L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$sethtml = $this->categorys[$catid]['sethtml'];
			$siteid = $this->categorys[$catid]['siteid'];

			$html_root = pc_base::load_config('system','html_root');
			if($sethtml) $html_root = '';

			$setting = string2array($this->categorys[$catid]['setting']);
			$content_ishtml = $setting['content_ishtml'];
			$this->db->set_model($modelid);
			$this->hits_db = pc_base::load_model('hits_model');
			$this->queue = pc_base::load_model('queue_model');
			if(isset($_GET['ajax_preview'])) {
				$ids = intval($_GET['id']);
				$_POST['ids'] = array(0=>$ids);
			}
			if(empty($_POST['ids'])) showmessage(L('you_do_not_check'));
			//附件初始化
			$attachment = pc_base::load_model('attachment_model');
			$this->content_check_db = pc_base::load_model('content_check_model');
			$this->position_data_db = pc_base::load_model('position_data_model');
			$this->search_db = pc_base::load_model('search_model');
			//判斷視頻模塊是否安裝
			if (module_exists('video') && file_exists(PC_PATH.'model'.DIRECTORY_SEPARATOR.'video_content_model.class.php')) {
				$video_content_db = pc_base::load_model('video_content_model');
				$video_install = 1;
			}
			$this->comment = pc_base::load_app_class('comment', 'comment');
			$search_model = getcache('search_model_'.$this->siteid,'search');
			$typeid = $search_model[$modelid]['typeid'];
			$this->url = pc_base::load_app_class('url', 'content');

			//notok->待整理
			$db_partition_games = pc_base::load_model('partition_games_model');
			$db_category = pc_base::load_model('category_model');
			//遊戲新庫關聯表
			$db_relation_game = pc_base::load_model('relation_game_model');

			foreach($_POST['ids'] as $id) {

				$this->db->set_model($modelid);
				$r = $this->db->get_one(array('id'=>intval($id)));

				//刪除文章時刪除分區關聯,notok->待整理
				$temp_modelid = $db_category->get_one( '`catid`='.$r['catid'], 'modelid' );
				$partition_data['modelid'] = $temp_modelid['modelid'];
				$partition_data['gameid'] = $r['id'];
				$db_partition_games->delete( $partition_data );

				if($content_ishtml && !$r['islink']) {
					$urls = $this->url->show($id, 0, $r['catid'], $r['inputtime']);
					$fileurl = $urls[1];
					if($this->siteid != 1) {
						$sitelist = getcache('sitelist','commons');
						$fileurl = $html_root.'/'.$sitelist[$this->siteid]['dirname'].$fileurl;
					}
					//刪除靜態文件，排除htm/html/shtml外的文件
					$lasttext = strrchr($fileurl,'.');
					$len = -strlen($lasttext);
					$path = substr($fileurl,0,$len);
					$path = ltrim($path,'/');
					$filelist = glob(PHPCMS_PATH.$path.'*');
					foreach ($filelist as $delfile) {
						$lasttext = strrchr($delfile,'.');
						if(!in_array($lasttext, array('.htm','.html','.shtml'))) continue;
						@unlink($delfile);
						//刪除發布點隊列數據
						$delfile = str_replace(PHPCMS_PATH, '/', $delfile);
						$this->queue->add_queue('del',$delfile,$this->siteid);
					}
				} else {
					$fileurl = 0;
				}
				//刪除內容
				$this->db->delete_content($id,$fileurl,$catid);
				//刪除統計表數據
				$this->hits_db->delete(array('hitsid'=>'c-'.$modelid.'-'.$id));
				//刪除附件
				$attachment->api_delete('c-'.$catid.'-'.$id);
				//刪除審核表數據
				$this->content_check_db->delete(array('checkid'=>'c-'.$id.'-'.$modelid));
				//刪除推薦位數據
				$this->position_data_db->delete(array('id'=>$id,'catid'=>$catid,'module'=>'content'));
				//刪除全站搜索中數據
				$this->search_db->delete_search($typeid,$id);
				//刪除視頻庫與內容對應關系數據
				if ($video_install ==1) {
					$video_content_db->delete(array('contentid'=>$id, 'modelid'=>$modelid));
				}

				//刪除相關的評論,刪除前應該判斷是否還存在此模塊
				if(module_exists('comment')){
					$commentid = id_encode('content_'.$catid, $id, $siteid);
					$this->comment->del($commentid, $siteid, $id, $catid);
				}

				//刪除新品庫遊戲關聯表中的關聯關系
				// 王官慶 2014.7.24 
				$db_relation_game->delete(array("catid"=>$catid,"id"=>$id));

 			}
			//更新欄目統計
			$this->db->cache_items();
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			showmessage(L('operation_failure'));
		}
	}
	/**
	 * 過審內容
	 */
	public function pass() {
		$admin_username = param::get_cookie('admin_username');
		$catid = intval($_GET['catid']);

		if(!$catid) showmessage(L('missing_part_parameters'));
		$category = $this->categorys[$catid];
		$setting = string2array($category['setting']);
		$workflowid = $setting['workflowid'];
		//如果是回收站的文章，通過則直接狀態為99，不再判斷是否為工作流（現主站也沒有啟用工作流）
		$steps = intval($_GET['steps']);

		if($steps==33){
			$modelid = $this->categorys[$catid]['modelid'];
			$this->db->set_model($modelid);
			$this->db->status($_POST['ids'],99);
			showmessage('已經從回收站恢復！',HTTP_REFERER);
		}


		//只有存在工作流才需要審核
		if($workflowid) {
			$steps = intval($_GET['steps']);
			//檢查當前用戶有沒有當前工作流的操作權限
			$workflows = getcache('workflow_'.$this->siteid,'commons');
			$workflows = $workflows[$workflowid];
			$workflows_setting = string2array($workflows['setting']);
			//將有權限的級別放到新數組中
			$admin_privs = array();
			foreach($workflows_setting as $_k=>$_v) {
				if(empty($_v)) continue;
				foreach($_v as $_value) {
					if($_value==$admin_username) $admin_privs[$_k] = $_k;
				}
			}
			if($_SESSION['roleid']!=1 && $steps && !in_array($steps,$admin_privs)) showmessage(L('permission_to_operate'));
			//更改內容狀態
				if(isset($_GET['reject'])) {
				//退稿
					$status = 0;
				} else {
					//工作流審核級別
					$workflow_steps = $workflows['steps'];

					if($workflow_steps>$steps) {
						$status = $steps+1;
					} else {
						$status = 99;
					}
				}

				$modelid = $this->categorys[$catid]['modelid'];
				$this->db->set_model($modelid);

				//審核通過，檢查投稿獎勵或扣除積分
				if ($status==99) {
					$html = pc_base::load_app_class('html', 'content');
					$this->url = pc_base::load_app_class('url', 'content');
					$member_db = pc_base::load_model('member_model');
					if (isset($_POST['ids']) && !empty($_POST['ids'])) {
						foreach ($_POST['ids'] as $id) {
							$content_info = $this->db->get_content($catid,$id);
							$memberinfo = $member_db->get_one(array('username'=>$content_info['username']), 'userid, username');
							$flag = $catid.'_'.$id;
							if($setting['presentpoint']>0) {
								pc_base::load_app_class('receipts','pay',0);
								receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
							} else {
								pc_base::load_app_class('spend','pay',0);
								spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
							}
							if($setting['content_ishtml'] == '1'){//欄目有靜態配置
  								$urls = $this->url->show($id, 0, $content_info['catid'], $content_info['inputtime'], '',$content_info,'add');
   								$html->show($urls[1],$urls['data'],0);
 							}
						}
					} else if (isset($_GET['id']) && $_GET['id']) {
						$id = intval($_GET['id']);
						$content_info = $this->db->get_content($catid,$id);
						$memberinfo = $member_db->get_one(array('username'=>$content_info['username']), 'userid, username');
						$flag = $catid.'_'.$id;
						if($setting['presentpoint']>0) {
							pc_base::load_app_class('receipts','pay',0);
							receipts::point($setting['presentpoint'],$memberinfo['userid'], $memberinfo['username'], $flag,'selfincome',L('contribute_add_point'),$memberinfo['username']);
						} else {
							pc_base::load_app_class('spend','pay',0);
							spend::point($setting['presentpoint'], L('contribute_del_point'), $memberinfo['userid'], $memberinfo['username'], '', '', $flag);
						}
						//單篇審核，生成靜態
						if($setting['content_ishtml'] == '1'){//欄目有靜態配置
						$urls = $this->url->show($id, 0, $content_info['catid'], $content_info['inputtime'], '',$content_info,'add');
						$html->show($urls[1],$urls['data'],0);
						}
					}
				}
				if(isset($_GET['ajax_preview'])) {
					$_POST['ids'] = $_GET['id'];
				}
				$this->db->status($_POST['ids'],$status);
		}
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	/**
	 * 排序
	 */
	public function listorder() {
		if(isset($_GET['dosubmit'])) {
			$catid = intval($_GET['catid']);
			if(!$catid) showmessage(L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$this->db->set_model($modelid);
			foreach($_POST['listorders'] as $id => $listorder) {
				$this->db->update(array('listorder'=>$listorder),array('id'=>$id));
			}
			showmessage(L('operation_success'));
		} else {
			showmessage(L('operation_failure'));
		}
	}
	/**
	 * 顯示欄目菜單列表
	 */
	public function public_categorys() {
		$show_header = '';
		$cfg = getcache('common','commons');
		$ajax_show = intval($cfg['category_ajax']);
		$from = isset($_GET['from']) && in_array($_GET['from'],array('block')) ? $_GET['from'] : 'content';
		$tree = pc_base::load_sys_class('tree');
		if($from=='content' && $_SESSION['roleid'] != 1) {
			$this->priv_db = pc_base::load_model('category_priv_model');
			$priv_result = $this->priv_db->select(array('action'=>'init','roleid'=>$_SESSION['roleid'],'siteid'=>$this->siteid,'is_admin'=>1));
			$priv_catids = array();
			foreach($priv_result as $_v) {
				$priv_catids[] = $_v['catid'];
			}
			if(empty($priv_catids)) return '';
		}
		$categorys = array();
		if(!empty($this->categorys)) {
			foreach($this->categorys as $r) {
				//隱藏專區匯集地的欄目
				if($r['catid']==1317){
					continue;
				}
				if($r['siteid']!=$this->siteid ||  ($r['type']==2 && $r['child']==0)) continue;
				if($from=='content' && $_SESSION['roleid'] != 1 && !in_array($r['catid'],$priv_catids)) {
					$arrchildid = explode(',',$r['arrchildid']);
					$array_intersect = array_intersect($priv_catids,$arrchildid);
					if(empty($array_intersect)) continue;
				}
				if($r['type']==1 || $from=='block') {
					if($r['type']==0) {
						$r['vs_show'] = "<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=".$r['catid']."&type=show' target='right'>[".L('content_page')."]</a>";
					} else {
						$r['vs_show'] ='';
					}
					$r['icon_type'] = 'file';
					$r['add_icon'] = '';
					$r['type'] = 'add';
				} else {
					$r['icon_type'] = $r['vs_show'] = '';
					$r['type'] = 'init';
					$r['add_icon'] = "<a target='right' href='?m=content&c=content&menuid=".$_GET['menuid']."&catid=".$r['catid']."' onclick=javascript:openwinx('?m=content&c=content&a=add&menuid=".$_GET['menuid']."&catid=".$r['catid']."&hash_page=".$_SESSION['hash_page']."','')><img src='".IMG_PATH."add_content.gif' alt='".L('add')."'></a> ";
				}
				$categorys[$r['catid']] = $r;
			}
		}
		if(!empty($categorys)) {
			$tree->init($categorys);
				switch($from) {
					case 'block':
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=\$catid&type=list' target='right'>\$catname</a> \$vs_show</span>";
						$strs2 = "<img src='".IMG_PATH."folder.gif'> <a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=\$catid&type=category' target='right'>\$catname</a>";
					break;

					default:
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=content&c=content&a=\$type&menuid=".$_GET['menuid']."&catid=\$catid' target='right' onclick='open_list(this)'>\$catname</a></span>";
						$strs2 = "<span class='folder'><a href='?m=content&c=content&a=\$type&menuid=".$_GET['menuid']."&catid=\$catid' target='right' onclick='open_list(this)'>\$catname</a></span>";
						break;
				}
			$categorys = $tree->get_treeview(0,'category_tree',$strs,$strs2,$ajax_show);
		} else {
			$categorys = L('please_add_category');
		}
        include $this->admin_tpl('category_tree');
		exit;
	}
	/**
	 * 檢查標題是否存在
	 */
	public function public_check_title() {
		if($_GET['data']=='' || (!$_GET['catid'])) return '';
		$catid = intval($_GET['catid']);
		$modelid = $this->categorys[$catid]['modelid'];
		$this->db->set_model($modelid);
		$title = $_GET['data'];
		if(CHARSET=='gbk') $title = iconv('utf-8','gbk',$title);
		$r = $this->db->get_one(array('title'=>$title));
		if($r) {
			exit('1');
		} else {
			exit('0');
		}
	}

	/**
	 * 修改某一字段數據
	 */
	public function update_param() {
		$id = intval($_GET['id']);
		$field = $_GET['field'];
		$modelid = intval($_GET['modelid']);
		$value = $_GET['value'];
		if (CHARSET!='utf-8') {
			$value = iconv('utf-8', 'gbk', $value);
		}
		//檢查字段是否存在
		$this->db->set_model($modelid);
		if ($this->db->field_exists($field)) {
			$this->db->update(array($field=>$value), array('id'=>$id));
			exit('200');
		} else {
			$this->db->table_name = $this->db->table_name.'_data';
			if ($this->db->field_exists($field)) {
				$this->db->update(array($field=>$value), array('id'=>$id));
				exit('200');
			} else {
				exit('300');
			}
		}
	}

	/**
	 * 圖片裁切
	 */
	public function public_crop() {
		if (isset($_GET['picurl']) && !empty($_GET['picurl'])) {
			$picurl = $_GET['picurl'];
			$catid = intval($_GET['catid']);
			if (isset($_GET['module']) && !empty($_GET['module'])) {
				$module = $_GET['module'];
			}
			$show_header =  '';
			include $this->admin_tpl('crop');
		}
	}
	/**
	 * 相關文章選擇
	 */
	public function public_relationlist() {
		pc_base::load_sys_class('format','',0);
		$show_header = '';
		$model_cache = getcache('model','commons');
		if(!isset($_GET['modelid'])) {
			showmessage(L('please_select_modelid'));
		} else {
			$page = intval($_GET['page']);

			$modelid = intval($_GET['modelid']);
			$this->db->set_model($modelid);
			$where = '';
			if($_GET['catid']) {
				$catid = intval($_GET['catid']);
				$where .= "catid='$catid'";
			}
			$where .= $where ?  ' AND status=99' : 'status=99';

			if(isset($_GET['keywords'])) {
				$keywords = trim($_GET['keywords']);
				$field = $_GET['field'];
				if(in_array($field, array('id','title','keywords','description'))) {
					if($field=='id') {
						$where .= " AND `id` ='$keywords'";
					} else {
						$where .= " AND `$field` like '%$keywords%'";
					}
				}
			}
			$infos = $this->db->listinfo($where,'',$page,12);
			$pages = $this->db->pages;
			if (isset($_GET['authorlist']) && $_GET['authorlist']) {
				include $this->admin_tpl('authorlist');
			} else {
				include $this->admin_tpl('relationlist');
			}
		}
	}

	public function public_mfrelation() {
		pc_base::load_sys_class('format','',0);
		$show_header = '';
		$model_cache = getcache('model','commons');
		$modelids_str = trim($_GET['modelids']);
		$modelid = intval($_GET['modelid']);
		$field = trim($_GET['field']);
		$type = intval($_GET['type']);
		if(!$modelids_str) {
			showmessage(L('please_select_modelid'));
		} else {
			$modelids = explode(',', $modelids_str);
			$modelids = array_map('trim', $modelids);
			$modelids = array_filter($modelids);

			$page = intval($_GET['page']);

			if (!$modelid) {
				$modelid = $modelids[0];
			}
			$this->db->set_model($modelid);

			if(isset($_GET['keywords'])) {
				$keywords = trim($_GET['keywords']);
				if ($this->db->field_exists('en_title')) {
					$where .= "`title` like '%{$keywords}%' OR `en_title` like '%{$keywords}%'";
				} else {
					$where .= "`title` like '%{$keywords}%'";
				}
			}
			$infos = $this->db->listinfo($where,'',$page,12);
			$pages = $this->db->pages;
			include $this->admin_tpl('mfrelationlist');
		}
	}

	public function public_getjson_author() {
		$modelid = intval($_GET['modelid']);
		$id = intval($_GET['id']);
		$this->db->set_model($modelid);
		$tablename = $this->db->table_name;
		$this->db->table_name = $tablename;
		$r = $this->db->get_one(array('id'=>$id),'id, title');

		$infos[] = $r;
		echo json_encode($infos);
	}

	public function public_getjson_ids() {
		$modelid = intval($_GET['modelid']);
		$id = intval($_GET['id']);
		$this->db->set_model($modelid);
		$tablename = $this->db->table_name;
		$this->db->table_name = $tablename.'_data';
		$r = $this->db->get_one(array('id'=>$id),'relation');

		if($r['relation']) {
			$relation = str_replace('|', ',', $r['relation']);
			$relation = trim($relation,',');
			$where = "id IN($relation)";
			$infos = array();
			$this->db->table_name = $tablename;
			$datas = $this->db->select($where,'id,title');
			foreach($datas as $_v) {
				$_v['sid'] = 'v'.$_v['id'];
				if(strtolower(CHARSET)=='gbk') $_v['title'] = iconv('gbk', 'utf-8', $_v['title']);
				$infos[] = $_v;
			}
			echo json_encode($infos);
		}
	}

	//文章預覽
	public function public_preview() {
		$catid = intval($_GET['catid']);
		$id = intval($_GET['id']);

		if(!$catid || !$id) showmessage(L('missing_part_parameters'),'blank');
		$page = intval($_GET['page']);
		$page = max($page,1);
		$CATEGORYS = getcache('category_content_'.$this->get_siteid(),'commons');

		if(!isset($CATEGORYS[$catid]) || $CATEGORYS[$catid]['type']!=0) showmessage(L('missing_part_parameters'),'blank');
		define('HTML', true);
		$CAT = $CATEGORYS[$catid];

		$siteid = $CAT['siteid'];
		$MODEL = getcache('model','commons');
		$modelid = $CAT['modelid'];

		$this->db->table_name = $this->db->db_tablepre.$MODEL[$modelid]['tablename'];
		$r = $this->db->get_one(array('id'=>$id));
		if(!$r) showmessage(L('information_does_not_exist'));
		$this->db->table_name = $this->db->table_name.'_data';
		$r2 = $this->db->get_one(array('id'=>$id));
		$rs = $r2 ? array_merge($r,$r2) : $r;

		//再次重新賦值，以數據庫為準
		$catid = $CATEGORYS[$r['catid']]['catid'];
		$modelid = $CATEGORYS[$catid]['modelid'];

		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$data = $content_output->get($rs);
		extract($data);
		$CAT['setting'] = string2array($CAT['setting']);
		$template = $template ? $template : $CAT['setting']['show_template'];
		$allow_visitor = 1;
		//SEO
		$SEO = seo($siteid, $catid, $title, $description);

		define('STYLE',$CAT['setting']['template_list']);
		if(isset($rs['paginationtype'])) {
			$paginationtype = $rs['paginationtype'];
			$maxcharperpage = $rs['maxcharperpage'];
		}
		$pages = $titles = '';
		if($rs['paginationtype']==1) {
			//自動分頁
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = pc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
		if($rs['paginationtype']!=0) {
			//手動分頁
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = pc_base::load_app_class('url', 'content');

				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
                //文章開頭有[page]時，頁碼-1
                if ($CONTENT_POS<7) {
					$pagenumber--;
				}
                //當有子標題時，根據[/page]計算頁碼數
				if (strpos($content, '[/page]')!==false) {
					$pagenumber = substr_count($content, '[/page]');
				}

				for($i=1; $i<=$pagenumber; $i++) {
					$pageurls[$i] = $this->url->show($id, $i, $catid, $rs['inputtime']);
				}

				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}

				$pages = content_pages($pagenumber,$page, $pageurls);
				//判斷[page]出現的位置是否在第一位
				if($CONTENT_POS<7) {
					$content = $contents[$page];
				} else {
					if ($page==1 && !empty($titles)) {
						$content = $title.'[/page]'.$contents[$page-1];
					} else {
						$content = $contents[$page-1];
					}
				}
				if($titles) {
					$content = explode('[/page]', $content);

					$content = trim($content[1]);
					if(strpos($content,'</p>')===0) {
						$content = '<p>'.$content;
					}
					if(stripos($content,'<p>')===0) {
						$content = $content.'</p>';
					}
                }
			}
		}
		//如果是非玩不可和魔客派的欄目
		if($r['catid'] == 934 or $r['catid'] == 1172){ //參考index/show方法
				require(PC_PATH."init/smarty.php");
				$smarty = use_v4();
				$smarty->assign("SEO",$SEO);
                $smarty->assign("CATEGORYS",$CATEGORYS);
                $smarty->assign('top_parentid',$top_parentid);
                $smarty->assign($data);

                $smarty->assign("rs",$rs);
                $smarty->assign("id",$id);
                $smarty->assign("modelid",$modelid);
                $smarty->assign("gameid",$gameid);
                $smarty->assign("description",$description);

                //有此字段，則顯示關聯遊戲
                // echo $relation_game;exit;
                if(!empty($rs['relation_game'])){
                    $relation_game = explode("|", $rs['relation_game']);
                    $smarty->assign("relation_game_array",$relation_game);
                }

                
                //圖文相關
                $smarty->assign("pagenumber",$pagenumber);
                $smarty->assign("titles",$titles);
                $smarty->assign("pics",$pics);
                $smarty->assign("tags",$tags);
                $smarty->assign("full_content",$full_content);
                $smarty->assign("pages",$pages);
                $smarty->assign("previous_page",$previous_page);
                $smarty->assign("next_page",$next_page);
                $smarty->assign("relate_article_array",$relate_article_array);
                $smarty->assign("allow_comment",$allow_comment);
                
                //視頻相關
                $smarty->assign("v17173_id",$v17173_id);
                $smarty->assign("vqq_id",$vqq_id);
                $smarty->assign("tudou_id",$tudou_id);
                $smarty->assign("v56_id",$v56_id);
                $smarty->assign("youkuid",$youkuid);
                $smarty->assign("letv_id",$letv_id);
                $smarty->assign("gameinfo_lists",$gameinfo_lists);
                
                //評測相關
                //增加對關聯鏈接/圖片ALT的處理 @wangguanqing 
                /* $content = $this->_keylinks($content); 
                $content = preg_replace("/alt=\".*?\"/i","alt=\"$title\"",$content);
                $smarty->assign("content",$content); */
				 $v4 = array(
                'show_pingce'=>'show_pingce_news',
                'show_moke'=>'show_moke',
                'show_www_news'=>'show_news',
                'show_ios_news'=>'show_news',
                'show_android_news'=>'show_news',
                'show_chanye_news'=>'show_news',
                'show_video'=>'show_video_news'
				);
				 $template_m = $template_m ? $template_m : $CAT['setting']['show_template'];
				
				if(!$template_m) $template_m = '';
                $smarty->assign("template",$template);
                $smarty->assign("siteid",$siteid);

                //數據處理
                $keyword = keyword_arr($keywords,0,3);
                $smarty->assign("keyword",$keyword);

                $template = $v4[$template];
              $smarty->display('content/'.$template.'.tpl');
		}else{
		include template('content',$template);
		}	
		$pc_hash = $_SESSION['pc_hash'];
		$steps = intval($_GET['steps']);
		echo "
		<link href=\"".CSS_PATH."dialog_simp.css\" rel=\"stylesheet\" type=\"text/css\" />
		<script language=\"javascript\" type=\"text/javascript\" src=\"".JS_PATH."dialog.js\"></script>
		<script type=\"text/javascript\">art.dialog({lock:false,title:'".L('operations_manage')."',mouse:true, id:'content_m', content:'<span id=cloading ><a href=\'javascript:ajax_manage(1)\'>".L('passed_checked')."</a> | <a href=\'javascript:ajax_manage(2)\'>".L('reject')."</a> |　<a href=\'javascript:ajax_manage(3)\'>".L('delete')."</a></span>',left:'100%',top:'100%',width:200,height:50,drag:true, fixed:true});
		function ajax_manage(type) {
			if(type==1) {
				$.get('?m=content&c=content&a=pass&ajax_preview=1&catid=".$catid."&steps=".$steps."&id=".$id."&pc_hash=".$pc_hash."');
			} else if(type==2) {
				$.get('?m=content&c=content&a=pass&ajax_preview=1&reject=1&catid=".$catid."&steps=".$steps."&id=".$id."&pc_hash=".$pc_hash."');
			} else if(type==3) {
				$.get('?m=content&c=content&a=delete&ajax_preview=1&dosubmit=1&catid=".$catid."&steps=".$steps."&id=".$id."&pc_hash=".$pc_hash."');
			}
			$('#cloading').html('<font color=red>".L('operation_success')."<span id=\"secondid\">2</span>".L('after_a_few_seconds_left')."</font>');
			setInterval('set_time()', 1000);
			setInterval('window.close()', 2000);
		}
		function set_time() {
			$('#secondid').html(1);
		}
		</script>";
	}

	/**
	 * 審核所有內容
	 */
	public function public_checkall() {
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

		$show_header = '';
		$workflows = getcache('workflow_'.$this->siteid,'commons');
		$datas = array();
		$pagesize = 20;
		$sql = '';
		if (in_array($_SESSION['roleid'], array('1'))) {
			$super_admin = 1;
			$status = isset($_GET['status']) ? $_GET['status'] : -1;
		} else {
			$super_admin = 0;
			$status = isset($_GET['status']) ? $_GET['status'] : 1;
			if($status==-1) $status = 1;
		}
		if($status>4) $status = 4;
		$this->priv_db = pc_base::load_model('category_priv_model');;
		$admin_username = param::get_cookie('admin_username');
		if($status==-1) {
			$sql = "`status` NOT IN (99,0,-2) AND `siteid`=$this->siteid";
		} else {
			$sql = "`status` = '$status' AND `siteid`=$this->siteid";
		}
		if($status!=0 && !$super_admin) {
			//以欄目進行循環
			foreach ($this->categorys as $catid => $cat) {
				if($cat['type']!=0) continue;
				//查看管理員是否有這個欄目的查看權限。
				if (!$this->priv_db->get_one(array('catid'=>$catid, 'siteid'=>$this->siteid, 'roleid'=>$_SESSION['roleid'], 'is_admin'=>'1'))) {
					continue;
				}
				//如果欄目有設置工作流，進行權限檢查。
				$workflow = array();
				$cat['setting'] = string2array($cat['setting']);
				if (isset($cat['setting']['workflowid']) && !empty($cat['setting']['workflowid'])) {
					$workflow = $workflows[$cat['setting']['workflowid']];
					$workflow['setting'] = string2array($workflow['setting']);
					$usernames = $workflow['setting'][$status];
					if (empty($usernames) || !in_array($admin_username, $usernames)) {//判斷當前管理，在工作流中可以審核幾審
						continue;
					}
				}
				$priv_catid[] = $catid;
			}
			if(empty($priv_catid)) {
				$sql .= " AND catid = -1";
			} else {
				$priv_catid = implode(',', $priv_catid);
				$sql .= " AND catid IN ($priv_catid)";
			}
		}
		$this->content_check_db = pc_base::load_model('content_check_model');
		$datas = $this->content_check_db->listinfo($sql,'inputtime DESC',$page);
		$pages = $this->content_check_db->pages;
		include $this->admin_tpl('content_checkall');
	}

	/**
	 * 批量移動文章
	 */
	public function remove() {
		if(isset($_POST['dosubmit'])) {
			$this->content_check_db = pc_base::load_model('content_check_model');
			if($_POST['fromtype']==0) {
				if($_POST['ids']=='') showmessage(L('please_input_move_source'));
				if(!$_POST['tocatid']) showmessage(L('please_select_target_category'));
				$tocatid = intval($_POST['tocatid']);
				$modelid = $this->categorys[$tocatid]['modelid'];
				if(!$modelid) showmessage(L('illegal_operation'));
				$ids = array_filter(explode(',', $_POST['ids']),"intval");
				foreach ($ids as $id) {
					$checkid = 'c-'.$id.'-'.$this->siteid;
					$this->content_check_db->update(array('catid'=>$tocatid), array('checkid'=>$checkid));
				}
				$ids = implode(',', $ids);
				$this->db->set_model($modelid);
				$this->db->update(array('catid'=>$tocatid),"id IN($ids)");
			} else {
				if(!$_POST['fromid']) showmessage(L('please_input_move_source'));
				if(!$_POST['tocatid']) showmessage(L('please_select_target_category'));
				$tocatid = intval($_POST['tocatid']);
				$modelid = $this->categorys[$tocatid]['modelid'];
				if(!$modelid) showmessage(L('illegal_operation'));
				$fromid = array_filter($_POST['fromid'],"intval");
				$fromid = implode(',', $fromid);
				$this->db->set_model($modelid);
				$this->db->update(array('catid'=>$tocatid),"catid IN($fromid)");
			}
			showmessage(L('operation_success'),HTTP_REFERER);
			//ids
		} else {
			$show_header = '';
			$catid = intval($_GET['catid']);
			$modelid = $this->categorys[$catid]['modelid'];
			$tree = pc_base::load_sys_class('tree');
			$tree->icon = array('&nbsp;&nbsp;│ ','&nbsp;&nbsp;├─ ','&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;';
			$categorys = array();
			foreach($this->categorys as $cid=>$r) {
				if($this->siteid != $r['siteid'] || $r['type']) continue;
				if($modelid && $modelid != $r['modelid']) continue;
				//$r['disabled'] = $r['child'] ? 'disabled' : '';
				$r['selected'] = $cid == $catid ? 'selected' : '';
				$categorys[$cid] = $r;
			}
			$str  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";

			$tree->init($categorys);
			$string .= $tree->get_tree(0, $str);
 			$str  = "<option value='\$catid'>\$spacer \$catname</option>";
			$source_string = '';
			$tree->init($categorys);
			$source_string .= $tree->get_tree(0, $str);
			$ids = empty($_POST['ids']) ? '' : implode(',',$_POST['ids']);
			include $this->admin_tpl('content_remove');
		}
	}

	/**
	 * 同時發布到其他欄目
	 */
	public function add_othors() {
		$show_header = '';
		$sitelist = getcache('sitelist','commons');
		$siteid = $_GET['siteid'];
		include $this->admin_tpl('add_othors');

	}
	/**
	 * 同時發布到其他欄目 異步加載欄目
	 */
	public function public_getsite_categorys() {
		$siteid = intval($_GET['siteid']);
		$this->categorys = getcache('category_content_'.$siteid,'commons');
		$models = getcache('model','commons');
		$tree = pc_base::load_sys_class('tree');
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		if($_SESSION['roleid'] != 1) {
			$this->priv_db = pc_base::load_model('category_priv_model');
			$priv_result = $this->priv_db->select(array('action'=>'add','roleid'=>$_SESSION['roleid'],'siteid'=>$siteid,'is_admin'=>1));
			$priv_catids = array();
			foreach($priv_result as $_v) {
				$priv_catids[] = $_v['catid'];
			}
			if(empty($priv_catids)) return '';
		}

		foreach($this->categorys as $r) {
			if($r['siteid']!=$siteid || $r['type']!=0) continue;
			if($_SESSION['roleid'] != 1 && !in_array($r['catid'],$priv_catids)) {
				$arrchildid = explode(',',$r['arrchildid']);
				$array_intersect = array_intersect($priv_catids,$arrchildid);
				if(empty($array_intersect)) continue;
			}
			$r['modelname'] = $models[$r['modelid']]['name'];
			$r['style'] = $r['child'] ? 'color:#8A8A8A;' : '';
			$r['click'] = $r['child'] ? '' : "onclick=\"select_list(this,'".safe_replace($r['catname'])."',".$r['catid'].")\" class='cu' title='".L('click_to_select')."'";
			$categorys[$r['catid']] = $r;
		}
		$str  = "<tr \$click >
					<td align='center'>\$id</td>
					<td style='\$style'>\$spacer\$catname</td>
					<td align='center'>\$modelname</td>
				</tr>";
		$tree->init($categorys);
		$categorys = $tree->get_tree(0, $str);
		echo $categorys;
	}

	public function public_sub_categorys() {
		$cfg = getcache('common','commons');
		$ajax_show = intval(abs($cfg['category_ajax']));
		$catid = intval($_POST['root']);
		$modelid = intval($_POST['modelid']);
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$tree = pc_base::load_sys_class('tree');
		if(!empty($this->categorys)) {
			foreach($this->categorys as $r) {
				if($r['siteid']!=$this->siteid ||  ($r['type']==2 && $r['child']==0)) continue;
				if($from=='content' && $_SESSION['roleid'] != 1 && !in_array($r['catid'],$priv_catids)) {
					$arrchildid = explode(',',$r['arrchildid']);
					$array_intersect = array_intersect($priv_catids,$arrchildid);
					if(empty($array_intersect)) continue;
				}
				if($r['type']==1 || $from=='block') {
					if($r['type']==0) {
						$r['vs_show'] = "<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=".$r['catid']."&type=show' target='right'>[".L('content_page')."]</a>";
					} else {
						$r['vs_show'] ='';
					}
					$r['icon_type'] = 'file';
					$r['add_icon'] = '';
					$r['type'] = 'add';
				} else {
					$r['icon_type'] = $r['vs_show'] = '';
					$r['type'] = 'init';
					$r['add_icon'] = "<a target='right' href='?m=content&c=content&menuid=".$_GET['menuid']."&catid=".$r['catid']."' onclick=javascript:openwinx('?m=content&c=content&a=add&menuid=".$_GET['menuid']."&catid=".$r['catid']."&hash_page=".$_SESSION['hash_page']."','')><img src='".IMG_PATH."add_content.gif' alt='".L('add')."'></a> ";
				}
				$categorys[$r['catid']] = $r;
			}
		}
		if(!empty($categorys)) {
			$tree->init($categorys);
				switch($from) {
					case 'block':
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=block&c=block_admin&a=public_visualization&menuid=".$_GET['menuid']."&catid=\$catid&type=list&pc_hash=".$_SESSION['pc_hash']."' target='right'>\$catname</a> \$vs_show</span>";
					break;

					default:
						$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=content&c=content&a=\$type&menuid=".$_GET['menuid']."&catid=\$catid&pc_hash=".$_SESSION['pc_hash']."' target='right' onclick='open_list(this)'>\$catname</a></span>";
						break;
				}
			$data = $tree->creat_sub_json($catid,$strs);
		}
		echo $data;
	}

	/**
	 * 一鍵清理演示數據
	 */
	public function clear_data() {
		//清理數據涉及到的數據表

		if ($_POST['dosubmit']) {
			set_time_limit(0);
			$models = array('category', 'content', 'hits', 'search', 'position_data', 'video_content', 'video_store', 'comment');
			$tables = $_POST['tables'];
			if (is_array($tables)) {
				foreach ($tables as $t) {
					if (in_array($t, $models)) {
						if ($t=='content') {
							$model = $_POST['model'];
							$db = pc_base::load_model('content_model');
							//讀取網站的所有模型
							$model_arr = getcache('model', 'commons');
							foreach ($model as $modelid) {
								$db->set_model($modelid);
								if ($r = $db->count()) { //判斷模型下是否有數據
									$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$model_arr[$modelid]['tablename'].'.sql';
									$result = $data = $db->select();
									$this->create_sql_file($result, $db->db_tablepre.$model_arr[$modelid]['tablename'], $sql_file);
									$db->query('TRUNCATE TABLE `phpcms_'.$model_arr[$modelid]['tablename'].'`');
									//開始清理模型data表數據
									$db->table_name = $db->table_name.'_data';
									$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$model_arr[$modelid]['tablename'].'_data.sql';
									$result = $db->select();
									$this->create_sql_file($result, $db->db_tablepre.$model_arr[$modelid]['tablename'].'_data', $sql_file);
									$db->query('TRUNCATE TABLE `phpcms_'.$model_arr[$modelid]['tablename'].'_data`');
									//刪除該模型中在hits表的數據
									$hits_db = pc_base::load_model('hits_model');
									$hitsid = 'c-'.$modelid.'-';
									$result = $hits_db->select("`hitsid` LIKE '%$hitsid%'");
									if (is_array($result)) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'hits-'.$modelid.'.sql';
										$this->create_sql_file($result, $hits_db->db_tablepre.'hits', $sql_file);
									}
									$hits_db->delete("`hitsid` LIKE '%$hitsid%'");
									//刪除該模型在search中的數據
									$search_db = pc_base::load_model('search_model');
									$type_model = getcache('type_model_'.$model_arr[$modelid]['siteid'], 'search');
									$typeid = $type_model[$modelid];
									$result = $search_db->select("`typeid`=".$typeid);
									if (is_array($result)) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'search-'.$modelid.'.sql';
										$this->create_sql_file($result, $search_db->db_tablepre.'search', $sql_file);
									}
									$search_db->delete("`typeid`=".$typeid);
									//Delete the model data in the position table
									$position_db = pc_base::load_model('position_data_model');
									$result = $position_db->select('`modelid`='.$modelid.' AND `module`=\'content\'');
									if (is_array($result)) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'position_data-'.$modelid.'.sql';
										$this->create_sql_file($result, $position_db->db_tablepre.'position_data', $sql_file);
									}
									$position_db->delete('`modelid`='.$modelid.' AND `module`=\'content\'');
									//清理視頻庫與內容對應關系表
									if (module_exists('video')) {
										$video_content_db = pc_base::load_model('video_content_model');
										$result = $video_content_db->select('`modelid`=\''.$modelid.'\'');
										if (is_array($result)) {
											$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'video_content-'.$modelid.'.sql';
											$this->create_sql_file($result, $video_content_db->db_tablepre.'video_content', $sql_file);
										}
										$video_content_db->delete('`modelid`=\''.$modelid.'\'');
									}
									//清理評論表及附件表，附件的清理為不可逆操作。
									//附件初始化
									//$attachment = pc_base::load_model('attachment_model');
									//$comment = pc_base::load_app_class('comment', 'comment');
									//if(module_exists('comment')){
										//$comment_exists = 1;
									//}
									//foreach ($data as $d) {
										//$attachment->api_delete('c-'.$d['catid'].'-'.$d['id']);
										//if ($comment_exists) {
											//$commentid = id_encode('content_'.$d['catid'], $d['id'], $model_arr[$modelid]['siteid']);
											//$comment->del($commentid, $model_arr[$modelid]['siteid'], $d['id'], $d['catid']);
										//}
									//}
								}
							}

						} elseif ($t=='comment') {
							$comment_db = pc_base::load_model('comment_data_model');
							for($i=1;;$i++) {
								$comment_db->table_name($i);
								if ($comment_db->table_exists(str_replace($comment_db->db_tablepre, '', $comment_db->table_name))) {
									if ($r = $comment_db->count()) {
										$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'comment_data_'.$i.'.sql';
										$result = $comment_db->select();
										$this->create_sql_file($result, $comment_db->db_tablepre.'comment_data_'.$i, $sql_file);
										$comment_db->query('TRUNCATE TABLE `phpcms_comment_data_'.$i.'`');
									}
								} else {
									break;
								}
							}
						} else {
							$db = pc_base::load_model($t.'_model');
							if ($r = $db->count()) {
								$result = $db->select();
								$sql_file = CACHE_PATH.'bakup'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$t.'.sql';
								$this->create_sql_file($result, $db->db_tablepre.$t, $sql_file);
								$db->query('TRUNCATE TABLE `phpcms_'.$t.'`');
							}
						}
					}
				}
			}
			showmessage(L('clear_data_message'));
		} else {
			//讀取網站的所有模型
			$model_arr = getcache('model', 'commons');
			include $this->admin_tpl('clear_data');
		}
	}

	/**
	 * 備份數據到文件
	 * @param $data array 備份的數據數組
	 * @param $tablename 數據所屬數據表
	 * @param $file 備份到的文件
	 */
	private function create_sql_file($data, $db, $file) {
		if (is_array($data)) {
			$sql = '';
			foreach ($data as $d) {
				$tag = '';
				$sql .= "INSERT INTO `".$db.'` VALUES(';
				foreach ($d as $_f => $_v) {
					$sql .= $tag.'\''.addslashes($_v).'\'';
					$tag = ',';
				}
				$sql .= ');'."\r\n";
			}
			file_put_contents($file, $sql);
		}
		return true;
	}

	/**
	* 新的產品庫接口列表 （李偉提供 ） 
	*/
	public function public_relation_game_list(){
		$keywords = urlencode($_GET['keywords']);
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		$pagesize = intval($_GET['pagesize']) ? intval($_GET['pagesize']) : 5;
		// $offset = ($page - 1)*$pagesize;
		$game_api = "http://game.mofang.com.tw/api/web/GetGameList?keywords=".$keywords."&offset=".$offset."&size=".$pagesize."&page=".$page;
		$datas = mf_curl_get($game_api);
		$datas = json_decode($datas,true);
		if($datas['code']=='0') {
			$infos = $datas['data']['data'];
		}else{
			echo '產品庫未查詢到相關遊戲！';
		}
		$totals = $datas['data']['total'];
		include $this->admin_tpl('relation_game_list');
	} 


	//顯示關聯遊戲（李偉新產品庫）
	public function public_getjson_relationgame() {
		$modelid = intval($_GET['modelid']);
		$id = intval($_GET['id']);
		$this->db->set_model($modelid);
		$tablename = $this->db->table_name;
		$this->db->table_name = $tablename.'_data';
		$r = $this->db->get_one(array('id'=>$id),'relation_game');
		$infos = array();
		if($r['relation_game']) {
			$relation_array = explode('|', $r['relation_game']);
			//獲取遊戲名稱及ID 
			if(!empty($relation_array)){
				foreach ($relation_array as $key => $gameid) {
					# code...
					if($gameid){
						$game_api = "http://game.mofang.com.tw/api/game/info?id=".$gameid;
						$datas = mf_curl_get($game_api);
						$datas = json_decode($datas,true);
						if($datas['code']=='0') {
							$array['sid'] = $datas['data']['id'];
							$array['id'] = $datas['data']['id'];
							// if(strtolower(CHARSET)=='gbk') $array['title'] = iconv('gbk', 'utf-8', $datas['data']['name']);
							 $array['title'] =  $datas['data']['name'];
							$infos[] = $array;
						}
					}
				}
			}
		}
		echo json_encode($infos);
	}

	//文章回收站功能 
	public function recycle(){
		$catid = intval($catid);
		if(!$catid){
			showmessage('請選擇正確的欄目！',HTTP_REFERER);
			return false;
		}
		

	}


	/**
	 *
	 * 刪除到回收站
	 *
	 */
	public function delete_new() {
		if(isset($_GET['dosubmit'])) {
			$this->position_data_db = pc_base::load_model('position_data_model');

			$catid = intval($_GET['catid']);
			if(!$catid) showmessage(L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$sethtml = $this->categorys[$catid]['sethtml'];
			$siteid = $this->categorys[$catid]['siteid'];
			if(isset($_GET['ajax_preview'])) {
				$ids = intval($_GET['id']);
				$_POST['ids'] = array(0=>$ids);
			}
			if(empty($_POST['ids'])) showmessage(L('you_do_not_check'));
			$this->db->set_model($modelid);
			foreach($_POST['ids'] as $id) {
				$this->db->update(array("status"=>33, "updatetime"=>SYS_TIME),array("id"=>$id));
				//刪除推薦位數據
				$this->position_data_db->delete(array('id'=>$id,'catid'=>$catid,'module'=>'content'));
			}
			showmessage('已經暫放文章回收站裡，正在返回。。。。',HTTP_REFERER);
		}
	}

	function _keylinks($txt, $replacenum = '',$link_mode = 1) {
        $search = "/(alt\s*=\s*|title\s*=\s*)[\"|\'](.+?)[\"|\']/ise";
        $replace = "\$this->_base64_encode('\\1','\\2')";
        $replace1 = "\$this->_base64_decode('\\1','\\2')";
        $txt = preg_replace($search, $replace, $txt);
        //  if($keywords) $keywords = strpos(',',$keywords) === false ? explode(' ',$keywords) : explode(',',$keywords);
        // if($link_mode && !empty($keywords)) { 
        //     foreach($keywords as $keyword) {
        //         $linkdatas[] = $keyword;
        //     }
        // } else {
        //     $linkdatas = getcache('keylink','commons');
        // }

        $linkdatas = getcache('keylink','commons');
        if($linkdatas) {
            $word = $replacement = array();
            foreach($linkdatas as $v) {
                if($link_mode && $keywords) {
                    $word1[] = '/(?!(<a.*?))' . preg_quote($v, '/') . '(?!.*<\/a>)/s';
                    $word2[] = $v;
                    $replacement[] = '<a href="javascript:;" onclick="show_ajax(this)" class="keylink">'.$v.'</a>';
                } else {
                    $word1[] = '/(?!(<a.*?))' . preg_quote($v[0], '/') . '(?!.*<\/a>)/s';
                    $word2[] = $v[0];                   
                    $replacement[] = '<a href="'.$v[1].'" target="_blank" class="keylink"><span style="color:#ff0000;">'.$v[0].'</span></a>';
                }
            }
            if($replacenum != '') {
                $txt = preg_replace($word1, $replacement, $txt, 1);
            } else {
                 foreach ($word2 as $word2key => $var) {//循環要替換的字符串
                    $pos = strpos($txt, $var);
                    if ($pos === false) {
                        continue;
                    }
                    $txt = substr_replace($txt, $replacement[$word2key], $pos, strlen($var));
                }  
            }
        }
        $txt = preg_replace($search, $replace1, $txt,1);
        return $txt;
    }
	/**
	*批量復制魔方初體驗的內容到新欄目 
	*只用一次,下次有可能注釋掉 10.31
	*
	*/
	public function copy_all(){
		$this->db->set_model(1);
		$data = $this->db->select(array("catid"=>1157));
		$data_count = $this->db->count(array("catid"=>1157));
		$this->db->set_model(36);
		$err = "";
		$num = 0;
		
		foreach($data as $v){
			$num++;
			unset($v['id']);
			unset($v['keywords']);
			$v['islink']=1;
			$v['catid']=1454;
			if(!$this->db->insert($v)){
				$err.=$v['catid']."-".$v['id']."|";
				continue;
			}
		}
		echo "成功導入 <span style='color:green;font-weight:bold'>".$num."</span> 條數據";
		echo"<hr>";
		if(!empty($err)){
		echo "shibai導入<span style='color:red'>".$err."</span>信息";
		}
	}




}
?>

