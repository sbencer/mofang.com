<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
class search_admin extends admin {
	function __construct() {
		parent::__construct();
		$this->siteid = $this->get_siteid();
		$this->db = pc_base::load_model('search_model');
		$this->module_db = pc_base::load_model('module_model');
		$this->type_db = pc_base::load_model('type_model');
		$this->model = getcache('model', 'commons');


	}

	public function setting() {
		$siteid = get_siteid();
		if(isset($_POST['dosubmit'])) {
			//合並數據庫緩存與新提交緩存
			$r = $this->module_db->get_one(array('module'=>'search'));
			$search_setting = string2array($r['setting']);
			
			$search_setting[$siteid] = $_POST['setting'];
			$setting = array2string($search_setting);
			setcache('search', $search_setting);
			$this->module_db->update(array('setting'=>$setting),array('module'=>'search'));
			showmessage(L('operation_success'),HTTP_REFERER);
		} else {
			$r = $this->module_db->get_one(array('module'=>'search'));
			$setting = string2array($r['setting']);
			if($setting[$siteid]){
				extract($setting[$siteid]);
			}
			
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=search&c=search_type&a=add\', title:\''.L('add_search_type').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_search_type'));
			include $this->admin_tpl('setting');
		}
	}
	/**
	 * 創建索引
     * @editor Jozh liu in 2014.10.23
	 */
	public function createindex() {
		if(isset($_GET['dosubmit'])) {
			//獲取siteid
			$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;

			$typeid = $_GET['typeid'] ? intval($_GET['typeid']) : '';

			//搜索配置
			$search_setting = getcache('search','search');
			$setting = $search_setting[$siteid];

			$solr = pc_base::load_app_class('apache_solr_service', 'search', 0);
			$solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);

			//重建索引首先清空表所有數據，然後根據搜索類型接口重新全部重建索引
			if(!isset($_GET['have_truncate'])) {
				//刪除該站點全文索引
                if (!$typeid) {
                    $solr->deleteByQuery('*:*');
                } else {
                    $solr->deleteByQuery('typeid:'.$typeid);
                }

				$types = $this->type_db->select(array('siteid'=> $this->siteid,'module'=>'search'));
				setcache('search_types',$types, 'search');
			} else{
				$types = getcache('search_types', 'search');
			}

			$key = isset($_GET['key']) ? intval($_GET['key']) : 0;
            $typename = '全部';
			try {
                foreach ($types as $_k=>$_v) {
                    if ($key == $_k) {
                        if ($typeid) {
                            if ($typeid == $_v['typeid']) {
                                if($_v['modelid']) {
                                    if ($_v['typedir']!=='yp') {
                                        $search_api = pc_base::load_app_class('search_api','content');
                                    } else {
                                        $search_api = pc_base::load_app_class('search_api',$_v['typedir']);
                                    }
                                    if(!isset($_GET['total'])) {
                                        $total = $search_api->total($_v['modelid']);
                                    } else {
                                        $total = intval($_GET['total']);
                                        $search_api->set_model($_v['modelid']);
                                    }
                                } else {
                                    $module = trim($_v['typedir']);
                                    $search_api = pc_base::load_app_class('search_api',$module);
                                    if(!isset($_GET['total'])) {
                                        $total = $search_api->total();
                                    } else {
                                        $total = intval($_GET['total']);
                                    }
                                }

                                $pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 50;
                                $page = max(intval($_GET['page']), 1);
                                $pages = ceil($total/$pagesize);
                            
                                $datas = $search_api->fulltext_api($pagesize,$page);
                                $document = new Apache_Solr_Document();

                                foreach ($datas as $id=>$r) {
                                    foreach ($r as $k => $v) {
                                        $document->$k = $v;
                                    }
                                    $solr->addDocument($document);
                                }

                                $page++;
                                $typename = $_v['name'];
                                if($page < $pages){
                                    showmessage("正在更新 <span style='color:#ff0000;font-size:14px;text-decoration:underline;' >{$_v['name']}</span> - 總數：{$total} - 當前第 <font color='red'>{$page}</font> 頁","?m=search&c=search_admin&a=createindex&menuid=909&page={$page}&total={$total}&pagesize={$pagesize}&key={$key}&typeid={$typeid}&have_truncate=1&dosubmit=1");
                                }elseif($page == $pages){
                                    break;
                                }
                            } else {
                                $key++;
                                continue;
                            }
                        } else {
                            if($_v['modelid']) {
                                if ($_v['typedir']!=='yp') {
                                    $search_api = pc_base::load_app_class('search_api','content');
                                } else {
                                    $search_api = pc_base::load_app_class('search_api',$_v['typedir']);
                                }
                                if(!isset($_GET['total'])) {
                                    $total = $search_api->total($_v['modelid']);
                                } else {
                                    $total = intval($_GET['total']);
                                    $search_api->set_model($_v['modelid']);
                                }
                            } else {
                                $module = trim($_v['typedir']);
                                $search_api = pc_base::load_app_class('search_api',$module);
                                if(!isset($_GET['total'])) {
                                    $total = $search_api->total();
                                } else {
                                    $total = intval($_GET['total']);
                                }
                            }

                            $pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 50;
                            $page = max(intval($_GET['page']), 1);
                            $pages = ceil($total/$pagesize);
                        
                            $datas = $search_api->fulltext_api($pagesize,$page);
                            $document = new Apache_Solr_Document();

                            foreach ($datas as $id=>$r) {
                                foreach ($r as $k => $v) {
                                    $document->$k = $v;
                                }
                                $solr->addDocument($document);
                            }

                            $page++;
                            $typename = $_v['name'];
                            if($page <=$pages){
                                showmessage("正在更新 <span style='color:#ff0000;font-size:14px;text-decoration:underline;' >{$_v['name']}</span> - 總數：{$total} - 當前第 <font color='red'>{$page}</font> 頁","?m=search&c=search_admin&a=createindex&menuid=909&page={$page}&total={$total}&pagesize={$pagesize}&key={$key}&have_truncate=1&dosubmit=1");
                            }else{
                                $key++;
                                showmessage("開始更新： <span style='color:#ff0000;font-size:14px;text-decoration:underline;' >{$_v['name']}</span> - 總數：{$total}條","?m=search&c=search_admin&a=createindex&menuid=909&page=1&pagesize={$pagesize}&key={$key}&have_truncate=1&dosubmit=1");
                            }
                        }
                    } // key end 
                } // foreach end
                $solr->commit();
                showmessage($typename.'索引更新完成','blank');
			} catch(Exception $e) {
                showmessage($typename.'索引更新失敗','blank');
			}
		} else {
            $page = isset($_GET['page']) && trim($_GET['page']) ? intval($_GET['page']) : 1;
            $result_datas = $this->type_db->listinfo(array('siteid'=>$this->siteid,'module'=>'search'),'listorder ASC', $page);
            foreach($result_datas as $r) {
                $r['modelname'] = $this->model[$r['modelid']]['name'];
                $datas[] = $r;
            }
			$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=search&c=search_type&a=add\', title:\''.L('add_search_type').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_search_type'));
			include $this->admin_tpl('createindex');
		}
	}
	
	public function public_test_solr() {
		// var_dump($_POST);
		$solrhost = !empty($_POST['solrhost']) ? $_POST['solrhost'] : exit('-1');
		$solrport = !empty($_POST['solrport']) ? intval($_POST['solrport']) : exit('-2');
		$solrdir = !empty($_POST['solrdir']) ? $_POST['solrdir'] : exit('-3');

		$solr = pc_base::load_app_class('apache_solr_service', '', 0);
		$solr = new Apache_Solr_Service($solrhost, $solrport, $solrdir);
		if (!$solr->ping()) {
			exit('0');
		} else {
			exit('1');
		}
	}
	
}
?>
