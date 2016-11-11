<?php

/**
 * [魔方游戏宝 v1] 接口
 * 王官庆  star time: 2015-4-15
 * 获取主站相关文章的接口
 * 一、 get_article_bychannelid 根据频道ID获取文章列表 
 * 二、 get_article_byids 根据ids获取文章列表
 * 三、 get_articleinfo_byid 根据ID、modelid获取文章详情
 * 四、 get_fenlei_bychannelid 通过channelid 循环对应的栏目，并调取栏目下几条信息（使用位置参考视频首页）
 * 五、 get_refined_bychannelid 精选数据接口
 */

defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
$article = new article;
$action = $_SERVER['REQUEST_URI'];
$a = explode('?', $action);
$b = explode('/', $a[0]);
$b_num = count($b); 
$true_action = $b[$b_num-1]; 
if(!method_exists($article,$true_action)){
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
$article->$true_action($_GET);

class article {

	function __construct() { 
    }

    /**
     * 根据频道ID获取文章列表 
     */
    function get_article_bychannelid($get_data) {
        $channelid = intval($get_data['channelid']);//频道ID
		$page = max(intval($get_data['page']),1);//分页
		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序
		$callback = safe_replace($get_data['callback']);
		$pagesize = $get_data['pagesize'] ? intval($get_data['pagesize']) : 30 ;//每页条数

		if(!$channelid){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '输入参数异常!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}


		//获取当前频道对应的数据模型,及IDS
		$app_channel_db= pc_base::load_model('app_channel_model');
		$channel_array = $app_channel_db->get_one(array("id"=>$channelid),'*');
		if(!$channel_array || empty($channel_array)){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '频道ID不存在!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}

		//读memcached缓存
		$game_search = 'mofangapp_channelid_'.$channelid;
		$game_search_key = sha1($game_search);
		$game_search_key .= '_'.$page;
		if(!$new_array = getcache($game_search_key, '', 'memcache', 'html')) { 
			$ordertype_array = array("inputtime desc","listorder asc");
			//定义文章数组
			$article_array = array(); 
			$content_db= pc_base::load_model('content_model');
			$content_db->set_model($channel_array['modelid']);	

			//频道对应的栏目ID集合
			$ids = $channel_array['ids'];
			$where = " `catid` in ($ids) AND status=99";

			$article_array = $content_db->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);

			if(!empty($article_array)){
				$new_array= array();
				$type_array = array("1"=>'article',"11"=>'video',"17"=>'video',"3"=>'pics');//模型ID对应的英文标识
				foreach ($article_array as $key => $value) {
					# code...
					$new_array[$key]['id'] = $value['id'];
					$new_array[$key]['catid'] = $value['catid'];
					$new_array[$key]['modelid'] = $channel_array['modelid'];
					$new_array[$key]['title'] = $value['title'];
					$new_array[$key]['shortname'] = $value['shortname'];

					$new_array[$key]['gameid'] = get_relation_game($value['id'],$channel_array['modelid']);//关联游戏
					$new_array[$key]['keywords'] = $value['keywords'] ? $value['keywords'] : '';
					$new_array[$key]['copyfrom'] = $value['copyfrom'] ? $value['copyfrom'] : '魔方网';
					$new_array[$key]['outhorname'] = $value['outhorname'] ? $value['outhorname'] : '魔方网';
					$new_array[$key]['thumb'] = $value['thumb'] ? $value['thumb'] : '';
					// URL增加comefrom参数，来判断该显示那个模版
					$new_array[$key]['url'] = $value['url'].'?wap=1&comefrom=mofangapp';
					$new_array[$key]['description'] = $value['description'];
					$new_array[$key]['addtime'] = $value['inputtime'];

					/**
					 * 获取文章对应的feed帖子ID + flag(以供后用)，供获取评论使用
					 */
					$falg_feedid = get_commentid_flagid($channel_array['modelid'],$value['id']);
					$new_array[$key]['commentid'] = intval($falg_feedid['feedid']);
					$new_array[$key]['flag'] = $falg_feedid['flag'];//通用评论标识
					

					//普通文章
					if($channel_array['modelid']==1 || $channel_array['modelid']==19){
						$new_array[$key]['type'] = 'article';
					}

					//图集类型
					if($channel_array['modelid']==3){
						$pics_info = $content_db->get_content($value['catid'],$value['id']);
						$pics_info['pictureurls'] = string2array($pics_info['pictureurls']); 
						$new_array[$key]['type'] = 'pics';
						$new_array[$key]['pics'] = $pics_info['pictureurls'];
					}
					//视频类型 11:视频模型  17：视频测评
					if($channel_array['modelid']==17 || $channel_array['modelid']==11){
						$video_info = $content_db->get_content($value['catid'],$value['id']);
						$new_array[$key]['type'] = 'video';
						$new_array[$key]['video']['video_id'] = $video_info['video_id'] ? $video_info['video_id'] : '';//乐视数字ID
						$new_array[$key]['video']['letv_id'] = $video_info['letv_id'] ? $video_info['letv_id'] : '';//乐视字符串ID
						$new_array[$key]['video']['youkuid'] = $video_info['youkuid'] ? $video_info['youkuid'] : '';
						$new_array[$key]['video']['tudou_id'] = $video_info['tudou_id'] ? $video_info['tudou_id'] : '';
						$new_array[$key]['video']['mofang_video_id'] = '';

						$new_array[$key]['video']['playnum'] = get_views("c-".$channel_array['modelid']."-".$value['id']);
						$new_array[$key]['video']['playnum'] = $new_array[$key]['video']['playnum'] + 1000;

						/**
						 * 通过letvid,youkuid,tudouid获取魔方网内部ID
						 */
						$get_mofangvid_api = '';
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
							$new_array[$key]['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
							unset($mofangvid_datas);
						}

					}

				}
			}else{
				// 未查出来文章
				$new_array = '';
			}
			//5分钟缓存
			setcache($game_search_key, $new_array, '', 'memcache', 'html', 600);
		}else{
			$new_array = getcache($game_search_key, '', 'memcache', 'html');
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
     * 根据栏目ids获取文章列表（支持同模型，多栏目查询）
     * 说明：此接口需要modelid，并且catids为同一数据模型
     */
    
    function get_article_byids($get_data){
    	$ids = safe_replace($get_data['ids']);//频道对应的栏目ID
		$page = max(intval($get_data['page']),1);//分页
		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序
		$modelid = intval($get_data['modelid']);//模型ID
		$callback = safe_replace($get_data['callback']);
		$pagesize = $get_data['pagesize'] ? intval($get_data['pagesize']) : 30 ;//每页条数

		if(!$ids || !$modelid){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '输入参数异常!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}

		//判断是否按系统显示
		if($get_data['needsystem']!=''){
			//获取请求来源的系统信息，按系统返回不同的数据
			//androidd:安卓  ios:苹果
			$true_atom = parse_str_new($get_data['atom']);
			$system = $true_atom['pf'];
		}


		$ordertype_array = array("inputtime desc","listorder asc");
		//定义文章数组
		$article_array = array(); 
		$content_db= pc_base::load_model('content_model');
		$content_db->set_model($modelid);	

		//频道对应的栏目ID集合
		$where = " `catid` in ($ids) AND status=99";

		$article_array = $content_db->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);

		if(!empty($article_array)){
			$new_array= array();
			$type_array = array("1"=>'article',"11"=>'video',"17"=>'video',"3"=>'pics');//模型ID对应的英文标识
			foreach ($article_array as $key => $value) {
				# code...

				//只显示当前系统需要的数据
				// 精选轮播图，使用keywords字段来标识是何平台
				if($system!='' && in_array($system, array("android","ios","all"))){
					$desc = str_replace(" ","",$value['keywords']);
					if($desc =='' || $desc=='all' || $desc == $system){

					}else{
						continue;
					}
				}

				$new_array[$key]['id'] = $value['id'];
				$new_array[$key]['catid'] = $value['catid'];
				$new_array[$key]['modelid'] = $modelid;
				$new_array[$key]['title'] = $value['title'];
				$new_array[$key]['shortname'] = $value['shortname'];

				$new_array[$key]['gameid'] = get_relation_game($value['id'],$modelid);//关联游戏
				$new_array[$key]['keywords'] = $value['keywords'] ? $value['keywords']:'魔方网';
				$new_array[$key]['copyfrom'] = $value['copyfrom']?$value['copyfrom']:'魔方网';
				$new_array[$key]['outhorname'] = $value['outhorname']? $value['outhorname'] : '魔方网';
				$new_array[$key]['thumb'] = $value['thumb'];
				// URL增加comefrom参数，来判断该显示那个模版
				if($value['islink']==1){
					$new_array[$key]['url'] = $value['url'];//外链不再拼接wap=1&comefrom=2之类的
				}else{
					$new_array[$key]['url'] = $value['url'].'?wap=1&comefrom=mofangapp';
				}
				$new_array[$key]['url'] = $value['url'].'?wap=1&comefrom=mofangapp';
				$new_array[$key]['description'] = $value['description'];
				$new_array[$key]['addtime'] = $value['inputtime'];

				/**
				 * 获取文章对应的feed帖子ID + flag(以供后用)，供获取评论使用
				 */
				$falg_feedid = get_commentid_flagid($modelid,$value['id']);
				$new_array[$key]['commentid'] = intval($falg_feedid['feedid']);
				$new_array[$key]['flag'] = $falg_feedid['flag'];//通用评论标识   

				//普通文章
				if($modelid==1 || $modelid==19){
					$new_array[$key]['type'] = 'article';
				}

				//图集类型
				if($modelid==3){
					$pics_info = $content_db->get_content($value['catid'],$value['id']);
					$pics_info['pictureurls'] = string2array($pics_info['pictureurls']); 
					$new_array[$key]['type'] = 'pics';
					$new_array[$key]['pics'] = $pics_info['pictureurls'];
				}
				//视频类型(11：视频模型  17： 视频评测)
				if($modelid==17 || $modelid==11){
					$video_info = $content_db->get_content($value['catid'],$value['id']);
					$new_array[$key]['type'] = 'video';
					$new_array[$key]['video']['video_id'] = $video_info['video_id'] ? $video_info['video_id'] : '';//乐视数字ID
					$new_array[$key]['video']['letv_id'] = $video_info['letv_id'] ? $video_info['letv_id'] : '';//乐视字符串ID
					$new_array[$key]['video']['youkuid'] = $video_info['youkuid'] ? $video_info['youkuid'] : '';
					$new_array[$key]['video']['tudou_id'] = $video_info['tudou_id'] ? $video_info['tudou_id'] : '';
					$new_array[$key]['video']['mofang_video_id'] = '';

					$new_array[$key]['video']['playnum'] = get_views("c-".$modelid."-".$value['id']);
					$new_array[$key]['video']['playnum'] = $new_array[$key]['video']['playnum'] + 1000;


					/**
					 * 通过letvid,youkuid,tudouid获取魔方网内部ID
					 */
					$get_mofangvid_api = '';
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
						$new_array[$key]['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
						unset($mofangvid_datas);
					}

				}

			}
		}
		$new_array = array_values($new_array);
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
     * 通过channelid 循环对应的栏目，并调取栏目下几条信息（使用位置参考视频首页）
     */
    function get_fenlei_bychannelid($get_data){
    	$channelid = intval($get_data['channelid']);//频道ID 
		$page = max(intval($get_data['page']),1);//分页
		$pagesize = max(intval($get_data['pagesize']),8);//每个栏目取多少数据
		$callback = $get_data['callback'];//回调函数

		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序

		//模型ID  和 频道ID都不能为空 
		if(!$channelid){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '频道栏目不能为空!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}


		//获取当前频道对应的数据模型,及IDS
		$app_channel_db= pc_base::load_model('app_channel_model');
		$channel_array = $app_channel_db->get_one(array("id"=>$channelid),'*');
		if(!$channel_array || empty($channel_array)){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '频道ID不存在!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}


		//读memcached缓存
		$game_search = 'mofangapp_get_fenlei_bychannelid_'.$channelid;
		$game_search_key = sha1($game_search);
		// $game_search_key .= '_'.$page;
		if($get_data['do_cache']!='' || !$array = getcache($game_search_key, '', 'memcache', 'html')) {
			$ordertype_array = array("inputtime desc","listorder asc");
			$ids = explode(',', $channel_array['ids']);


			//定义文章数组
			$article_array = array(); 
			$array = array();

			//需要使用的数据模型
			$content_db= pc_base::load_model('content_model');
			$category_db= pc_base::load_model('category_model');

			// $content_db->set_model($modelid);	

			//循环配置栏目的数据 
			foreach ($ids as $key => $value) {
				# code...
				if($value==''){
					continue;
				}
				$category_array = array();
				$category_array = $category_db->get_one(array("catid"=>$value),'*');
				/**
				 * 如果栏目不存在，退出本次循环 继续其它
				 */
				if(empty($category_array)){
					continue;
				}
				$content_db->set_model($category_array['modelid']);
				
				$where = array("catid"=>$value,"status"=>99);
				$article_array = $content_db->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);
				

				if(!empty($article_array)){
					$new_array = array();
					foreach ($article_array as $key => $art_value) {
						$new_array[$key]['id'] = $art_value['id'];
						$new_array[$key]['catid'] = $art_value['catid'];
						$new_array[$key]['modelid'] = $category_array['modelid'];
						$new_array[$key]['title'] = $art_value['title'];
						$new_array[$key]['shortname'] = $art_value['shortname'];
	 
						$new_array[$key]['gameid'] = get_relation_game($art_value['id'],$category_array['modelid']);//关联游戏

						$new_array[$key]['keywords'] = $art_value['keywords'];
						$new_array[$key]['copyfrom'] = $art_value['copyfrom']?$art_value['copyfrom'] : '魔方网';
						$new_array[$key]['outhorname'] = $art_value['outhorname']? $art_value['outhorname'] : '魔方网';
						$new_array[$key]['thumb'] = $art_value['thumb'];
						$new_array[$key]['url'] = $art_value['url'].'?wap=1&comefrom=mofangapp';
						$new_array[$key]['description'] = $art_value['description'];
						$new_array[$key]['addtime'] = $art_value['inputtime'];

						/**
						 * 获取文章对应的feed帖子ID + flag(以供后用)，供获取评论使用
						 */
						$falg_feedid = get_commentid_flagid($category_array['modelid'],$art_value['id']);
						$new_array[$key]['commentid'] = intval($falg_feedid['feedid']);
						$new_array[$key]['flag'] = $falg_feedid['flag'];//通用评论标识  

						//普通文章
						if($category_array['modelid']==1 || $category_array['modelid']==19){
							$new_array[$key]['type'] = 'article';
						}

						//图集类型
						if($category_array['modelid']==3){
							$pics_info = $content_db->get_content($art_value['catid'],$art_value['id']);

							$pics_info['pictureurls'] = string2array($pics_info['pictureurls']); 
							$new_array[$key]['type'] = 'pics';
							$new_array[$key]['pics'] = $pics_info['pictureurls'];
						}

						//视频类型
						if($category_array['modelid']==11 || $category_array['modelid']==17){
							$video_info = $content_db->get_content($art_value['catid'],$art_value['id']);
							$new_array[$key]['type'] = 'video';
							$new_array[$key]['video']['video_id'] = $video_info['video_id'];//乐视数字ID
							$new_array[$key]['video']['letv_id'] = $video_info['letv_id'];//乐视字符串ID
							$new_array[$key]['video']['youkuid'] = $video_info['youkuid'];
							$new_array[$key]['video']['tudou_id'] = $video_info['tudou_id'];
							$new_array[$key]['video']['mofang_video_id'] = '';
							// $new_array[$key]['video']['playnum'] = rand(200,3000);
							$new_array[$key]['video']['playnum'] = get_views("c-".$category_array['modelid']."-".$art_value['id']);
							$new_array[$key]['video']['playnum'] = $new_array[$key]['video']['playnum'] + 1000;


							/**
							 * 通过letvid,youkuid,tudouid获取魔方网内部ID
							 */
							$get_mofangvid_api = '';
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
								$new_array[$key]['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
								unset($mofangvid_datas);
							}
						}

					}

				}
				$unin_array['catname'] = $category_array['catname'];
				$unin_array['catid'] = $category_array['catid'];
				$unin_array['modelid'] = $category_array['modelid'];
				$unin_array['data'] = $new_array;

				$array['articlelist'][] = $unin_array;

			}

			//第一页时，获取频道对应轮播图数据
			if($channel_array['banner']!='' && $page==1){
				$array['banner'] = $this->get_articlelist_byid($channel_array['banner'],1,10);
			}
			//设置5分钟的缓存
			setcache($game_search_key, $array, '', 'memcache', 'html', 600);
		}else{
			$array = getcache($game_search_key, '', 'memcache', 'html');
		}

		
		
		$return = array();
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


    



    /**
     * 通过catid，获取对栏目的文章列表，返回Array格式数据
     * 类内部自调用，非对外接口 
     */
    function get_articlelist_byid($catid,$page=1,$pagesize=30,$check_system = 'all'){
    	$catid = intval($catid);
    	$pagesize = intval($pagesize);
    	$page = intval($page);

    	if(!$catid){
    		return '';exit;
    	}

    	//需要使用的数据模型
		$content_db= pc_base::load_model('content_model');
		$category_db= pc_base::load_model('category_model');

		$category_array = $category_db->get_one(array("catid"=>$catid),'*');
		/**
		 * 如果栏目不存在，退出本次循环 继续其它
		 */
		if(empty($category_array)){
			return '' ;exit;
		}
		$content_db->set_model($category_array['modelid']);

		$where = array("catid"=>$catid,"status"=>99);
		$article_array = $content_db->listinfo($where, 'listorder asc,inputtime desc', $page, $pagesize);
			

		if(!empty($article_array)){
			$new_array = array();
			foreach ($article_array as $key => $art_value) {
				//只显示当前系统需要的数据
				// 精选轮播图，使用keywords字段来标识是何平台
				if($check_system!='all' && in_array($check_system, array("android","ios","all"))){
					$desc = str_replace(" ","",$art_value['keywords']);
					//拆分字符分析
					$desc_array = explode('|', $desc);
					if($desc_array[0] =='' || $desc_array[0]=='all' || $desc_array[0] == $check_system){
						if($desc_array[1] && $desc_array[1]!=''){
							$target = $desc_array[1];
						}else{
							$target = '0';
						}
					}else{
						continue;
					}
				}
				$new_array[$key]['is_browser'] = $target ;//原生打开，还是浏览器打开1:原生 2：浏览器打开 


				$new_array[$key]['id'] = $art_value['id'];
				$new_array[$key]['catid'] = $art_value['catid'];
				$new_array[$key]['modelid'] = $category_array['modelid'];
				$new_array[$key]['title'] = $art_value['title'];
				$new_array[$key]['shortname'] = $art_value['shortname'];

				$new_array[$key]['gameid'] = get_relation_game($category_array['modelid'],$art_value['id']);//关联游戏
				$new_array[$key]['keywords'] = $art_value['keywords'];
				$new_array[$key]['copyfrom'] = $art_value['copyfrom']?$art_value['copyfrom']:'魔方网';
				$new_array[$key]['outhorname'] = $art_value['outhorname'] ? $art_value['outhorname'] : '魔方网';
				$new_array[$key]['thumb'] = $art_value['thumb'];
				//如果链接中存在share.mofang.com 则不进行URL转换 
				if(strpos($art_value['url'], 'share.mofang.com') || strpos($art_value['url'], 'share.test.mofang.com')){
					$new_array[$key]['url'] = $art_value['url'];

				}else{
					$new_array[$key]['url'] = $art_value['url'].'?wap=1&comefrom=mofangapp';
				}
				$new_array[$key]['description'] = $art_value['description'];
				$new_array[$key]['addtime'] = $art_value['inputtime'];

				/**
				 * 获取文章对应的feed帖子ID + flag(以供后用)，供获取评论使用
				 */
				$falg_feedid = get_commentid_flagid($category_array['modelid'],$art_value['id']);
				$new_array[$key]['commentid'] = intval($falg_feedid['feedid']);
				$new_array[$key]['flag'] = $falg_feedid['flag'];//通用评论标识 

				//普通文章
				if($category_array['modelid']==1 || $category_array['modelid']==19){
					$new_array[$key]['type'] = 'article';
				}

				//图集类型
				if($category_array['modelid']==3){
					$pics_info = $content_db->get_content($art_value['catid'],$art_value['id']);
					$pics_info['pictureurls'] = string2array($pics_info['pictureurls']); 
					$new_array[$key]['type'] = 'pics';
					$new_array[$key]['pics'] = $pics_info['pictureurls']; 
				}

				//视频类型
				if($category_array['modelid']==11 || $category_array['modelid']==17){
					$video_info = $content_db->get_content($art_value['catid'],$art_value['id']);
					$new_array[$key]['type'] = 'video';
					$new_array[$key]['video']['video_id'] = $video_info['video_id'];//乐视数字ID
					$new_array[$key]['video']['letv_id'] = $video_info['letv_id'];//乐视字符串ID
					$new_array[$key]['video']['youkuid'] = $video_info['youkuid'];
					$new_array[$key]['video']['tudou_id'] = $video_info['tudou_id'];
					$new_array[$key]['video']['mofang_video_id'] = '';
					// $new_array[$key]['video']['playnum'] = rand(200,3000);

					$new_array[$key]['video']['playnum'] = get_views("c-".$category_array['modelid']."-".$art_value['id']);
					$new_array[$key]['video']['playnum'] = $new_array[$key]['video']['playnum'] + 1000;

					/**
					 * 通过letvid,youkuid,tudouid获取魔方网内部ID
					 */
					$get_mofangvid_api = '';
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
						$new_array[$key]['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
						unset($mofangvid_datas);
					}
					
				}
			}
			//重新对数组进行索引，去除中间的断层
			$new_array = array_values($new_array);
			return $new_array;

		}else{
			return '';
		}

    }



    /**
     * 精选数据接口 （含轮播图数据）
     */ 
    function get_refined_bychannelid($get_data) {
        $channelid = intval($get_data['channelid']);//频道ID
        $page = max(intval($get_data['page']),1);//分页
		$ordertype = $get_data['ordertype'] ? intval($get_data['ordertype']) :  0;//排序
		$callback = safe_replace($get_data['callback']);
		$pagesize = $get_data['pagesize'] ? intval($get_data['pagesize']) : 30 ;//每页条数

		//获取当前频道对应的数据模型,及IDS
		$app_channel_db= pc_base::load_model('app_channel_model');
		$channel_array = $app_channel_db->get_one(array("id"=>$channelid),'*');
		if(!$channel_array || empty($channel_array)){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '频道ID不存!';
			$return['data'] = '';
			$return = json_encode($return);
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit;
		}

		//获取请求来源的系统信息，按系统返回不同的数据
		//androidd:安卓  ios:苹果
		$true_atom = parse_str_new($get_data['atom']);
		$system = $true_atom['pf'];

		//读memcached缓存
		$game_search = 'mofangapp_refined_'.$channelid."_".$system;
		$game_search_key = sha1($game_search);
		$game_search_key .= '_'.$page."_".$pagesize;
		if($get_data['do_cache']!='' || !$array = getcache($game_search_key, '', 'memcache', 'html')) {
			$ordertype_array = array("listorder desc,timeing desc","listorder desc,id desc","inputtime desc");
			//定义数据模型
			$app_refined_db= pc_base::load_model('app_refined_model');
			$content_db= pc_base::load_model('content_model');
			$where = " `status`=99 AND (`system`='".$system."' or `system`='all' )";

			// 获取精选数据列表
			$article_array = array(); 
			$article_array = $app_refined_db->listinfo($where, $ordertype_array[$ordertype], $page, $pagesize);

			if(!empty($article_array)){
				$new_array= array();
				foreach ($article_array as $key => $value) {
					# code...
					$new_array[$key]['id'] = $value['contentid'];
					$new_array[$key]['catid'] = $value['catid'];
					$new_array[$key]['modelid'] = $value['modelid'];
					$new_array[$key]['title'] = $value['title'];
					$new_array[$key]['shortname'] = $value['shortname'];
					$new_array[$key]['description'] = $value['description'];

					$new_array[$key]['gameid'] = get_relation_game($value['modelid'],$value['contentid']);//关联游戏

					
					// 自定义的标签
					$new_array[$key]['tag'] = $value['tag'];
					$new_array[$key]['thumb'] = $value['thumb'];
					// URL增加comefrom参数，来判断该显示那个模版
					$new_array[$key]['url'] = $value['url'].'?wap=1&comefrom=mofangapp';
					$new_array[$key]['addtime'] = $value['inputtime']; 

					/**
					 * 获取文章对应的feed帖子ID + flag(以供后用)，供获取评论使用
					 */
					$falg_feedid = get_commentid_flagid($value['modelid'],$value['contentid']);
					$new_array[$key]['commentid'] = intval($falg_feedid['feedid']);
					$new_array[$key]['flag'] = $falg_feedid['flag'];//通用评论标识



					//获取文章的其它详情资料
					$content_db->set_model($value['modelid']);
					$art_info = $content_db->get_content($value['catid'],$value['contentid']);

					$new_array[$key]['keywords'] = $art_info['keywords'] ? $art_info['keywords'] : '';
					$new_array[$key]['copyfrom'] = $art_info['copyfrom'] ? $art_info['copyfrom'] : '魔方网';
					$new_array[$key]['outhorname'] = $art_info['outhorname']? $art_info['outhorname'] :'魔方网';
					//图集类型
					if($value['modelid']==3){
						
						$pics_info['pictureurls'] = string2array($art_info['pictureurls']); 
						$new_array[$key]['type'] = 'pics';
						$new_array[$key]['pics'] = $pics_info['pictureurls'];
						
					}elseif($value['modelid']==17 || $value['modelid']==11){
						// $video_info = $content_db->get_content($value['catid'],$value['id']);
						$new_array[$key]['type'] = 'video';
						$new_array[$key]['video']['video_id'] = $art_info['video_id'] ? $art_info['video_id'] : '';//乐视数字ID
						$new_array[$key]['video']['letv_id'] = $art_info['letv_id'] ? $art_info['letv_id'] : '';//乐视字符串ID
						$new_array[$key]['video']['youkuid'] = $art_info['youkuid'] ? $art_info['youkuid'] : '';
						$new_array[$key]['video']['tudou_id'] = $art_info['tudou_id'] ? $art_info['tudou_id'] : '';
						$new_array[$key]['video']['mofang_video_id'] = '';
						$new_array[$key]['video']['playnum'] = rand(200,3000);
						

						/**
						 * 通过letvid,youkuid,tudouid获取魔方网内部ID
						 */
						$get_mofangvid_api = '';
						if($art_info['video_id']!=''){
							$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[letv]=".$art_info['video_id'];
						}
						if($art_info['youkuid']!=''){
							$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[youku]=".$art_info['youkuid'];
						}
						if($art_info['tudou_id']!=''){
							$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[tudou]=".$art_info['tudou_id'];
						}
						if($get_mofangvid_api!=''){
							$datas = mf_curl_get($get_mofangvid_api);
							$mofangvid_datas = json_decode($datas,true);
							//魔方内部ID，供客户端使用
							$new_array[$key]['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
							unset($mofangvid_datas);
						}


					}elseif($value['modelid']==33){
						//广告位模型
						$new_array[$key]['type'] = 'banner';
					}else{
						//默认为文章模型（包含广告等）
						$new_array[$key]['type'] = 'article';
					}
				}
			}else{
				$new_array = '';
			}

			$array['articlelist'] = $new_array;

			if($channel_array['banner']!='' && $page==1){
				//获取频道对应轮播图数据 , 按系统来返回数据（分安卓和IOS）
				$array['banner'] = $this->get_articlelist_byid($channel_array['banner'],1,10,$system);
			}
			//5分钟缓存
			setcache($game_search_key, $array, '', 'memcache', 'html', 600);
		}else{
			$array = getcache($game_search_key, '', 'memcache', 'html');
		} 
		

		$return = array();
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


	/**
     * 根据ID、modelid获取文章详情
     */
    function get_articleinfo_byid($get_data){

    	$modelid = intval($get_data['modelid']);//频道ID
    	$id = intval($get_data['id']);//频道ID
    	$callback = safe_replace($get_data['callback']);//返回函数

    	$return = array();

    	if($modelid=='' || $id ==''){
			$return['code'] = -1;
			$return['message'] = '参数错误!';
			$return['data'] = '';
			$return = json_encode($return);
			
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
    	}
    	$content_db= pc_base::load_model('content_model');
		$where = " status=99";

		//获取文章的其它详情资料
		$array = array();
		$content_db->set_model($modelid);
		$array = $content_db->get_one(array("id"=>$id,"status"=>99),'id,catid,title,status');
		if(!$array || empty($array)){
			$return = array();
			$return['code'] = -1;
			$return['message'] = '未取到正常数据!';
			$return['data'] = '';
			$return = json_encode($return);
			
			if($callback){
				echo $callback."($return)";
			}else{
				echo $return;
			}
			exit();
		}
		$art_value = $content_db->get_content($array['catid'],$array['id']);

		$new_array = array();

		$new_array['id'] = $art_value['id'];
		$new_array['catid'] = $art_value['catid'];
		$new_array['modelid'] = $modelid;
		$new_array['title'] = $art_value['title'];
		$new_array['shortname'] = $art_value['shortname'];

		$new_array['gameid'] = get_relation_game($modelid,$art_value['id']);//关联游戏
		$new_array['keywords'] = $art_value['keywords'];
		$new_array['copyfrom'] = $art_value['copyfrom']? $art_value['copyfrom'] : '魔方网';
		$new_array['outhorname'] = $art_value['outhorname']?$art_value['outhorname'] : '魔方网';
		$new_array['thumb'] = $art_value['thumb'];
		$new_array['url'] = $art_value['url'].'?wap=1&comefrom=mofangapp';
		$new_array['description'] = $art_value['description'];
		$new_array['addtime'] = $art_value['inputtime'];
		/**
		 * 获取文章对应的feed帖子ID + flag(以供后用)，供获取评论使用
		 */
		$falg_feedid = get_commentid_flagid($modelid,$art_value['id']);
		$new_array[$key]['commentid'] = intval($falg_feedid['feedid']);
		$new_array[$key]['flag'] = $falg_feedid['flag'];//通用评论标识

		//普通文章
		if($modelid==1 || $modelid==19){
			$new_array['type'] = 'article';
		}

		//图集类型
		if($modelid==3){
			// $pics_info = $content_db->get_content($art_value['catid'],$art_value['id']);
			$pics_info['pictureurls'] = string2array($art_value['pictureurls']); 
			$new_array['type'] = 'pics';
			$new_array['pics'] = $pics_info['pictureurls']; 
		}

		//视频类型
		if($modelid==11 || $modelid==17){
			// $video_info = $content_db->get_content($art_value['catid'],$art_value['id']);
			$new_array['type'] = 'video';
			$new_array['video']['video_id'] = $art_value['video_id'];//乐视数字ID
			$new_array['video']['letv_id'] = $art_value['letv_id'];//乐视字符串ID
			$new_array['video']['youkuid'] = $art_value['youkuid'];
			$new_array['video']['tudou_id'] = $art_value['tudou_id'];
			$new_array['video']['mofang_video_id'] = '';
			$new_array['video']['playnum'] = rand(200,3000);

			/**
			 * 通过letvid,youkuid,tudouid获取魔方网内部ID
			 */
			$get_mofangvid_api = '';
			if($art_value['video_id']!=''){
				$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[letv]=".$art_value['video_id'];
			}
			if($art_value['youkuid']!=''){
				$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[youku]=".$art_value['youkuid'];
			}
			if($art_value['tudou_id']!=''){
				$get_mofangvid_api = "http://video.admin.mofang.com/api/getVideoId?video_ids[tudou]=".$art_value['tudou_id'];
			}
			if($get_mofangvid_api!=''){
				$datas = mf_curl_get($get_mofangvid_api);
				$mofangvid_datas = json_decode($datas,true);
				//魔方内部ID，供客户端使用
				$new_array['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
				unset($mofangvid_datas);
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

    /*获取视频轮播图的数据接口*/
    function get_videobanner($get_data){
    	//获取请求来源的系统信息，按系统返回不同的数据
		//androidd:安卓  ios:苹果
		$true_atom = parse_str_new($get_data['atom']);
		$system = $true_atom['pf'];
		$data = $this->get_articlelist_byid(1522,1,10,$system);

		$return = array();
		$return['code'] = 0;
		$return['message'] = '数据返回正常!';
		$return['data'] = $data;
		$return = json_encode($return);
		$callback = isset($get_data['jsonpcallback']) ? trim($get_data['jsonpcallback']) : ( isset($get_data['callback']) ? trim($get_data['callback']) : "" );
		if($callback){
			echo $callback."($return)";
		}else{
			echo $return;
		}
		exit();
    }





}
?>	
