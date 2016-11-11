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
 * title, description, tag, vid, picpath, size, timelen, status, playnum, catid, posid
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
 * catid 導入到本系統欄目ID 導入過來的視頻，首先發布為內容，同時將視頻放入視頻庫中供以後使用
 * 
 * posid 本系統推薦位ID 可以為空，不為空時，需要將視頻添加到推薦位表中
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
$content = pc_base::load_model('content_model');
$cat_db = pc_base::load_model('category_model');
$model_field = pc_base::load_model('sitemodel_field_model');
$video_setting = getcache('video', 'video');
//加載v.class
pc_base::load_app_func('global', 'video');
pc_base::load_app_class('v', 'video', 0);
$v = new v($db);

//驗證信息
$data = $video_data = array();
$data['catid'] = intval($_POST['catid']);
if (!$data['catid']) {
	$data['catid'] = $video_setting['catid'];
} 
$cat_info = $cat_db->get_one(array('catid'=>$data['catid']));

$data['title'] = $video_data['title'] = $_POST['title'];
if (!$data['title']) {
	echo json_encode(array('msg'=>'The parameter title must have a value', 'code'=>3));
	exit;
}
if (!$_POST['picpath'] || strripos($_POST['picpath'],'.jpg')===false) {
	echo json_encode(array('msg'=>'The parameter picpath must have a value', 'code'=>5));
	exit;
}
$data['content'] = $_POST['description'] ? addslashes($_POST['description']) : '';
$data['description'] = $video_data['description'] = substr($data['content'], 0, 255);
$data['keywords'] = $video_data['keywords'] = $_POST['tag'] ? $_POST['tag'] : '';
$video_data['timelen'] = intval($_POST['timelen']);
$video_data['size'] = intval($_POST['size']);
$video_data['vid'] = $_POST['vid'];
if (!$video_data['vid']) {
	echo json_encode(array('msg'=>'The parameter vid must have a value', 'code'=>4));
	exit;
}

//先將視頻加入到視頻庫中，並取得videoid
//判斷vid是否已經存在視頻庫中
if (!$video_store = $video_store_db->get_one(array('vid'=>$video_data['vid']))) {
	$video_data['status'] = $_POST['ku6status'] ? intval($_POST['ku6status']) : 1;
	$video_data['picpath'] = safe_replace( format_url($_POST['picpath']) );
	$video_data['addtime'] = $_POST['createtime'] ? $_POST['createtime'] : SYS_TIME;
	$video_data['channelid'] = 1;
	if (strtolower(CHARSET)!='utf-8') {
		$video_data = array_iconv($video_data, 'utf-8', 'gbk');
	}
	$videoid = $video_store_db->insert($video_data, true);
} else {
	$videoid = $video_store['videoid'];
}
if (!$cat_info) {
	echo json_encode(array('msg'=>'Add Success', 'code'=>'200'));
	exit;
}
//根據欄目信息取得站點id及模型id
$siteid = $cat_info['siteid'];
$modelid = $cat_info['modelid'];
//根據模型id，得到視頻字段名
$r = $model_field->get_one(array('modelid'=>$modelid, 'formtype'=>'video'), 'field');
$fieldname = $r['field'];
if ($_POST['posid']) {
	$data['posids'][] = $_POST['posid'];
}
$data['thumb'] = safe_replace( format_url($_POST['picpath']) );
$data[$fieldname] = 1;
//組合POST數據
$_POST[$fieldname.'_video'][1] = array('videoid'=>$videoid, 'listorder'=>1);
$data['status'] = ($video_data['status'] == 21 || $_POST['status']==1) ? 99 : 1;
//調用內容模型
if (strtolower(CHARSET)!='utf-8') {
	$data = array_iconv($data, 'utf-8', 'gbk');
}
$content->set_model($modelid); 
$cid = $content->add_content($data);
//更新對應關系
//$content_video_db = pc_base::load_model('video_content_model');
//$content_video_db->insert(array('contentid'=>$cid, 'videoid'=>$videoid, 'modelid'=>$modelid, 'listorder'=>1));
//更新點擊次數 
if ($_POST['playnum']) {
	$views = intval($_POST['playnum']);
	$hitsid = 'c-'.$modelid.'-'.$cid;
	$count = pc_base::load_model('hits_model');
	$count->update(array('views'=>$views), array('hitsid'=>$hitsid));
}

echo json_encode(array('msg'=>'Add Success', 'code'=>'200'));
exit;
?>