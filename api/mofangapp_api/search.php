<?php
defined('IN_PHPCMS') or exit('No permission resources.');
header('Content-Type: application/json');

/**
 * 游戏宝搜索接口＋热词返回
 * @author Jozh liu
 * 2015/09/12015/09/15
 */
class mofangapi {
    function __construct() {
        $this->q = safe_replace(trim($_GET['q']));
        $this->q = htmlspecialchars(strip_tags($this->q));
        $this->q = str_replace('%', '', $this->q); // 过滤'%'，用户全文搜索
        // $this->q = str_replace(" ", '', $this->q); // 空格替换为空

        $this->not_q = preg_match("/\d{6}/i", $this->q); // 如果里面包含超过6位数字，则认为是广告，直接返回！
        $this->keyword = substr($this->q, 0, 60); // 截取关键字 @数据表长度所困@

        // $ctag = pc_base::load_app_class('content_tag', 'content');
        // $this->solr = $ctag->check_solr(); // 加载solr
        $type_arr =  array('1'=>'news', '2'=>'video');
        $this->type = $type_arr[$_GET['type']] ? : 'news';
    }
    function lists() {
        if (!$this->q || $this->not_q) return array('code'=>1, 'message'=>'检查一下关键字，拼写是否正确！');

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = intval($_GET['pagesize'])?:10;
        $start = ($page-1)*$pagesize;
        $result = array();

        pc_base::load_app_func('global','search'); // 加载search模块global方法库
        $result = get_search_solr($this->q, $this->type, '', array('page'=>$page, 'pagesize'=>$pagesize));

        $data = $result['data'] ? : array();

		if(is_array($data) && !empty($data)){
            $content_db = pc_base::load_model('content_model'); // 加载数据模型
			foreach ($data as $key => $val) {
				// 获取评论ID
				$val['commentid'] = get_commentid($val['modelid'],$val['id']);

				// 视频
				if($val['modelid']==17 || $val['modelid']==11){
                    $content_db->set_model($val['modelid']);
					$video_info = $content_db->get_content($val['catid'],$val['id']);
					$val['type'] = 'video';
					$val['video']['letv_id'] = $video_info['letv_id'];
					$val['video']['video_id'] = $video_info['video_id'];
					$val['video']['youkuid'] = $video_info['youkuid'];
					$val['video']['tudou_id'] = $video_info['tudou_id'];

					$val['video']['playnum'] = get_views("c-".$val['modelid']."-".$val['id']);
					$val['video']['playnum'] = $val['video']['playnum'] + 1000;

					// 通过letvid,youkuid,tudouid获取魔方网内部ID
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
						// 魔方内部ID，供客户端使用
						$val['video']['mofang_video_id'] = $mofangvid_datas['data']['video_id'];
					}
				}

                // 处理跳转链接
                preg_match_all('/http:\/\/(.*).mofang.com/', $val['url'], $result);
                $host_head = $result[1][0];
                if (in_array($host_head, array('bbs', 'share', 'game', 'fahao')) || !$host_head) {
                    continue;
                }
                $val['url'] .= '?wap=1&comefrom=mofangapp';

                // 时间字段
                $val['addtime'] = $val['inputtime'];
                $data[$key] = $val;
			}
		}
        $totalnums = $result['totalnums'] ? : 0;
        $pagemore = $page >= ceil($totalnums/$pagesize) ? 0 : 1;


        return array('code'=>0, 'data'=>array('articlelist'=>$data, 'totalnums'=>$totalnums, 'pagemore'=>$pagemore));
    }

    function tags() {
        $tags = array();
        if ($tags_str = getcache('mofangapp_search_tags', 'commons')) {
            $tags = explode(',', $tags_str[$this->type]);
        }

        return array('code'=>0, 'data'=>$tags);
    }
}

// 基础代码
$mofangapi = new mofangapi;
$action = $_SERVER['REQUEST_URI'];
$a = explode('?', $action);
$b = explode('/', $a[0]);
$b_num = count($b);
$true_action = $b[$b_num-1];
$return = array();

if(!method_exists($mofangapi,$true_action)){
    $return['code'] = -1;
    $return['message'] = '接口方法不存在，请检查!';
    $return['data'] = array();
} else {
    $return = $mofangapi->$true_action($_GET);
}
$callback = isset($_GET['jsonpcallback']) ? trim($_GET['jsonpcallback']) : ( isset($_GET['callback']) ? trim($_GET['callback']) : "" );
if($callback){
    echo $callback."(".json_encode($return).")";
}else{
    echo json_encode($return);
}
exit;

?>
