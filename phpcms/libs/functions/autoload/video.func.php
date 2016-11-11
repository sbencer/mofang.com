<?php


/**
 * 獲取視頻圖片
 * @param $id
 */
function get_pic($id,$catid) {
	global $db;
	$id = intval($id);
 	$catid = intval($catid);
	if(!$id || empty($id)){ return false;}
 	$db = pc_base::load_model('content_model');
	$db->set_catid($catid);
	$r = $db->get_content($catid,$id);
   	if($r){
		return $r;	
 	}else{
		return '0';
	}
}

/**
 * 生成分類信息中的篩選菜單
 * @param $field   字段名稱
 * @param $modelid  模型ID
 * @param $diyarr 數據包
 * @param $isall 是否顯示全部
 */
function video_filters($field = '',$modelid,$diyarr = array(),$isall = 1) {
	$fields = getcache('model_field_'.$modelid,'model');
	$options = empty($diyarr) ?  explode("\n",$fields[$field]['options']) : $diyarr;
	$field_value = intval($_GET[$field]);
	foreach($options as $_k) {
		$v = explode("|",$_k);
		$k = trim($v[1]);
		$option[$k]['name'] = $v[0];
		$option[$k]['value'] = $k;
		$option[$k]['url'] = video_filters_url($field,array($field=>$k),2,$modelid);
		$option[$k]['menu'] = $field_value == $k ? '<a href="#" class="ac">'.$v[0].'</a>' : '<a href="'.$option[$k]['url'].'">'.$v[0].'</a>';
	}
	if ($isall) {
		$all['name'] = L('all');
		$all['url'] = video_filters_url($field,array($field=>''),2,$modelid);
		$all['menu'] = $field_value == '' ? '<a href="#" class="ac">'.$all['name'].'</a>' : '<a href="'.$all['url'].'">'.$all['name'].'</a>';
		array_unshift($option,$all);
	}
	return $option;
}



/**
 * 構造篩選URL
 */
function video_filters_url($fieldname,$array=array(),$type = 1,$modelid, $isphp = 0) {
	if(empty($array)) {
		$array = $_GET;
	} else {
		$array = array_merge($_GET,$array);
	}
	//$setting = getcache('yp_setting', 'yp');
	//TODO
	$fields = getcache('model_field_'.$modelid,'model');
	if(is_array($fields) && !empty($fields)) {
		ksort($fields);
		foreach ($fields as $_v=>$_k) {
			if($_k['filtertype'] || $_k['rangetype']) {
				$urlpars .= '&'.$_v.'={$'.$_v.'}';
			}
		}
	}
	//偽靜態url規則管理，apache偽靜態支持9個參數
	 $urlrule =APP_PATH.'index.php?m=content&c=index&a=lists&catid='.$_GET[catid].'&modelid='.$modelid.$urlpars.'&page={$page}';
	//根據get傳值構造URL
	if (is_array($array)) foreach ($array as $_k=>$_v) {
		if($_k=='page') $_v=1;
		if($type == 1) if($_k==$fieldname) continue;
		$_findme[] = '/{\$'.$_k.'}/';
		if (strpos('_', $_v)===false) {
			$_v = intval($_v);
		} else {
			$str_arr = explode('_', $_v);
			$str_arr = array_map("intval", $str_arr);
			$_v = implode('_', $str_arr);
		}
		$_replaceme[] = $_v;
	}
     //type 模式的時候，構造排除該字段名稱的正則
	if($type==1) $filter = '(?!'.$fieldname.'.)';
	$_findme[] = '/{\$'.$filter.'([a-z0-9_]+)}/';
	$_replaceme[] = '';
	$urlrule = preg_replace($_findme, $_replaceme, $urlrule);
	$b = isset($_GET['b']) ? intval($_GET['b']) : 1;
	$urlrule .='&b='.$b;

	return 	$urlrule;
}


/**
 * 構造篩選時候的sql語句
 */
function video_filters_sql($modelid,$catid) {
	$sql = $fieldname = $min = $max = '';
	$fieldvalue = array();
	$modelid = intval($modelid);
	$model =  getcache('video_model','model');
	$fields = getcache('model_field_'.$modelid,'model');
	$fields_key = array_keys($fields);
	//TODO
	$siteid = get_siteid();
	$sql = '`status` = \'99\'';
	
	$category = getcache('category_content_'.$siteid);
	if ($category[$catid]['child']) {
		$sql .= ' AND `catid` IN('.$datas[$catid]['arrchildid'].')';
	} else {
		$sql .= ' AND `catid`=\''.$catid.'\'';
	}
	
	foreach ($_GET as $k=>$r) {
		if(in_array($k,$fields_key) && intval($r)!=0 && ($fields[$k]['filtertype'] || $fields[$k]['rangetype'])) {
			if($fields[$k]['formtype'] == 'linkage') {
				$datas = getcache($fields[$k]['linkageid'],'linkage');
				$infos = $datas['data'];
				if($infos[$r]['arrchildid']) {
					$sql .=  ' AND `'.$k.'` in('.$infos[$r]['arrchildid'].')';
				}
			} elseif($fields[$k]['formtype'] == 'catids') {
				$datas = getcache('category_content_'.$modelid);
				if ($datas[$r]['child']) {
					$sql .= ' AND `'.$k.'` IN('.$datas[$r]['arrchildid'].')';
				} else {
					$sql .= ' AND `'.$k.'`=\''.$r.'\'';
				}
			} elseif($fields[$k]['rangetype']) {
				if(is_numeric($r)) {
					$sql .=" AND `$k` = '$r'";
				} else {
					$fieldvalue = explode('_',$r);
					$min = intval($fieldvalue[0]);
					$max = $fieldvalue[1] ? intval($fieldvalue[1]) : 999999;
					$sql .=" AND `$k` >= '$min' AND  `$k` < '$max'";
				}
			} else {
				$sql .=" AND `$k` = '$r'";
			}
		}
	}
	return $sql;
}


function video_makeurlrule() {
	$setting = getcache('video', 'video');
	if($setting['enable_rewrite'] == 0) {
		return url_par('page={$'.'page}');
	}
	else {
		$url = preg_replace('/-[0-9]+.html$/','-{$page}.html',get_url());
		return $url;
	}
}

function player_code($id = 'video_player',$channelid,$vid,$width = 622, $height = 460, $style_projectid = '') {
	if(!$channelid) return 'channelid empty!';
	if(!$vid) return 'vid empty!';
	$player = getcache('player', 'video');
	
	$player_config = $player[$channelid];
	$default_style = $player_config['default'];

	$style_projectid = $style_projectid ? $style_projectid : $default_style;
	$_config = $player_config['STY-'.$style_projectid];
	if(empty($_config)) return 'style error!';

	$playerurl = pc_base::load_config('ku6server', 'player_url').$vid.'/style/'.$style_projectid.'/v.swf';
	$string = '<embed id="'.$id.'" name="'.$id.'" src="'.$playerurl.'" width="'.$width.'" height="'.$height.'" quality="high" align="middle" allowScriptAccess="always" allowfullscreen="true" type="application/x-shockwave-flash"></embed>';
	return $string;
}

function youku_code($content){
	$search = '/\[youku\s+h:(\d+)\s+w:(\d+)\]\s*(\w+)\s*\[\/youku\]/i';
	$replace = '<div id="youkuplayer\\3"></div>
                    <script>
                    player\\3 = new YKU.Player("youkuplayer\\3",{
                        client_id: "04a4fa40c0634318",
                        vid: "\\3",
                        width: \\2,
                        height: \\1,
                        autoplay: false,
                        show_related: false
                    });
                    </script>';
    $content = preg_replace($search, $replace, $content);
	return $content;
}
?>
