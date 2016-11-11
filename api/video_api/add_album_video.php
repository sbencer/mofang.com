<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
 * 
 * 視頻添加接收接口 在vms系統中添加視頻、導入ku6視頻時，會調用此接口同步這些視頻
 * 
 * @author				chenxuewang
 * @link				http://www.phpcms.cn http://www.ku6.cn
 * @copyright			CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 * @license			http://www.phpcms.cn/license/
 * 
 * 
 * *************************************
 *              			           *
 *                 參數說明            *
 *                                     *
 * ************************************* 
 * 
 * title, description, tag, vid, picpath, size, timelen, status, playnum, specialid
 * 
 * title, 視頻標題
 * 
 * descrption 視頻簡介
 * 
 * tag 視頻標簽
 * 
 * vid，視頻vid，視頻的唯一的標示符。區分視頻
 * 
 * picpath 視頻縮略圖
 * 
 * size 視頻大小
 * 
 * timelen 視頻播放時長
 * 
 * status 視頻目前的狀態
 * 
 * playnum 視頻播放次數
 * 
 * specialid 視頻導入的專題id
 * 
 * 
 * 
 * ************************************
 *              			          *
 *                 返 回 值           *
 *                                    *
 * ************************************ 
 * 
 * 接口執行後，應返回相應的值通知vms系統
 * 返回值格式 json數據，array('msg'=>'Add Success', 'code'=>'100')
 */

//加載數據模型

$video_store_db = pc_base::load_model('video_store_model');
$special_db = pc_base::load_model('special_model');
$special_content_db = pc_base::load_model('special_content_model');
$content_data_db = pc_base::load_model('special_c_data_model');
$type_db = pc_base::load_model('type_model');

pc_base::load_app_func('global', 'video');

//驗證信息
$data = $video_data = array();

$data['specialid'] = intval($_POST['specialid']);
if (!$data['specialid']) {
	echo json_encode(array('msg'=>'Specialid do not empty', 'code'=>'1'));
	exit;
} 
if (!$special_info = $special_db->get_one(array('id'=>$data['specialid']))) {
	echo json_encode(array('msg'=>'The system does not exist this special', 'code'=>2));
	exit;
}
$data['title'] = $video_data['title'] = safe_replace($_POST['title']);
if (!$data['title']) {
	echo json_encode(array('msg'=>'Video\'s title not empty', 'code'=>3));
	exit;
}
$content = $_POST['desc'] ? addslashes($_POST['desc']) : '';
$data['description'] = $video_data['description'] = substr($content, 0, 255);
$data['keywords'] = $video_data['keywords'] = $_POST['tag'] ? addslashes($_POST['tag']) : '';
$vid = $video_data['vid'] = $_POST['vid'];
if (!$vid) {
	echo json_encode(array('msg'=>'Vid do not empty', 'code'=>4));
	exit;
}
//先將視頻加入到視頻庫中，並取得videoid
//判斷vid是否已經存在視頻庫中
if (!$video_store = $video_store_db->get_one(array('vid'=>$vid))) {
	$video_data['status'] = $_POST['status'] ? intval($_POST['status']) : 21;
	$video_data['picpath'] = safe_replace( format_url($_POST['picPath']) );
	$video_data['addtime'] = intval(substr($_POST['uploadTime'], 0, 10));
	$video_data['timelen'] = intval($_POST['videoTime']);
	$video_data['size'] = intval($_POST['videoSize']);
	if (strtolower(CHARSET)!='utf-8') {
		$video_data = array_iconv($video_data, 'utf-8', 'gbk');
	}
	$videoid = $video_store_db->insert($video_data, true);
} else {
	$videoid = $video_store['vid'];
}
//構建special_content表數據字段
$res = $type_db->get_one(array('parentid'=>$data['specialid'], 'module'=>'special'), 'typeid', 'listorder ASC');
$data['typeid'] = $res['typeid'];
$data['thumb'] = $video_data['picpath'];
$data['videoid'] = $videoid;
//組合POST數據
$data['inputtime'] = SYS_TIME;
$data['updatetime'] = SYS_TIME;
if (strtolower(CHARSET)!='utf-8') {
	$data = array_iconv($data, 'utf-8', 'gbk');
}
$contentid = $special_content_db->insert($data, true);
// 向數據統計表添加數據
$count = pc_base::load_model('hits_model');
$hitsid = 'special-c-'.$data['specialid'].'-'.$contentid;
$count->insert(array('hitsid'=>$hitsid, 'views'=>intval($_POST['playnum'])));
//將內容加到data表中
$content = iconv('utf-8', 'gbk', $content);
$content_data_db->insert(array('id'=>$contentid, 'content'=>$content));
//更新search表
$search_db = pc_base::load_model('search_model');
$siteid = $special_info['siteid'];
$type_arr = getcache('type_module_'.$siteid,'search');
$typeid = $type_arr['special'];
$searchid = $search_db->update_search($typeid ,$contentid,'',$data['title'], $data['inputtime']);
//獲取專題的url
$html = pc_base::load_app_class('html', 'special');
$urls= $html->_create_content($contentid);
$special_content_db->update(array('url'=>$urls[0], 'searchid'=>$searchid), array('id'=>$contentid));
if ($_POST['end_status']) {
	$html->_index($data['specialid'], 20, 5);
}
echo json_encode(array('msg'=>'Add Success', 'code'=>'200'));
exit;