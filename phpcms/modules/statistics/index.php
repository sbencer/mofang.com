<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//模型緩存路徑
define('CACHE_MODEL_PATH',CACHE_PATH.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);
//定義在單獨操作內容的時候，同時更新相關欄目頁面
define('RELATION_HTML',true);

pc_base::load_app_class('admin','admin',0);
pc_base::load_sys_class('form','',0);
pc_base::load_app_func('util');
pc_base::load_app_func('global');
pc_base::load_sys_class('format','',0);

class index extends admin {

    public function __construct() {
        $this->db = pc_base::load_model('content_model');
        $this->modelid = array('news'=>1,'picture'=>3,'video'=>11,'iosgames'=>20,'androidgames'=>21);
        $this->groups = $this->get_groups();
    }

    public function init() {
        $group = intval($_GET['group']);
        $members = $this->get_members($group);

        $model = trim($_GET['model']);
        if($model == 'all'){
            $tables = array_keys($this->modelid);
        } else {
            $tables = array($model);
        }

        // 搜索時間區間
        if (!empty($_GET['start_time']) && !is_numeric($starttime = $_GET['start_time'])) {
            $starttime = strtotime($_GET['start_time'])>strtotime('-3 month')?strtotime($_GET['start_time']):strtotime('-3 month');
        }
        if (!is_numeric($endtime = $_GET['end_time'])) {
            $endtime = strtotime($_GET['end_time']);
        }

        // 編輯詳情url
        $list_url = "?m=statistics&c=index&a=content_list&model={$model}&start_time=$starttime&end_time=$endtime&user=";
        // 請求url
        $request_url = "?m=statistics&c=index&a=init&model={$model}&group={$group}&start_time=$starttime&end_time=$endtime";
        if ($members) {
            mysql_query("delete from www_statistics where validtime<".time());
            $user_m5 = md5($request_url);
            $user_cached = mysql_query("select * from www_statistics where id='$user_m5'");
            $cached = mysql_num_rows($user_cached);

            if($cached == 0){
                $user_info = $this->getinfo_more($tables,$members,$starttime,$endtime);
                $user_cache = serialize($user_info);
                $validtime = time()+3600;
                mysql_query("INSERT INTO www_statistics (id,arrs,validtime) VALUES('$user_m5', '$user_cache', $validtime)");
            }else{
                $user_cached = mysql_fetch_assoc($user_cached);
                $user_info = unserialize($user_cached['arrs']);
            }

            // 結果排序
            if(isset($_GET['by'])){
                $user_info = sysSortArray($user_info,$_GET['by'],'SORT_DESC',"SORT_REGULAR");
            }else{
                $user_info = sysSortArray($user_info,'user','SORT_DESC',"SORT_REGULAR");
            }
        }

        //篩選時間還原字符格式
        if (!empty($starttime)) {
            $starttime = date("Y-m-d H:m:s", $starttime);
        } else {
            $starttime = date("Y-m-d H:m:s", strtotime(date("Y-m", time())));
        }
        if (!empty($endtime)) {
            $endtime = date("Y-m-d H:m:s", $endtime);
        } else {
            $endtime = date("Y-m-d H:m:s");
        }

        $template = $MODEL['admin_list_template'] ? $MODEL['admin_list_template'] : 'statistics_list';
        include $this->admin_tpl($template);
    }


    /**
     * 查詢所有符合條件的編輯信息
     */
    function getinfo_more($tablenames,$members,$starttime="",$stoptime="",$order="ASC",$by="realname"){
        $users = array();
        foreach($members as $username=>$realname) {
            $user_info[$username]['user'] = $realname;
            $user_info[$username]['num'] = 0;
            $user_info[$username]['view'] = 0;
            $user_info[$username]['comment'] = 0;
            $usernames[] = "'".$username."'";
        }
        $usernamestr = implode(',', $usernames);
        foreach ($tablenames as $table) {
            if($starttime != "" && $stoptime != ""){
                $result = $this->db->query("SELECT id,catid,realname,u.username FROM www_{$table} u,www_admin a WHERE u.username=a.username AND inputtime>{$starttime} AND inputtime<{$stoptime} AND u.username IN ($usernamestr)");
            }else{
                return;
            }
            $rows = $this->db->fetch_array();
            foreach($rows as $val){
                    $user_info[$val['username']]['num'] += 1;

                    $views = mysql_query("select views from www_hits where hitsid='c-{$this->modelid[$table]}-{$val['id']}'");
                    while ($v = mysql_fetch_assoc($views)) {
                        $user_info[$val['username']]['view'] += $v['views'];
                    }

                    $comments = mysql_query("select total from www_comment where commentid='content_{$val['catid']}-{$val['id']}-1'");
                    while ($c = mysql_fetch_assoc($comments)) {
                        $user_info[$val['username']]['comment'] += $c['total'];
                    }
            }
        }
        return $user_info;
    }

    /**
     * 獲得網站成員員分組
     */
    private function get_groups() {
        $this->db->query("SELECT roleid,rolename FROM www_admin_role");
        $result = $this->db->fetch_array();
        foreach($result as $val) {
            $groups[$val['roleid']] = $val['rolename'];
        }
        return $groups;
    }

    /**
     * 獲得用戶組下所有的用戶信息
     */
    private function get_members($roleid) {
        if ($roleid) {
            $this->db->query("SELECT username,realname FROM www_admin WHERE roleid={$roleid}");
        } else {
            $this->db->query("SELECT username,realname FROM www_admin");
        }
        $result = $this->db->fetch_array();
        foreach($result as $val) {
            $members[$val['username']] = $val['realname'];
        }
        unset($members['mofang']);
        return $members;
    }

    function content_list() {
        $pc_hash = $_SESSION['pc_hash'];
        $model_arr = array('news'=>1, 'picture'=>3, 'video'=>11, 'iosgames'=>20, 'androidgames'=>21);
        $model = trim($_GET['model']);
        if (!in_array($model, $omdel_arr)) {
            $model = 'news';
        }
        $members = $this->get_members();
        $this->db->table_name = $this->db->db_tablepre.$model;

        $username = $_GET['user'];
        if(isset($username)){
            $where .= " username='{$username}'";
        }
        // 搜索時間區間
        if (!empty($_GET['start_time']) && !is_numeric($starttime = $_GET['start_time'])) {
            $starttime = strtotime($_GET['start_time'])>strtotime('-3 month')?strtotime($_GET['start_time']):strtotime('-3 month');
            $where .= " AND `inputtime` > '$starttime'";
        }
        if (!is_numeric($endtime = $_GET['end_time'])) {
            $endtime = strtotime($_GET['end_time']);
            $where .= " AND `inputtime` < '$endtime'";
        }
        
        if($start_time>$end_time) showmessage(L('starttime_than_endtime'));
        if (!empty($starttime) && !empty($endtime)) {
            $datas = $this->db->listinfo($where,'inputtime desc',$_GET['page']);
            $pages = $this->db->pages;
        }

        //篩選時間還原字符格式
        if (!empty($starttime)) {
            $starttime = date("Y-m-d H:m:s", $starttime);
        } else {
            $starttime = date("Y-m-d H:m:s", strtotime(date("Y-m", time())));
        }
        if (!empty($endtime)) {
            $endtime = date("Y-m-d H:m:s", $endtime);
        } else {
            $endtime = date("Y-m-d H:m:s");
        }

        $template = $MODEL['admin_list_template'] ? $MODEL['admin_list_template'] : 'content_list';
        include $this->admin_tpl($template);
    }
}

