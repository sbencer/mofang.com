<?php

defined('IN_PHPCMS') or exit('No permission resources.');

if(!defined('CACHE_MODEL_PATH')) define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);



/**

 * 內容模型數據庫操作類

 */

pc_base::load_sys_class('model', '', 0);

class content_model extends model {

	public $table_name = '';

	public $category = '';

	public function __construct() {

		$this->db_config = pc_base::load_config('database');

		$this->db_setting = 'default';

		parent::__construct();

		$this->url = pc_base::load_app_class('url', 'content');

		$this->siteid = get_siteid();

	}

	public function set_model($modelid) {

		$this->model = getcache('model', 'commons');

		$this->modelid = $modelid;

		$this->table_name = $this->db_tablepre.$this->model[$modelid]['tablename'];

		$this->model_tablename = $this->model[$modelid]['tablename'];

	}

	/**

	 * 添加內容

	 *

	 * @param $datas

	 * @param $isimport 是否為外部接口導入

	 */

	public function add_content($data,$isimport = 0) {

		if($isimport) $data = new_addslashes($data);

		$modelid = $this->modelid;

		require_once CACHE_MODEL_PATH.'content_input.class.php';

        require_once CACHE_MODEL_PATH.'content_update.class.php';

		$content_input = new content_input($this->modelid);

		$inputinfo = $content_input->get($data,$isimport);

		$systeminfo = $inputinfo['system'];
		$modelinfo = $inputinfo['model'];


		if($data['inputtime'] && !is_numeric($data['inputtime'])) {

			$systeminfo['inputtime'] = strtotime($data['inputtime']);

		} elseif(!$data['inputtime']) {

			$systeminfo['inputtime'] = SYS_TIME;

		} else {

			$systeminfo['inputtime'] = $data['inputtime'];

		}


        $systeminfo['style'] = $data['style'];

		//讀取模型字段配置中，關於日期配置格式，來組合日期數據

		$this->fields = getcache('model_field_'.$modelid,'model');

		$setting = string2array($this->fields['inputtime']['setting']);

		extract($setting);

		if($fieldtype=='date') {

			$systeminfo['inputtime'] = date('Y-m-d');

		}elseif($fieldtype=='datetime'){

 			$systeminfo['inputtime'] = date('Y-m-d H:i:s');

		}



		if($data['updatetime'] && !is_numeric($data['updatetime'])) {

			$systeminfo['updatetime'] = strtotime($data['updatetime']);

		} elseif(!$data['updatetime']) {

			$systeminfo['updatetime'] = SYS_TIME;

		} else {

			$systeminfo['updatetime'] = $data['updatetime'];

		}

		$systeminfo['username'] = $data['username'] ? $data['username'] : param::get_cookie('admin_username');

		$systeminfo['sysadd'] = defined('IN_ADMIN') ? 1 : 0;



		//自動提取摘要

		if(isset($_POST['add_introduce']) && $systeminfo['description'] == '' && isset($modelinfo['content'])) {

			$content = stripslashes($modelinfo['content']);

			$introcude_length = intval($_POST['introcude_length']);

			$systeminfo['description'] = str_cut(str_replace(array("\r\n","\t",'[page]','[/page]','&ldquo;','&rdquo;','&nbsp;'), '', strip_tags($content)),$introcude_length);

			$inputinfo['system']['description'] = $systeminfo['description'] = addslashes($systeminfo['description']);

		}


		//自動提取縮略圖

		if(isset($_POST['auto_thumb']) && $systeminfo['thumb'] == '' && isset($modelinfo['content'])) {

			$content = $content ? $content : stripslashes($modelinfo['content']);

			$auto_thumb_no = intval($_POST['auto_thumb_no'])-1;

			if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {

				$systeminfo['thumb'] = $matches[3][$auto_thumb_no];

			}

		}

		//向產品庫中添加數據時，轉換標題為拼音

		if ($this->model_tablename == 'product') {

			pc_base::load_sys_func('iconv');

			$letters = gbk_to_pinyin($systeminfo['title']);

			if ($letters) {

				$systeminfo['letter'] = strtolower(implode('', $letters));

				$systeminfo['initial'] = '';

				foreach ($letters as $word) {

					$systeminfo['initial'] .= strtolower($word[0]);

				}

			}

		}


		// var_dump($data);exit();		

		//主表

		$tablename = $this->table_name = $this->db_tablepre.$this->model_tablename;

		$id = $modelinfo['id'] = $this->insert($systeminfo,true);

		$this->update($systeminfo,array('id'=>$id));

		// 設置主表中定時文章的狀態
		if($systeminfo['timed']){
			$this->update(array('status'=>21),array('id'=>$id));
		}

		//更新URL地址

		if($data['islink']==1) {

			$urls[0] = $_POST['linkurl'];

		} else {

			$urls = $this->url->show($id, 0, $systeminfo['catid'], $systeminfo['inputtime'], $data['prefix'],$inputinfo,'add');

		}

		$this->table_name = $tablename;

		$this->update(array('url'=>$urls[0]),array('id'=>$id));

		//附屬表

		$this->table_name = $this->table_name.'_data';

		$this->insert($modelinfo);

		//添加統計

		$this->hits_db = pc_base::load_model('hits_model');

		$hitsid = 'c-'.$modelid.'-'.$id;

		$this->hits_db->insert(array('hitsid'=>$hitsid,'catid'=>$systeminfo['catid'],'inputtime'=>SYS_TIME));

		//更新到全站搜索

		$searchinfo = $inputinfo['search'];

		$searchinfo['ukid'] = $systeminfo['catid'].'0'.$id;

		$searchinfo['id'] = $id;

        $searchinfo['catid'] = $systeminfo['catid'];

        $searchinfo['modelid'] = $this->modelid;

        $specialid = array('1'=>'news','3'=>'picture','11'=>'video','20'=>'game', '21'=>'game');

		$searchinfo['types'] = $specialid[$this->modelid];

		$searchinfo['url'] = $urls[0];

        $searchinfo['thumb'] = $data['thumb']; // 新添加行，不知是否會把縮略圖填入solr中，待驗證

		//$this->search_api($searchinfo);

		//更新欄目統計數據

		$this->update_category_items($systeminfo['catid'],'add',1);

		//調用 update

		$content_update = new content_update($this->modelid,$id);

		//合並後，調用update

		$merge_data = array_merge($systeminfo,$modelinfo);

		$merge_data['posids'] = $data['posids'];

		$content_update->update($merge_data);

		// 發布到定時列表中-同在審核表裡

		if($systeminfo['timed']){

			$this->content_check_db = pc_base::load_model('content_check_model');

			$check_data = array(

				'checkid'=>'c-'.$id.'-'.$modelid,

				'catid'=>$systeminfo['catid'],

				'siteid'=>$this->siteid,

				'title'=>$systeminfo['title'],

				'username'=>$systeminfo['username'],

				'inputtime'=>$systeminfo['inputtime'],

				'status'=>21,

				);

			$this->content_check_db->insert($check_data);

		}

		//發布到審核列表中

		if(!defined('IN_ADMIN') || $data['status']!=99) {

			$this->content_check_db = pc_base::load_model('content_check_model');

			$check_data = array(

				'checkid'=>'c-'.$id.'-'.$modelid,

				'catid'=>$systeminfo['catid'],

				'siteid'=>$this->siteid,

				'title'=>$systeminfo['title'],

				'username'=>$systeminfo['username'],

				'inputtime'=>$systeminfo['inputtime'],

				'status'=>$data['status'],

				);

			$this->content_check_db->insert($check_data);

		}

		//END發布到審核列表中

		if(!$isimport) {

			$html = pc_base::load_app_class('html', 'content');

			$urls['data']['system']['id'] = $id;

			if($urls['content_ishtml'] && $data['status']==99) $html->show($urls[1],$urls['data']);

			$catid = $systeminfo['catid'];

		}

		//發布到其他欄目

		if($id && isset($_POST['othor_catid']) && is_array($_POST['othor_catid'])) {

			$linkurl = $urls[0];

			$r = $this->get_one(array('id'=>$id));

			foreach ($_POST['othor_catid'] as $cid=>$_v) {

				$this->set_catid($cid);

				$mid = $this->category[$cid]['modelid'];

				if($modelid==$mid) {

					//相同模型的欄目插入新的數據

					$inputinfo['system']['catid'] = $systeminfo['catid'] = $cid;

					$newid = $modelinfo['id'] = $this->insert($systeminfo,true);

					$this->table_name = $tablename.'_data';

					$this->insert($modelinfo);

					if($data['islink']==1) {

						$urls = $_POST['linkurl'];

					} else {

						$urls = $this->url->show($newid, 0, $cid, $systeminfo['inputtime'], $data['prefix'],$inputinfo,'add');

					}

					$this->table_name = $tablename;

					$this->update(array('url'=>$urls[0]),array('id'=>$newid));

					//發布到審核列表中

					if($data['status']!=99) {

						$check_data = array(

							'checkid'=>'c-'.$newid.'-'.$mid,

							'catid'=>$cid,

							'siteid'=>$this->siteid,

							'title'=>$systeminfo['title'],

							'username'=>$systeminfo['username'],

							'inputtime'=>$systeminfo['inputtime'],

							'status'=>1,

							);

						$this->content_check_db->insert($check_data);

					}

					if($urls['content_ishtml'] && $data['status']==99) $html->show($urls[1],$urls['data']);

				} else {

					//不同模型插入轉向鏈接地址

					$newid = $this->insert(

					array('title'=>$systeminfo['title'],

						'style'=>$systeminfo['style'],

						'thumb'=>$systeminfo['thumb'],

						'keywords'=>$systeminfo['keywords'],

						'description'=>$systeminfo['description'],

						'status'=>$systeminfo['status'],

						'catid'=>$cid,'url'=>$linkurl,

						'sysadd'=>1,

						'username'=>$systeminfo['username'],

						'inputtime'=>$systeminfo['inputtime'],

						'updatetime'=>$systeminfo['updatetime'],

						'islink'=>1

					),true);

					$this->table_name = $this->table_name.'_data';

					$this->insert(array('id'=>$newid));

					//發布到審核列表中

					if($data['status']!=99) {

						$check_data = array(

							'checkid'=>'c-'.$newid.'-'.$mid,

							'catid'=>$systeminfo['catid'],

							'siteid'=>$this->siteid,

							'title'=>$systeminfo['title'],

							'username'=>$systeminfo['username'],

							'inputtime'=>$systeminfo['inputtime'],

							'status'=>1,

							);

						$this->content_check_db->insert($check_data);

					}

				}

				$hitsid = 'c-'.$mid.'-'.$newid;

				$this->hits_db->insert(array('hitsid'=>$hitsid,'catid'=>$cid,'inputtime'=>SYS_TIME));

			}

		}

		//END 發布到其他欄目

		//創建專區

		if (isset($systeminfo['area_level']) && $systeminfo['area_level'] === '1') {

			$this->area = pc_base::load_model('area_model');

			$menus = get_area_menus();

			foreach ($menus as $menu) {

				$area_menus[] = array(

					'productid' => $id,

					'catid' => $menu['catid'],

					'name' => $menu['catname'],

					);

			}

			$ret = $this->area->batch_insert($area_menus);

			$this->area->cache();

		}

		//END 創建專區

		//更新附件狀態

		if(pc_base::load_config('system','attachment_stat')) {

			$this->attachment_db = pc_base::load_model('attachment_model');

			$this->attachment_db->api_update('','c-'.$systeminfo['catid'].'-'.$id,2);

		}

		//生成靜態

		if(!$isimport && $data['status']==99) {

			//在添加和修改內容處定義了 INDEX_HTML

			if(defined('INDEX_HTML')) $html->index();

			if(defined('RELATION_HTML')) $html->create_relation_html($catid);

		}

		return $id;

	}

	/**

	 * 修改內容

	 *

	 * @param $datas

	 */

	public function edit_content($data,$id) {

		//前台權限判斷

		if(!defined('IN_ADMIN')) {

			$_username = param::get_cookie('_username');

			$us = $this->get_one(array('id'=>$id,'username'=>$_username));

			if(!$us) return false;

		}


		require_once CACHE_MODEL_PATH.'content_input.class.php';

        require_once CACHE_MODEL_PATH.'content_update.class.php';

		$content_input = new content_input($this->modelid);

		$inputinfo = $content_input->get($data);



		$systeminfo = $inputinfo['system'];

		$modelinfo = $inputinfo['model'];

		if($data['inputtime'] && !is_numeric($data['inputtime'])) {

			$systeminfo['inputtime'] = strtotime($data['inputtime']);

		} elseif(!$data['inputtime']) {

			$systeminfo['inputtime'] = SYS_TIME;

		} else {

			$systeminfo['inputtime'] = $data['inputtime'];

		}



		if($data['updatetime'] && !is_numeric($data['updatetime'])) {

			$systeminfo['updatetime'] = strtotime($data['updatetime']);

		} elseif(!$data['updatetime']) {

			$systeminfo['updatetime'] = SYS_TIME;

		} else {

			$systeminfo['updatetime'] = $data['updatetime'];

		}

		//自動提取摘要

		if(isset($_POST['add_introduce']) && $systeminfo['description'] == '' && isset($modelinfo['content'])) {

			$content = stripslashes($modelinfo['content']);

			$introcude_length = intval($_POST['introcude_length']);

			$systeminfo['description'] = str_cut(str_replace(array("\r\n","\t",'[page]','[/page]','&ldquo;','&rdquo;','&nbsp;'), '', strip_tags($content)),$introcude_length);

			$inputinfo['system']['description'] = $systeminfo['description'] = addslashes($systeminfo['description']);

		}

		//自動提取縮略圖

		if(isset($_POST['auto_thumb']) && $systeminfo['thumb'] == '' && isset($modelinfo['content'])) {

			$content = $content ? $content : stripslashes($modelinfo['content']);

			$auto_thumb_no = intval($_POST['auto_thumb_no'])-1;

			if(preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {

				$systeminfo['thumb'] = $matches[3][$auto_thumb_no];

			}

		}

		if($data['islink']==1) {

			$systeminfo['url'] = $_POST['linkurl'];

		} else {

			//更新URL地址

			$urls = $this->url->show($id, 0, $systeminfo['catid'], $systeminfo['inputtime'], $data['prefix'],$inputinfo,'edit');

			$systeminfo['url'] = $urls[0];

		}

		//向產品庫中添加數據時，轉換標題為拼音

		if ($this->model_tablename == 'product') {

			pc_base::load_sys_func('iconv');

			$letters = gbk_to_pinyin($systeminfo['title']);

			if ($letters) {

				$systeminfo['letter'] = strtolower(implode('', $letters));

				$systeminfo['initial'] = '';

				foreach ($letters as $word) {

					$systeminfo['initial'] .= strtolower($word[0]);

				}

			}

		}



		//主表

		$this->table_name = $this->db_tablepre.$this->model_tablename;

		$this->update($systeminfo,array('id'=>$id));



		//附屬表

		$this->table_name = $this->table_name.'_data';

		$this->update($modelinfo,array('id'=>$id));

		//更新到全站搜索

		$searchinfo = $inputinfo['search'];

		$searchinfo['ukid'] = $systeminfo['catid'].'0'.$id;

		$searchinfo['id'] = $id;

		$searchinfo['catid'] = $systeminfo['catid'];

        $searchinfo['modelid'] = $this->modelid;

        $specialid = array('1'=>'news','3'=>'picture','11'=>'video','20'=>'game', '21'=>'game');

		$searchinfo['types'] = $specialid[$this->modelid];

		$searchinfo['url'] = $systeminfo['url'];

		//$this->search_api($searchinfo);

		//調用 update

		$content_update = new content_update($this->modelid,$id);

		$content_update->update($data);

		//更新附件狀態

		if(pc_base::load_config('system','attachment_stat')) {

			$this->attachment_db = pc_base::load_model('attachment_model');

			$this->attachment_db->api_update('','c-'.$systeminfo['catid'].'-'.$id,2);

		}

		//更新審核列表

		$this->content_check_db = pc_base::load_model('content_check_model');

		$check_data = array(

			'catid'=>$systeminfo['catid'],

			'siteid'=>$this->siteid,

			'title'=>$systeminfo['title'],

			'status'=>$systeminfo['status'],

			);

		if(!isset($systeminfo['status'])) unset($check_data['status']);

		$this->content_check_db->update($check_data,array('checkid'=>'c-'.$id.'-'.$this->modelid));

		//更新專區

		if (isset($systeminfo['area_level']) && $systeminfo['area_level'] === '1') {

			$this->area = pc_base::load_model('area_model');

			if ( $this->area->count(array('productid'=>$id)) == 0) {

				$menus = get_area_menus();

				foreach ($menus as $menu) {

					$area_menus[] = array(

						'productid' => $id,

						'catid' => $menu['catid'],

						'name' => $menu['catname'],

						);

				}

				$ret = $this->area->batch_insert($area_menus);

				$this->area->cache();

			}

		}

		//END 更新專區

		//生成靜態

		$html = pc_base::load_app_class('html', 'content');

		if($urls['content_ishtml']) {

			$html->show($urls[1],$urls['data']);

		}

		//在添加和修改內容處定義了 INDEX_HTML

		if(defined('INDEX_HTML')) $html->index();

		if(defined('RELATION_HTML')) $html->create_relation_html($systeminfo['catid']);

		return true;

	}



	public function status($ids = array(), $status = 99) {

		$this->content_check_db = pc_base::load_model('content_check_model');

		$this->message_db = pc_base::load_model('message_model');

		$this->set_model($this->modelid);

		if(is_array($ids) && !empty($ids)) {

			foreach($ids as $id) {

				$this->update(array('status'=>$status, "updatetime"=>SYS_TIME),array('id'=>$id));

				$del = false;

				$r = $this->get_one(array('id'=>$id));

				if($status==0) {

				//退稿發送短消息、郵件

					$message = L('reject_message_tips').$r['title']."<BR><a href=\'index.php?m=member&c=content&a=edit&catid={$r[catid]}&id={$r[id]}\'><font color=red>".L('click_edit')."</font></a><br>";

					if(isset($_POST['reject_c']) && $_POST['reject_c'] != L('reject_msg')) {

						$message .= $_POST['reject_c'];

					} elseif(isset($_GET['reject_c']) && $_GET['reject_c'] != L('reject_msg')) {

						$message .= $_GET['reject_c'];

					}

					$this->message_db->add_message($r['username'],'SYSTEM',L('reject_message'),$message);

				} elseif($status==99 && $r['sysadd']) {

					$this->content_check_db->delete(array('checkid'=>'c-'.$id.'-'.$this->modelid));

					$del = true;

				}

				if(!$del) $this->content_check_db->update(array('status'=>$status),array('checkid'=>'c-'.$id.'-'.$this->modelid));

			}

		} else {

			$this->update(array('status'=>$status, "updatetime"=>SYS_TIME),array('id'=>$ids));

			$del = false;

			$r = $this->get_one(array('id'=>$ids));

			if($status==0) {

				//退稿發送短消息、郵件

				$message = L('reject_message_tips').$r['title']."<BR><a href=\'index.php?m=member&c=content&a=edit&catid={$r[catid]}&id={$r[id]}\'><font color=red>".L('click_edit')."</font></a><br>";

				if(isset($_POST['reject_c']) && $_POST['reject_c'] != L('reject_msg')) {

					$message .= $_POST['reject_c'];

				} elseif(isset($_GET['reject_c']) && $_GET['reject_c'] != L('reject_msg')) {

					$message .= $_GET['reject_c'];

				}

				$this->message_db->add_message($r['username'],'SYSTEM',L('reject_message'),$message);

			} elseif($status==99 && $r['sysadd']) {

				$this->content_check_db->delete(array('checkid'=>'c-'.$ids.'-'.$this->modelid));

				$del = true;

			}

			if(!$del) $this->content_check_db->update(array('status'=>$status),array('checkid'=>'c-'.$ids.'-'.$this->modelid));

		}

		return true;

	}

	/**

	 * 刪除內容

	 * @param $id 內容id

	 * @param $file 文件路徑

	 * @param $catid 欄目id

	 */

	public function delete_content($id,$file,$catid = 0) {

		// 獲得文章url作為solr刪除依據

		$res = $this->get_one(array('id'=>$id),'url');

		//刪除主表數據

		$this->delete(array('id'=>$id));

		//刪除從表數據

		$this->table_name = $this->table_name.'_data';

		$this->delete(array('id'=>$id));

		//重置默認表

		$this->table_name = $this->db_tablepre.$this->model_tablename;

		//更新欄目統計

		$this->update_category_items($catid,'delete');

		//刪除關聯遊戲數據表

		$this->table_name = $this->db_tablepre.'relation';

		$this->delete(array('scat'=>$catid,'sid'=>$id));

		// 刪除搜索索引
		$searchinfo['url'] = $res['url'];

		//$this->search_api($searchinfo,'delete');

	}


	/**

	 * 搜索索引更新

	 * @param $data 索引內容

	 * @param $action 索引內容

	 */
	private function search_api($data = array(), $action = 'update') {

		//獲取siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;

		//搜索配置
		$search_setting = getcache('search','search');

		$setting = $search_setting[$siteid];

		$solr = pc_base::load_app_class('apache_solr_service', 'search', 0);

		$solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);

		if (!$solr->ping()) {
			// 搜索服務無法鏈接時，跳過索引插入
			return;

		}

		$type_arr = getcache('search_model_'.$this->siteid,'search');

		$types = array_keys($type_arr);
		
		if(!in_array($this->modelid, $types)) return;

        $this->query("SELECT catid,arrparentid FROM www_partition_games g LEFT JOIN www_partition p ON g.part_id=p.catid WHERE g.modelid={$this->modelid} AND g.gameid={$data['id']}");

        $result = $this->fetch_array();

        if ($info = $result[0]) {

            if ($info['arrparentid'] == '0') {

                $data['partition'] = $info['catid'];

            } else {

                $parentids = explode(',', $info['arrparentid']);

                $data['partition'] = $parentids[1];

            }

        } else {

            $data['partition'] = 0;

        }

		try {

		if($action == 'update') {

			$solr->deleteByQuery('url:"'.$data['url'].'"');

			$document = new Apache_Solr_Document();

			foreach ($data as $key => $value) {
				if ($key == 'content') {
					$document->$key = strip_tags($value);
				} else {
					$document->$key = $value;
				}

			}

			$solr->addDocument($document);

		} elseif($action == 'delete') {

			$solr->deleteByQuery('url:"'.$data['url'].'"');
			
		}

		$solr->commit();

		} catch(Exception $e) {

		}
	}

	/**

	 * 獲取單篇信息

	 *

	 * @param $catid

	 * @param $id

	 */

	public function get_content($catid,$id) {

		$catid = intval($catid);

		$id = intval($id);

		if(!$catid || !$id) return false;

		$siteids = getcache('category_content','commons');

		$siteid = $siteids[$catid];

		$this->category = getcache('category_content_'.$siteid,'commons');

		if(isset($this->category[$catid]) && $this->category[$catid]['type'] == 0) {

			$modelid = $this->category[$catid]['modelid'];

			$this->set_model($modelid);

			$r = $this->get_one(array('id'=>$id));

			//附屬表

			$this->table_name = $this->table_name.'_data';

			$r2 = $this->get_one(array('id'=>$id));

			if($r2) {

				return array_merge($r,$r2);

			} else {

				return $r;

			}

		}

		return true;

	}

	/**

	 * 設置catid 所在的模型數據庫

	 *

	 * @param $catid

	 */

	public function set_catid($catid) {

		$catid = intval($catid);

		if(!$catid) return false;

		if(empty($this->category)) {

			$siteids = getcache('category_content','commons');

			$siteid = $siteids[$catid];

			$this->category = getcache('category_content_'.$siteid,'commons');

		}

		if(isset($this->category[$catid]) && $this->category[$catid]['type'] == 0) {

			$modelid = $this->category[$catid]['modelid'];

			$this->set_model($modelid);

		}

	}



	private function update_category_items($catid,$action = 'add',$cache = 0) {

		$this->category_db = pc_base::load_model('category_model');

		if($action=='add') {

			$this->category_db->update(array('items'=>'+=1'),array('catid'=>$catid));

		}  else {

			$this->category_db->update(array('items'=>'-=1'),array('catid'=>$catid));

		}

		if($cache) $this->cache_items();

	}



	public function cache_items() {

		$datas = $this->category_db->select(array('modelid'=>$this->modelid),'catid,type,items',10000);

		$array = array();

		foreach ($datas as $r) {

			if($r['type']==0) $array[$r['catid']] = $r['items'];

		}

		setcache('category_items_'.$this->modelid, $array,'commons');

	}

}


