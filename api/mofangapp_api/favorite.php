<?php

/**
 * [魔方游戏宝 v1] 接口
 * 王官庆  star time: 2013-10-17
 * 用户收藏文章相关接口
 * 一、 add_favorite 添加收藏 
 * 二、 cancel_favorite 取消收藏
 * 二、 list_favorite 收藏列表
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
$favorite = new favorite;
$action = $_SERVER['REQUEST_URI'];
$a = explode('?', $action);
$b = explode('/', $a[0]);
$b_num = count($b); 
$true_action = $b[$b_num-1]; 
if(!method_exists($favorite,$true_action)){
	$return = array();
	$return['code'] = -1;
	$return['message'] = '此收藏接口不存在，请检查!';
	$return['data'] = '';
	$return = json_encode($return);
	if($callback){
		echo $callback."($return)";
	}else{
		echo $return;
	}
	exit;
}
$favorite->$true_action($_GET);

class favorite {

	function __construct() { 
    }

    /**
     * 增加收藏
     */
    function add_favorite($get_data) {

		$callback = safe_replace($get_data['callback']);

        $partner = safe_replace($get_data['partner']);//合作方标识
		$userid = intval($get_data['userid']);//用户ID  
		$modelid = intval($get_data['modelid']);  //模型ID
		$catid = intval($get_data['catid']);  //栏目ID
		$contentid = intval($get_data['id']);//  内容ID
		$url = $get_data['url'] ? safe_replace($get_data['url']) : 'http://www.mofang.com';//url
		if(!$userid || !$modelid || !$contentid || !$url){
			$return['code'] = -3;
			$return['message'] = '参数错误!';
			$return['data']= '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
		}


		//数据模型
		$app_favorite_db= pc_base::load_model('app_favorite_model');

		//检查是否已经收藏 
		$is_add = $app_favorite_db->get_one(array("userid"=>$userid,"modelid"=>$modelid,"contentid"=>$contentid));
		if($is_add && !empty($is_add)){
			$return['code'] = -2;
			$return['message'] = '已经收藏过!';
			$return['data']= '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
		}


		$array = array();
		$array['userid'] = $userid;
		$array['modelid'] = $modelid;
		$array['catid'] = $catid;
		$array['contentid'] = $contentid;
		$array['inputtime'] = SYS_TIME;
		$array['url'] = $url;
		$favorite_id = $app_favorite_db->insert($array,1);
		 
		$return = array();
		if($favorite_id){
			// 正常入库
			$return['code'] = 0;
			$return['message'] = '收藏成功!';
			
		}else{
			//未正常入库
			$return['code'] = -1;
			$return['message'] = '收藏失败!';
		}
		$return['data']= '';
		$return = json_encode($return);

		if($callback){
			echo $callback."($return)";
		}else{
			echo $return;
		}
		exit();

    }


    /**
     * 取消收藏
     */
    
    function cancel_favorite($get_data){

		$callback = safe_replace($get_data['callback']);

	    $partner = safe_replace($get_data['partner']);//合作方标识
		$userid = intval($get_data['userid']);//用户ID  
		$modelid = intval($get_data['modelid']);  //模型ID
		$contentid = intval($get_data['id']);//  内容ID

		if(!$userid || !$modelid || !$contentid){
			$return['code'] = -2;
			$return['message'] = '参数错误!';
			$return['data']= '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
		}


		//数据模型
		$app_favorite_db= pc_base::load_model('app_favorite_model');

		$array = array();
		$array['userid'] = $userid;
		$array['modelid'] = $modelid;
		$array['contentid'] = $contentid; 

		$app_favorite_db->delete($array);
		 
		$return = array();
		$return['code'] = 0;
		$return['message'] = '取消收藏成功!'; 
		$return['data']= '';
		$return = json_encode($return);

		if($callback){
			echo $callback."($return)";
		}else{
			echo $return;
		}
		exit();
    }



    /**
     * 收藏列表接口
     * 默认为：文章+图片(非视频收藏)，视频收藏需要单独传递modelid=11,17分开 
     */
    function list_favorite($get_data){
    	$partner = safe_replace($get_data['partner']);//合作方标识
		$userid = intval($get_data['userid']);//用户ID  
		$modelid = safe_replace($get_data['modelid']);  //模型ID

		$page = max(intval($get_data['page']),1);//分页
		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序
		$callback = safe_replace($get_data['callback']);
		$pagesize = $get_data['pagesize'] ? intval($get_data['pagesize']) : 10 ;//每页条数

		//参数判断
		if(!$userid ){
			$return['code'] = -2;
			$return['message'] = '参数错误!';
			$return['data']= '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
		}

		//数据模型
		$app_favorite_db= pc_base::load_model('app_favorite_model');
		if($modelid){
			//供查询视频收藏使用
			$where = " `userid`=$userid AND `modelid` in ($modelid)";
		}else{
			//默认显示当前会员所有的收藏 
			$where = array("userid"=>$userid);
			$where = " `userid`=$userid AND `catid`!='' AND `contentid`!='' ";

		}
		$article_array = $app_favorite_db->listinfo($where, 'id desc', $page, $pagesize);
		if(!empty($article_array)){
			$new_array= array();
			$content_db= pc_base::load_model('content_model');

			foreach ($article_array as $key => $value) { 
				$content_db->set_model($value['modelid']);
				// $array = $content_db->get_one(array("id"=>$value['contentid']));
				// 不管什么模型都需要取详情
				$array = $content_db->get_content($value['catid'],$value['contentid']);

				$new_array[$key]['id'] = $value['contentid'];
				$new_array[$key]['catid'] = $array['catid'];
				$new_array[$key]['modelid'] = $value['modelid'] ? intval($value['modelid']) : 1 ;
				$new_array[$key]['title'] = $array['title'];
				$new_array[$key]['shortname'] = $array['shortname'];
				$new_array[$key]['keywords'] = $array['keywords'];

				$new_array[$key]['copyfrom'] = $array['copyfrom']?$array['copyfrom']:'魔方网';
				$new_array[$key]['outhorname'] = $array['outhorname']? $array['outhorname'] : '魔方网';

				$new_array[$key]['description'] = $array['description'];
				$new_array[$key]['thumb'] = $array['thumb'];
				// URL增加comefrom参数，来判断该显示那个模版
				$new_array[$key]['url'] = $array['url'].'?wap=1&comefrom=mofangapp';
				$new_array[$key]['addtime'] = $value['inputtime'];

				/**
				 * 获取文章对应的feed帖子ID + flag(以供后用)，供获取评论使用
				 */
				$falg_feedid = get_commentid_flagid($value['modelid'],$value['contentid']);
				$new_array[$key]['commentid'] = intval($falg_feedid['feedid']);
				$new_array[$key]['flag'] = $falg_feedid['flag'];//通用评论标识 

				//图集类型
				if($value['modelid']==3){
					// $pics_info = $content_db->get_content($value['catid'],$value['id']);
					$array['pictureurls'] = string2array($array['pictureurls']); 
					$new_array[$key]['type'] = 'pics';
					$new_array[$key]['pics'] = $array['pictureurls'];
				}
				//视频类型 11:视频模型  17：视频测评
				if($value['modelid']==17 || $value['modelid']==11){
					// $video_info = $content_db->get_content($value['catid'],$value['id']);
					$new_array[$key]['type'] = 'video';
					$new_array[$key]['video']['video_id'] = $array['video_id'] ? $array['video_id'] : '';//乐视数字ID
					$new_array[$key]['video']['letv_id'] = $array['letv_id'] ? $array['letv_id'] : '';//乐视字符串ID
					$new_array[$key]['video']['youkuid'] = $array['youkuid'] ? $array['youkuid'] : '';
					$new_array[$key]['video']['tudou_id'] = $array['tudou_id'] ? $array['tudou_id'] : '';
					$new_array[$key]['video']['mofang_video_id'] = '';


					$new_array[$key]['video']['playnum'] = get_views("c-".$value['modelid']."-".$array['id']);
					$new_array[$key]['video']['playnum'] = $new_array[$key]['video']['playnum'] + 1000;

					/**
					 * 通过letvid,youkuid,tudouid获取魔方网内部ID
					 */
					$get_mofangvid_api = '';
					if($array['video_id']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[letv]=".$array['video_id'];
					}
					if($array['youkuid']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[youku]=".$array['youkuid'];
					}
					if($array['tudou_id']!=''){
						$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[tudou]=".$array['tudou_id'];
					}
					if($get_mofangvid_api!=''){
						$datas = mf_curl_get($get_mofangvid_api);
						$mofangvid_datas = json_decode($datas,true);
						//魔方内部ID，供客户端使用
						$new_array[$key]['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
						unset($mofangvid_datas);
					}

				}

			}
		}else{
			$new_array = '';
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
     * 详情页获取是否收藏 + 评论数
     */
    
    function get_isfavorite_commentdnum($get_data){
    	$userid = intval($get_data['userid']);
    	$commentid = intval($get_data['commentid']);
    	$modelid = intval($get_data['modelid']);//当前文章的模型ID
    	$contentid = intval($get_data['id']);//文章ID
		$callback = safe_replace($get_data['callback']);

		//参数判断
		if(!$userid || !$modelid || !$contentid){
			$return['code'] = -2;
			$return['message'] = '参数错误!';
			$return['data']= '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
		}


    	$array = array();
    	if($commentid){
    		$array['commentnum'] = get_feed_commentnum($commentid);
    	}else{
    		$array['commentnum'] = 0;
    	}

    	if($userid && $contentid && $modelid){
    		$array['is_favorite'] = get_is_favorite($userid,$modelid,$contentid);//获取是收否收藏
    	}else{
    		$array['is_favorite'] = 0;
    	}

    	$array['userid'] = intval($userid);
    	$array['modelid'] = intval($modelid);
    	$array['id'] = intval($id);
    	$array['commentid'] = $commentid;


    	$return['code'] = 0;
		$return['message'] = '数据返回正常!';
		$return['data'] = $array;
		$return = json_encode($return);

		
		if($callback){
			echo $callback."($return)";
		}else{
			echo $return;
		}
		exit();


    }

}
?>	