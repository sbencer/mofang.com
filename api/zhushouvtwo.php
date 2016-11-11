<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
  * 專區接口
  *
  */

$db_partition = pc_base::load_model('partition_model');
$db_partition_games = pc_base::load_model('partition_games_model');
$db_partition_relationgames = pc_base::load_model('partition_relationgames_model');
$db_content = pc_base::load_model('content_model');
$db_category = pc_base::load_model('category_model');

if( $_GET['catid'] ){//欄目文章列表
	$part_info = $db_partition->get_one('`catid`='.intval($_GET['catid']));
	if( $part_info['child'] ){//父級欄目
        channel_lists(intval($_GET['catid']));
    }else{
        
        $time_from = isset($_GET['time_from']) ? intval($_GET['time_from']) : 0;

	    article_lists( intval($_GET['catid']), false, $time_from);
    }
	exit();

}else if($_GET['device'] && $_GET['package_name'] && $_GET['addi_info']){//遊戲及高端玩家正在用
    get_addi_info($_GET['device'], $_GET['package_name']);
    exit();
}else if($_GET['device'] && $_GET['package_name']){//欄目結構
    $time_from = isset($_GET['time_from']) ? intval($_GET['time_from']) : 0;
	get_partition_structure($_GET['device'], $_GET['package_name'], $time_from);
	exit();
}else{//參數錯誤
	$err_info['code'] = 2;
	$err_info['msg'] = '參數異常!';
	echo json_encode($err_info);
	exit();
}


/*
 * 高端玩家正在用
 *      $device 當前設備標識
 *
 **/
function get_all_use($device){
	global $db_partition;
    $db_partition->table_name = 'www_download';
    $all_use = $db_partition->select('`catid`=277', 'id,title,thumb,catid');
    foreach($all_use as $k_au=>$v_au){
        $db_partition->table_name = 'www_download_data';
        $all_use_item = $db_partition->get_one('`id`='.$v_au['id'], 'iospackage,andpackage');
        $all_use_item['iospackage'] = string2array($all_use_item['iospackage']);
        $all_use_item['iospackage'] = array_values($all_use_item['iospackage']);
        $all_use_item['iospackage'] = $all_use_item['iospackage'][0];
        $all_use_item['iospackage'] = $all_use_item['iospackage'] ? $all_use_item['iospackage'] : '';
        if($device=='android'){
            unset($all_use_item['iospackage']);
        }
        if(empty($all_use_item['iospackage'])&&$device=='ios'){
            unset($all_use[$k_au]);
            continue;
        }

        $all_use_item['andpackage'] = string2array($all_use_item['andpackage']);
        $all_use_item['andpackage'] = array_values($all_use_item['andpackage']);
        $all_use_item['andpackage'] = $all_use_item['andpackage'][0];
        $all_use_item['andpackage'] = $all_use_item['andpackage'] ? $all_use_item['andpackage'] : '';
        if($device=='ios'){
            unset($all_use_item['andpackage']);
        }
        if(empty($all_use_item['andpackage'])&&$device=='android'){
            unset($all_use[$k_au]);
            continue;
        }

        $all_use[$k_au] = array_merge($v_au,$all_use_item);
    }
    $all_use = array_values($all_use);
    return $all_use;
}

/*
 * 獲取額外信息
 *
 **/
function get_addi_info($device, $package_name){
	global $db_partition,$db_partition_relationgames,$db_content;
	$device_column = ($device=='android') ? "`pack_android`" : "`pack_ios`";
	$father_partition_item = $db_partition->get_one( $device_column."='".$package_name."'" ); 
    if($father_partition_item){
        $where['part_id'] = $father_partition_item['catid'];
        $where['modelid'] = ($device=='android') ? 21 : 20;
        $relate_game_info = $db_partition_relationgames->get_one($where,'modelid,gameid');
        if(!$relate_game_info){//無對應關聯遊戲
            $return_data['download'] = '';
        }else{
            $game_info = array();
		    $db_content->set_model($relate_game_info['modelid']);
		    $game_info_base = $db_content->get_one('`id`='.$relate_game_info['gameid'], 'title');
            $game_info['title'] = $game_info_base['title'];
            $db_content->table_name .= '_data';
		    $game_info_data = $db_content->get_one('`id`='.$relate_game_info['gameid']);
            $down_url = string2array($game_info_data['package']);
            $game_info['url'] = $down_url['fileurl'];
            $return_data['download'] = $game_info;
        }
        
        $return['code'] = 0;
        //遊戲下載信息
        $return['download'] = $return_data['download'];
        //高端玩家都在用
        $return['all_use'] = get_all_use($device);
        echo json_encode($return);
	}else{
		$err_info['code'] = 1;
		$err_info['msg'] = '無符合條件專區!';
		echo json_encode($err_info);
	}
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
function get_partition_structure( $device, $package_name, $time_from=0 ){
	global $db_partition, $db_category;

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


        //專區名
        $partition_list_info['catname'] = $father_partition_item['catname'] ? $father_partition_item['catname'] : array();
        //catid
        $partition_list_info['catid'] = $father_partition_item['catid'] ? $father_partition_item['catid'] : "0";
		$partition_list_info['bbs_id'] = $father_partition_item['bbs_id'];


        $db_partition = pc_base::load_model('partition_model');
        $db_partition_games = pc_base::load_model('partition_games_model');
        $db_content = pc_base::load_model('content_model');

        //button_v2
        $temp_setting = string2array($father_partition_item['setting']);
        $partition_list_info['button_v2'] = $temp_setting['button_v2'] ? $temp_setting['button_v2'] : array();
        usort($partition_list_info['button_v2'],"partition_list_cmp_listorder");
        $partition_list_info['button_v2'] = array_values($partition_list_info['button_v2']);
        foreach($partition_list_info['button_v2'] as $k_bv=>$v_bv){

            if($v_bv['button_type']==0){
                $temp_catid_id = match_catid_by_url('/([0-9]{1,})-([0-9]{1,})-([0-9]{1,})/i',$v_bv['button_value'], 1);
                if($temp_catid_id[0]){
                    $temp_catid_v = $temp_catid_id[1];
                    $temp_id_v = $temp_catid_id[2];
                }else{
                    $temp_catid_v = match_catid_by_url('/([0-9]*)_/i',$v_bv['button_value']);
                    $temp_id_v = match_catid_by_url('/_([0-9]*)/i',$v_bv['button_value']);
                }

                $partition_list_info['button_v2'][$k_bv]['catid'] = $temp_catid_v;
                $partition_list_info['button_v2'][$k_bv]['id'] = $temp_id_v;

                $temp_modelid = $db_category->get_one('`catid`='.$temp_catid_v, 'modelid');
                if($temp_modelid['modelid']==11){
                    $db_content->set_model($temp_modelid['modelid']);
                    $temp_youkuid = $db_content->get_one('`id`='.$temp_id_v, 'youkuid');
                    $partition_list_info['button_v2'][$k_bv]['youkuid'] = $temp_youkuid['youkuid'] ? $temp_youkuid['youkuid'] : '';
                }
            }


            if($v_bv['button_type']==0 && $time_from!=0){//文章
                $temp_id = match_catid_by_url('/_([0-9]*)/i',$v_bv['button_value']);
                $temp_catid = match_catid_by_url('/([0-9]*)_/i',$v_bv['button_value']);

                if(empty($temp_id) || empty($temp_catid)){//增加異常處理(url不符合規則的情況)
                    $partition_list_info['button_v2'][$k_bv]['update_count'] = "0";
                    continue;
                }

                $temp_modelid = $db_category->get_one('`catid`='.$temp_catid, 'modelid');
                $temp_modelid = $temp_modelid['modelid'];

                $update_count = 0;
                $db_content->set_model($temp_modelid);
                $temp_count = $db_content->count("`id`=".$temp_id." AND `updatetime`>=".$time_from);
                $update_count += $temp_count;

                if($update_count==0 && $device!='android'){//沒有更新則不展示
                    unset($partition_list_info['button_v2'][$k_bv]);
                    continue;
                }else if($update_count==0){
                    $partition_list_info['button_v2'][$k_bv]['update_count'] = "0";
                }else{
                    $partition_list_info['button_v2'][$k_bv]['update_count'] = "1";
                }


            }else if($v_bv['button_type']==1 && $time_from!=0){//欄目+時間
                $temp_arrchildid_item = $db_partition->get_one('`catid`='.$v_bv['button_value'], 'arrchildid,cont_style,cont_type,child ');
                $temp_arrchildid = explode(',', $temp_arrchildid_item['arrchildid']);
                $update_count = 0;
                foreach($temp_arrchildid as $k_ta=>$v_ta){
                    $temp_channel = $db_partition_games->select('`part_id`='.$v_ta, 'modelid, gameid');
                    if(!$temp_channel[0]){//無內容
                        continue;
                    }
                    $temp_ids = '';
                    foreach($temp_channel as $k_tc=>$v_tc){
                        $temp_ids .= ','.$v_tc['gameid'];
                    }
                    $temp_ids = trim($temp_ids, ',');
                    $db_content->set_model($temp_channel[0]['modelid']);
                    $temp_count = $db_content->count("`id` IN (".$temp_ids.") AND `updatetime`>=".$time_from);
                    $update_count += $temp_count;
                }

                if($update_count==0 && $device!='android'){//沒有更新則不展示
                    unset($partition_list_info['button_v2'][$k_bv]);
                    continue;
                }

                $partition_list_info['button_v2'][$k_bv]['update_count'] = (string)$update_count;
                
                //返回列表類型
                $partition_list_info['button_v2'][$k_bv]['cont_style'] = $temp_arrchildid_item['cont_style'];
                $partition_list_info['button_v2'][$k_bv]['cont_type'] = $temp_arrchildid_item['cont_type'];
                $partition_list_info['button_v2'][$k_bv]['child'] = $temp_arrchildid_item['child'];
            }elseif($v_bv['button_type']==1){//欄目
                //返回列表類型
                $temp_channel_item = $db_partition->get_one('`catid`='.$v_bv['button_value'], 'cont_style,cont_type,child ');
                $partition_list_info['button_v2'][$k_bv]['cont_style'] = $temp_channel_item['cont_style'];
                $partition_list_info['button_v2'][$k_bv]['cont_type'] = $temp_channel_item['cont_type'];
                $partition_list_info['button_v2'][$k_bv]['child'] = $temp_channel_item['child'];
                $partition_list_info['button_v2'][$k_bv]['update_count'] = '0';
            }else{
                $partition_list_info['button_v2'][$k_bv]['update_count'] = '0';
            }
        }

        $partition_list_info['button_v2'] = array_values($partition_list_info['button_v2']);

        //頭圖
		$partition_list_info['header_pic'] = json_decode($father_partition_item['header_pic'], true);
		foreach( $partition_list_info['header_pic'] as $key=>$value ){
			if( $value['redirect_type'] == 1 ){//跳轉欄目
				$temp_add = $db_partition->get_one('`catid`='.$value['redirect']);
				$partition_list_info['header_pic'][$key]['child'] = $temp_add['child'];
				$partition_list_info['header_pic'][$key]['cont_type'] = $temp_add['cont_type'];
				$partition_list_info['header_pic'][$key]['cont_style'] = $temp_add['cont_style'];
			}else{//跳轉url

                $temp_catid_id = match_catid_by_url('/([0-9]{1,})-([0-9]{1,})-([0-9]{1,})/i',$value['redirect'], 1);
                if($temp_catid_id[0]){
                    $temp_catid_v = $temp_catid_id[1];
                    $temp_id_v = $temp_catid_id[2];
                }else{
                    $temp_catid_v = match_catid_by_url('/([0-9]*)_/i', $value['redirect']);
                    $temp_id_v = match_catid_by_url('/_([0-9]*)/i', $value['redirect']);
                }

                $partition_list_info['header_pic'][$key]['catid'] = $temp_catid_v;
                $partition_list_info['header_pic'][$key]['id'] = $temp_id_v;

                $temp_modelid = $db_category->get_one('`catid`='.$temp_catid_v, 'modelid');
                if($temp_modelid['modelid']==11){
                    $db_content->set_model($temp_modelid['modelid']);
                    $temp_youkuid = $db_content->get_one('`id`='.$temp_id_v, 'youkuid');
                    $partition_list_info['header_pic'][$key]['youkuid'] = $temp_youkuid['youkuid'] ? $temp_youkuid['youkuid'] : '';
                }
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
function article_lists($catid, $return = false, $time_from=0){
	global $db_partition_games,$db_content,$db_partition,$db_category;
	$part_info = $db_partition->get_one('`catid`='.$catid);

	$part_article_list = $db_partition_games->select('`part_id`='.$catid, '*', '', '`listorder` ASC, `inputtime` DESC');
	foreach( $part_article_list as $key=>$value ){
		$db_content->set_model($value['modelid']);
        $temp_where = '`id`='.$value['gameid'];
        $temp_where .= ' AND `updatetime`>='.$time_from;
        $temp_field = ($value['modelid']==3) ? 'id,catid,url,title,thumb,updatetime' : 'id,catid,url,title,shortname,thumb,updatetime';
		$temp_article_info = $db_content->get_one($temp_where, $temp_field, '`listorder` DESC');
        if($value['modelid']==3){//圖集
            $db_content->table_name .= '_data';
            $temp_add_field = 'shortname,pictureurls';
		    $temp_article_info_data = $db_content->get_one('`id`='.$value['gameid'], $temp_add_field);
            $temp_article_info_data['pictureurls'] = string2array($temp_article_info_data['pictureurls']);
            $temp_article_info = array_merge($temp_article_info, $temp_article_info_data);
        }
        if(empty($temp_article_info)){
            continue;
        }

		$temp_url = parse_url($temp_article_info['url']);
        $temp_article_info['url'] = $temp_url['query'] ? $temp_article_info['url'] : $temp_article_info['url'].'?from=mofang';


        $temp_catid_id = match_catid_by_url('/([0-9]{1,})-([0-9]{1,})-([0-9]{1,})/i', $temp_article_info['url'], 1);
        if($temp_catid_id[0]){
            $temp_catid_v = $temp_catid_id[1];
            $temp_id_v = $temp_catid_id[2];
        }else{
            $temp_catid_v = match_catid_by_url('/([0-9]*)_/i', $temp_article_info['url']);
            $temp_id_v = match_catid_by_url('/_([0-9]*)/i', $temp_article_info['url']);
        }

        $temp_modelid = $db_category->get_one('`catid`='.$temp_catid_v, 'modelid');
        if($temp_modelid['modelid']==11){
            $db_content->set_model($temp_modelid['modelid']);
            $temp_youkuid = $db_content->get_one('`id`='.$temp_id_v, 'youkuid');
            $temp_article_info['youkuid'] = $temp_youkuid['youkuid'] ? $temp_youkuid['youkuid'] : '';
        }


		$temp_article_info['modelid'] = $value['modelid'];
		if (!empty($temp_article_info['thumb']) && strpos($temp_article_info['thumb'], 'pics.mofang.com') !== FALSE && strpos($temp_article_info['thumb'], '!') === FALSE) {
			$temp_article_info['thumb'] = str_replace('pics.mofang.com', 'pic0.mofang.com', $temp_article_info['thumb']) . '!w640';
		}
		$article_list[] = $temp_article_info;
	}
	if ($return) {
		return $article_list;
	} else {

	    $data['code'] = 0;
	    $data['data'] = !empty($article_list) ? $article_list : array();
		echo json_encode($data);
	}
}

?>
