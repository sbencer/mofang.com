<?php

/**
 * [魔方游戏宝 v1] 接口
 * 王官庆  star time: 2013-10-17
 * 相关文章接口
 * 一、get_relation_bykeywords 通过关键词获取相关文章
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
$relation = new relation;
$action = $_SERVER['REQUEST_URI'];
$a = explode('?', $action);
$b = explode('/', $a[0]);
$b_num = count($b); 
$true_action = $b[$b_num-1]; 
if(!method_exists($relation,$true_action)){
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
$relation->$true_action($_GET);

class relation {

	function __construct() { 
    }

    /**
     * 通过关键词获取相关文章
     * 如果关键字不存在，则返回当前模型的最近信息
     */
    function get_relation_bykeywords($get_data) {
    	$catid = intval($get_data['catid']);
    	$keywords = urldecode($get_data['keywords']);
    	$keywords = $keywords ? $keywords : '';
        // $keywords = $get_data['keywords'] ? safe_replace($get_data['keywords']) : '';//关键字
		$page = max(intval($get_data['page']),1);//分页
		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序
		$callback = safe_replace($get_data['callback']);

		$pagesize = $get_data['pagesize'] ? intval($get_data['pagesize']) : 10 ;//每页条数
		$start = ($page-1)*$pagesize; 

		$modelid = intval($get_data['modelid']);

		//从SOLR里获取相关文章
		$search_setting = getcache('search','search');
		$setting = $search_setting[1];
		$solr = pc_base::load_app_class('apache_solr_service', 'search', 0);
		$solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
		//SOLR服务器链接正常
		if($solr->ping()){
			$additionalParameters['sort'] = 'inputtime desc';
		    //只查本数据模型的数据
		    if($modelid!=''){
		    	$fq_modelid = $modelid;
		    	switch ($fq_modelid) {
		    		case 1:
		    			# 新闻
		    			$additionalParameters['fq'][] = "types:news";
		    			break;
		    		case 11:
		    			# 视频模型
		    			$additionalParameters['fq'][] = "types:video";
		    			break;	
		    		case 17:
		    			# 视频游戏评测
		    			$additionalParameters['fq'][] = "types:video";
		    			break;	
		    		case 3:
		    			# 图集
		    			$additionalParameters['fq'][] = "types:picture";
		    			break;	
		    		
		    		default:
		    			# 默认为新闻模型
		    			$additionalParameters['fq'][] = "types:news";
		    			break;
		    	}
		    	// $additionalParameters['fq'][] = "modelid:$fq_modelid";
                $additionalParameters['sort'] = 'inputtime desc';

		    }else{
		    	$additionalParameters['fq'][] = "types:news";
                $additionalParameters['sort'] = 'inputtime desc';
		    }
			$q = '*:*';

		    if(is_array($keywords)){
		    	$additionalParameters['fq'][] = "keywords:{$keywords[0]}"; 
			    foreach ($keywords as $keyword) {
			        $q .= 'keywords:'.$keyword.' OR ';
			    }
			    $q = trim($q, 'OR ')."\n";
		    }elseif ($keywords!='') {
		    	# code...
		    	// $additionalParameters['fq'][] = "keywords:$keywords"; 
			    // $q = "keywords:".$keywords;
			    if($catid){
		    		$additionalParameters['fq'][] = "catid:".$catid;
			    }else{
				    $q = $keywords;
			    }
		    }
		    $result = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
		    if ($result) {
		        $totalnums = (int) $result->response->numFound;
		    }
		    $data = array();
		    foreach ($result->response->docs as $key=> $doc) {
		        foreach ($doc as $field => $value) {
		        	if($field!='content' && $field!='ukid' && $field!='_version_'){
		            	//如果URL字段则增加参数
		            	if($field=='url'){
		            		$now_data[$field] = $value.'?comefrom=mofangapp';
		            	}else{
		            		$now_data[$field] = $value;
		            	}
		        	}
		        }
		        $data[]=$now_data;
		    } 
		}else{
			$return = array();
			$return['code'] = -1;
			$return['message'] = '搜索服务器状态异常!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}

		//循环获取魔方网内部ID 
		$new_array = array();
		$content_db= pc_base::load_model('content_model');
		$content_db->set_model($modelid);

		if(is_array($data) && !empty($data)){
			foreach ($data as $key => $value) {
				# code...
				# 获取评论ID
				$value['commentid'] = get_commentid($value['modelid'],$value['id']);
				
				//视频
				if($modelid==17 || $modelid==11){
					$video_info = $content_db->get_content($value['catid'],$value['id']);
					$value['type'] = 'video';
					$value['video']['letv_id'] = $video_info['letv_id'];
					$value['video']['video_id'] = $video_info['video_id'];
					$value['video']['youkuid'] = $video_info['youkuid'];
					$value['video']['tudou_id'] = $video_info['tudou_id']; 

					$value['video']['playnum'] = get_views("c-".$value['modelid']."-".$value['id']);
					$value['video']['playnum'] = $value['video']['playnum'] + 1000;

					/**
					 * 通过letvid,youkuid,tudouid获取魔方网内部ID
					 */
					if($video_info['video_id']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[letv]=".$video_info['video_id'];
					}
					if($video_info['youkuid']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[youku]=".$video_info['youkuid'];
					}
					if($video_info['tudou_id']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[tudou]=".$video_info['tudou_id'];
					}
					if($get_mofangvid_api!=''){
						$datas = mf_curl_get($get_mofangvid_api);
						$mofangvid_datas = json_decode($datas,true);
						//魔方内部ID，供客户端使用
						$value['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
					}
				}
				//重新把数据赋值给数组
				$new_array[] = $value;
			}
		}

		$return = array();
		$return['code'] = 0;
		$return['message'] = '数据返回正常!';
		$return['data'] = $new_array;
		$return = json_encode($return);
		
		if($callback){
			echo $callback."($return)";
		}else{
			echo $return;
		}
		exit();
		
    }




    /**
     * 通过关键词获取相关文章
     * 如果关键字不存在，则返回当前模型的最近信息
     */
    
    function get_relation_bytype($get_data){
    	$type = $get_data['type'];
    	$type = $type ? $type : 'video'; //默认为视频的相关文章
    	
    	$page = max(intval($get_data['page']),1);//分页
		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序
		$callback = safe_replace($get_data['callback']);

		$pagesize = $get_data['pagesize'] ? intval($get_data['pagesize']) : 10 ;//每页条数
		$start = ($page-1)*$pagesize; 

		$type_array = array("news"=>1,"video"=>17,"picture"=>3);
		$types = array("news","video","picture");
		if(!in_array($type, $types)){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '参数错误!';
			$return['data'] = '';
			$return = json_encode($return); 
			echo $return;
			exit;
		}

		//从SOLR里获取相关文章
		$search_setting = getcache('search','search');
		$setting = $search_setting[1];
		$solr = pc_base::load_app_class('apache_solr_service', 'search', 0);
		$solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);
		//SOLR服务器链接正常
		if($solr->ping()){
			$additionalParameters['sort'] = '_version_ desc';
			$additionalParameters['fq'][] = "types:".$type;
			$q = '*:*';

			$result = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
		    if ($result) {
		        $totalnums = (int) $result->response->numFound;
		    }
		    $data = array();
		    foreach ($result->response->docs as $key=> $doc) {
		        foreach ($doc as $field => $value) {
		        	if($field!='content' && $field!='ukid' && $field!='_version_'){
		            	//如果URL字段则增加参数
		            	if($field=='url'){
		            		$now_data[$field] = $value.'?comefrom=mofangapp';
		            	}else{
		            		$now_data[$field] = $value;
		            	}
		        	}
		        }
		        $data[]=$now_data;
		    } 


		}else{
			$return = array();
			$return['code'] = -1;
			$return['message'] = '搜索服务器状态异常!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}	


		//循环获取魔方网内部ID 
		$new_array = array();
		$content_db= pc_base::load_model('content_model');
		$modelid = $type_array[$type];
		$content_db->set_model($modelid);

		if(is_array($data) && !empty($data)){
			foreach ($data as $key => $value) {
				# code...
				# 获取评论ID
				$value['commentid'] = get_commentid($value['modelid'],$value['id']);
				
				//视频
				if($modelid==17 || $modelid==11){
					$video_info = $content_db->get_content($value['catid'],$value['id']);
					$value['type'] = 'video';
					$value['video']['letv_id'] = $video_info['letv_id'];
					$value['video']['video_id'] = $video_info['video_id'];
					$value['video']['youkuid'] = $video_info['youkuid'];
					$value['video']['tudou_id'] = $video_info['tudou_id']; 

					$value['video']['playnum'] = get_views("c-".$value['modelid']."-".$value['id']);
					$value['video']['playnum'] = $value['video']['playnum'] + 1000;

					/**
					 * 通过letvid,youkuid,tudouid获取魔方网内部ID
					 */
					if($video_info['video_id']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[letv]=".$video_info['video_id'];
					}
					if($video_info['youkuid']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[youku]=".$video_info['youkuid'];
					}
					if($video_info['tudou_id']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[tudou]=".$video_info['tudou_id'];
					}
					if($get_mofangvid_api!=''){
						$datas = mf_curl_get($get_mofangvid_api);
						$mofangvid_datas = json_decode($datas,true);
						//魔方内部ID，供客户端使用
						$value['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
					}
				}
				//重新把数据赋值给数组
				$new_array[] = $value;
			}
		}
		$return = array();
		$return['code'] = 0;
		$return['message'] = '数据返回正常!';
		$return['data'] = $new_array;
		$return = json_encode($return);
		
		echo $return;
		exit();		

    }

}
?>	