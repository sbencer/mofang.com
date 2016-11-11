<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('form','',0);
pc_base::load_sys_class('format','',0);
pc_base::load_app_func('util','content');
pc_base::load_sys_class('smarty','',0);
class index {
    private $_is_wap = false;

	function __construct() {
		$this->db = pc_base::load_model('search_model');
		$this->content_db = pc_base::load_model('content_model');

        if(WAP) { //移动端展示判断
            $this->_is_wap = true;
        }
	}
	
	/**
	 * 关键词搜索
	 */
	public function init() {
		//获取siteid
		$siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
		$SEO = seo($siteid);

		//搜索配置
		$setting = pc_base::load_config('solr');

        //有關鍵字時才請求solr
		if(isset($_GET['q'])) {
			$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
			$pagesize = 10;
			$q = safe_replace(trim($_GET['q']));
			$q = htmlspecialchars(strip_tags($q));
			$q = str_replace('%', '', $q);	//过滤'%'，用户全文搜索
			$search_q = $q;	//搜索原内容

			$solr = new Apache_Solr_Service($setting['hostname'], $setting['port'], $setting['path']);

			if ( ! $solr->ping() ) {
				echo 'Search service not responding.';
				exit;
			}

			$offset = ($page-1) * $pagesize;

			$params['hl'] = 'true';
			$params['hl.fl'] = 'title';
			$params['hl.simple.pre'] = '<span>';
			$params['hl.simple.post'] = '</span>';

			$response = $solr->search($q, $offset, $pagesize, $params);

			if ($response->getHttpStatus() == 200) {

				$totalnums = $response->response->numFound;
				if ($totalnums > 0) {
					foreach ( $response->response->docs as $key => $doc ) {
						foreach($doc as $field => $value) {
							$ukid = $doc->ukid;
							if($field == 'title') {
								//$data[$key]['title'] = $response->highlighting->$ukid->title[0] ? : $value;
								$data[$key][$field] = $value;
							} else {
								$data[$key][$field] = $value;
							}
						}
					}
				}

				//如果关键词长度在2-10之间，保存关键词计数
				if(strlen($q) < 31 && strlen($q) > 5) {
					$this->hits($q);
				}

			} else {
				echo $response->getHttpStatusMessage();
			}
        }

        $execute_time = execute_time();
        $pages = isset($pages) ? $pages : '';
        $totalnums = isset($totalnums) ? $totalnums : 0;
        $data = isset($data) ? $data : array();

        if($_GET['ajax'] == 1) {
            echo json_encode($data);
            return;
        }

        $smarty = new CSmarty();

        $smarty->assign("SEO", $SEO);
        $smarty->assign("tag", $q);
        $smarty->assign("data", $data);

        $smarty->assign("keyword", $q);
        $smarty->assign("result", $data);

        $smarty->assign("page", $page);
        $smarty->assign("total", $totalnums);

        if($this->_is_wap) {
            $smarty->display('tw_acg/wap/tag.tpl');
        } else {
            $smarty->display('tw_acg/search.tpl');
        }
	}

	
	public function public_get_suggest_keyword() {
		$q = safe_replace(trim($_GET['q']));
		$q = htmlspecialchars(strip_tags($q));
		$q = str_replace('%', '', $q);	//过滤'%'，用户全文搜索

		$this->keyword_db = pc_base::load_model('search_count_model');
		$suggest = $this->keyword_db->select("keyword like '$q%'", 'keyword', 5, 'views DESC');

		$keywords = array();

		foreach($suggest as $value) {
			$keywords[] = $value['keyword'];
		}

		echo json_encode($keywords);
	}
	
	/**
	 * 提示搜索接口
	 * TODO 暂时未启用，用的是google的接口
	 */
	public function public_suggest_search() {
		//关键词转换为拼音
		pc_base::load_sys_func('iconv');
		$pinyin = gbk_to_pinyin($q);
		if(is_array($pinyin)) {
			$pinyin = implode('', $pinyin);
		}
		$this->keyword_db = pc_base::load_model('search_keyword_model');
		$suggest = $this->keyword_db->select("pinyin like '$pinyin%'", '*', 10, 'searchnums DESC');
		
		foreach($suggest as $v) {
			echo $v['keyword']."\n";
		}

		
	}

	/**
	 * 关键字搜索次数统计
	 * @param $keyword
	 */
	function hits($keyword) {
		$this->keyword_db = pc_base::load_model('search_count_model');

		$r = $this->keyword_db->get_one(array('keyword'=>$keyword));
		if($r) {
			$views = $r['views'] + 1;
			$yesterdayviews = (date('Ymd', $r['updatetime']) == date('Ymd', strtotime('-1 day'))) ? $r['dayviews'] : $r['yesterdayviews'];
			$dayviews = (date('Ymd', $r['updatetime']) == date('Ymd', SYS_TIME)) ? ($r['dayviews'] + 1) : 1;
			$weekviews = (date('YW', $r['updatetime']) == date('YW', SYS_TIME)) ? ($r['weekviews'] + 1) : 1;
			$monthviews = (date('Ym', $r['updatetime']) == date('Ym', SYS_TIME)) ? ($r['monthviews'] + 1) : 1;
			$sql = array('views' => $views, 'yesterdayviews' => $yesterdayviews, 'dayviews' => $dayviews, 'weekviews' => $weekviews, 'monthviews' => $monthviews, 'updatetime' => SYS_TIME);
			return $this->keyword_db->update($sql, array('keyword' => $keyword));
		} else {
			$sql = array('keyword' => $keyword, 'views' => 1, 'yesterdayviews' => 1, 'dayviews' => 1, 'weekviews' => 1, 'monthviews' => 1, 'updatetime' => SYS_TIME);
			return $this->keyword_db->insert($sql);
		}
	}
}
?>
