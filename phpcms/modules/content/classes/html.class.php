<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('util','content');
pc_base::load_sys_func('dir');
class html {
	private $siteid,$url,$html_root,$queue,$categorys;
	public function __construct() {
		$this->queue = pc_base::load_model('queue_model');
		define('HTML',true);
		self::set_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$this->url = pc_base::load_app_class('url', 'content');
		$this->html_root = pc_base::load_config('system','html_root');
		$this->sitelist = getcache('sitelist','commons');
	}

	/**
	 * 生成內容頁
	 * @param  $file 文件地址
	 * @param  $data 數據
	 * @param  $array_merge 是否合並
	 * @param  $action 方法
	 * @param  $upgrade 是否是升級數據
	 */
	public function show($file, $data = '', $array_merge = 1,$action = 'add',$upgrade = 0) {
		if($upgrade) $file = '/'.ltrim($file,WEB_PATH);
		$allow_visitor = 1;
		$id = $data['id'];
		if($array_merge) {
			$data = new_stripslashes($data);
			$data = array_merge($data['system'],$data['model']);
		}
		//通過rs獲取原始值
		$rs = $data;
		if(isset($data['paginationtype'])) {
			$paginationtype = $data['paginationtype'];
			$maxcharperpage = $data['maxcharperpage'];
		} else {
			$paginationtype = 0;
		}
		$catid = $data['catid'];
		$CATEGORYS = $this->categorys;
		$CAT = $CATEGORYS[$catid];
		$CAT['setting'] = string2array($CAT['setting']);
		define('STYLE',$CAT['setting']['template_list']);

		//最頂級欄目ID
		$arrparentid = explode(',', $CAT['arrparentid']);
		$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
		
		//$file = '/'.$file;
		//添加到發布點隊列
		//當站點為非系統站點
		
		if($this->siteid!=1) {
			$site_dir = $this->sitelist[$this->siteid]['dirname'];
			$file = $this->html_root.'/'.$site_dir.$file;
		}
		
		$this->queue->add_queue($action,$file,$this->siteid);
		
		$modelid = $CAT['modelid'];
		require_once CACHE_MODEL_PATH.'content_output.class.php';
		$content_output = new content_output($modelid,$catid,$CATEGORYS);
		$output_data = $content_output->get($data);
		extract($output_data);
		if(module_exists('comment')) {
			$allow_comment = isset($allow_comment) ? $allow_comment : 1;
		} else {
			$allow_comment = 0;
		}
		$this->db = pc_base::load_model('content_model');
		$this->db->set_model($modelid);
		//上一頁
		$previous_page = $this->db->get_one("`catid` = '$catid' AND `id`<'$id' AND `status`=99",'*','id DESC');
		//下一頁
		$next_page = $this->db->get_one("`catid`= '$catid' AND `id`>'$id' AND `status`=99");
		
		if(empty($previous_page)) {
			$previous_page = array('title'=>L('first_page','','content'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('first_page','','content').'\');');
		}
		if(empty($next_page)) {
			$next_page = array('title'=>L('last_page','','content'), 'thumb'=>IMG_PATH.'nopic_small.gif', 'url'=>'javascript:alert(\''.L('last_page','','content').'\');');
		}
	
		$title = strip_tags($title);
		//SEO
		$seo_keywords = '';
		if(!empty($keywords)) $seo_keywords = implode(',',$keywords);
		$siteid = $this->siteid;
		$SEO = seo($siteid, $catid, $title, $description, $seo_keywords);
		
		$ishtml = 1;
		$template = $template ? $template : $CAT['setting']['show_template'];
		
		//分頁處理
		$pages = $titles = '';
		if($paginationtype==1) {
			//自動分頁
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = pc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
	
		if($paginationtype!=0) {
			//手動分頁
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = pc_base::load_app_class('url', 'content');	
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$upgrade = $upgrade ? '/'.ltrim($file,WEB_PATH) : '';
					$pageurls[$i] = $this->url->show($id, $i, $catid, $data['inputtime'],'','','edit',$upgrade);
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				//生成分頁
				foreach ($pageurls as $page=>$urls) {
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
						list($title, $content) = explode('[/page]', $content);
						$content = trim($content);
						if(strpos($content,'</p>')===0) {
							$content = '<p>'.$content;
						}
						if(stripos($content,'<p>')===0) {
							$content = $content.'</p>';
						}
					}
					$pagefile = $urls[1];
					if($this->siteid!=1) {
						$pagefile = $this->html_root.'/'.$site_dir.$pagefile;
					}
					$this->queue->add_queue($action,$pagefile,$this->siteid);
					$pagefile = PHPCMS_PATH.$pagefile;
					ob_start();
					include template('content', $template);
					$this->createhtml($pagefile);
				}
				return true;
			}
		}
		//分頁處理結束
		$file = PHPCMS_PATH.$file;
		ob_start();
		include template('content', $template);
		return $this->createhtml($file);
	}

	/**
	 * 生成欄目列表
	 * @param $catid 欄目id
	 * @param $page 當前頁數
	 */
	public function category($catid, $page = 0) {
		$CAT = $this->categorys[$catid];
		@extract($CAT);
		if(!$ishtml) return false;
		if(!$catid) showmessage(L('category_not_exists','content'),'blank');
		$CATEGORYS = $this->categorys;
		if(!isset($CATEGORYS[$catid])) showmessage(L('information_does_not_exist', 'content'),'blank');
		$siteid = $CAT['siteid'];
		$copyjs = '';
		$setting = string2array($setting);
		if(!$setting['meta_title']) $setting['meta_title'] = $catname;
		$SEO = seo($siteid, '',$setting['meta_title'],$setting['meta_description'],$setting['meta_keywords']);
		define('STYLE',$setting['template_list']);

		$page = intval($page);
		$parentdir = $CAT['parentdir'];
		$catdir = $CAT['catdir'];
		//檢查是否生成到根目錄
		$create_to_html_root = $CAT['sethtml'];
		//$base_file = $parentdir.$catdir.'/';
		//生成地址
		if($CAT['create_to_html_root']) $parentdir = '';
		
		//獲取父級的配置，看是否生成靜態，如果是動態則直接把父級目錄調過來為生成靜態目錄所用
		$parent_setting = string2array($CATEGORYS[$CAT['parentid']]['setting']);
		if($parent_setting['ishtml']==0 && $setting['ishtml']==1){
			$parentdir = $CATEGORYS[$CAT['parentid']]['catdir'].'/';
		}
		
		$base_file = $this->url->get_list_url($setting['category_ruleid'],$parentdir, $catdir, $catid, $page);
		$base_file = '/'.$base_file;
		
		//非系統站點時，生成到指定目錄
		if($this->siteid!=1) {
			$site_dir = $this->sitelist[$this->siteid]['dirname'];
			if($create_to_html_root) {
				$base_file = '/'.$site_dir.$base_file;
			} else {
				$base_file = '/'.$site_dir.$this->html_root.$base_file;
			}
		} 
		//判斷二級域名是否直接綁定到該欄目
		$root_domain = preg_match('/^((http|https):\/\/)([a-z0-9\-\.]+)\/$/',$CAT['url']) ? 1 : 0;
		$count_number = substr_count($CAT['url'], '/');
		$urlrules = getcache('urlrules','commons');
		$urlrules = explode('|',$urlrules[$category_ruleid]);
		
		if($create_to_html_root) {
			if($this->siteid==1) {
				$file = PHPCMS_PATH.$base_file;
			} else {
				$file = PHPCMS_PATH.substr($this->html_root,1).$base_file;
			}
			//添加到發布點隊列
			$this->queue->add_queue('add',$base_file,$this->siteid);
			//評論跨站調用所需的JS文件
			if(substr($base_file, -10)=='index.html' && $count_number==3) {
				$copyjs = 1;
				$this->queue->add_queue('add',$base_file,$this->siteid);
			}
			//URLRULES
			if($CAT['isdomain']) {
				$second_domain = 1;
				foreach ($urlrules as $_k=>$_v) {
					$urlrules[$_k] = $_v;
				}
			} else {
				foreach ($urlrules as $_k=>$_v) {
					$urlrules[$_k] = '/'.$_v;
				}
			}
		} else {
			$file = PHPCMS_PATH.substr($this->html_root,1).$base_file;
			//添加到發布點隊列
			$this->queue->add_queue('add',$this->html_root.$base_file,$this->siteid);
			//評論跨站調用所需的JS文件
			if(substr($base_file, -10)=='index.html' && $count_number==3) {
				$copyjs = 1;
				$this->queue->add_queue('add',$this->html_root.$base_file,$this->siteid);
			}		
			//URLRULES
			$htm_prefix = $root_domain ? '' : $this->html_root;
			$htm_prefix = rtrim(WEB_PATH,'/').$htm_prefix;
			if($CAT['isdomain']) {
				$second_domain = 1;
			} else {
				$second_domain = 0;//判斷該欄目是否綁定了二級域名或者上級欄目綁定了二級域名，存在的話，重新構造列表頁url規則
				foreach ($urlrules as $_k=>$_v) {
					$urlrules[$_k] = $htm_prefix.'/'.$_v;
				}
			}
		}

		if($type==0) {
			$template = $setting['category_template'] ? $setting['category_template'] : 'category';
			$template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
			$template = $child ? $template : $template_list;
			$arrparentid = explode(',', $arrparentid);
			$top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
			$array_child = array();
			$self_array = explode(',', $arrchildid);
			foreach ($self_array as $arr) {
				if($arr!=$catid) $array_child[] = $arr;
			}
			$arrchildid = implode(',', $array_child);
			//URL規則
			$urlrules = implode('~', $urlrules);
			
			define('URLRULE', $urlrules);
			//綁定域名時，設置$catdir 為空
			if($root_domain) $parentdir = $catdir = '';
			if($second_domain) {
				$parentdir = '';
				$parentdir = str_replace($catdir.'/', '', $CAT['url']);
			}
			
			$GLOBALS['URL_ARRAY'] = array('categorydir'=>$parentdir, 'catdir'=>$catdir, 'catid'=>$catid);
		} else {
		//單網頁
			$datas = $this->page($catid);
			if($datas) extract($datas);
			$template = $setting['page_template'] ? $setting['page_template'] : 'page';
			$parentid = $CATEGORYS[$catid]['parentid'];
			$arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
			if($arrchild_arr=='') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
			$arrchild_arr = explode(',',$arrchild_arr);
			array_shift($arrchild_arr);
			$keywords = $keywords ? $keywords : $setting['meta_keywords'];
			$SEO = seo($siteid, 0, $title,$setting['meta_description'],$keywords);
		}
		ob_start();
		include template('content',$template);
		return $this->createhtml($file, $copyjs);
	}

	/**
	 * 更新首頁
	 * 改為smarty 模版生成  - 王官慶
	 */
	public function index() {

		define('SITEID', $this->siteid);
		$SEO = seo($this->siteid);
		$siteid = $this->siteid;
		$CATEGORYS = $this->categorys;
		if($this->siteid==1) {
			$file = PHPCMS_PATH.'index.html';
		}
		require(PC_PATH."init/smarty.php"); 
        $smarty = use_v4();
        $smarty->assign("SEO",$SEO);
		ob_start();
        $smarty->display('content/index.tpl'); 
		return $this->createhtml($file, 1); 
	}


	/**
	 * 更新首頁
	 */
	public function index_bak() {
		if($this->siteid==1) {
			$file = PHPCMS_PATH.'index.html';
			//添加到發布點隊列
			$this->queue->add_queue('edit','/index.html',$this->siteid);
		} else {
			$site_dir = $this->sitelist[$this->siteid]['dirname'];
			$file = $this->html_root.'/'.$site_dir.'/index.html';
			//添加到發布點隊列
			$this->queue->add_queue('edit',$file,$this->siteid);
			$file = PHPCMS_PATH.$file;
		}
		define('SITEID', $this->siteid);
		//SEO
		$SEO = seo($this->siteid);
		$siteid = $this->siteid;
		$CATEGORYS = $this->categorys;
		$style = $this->sitelist[$siteid]['default_style'];
		ob_start();
		include template('content','index',$style);
		return $this->createhtml($file, 1);
	}
	/**
	 * 單網頁
	 * @param $catid
	 */
	public function page($catid) {
		$this->page_db = pc_base::load_model('page_model');
		$data = $this->page_db->get_one(array('catid'=>$catid));
		return $data;
	}
	/**
	* 寫入文件
	* @param $file 文件路徑
	* @param $copyjs 是否復制js，跨站調用評論時，需要該js
	*/
	private function createhtml($file, $copyjs = '') {
		$data = ob_get_contents();
		ob_clean();
		$dir = dirname($file);
		if(!is_dir($dir)) {
			mkdir($dir, 0777,1);
		}
		if ($copyjs && !file_exists($dir.'/js.html')) {
			@copy(PC_PATH.'modules/content/templates/js.html', $dir.'/js.html');
		}
		$strlen = file_put_contents($file, $data);
		@chmod($file,0777);
		if(!is_writable($file)) {
			$file = str_replace(PHPCMS_PATH,'',$file);
			showmessage(L('file').'：'.$file.'<br>'.L('not_writable'));
		}
		return $strlen;
	}

	/**
	 * 設置當前站點id
	 */
	private function set_siteid() {
		if(defined('IN_ADMIN')) {
			$this->siteid = $GLOBALS['siteid'] = get_siteid();
		} else {
			if (param::get_cookie('siteid')) {
				$this->siteid = $GLOBALS['siteid'] = param::get_cookie('siteid');
			} else {
				$this->siteid = $GLOBALS['siteid'] = 1;
			}
		}
	}
	/**
	* 生成相關欄目列表、只生成前5頁
	* @param $catid
	*/
	public function create_relation_html($catid) {
		for($page = 1; $page < 6; $page++) {
			$this->category($catid,$page);
		}
		//檢查當前欄目的父欄目，如果存在則生成
		$arrparentid = $this->categorys[$catid]['arrparentid'];
		if($arrparentid) {
			$arrparentid = explode(',', $arrparentid);
			foreach ($arrparentid as $catid) {
				if($catid) $this->category($catid,1);
			}
		}
	}
}