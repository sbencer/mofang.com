<?php

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class partition extends admin {
    private $db;
    public $siteid;
    function __construct() {
        parent::__construct();

        //ok
        $this->db = pc_base::load_model('partition_model');
        //$this->db = pc_base::load_model('category_model');

        $this->siteid = $this->get_siteid();
        $this->db_content = pc_base::load_model('content_model');
        $this->db_partition_games = pc_base::load_model('partition_games_model');
        $this->db_partition_relationgames = pc_base::load_model('partition_relationgames_model');

    }

    /**
     * 管理分區
     * 1.除了整理鏈接參數,其他已ok
     */
    public function init() {

        //ok
        $show_pc_hash = '';

        //構造分區樹相關,ok
        $tree = pc_base::load_sys_class('tree');
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        //分區數據數組,初始化數組,ok
        $categorys = array();
        
        //ok
        $parentid = $_GET['parentid'] ? intval($_GET['parentid']) : 0;

        if( $parentid ){//面包屑父級專區
            $temp_curr_parent_name = $this->db->get_one( '`catid`='.$parentid, 'catname' );
            $curr_parent_name .= $temp_curr_parent_name['catname'].' &gt; 欄目列表 ';
        }

        if( !$parentid ){
            //按关键字搜索专区，默认直接分布显示 防止内存超出  王官庆 15.1.7
            $keyword = safe_replace($_GET['keyword']);
            if(!$keyword){
                //默认为所有专区分页显示
                $result = $this->db->listinfo(array("parentid"=>0),'`listorder` DESC, `catid` DESC', $_GET['page']);
            }else{
                //按关键字搜索专区
                $sql = " `parentid`=0 AND `catname` like '%$keyword%'";
                $result = $this->db->select($sql, '*', '', '`listorder` DESC, `catid` DESC');
            }
            $pages = $this->db->pages;
            $pc_hash = $_SESSION['pc_hash'];
        }else{
            $result = $this->db->select("`module`='partition' AND `arrparentid` like '%".$parentid."%'", '*', '', '`listorder` ASC');
            $tabnum = 0;
            foreach( $result as $key=>$value ){
                if( $value['parentid']==$parentid ){
                    $result[$key]['parentid'] = 0;
                }
                if ($value['is_tab'] == 1) {
                    $tabnum++;
                    $result[$key]['catname'] .= ' <span class="red">[TAB'.$tabnum.']</span>';
                }
                if ($value['is_tab2'] == 1) {
                    $tabnum++;
                    $result[$key]['catname'] .= ' <span class="green">[TAB'.$tabnum.']</span>';
                }
                $this->categorys = $result;
                $result[$key]['arrparentid'] = $this->get_arrparentid( $value['catid'] );
                $result[$key]['arrchildid'] = $this->get_arrchildid( $value['catid'] );
                $result[$key]['son_show'] = 1;
            }
        }

        if(!empty($result)) {
            foreach($result as $r) {

                //管理菜單,ok
                $r['str_manage'] = '';

                //顯示子分區,ok
                $show_detail = empty($parentid) ? 0 : 1;
                if(!$show_detail) {//是否顯示子分區的情況,ok

                    //獲取指定父分區下的子分區
                    if($r['parentid']!=$parentid) continue;

                    //與構造樹的類有關, 保留就好
                    $r['parentid'] = 0;

                    $r['str_manage'] .= '<a href="?m=partition&c=partition&a=init&parentid='.$r['catid'].'&s='.$r['type'].'&pc_hash='.$_SESSION['pc_hash'].'">'.L('manage_sub_category').'</a> | ';

                }
                $temp_parentid = $r['parentid'];

                //管理菜單,notok->待整理參數
                //增加子分區_鏈接
                $r['str_manage'] .= '<a href="?m=partition&c=partition&a=add&parentid='.$r['catid'].'&menuid='.$_GET['menuid'].'&s='.$r['type'].'&pc_hash='.$_SESSION['pc_hash'].'">'.添加欄目.'</a> | ';
                //修改/刪除/移動 分區_鏈接
                $r['str_manage'] .= '<a href="?m=partition&c=partition&a=edit&catid='.$r['catid'].'&menuid='.$_GET['menuid'].'&type='.$r['type'].'&pc_hash='.$_SESSION['pc_hash'].'">'.L('edit').'</a> | <a href="javascript:confirmurl(\'?m=partition&c=partition&a=delete&catid='.$r['catid'].'&menuid='.$_GET['menuid'].'\',\''.L('confirm',array('message'=>addslashes(strip_tags($r['catname'])))).'\')">'.L('delete').'</a>| <a href="?m=partition&c=activity&a=init&catid='.$r['catid'].'&menuid='.$_GET['menuid'].'">'.L('activity_manager').'</a>';
                //子分區,增加操作項
                if( $temp_parentid != 0 || $r['son_show'] ){
                    if($r['child']==0){
                        $string_add = '<a href="javascript:openwinx(\'?m=partition&c=content&a=add&parentid='.$parentid.'&partition_id='.$r['catid'].'\',\'\');void(0);"><font color=red>添加信息</font></a>';
                    }else{
                        $string_add = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    $r['str_manage'] = $r['str_manage'].' | <a href="javascript:import_c('.$r['catid'].');void(0);">導入信息</a> | '.$string_add.' ｜ <a href="?m=partition&c=content&a=init&parentid='.$parentid.'&specialid='.$r[catid].'&pc_hash='.$_SESSION['pc_hash'].'">管理信息</a>';
                }

                if( !$show_detail ){//專區名加鏈接
                    $r['catname'] = '<a href="?m=partition&c=partition&a=init&parentid='.$r['catid'].'&s='.$r['type'].'&pc_hash='.$_SESSION['pc_hash'].'">'.$r['catname'].'</a>';
                }else{//子欄目加鏈接
                    $r['catname'] = '<a href="?m=partition&c=content&a=init&specialid='.$r['catid'].'&pc_hash='.$_SESSION['pc_hash'].'">'.$r['catname'].'</a>';
                }

                //ok
                $categorys[$r['catid']] = $r;
            }
        }

        //ok
        $str  = "<tr>
                    <td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input-text-c'></td>
                    <td align='center'>\$id</td>
                    <td >\$spacer\$catname\$display_icon</td>
                    <td align='center' >\$str_manage</td>
                </tr>";

        //構造分區樹相關,ok
        $tree->init($categorys);
        $categorys = $tree->get_tree(0, $str);
        //是否顯示文章搜索
        $is_search = $parentid ? 1 : 0;
        include $this->admin_tpl('category_manage');
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
            echo json_encode( form::images_partition('redirect_button['.$curr_id.'][image]', 'image_redirect'.$curr_id, $image, 'partition','','','input-text') );

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
            echo json_encode( form::images_partition('header_pic['.$curr_id.'][image]', 'image_headerpic'.$curr_id, $image, 'partition','','','input-text') );
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
        echo json_encode( form::images_partition('setting[button_v2]['.$curr_id.'][image]', 'image_buttonv2pic'.$curr_id, $image, 'partition','',30,'input-text') );
    }

    /**
     * 添加分區
     * 1.暫未處理批量增加分區的情況,其他已ok
     */
    public function add() {

        $act = 'add';
        
        if(isset($_POST['dosubmit'])) {

            pc_base::load_sys_func('iconv');

            //添加類型相關,分區這裡始終為0,ok
            $_POST['info']['type'] = intval($_POST['type']);

            //分區名,notok->暫未處理批量增加分區的情況
            if(isset($_POST['batch_add']) && empty($_POST['batch_add'])) {
                if($_POST['info']['catname']=='') showmessage(L('input_catname'));
                $_POST['info']['catname'] = safe_replace($_POST['info']['catname']);
            }

            //siteid和module標識,ok
            $_POST['info']['siteid'] = $this->siteid;
            $_POST['info']['module'] = 'partition';

            //設置信息,ok
            $setting = $_POST['setting'];
            foreach($setting['tem_setting']['nav'] as $k_tn=>$v_tn){//空nav項濾重
                if( empty($v_tn['name'])||empty($v_tn['nav_value']) ){
                    unset($setting['tem_setting']['nav'][$k_tn]);
                }
            }
            $_POST['info']['setting'] = array2string($setting);

            //頭圖
            $header_pic = array();
            foreach( $_POST['header_pic'] as $value ){
                $header_pic[] = $value;
            }

            $_POST['info']['header_pic'] = addslashes(json_encode($header_pic));
            //跳轉button
            $redirect_button = array();
            foreach( $_POST['redirect_button'] as $value ){//重新索引數組
                $redirect_button[] = $value;
            }
            $_POST['info']['redirect_button'] = addslashes(json_encode( $redirect_button ));

            //提示信息字符串,這裡不用動,ok
            $end_str = $old_end =  '<script type="text/javascript">window.top.art.dialog({id:"test"}).close();window.top.art.dialog({id:"test",content:\'<h2>'.L("add_success").'</h2><span style="fotn-size:16px;">'.L("following_operation").'</span><br /><ul style="fotn-size:14px;"><li><a href="'.HTTP_REFERER.'" target="right" onclick="window.top.art.dialog({id:\\\'test\\\'}).close()">'.L("following_operation_2").'</a></li></ul>\',width:"400",height:"200"});</script>';

            if(!isset($_POST['batch_add']) || empty($_POST['batch_add'])) {//單條添加

                //分區名的拼音形式,ok
                $catname = CHARSET == 'gbk' ? $_POST['info']['catname'] : iconv('utf-8','gbk',$_POST['info']['catname']);
                $letters = gbk_to_pinyin($catname);
                $_POST['info']['letter'] = strtolower(implode('', $letters));

                //添加新分區,ok
                $catid = $this->db->insert($_POST['info'], true);

                //更新父子節點關聯字段,ok
                $this->categorys = $categorys = $this->db->select(array('siteid'=>$this->siteid,'module'=>'partition'), '*', '', 'listorder ASC, catid ASC', '', 'catid');
                $up['arrparentid'] = $this->get_arrparentid( $catid );
                $up['arrchildid'] = $this->get_arrchildid( $catid );
                $up_where['catid'] = $catid;
                //更新當前節點的 關聯節點字段(初始化關聯父節點, 關聯子節點)
                $this->db->update( $up, $up_where );
                //更新所有父節點 關聯節點字段(關聯子節點)
                $arrparentid = explode( ",", $up['arrparentid'] );
                foreach( $arrparentid as $key=>$value ){
                    if($value == 0) continue;
                    $parent_up['arrchildid'] = $this->get_arrchildid( $value );
                    $parent_up['child'] = 1;
                    $parent_up_where['catid'] = $value;
                    $this->db->update( $parent_up, $parent_up_where );
                }

                /*
                //父子節點相關字段更新,notok
                //初始化新分區子節點字符串值
                $this->db->update(array('arrchildid'=>$catid), array('catid'=>$catid));
                //更新父子節點關聯,這裡待完善
                //有父節點的話,初始化新分區父節點字符串值->復制父分區相應節點值後,增加新分區
                if( $_POST['info']['parentid']  ){
                    $parentids = $this->db->select( array('catid'=>$_POST['info']['parentid']), 'arrparentid' );
                    //更新子節點的
                    $this->db->update( array('arrchildid'=>$parentids['arrchildid']), array('catid'=>$catid) );
                }*/

                //更新權限,ok
                /*
                $this->update_priv($catid, $_POST['priv_roleid']);
                $this->update_priv($catid, $_POST['priv_groupid'],0);
                */

                //添加關聯遊戲,ok
                $relation_game = explode("|", trim($_POST['relation_game'], "|"));
                if( !empty($relation_game[0]) ){
                    //分區id
                    // foreach( $relation_game as $key=>$value ){ 
                    //  $game_item = explode("-", $value);
                    //  $game_data[$key]['part_id'] = $catid;
                    //  $game_data[$key]['modelid'] = ($game_item[0] == 'ios') ? 20 : 21;
                    //  $game_data[$key]['gameid'] = $game_item[1];
                    // }
                    //新庫遊戲入庫 212|332
                    foreach( $relation_game as $key=>$value ){ 
                        $game_data[$key]['part_id'] = $catid;
                        // $game_data[$key]['modelid'] = ($game_item[0] == 'ios') ? 20 : 21;
                        $game_data[$key]['gameid'] = $value;
                        $game_data[$key]['newgame'] = 1 ;
                    }
                    //$partition_games = pc_base::load_model('partition_games_model');
                    $this->db_partition_relationgames->batch_insert($game_data);
                }

            } else {//批量添加,這裡待審核,notok
                $end_str = '';
                $batch_adds = explode("\n", $_POST['batch_add']);

                foreach ($batch_adds as $_v) {
                    if(trim($_v)=='') continue;
                    $names = explode('|', $_v);
                    $catname = $names[0];
                    $_POST['info']['catname'] = trim($names[0]);

                    //已存該字段,但對專區來說沒什麼用
                    $letters = gbk_to_pinyin($catname);
                    $_POST['info']['letter'] = strtolower(implode('', $letters));

                    //添加欄目
                    $catid = $this->db->insert($_POST['info'], true);

                    /*
                    //角色權限設定
                    $this->update_priv($catid, $_POST['priv_roleid']);
                    //組權限設定
                    $this->update_priv($catid, $_POST['priv_groupid'],0);
                    */
                }

                //提示 因已存在而沒有添加的欄目 或 成功信息
                $end_str = $end_str ? L('follow_catname_have_exists').$end_str : $old_end;
            }

            showmessage(L('add_success').$end_str);

        } else {//顯示模板信息

            //獲取站點模板信息,ok
            pc_base::load_app_func('global');

            //模板風格,ok
            $template_list = template_list($this->siteid, 0);
            foreach ($template_list as $k=>$v) {
                $template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
                unset($template_list[$k]);
            }

            //不用動它就行,待審核,notok
            $show_validator = '';
            if(isset($_GET['parentid'])) {//添加子分區時,繼承父分區配置,待審核,notok
                $parentid = $_GET['parentid'];
                $r = $this->db->get_one(array('catid'=>$parentid));
                if($r) extract($r,EXTR_SKIP);
                $setting = string2array($setting);
                //繼承忽略SEO項 by jozh 2014-04-30
                foreach($setting as $k=>$v){
                    if( in_array($k,array('meta_title','meta_keywords','meta_description')) ){
                        $setting[$k] = '';
                    }
                }
            }
            if( !empty($_GET['parentid']) ){//分區選擇
                //echo $_GET['parentid'];
                $this->categorys = $categorys = $this->db->select(array('siteid'=>$this->siteid,'module'=>'partition'), '*', '', 'listorder ASC, catid ASC', '', 'catid');
                $sub_arrparentid = $this->get_arrparentid( $parentid );
                if( $sub_arrparentid ){//有父分區
                    $sub_id = explode( ",", $sub_arrparentid );
                    $is_sub = $sub_id[1] ? 1 : 0;
                }else{//無父分區
                    $sub_id[1] = $_GET['parentid'];
                    $is_sub = 1;
                }
                $do_show = 1;
            }
            if( $catid ){
                $is_parent = $this->db->get_one('`catid`='.$catid, 'parentid');
            }

            //專區面包屑
            $curr_parent_name = '';
            $tmp_arrparentid = explode( ',', $r['arrparentid'] );
            if( $_GET['parentid'] ){//面包屑父級專區
                foreach( $tmp_arrparentid as $v_id ){
                    if( $v_id == 0 ){ continue; }
                    $temp_curr_parent_name = $this->db->get_one( '`catid`='.$v_id, 'catname' );
                    $conn_str = $curr_parent_name ? ' &gt; ' : '';
                    $curr_parent_name .= $conn_str.$temp_curr_parent_name['catname'];
                }
                $conn_str = $curr_parent_name ? ' &gt; ' : '';
                $curr_parent_name .= $conn_str.$r['catname'].' &gt; 添加欄目';
            }else{
                $curr_parent_name .= '添加專區';
            }

            if( $r['arrparentid'] ){
                $nav_add = 1;

                $temp_nav_arrp = $this->db->get_one('`catid`='.$r['catid'], 'arrparentid' );
                $nav_pid = explode(",", $temp_nav_arrp['arrparentid']);
                $nav_pid_istop = $temp_nav_arrp['arrparentid'];
            }

            //關聯遊戲按鈕,ok
            $show_dialog = 1;
            $game_info = 'javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=hao&c=admin_hao&a=game_info\', title:\''.L('select_game_info').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);';
            pc_base::load_sys_class('form','',0);

            //分區這裡s參數始終為0,可整理這部分代碼,ok
            $type = $_GET['s'];
            if($type==0) {//添加分區
                include $this->admin_tpl('category_add');

            }

        }
    }


    /**
     * 修改分區
     */
    public function edit() {

        $act = 'edit';

        if(isset($_POST['dosubmit'])) {//修改操作

            //基本信息,ok
            pc_base::load_sys_func('iconv');
            $catid = 0;
            $catid = intval($_POST['catid']);
            $setting = $_POST['setting'];
            if($setting['tem_setting']['nav']){
                foreach($setting['tem_setting']['nav'] as $k_tn=>$v_tn){//空nav項濾重
                    if( empty($v_tn['name'])||empty($v_tn['nav_value']) ){
                        unset($setting['tem_setting']['nav'][$k_tn]);
                    }
                }
            }
            //by jozh
            if($setting['tem_setting']['fastnav']){
                foreach($setting['tem_setting']['fastnav'] as $k_tn=>$v_tn){//空nav項濾重
                    if( empty($v_tn['title'])||empty($v_tn['fastnav_id']) ){
                        unset($setting['tem_setting']['fastnav'][$k_tn]);
                    }
                }
            }
            // wap_setting nav正序存储
            if(is_array($setting['wap_setting']['nav'])) {
                usort($setting['wap_setting']['nav'],"partition_list_cmp_listorder");
            }
            //模塊配置數據處理
            if(!$setting['module_setting']){
                $setting['module_setting'] = $this->data_format($setting);
            }else{
                $setting['module_setting'] = keysort($setting['module_setting'],'listorder');
            }
            $_POST['info']['setting'] = array2string($setting);
            $_POST['info']['module'] = 'partition';
            $catname = CHARSET == 'gbk' ? safe_replace($_POST['info']['catname']) : iconv('utf-8','gbk',safe_replace($_POST['info']['catname']));
            $letters = gbk_to_pinyin($catname);
            $_POST['info']['letter'] = strtolower(implode('', $letters));

            /*
            //應用權限設置到子欄目,notok->待審核
            if($_POST['priv_child']) {
                $arrchildid = $this->db->get_one(array('catid'=>$catid), 'arrchildid');
                if(!empty($arrchildid['arrchildid'])) {
                    $arrchildid_arr = explode(',', $arrchildid['arrchildid']);
                    if(!empty($arrchildid_arr)) {
                        foreach ($arrchildid_arr as $arr_v) {
                            $this->update_priv($arr_v, $_POST['priv_groupid'], 0);
                        }
                    }
                }
            }
            */

            //應用模板到所有子欄目,應該是不用動,notok->待整理sh
            if($_POST['template_child']){
                $this->categorys = $categorys = $this->db->select(array('siteid'=>$this->siteid,'module'=>'partition'), '*', '', 'listorder ASC, catid ASC', '', 'catid');
                $idstr = $this->get_arrchildid($catid);
                 if(!empty($idstr)){
                    $sql = "select catid,setting from phpcms_category where catid in($idstr)";
                    $this->db->query($sql);
                    $arr = $this->db->fetch_array();
                    if(!empty($arr)){
                        foreach ($arr as $v){
                            $new_setting = array2string(
                            array_merge(string2array($v['setting']), array('category_template' => $_POST['setting']['category_template'],'list_template' =>  $_POST['setting']['list_template'],'show_template' =>  $_POST['setting']['show_template'])
                                                    )
                            );
                            $this->db->update(array('setting'=>$new_setting), 'catid='.$v['catid']);
                        }
                    }
                }
            }


            if( $catid == $_POST['info']['parentid'] ){//防止自動修改parentid
                unset($_POST['info']['parentid']);
            }else{//更新上級分區關聯

                //更新父子節點關聯字段,ok
                $this->categorys = $categorys = $this->db->select(array('siteid'=>$this->siteid,'module'=>'partition'), '*', '', 'listorder ASC, catid ASC', '', 'catid');
                $up_old['arrparentid'] = $this->get_arrparentid( $catid );
                $arrparentid_old = explode( ",", $up_old['arrparentid'] );

                //標識新父級更新關聯
                $update_relation = 1;
            }

            //頭圖
            $header_pic = array();
            foreach( $_POST['header_pic'] as $value ){
                $header_pic[] = $value;
            }
            $_POST['info']['header_pic'] = addslashes(json_encode($header_pic));
            //跳轉button
            $redirect_button = array();
            foreach( $_POST['redirect_button'] as $value ){//重新索引數組
                $redirect_button[] = $value;
            }
            $_POST['info']['redirect_button'] = addslashes(json_encode( $redirect_button ));

            //更新分區信息,ok
            $this->db->update($_POST['info'],array('catid'=>$catid,'siteid'=>$this->siteid));

            if( $update_relation ){//更新上級分區關聯
                //更新父子節點關聯字段,ok
                // $this->categorys = $categorys = $this->db->select(array('siteid'=>$this->siteid,'module'=>'partition'), '*', '', 'listorder ASC, catid ASC', '', 'catid');
                $up['arrparentid'] = $this->get_arrparentid( $catid );
                $up['arrchildid'] = $this->get_arrchildid( $catid );
                $up_where['catid'] = $catid;
                //更新當前節點的 關聯節點字段(初始化關聯父節點, 關聯子節點)
                $this->db->update( $up, $up_where );
                //更新所有父節點 關聯節點字段(關聯子節點)
                $arrparentid = explode( ",", $up['arrparentid'] );
                foreach( $arrparentid as $key=>$value ){
                    if($value == 0) continue;
                    $parent_up['arrchildid'] = $this->get_arrchildid( $value );
                    $parent_up['child'] = strpos($parent_up['arrchildid'], ',') ? 1 : 0;
                    $parent_up_where['catid'] = $value;
                    $this->db->update( $parent_up, $parent_up_where );
                }
                //更新所有子節點 關聯節點字段(關聯子節點)
                $arrchildid = explode( ",", $up['arrchildid'] );
                foreach( $arrchildid as $key=>$value ){
                    if($value == $catid) continue;
                    $parent_up_2['arrparentid'] = $this->get_arrparentid( $value );
                    $parent_up_where_2['catid'] = $value;
                    $this->db->update( $parent_up_2, $parent_up_where_2 );
                }

                //更新原所有父節點 關聯節點字段(關聯子節點)
                foreach( $arrparentid_old as $key=>$value ){
                    if($value == 0) continue;
                    $parent_up_old['arrchildid'] = $this->get_arrchildid( $value );
                    $parent_up_old['child'] = strpos( $parent_up_old['arrchildid'], ',' ) ? 1 : 0;
                    $parent_up_where_old['catid'] = $value;
                    $this->db->update( $parent_up_old, $parent_up_where_old );
                }
            }

            //更新關聯遊戲,ok

            $partition_games = $this->db_partition_relationgames;
            $relation_game = explode("|", trim($_POST['relation_game'], "|"));
            if( !empty($relation_game[0]) ){
                //分區id
                foreach( $relation_game as $key=>$value ){
                    //增加對新庫遊戲關聯的判斷
                    if(strpos($value, '-')){
                        //關聯的老庫遊戲
                        $game_item = explode("-", $value);
                        $game_data[$key]['part_id'] = $catid;
                        $game_data[$key]['modelid'] = ($game_item[0] == 'ios') ? 20 : 21;
                        $game_data[$key]['gameid'] = $game_item[1];
                        $game_data[$key]['newgame'] = '0';
                        // 當專區關聯android遊戲時，向萬遊推送攻略標示 by yuzhewo
                        // if ($game_data[$key]['modelid'] == 21) {
                        //     $this->db->query("SELECT appid FROM www_androidgames WHERE id={$game_data[$key]['gameid']}");
                        //     $info = $this->db->fetch_array();
                        //     $appid = $info[0]['appid'];
                        //     if (!empty($appid)) {
                        //         $return = wanyou_tui_api($appid);
                        //     }
                        // }
                    }else{
                        //關聯的新庫遊戲
                        $game_data[$key]['part_id'] = $catid;
                        $game_data[$key]['modelid'] = 0;
                        $game_data[$key]['gameid'] = $value;
                        $game_data[$key]['newgame'] = 1 ;
                    }
                    
                }
                //先清除老關聯關系
                $partition_game_delete['part_id'] = $catid;
                $partition_games->delete($partition_game_delete);
                //重新入庫新的關聯關系
                $partition_games->batch_insert($game_data);
            }else{
                //關聯的遊戲全被清除
                $partition_game_delete['part_id'] = $catid;
                $partition_games->delete( $partition_game_delete );
            }

            /*
            //更新權限信息,ok
            $this->update_priv($catid, $_POST['priv_roleid']);
            $this->update_priv($catid, $_POST['priv_groupid'],0);
            */

            //showmessage(L('operation_success').'','?m=partition&c=partition&a=init&module=admin&menuid=43');
            showmessage(L('operation_success'),HTTP_REFERER);

        } else {//顯示模板,ok
            //獲取站點模板信息,ok
            pc_base::load_app_func('global');

            //模板信息,ok
            $template_list = template_list($this->siteid, 0);
            foreach ($template_list as $k=>$v) {
                $template_list[$v['dirname']] = $v['name'] ? $v['name'] : $v['dirname'];
                unset($template_list[$k]);
            }

            //查詢分區信息,ok
            $show_validator = $catid = $r = '';
            $catid = intval($_GET['catid']);
            pc_base::load_sys_class('form','',0);
            $r = $this->db->get_one(array('catid'=>$catid));
            if($r) extract($r);
            $setting = string2array($setting);

            // 查詢專區英文標識
            if($parentid != 0){ // 非專區id，即專區下欄目id
                $temp_arr = explode(',', $arrparentid);
                $partition_id = $temp_arr[1];
                $temp_r = $this->db->get_one(array('catid'=>$partition_id));
                $domain_dir = $temp_r['domain_dir'];
            }
            // 生成內嵌頁鏈接
            if(strpos($_SERVER['HTTP_HOST'], 'zc.test') === 0){
                $iframe_url = 'http://'.$_SERVER['HTTP_HOST'].'/www/p/'.$domain_dir.'/';
            }else{
                $iframe_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$domain_dir.'/';
            }
            //查詢權限,ok
            $this->priv_db = pc_base::load_model('category_priv_model');
            $this->privs = $this->priv_db->select(array('catid'=>$catid));

            //關聯遊戲,notok->1.待核對數字值測試 2.id重復時可能刪除id會出問題
            //輸出格式->"ios-123,android-456"

            $relate_games = $this->db_partition_relationgames->select( '`part_id`='.$catid);
            $related_games = '';
            $game_info_array = array();
            foreach( $relate_games as $key=>$value ){
                //增加對新老關聯關系的判斷
                if($value['newgame']!=1){//老關聯關系
                    switch( $value['modelid']  ){//模型名
                    case 20:
                        $model_name = 'ios';
                        $this->db_content->set_model(20);
                        $temp_game_title = $this->db_content->get_one('`id`='.$value['gameid'],'title');
                        $game_info_array['ios-'.$value['gameid']] = $temp_game_title['title'];
                        break;
                    case 21:
                        $model_name = 'android';
                        $this->db_content->set_model(21);
                        $temp_game_title = $this->db_content->get_one('`id`='.$value['gameid'],'title');
                        $game_info_array['android-'.$value['gameid']] = $temp_game_title['title'];
                        break;
                    }
                    $related_games = $related_games.'|'.$model_name.'-'.$value['gameid'];
                }else{//新庫關聯關系
                    //查詢新遊的名稱
                    $gameid = intval($value['gameid']);
                    $game_api = "http://game.mofang.com/api/web/GetGameInfo?id=".$gameid;
                    $datas = mf_curl_get($game_api);
                    $datas = json_decode($datas,true);
                    $return = array();
                    if($datas['code']=='0') { 
                        $game_info_array[$value['gameid']] = $datas['data']['name'];
                    }
                    $related_games = $related_games.'|'.$value['gameid'];
                }
                
            }
            $related_games = trim($related_games, '|');

            //關聯遊戲按鈕,ok
            $show_dialog = 1;
            //$rela_game_info = 'javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=hao&c=admin_hao&a=game_info\', title:\''.L('select_game_info').'\', width:\'700\', height:\'500\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);';
            pc_base::load_sys_class('form','',0);

            //專區面包屑
            $curr_parent_name = '';
            $tmp_arrparentid = explode( ',', $r['arrparentid'] );
            if( $r['arrparentid'] ){//面包屑父級專區
                foreach( $tmp_arrparentid as $v_id ){
                    if( $v_id == 0 ){ continue; }
                    $temp_curr_parent_name = $this->db->get_one( '`catid`='.$v_id, 'catname' );
                    $conn_str = $curr_parent_name ? ' &gt; ' : '';
                    $curr_parent_name .= $conn_str.$temp_curr_parent_name['catname'];
                }

                $conn_str = $curr_parent_name ? ' &gt; ' : '';
                $curr_parent_name .= $conn_str.$r['catname'].' &gt; 修改欄目';
            }else{
                $curr_parent_name = $r['catname'].' &gt; 修改欄目';
            }

            $temp_nav_arrp = $this->db->get_one('`catid`='.$r['catid'], 'arrparentid' );
            $nav_pid = explode(",", $temp_nav_arrp['arrparentid']);
            $nav_pid_istop = $temp_nav_arrp['arrparentid'];

            //頭圖
            $header_pic_array = json_decode($r['header_pic'], true);
            $count_header_pic = count( $header_pic_array );
            //跳轉button
            $redirect_button_array = json_decode($r['redirect_button'], true);
            $count_button = count( $redirect_button_array );

            //這裡type始終為0,ok
            $type = $_GET['type'];
            if($type==0) {
                include $this->admin_tpl('category_edit');
            }
        }
    }


    /**
     * 排序,需修改,應該是沒問題了,待最終審查,待增加指定功能,notok
     */
    public function listorder() {
        if(isset($_POST['dosubmit'])) {
            foreach($_POST['listorders'] as $id => $listorder) {
                $this->db->update(array('listorder'=>$listorder),array('catid'=>$id));
            }
            showmessage(L('operation_success'),HTTP_REFERER);
        } else {
            showmessage(L('operation_failure'));
        }
    }

    /**
     * 刪除欄目,子欄目刪除有問題,修改
     * 1.待加刪除關聯權限信息
     */
    public function delete() {

        $catid = intval($_GET['catid']);
        $temp_parentid = $this->db->get_one(array('catid'=>$catid), 'parentid');

        //modelid在功能上沒起作用,ok
        $modelid=0;
        $this->delete_child($catid, $modelid);
        $this->db->delete(array('catid'=>$catid));

        //刪除關聯遊戲和關聯文章,ok
        $relation['part_id'] = $catid;
        $this->db_partition_games->delete( $relation );
        $this->db_partition_relationgames->delete( $relation );

        //更新父節點關聯字段,ok
        $this->categorys = $categorys = $this->db->select(array('siteid'=>$this->siteid,'module'=>'partition'), '*', '', 'listorder ASC, catid ASC', '', 'catid');

        //查詢節點的父節點,然後更新父節點的子節點(需判斷一下是否還有child),然後更新父節點的父節點的子節點字段
        //更新直接父節點的child字段和arrchild
        $temp_parent_data = $this->db->get_one(array('parentid'=>$temp_parentid['parentid']));
        $up['child'] = empty($temp_parent_data) ? 0 : 1;
        $up['arrchildid'] = $this->get_arrchildid( $temp_parentid['parentid'] );
        $up_where['catid'] = $temp_parentid['parentid'];
        $this->db->update( $up, $up_where );

        //更新所有父節點 關聯節點字段(關聯子節點)
        $arrparentid = explode( ",", $this->get_arrparentid( $temp_parentid['parentid'] ) );
        foreach( $arrparentid as $key=>$value  ){
            if($value == 0) continue;
            $parent_up['arrchildid'] = $this->get_arrchildid( $value );
            $parent_up['child'] = 1;
            $parent_up_where['catid'] = $value;
            $this->db->update( $parent_up, $parent_up_where );
        }

        showmessage(L('operation_success'),HTTP_REFERER);
    }

    /**
     * 遞歸刪除欄目
     * 1.待增加刪除關聯遊戲和關聯文章功能處理
     * @param $catid 要刪除的欄目id
     */
    private function delete_child($catid, $modelid) {
        $catid = intval($catid);
        if (empty($catid)) return false;
        while( $r = $this->db->get_one(array('parentid'=>$catid)) ){
            if($r) {
                $this->delete_child($r['catid']);
                $this->db->delete(array('catid'=>$r['catid']));

                //刪除關聯遊戲和關聯文章,ok
                $relation['part_id'] = $r['catid'];
                $this->db_partition_games->delete( $relation );
                $this->db_partition_relationgames->delete( $relation );
            }
        }
        return true;
    }

    /**
     *
     * 獲取父分區ID列表,ok
     * @param integer $catid              欄目ID
     * @param array $arrparentid          父目錄ID
     * @param integer $n                  查找的層次
     */
    private function get_arrparentid($catid, $arrparentid = '', $n = 1) {
        if($n > 5 || !is_array($this->categorys) || !isset($this->categorys[$catid])) return false;
        $parentid = $this->categorys[$catid]['parentid'];
        $arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
        if($parentid) {
            $arrparentid = $this->get_arrparentid($parentid, $arrparentid, ++$n);
        } else {
            $this->categorys[$catid]['arrparentid'] = $arrparentid;
        }
        $parentid = $this->categorys[$catid]['parentid'];
        return $arrparentid;
    }

    /**
     *
     * 獲取子欄目ID列表,ok
     * @param $catid 欄目ID
     */
    private function get_arrchildid($catid) {
        $arrchildid = $catid;
        if(is_array($this->categorys)) {
            foreach($this->categorys as $id => $cat) {
                if($cat['parentid'] && $id != $catid && $cat['parentid']==$catid) {
                    $arrchildid .= ','.$this->get_arrchildid($id);
                }
            }
        }
        return $arrchildid;
    }

    /**
     * 更新權限,notok->待審查
     * @param  $catid
     * @param  $priv_datas
     * @param  $is_admin
     */
    private function update_priv($catid,$priv_datas,$is_admin = 1) {
        return true;
        $this->priv_db = pc_base::load_model('category_priv_model');
        $this->priv_db->delete(array('catid'=>$catid,'is_admin'=>$is_admin));
        if(is_array($priv_datas) && !empty($priv_datas)) {
            foreach ($priv_datas as $r) {
                $r = explode(',', $r);
                $action = $r[0];
                $roleid = $r[1];
                $this->priv_db->insert(array('catid'=>$catid,'roleid'=>$roleid,'is_admin'=>$is_admin,'action'=>$action,'siteid'=>$this->siteid));
            }
        }
    }

    /**
     * 檢查欄目權限,notok->待審查
     * @param $action 動作
     * @param $roleid 角色
     * @param $is_admin 是否為管理組
     */
    private function check_category_priv($action,$roleid,$is_admin = 1) {
        $checked = '';
        foreach ($this->privs as $priv) {
            if($priv['is_admin']==$is_admin && $priv['roleid']==$roleid && $priv['action']==$action) $checked = 'checked';
        }
        return $checked;
    }


    /**
     * 遊戲信息,notok->安卓(搜索時)添加遊戲bug處理
     */
    //可增加Ajax更新遊戲列表
    //搜索是小bug修改
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
     * 信息導入分區,待審核,notok
     * 1.待審核列表數據來源,以及是否有緩存
     */
    public function import() {

        $this->partition_api = pc_base::load_app_class('partition_api', 'partition');
        pc_base::load_sys_class('form','',0);
        pc_base::load_sys_class('format','',0);

        if(isset($_POST['dosubmit']) || isset($_GET['dosubmit'])) {//提交導入數據

            if(!is_array($_POST['ids']) || empty($_POST['ids']) || !$_GET['modelid']) showmessage(L('illegal_action'), HTTP_REFERER);
            //分類
            if(!isset($_POST['typeid']) || empty($_POST['typeid'])) showmessage(L('select_type'), HTTP_REFERER);

            foreach($_POST['ids'] as $id) {
                //$this->special_api->_import($_GET['modelid'], $_GET['specialid'], $id, $_POST['typeid'], $_POST['listorder'][$id]);
                $this->partition_api->_import($_GET['modelid'], $_GET['specialid'], $id, $_POST['typeid']);
            }

            //$this->solr_index($_GET['modelid'],$_POST['ids'],$_GET['specialid']);

            //showmessage(L('import_success'), 'blank', '', 'import');
            showmessage(L('import_success'), 'blank', '3600', 'import');
            //$this->db_content = pc_base::load_model('content_model');

        } else {

            //判斷非法操作,notok->待修改參數名
            if(!$_GET['specialid']) showmessage(L('illegal_action'), HTTP_REFERER);

            $specialid = $_GET['specialid'];

            //ok
            $_GET['modelid'] = $_GET['modelid'] ? intval($_GET['modelid']) : 0;
            $_GET['catid'] = $_GET['catid'] ? intval($_GET['catid']) : 0;
            $_GET['page'] = max(intval($_GET['page']), 1);
            $where = '';
            if($_GET['catid']) $where .= get_sql_catid('category_content_'.$this->get_siteid(), $_GET['catid'])." AND `status`=99";
            else $where .= " `status`=99";
            if($_GET['start_time']) {
                $where .= " AND `inputtime`>=".strtotime($_GET['start_time']);
            }
            if($_GET['end_time']) {
                $where .= " AND `inputtime`<=".strtotime($_GET['end_time']);
            }
            if ($_GET['key']) {
                $where .= " AND `title` LIKE '%$_GET[key]%' OR `keywords` LIKE '%$_GET[key]%'";
            }

            //ok
            $data = $this->partition_api->_get_import_data($_GET['modelid'], $where, $_GET['page']);
            foreach( $data as $key=>$value ){
                $search_data_where['modelid'] = $_GET['modelid'];
                $search_data_where['gameid'] = $value['id'];
                $temp_part_id = $this->db_partition_games->select( $search_data_where, 'part_id' );
                if( count($temp_part_id)>1 ){
                    $data[$key]['importd_ids'] = '';
                    foreach( $temp_part_id as $key1=>$value1 ){
                        $data[$key]['imported_ids'] .= ','.$value1['part_id'];
                    }
                    $data[$key]['imported_ids'] = ltrim($data[$key]['imported_ids'], ',');
                }elseif( count($temp_part_id)==1 ){
                    $data[$key]['imported_ids'] = $temp_part_id[0]['part_id'];
                }else{
                    $data[$key]['imported_ids'] = '';
                }
            }

            $pages = $this->partition_api->pages;

            //除會員外的模型列表,notok->改為直接查表
            $models = getcache('model','commons');
            $model_datas = array();
            foreach($models as $_k=>$_v) {
                if($_v['siteid']==$this->get_siteid()) {
                    $model_datas[$_v['modelid']] = $_v['name'];
                }
            }
            $model_form = form::select($model_datas, $_GET['modelid'], 'name="modelid" onchange="select_categorys(this.value)"', L('select_model'));

            //分類名,notok->待測數據來源
            $types = $this->partition_api->_get_types($specialid);

            include $this->admin_tpl('import_content');
        }
    }
    
    /**
     * 按模型ID列出模型下的欄目,ok
     */
    public function public_categorys_list() {
        pc_base::load_sys_class('form','',0);
        if(!isset($_GET['modelid']) || empty($_GET['modelid'])) exit('');
        $modelid = intval($_GET['modelid']);
        exit(form::select_category('', $_GET['catid'], 'name="catid" id="catid"', L('please_select'), $modelid, 0, 1));
    }

    function solr_index ($modelid, $ids, $specialid) {
        $arrid = $this->db->get_one(array('catid'=>$specialid),'arrparentid');
        $arrids = explode(',', $arrid['arrparentid']);
        $partition = $arrids[1];

        //獲取siteid
        $siteid = isset($_REQUEST['siteid']) && trim($_REQUEST['siteid']) ? intval($_REQUEST['siteid']) : 1;
        //搜索配置
        $search_setting = getcache('search','search');
        $setting = $search_setting[$siteid];
        $solr = pc_base::load_app_class('apache_solr_service', 'search', 0);
        $solr = new Apache_Solr_Service($setting['solrhost'], $setting['solrport'], $setting['solrdir']);

        $document = new Apache_Solr_Document();

        $content_db = pc_base::load_model('content_model');
        $model = getcache('model', 'commons');
        $table = $content_db->table_name = $content_db->db_tablepre.$model[$modelid]['tablename'];
        foreach ($ids as $id) {
            $info = $content_db->get_one(array('id'=>$id),'catid,id');
            $ukid = $info['catid'].'0'.$info['id'];
            try {
                $data = $solr->search("ukid:$ukid");
                foreach ($data->response->docs[0] as $k=>$v) {
                    $document->$k = $v;
                }
                $document->partition = $partition;
                $document->specialid = $specialid;
                $solr->addDocument($document);
            } catch (Exception $e) {
                continue;
            }
        }
        $solr->commit();
        
    }
    /**
     * 格式化數據 by jozh
     */
    public function data_format($setting){
        $setting['module_setting'] = array();
        //攻略及新手指引
        if(isset($setting['tem_setting']['gls'])&&isset($setting['tem_setting']['guide'])){
            $setting['module_setting'][0]['type']='newgls_guide';
            $setting['module_setting'][0]['listorder']=$setting['tem_setting']['column']['newgls_guide']['listorder'];
            $setting['module_setting'][0]['gls']=$setting['tem_setting']['gls'];
            $setting['module_setting'][0]['guide']=$setting['tem_setting']['guide'];
            $setting['module_setting'][0]['disable_type']=$setting['tem_setting']['newgls_guide_disable_type'];
        }
        //副本信息
        if(isset($setting['tem_setting']['team'])){
            $setting['module_setting'][1]['type'] = 'team';
            $setting['module_setting'][1]['listorder']=$setting['tem_setting']['column']['team']['listorder'];
            foreach($setting['tem_setting']['team'] as $k => $v){
                $setting['module_setting'][1][$k] = $v;
            }
        }
        //視頻
        if(isset($setting['tem_setting']['video'])){
            $setting['module_setting'][2]['type']='video';
            $setting['module_setting'][2]['listorder']=$setting['tem_setting']['column']['video']['listorder'];
            foreach($setting['tem_setting']['video'] as $k => $v){
                $setting['module_setting'][2][$k] = $v;
            }
        }
        //左文右圖
        if(isset($setting['tem_setting']['pvp'])){
            $setting['module_setting'][3]['type']='pvp';
            $setting['module_setting'][3]['listorder']=$setting['tem_setting']['column']['pvp']['listorder'];
            foreach($setting['tem_setting']['pvp'] as $k => $v){
                $setting['module_setting'][3][$k] = $v;
            }
        }
        //圖鑑
        if(isset($setting['tem_setting']['tujian'])){
            $setting['module_setting'][4]['type']='tujian_topic';
            $setting['module_setting'][4]['listorder']=$setting['tem_setting']['column']['tujian_topic']['listorder'];
            $setting['module_setting'][4]['tujian']=$setting['tem_setting']['tujian'];
            $setting['module_setting'][4]['disable_type']=$setting['tem_setting']['tujian_topic_disable_type'];
        }
        //圖集
        if(isset($setting['tem_setting']['tuji'])){
            $setting['module_setting'][5]['type']='tuji';
            $setting['module_setting'][5]['listorder']=$setting['tem_setting']['column']['tuji']['listorder'];
            foreach($setting['tem_setting']['tuji'] as $k => $v){
                $setting['module_setting'][5][$k] = $v;
            }
        }
        sort($setting['module_setting']);
        foreach($setting['module_setting'] as $k => $v){
            $ks=intval($v['listorder']);
            $setting['module_setting'][$ks]=$v;
        }
        unset($setting['module_setting'][0]);
        return $setting['module_setting'];
    }



    /**
    * 新的產品庫接口列表 （王官慶） 
    */
    public function public_relation_game_list(){
        $keywords = urlencode($_GET['keywords']);
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $pagesize = intval($_GET['pagesize']) ? intval($_GET['pagesize']) : 4;
        $offset = ($page - 1)*$pagesize;
        $game_api = "http://game.mofang.com/api/game/list?keywords=".$keywords."&offset=".$offset."&count=".$pagesize;
        $datas = mf_curl_get($game_api);
        $datas = json_decode($datas,true);
        if($datas['code']=='0') {
            $infos = $datas['data'];
        }else{
            echo '產品庫未查詢到相關遊戲！';
        }
        $totals = $datas['message'];
        include $this->admin_tpl('relation_game_list');
    } 

    /**
     *  專區通用浮窗配置
     */
    public function setting() {
        pc_base::load_sys_class('form','',0);
        $m_db = pc_base::load_model('module_model');

        if(isset($_POST['dosubmit'])) {
            $setting = $_POST['setting'];
            setcache('partition', $setting, 'commons');  
            $set = array2string($setting);
            $m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
            showmessage('配置保存成功！', HTTP_REFERER);
        } else {
            $data = array();
            $data = $m_db->select(array('module'=>'partition'));
            $setting = string2array($data[0]['setting']);
            $now_seting = $setting; //當前站點對專區浮窗的配置
            include $this->admin_tpl('setting');
        }
    }
    /**
     *  主頁通欄設置信息 //時間緊急沒有存數據庫, cacche文件在commns/ index_mgs.cache.php
     */
    public function par_game_seting() {
        pc_base::load_sys_class('form','',0);
        $m_db = pc_base::load_model('module_model');
        if(isset($_POST['dosubmit'])) {
            $setting = $_POST['setting'];
           $rs= setcache('index_mgs', $setting, 'commons');  
           if($rs){
            showmessage('配置保存成功！', HTTP_REFERER);
           }
            $set = array2string($setting);
           // $m_db->update(array('setting'=>$set), array('module'=>ROUTE_M));
           // 
        } else {
            $data = array();
            $data = getcache("index_mgs","commons");
            $setting = $data; //當前站點對專區浮窗的配置
            include $this->admin_tpl('par_index_set');
        }
    }

    /*
    * 測試專區發布程序 9.11號
    */
    public function push_partition(){
        //當前測試專區目錄 
        $catid = intval($_GET['p']); 
        include $this->admin_tpl('upload_partition');

        // $source_dir = PHPCMS_PATH.'ftp'.DIRECTORY_SEPARATOR.'partition'.DIRECTORY_SEPARATOR.$partition_array['domain_dir'];
        // $target = PHPCMS_PATH.'ftp'.DIRECTORY_SEPARATOR.'partition'.DIRECTORY_SEPARATOR.$partition_array['domain_dir']; 
        // $upload_return = $this->zhiwei($source,$target,$module,$prefix); 


        // $list = array();
        // $list = glob($source_dir.DIRECTORY_SEPARATOR.'*');
        // if(!empty($list)) ksort($list);
        // if(is_array($list)){
        //  foreach ($list as $key => $v) {
        //      # code...
        //      echo $v.'<br>';
        //      $filename = basename($v);
        //      if(is_dir($v)){
        //          //目錄繼續掃描目錄下的文件 
        //          $list = glob($v.DIRECTORY_SEPARATOR.'*');

        //      }else{
        //          //文件直接請求志偉函數 
        //      }
        //  }
        // }

    }

    //專區模版上傳處理程序 
    public function upload_zq(){ 
        $catid = intval($_GET['catid']);
        if(!$catid){
            echo 0;
        }
        $push_partition = pc_base::load_app_class('push_partition','partition',1);
        $return = $push_partition->init($catid);
        if($return==1){
            echo 1;
        }else{
            echo 0;
        } 
    }

    //專區ID對應欄目ID配置（專區視頻導入欄目使用）
    public function partitionid_catid(){
        if(isset($_POST['dosubmit']) || isset($_GET['dosubmit'])) {
            $partition_id = $_POST['partition_id'];
            setcache('partitionid_catid', $partition_id,'partition');
            showmessage('配置保存成功！', HTTP_REFERER);
            exit; 
        }else{
            $catid = 1324;
            $all_categorys = getcache('category_content_1','commons'); 
            $models = getcache('model','commons');
            $tree = pc_base::load_sys_class('tree');
            $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;'; 

            //獲取以前的配置
            $old_setting = getcache('partitionid_catid','partition');

            $categorys = array();
            foreach($all_categorys as $r) {
                if(strpos($r['arrparentid'], "$catid")){
                    if($r['child']==0){

                        $r['modelname'] = '<input name="partition_id['.$r['catid'].']" type="text" size="46" value="'.$old_setting[$r['catid']].'" class="input-text-c input-text">';
                    }else{
                        $r['modelname'] = '';
                    }
                    
                    $r['style'] = $r['child'] ? 'color:#8A8A8A;' : '';
                    $r['click'] = $r['child'] ? '' : "onclick=\"select_list(this,'".safe_replace($r['catname'])."',".$r['catid'].")\" class='cu' title='".L('click_to_select')."'";
                    $categorys[$r['catid']] = $r;
                }
            }
            $str  = "<tr >
                        <td align='center'>\$id</td>
                        <td style='\$style'>\$spacer\$catname</td>
                        <td align='center'>\$modelname</td>
                    </tr>";
            $tree->init($categorys);
            $categorys = $tree->get_tree($catid, $str);
            include $this->admin_tpl('partitionid_catid');
        }
    }


    //專區視頻導入指定欄目
    public function partitionid_to_catid(){
        //獲取以前的配置
        $old_setting = getcache('partitionid_catid','partition');
        $old_setting = array_flip($old_setting);
        $new_array = array();
        foreach ($old_setting as $key => $value) {
            # code...
            if($value!=''){
                if(strpos($key, '|')){
                    $array = explode("|", $key);
                    foreach ($array as $key_2 => $value_2) {
                        # code...
                        $new_array[$value_2] = $value;
                    }
                }else{
                    $new_array[$key] = $value;
                }
            }
            
        }
        //循環所有專區文章，對比所在欄目屬於那個專區，進行視頻查找入庫
        $this->db_content->set_model(1);
        $pagesize = 20;
        $page = 1; 
        $start = 0;  
        while($start>=0){
            $offset = $pagesize*($page-1);
            $limit = "$offset,$pagesize";
            $rs = $this->db_partition_games->query("select * from www_partition_games ORDER BY id desc limit $limit");
            $data = $this->db_partition_games->fetch_array();
            if(!empty($data)){
                //判斷文章中是否有視頻，有則按對應關系導入，無則跳過
                foreach ($data as $key => $value){
                    $insert_data = array();
                    $title_array = $this->db_content->get_content( 81, $value['gameid']);
                    if($title_array['content']!=''){
                        //過渡是否有youku的視頻
                        $content = $title_array['content'];
                        preg_match_all("/\<embed.*?src\=\"(.*?)\"[^>]*>/i", $content, $match);
                        if(strpos($match[1][0],'youku')){
                            //youku
                            $array = explode("/", $match[1][0]);
                            $insert_data['youkuid'] = $array[5];
                            $is_video = 1;//是視頻
                        }elseif(strpos($match[1][0],'56')){
                            //56
                            $array = explode("/", $match[1][0]);
                            $array = explode(".", $array[3]);
                            $insert_data['v56_id'] = $array[0];
                            $is_video = 1;
                        }elseif(strpos($match[1][0],'qq')){
                            //qq
                            $array = explode("/", $match[1][0]);
                            $array = explode(".", $array[3]);
                            $insert_data['vqq_id'] = $array[0];
                            $is_video = 1;
                        }elseif (strpos($match[1][0],'tudou')) {
                            # 土豆
                            $array = explode("/", $match[1][0]);
                            $insert_data['tudou_id'] = $array[4];
                            $is_video = 1;
                        }else{
                            $is_video = 0 ;
                        }
                        if($is_video==1){
                            $insert_data['title'] = $title_array['title'];
                            // $insert_data['shortname'] = $title_array['shortname'];
                            $insert_data['thumb'] = $title_array['thumb'];
                            $insert_data['keywords'] = $title_array['keywords'];
                            $insert_data['description'] = $title_array['description'];
                            $insert_data['vision'] = 1;//畫質
                            $insert_data['video_category'] = 1;//視頻分類
                            $insert_data['inputtime'] = SYS_TIME;//增加時間
                            $insert_data['status'] = 99;//視頻狀態
                            $insert_data['sysadd'] = 1;//系統添加

                            $partition_array = $this->db->get_one(array("catid"=>$value['part_id']),'catid,arrparentid,catname');
                            $cat_array = explode(',', $partition_array['arrparentid']);
                            sort($cat_array); //順序排序 ，以0為起啟
                            $insert_data['catid'] = $new_array[$cat_array[1]];//視頻分類
                            if($insert_data['catid']){
                                $this->db_content->set_model(11); 
                                $id = $this->db_content->add_content($insert_data,1);//入視頻指定欄目 
                            }
                        } 
                    }
                }
                $page = $page+1;
                $start = 0;
            }else{
                //結果為空，說明查詢已經到最後
                echo '查詢全部結果！';
                $start = -1;
                exit();
            }
        }
    }

    //專區下文章搜索
    public function search_article(){
        // if(isset($_GET['dosubmit'])) {
            $search_catid = 1317;
            $the_parentid = intval($_GET['parentid']);
            $parentid = intval($_GET['parentid']);
            $page = intval($_GET['page']);//第幾頁
            $curr_parent_name = '專區文章搜索';
            $is_search = 1;//如果是搜索，不再顯示刪除和排序

            pc_base::load_sys_class('format','',0);
            $where = 'catid='.$search_catid.' AND status=99';
            $username = $_GET['user'];
            if(isset($username)){
                $where .= " AND username='{$username}'";
            } 
            //搜索
            if(isset($_GET['start_time']) && $_GET['start_time']) {
                $start_time = strtotime($_GET['start_time']);
                $where .= " AND `inputtime` > '$start_time'";
            }
            if(isset($_GET['end_time']) && $_GET['end_time']) {
                $end_time = strtotime($_GET['end_time']);
                $where .= " AND `inputtime` < '$end_time'";
            }
            if($start_time>$end_time) showmessage(L('starttime_than_endtime'));
            if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                $type_array = array('title','description','username');
                $searchtype = intval($_GET['searchtype']);
                if($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $keyword = strip_tags(trim($_GET['keyword']));
                    $where .= " AND `$searchtype` like '%$keyword%'";
                } elseif($searchtype==3) {
                    $keyword = intval($_GET['keyword']);
                    $where .= " AND `id`='$keyword'";
                }
            }
            if(isset($_GET['posids']) && !empty($_GET['posids'])) {
                $posids = $_GET['posids']==1 ? intval($_GET['posids']) : 0;
                $where .= " AND `posids` = '$posids'";
            }
            $this->db_content->set_model(1);
            $datas = $this->db_content->listinfo($where,'inputtime desc',$page,15);
            $pages = $this->db_content->pages;
            $pc_hash = $_SESSION['pc_hash'];
            include $this->admin_tpl('content_list');
        // }
    }

    //圖片上傳測試
    public function test_pic(){
        $new_pic = pc_base::load_sys_class('image_new','',1);
        $source = PHPCMS_PATH.'statics/s_test/event';//測試目錄 
        $target = PHPCMS_PATH.'statics/s/event';//切後存的目錄
        $pic_url = $source.DIRECTORY_SEPARATOR."a.jpeg";
        $return = $new_pic->cut_images($pic_url,$target,800,100);//寬800，高100的切，存成多個文件 
        print_r($return);
    }

}
?>
