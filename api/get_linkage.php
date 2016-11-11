<?php
/**
 * 獲取聯動菜單接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 
if((!$_GET['callback'] && $_GET['act'] != 'ajax_select')|| !$_GET['act'])  showmessage(L('error'));

switch($_GET['act']) {
	case 'ajax_getlist':
		ajax_getlist();
	break;
	
	case 'ajax_getpath':
		ajax_getpath($_GET['parentid'],$_GET['keyid'],$_GET['callback']);
	break;	
	case 'ajax_gettopparent':
		ajax_gettopparent($_GET['linkageid'],$_GET['keyid'],$_GET['callback']);
	break;
	case 'ajax_select':
		$parent_id = $_GET['parent_id'] ? intval($_GET['parent_id']) : 0;
		$keyid = $_GET['keyid'];
		ajax_select($parent_id,$keyid);
	break;
}


/**
 * 獲取地區列表
 */
function ajax_getlist() {
	$keyid = intval($_GET['keyid']);
	$datas = getcache($keyid,'linkage');
	$infos = $datas['data'];
	$where_id = isset($_GET['parentid']) ? $_GET['parentid'] : intval($infos[$_GET['linkageid']]['parentid']);
	$parent_menu_name = ($where_id==0) ? $datas['title'] :$infos[$where_id]['name'];
	if(is_array($infos)){
		foreach($infos AS $k=>$v) {
			if($v['parentid'] == $where_id) {
				$s[]=iconv(CHARSET,'utf-8',$v['linkageid'].','.$v['name'].','.$v['parentid'].','.$parent_menu_name);
			}
		}
	}
	
	if(count($s)>0) {
		$jsonstr = json_encode($s);
		echo trim_script($_GET['callback']).'(',$jsonstr,')';
		exit;			
	} else {
		echo trim_script($_GET['callback']).'()';exit;			
	}
}

/**
 * 獲取地區父級路徑路徑
 * @param $parentid 父級ID
 * @param $keyid 菜單keyid
 * @param $callback json生成callback變量
 * @param $result 遞歸返回結果數組
 * @param $infos
 */
function ajax_getpath($parentid,$keyid,$callback,$result = array(),$infos = array()) {
	$keyid = intval($keyid);
	$parentid = intval($parentid);
	if(!$infos) {
		$datas = getcache($keyid,'linkage');
		$infos = $datas['data'];
	}
	if(array_key_exists($parentid,$infos)) {
		$result[]=iconv(CHARSET,'utf-8',$infos[$parentid]['name']);
		return ajax_getpath($infos[$parentid]['parentid'],$keyid,$callback,$result,$infos);
	} else {
		if(count($result)>0) {
			krsort($result);
			$jsonstr = json_encode($result);
			echo trim_script($callback).'(',$jsonstr,')';
			exit;			
		} else {
			$result[]=iconv(CHARSET,'utf-8',$datas['title']);
			$jsonstr = json_encode($result);
			echo trim_script($callback).'(',$jsonstr,')';
			exit;
		}
	}
}
/**
 * 獲取地區頂級ID
 * Enter description here ...
 * @param  $linkageid 菜單id
 * @param  $keyid 菜單keyid
 * @param  $callback json生成callback變量
 * @param  $infos 遞歸返回結果數組
 */
function ajax_gettopparent($linkageid,$keyid,$callback,$infos = array()) {
	$keyid = intval($keyid);	
	$linkageid = intval($linkageid);
	if(!$infos) {
		$datas = getcache($keyid,'linkage');
		$infos = $datas['data'];
	}
	if($infos[$linkageid]['parentid']!=0) {
		return ajax_gettopparent($infos[$linkageid]['parentid'],$keyid,$callback,$infos);
	} else {
		echo trim_script($callback).'(',$linkageid,')';
		exit;		
	}
}

/**************************************************************
 *
 *	以下函數適用於select聯動樣式
 *
 *************************************************************/
function ajax_select($parentid,$keyid) {
	$keyid = intval($keyid);
	$datas = getcache($keyid,'linkage');
	$infos = $datas['data'];
	$json_str = "[";
	$json = array();
	foreach($infos AS $k=>$v) {
		if($v['parentid'] == $parentid) {
			$r = array('region_id' => $v['linkageid'],
					   'region_name' => $v['name']);
			$json[] = JSON($r);		
		}
	}
	$json_str .= implode(',',$json);
	$json_str .= "]";
	echo $json_str;	
}

function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }

        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
}

function JSON($array) {
	arrayRecursive($array, 'urlencode', true);
	$json = json_encode($array);
	return urldecode($json);
}
?>