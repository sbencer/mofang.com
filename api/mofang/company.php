<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
 
$company = new company;
$true_action = trim($_GET['action']);
if(!method_exists($company,$true_action)){
	$return = array();
	$return['code'] = -1;
	$return['message'] = '接口不存在，请检查!';
	$return['data'] = '';
	$return = json_encode($return);
	if($callback){
		echo $callback."($return)";
	}else{
		echo $return;
	}
	exit;
}
$company->$true_action($_GET); 


class company {

	function __construct() { 
    }

/**
* 厂商库相关新闻
* 参数：  page pagesize companyid(Y) type: article,video 
* 根据type获取不同的信息 
* 作者：王官庆  
* 例子： http://wgq.mofang.com/api_v2.php?op=mofang&action=company_article&companyid=14540&type=article 
* 视频： http://wgq.mofang.com/api_v2.php?op=mofang&action=company_article&companyid=14540&type=video
*/

    public function Get_Article_By_Companyid(){
		$page = $_GET['page'] ? intval($_GET['page']) : 1; 
		$pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 10;
		$companyid = intval($_GET['companyid']);
		$type = $_GET['type'] ? safe_replace($_GET['type']) : 'all';

		$type_array = array("article","video",'all');
		$type_modelid_array = array("article"=>'1,17,19',"video"=>'11');
		if(!$companyid || !in_array($type, $type_array)){
			exit('Operation can not be empty');
		}
		$company_db= pc_base::load_model('relation_company_model');
		$modelids = $type_modelid_array[$type]; 
		//限定不采用的catid 字符串
		$not_catids = "122";

		switch ($type) {
			case 'all':
				# code...
				$where = " `companyid`=$companyid";
				break;
			case 'article':
				# code...
				$where = " `companyid`=$companyid AND `modelid` in ($modelids) AND `catid` not in ($not_catids)  ";

				break;
			case 'video':
				# code...
				$where = " `companyid`=$companyid AND `modelid` in ($modelids)";
				break;
			default:
				# code...
				$where = " `companyid`=$companyid";
				break;
		}
		// $where = " `companyid`=$companyid AND `modelid` in ($modelids) AND `catid` not in ($not_catids)  ";
		$article_array = $company_db->listinfo($where, 'addtime desc ', $page, $pagesize);
		$array_data = array();
		if(!empty($article_array)){
			$content_db= pc_base::load_model('content_model');
			$categorys = getcache('category_content_1','commons');

			foreach ($article_array as $key => $value) {
				# code...
				$modelid = '';
				$modelid = $value['modelid'];
				$content_db->set_model($modelid); 
				$art_array = array();
				$art_array = $content_db->get_content($value['catid'],$value['id']);
				$array = array();
				$array['id'] = $art_array['id'];
				$array['catid'] = $art_array['catid'];
				$array['catname'] = $categorys[$art_array['catid']]['catname'];//栏目名称
				$array['title'] = $art_array['title'];
				$array['shortname'] = $art_array['shortname'];
				$array['thumb'] = $art_array['thumb'];
				$array['outhorname'] = $art_array['outhorname'];
				$array['description'] = $art_array['description'];
				$array['keywords'] = $art_array['keywords'];
				$array['inputtime'] = $art_array['inputtime'];
				$array['url'] = $art_array['url'];
				switch ($value['modelid']) {
					case '1':
						# code...
						$array['type'] = 'article';
						break;
					case '17':
						# code...
						$array['type'] = 'article';
						break;
					case '19':
						# code...
						$array['type'] = 'article';
						break;
					case '11':
						# code...
						$array['type'] = 'video';
						break;	
					default:
						# code...
						$array['type'] = 'article';
						break;
				}

				$array_data[] = $array;
				unset($modelid);
			}
		}

		$return = array();
		$return['code'] = 0;
		$return['message'] = 'Success!';
		$return['data'] = $array_data;
		$return = json_encode($return);
		if($callback){
		echo $callback."($return)";
		}else{
		echo $return;
		}
		exit;

    }



/**
* 根据厂商ID，从指定栏目获取，跟厂商相关的推荐阅读
* 参数：  page pagesize companyid(Y) 
* 作者：王官庆  
* 例子： http://wgq.mofang.com/api_v2.php?op=mofang&action=company_article&companyid=14540&type=article 
*/

    public function Get_Recommend_By_Companyid(){
		$page = $_GET['page'] ? intval($_GET['page']) : 1; 
		$pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 10;
		$companyid = intval($_GET['companyid']);
		if(!$companyid){
			exit('Operation can not be empty');
		}
		$company_db= pc_base::load_model('relation_company_model');
		//从指定栏目查询文章
		$catids = '122';
		$where = " `companyid`=$companyid AND `catid` in ($catids) ";
		$article_array = $company_db->listinfo($where, 'addtime desc ', $page, $pagesize);
		$array_data = array();
		if(!empty($article_array)){
			$content_db= pc_base::load_model('content_model');
			$categorys = getcache('category_content_1','commons');

			foreach ($article_array as $key => $value) {
				# code...
				$modelid = '';
				$modelid = $value['modelid'];
				$content_db->set_model($modelid); 
				$art_array = array();
				$art_array = $content_db->get_content($value['catid'],$value['id']);
				$array = array();
				$array['id'] = $art_array['id'];
				$array['catid'] = $art_array['catid'];
				$array['catname'] = $categorys[$art_array['catid']]['catname'];//栏目名称
				$array['title'] = $art_array['title'];
				$array['shortname'] = $art_array['shortname'];
				
				$array['thumb'] = $art_array['thumb'];
				$array['outhorname'] = $art_array['outhorname'];
				
				$array['description'] = $art_array['description'];
				$array['keywords'] = $art_array['keywords'];
				$array['inputtime'] = $art_array['inputtime'];
				$array['url'] = $art_array['url'];
				switch ($value['modelid']) {
					case '1':
						# code...
						$array['type'] = 'article';
						break;
					case '17':
						# code...
						$array['type'] = 'article';
						break;
					case '19':
						# code...
						$array['type'] = 'article';
						break;
					case '11':
						# code...
						$array['type'] = 'video';
						break;	
					default:
						# code...
						$array['type'] = 'article';
						break;
				}
				
				$array_data[] = $array;
				unset($modelid);
			}
		}

		$return = array();
		$return['code'] = 0;
		$return['message'] = 'Success!';
		$return['data'] = $array_data;
		$return = json_encode($return);
		if($callback){
		echo $callback."($return)";
		}else{
		echo $return;
		}
		exit;

    }





}



?>
