<?php

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

/**
 * 解析PC標簽
 * @param string $op 操作方式
 * @param string $data 參數
 * @param string $html 匹配到的所有的HTML代碼
 */
function smarty_compiler_pc($arrParams) {
    // 参数外标签过滤
    foreach ($arrParams as $_key => $_value) {
        $arrParams[$_key] = str_replace(array("'","\""),"",$_value);
    }
    $op = $arrParams["M"];
    if(!$op){
        $op = $arrParams["module"];
    }   
    unset($arrParams["M"]);
    
    $arr = array('action','num','cache','page', 'pagesize', 'urlrule', 'return', 'start', 'skip');
    $tools = array('json', 'xml', 'block', 'get');
    $datas = array();
    $tag_id = md5(stripslashes($html));
    //可視化條件
    $str_datas = 'op='.$op.'&tag_md5='.$tag_id;
    foreach ($arrParams as $k => $v) {
        if(in_array($k, $arr)) {
            $$k = $v;
            continue;
        }
        $datas[$k] = $v;
    }
    $str = '';
    $num = isset($num) && intval($num) ? intval($num) : 20;
    $skip = isset($skip) && intval($skip) ? intval($skip) : 0;
    $cache = isset($cache) && intval($cache) ? intval($cache) : 0;
    $return = isset($return) && trim($return) ? trim($return) : 'data';
    if (!isset($urlrule)) $urlrule = '';
    if (!empty($cache) && !isset($page)) {
        $str .= '$tag_cache_name = md5(implode(\'&\','.arr_to_html($datas).').\''.$tag_id.'\');if(isset($_GET["refreshcached"]) || !$'.$return.' = getcache($tag_cache_name,\'\',\'memcache\',\'html\')){';
    }
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
                    $num = isset($num) && intval($num) > 0 ? intval($num) : 20;
                    if (isset($start) && intval($start)) {
                        $limit = intval($start).','.$num;
                    } else {
                        $limit = $num;
                    }
                    if (isset($page)) {
                        $str .= '$pagesize = '.$num.';';
                        $str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
                        $str .= '$offset = ($page - 1) * $pagesize + $skip;';
                        $limit = '$offset,$pagesize';
                        if ($sql = preg_replace('/select([^from].*)from/i', "SELECT COUNT(*) as count FROM ", $datas['sql'])) {
                            $str .= '$r = $get_db->sql_query("'.$sql.'");$s = $get_db->fetch_next();$pages=pages($s[\'count\'], $page, $pagesize, $urlrule);';
                        }
                    }
                    
                    
                    $str .= '$r = $get_db->sql_query("'.$datas['sql'].' LIMIT '.$limit.'");while(($s = $get_db->fetch_next()) != false) {$a[] = $s;}$'.$return.' = $a;unset($a);';
                    $str .= '$_smarty_tpl->assign(\''.$return.'\',$'.$return.');';
                break;
                
            case 'block':
                $str .= '$block_tag = pc_base::load_app_class(\'block_tag\', \'block\');';
                $str .= 'echo $block_tag->pc_tag('.arr_to_html($datas).');';
                break;
        }
    } else {
        if (!isset($action) || empty($action)) return false;
        if (module_exists($op) && file_exists(PC_PATH.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$op.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$op.'_tag.class.php')) {
            $str .= '$'.$op.'_tag = pc_base::load_app_class("'.$op.'_tag", "'.$op.'");if (method_exists($'.$op.'_tag, \''.$action.'\')) {';	
            if (isset($start) && intval($start)) {
                $datas['limit'] = intval($start).','.$num;
            } else {
                $datas['limit'] = $num;
            }
            if (isset($page)) {
                $str .= '$pagesize = '.$num.';';
                $str .= '$skip = '.$skip.';';
                $str .= '$page = intval('.$page.') ? intval('.$page.') : 1;if($page<=0){$page=1;}';
                $str .= '$offset = ($page - 1) * $pagesize + $skip;';
                $datas['limit'] = '$offset.",".$pagesize';
                $datas['action'] = $action;
                $str .= '$'.$op.'_total = $'.$op.'_tag->count('.arr_to_html($datas).');';
                $str .= '$pages = pages($'.$op.'_total, $page, $pagesize, $urlrule);';
                $str .= '$_smarty_tpl->assign(\'total\',$'.$op.'_total);';
                $str .= '$_smarty_tpl->assign(\'pagesize\',$pagesize);';
            }
            $str .= '$'.$return.' = $'.$op.'_tag->'.$action.'('.arr_to_html($datas).');';
            $str .= '}';
        } 
    }
    if (!empty($cache) && !isset($page)) {
        $str .= 'if(!empty($'.$return.')){setcache($tag_cache_name, $'.$return.', \'\', \'memcache\', \'html\', $cache);}';
        $str .= '}';
    }
    $str .= '$_smarty_tpl->assign(\''.$return.'\',$'.$return.');';

    return "<"."?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo \"<div class=\\\"admin_piao\\\" pc_action=\\\"".$op."\\\" data=\\\"".$str_datas."\\\"><a href=\\\"javascript:void(0)\\\" class=\\\"admin_piao_edit\\\">".($op=='block' ? L('block_add') : L('edit'))."</a>\";}".$str."?".">";
}

/**
 * PC標簽結束
 */
function smarty_compiler_pcclose() {
    return '<?php if(defined(\'IN_ADMIN\') && !defined(\'HTML\')) {echo \'</div>\';}?>';
}
