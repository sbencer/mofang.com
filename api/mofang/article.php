<?php
defined('IN_PHPCMS') or exit('No permission resources.');
header('Content-Type: application/json');
pc_base::load_app_func('global','content');

/**
 * 本文件功能注释
 * @author 作者
 * 时间
 */
class mofangapi {
    function __construct() {
        $this->db_content = pc_base::load_model('content_model');
    }

    public function show() {
        if ( !($catid = $_GET['catid']) || !($id = $_GET['id']) ) return array('code'=>1, 'message'=>'缺少必要参数：catid，id！');

        $siteids = getcache('category_content','commons');
        $siteid = $siteids[$catid];
        $this->categorys = getcache('category_content_'.$siteid,'commons');
        if ( !isset($this->categorys[$catid]) || $this->categorys[$catid]['type']!=0 ) return array('code'=>1, 'message'=>'查无此栏目！');
        $modelid = $this->categorys[$catid]['modelid'];

        $MODEL = getcache('model', 'commons');
 
        $tablename = $this->db_content->table_name = $this->db_content->db_tablepre.$MODEL[$modelid]['tablename'];
        $r = $this->db_content->get_one(array('id'=>$id, 'status'=>'99'));
        if (!$r) return array('code'=>1, 'message'=>'查无此文章！');

        $this->db_content->table_name = $tablename.'_data';
        $r2 = $this->db_content->get_one(array('id'=>$id));
        $rs = $r2 ? array_merge($r,$r2) : $r;

        require_once CACHE_MODEL_PATH.'content_output.class.php';
        $content_output = new content_output($modelid,$catid,$this->categorys);
        $data = $content_output->get($rs);

        $data['content'] = preg_replace("|\[page](.*)\[/page\]|U",'',$data['content']); // 去掉分页符
        $data['content'] = preg_replace("|\[img_ids](.*)\[/img_ids\]|U",'',$data['content']); // 去掉内容页的传入的id
        $data['content'] = preg_replace("|\[show_game](.*)\[/show_game\]|U",'',$data['content']); // 去掉内容页游戏传入的id

        return array('code'=>0, 'data'=>$data);
    }

    public function lists() {
        if ( !$_GET['catid'] && !($_GET['keyword'])) return array('code'=>1, 'message'=>'至少包含参数：catid或者keyword！');
        $query_param = array(); // get请求参数
        parse_str($_SERVER['QUERY_STRING'], $query_param);
        $cache_key = md5($_SERVER['QUERY_STRING']);

        foreach ($query_param as $field=>$value) {
            if ($field == 'op' || $field == 'file' || $field == 'action') {
                unset($query_param[$field]);
            } else {
                if (is_int($value)) {
                    $query_param[$field] = intval($value);
                } elseif (is_string($value)) {
                    $query_param[$field] = trim($value);
                }
            }
        }

        // if ( $response = getcache($cache_key, '', 'memcache', 'html') ) {
        //     echo $response;
        // } else {
            $data = array(); // 查询参数
            $data = $query_param;
            extract($data);
            $page = isset($page) ? $page : (isset($currpage) ? $currpage : 2);

            $page = $page < 1 ? 1 : $page;
            $pagesize = $pagesize < 1 ? 10 : $pagesize;
            $start = ($page-1) * $pagesize;

            $data['limit'] = "$start,$pagesize";
            $data['order'] = 'inputtime DESC';
            $data['moreinfo'] = 1; // 全部字段

            $response = array();
            $ctag = pc_base::load_app_class('content_tag','content',1);
            if ( !empty($keyword) ) {
                $re_data = $ctag->get_solr_relation($keyword,'','',$data);
                if ($re_data) {
                    $response['code'] = 0;
                    $response['data'] = $total ? array_values($re_data['data']) : array_values($re_data);
                    if ($total) $response['total'] = $re_data['content_total'];
                } else {
                    $response = array('code'=>1, 'message'=>'数据为空！');
                }
            } else {
                $re_data = $ctag->lists($data);
                if ($re_data) {
                    $response['code'] = 0;
                    $response['data'] = $total ? array_values($re_data['contents']) : array_values($re_data);
                    if ($total) $response['total'] = $re_data['content_total'];
                } else {
                    $response = array('code'=>1, 'message'=>'数据为空！');
                }
            }

            // setcache($cache_key, $response, '', 'memcache', 'html', 1800);
            return $response;
        // }
    }

    /**
     * loadmore 统一走solr
     * @author jozh Liu 2015/08/21/
     */
    public function loadmore() {
        if ( !$_GET['catid'] || !($_GET['inputtime'])) return array('code'=>1, 'message'=>'缺少必要参数：catid，inputtime！');
        $params = array(); // get请求参数

        parse_str($_SERVER['QUERY_STRING'], $params);
        $cache_key = md5($_SERVER['QUERY_STRING']);

        foreach ($params as $field=>$value) {
            if ( in_array($field, array('op', 'file', 'action')) ) {
                unset($params[$field]);
            } else {
                if (is_int($value)) {
                    $params[$field] = intval($value);
                } elseif (is_string($value)) {
                    $params[$field] = trim($value);
                }
            }
        }
        extract($params);
        $ctag = pc_base::load_app_class('content_tag','content',1);

        $params['where'] = "status=99 AND catid=$catid AND inputtime < $inputtime order by `inputtime` desc";
        $params['limit'] = isset($limit) ? $limit : (isset($pagesize) ? $pagesize : (isset($pagenum) ? $pagenum : 10) );
        $params['moreinfo'] = 1;
        $params['total'] = 1;

        if ( $response = getcache($cache_key, '', 'memcache', 'html') ) {
            return $response;
        } else {
            $re_data = $ctag->lists($params);

            if ($re_data) {
                $response['code'] = 0;
                $response['data'] = array_values($re_data['contents']);
                $response['total'] = $re_data['content_total'];
            } else {
                $response = array('code'=>1, 'message'=>'数据为空！');
            }

            setcache($cache_key, $response, '', 'memcache', 'html', 1800);
            return $response;
        }

    }
}

// 基础代码
$mofangapi = new mofangapi;
$true_action = trim($_GET['action']);
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
