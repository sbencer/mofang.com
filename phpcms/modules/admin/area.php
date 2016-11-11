<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class area extends admin {
	private $db;
	public $siteid;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('area_model');
		$this->siteid = $this->get_siteid();
	}
	/**
	 * 管理專區
	 */
	public function init () {
		$show_header = '';
		if(isset($_GET['productid']) && $_GET['productid']) {
			$productid = intval($_GET['productid']);
			$show_pc_hash = '';
			$tree = pc_base::load_sys_class('tree');
			$area_menus = get_area_menus();
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$areas = array();
			//讀取緩存
			$result = getcache('product_areas_'.$productid,'commons');
			$parentid = $_GET['parentid'] ? intval($_GET['parentid']) : 0;
			$html_root = pc_base::load_config('system','html_root');
			if(!empty($result)) {
				foreach($result as $r) {
					$r['str_manage'] = '';
					$r['str_manage'] .= '<a href="?m=admin&c=area&a=add&productid='.$r['productid'].'&parentid='.$r['id'].'&catid='.$r['catid'].'&pc_hash='.$_SESSION['pc_hash'].'">'.L('add_sub_area').'</a> | ';

					$r['str_manage'] .= '<a href="?m=admin&c=area&a=edit&areaid='.$r['id'].'&pc_hash='.$_SESSION['pc_hash'].'">'.L('edit').'</a> | <a href="javascript:confirmurl(\'?m=admin&c=area&a=delete&areaid='.$r['id'].'\',\''.L('confirm',array('message'=>addslashes($r['name']))).'\')">'.L('delete').'</a>';
					$r['catname'] = $area_menus[$r['catid']]['catname'];
					$r['help'] = '';
					$setting = string2array($r['setting']);
					$areas[$r['id']] = $r;
				}
				if($r['url']) {
					if(preg_match('/^(http|https):\/\//', $r['url'])) {
						$catdir = $r['catdir'];
						$prefix = $r['sethtml'] ? '' : $html_root;
						if($this->siteid==1) {
							$catdir = $prefix.'/'.$r['parentdir'].$catdir;
						} else {
							$catdir = $prefix.'/'.$sitelist[$this->siteid]['dirname'].$html_root.'/'.$catdir;
						}
						if($r['type']==0 && $setting['ishtml'] && strpos($r['url'], '?')===false && substr_count($r['url'],'/')<4) $r['help'] = '<img src="'.IMG_PATH.'icon/help.png" title="'.L('tips_domain').$r['url'].'&#10;'.L('directory_binding').'&#10;'.$catdir.'/">';
					} else {
						$r['url'] = substr($sitelist[$this->siteid]['domain'],0,-1).$r['url'];
					}
					$r['url'] = "<a href='$r[url]' target='_blank'>".L('vistor')."</a>";
				} else {
					$r['url'] = "<a href='?m=admin&c=category&a=public_cache&menuid=43&module=admin'><font color='red'>".L('update_backup')."</font></a>";
				}
			}
			$str  = "<tr>
						<td align='center'>\$id</td>
						<td >\$spacer\$name</td>
						<td align='center'>\$catname</td>
						<td align='center'>\$items</td>
						<td align='center'>\$url</td>
						<td align='center' >\$str_manage</td>
					</tr>";
			$tree->init($areas);
			$areas = $tree->get_tree(0, $str);
			include $this->admin_tpl('area_manage');
		} else {
			include $this->admin_tpl('area_quick');
		}
	}
	/**
	 * 添加專區
	 */
	public function add() {
		if(isset($_POST['dosubmit'])) {
			pc_base::load_sys_func('iconv');

			$_POST['batch_add'] = trim($_POST['batch_add']);
			if (!isset($_POST['batch_add']) || empty($_POST['batch_add'])) {
				if ($_POST['info']['name']=='') showmessage(L('input_catname'));
				$_POST['info']['name'] = safe_replace($_POST['info']['name']);
				if ($_POST['info']['catid']=='0') showmessage(L('please_select_catid'));
			}
			$_POST['info']['setting'] = array2string($_POST['setting']);

			$end_str = $old_end =  '<script type="text/javascript">window.top.art.dialog({id:"test"}).close();window.top.art.dialog({id:"test",content:\'<h2>'.L("add_success").'</h2><span style="fotn-size:16px;">'.L("following_operation").'</span><br /><ul style="fotn-size:14px;"><li><a href="?m=admin&c=area&a=public_cache&menuid=43&module=admin" target="right"  onclick="window.top.art.dialog({id:\\\'test\\\'}).close()">'.L("following_operation_1").'</a></li><li><a href="'.HTTP_REFERER.'" target="right" onclick="window.top.art.dialog({id:\\\'test\\\'}).close()">'.L("following_operation_2").'</a></li></ul>\',width:"400",height:"200"});</script>';
			if(!isset($_POST['batch_add']) || empty($_POST['batch_add'])) {
				$letters = gbk_to_pinyin($_POST['info']['name']);
				$_POST['info']['letter'] = strtolower(implode('', $letters));
				if($this->db->count(array('name'=>$_POST['info']['name'], 'productid'=>$_POST['info']['productid']))) {
					showmessage(L('follow_catname_have_exists').$_POST['info']['name']);
				}
				$catid = $this->db->insert($_POST['info'], true);
			} else {//批量添加
				$end_str = '';
				$batch_adds = explode("\n", $_POST['batch_add']);
				foreach ($batch_adds as $_v) {
					if(trim($_v)=='') continue;
					$names = explode('|', $_v);
					$catname = $names[0];
					$_POST['info']['name'] = trim($names[0]);
					$letters = gbk_to_pinyin($_POST['info']['name']);
					$_POST['info']['letter'] = strtolower(implode('', $letters));
					if($this->db->count(array('name'=>$_POST['info']['name'], 'productid'=>$_POST['info']['productid']))) {
						$end_str .= $end_str ? ',' : '';
						$end_str .= $_POST['info']['name'];
						continue;
					}
					$catid = $this->db->insert($_POST['info'], true);
				}
				$end_str = $end_str ? L('follow_catname_have_exists').$end_str : $old_end;
			}
			$this->cache();
			showmessage(L('add_success').$end_str);
		} else {
			//獲取站點模板信息
			pc_base::load_app_func('global');

			if (!isset($_GET['productid'])) {
				showmessage(L('parameters_error'));
			}
			$template_list = template_list($this->siteid, 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}
			$show_validator = '';
			if(isset($_GET['parentid'])) {
				$parentid = $_GET['parentid'];
				$r = $this->db->get_one(array('id'=>$parentid));
				if($r) extract($r,EXTR_SKIP);
				$setting = string2array($setting);
			}
			$productid = $_GET['productid'];
			$productname = $this->db->get_product_name($productid);
			$area_menus = get_area_menus();
			pc_base::load_sys_class('form','',0);
			include $this->admin_tpl('area_add');
		}
	}
	/**
	 * 修改專區
	 */
	public function edit() {

		if(isset($_POST['dosubmit'])) {
			pc_base::load_sys_func('iconv');
			$tid = 0;
			$id = intval($_POST['id']);
			$setting = $_POST['setting'];
			$_POST['info']['name'] = safe_replace($_POST['info']['name']);
			$letters = gbk_to_pinyin($_POST['info']['name']);
			$_POST['info']['letter'] = strtolower(implode('', $letters));

			//應用模板到所有子專區
			if($_POST['template_child']){
				$arr = $this->db->select(array('parentid'=>$id), 'id, setting');
				if(!empty($arr)){
					foreach ($arr as $v){
						$v['setting']['list_template'] = $_POST['setting']['list_template'];
						$v['setting']['show_template'] = $_POST['setting']['show_template'];
						$new_setting = array2string($v['setting']);
						$this->db->update(array('setting'=>$new_setting), array('id'=>$v['id']) );
					}
				}
			}

			$_POST['info']['setting'] = array2string($_POST['setting']);
			$this->db->update($_POST['info'],array('id'=>$id));
			$this->cache();
			//更新附件狀態
			if($_POST['info']['image'] && pc_base::load_config('system','attachment_stat')) {
				$this->attachment_db = pc_base::load_model('attachment_model');
				$this->attachment_db->api_update($_POST['info']['image'],'catid-'.$catid,1);
			}
			showmessage(L('operation_success').'<script type="text/javascript">window.top.art.dialog({id:"test"}).close();window.top.art.dialog({id:"test",content:\'<h2>'.L("operation_success").'</h2><span style="fotn-size:16px;">'.L("edit_following_operation").'</span><br /><ul style="fotn-size:14px;"><li><a href="?m=admin&c=area&a=public_cache&menuid=43&module=admin" target="right"  onclick="window.top.art.dialog({id:\\\'test\\\'}).close()">'.L("following_operation_1").'</a></li></ul>\',width:"400",height:"200"});</script>','?m=admin&c=area&a=init&module=admin&menuid=43');
		} else {
			//獲取站點模板信息
			if (!isset($_GET['areaid'])) {
				showmessage(L('parameters_error'));
			}
			pc_base::load_app_func('global');
			$template_list = template_list($this->siteid, 0);
			foreach ($template_list as $k=>$v) {
				$template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
				unset($template_list[$k]);
			}


			$show_validator = $catid = $r = '';
			$areaid = intval($_GET['areaid']);
			pc_base::load_sys_class('form','',0);
			$r = $this->db->get_one(array('id'=>$areaid));
			if($r) extract($r);
			$productname = $this->db->get_product_name($productid);
			$area_menus = get_area_menus();
			$setting = string2array($setting);
			include $this->admin_tpl('area_edit');
		}
	}
	/**
	 * 刪除專區
	 */
	public function delete() {
		$id = intval($_GET['areaid']);
		$areas = getcache('area_content_'.$this->siteid,'commons');
		$items = getcache('area_items_'.$modelid,'commons');
		//if($items[$catid]) showmessage(L('area_does_not_allow_delete'));
		$this->delete_child($id, $modelid);
		$this->db->delete(array('id'=>$id));
		$this->cache();
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	/**
	 * 遞歸刪除專區
	 * @param $catid 要刪除的專區id
	 */
	private function delete_child($id) {
		$id = intval($id);
		if (empty($id)) return false;
		$childs = $this->db->select(array('parentid'=>$id));
		if ($childs) {
			foreach ($childs as $child) {
				$this->delete_child($child['id']);
			}
		}
		$this->db->delete(array('parentid'=>$id));
		return true;
	}
	/**
	 * 更新緩存
	 */
	public function cache() {
		$this->db->cache();
	}
	/**
	 * 更新緩存並修復專區
	 */
	public function public_cache() {
		//$this->repair();
		$this->db->cache();
		showmessage(L('operation_success'),'?m=admin&c=area&a=init&module=admin&menuid=43');
	}

	/**
	 * 找出子目錄列表
	 * @param array $areas
	 */
	private function get_areas($areas = array()) {
		if (is_array($areas) && !empty($areas)) {
			foreach ($areas as $catid => $c) {
				$this->areas[$catid] = $c;
				$result = array();
				foreach ($this->areas as $_k=>$_v) {
					if($_v['parentid']) $result[] = $_v;
				}
				$this->get_areas($r);
			}
		}
		return true;
	}

	/**
	 *
	 * 獲取父專區ID列表
	 * @param integer $catid              專區ID
	 * @param array $arrparentid          父目錄ID
	 * @param integer $n                  查找的層次
	 */
	private function get_arrparentid($catid, $arrparentid = '', $n = 1) {
		if($n > 5 || !is_array($this->areas) || !isset($this->areas[$catid])) return false;
		$parentid = $this->areas[$catid]['parentid'];
		$arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
		if($parentid) {
			$arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
		} else {
			$this->areas[$catid]['arrparentid'] = $arrparentid;
		}
		$parentid = $this->areas[$catid]['parentid'];
		return $arrparentid;
	}

	/**
	 *
	 * 獲取子專區ID列表
	 * @param $catid 專區ID
	 */
	private function get_arrchildid($catid) {
		$arrchildid = $catid;
		if(is_array($this->areas)) {
			foreach($this->areas as $id => $cat) {
				if($cat['parentid'] && $id != $catid && $cat['parentid']==$catid) {
					$arrchildid .= ','.$this->get_arrchildid($id);
				}
			}
		}
		return $arrchildid;
	}
	/**
	 * 獲取父專區路徑
	 * @param  $catid
	 */
	function get_parentdir($catid) {
		if($this->areas[$catid]['parentid']==0) return '';
		$r = $this->areas[$catid];
		$setting = string2array($r['setting']);
		$url = $r['url'];
		$arrparentid = $r['arrparentid'];
		unset($r);
		if (strpos($url, '://')===false) {
			if ($setting['creat_to_html_root']) {
				return '';
			} else {
				$arrparentid = explode(',', $arrparentid);
				$arrcatdir = array();
				foreach($arrparentid as $id) {
					if($id==0) continue;
					$arrcatdir[] = $this->areas[$id]['catdir'];
				}
				return implode('/', $arrcatdir).'/';
			}
		} else {
			if ($setting['create_to_html_root']) {
				if (preg_match('/^((http|https):\/\/)?([^\/]+)/i', $url, $matches)) {
					$url = $matches[0].'/';
					$rs = $this->db->get_one(array('url'=>$url), '`parentdir`,`catid`');
					if ($catid == $rs['catid']) return '';
					else return $rs['parentdir'];
				} else {
					return '';
				}
			} else {
				$arrparentid = explode(',', $arrparentid);
				$arrcatdir = array();
				krsort($arrparentid);
				foreach ($arrparentid as $id) {
					if ($id==0) continue;
					$arrcatdir[] = $this->areas[$id]['catdir'];
					if ($this->areas[$id]['parentdir'] == '') break;
				}
				krsort($arrcatdir);
				return implode('/', $arrcatdir).'/';
			}
		}
	}
	/**
	 * 檢查目錄是否存在
	 * @param  $return_method 返回方法
	 * @param  $catdir 目錄
	 */
	public function public_check_catdir($return_method = 1,$catdir = '') {
		$old_dir = '';
		$catdir = $catdir ? $catdir : $_GET['catdir'];
		$parentid = intval($_GET['parentid']);
		$old_dir = $_GET['old_dir'];
		$r = $this->db->get_one(array('siteid'=>$this->siteid,'module'=>'content','catdir'=>$catdir,'parentid'=>$parentid));
		if($r && $old_dir != $r['catdir']) {
			//目錄存在
			if($return_method) {
				exit('0');
			} else {
				return false;
			}
		} else {
			if($return_method) {
				exit('1');
			} else {
				return true;
			}
		}
	}

	/**
	 * 重新統計專區信息數量
	 */
	public function count_items() {
		$this->content_db = pc_base::load_model('content_model');
		$result = getcache('area_content_'.$this->siteid,'commons');
		foreach($result as $r) {
			if($r['type'] == 0) {
				$modelid = $r['modelid'];
				$this->content_db->set_model($modelid);
				$number = $this->content_db->count(array('catid'=>$r['catid']));
				$this->db->update(array('items'=>$number),array('catid'=>$r['catid']));
			}
		}
		showmessage(L('operation_success'),HTTP_REFERER);
	}
	/**
	 * json方式加載模板
	 */
	public function public_tpl_file_list() {
		$style = isset($_GET['style']) && trim($_GET['style']) ? trim($_GET['style']) : exit(0);
		$catid = isset($_GET['catid']) && intval($_GET['catid']) ? intval($_GET['catid']) : 0;
		$batch_str = isset($_GET['batch_str']) ? '['.$catid.']' : '';
		if ($catid) {
			$cat = getcache('area_content_'.$this->siteid,'commons');
			$cat = $cat[$catid];
			$cat['setting'] = string2array($cat['setting']);
		}
		pc_base::load_sys_class('form','',0);
		if($_GET['type']==1) {
			$html = array('page_template'=>form::select_template($style, 'content',(isset($cat['setting']['page_template']) && !empty($cat['setting']['page_template']) ? $cat['setting']['page_template'] : 'area'),'name="setting'.$batch_str.'[page_template]"','page'));
		} else {
			$html = array('area_template'=> form::select_template($style, 'content',(isset($cat['setting']['area_template']) && !empty($cat['setting']['area_template']) ? $cat['setting']['area_template'] : 'area'),'name="setting'.$batch_str.'[area_template]"','area'),
				'list_template'=>form::select_template($style, 'content',(isset($cat['setting']['list_template']) && !empty($cat['setting']['list_template']) ? $cat['setting']['list_template'] : 'list'),'name="setting'.$batch_str.'[list_template]"','list'),
				'show_template'=>form::select_template($style, 'content',(isset($cat['setting']['show_template']) && !empty($cat['setting']['show_template']) ? $cat['setting']['show_template'] : 'show'),'name="setting'.$batch_str.'[show_template]"','show')
			);
		}
		if ($_GET['module']) {
			unset($html);
			if ($_GET['templates']) {
				$templates = explode('|', $_GET['templates']);
				if ($_GET['id']) $id = explode('|', $_GET['id']);
				if (is_array($templates)) {
					foreach ($templates as $k => $tem) {
						$t = $tem.'_template';
						if ($id[$k]=='') $id[$k] = $tem;
						$html[$t] = form::select_template($style, $_GET['module'], $id[$k], 'name="'.$_GET['name'].'['.$t.']" id="'.$t.'"', $tem);
					}
				}
			}

		}
		if (CHARSET == 'gbk') {
			$html = array_iconv($html, 'gbk', 'utf-8');
		}
		echo json_encode($html);
	}

	/**
	 * 快速進入搜索
	 */
	public function public_ajax_search() {
		$name = trim($_GET['name']);
		$result = $this->db->search($name);
		if (CHARSET == 'gbk') {
			$result = array_iconv($result, 'gbk', 'utf-8');
		}
		echo json_encode($result);
	}
	/**
	 * 查詢專區欄目所對應的主站欄目ID
	 */
	public function public_get_catid() {
		if (isset($_GET['areaid'])) {
			$areaid = intval($_GET['areaid']);
		} else {
			return false;
		}
		$result = $this->db->get_one(array('id'=>$areaid),'catid');
		echo json_encode($result);
	}
	/**
	 * json方式讀取風格列表，推送部分調用
	 */
	public function public_change_tpl() {
		pc_base::load_sys_class('form','',0);
		$models = getcache('model','commons');
		$modelid = intval($_GET['modelid']);
		if($_GET['modelid']) {
			$style = $models[$modelid]['default_style'];
			$area_template = $models[$modelid]['area_template'];
			$list_template = $models[$modelid]['list_template'];
			$show_template = $models[$modelid]['show_template'];
			$html = array(
				'template_list'=> $style,
				'area_template'=> form::select_template($style, 'content',$area_template,'name="setting[area_template]"','area'),
				'list_template'=>form::select_template($style, 'content',$list_template,'name="setting[list_template]"','list'),
				'show_template'=>form::select_template($style, 'content',$show_template,'name="setting[show_template]"','show')
			);
			if (CHARSET == 'gbk') {
				$html = array_iconv($html, 'gbk', 'utf-8');
			}
			echo json_encode($html);
		}
	}
	/**
	 * 顯示專區菜單列表
	 */
	public function area_tree() {
		$tree_items = array();
		$tree_items[100001] = array('id'=>'100001', 'name'=>L('area_level_1'), 'child'=>'1');
		$tree_items[100002] = array('id'=>'100002', 'name'=>L('area_level_2'), 'child'=>'2');
		$tree_items[100003] = array('id'=>'100003', 'name'=>L('area_level_3'), 'child'=>'3');

		$show_header = '';
		$cfg = getcache('common','commons');
		$from = isset($_GET['from']) && in_array($_GET['from'],array('block')) ? $_GET['from'] : 'content';
		$tree = pc_base::load_sys_class('tree');
		$areas = $this->areas = getcache('area_content', 'commons');
		$products = getcache('product_content', 'commons');
		foreach ($products as $productid => $product) {
			$product['child'] = 1;
			$product['name'] = $product['title'];
			$product['id'] = 110000 + $product['id'];
			$product['parentid'] = 100000 + $product['area_level'];
			$tree_items[$productid + 110000] = $product;
		}
		foreach ($areas as $areaid => $area) {
			if ($area['parentid'] == 0) {
				$area['parentid'] = 110000 + $area['productid'];
			}
			$area['icon_type'] = $area['vs_show'] = '';
			$area['type'] = 'init';
			$area['add_icon'] = "<a target='right' href='?m=content&c=content&a=add&areaid=".$areaid."' onclick=javascript:openwinx('?m=content&c=content&a=add&areaid=".$areaid."&hash_page=".$_SESSION['hash_page']."','')><img src='".IMG_PATH."add_content.gif' alt='".L('add')."'></a> ";
			$tree_items[$areaid] = $area;
		}
		if(!empty($tree_items)) {
			$tree->init($tree_items);
			$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=admin&c=area&a=list&areaid=\$id' target='right' onclick='open_list(this)'>\$name</a></span>";
			$strs2 = "<span class='folder'>\$name</span>";
			$areas = $tree->get_treeview(0,'category_tree',$strs,$strs2);
		} else {
			$areas = L('please_add_category');
		}
        include $this->admin_tpl('area_tree');
	}

	/**
	 * 顯示專區列表
	 */
	public function product_tree() {
		$tree_items = array();
		$tree_items[-1] = array('id'=>'-1', 'name'=>L('area_level_1'), 'child'=>'1');
		$tree_items[-2] = array('id'=>'-2', 'name'=>L('area_level_2'), 'child'=>'2');
		$tree_items[-3] = array('id'=>'-3', 'name'=>L('area_level_3'), 'child'=>'3');

		$show_header = '';
		$cfg = getcache('common','commons');
		$from = isset($_GET['from']) && in_array($_GET['from'],array('block')) ? $_GET['from'] : 'content';
		$tree = pc_base::load_sys_class('tree');
		$areas = $this->areas = getcache('area_content', 'commons');
		$products = getcache('product_content', 'commons');
		foreach ($products as $productid => $product) {
			$product['child'] = 1;
			$product['name'] = $product['title'];
			$product['parentid'] = 0 - $product['area_level'];
			$product['icon_type'] = $product['vs_show'] = '';
			$product['type'] = 'init';
			$product['add_icon'] = "<a target='right' href='?m=admin&c=area&a=add&productid=".$productid."' ><img src='".IMG_PATH."add_content.gif' alt='".L('add')."'></a> ";
			$tree_items[$productid] = $product;
		}
		if(!empty($tree_items)) {
			$tree->init($tree_items);
			$strs = "<span class='\$icon_type'>\$add_icon<a href='?m=admin&c=area&a=init&productid=\$id' target='right' onclick='open_list(this)'>\$name</a></span>";
			$strs2 = "<span class='folder'>\$name</span>";
			$areas = $tree->get_treeview(0,'category_tree',$strs,$strs2);
		} else {
			$areas = L('please_add_category');
		}
        include $this->admin_tpl('area_tree');
	}

}
?>