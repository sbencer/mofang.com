<?php


if (!function_exists('arr_to_html')) {

    function arr_to_html($data) {
        if (is_array($data)) {
            $str = 'array(';
            foreach ($data as $key=>$val) {
                if (is_array($val)) {
                    $str .= "'$key'=>".arr_to_html($val).",";
                } else {
                    if (strpos($val, '$')===0) {
                        $str .= "'$key'=>$val,";
                    } else {
                        $str .= "'$key'=>'".new_addslashes($val)."',";
                    }
                }
            }
            return $str.')';
        }
        return false;
    }

}
/// 停用了pc:block標記
/// pc:content action=nav_list ... -> pc M=content action=nav_list ...
/// 停用了phpcms的緩存處理
/// pc:json     -> pc A=json
/// pc:xml      -> pc A=xml
/// pc:get      -> pc A=get
/// pc:block    -> XXXXXX
/// pc:<module> -> pc M=<module>

// 如果在MFE的測試環境，輸出空處理，這樣與數據模型完全隔離
if(!MFE_SMART_DEBUG){

    /// $op, $data,$html
    function smarty_compiler_pc($arrParams, $smarty){
        foreach ($arrParams as $_key => $_value) {
            $arrParams[$_key] = str_replace("'","",$_value);
        }
        $op = $arrParams["M"];
        if(!$op){
            $op = $arrParams["A"];
        }
        unset($arrParams["M"]);
        unset($arrParams["A"]);

        // preg_match_all("/([a-z]+)\=[\"]?([^\"]+)[\"]?/i", stripslashes($data), $matches, PREG_SET_ORDER);

        // 不作為參數傳入的列表
        $arr = array('action','num','cache','page', 'pagesize', 'urlrule', 'return', 'start');

        // 輔助操作標記 pc:json  pc:xml pc:get
        // pc:block: ** 禁止調用
    //    $tools = array('json', 'xml','block' ,'get');
        $tools = array('json', 'xml' ,'get');
        $datas = array();


    //    $tag_id = md5(stripslashes($html));

        //可視化條件
    //    $str_datas = 'op='.$op.'&tag_md5='.$tag_id;
        $str_datas = 'op='.$op;

    //    foreach ($matches as $v) {
    //
    //        $str_datas .= $str_datas ?
    //            "&$v[1]=".($op == 'block' && strpos($v[2], '$') === 0 ? $v[2] : urlencode($v[2])) :
    //            "$v[1]=".(strpos($v[2], '$') === 0 ? $v[2] : urlencode($v[2]));
    //
    //        if(in_array($v[1], $arr)) {
    //            $$v[1] = $v[2];
    //            continue;
    //        }
    //        $datas[$v[1]] = $v[2];
    //    }

        foreach ($arrParams as $_key => $_value) {

            if(strpos($_value, '$') === 0){
                //preg_match_all("/\[\s*(.*)\s*\]/i", stripslashes($_value), $mm, PREG_SET_ORDER);
                //$_value = "$".$mm[0][1];
                $_value = '".'.$_value.'."';
            }else{
                $_value = urlencode($_value);
            }
            if($str_datas){
                $str_datas .= "&".$_key."=".$_value;
            }else{
                $str_datas .= $_key."=".$_value;
            }
        }


        foreach ($arrParams as $_key => $_value) {
            if(in_array($_key, $arr)) {
                $$_key = $_value;
                continue;
            }
            $datas[$_key] = $_value;
        }

        $str = '';
//        $num = isset($num) && intval($num) ? intval($num) : 20;
    //    $cache = isset($cache) && intval($cache) ? intval($cache) : 0;
        $return = isset($return) && trim($return) ? trim($return) : 'data';
        if (!isset($urlrule)) $urlrule = '';

    //    // 緩存處理
    //    if (!empty($cache) && !isset($page)) {
    //        $str .= '$tag_cache_name = md5(implode(\'&\','.arr_to_html($datas).').\''.$tag_id.'\');if(!$'.$return.' = tpl_cache($tag_cache_name,'.$cache.')){';
    //    }

        // 如果是特殊操作
        if (in_array($op,$tools)) {
            switch ($op) {
                case 'json':
                    if (isset($datas['url']) && !empty($datas['url'])) {
                        $str .= '$json = @file_get_contents(\''.$datas['url'].'\');';
                        $str .= '$'.$return.' = json_decode($json, true);';
                    }
                    break;

                case 'xml':
                    $str .= '$xml = pc_base::load_sys_class(\'xml\');';
                    $str .= '$xml_data = @file_get_contents(\''.$datas['url'].'\');';
                    $str .= '$'.$return.' = $xml->xml_unserialize($xml_data);';
                    break;

                case 'get':
                    $str .= 'pc_base::load_sys_class("get_model", "model", 0);';
                    if ($datas['dbsource']) {
                        $dbsource = getcache('dbsource', 'commons');
                        if (isset($dbsource[$datas['dbsource']])) {
                            $str .= '$get_db = new get_model('.var_export($dbsource,true).', \''.$datas['dbsource'].'\');';
                        } else {
                            return false;
                        }
                    } else {
                        $str .= '$get_db = new get_model();';
                    }
//                    $num = isset($num) && intval($num) > 0 ? intval($num) : 20;
                    if (isset($start) && intval($start)) {
                        $limit = intval($start).','.$num;
                    } else {
                        $limit = $num;
                    }
                    if (isset($page)) {
                        $str .= '$pagesize = '.$num.';';
                        $str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
                        $str .= '$offset = ($page - 1) * $pagesize;';
                        $limit = '$offset,$pagesize';
                        if ($sql = preg_replace('/select([^from].*)from/i', "SELECT COUNT(*) as count FROM ", $datas['sql'])) {
                            $str .= '$r = $get_db->sql_query("'.$sql.'");$s = $get_db->fetch_next();$pages=pages($s[\'count\'], $page, $pagesize, $urlrule);';
                        }
                    }
                    $str .= '$r = $get_db->sql_query("'.$datas['sql'].' LIMIT '.$limit.'");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$'.$return.' = $a;unset($a);';
                    break;

    //            case 'block':
    //                $str .= '$block_tag = pc_base::load_app_class(\'block_tag\', \'block\');';
    //                $str .= 'echo $block_tag->pc_tag('.self::arr_to_html($datas).');';
    //                break;
            }

        // 不在特殊操作裡面，則為model調用
        } else {

    //        // model 對應的action 不能為空
            if (!isset($action) || empty($action)) return false;
            if (module_exists($op) && file_exists(PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$op.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$op.'_tag.class.php')) {

                $str .= '$'.$op.'_tag = pc_base::load_app_class("'.$op.'_tag", "'.$op.'");if (method_exists($'.$op.'_tag, \''.$action.'\')) {';
                /* if (isset($start) && intval($start)) { */
                /*     $datas['limit'] = intval($start).','.$num; */
                /*     var_dump($datas['limit']); */
                /* } else { */
                /*     $datas['limit'] = $num; */
                /* } */
                $datas['limit'] = $num;
                if (isset($page)) {
                    $str .= '$pagesize = '.$num.';';
                    $str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
                    $str .= '$offset = ($page - 1) * $pagesize;';
                    $datas['limit'] = '$offset.",".$pagesize';
                    $datas['action'] = $action;
                    $str .= '$'.$op.'_total = $'.$op.'_tag->count('.arr_to_html($datas).');';
                    $str .= '$pages = pages($'.$op.'_total, $page, $pagesize, $urlrule);';
                }
                $str .= '$'.$return.' = $'.$op.'_tag->'.$action.'('.arr_to_html($datas).');';
                $str .= '$_smarty_tpl->assign(\''.$return.'\',$'.$return.');}';
            }
        }
    //    // 緩存處理
    //    if (!empty($cache) && !isset($page)) {
    //        $str .= 'if(!empty($'.$return.')){setcache($tag_cache_name, $'.$return.', \'tpl_data\');}';
    //        $str .= '}';
    //    }
        return "<"."?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo \"<div class=\\\"admin_piao\\\" pc_action=\\\"".$op."\\\" data=\\\"".$str_datas."\\\"><a href=\\\"javascript:void(0)\\\" class=\\\"admin_piao_edit\\\">".($op=='block' ? L('block_add') : L('edit'))."</a>\";}".$str."?".">";
    }

    function smarty_compiler_pcclose(){
        return '<?php if(defined(\'IN_ADMIN\') && !defined(\'HTML\')) {echo \'</div>\';}?>';
    }
}else{

    function smarty_compiler_pc($P,  $smarty){

        return "<!--PC section[".$P['M']."] START -->";
    }

    function smarty_compiler_pcclose($P,  $smarty){

        return "<!--PC section[".$P['M']."] COMPLETE -->";


    }
}
