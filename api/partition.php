<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
  * 專區接口
  *
  */

$db_partition = pc_base::load_model('partition_model');
$db_partition_games = pc_base::load_model('partition_games_model');
$db_content = pc_base::load_model('content_model');

if( $_GET['catid'] ){//欄目文章列表
	$part_info = $db_partition->get_one('`catid`='.intval($_GET['catid']));
	if( $part_info['child'] ){//父級欄目
        channel_lists(intval($_GET['catid']));
    }else{
	    article_lists( intval($_GET['catid']) );
    }
	exit();
}else if( $_GET['device'] && $_GET['package_name'] ){//欄目結構
	get_partition_structure($_GET['device'], $_GET['package_name']);
	exit();
}else{//參數錯誤
	$err_info['code'] = 2;
	$err_info['msg'] = '參數異常!';
	echo json_encode($err_info);
	exit();
}

/**
 * 構造欄目結構
 *
 *
 **/
function make_category_structure( $catid ,&$father_key, &$father_partition_list){

	global $db_partition;
	$son_list = $db_partition->select('`parentid`='.$catid, '*', '', 'listorder ASC');
	if($son_list[0]){
		foreach( $son_list as $key=>$value ){
			if( $value['child'] ){
				make_category_structure($value['catid'], $key, $son_list);
			}
			$father_partition_list[$father_key]['childs'] = $son_list;
			unset($curr_son_list_temp);
		}
	}
}

/**
  * 獲取分區列表結構
  * @Param $device 		設備名(包所對應的設備名)
  	   $package_name 	包名
  *
 */
function get_partition_structure( $device, $package_name ){
	global $db_partition;
	$device_column = ($device=='android') ? "`pack_android`" : "`pack_ios`";
	$father_partition_item = $db_partition->get_one( $device_column."='".$package_name."'" ); 
	if( $father_partition_item ){
		$event_result = array();
		$father_partition_list = $db_partition->select( '`catid` IN ('.$father_partition_item['arrchildid'].') AND `is_tab`=1', 'catid,parentid,arrparentid,child,arrchildid,catname,cont_style,cont_type' , '', 'listorder ASC');
		$event_result = array();
		foreach( $father_partition_list as $key=>$value ){
			make_category_structure($value['catid'], $key, $father_partition_list);
		}
		$event_result = $father_partition_list;


		$partition_list_info['bbs_id'] = $father_partition_item['bbs_id'];
		$partition_list_info['header_pic'] = json_decode($father_partition_item['header_pic'], true);
		$partition_list_info['redirect_button'] = json_decode($father_partition_item['redirect_button'], true);
		if ($father_partition_item['rec_channel']) {
			$partition_list_info['position'] = article_lists($father_partition_item['rec_channel'], true);
		} else {
			$partition_list_info['position'] = NULL;
		}
		foreach( $partition_list_info['header_pic'] as $key=>$value ){
			if( $value['redirect_type'] == 1 ){//跳轉欄目
				$temp_add = $db_partition->get_one('`catid`='.$value['redirect']);
				$partition_list_info['header_pic'][$key]['child'] = $temp_add['child'];
				$partition_list_info['header_pic'][$key]['cont_type'] = $temp_add['cont_type'];
				$partition_list_info['header_pic'][$key]['cont_style'] = $temp_add['cont_style'];
			}else{//跳轉url
                $temp_catid_id = match_catid_by_url('/([0-9]{1,})-([0-9]{1,})-([0-9]{1,})/i', $value['redirect'], 1);
                if($temp_catid_id[0]){
                    $temp_catid_h = $temp_catid_id[1];
                    $temp_id_h = $temp_catid_id[2];
                }else{
                    $temp_catid_h = match_catid_by_url('/([0-9]*)_/i', $value['redirect']);
                    $temp_id_h = match_catid_by_url('/_([0-9]*)/i', $value['redirect']);
                }
                $partition_list_info['header_pic'][$key]['catid'] = $temp_catid_h;
                $partition_list_info['header_pic'][$key]['id'] = $temp_id_h;
            }
		}
		foreach( $partition_list_info['redirect_button'] as $key1=>$value1 ){
			if( $value1['redirect_type'] == 1 ){//跳轉欄目
				$temp_add = $db_partition->get_one('`catid`='.$value1['redirect']);
				$partition_list_info['redirect_button'][$key1]['child'] = $temp_add['child'];
				$partition_list_info['redirect_button'][$key1]['cont_type'] = $temp_add['cont_type'];
				$partition_list_info['redirect_button'][$key1]['cont_style'] = $temp_add['cont_style'];
			}
		}

		$partition_list_info['category'] = $event_result;
		$data['code'] = 0;
		$data['data'] = $partition_list_info;
		
		echo json_encode($data);
	}else{
		$err_info['code'] = 1;
		$err_info['msg'] = '無符合條件專區!';
		echo json_encode($err_info);
	}
}

/*
 * 查詢欄目列表
 *
 **/
function channel_lists($catid){
	global $db_partition_games,$db_content,$db_partition;
	$part_info = $db_partition->get_one('`catid`='.$catid);
	$father_partition_item['arrchildid'] = $part_info['arrchildid'];
	$event_result = array();
	$father_partition_list = $db_partition->select( '`catid` IN ('.$father_partition_item['arrchildid'].') AND `catid`!='.$catid, 'catid,parentid,arrparentid,child,arrchildid,catname,cont_style,cont_type,image' );
	$event_result = $father_partition_list;

	$data['code'] = 0;
	$data['data'] = $event_result;

    echo json_encode($data);
}

/**
 * 欄目下文章列表
 * @Param 欄目id
 *
 */
function article_lists($catid, $return = false){
    global $db_partition_games,$db_content,$db_partition;
    $part_info = $db_partition->get_one('`catid`='.$catid);

    $part_article_list = $db_partition_games->select('`part_id`='.$catid, '*', '', '`listorder` ASC');
    $partition_url = get_partition_url_by_catid($catid);
    foreach( $part_article_list as $key=>$value ){
        $db_content->set_model($value['modelid']);
        $temp_article_info = $db_content->get_one('`id`='.$value['gameid'], 'id,catid,url,title,shortname,thumb,updatetime', '`listorder` DESC');

        $temp_url = parse_url($temp_article_info['url']);
        $temp_article_info['url'] = $temp_url['query'] ? $temp_article_info['url'] : $temp_article_info['url'].'?from=mofang';
        $temp_article_info['url'] = $partition_url . $temp_article_info['catid'] . '_' . $temp_article_info['id'] . '.html?form=mofang';

        $temp_article_info['modelid'] = $value['modelid'];
        if (!empty($temp_article_info['thumb']) && strpos($temp_article_info['thumb'], 'pics.mofang.com') !== FALSE && strpos($temp_article_info['thumb'], '!') === FALSE) {
            $temp_article_info['thumb'] = str_replace('pics.mofang.com', 'pic0.mofang.com', $temp_article_info['thumb']) . '!w640';
        }
        $article_list[] = $temp_article_info;
    }
    if ($return) {
        return $article_list;
    } else {
        echo json_encode($article_list);
    }
}

function get_partition_url_by_catid($catid) {
    global $db_partition;
    $max_level = 5;
    $cache_key = "partition_url_{$catid}";
    if ( $ret = apc_fetch($cache_key)) {
        return $ret;
    }
    do {
        $row = $db_partition->get_one(array('catid'=>$catid), 'catid, parentid, domain_dir, is_domain');
        if ($row['parentid'] == 0) {
            $partition_url = '';
            $domain = str_ireplace( '.mofang.com', '', $_SERVER['HTTP_HOST'] );
            if(!$row['is_domain']){//未啟用二級域名
                $partition_url = get_category_url('www'). '/' . $row['domain_dir'].'/';
            }else{
                $partition_url = 'http://' . $row['domain_dir'] . pc_base::load_config('domains','base_domain') . '/';
            }
            apc_add($cache_key, $partition_url, 3600);
            return $row['domain_dir'];
        } else {
            $catid = $row['parentid'];
        }
        $max_level--;
    } while ($max_level > 0);
}
