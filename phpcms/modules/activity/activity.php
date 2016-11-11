<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class activity extends admin {
    private $db;
    public $siteid;
    function __construct() {
        parent::__construct();

        $this->db = pc_base::load_model('activity_model');
    }

    /**
     * 活動列表
     */
    public function init() {
        $tree = pc_base::load_sys_class('tree');
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        $categorys = array();

        // 活動列表
        $result = $this->db->select(array(), '*', '', '`id` DESC');
        $str  = "<tr>
                <td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input-text-c'></td>
                <!-- <td align='center'>\$id</td> -->
                <td >\$spacer\$activity_name\$display_icon</td>
                <td align='left'>\$domain_dir\$display_icon</td>
                <td >\$spacer\$page_name\$display_icon</td>
                <td align='center' >\$str_manage</td>
                </tr>";
        $host = $_SERVER['HTTP_HOST'];
        if(strpos($host, 'zc.test') === 0){
            $host_path = 'zc.test.mofang.com/www';
        }else{
            $host_path = 'www.mofang.com';
        }
        
        // 管理菜單
        if(!empty($result)) {
            foreach($result as $r) {
                $r['str_manage'] = '';

                //增加
                if ( $r['parentid'] == 0 ) {
                    $r['str_manage'] .= '<a href="?m=activity&c=activity&a=add&parentid='.$r['id'].'&pc_hash='.$_SESSION['pc_hash'].'">'.添加分頁.'</a> | ';
                }
                //修改
                $r['str_manage'] .= '<a href="?m=activity&c=activity&a=edit&id='.$r['id'].'&pc_hash='.$_SESSION['pc_hash'].'">'.L('edit').'</a> | ';
                //刪除
                $r['str_manage'] .= '<a href="javascript:confirmurl(\'?m=activity&c=activity&a=delete&id='.$r['id'].'\',\''.L('confirm',array('message'=>addslashes(strip_tags($r['activity_name'])))).'\')">'.L('delete').'</a>';
                
                // 活動名加鏈接
                $r['activity_name'] = '<a href="http://'.$host_path.'/activity/'.$r['domain_dir'].'/'.$r['page_name'].'.html" target="_blank">'.$r['activity_name'].'</a>';

                $categorys[$r['id']] = $r;
            }
        }

        //構造分區樹
        $tree->init($categorys);
        $categorys = $tree->get_tree(0, $str);

        include $this->admin_tpl('category_manage');
    }

    /**
     * 添加活動
     */
    public function add() {
        // 加載表單類
        pc_base::load_sys_class('form','',0);
        // 加載公共類
        pc_base::load_sys_class('format','',0);
        // 加載公共函數類
        pc_base::load_app_func('global');

        if(isset($_POST['dosubmit'])) {
            if ($_POST['info']['activity_name']=='') showmessage('活動標題不能為空');
            $_POST['info']['activity_name'] = safe_replace($_POST['info']['activity_name']);

            // 裁切圖片
            if( !empty($_POST['info']['bg_pic']) ){
                // 加載裁切圖片類
                $new_pic = pc_base::load_sys_class('image_new','',1);
                $target = PHPCMS_PATH.'statics/s/event';
                $host = $_SERVER['HTTP_HOST'];

                if(is_test_server()){
                    $host_path = $host.'/www/statics/s/event/';
                }else{
                    $host_path = $host.'/statics/s/event/';
                }

                $pic_url = $_POST['info']['bg_pic'];
                $return = $new_pic->cut_images($pic_url,$target,200);

                if($return){
                    foreach ($return as $key => $val) {
                        $tem_arr = explode('/', $val['url']);
                        $pic = end($tem_arr);
                        $return[$key]['img_url'] = $host_path.$pic;
                    }
                }
                $_POST['info']['render_pics'] = array2string($return);
            }
            
            // 輪盤獎品處理
            $prize_pic = array();
            if(isset($_POST['prize_key']) && isset($_POST['prize_value'])) {
                foreach($_POST['prize_key'] as $k => $v) {
                    $prize_pic[$v] = $_POST['prize_value'][$k]?:'';
                
                }
            }
            $_POST['roulette']['prize_pic'] = $prize_pic;

            // 其他配置項
            $_POST['info']['setting'] = array2string($_POST['setting']);
            $_POST['info']['float_win'] = array2string($_POST['float_win']);
            $_POST['info']['weixin'] = array2string($_POST['weixin']);
            $_POST['info']['roulette'] = array2string($_POST['roulette']);

            // 提示信息字符串
            $end_str = $old_end =  '<script type="text/javascript">window.top.art.dialog({id:"test"}).close();window.top.art.dialog({id:"test",content:\'<h2>'.L("add_success").'</h2><span style="fotn-size:16px;">'.L("您可以進行以下的操作：").'</span><br /><ul style="fotn-size:14px;"><li><a href="'.HTTP_REFERER.'" target="right" onclick="window.top.art.dialog({id:\\\'test\\\'}).close()">'.L("2、返回繼續添加活動").'</a></li></ul>\',width:"400",height:"200"});</script>';

            // 添加活動
            $id = $this->db->insert($_POST['info'], true);

            showmessage(L('add_success').$end_str);
        }else{
            $parentid = isset($_GET['parentid']) ? $_GET['parentid'] : '';

            if( $parentid ) {
                $r = $this->db->get_one(array('id'=>$parentid));
                if($r) extract($r,EXTR_SKIP);

                $big_menu = array('?m=activity&c=activity&a=init','返回列表');
                $curr_parent_name = $activity_name .' > 添加分頁[微信頁、移動頁_1_2_3_4_5]';
            }
            
            include $this->admin_tpl('category_add');
        }
    }

    /**
     * 刪除活動,子欄目刪除
     */
    public function delete() {
        $id = intval($_GET['id']);
        $temp_parentid = $this->db->get_one(array('id'=>$id), 'id,parentid');

        // 刪除操作
        $this->delete_child($id);
        $this->db->delete(array('id'=>$id));

        showmessage(L('operation_success'),HTTP_REFERER);
    }

    /**
     * 遞歸刪除欄目
     * @param $id 要刪除的欄目id
     */
    private function delete_child($id) {
        $id = intval($id);
        if (empty($id)) return false;
        while( $r = $this->db->get_one(array('parentid'=>$id)) ){
            if($r) {
                $this->delete_child($r['id']);
                $this->db->delete(array('id'=>$r['id']));
            }
        }
        return true;
    }

    /**
     * 修改分區
     */
    public function edit() {
        if(isset($_POST['dosubmit'])) {
            //基本信息
            pc_base::load_sys_func('iconv');
            $id = intval($_POST['id']);

            // 查詢分區信息
            $r = array();
            $r = $this->db->get_one(array('id'=>$id));
            if($r) extract($r);

            // 修改時，需保證活動英文標識一致
            if($parentid){
                $re = $this->db->get_one(array('id'=>$parentid),'domain_dir');
                $_POST['info']['domain_dir'] = $re['domain_dir'];
            }else{
                $re = $this->db->select(array('parentid'=>$id));
                if($re){
                    foreach($re as $key=>$val){
                        $this->db->update(array('domain_dir'=>$_POST['info']['domain_dir']),array('id'=>$val['id']));
                    }
                }
            }

            // 裁切圖片
            /*if( empty($render_pics) || $bg_pic != $_POST['info']['bg_pic'] ){
                // 加載裁切圖片類
                $new_pic = pc_base::load_sys_class('image_new','',1);
                $target = PHPCMS_PATH.'statics/s/event';
                $host = $_SERVER['HTTP_HOST'];

                if(strpos($host, 'zc.test') === 0){
                    $host_path = $host.'/www/statics/s/event/';
                }else{
                    $host_path = $host.'/statics/s/event/';
                }

                $pic_url = $_POST['info']['bg_pic'];
                $return = $new_pic->cut_images($pic_url,$target,200);

                if($return){
                    foreach ($return as $key => $val) {
                        $tem_arr = explode('/', $val['url']);
                        $pic = end($tem_arr);
                        $return[$key]['img_url'] = $host_path.$pic;
                    }
                }
                $_POST['info']['render_pics'] = array2string($return);
            }*/

            // 其他配置項
            $prize_pic = array();
            if(isset($_POST['prize_key']) && isset($_POST['prize_value'])) {
                foreach($_POST['prize_key'] as $k => $v) {
                    $prize_pic[$v] = $_POST['prize_value'][$k]?:'';
                
                }
            }
            $_POST['roulette']['prize_pic'] = $prize_pic;

            $_POST['info']['setting'] = array2string($_POST['setting']);
            $_POST['info']['float_win'] = array2string($_POST['float_win']);
            $_POST['info']['weixin'] = array2string($_POST['weixin']);
            $_POST['info']['roulette'] = array2string($_POST['roulette']);

            //更新分區信息
            $this->db->update($_POST['info'],array('id'=>$id));

            showmessage(L('operation_success'),HTTP_REFERER);
        } else {
            // 加載表單類
            pc_base::load_sys_class('form','',0);

            // 查詢分區信息
            $r = array();
            $id = intval($_GET['id']);
            $r = $this->db->get_one(array('id'=>$id));
            if($r) extract($r);

            // 修改時，需保證活動英文標識一致
            if($parentid){
                $re = $this->db->get_one(array('id'=>$parentid),'domain_dir');
                $domain_dir = $re['domain_dir'];
            }
            // 把配置數組做處理
            $setting = string2array($setting);
            $float_win = string2array($float_win);
            $weixin = string2array($weixin);
            $roulette = string2array($roulette);

            $big_menu = array('?m=activity&c=activity&a=init','返回列表');
            $curr_parent_name = $activity_name.' &gt; 修改信息';

            //頭圖
            // $header_pic_array = json_decode($bg_pic, true);
            // $count_header_pic = count( $header_pic_array );

            include $this->admin_tpl('category_edit');
        }
    }

    public function add_map_setting() {
        include $this->admin_tpl('map_setting');
    }
    /**
      * Ajax獲取上傳圖片相關的html(跳轉button)
      * @Param
      *     $curr_id    當前id
      *     $image      輸入框默認值
      *
      */
    public function ajax_upload_img(){
        pc_base::load_sys_class('form','',0);

        $curr_id = $_POST['curr_id'];
        $image = $_POST['image'] ? $_POST['image'] : '';
            echo json_encode( form::images_activity('redirect_button['.$curr_id.'][image]', 'image_redirect'.$curr_id, $image, 'activity','','','input-text') );

    }

    /**
      * Ajax獲取上傳圖片相關的html(頭圖)
      * @Param
      *     $curr_id    當前id
      *     $image      輸入框默認值
      *
      */
    public function ajax_upload_img2(){
        pc_base::load_sys_class('form','',0);

        $curr_id = $_POST['curr_id'];
        $image = $_POST['image'] ? $_POST['image'] : '';
            echo json_encode( form::images_activity('header_pic['.$curr_id.'][image]', 'image_headerpic'.$curr_id, $image, 'activity','','','input-text') );
    }

    /**
      * Ajax獲取上傳圖片相關的html(頭圖)
      * @Param
      *     $curr_id    當前id
      *     $image      輸入框默認值
      *
      */
    public function ajax_upload_img3(){
        pc_base::load_sys_class('form','',0);

        $curr_id = $_POST['curr_id'];
        $image = $_POST['image'] ? $_POST['image'] : '';
        echo json_encode( form::images_activity('setting[button_v2]['.$curr_id.'][image]', 'image_buttonv2pic'.$curr_id, $image, 'activity','',30,'input-text') );
    }

    /**
     * 排序,需修改,應該是沒問題了,待最終審查,待增加指定功能,notok
     */
    public function listorder() {
        if(isset($_POST['dosubmit'])) {
            foreach($_POST['listorders'] as $id => $listorder) {
                $this->db->update(array('listorder'=>$listorder),array('id'=>$id));
            }
            showmessage(L('operation_success'),HTTP_REFERER);
        } else {
            showmessage(L('operation_failure'));
        }
    }

    /**
     * 遊戲信息列表
     */
    public function game_info() {
        pc_base::load_sys_class('format','',0);
        
        $game_sort['ios'] = 'iOS遊戲庫';
        $game_sort['android'] = 'Android遊戲庫';
        
        $game_info = $_GET['game_sort'] ? trim($_GET['game_sort']) : 'ios';
        switch ( $game_info ){
            case 'ios':
                $modelid = 20;
                break;
            case 'android':
                $modelid = 21;
                break;
            default:
                $modelid = 20;
        }
        
        $categorys[20] = 'iOS遊戲中心';
        $categorys[134] = '安卓遊戲中心';

        $page = intval($_GET['page']);
        $this->db_content->set_model($modelid);
        
        if(isset($_GET['keywords'])) {
            $keywords = trim($_GET['keywords']);
            $where .= "`title` like '%{$keywords}%'";
        }
        
        $game_infos = $this->db_content->listinfo($where,'',$page,12);
        $pages = $this->db_content->pages;
        include $this->admin_tpl('game_info');
    }

    /**
     * 活動緩存
     */
    private function activity_cache() {
        $activity = array();
        $result = $this->db->select(array('disabled'=>0), '`id`, `siteid`, `title`, `url`, `thumb`, `banner`, `ishtml`', '', '`listorder` DESC, `id` DESC');
        foreach($result as $r) {
            $activity[$r['id']] = $r;
        }
        setcache('activity', $activity, 'commons');
        return true;
    }
}
?>

