<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
// header('Content-Type: application/json');

$game = new game;
$true_action = trim($_GET['action']);

$return = array();

if(!method_exists($game,$true_action)){
    $return['code'] = -1;
    $return['message'] = '接口方法不存在，请检查!';
    $return['data'] = "";
} else {
    $return = $game->$true_action(); 
}
$callback = isset($_GET['jsonpcallback']) ? trim($_GET['jsonpcallback']) : ( isset($_GET['callback']) ? trim($_GET['callback']) : "" );
if($callback){
    echo $callback."(".json_encode($return).")";
}else{
    echo json_encode($return);
}
exit;



/**
  * 根据游戏ID，游戏名称，查询文章列表 并增加类别字段
  * 方法get_information
  * 参数gamename,gameid,number,test,
  * 例：www.mofang.com/api_v2.php?op=mofang&file=game&action=get_information&gameid=$1&gamename=$2&number=$3
  * 手动改变缓存：www.mofang.com/api_v2.php?op=mofang&file=game&action=get_information&gameid=$1&gamename=$2&number=$3&test=1
  * 7.17号 周蕊  
  */
class game {
	function __construct()
	{
		
	}

	public function get_information(){
		if ( !($game_name = trim($_GET['gamename'])) ) return array('code'=>1, 'message'=>'缺少必要参数：gamename！');
		if ( !($gameid = trim($_GET['gameid'])) ) return array('code'=>1, 'message'=>'缺少必要参数：gameid！');
		//新闻
		$xw = array(81, 182, 101, 188, 1149, 1150, 1166, 1167);
		//评测
		$pc = array(1157,1311,1393,1454);
		//攻略
		$gl = array(1019, 83, 184, 103, 190);

		$number = $_GET['number'] ? intval($_GET['number']) : 5 ;
		$test = $_GET['test'] ? intval($_GET['test']) : '' ;
		$game_search = $gameid.'-getgamearticle_'.$number;
		$game_search_key = sha1($game_search);
		$game_search_key .= '_lists';

		if ($test==1) {
			$article_array = array();
			$content_db= pc_base::load_model('content_model');
			$content_db->set_model(1);
			$catids = " `catid` in (1157, 1311, 1393, 1454, 1019, 83, 184, 103, 190,81, 182, 101, 188, 1149, 1150, 1166, 1167) ";	
			$sql = $catids." AND `status`=99 AND `title` like '%$game_name%' ";
			$article_array = $content_db->select($sql,'id,catid,title,thumb,description,url,inputtime',$number,'id desc');
			foreach ($article_array as $key => $value) {
				if (in_array($value['catid'], $xw)){
					$article_array[$key]['types'] = '新闻';
				}elseif (in_array($value['catid'], $pc)) {
					$article_array[$key]['types'] = '评测';
				}elseif (in_array($value['catid'], $gl)) {
					$article_array[$key]['types'] = '攻略';
				}
        	} 
			//组成返回数据
			$data['code'] = 0;
			$err_info['msg'] = 'ok';
			$err_info['data'] = $article_array;
			//写缓存
			setcache($game_search_key, $article_array, '', 'memcache', 'html', 7200);
			return $err_info;
			exit;
		}
		if (!$datas = getcache($game_search_key, '', 'memcache', 'html')) {
			$search_setting = getcache('search','search');
	        $setting = $search_setting[1];
	        $solr = pc_base::load_app_class('apache_solr_service', 'search', 0);
	        $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
	        if($solr->ping()){
	        //if(1==1){
	        	//solr可用 
	        	$q = $game_name;
		        $page = 1;
		        $pagesize = $number;
		        $start = ($page-1)*$pagesize;

		        $additionalParameters['sort'] = 'inputtime desc';
		        $additionalParameters['fq'][] = "types:news";
		        $additionalParameters['fq'][] = "title:".$game_name;
		        $additionalParameters['fq'][] = "catid:1157 OR catid:1131 OR catid:1393 OR catid:1454 OR catid:1019 OR catid:103 OR catid:190 OR catid:83 OR catid:1149 OR catid:1150 OR catid:1166 OR catid:1167";

		        $result = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
		        if ($result) {
		            $totalnums = (int) $result->response->numFound;
		        }
		        foreach ($result->response->docs as $key=> $doc) {
		            foreach ($doc as $field => $value) {
		                $data[$key][$field] = $value;
		            }
		        }
		        foreach ($data as $key => $value) {
					if (in_array($value['catid'], $xw)){
						$data[$key]['types'] = '新闻';
					}elseif (in_array($value['catid'], $pc)) {
						$data[$key]['types'] = '评测';
					}elseif (in_array($value['catid'], $gl)) {
						$data[$key]['types'] = '攻略';
					}
	        	}
		        //组成返回数据
				$err_info['code'] = 0;
				$err_info['msg'] = 'ok';
				$err_info['data'] = $data;
				//写缓存
				setcache($game_search_key, $data, '', 'memcache', 'html', 7200);
				return $err_info;
	        }else{//solr 不可用，走DB 搜索 
				//定义文章数组
				$article_array = array();
				$content_db= pc_base::load_model('content_model');
				$content_db->set_model(1);
				$catids = " `catid` in (1157, 1311, 1393, 1454, 1019, 83, 184, 103, 190,81, 182, 101, 188, 1149, 1150, 1166, 1167) ";	
				$sql = $catids." AND `status`=99 AND `title` like '%$game_name%' ";
				$article_array = $content_db->select($sql,'id,catid,title,thumb,description,url,inputtime',$number,'id desc');
				foreach ($article_array as $key => $value) {
					if (in_array($value['catid'], $xw)){
						$article_array[$key]['types'] = '新闻';
					}elseif (in_array($value['catid'], $pc)) {
						$article_array[$key]['types'] = '评测';
					}elseif (in_array($value['catid'], $gl)) {
						$article_array[$key]['types'] = '攻略';
					}
	        	} 
				//组成返回数据
				$data['code'] = 0;
				$err_info['msg'] = 'ok';
				$err_info['data'] = $article_array;
				//写缓存
				setcache($game_search_key, $article_array, '', 'memcache', 'html', 7200);
				return $err_info;
	        }
		}else{
			$datas = getcache($game_search_key, '', 'memcache', 'html');
			$err_info['code'] = 0;
			$err_info['msg'] = 'ok';
			$err_info['data'] = $datas;
			return $err_info;
		}
	}
}