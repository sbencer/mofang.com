<?php 
/**
 *  special_api.class.php 專題接口類
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-8-3
 */

defined('IN_PHPCMS') or exit('No permission resources.');

class special_api {
	
	private $db, $type_db, $c_db, $data_db;
	public $pages;
	
	public function __construct() {
		$this->db = pc_base::load_model('special_model'); //專題數據模型
		$this->type_db = pc_base::load_model('type_model'); //專題分類數據模型
		$this->c_db = pc_base::load_model('special_content_model'); //專題內容數據模型
		$this->data_db = pc_base::load_model('special_c_data_model'); 
	}
	
	/**
	 * 更新分類
	 * @param intval $pid 專題ID
	 * @param string $type 分類字符串 每行一個分類。格式為：分類名|分類目錄，例:最新新聞|news last
	 * @param string $a 添加時直接加入到數據庫，修改是需要判斷。
	 * @return boolen
	 */
	public function _update_type($specialid, $type, $a = 'add') {
		$specialid = intval($specialid);
		if (!$specialid) return false;
		$special_info = $this->db->get_one(array('id'=>$specialid));
		$app_path = substr(APP_PATH, 0, -1);
		foreach ($type as $k => $v) {
			if (!$v['name'] || !$v['typedir']) continue;
			//添加時，無需判斷直接加到數據表中，修改時應判斷是否為新添加、修改還是刪除
			$siteid = get_siteid();
			if ($a == 'add' && !$v['del']) {
				$typeid = $this->type_db->insert(array('siteid'=>$siteid, 'module'=>'special', 'name'=>$v['name'], 'listorder'=>$v['listorder'], 'typedir'=>$v['typedir'], 'parentid'=>$specialid, 'listorder'=>$k), true);
				if ($siteid>1) {
					$site = pc_base::load_app_class('sites', 'admin');
					$site_info = $site->get_by_id($siteid);
					if ($special_info['ishtml']) {
						$url = $site_info['domain'].'special/'.$special_info['filename'].'/'.$v['typedir'].'/'.'type-'.$typeid.'.html';
					} else {
						$url = $site_info['domain'].'index.php?m=special&c=index&a=type&specialid='.$specialid.'&typeid='.$typeid;
					}
				} else {
					if($special_info['ishtml']) $url = addslashes($app_path.pc_base::load_config('system', 'html_root').'/special/'.$special_info['filename'].'/'.$v['typedir'].'/'.'type-'.$typeid.'.html');
					else $url = APP_PATH.'index.php?m=special&c=index&a=type&specialid='.$specialid.'&typeid='.$typeid;
				}
				$this->type_db->update(array('url'=>$url), array('typeid'=>$typeid));
			} elseif ($a == 'edit') {
				if ((!isset($v['typeid']) || empty($v['typeid'])) && (!isset($v['del']) || empty($v['del']))) {
					$typeid = $this->type_db->insert(array('siteid'=>$siteid, 'module'=>'special', 'name'=>$v['name'], 'listorder'=>$v['listorder'], 'typedir'=>$v['typedir'], 'parentid'=>$specialid, 'listorder'=>$k), true);
					if ($siteid>1) {
						$site = pc_base::load_app_class('sites', 'admin');
						$site_info = $site->get_by_id($siteid);
						if ($special_info['ishtml']) {
							$url = $site_info['domain'].'special/'.$special_info['filename'].'/'.$v['typedir'].'/'.'type-'.$typeid.'.html';
						} else {
							$url = $site_info['domain'].'index.php?m=special&c=index&a=type&specialid='.$specialid.'&typeid='.$typeid;
						}
					} else {
						if($special_info['ishtml']) $url = addslashes($app_path.pc_base::load_config('system', 'html_root').'/special/'.$special_info['filename'].'/'.$v['typedir'].'/'.'type-'.$typeid.'.html');
						else $url = APP_PATH.'index.php?m=special&c=index&a=type&specialid='.$specialid.'&typeid='.$typeid;
					}
					$v['url'] = $url;
					$this->type_db->update($v, array('typeid'=>$typeid));
				} 
				if ((!isset($v['del']) || empty($v['del'])) && $v['typeid']) {
					$this->type_db->update(array('name'=>$v['name'], 'typedir'=>$v['typedir'], 'listorder'=>$v['listorder']), array('typeid'=>$r['typeid']));
					if ($siteid>1) {
						$site = pc_base::load_app_class('sites', 'admin');
						$site_info = $site->get_by_id($siteid);
						if ($special_info['ishtml']) {
							$url = $site_info['domain'].'special/'.$special_info['filename'].'/'.$v['typedir'].'/'.'type-'.$v['typeid'].'.html';
						} else {
							$url = $site_info['domain'].'index.php?m=special&c=index&a=type&specialid='.$specialid.'&typeid='.$v['typeid'];
						}
					} else {
						if($special_info['ishtml']) $url = addslashes($app_path.pc_base::load_config('system', 'html_root').'/special/'.$special_info['filename'].'/'.$v['typedir'].'/'.'type-'.$v['typeid'].'.html');
						else $url = APP_PATH.'index.php?m=special&c=index&a=type&specialid='.$specialid.'&typeid='.$v['typeid'];
					}
					$v['url'] = $url;
					$typeid = $v['typeid'];
					unset($v['typeid']);
					$this->type_db->update($v, array('typeid'=>$typeid));
				} 
				if ($v['typeid'] && $v['del']) {
					$this->delete_type($v['typeid'], $siteid, $special_info['ishtml']);
				}
			}
		}
		return true;
	}
	
	/**
	 * 調取內容信息
	 * @param intval $modelid 模型ID
	 * @param string $where sql語句
	 * @param intval $page 分頁
	 * @return array 返回調取的數據 
	 */
	public function _get_import_data($modelid = 0, $where = '', $page) {
		$c = pc_base::load_model('content_model');
		if(!$modelid) return '';
		$c->set_model($modelid);
		$data = $c->listinfo($where, '`id`  DESC', $page);
		$this->pages = $c->pages;
		return $data;
	}
	
	/**
	 * 信息推薦至專題接口
	 * @param array $param 屬性 請求時，為模型、欄目數組。 例：array('modelid'=>1, 'catid'=>12); 提交添加為二維信息數據 。例：array(1=>array('title'=>'多發發送方法', ....))
	 * @param array $arr 參數 表單數據，只在請求添加時傳遞。
	 * @return 返回專題的下拉列表 
	 */
	public function _get_special($param = array(), $arr = array()) {
		if ($arr['dosubmit']) {
			foreach ($param as $id => $v) {
				if (!$arr['specialid'] || !$arr['typeid']) continue;
				if (!$this->c_db->get_one(array('title'=>$v['title'], 'specialid'=>$arr['specialid']))) {
					$info['specialid'] = $arr['specialid'];
					$info['typeid'] = $arr['typeid'];
					$info['title'] = $v['title'];
					$info['thumb'] = $v['thumb'];
					$info['url'] = $v['url'];
					$info['curl'] = $v['id'].'|'.$v['catid'];
					$info['description'] = $v['description'];
					$info['userid'] = $v['userid'];
					$info['username'] = $v['username'];
					$info['inputtime'] = $v['inputtime'];
					$info['updatetime'] = $v['updatetime'];
					$info['islink'] = 1;
					$this->c_db->insert($info, true);
				}
			}
			return true;
		} else {
			$datas = getcache('special', 'commons');
			$special = array(L('please_select'));
			if (is_array($datas)) {
				foreach ($datas as $sid => $d) {
					if ($d['siteid']==get_siteid()) {
						$special[$sid] = $d['title'];
					}
				}
			}
			return array(
				'specialid' => array('name'=>L('special_list','','special'), 'htmltype'=>'select', 'data'=>$special, 'ajax'=>array('name'=>L('for_type','','special'), 'action'=>'_get_type', 'm'=>'special', 'id'=>'typeid')),
				'validator' => '$(\'#specialid\').formValidator({autotip:true,onshow:"'.L('please_choose_special','','special').'",oncorrect:"'.L('true', '', 'special').'"}).inputValidator({min:1,onerror:"'.L('please_choose_special','','special').'"});$(\'#typeid\').formValidator({autotip:true,onshow:"'.L('please_choose_type', '', 'special').'",oncorrect:"'.L('true', '', 'special').'"}).inputValidator({min:1,onerror:"'.L('please_choose_type', '', 'special').'"});',
			);
		}
	}
	
	/**
	 * 獲取分類
	 * @param intval $specialid 專題ID
	 */
	public function _get_type($specialid = 0) {
		$type_db = pc_base::load_model('type_model');
		$data = $arr = array();
		$data = $type_db->select(array('module'=>'special', 'parentid'=>$specialid));
		pc_base::load_sys_class('form', '', 0);
		foreach ($data as $r) {
			$arr[$r['typeid']] = $r['name'];
		}
		return form::select($arr, '', 'name="typeid", id="typeid"', L('please_select'));
	}
	
	/**
	 * 調取專題的附屬分類
	 * @param intval $specialid 專題ID
	 * @return array 專題的附屬分類
	 */
	public function _get_types($specialid = 0) {
		if (!$specialid) return false;
		$rs = $this->type_db->select(array('parentid'=>$specialid, 'siteid'=>get_siteid()), 'typeid, name');
		$types = array();
		foreach ($rs as $r) {
			$types[$r['typeid']] = $r['name'];
		}
		return $types;
	}

	/**
	 * 刪除專題 執行刪除操作的方法，同時刪除專題下的分類、信息、及生成靜態文件和圖片
	 * @param intval $id 專題ID
	 * @return boolen 
	 */
	public function _del_special($id = 0) {
		$id = intval($id);
		if (!$id) return false;
		
		//檢查專題下是否有信息
		$rs = $this->c_db->select(array('specialid'=>$id), 'id');

		$info = $this->db->get_one(array('id'=>$id, 'siteid'=>get_siteid()), 'siteid, ispage, filename, ishtml');
		
		//有信息時，循環刪除
		if (is_array($rs) && !empty($rs)) {
			foreach ($rs as $r) {
				$this->_delete_content($r['id'], $info['siteid'], $info['ishtml']);
			}
		}

		//刪除專題的附屬分類
		$type_info = $this->type_db->select(array('module'=>'special', 'parentid'=>$id, 'siteid'=>get_siteid()), '`typeid`');
		if (is_array($type_info) && !empty($type_info)) {
			foreach ($type_info as $t) {
				$this->delete_type($t['typeid'], $info['siteid'], $info['ishtml']);
			}
		}
		pc_base::load_sys_func('dir');
		$this->db->delete(array('id'=>$id, 'siteid'=>get_siteid()));
		if ($info['siteid']>1) {
			if ($info['ishtml']) {
				$queue = pc_base::load_model('queue_model');
				$site = pc_base::load_app_class('sites', 'admin');
				$site_info = $site->get_by_id($info['siteid']);
				$file = pc_base::load_config('system', 'html_root').'/'.$site_info['dirname'].'/special/'.$info['filename'].'/index.html';
				if ($info['ispage']) {
					for ($i==1; $i>0; $i++) {
						if ($i>1) {
							$file = str_replace('.html', '-'.$i.'.html', $file);
						}
						if (!file_exists(PHPCMS_PATH.$file)) {
							break;
						} else {
							$queue->add_queue('del', $file, $info['siteid']);
							unlink(PHPCMS_PATH.$file);
						}
					}
				} else {
					$queue->add_queue('del', $file, $info['siteid']);
					unlink(PHPCMS_PATH.$file);
				}
				$queue->add_queue('del', pc_base::load_config('system', 'html_root').'/'.$site_info['dirname'].'/special/'.$info['filename'].'/', $info['siteid']);
				dir_delete(pc_base::load_config('system', 'html_root').'/'.$site_info['dirname'].'/special/'.$info['filename']);
			}
		} else {
			if ($info['ishtml']) {
				dir_delete(PHPCMS_PATH.pc_base::load_config('system', 'html_root').DIRECTORY_SEPARATOR.'special'.DIRECTORY_SEPARATOR.$info['filename']); //刪除專題目錄
			}
		}
		if(pc_base::load_config('system','attachment_stat')) {
			$keyid = 'special-'.$id;
			$this->attachment_db = pc_base::load_model('attachment_model');
			$this->attachment_db->api_delete($keyid);
		}
		return true;
	}
	
	/**
	 * 導入的數據添加到數據表
	 * @param intval $modelid	 模型ID
	 * @param intval $specialid	 信息的所屬專題ID
	 * @param intval $id 		 信息的ID
	 * @param intval $typeid 	 信息的分類ID
	 * @param intval $listorder	 信息的排序
	 */
	public function _import($modelid, $specialid, $id, $typeid, $listorder = 0) {
		if (!$specialid || !$id || !$typeid) return false;
		$c = pc_base::load_model('content_model');
		$c->set_model($modelid);
		$info = $c->get_one(array('id'=>$id, 'status'=>99), '`id`, `catid`, `title`, `thumb`, `url`, `description`, `username`, `inputtime`, `updatetime`');
		if ($info) {
			$info['curl'] = $info['id'].'|'.$info['catid'];
			unset($info['id'], $info['catid']);
			if(!$this->c_db->get_one(array('title'=>addslashes($info['title']), 'specialid'=>$specialid, 'typeid'=>$typeid))) {
				$info['specialid'] = $specialid;
				$info['typeid'] = $typeid;
				$info['islink'] = 1;
				$info['listorder'] = $listorder;
				$info = new_addslashes($info);
				return $this->c_db->insert($info, true);
			}
		}
		return false;
	}
	
	/**
	 * 刪除專題分類
	 * @param intval $typeid 專題附屬分類ID
	 * @param intval $siteid 站點ID
	 * @param intval $ishtml 專題是否生成靜態
	 */
	private function delete_type($typeid = 0, $siteid = 0, $ishtml = 0) {
		$typeid = intval($typeid);
		if (!$typeid) return false;
		
		pc_base::load_sys_func('dir');
		$info = $this->type_db->get_one(array('typeid'=>$typeid));
		if ($ishtml) {
			$siteid = $siteid ? intval($siteid) : get_siteid();
			if ($siteid>1) {
				$site = pc_base::load_app_class('sites', 'admin');
				$site_info = $site->get_by_id($siteid);
				$queue = pc_base::load_model('queue_model');
				for ($i = 1; $i>0; $i++) {
					if ($i==1) $file = str_replace($site_info['domain'], pc_base::load_config('system', 'html_root').'/'.$site_info['dirname'].'/', $info['url']);
					else $file = str_replace(array($site_info['domain'], '.html'), array(pc_base::load_config('system', 'html_root').'/'.$site_info['dirname'].'/', '-'.$i.'.html'), $info['url']);
					if (!file_exists(PHPCMS_PATH.$file)) {
						break;
					} else {
						$queue->add_queue('del', $file, $siteid); //並加入到消息隊列中，便以其他站點刪除文件
						unlink(PHPCMS_PATH.$file);	//刪除生成的靜態文件
					}
				}
			} else {
				for ($i = 1; $i>0; $i++) {
					if ($i==1) $file = str_replace(APP_PATH, '', $info['url']);
					else $file = str_replace(array(APP_PATH, '.html'), array('', '-'.$i.'.html'), $info['url']);
					if (!file_exists(PHPCMS_PATH.$file)) {
						break;
					} else {
						unlink(PHPCMS_PATH.$file);	//刪除生成的靜態文件
					}
				}
			}
		}
		$this->type_db->delete(array('typeid'=>$typeid)); //刪除數據表記錄
		return true;
	}
	
	/**
	 * 刪除專題信息，同時刪除專題的信息，及相關的靜態文件、圖片
	 * @param intval $cid 專題信息ID
	 * @param intval $siteid 所屬站點
	 * @param intval $ishtml 專題是否生成靜態
	 */
	public function _delete_content($cid = 0, $siteid = 0, $ishtml = 0) {
		$info = $this->c_db->get_one(array('id'=>$cid), 'inputtime, isdata');

		if ($info['isdata']) {
			if ($ishtml) {	
				pc_base::load_app_func('global', 'special');
				$siteid = $siteid ? intval($siteid) : get_siteid();
				if ($siteid>1) {
					$site = pc_base::load_app_class('sites', 'admin');
					$site_info = $site->get_by_id($siteid);
					$queue = pc_base::load_model('queue_model');
					
					for ($i = 1; $i>0; $i++) {
						$file = content_url($cid, $i, $info['inputtime'], 'html', $site_info);
						if (!file_exists(PHPCMS_PATH.$file[1])) {
							break;
						} else {
							$queue->add_queue('del', $file[1], $siteid); //並加入到消息隊列中，便以其他站點刪除文件
							unlink(PHPCMS_PATH.$file[1]);	//刪除生成的靜態文件
						}
					}
				} else {
					for ($i = 1; $i>0; $i++) {
						$file = content_url($cid, $i, $info['inputtime']);
						if (!file_exists(PHPCMS_PATH.$file[1])) {
							break;
						} else {
							unlink(PHPCMS_PATH.$file[1]);	//刪除生成的靜態文件
						}
					}
				}
			}
			
			//刪除全站搜索數據
			$this->search_api($cid, '', '', 'delete');
			
			// 刪除數據統計表數據
			$count = pc_base::load_model('hits_model');
			$hitsid = 'special-c-'.$info['specialid'].'-'.$cid;
			$count->delete(array('hitsid'=>$hitsid));
			
			//刪除信息內容表中的數據
			$this->data_db->delete(array('id'=>$cid));
		}
		$this->c_db->delete(array('id'=>$cid)); //刪除信息表中的數據
		return true;
	}
	
	/**
	 * Function importfalbum
	 * 將專輯載入到專題
	 * @param array $info 專輯詳細信息
	 */
	public function importfalbum($info = array()) {
		static $siteid,$sitelists;
		if (!$siteid) $siteid = get_siteid();
		if (!$sitelists) $sitelists = getcache('sitelist', 'commons');
		pc_base::load_sys_func('iconv');
		if (is_array($info)) {
			$username = param::get_cookie('admin_username');
			$userid = param::get_cookie('userid');
			$arr = array(
						'siteid' => $siteid,
						'aid' => $info['id'],
						'title' => $info['title'],
						'thumb' => format_url($info['coverurl']),
						'banner' => format_url($info['coverurl']),
						'description' => $info['desc'],
						'ishtml' => 0,
						'ispage' => 0,
						'style' => 'default',
						'index_template' => 'index_video',
						'list_template' => 'list_video',
						'show_template' => 'show_video',
						'username' => $username,
						'userid' =>$userid,
						'createtime' => SYS_TIME,
						'isvideo' => 1,
					);
			//將數據插入到專題表中
			$arr = new_html_special_chars($arr);
			$specialid = $this->db->insert($arr, true);
			$url = $sitelists[$siteid]['domain'].'index.php?m=special&c=index&id='.$specialid;
			$this->db->update(array('url'=>$url), array('id'=>$specialid));
			//組合子分類數組
			$letters = gbk_to_pinyin($info['title']);
			$type_info = array(
							'siteid' => $siteid,
							'module' => 'special',
							'modelid' => 0,
							'name' => new_html_special_chars($info['title']),
							'parentid' => $specialid,
							'typedir' => strtolower(implode('', $letters)),
							'listorder' => 1,
							);
			$typeid = $this->type_db->insert($type_info, true);
			$url = $sitelists[$siteid]['domain'].'index.php?m=special&c=index&a=type&specialid='.$specialid.'&typeid='.$typeid;
			$this->type_db->update(array('url'=>$url), array('typeid'=>$typeid));
			return $specialid;
		} else {
			return false;
		}
	}
	
	/**
	 * 添加到全站搜索
	 * @param intval $id 文章ID
	 * @param array $data 數組
	 * @param string $title 標題
	 * @param string $action 動作
	 */
	private function search_api($id = 0, $data = array(), $title, $action = 'update') {
		$this->search_db = pc_base::load_model('search_model');
		$siteid = get_siteid();
		$type_arr = getcache('type_module_'.$siteid,'search');
		$typeid = $type_arr['special'];
		if($action == 'update') {
			$fulltextcontent = $data['content'];
			return $this->search_db->update_search($typeid ,$id, $fulltextcontent,$title);
		} elseif($action == 'delete') {
			$this->search_db->delete_search($typeid ,$id);
		}
	}
}
?>