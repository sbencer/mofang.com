<?php
/**
 * [攻略助手 v1] 接口
 * 王官庆  star time: 2015-12-17
 * 获取专区相关配置的接口
 * 一、 banner 根据partitionID获取APP广告位
 * 二、 quick_nav 根据aprtitionID获取APP导航
 * 三、 lists 根据catid获取栏目文章列表
 * 四、 search 专区攻略内容搜索(未经测试)
 * 五、 partition_lists 返回专区列表，用于推荐(暂时未使用，用时请测试)
 */

defined('IN_PHPCMS') or exit('No permission resources.'); 
header('Content-Type: application/json');
$article = new partition;
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

class partition {
    function __construct() {
        $this->db_partition = pc_base::load_model('partition_model');
        $this->db_partition_games = pc_base::load_model('partition_games_model');
        $this->db_partition_relationgames = pc_base::load_model('partition_relationgames_model');
        $this->db_content = pc_base::load_model('content_model');
        $this->db_category = pc_base::load_model('category_model');
    }


    // 攻略助手banner配置
    public function banner() {
        if ( !($partitionid = $_GET['partitionid']) ) {
            echo json_encode(array('code'=>1, 'message'=>'缺少必要参数：partitionid！', 'data'=>array()));
            return;
        }

        $part_info = $this->db_partition->get_one('`catid` = '.$partitionid, "catname,catid,bbs_id,domain_dir,setting,header_pic");
        if (!$part_info) {
            echo json_encode( array('code'=>1, 'message'=>'查无相符专区！', 'data'=>array()));
            return;
        } else {
            $setting = string2array($part_info['setting']);
            $header_pic = json_decode($part_info['header_pic'], true);
            foreach($header_pic as $key=>$val) {
                $data[$key]['listorder'] = $val['listorder'];    
                $data[$key]['title'] = $val['name'];    
                $data[$key]['thumb'] = $val['image'];    
                $data[$key]['url'] = $val['redirect'];    
                $data[$key]['redirect_type'] = $val['redirect_type'];
            }

            echo json_encode(array('code'=>0, 'message' => '数据返回正常!', 'data'=>$data));
        }
    }

    // 快捷导航及专区配置
    public function quick_nav() {
        if ( !($partitionid = $_GET['partitionid']) ) {
            echo json_encode(array('code'=>1, 'message'=>'缺少必要参数：partitionid！', 'data'=>array()));
            return;
        }

        $part_info = $this->db_partition->get_one('`catid` = '.$partitionid, "catname,catid,bbs_id,domain_dir,setting,header_pic");
        if (!$part_info) {
            echo json_encode( array('code'=>1, 'message'=>'查无相符专区！', 'data'=>array()));
            return;
        } else {
            $domain_dir = $part_info['domain_dir'];

            $setting = string2array($part_info['setting']);
            $part_info['quick_nav'] = $setting['button_v2'];
            foreach ($part_info['quick_nav'] as $key=>$val) {
                $quick_nav[$key]['listorder'] = $val['listorder'];
                $quick_nav[$key]['title'] = $val['name'];
                $quick_nav[$key]['nav_type'] = $val['button_type'];
                $quick_nav[$key]['fastnav_id'] = $val['button_value'];
                $quick_nav[$key]['icon'] = $val['image'];
                if ($val['button_type'] == 1) {
                    $quick_nav[$key]['api_url'] = APP_PATH.'api_v2.php?op=mofang&file=partition&action=lists&p='.$domain_dir.'&catid='.$val['button_value'];
                } else {
                    $quick_nav[$key]['api_url'] = $val['fastnav_id'];
                }

            }
            $part_info['quick_nav'] = array_values($quick_nav);

            unset($part_info['setting']);
            unset($part_info['header_pic']);

            echo json_encode(array('code'=>0, 'message' => '数据返回正常!', 'data'=>$part_info));
        }
    }

    // 专区栏目文章列表
    public function lists() {
        if ( !$_GET['p'] || !$_GET['catid']) return array('code'=>1, 'message'=>'缺少必要参数：p，catid！');
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = $_GET['pagesize'] ? $_GET['pagesize'] : 15;
        $listorder = isset($_GET['listorder']) ? $_GET['listorder'] : '`inputtime` DESC, `listorder` DESC';

        $temp_arrchildid = $this->db_partition->get_one('`catid`='.$_GET['catid'], 'arrchildid');

        if($temp_arrchildid) {
            $part_info_ids = $this->db_partition_games->listinfo('`part_id` IN ('.$temp_arrchildid['arrchildid'].')', $listorder, $page, $pagesize);
            $content_total = $this->db_partition_games->count('`part_id` IN ('.$temp_arrchildid['arrchildid'].')');
        } else {
            echo json_encode(array('code'=>1, 'message' => '栏目不存在', 'data'=>array()));
            return;
        }

        $db_hits = pc_base::load_model('hits_model');
        if( $_GET['vieworder'] ){ // 看访问量排序
            foreach( $part_info_ids as $k_il=>$v_il ){
                $hits_where['hitsid'] = 'c-'.$v_il['modelid'].'-'.$v_il['gameid'];
                $temp_views = $db_hits->get_one($hits_where, 'views');
                $part_info_ids[$k_il]['views'] = $temp_views['views'];
            }
            usort( $part_info_ids, "partition_list_cmp_views" );
        }
        $part_info_array = array();
        //获取文章详情
        foreach( $part_info_ids as $key=>$value ){
            $this->db_content->set_model($value['modelid']);
            $info_array = $this->db_content->get_one('`id`='.$value['gameid'], 'id,catid,url,title,shortname,thumb,description,updatetime,username,inputtime');
            //获取浏览数
            $hits_where = array();
            $hits_where['hitsid'] = 'c-'.$value['modelid'].'-'.$value['gameid'];
            $temp_views = $db_hits->get_one($hits_where, 'views');
            $info_array['views']=$temp_views['views'] ? $temp_views['views'] : 0;
            //获取论坛FEEDID 
            //$info_array['commentid'] = intval(get_commentid($value['modelid'],$value['gameid']));

            //归入数组
            $part_info_array[] = $info_array;
        }
        //生成对应的接口地址
        foreach ($part_info_array as $key=>$val) {
            $part_info_array[$key]['api_url'] = APP_PATH.'api_v2.php?op=mofang&file=article&action=show&id='.$val['id'].'&catid='.$val['catid'];
            $part_info_array[$key]['thumb'] = $val['thumb'] ? $val['thumb'] : 'http://pic1.mofang.com/2015/1120/20151120044005949.jpg';
        }

        $lists_info['page'] = $page;
        $lists_info['pagesize'] = $pagesize;
        $lists_info['count_all'] = $content_total;
        $lists_info['contents'] = $part_info_array;

        echo json_encode(array('code'=>0, 'message'=>'数据返回正常', 'data'=>$lists_info));
    }
    //专区搜素
    public function search(){
        if ( !$_GET['p'] || !$_GET['catid']) return array('code'=>1, 'message'=>'缺少必要参数：p，catid！');
        $keywords = $_GET['keyword'] ? trim($_GET['keyword']) : '';
        //搜索配置
        $catid = intval($_GET['catid']);
        $keywords = keyword_arr($keywords,0,3);
        $range = keyword_arr($_GET['range']);
        $partitionid = intval($partitionid);
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $pagesize = $_GET['pagesize'] ? $_GET['pagesize'] : 15;
        $start = ($page-1)*$pagesize;

        $search_setting = getcache('search','search');
        $setting = $search_setting[1];
        $solr = pc_base::load_app_class('apache_solr_service', 'search', 0);
        $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);

        $additionalParameters['sort'] = 'inputtime desc';
        $additionalParameters['fq'][] = "partition:{$catid}";
        if (count($keywords) == 1){
            $keyword = safe_replace($keywords[0]);
            $additionalParameters['fq'][] = "keywords:{$keyword}";
        }
        $q = '';
        foreach ($keywords as $keyword) {
            $keyword = safe_replace($keyword);
            $q .= 'keywords:'.$keyword.' OR ';
        }
        $q = trim($q, 'OR ')."\n";
        if ($range) {
            if (count($range) == 1) {
                $additionalParameters['fq'][] = "real_partid:{$range[0]}";
            } else {
                foreach ($range as $partid) {
                    $q .= 'real_partid:'.$partid.' OR ';
                }
            }
        }
        $q = trim($q, 'OR ')."\n";

        $result = $solr->search("{$q}", $start, $pagesize, $additionalParameters);
        if ($result) {
            $totalnums = (int) $result->response->numFound;
        }
        foreach ($result->response->docs as $key=> $doc) {
            foreach ($doc as $field => $value) {
                if ($field=='thumb') {
                    $value = $value ? $value : 'http://pic1.mofang.com/2015/1120/20151120044005949.jpg';
                }
                $data[$key][$field] = $value;
            }
        }
        $part_info_array = $data ? : array();
        $content_total = $totalnums ? : 0;
        unset($tmp_data);
        $lists_info['page'] = $page;
        $lists_info['pagesize'] = $pagesize;
        $lists_info['count_all'] = $content_total;
        $lists_info['contents'] = $part_info_array;

        return array('code'=>0, 'data'=>$lists_info);
    }
    // 专区列表
    public function partition_lists() {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $pagesize = isset($_GET['pagesize']) ? $_GET['pagesize'] : 15;
        $listorder = isset($_GET['listorder']) ? $_GET['listorder'] : '`catid` ASC';
        if ($listorder=='listorder') {
            $listorder = 'listorder DESC';
        }
        if (isset($_GET['key'])) {
            $keyword = safe_replace($_GET['key']);
            $where = "`catname` LIKE '%$keyword%' AND `is_online` = 1";
            $order = "listorder DESC";
            $limit = ($page-1)*$pagesize.",".$pagesize; 
            $partition_list = $this->db_partition->select($where,'*',$limit,$order);
            $count_all = $this->db_partition->count($where);
        }else{
            $partition_list = $this->db_partition->listinfo('`parentid` = 0 AND `is_online` = 1', $listorder, $page, $pagesize);
            $count_all = $this->db_partition->count('`parentid` = 0 AND `is_online` = 1');
        }
        foreach ($partition_list as $key=>$val) {

            foreach ($val as $_k=>$_v) {
                if ( in_array($_k, array('catid', 'catname', 'image','is_domain', 'domain_dir', 'setting')) ) {
                    if ($_k == 'setting') {
                        $setting = string2array($_v);
                        //专区图
                        $partition_list[$key]['img'] = $val['image'] ? $val['image'] : ($setting['web_header'] ?$setting['web_header'] :'' );
                        //礼包
                        $partition_list[$key]['libao'] = $setting['tem_setting']['mf_libao_url'] ? $setting['tem_setting']['mf_libao_url'] : "http://m.mofang.com/tag/".$val['catname']."-libao-1.html";
                        //论坛
                        $partition_list[$key]['bbs'] = $val['bbs_id'] ? "http://bbs.mofang.com/f/".$val['bbs_id'].".html" : 'http://bbs.mofang.com/';
                        //攻略助手
                        $partition_list[$key]['strategy'] = $setting['app_help']['ios'] ? $setting['app_help']['ios'] : $setting['app_help']['android'] ? $setting['app_help']['android'] : "http://app.mofang.com/";
                        $partition_list[$key]['description'] = $setting['meta_description'];
                        unset($partition_list[$key]['setting']);
                    }
                } else {
                    unset($partition_list[$key][$_k]);
                }
            }
            if ($val['is_domain']) {
                $partition_list[$key]['url'] = 'http://'.$val['domain_dir'].'.mofang.com.tw/';
            } else {
                $partition_list[$key]['url'] = APP_PATH.$val['domain_dir'].'/';
            }
            unset($partition_list[$key]['is_domain']);
            $partition_list[$key]['api_url'] = APP_PATH.'api_v2.php?op=mofang&file=partition&action=quick_nav&partitionid='.$val['catid'];
        }
        return array('code'=>0, 'count_all'=>$count_all, 'data'=>$partition_list);
    }


}
