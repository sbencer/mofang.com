<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
 * 
 * 視頻修改接收接口 在vms系統中修改視頻時，會調用此接口更新這些視頻
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
 * title, description, tag, vid, picpath, size, timelen, status, playnum
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
 * 
 * 
 * ************************************
 *              			          *
 *                 返 回 值           *
 *                                    *
 * ************************************ 
 * 
 * 接口執行後，應返回相應的值通知vms系統
 * 返回值格式 json數據，array('msg'=>'Edit Success', 'code'=>'100')
 */

//加載數據模型
$video_store_db = pc_base::load_model('video_store_model');
pc_base::load_app_func('global', 'video');

//驗證信息
$data = array();

$vid = $_POST['vid'];
if (!$vid) {
	echo json_encode(array('msg'=>'Vid do not empty', 'code'=>4));
	exit;
}
if ($_POST['title'])		$data['title'] = safe_replace($_POST['title']);
if ($_POST['description'])  $data['description'] = safe_replace($_POST['description']);
if ($_POST['keywords'])		$data['keywords'] = safe_replace($_POST['tag']);
if ($_POST['picpath'])		$data['picpath'] = safe_replace(format_url($_POST['picpath']));
if ($_POST['size'])			$data['size'] = $_POST['size'];
if ($_POST['timelen'])		$data['timelen'] = intval($_POST['timelen']);
if ($_POST['ku6status'])	$data['status'] = intval($_POST['ku6status']);
if ($_POST['playnum'])		$data['playnum'] = intval($_POST['playnum']);

if ($data['status']<0 || $data['status']==24) {
	$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
	$videoid = $r['videoid'];
	//$video_store_db->delete(array('vid'=>$vid)); //刪除此視頻
	/**
	 * 加載視頻內容對應關系數據模型，檢索與刪除視頻相關的內容。
	 * 在對應關系表中解除關系，並更新內容的靜態頁
	 */
	$video_content_db = pc_base::load_model('video_content_model');
	$result = $video_content_db->select(array('videoid'=>$videoid));
	if (is_array($result) && !empty($result)) {
		//加載更新html類
		$html = pc_base::load_app_class('html', 'content');
		$content_db = pc_base::load_model('content_model');
		$url = pc_base::load_app_class('url', 'content');
		foreach ($result as $rs) {
			$modelid = intval($rs['modelid']);
			$contentid = intval($rs['contentid']);
			$video_content_db->delete(array('videoid'=>$videoid, 'contentid'=>$contentid, 'modelid'=>$modelid));
			$content_db->set_model($modelid);
			$table_name = $content_db->table_name;
			$r1 = $content_db->get_one(array('id'=>$contentid));
			/**
			 * 判斷如果內容頁生成了靜態頁，則更新靜態頁
			 */
			if (ishtml($r1['catid'])) {
				$content_db->table_name = $table_name.'_data';
				$r2 = $content_db->get_one(array('id'=>$contentid));
				$r = array_merge($rs, $r2);unset($r1, $r2);
				if($r['upgrade']) {
					$urls[1] = $r['url'];
				} else {
					$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
				}
				$html->show($urls[1], $r, 0, 'edit');
			} else {
				continue;
			}
		}
	}
} elseif ($data['status']==21) {
	$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
	$videoid = $r['videoid'];
	/**
	 * 加載視頻內容對應關系數據模型，檢索與刪除視頻相關的內容。
	 * 在對應關系表中找出對應的內容id，並更新內容的靜態頁
	 */
	$video_content_db = pc_base::load_model('video_content_model');
	$result = $video_content_db->select(array('videoid'=>$videoid));
	if (is_array($result) && !empty($result)) {
		//加載更新html類
		$html = pc_base::load_app_class('html', 'content');
		$content_db = pc_base::load_model('content_model');
		$content_check_db = pc_base::load_model('content_check_model');
		$url = pc_base::load_app_class('url', 'content');
		foreach ($result as $rs) {
			$modelid = intval($rs['modelid']);
			$contentid = intval($rs['contentid']);
			$content_db->set_model($modelid);
			$c_info = $content_db->get_one(array('id'=>$contentid), 'thumb');

			$where = array('status'=>99);
			if (!$c_info['thumb']) $where['thumb'] = $data['picpath'];
			$content_db->update($where, array('id'=>$contentid));
			$checkid = 'c-'.$contentid.'-'.$modelid;
			$content_check_db->delete(array('checkid'=>$checkid));
			$table_name = $content_db->table_name;
			$r1 = $content_db->get_one(array('id'=>$contentid));
			/**
			 * 判斷如果內容頁生成了靜態頁，則更新靜態頁
			 */
			if (ishtml($r1['catid'])) {
				$content_db->table_name = $table_name.'_data';
				$r2 = $content_db->get_one(array('id'=>$contentid));
				$r = array_merge($r1, $r2);unset($r1, $r2);
				if($r['upgrade']) {
					$urls[1] = $r['url'];
				} else {
					$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
				}
				$html->show($urls[1], $r, 0, 'edit');
				
			} else {
				continue;
			}
		}
	}
}
//修改視頻庫中的視頻
if (strtolower(CHARSET)!='utf-8') {
	$data = array_iconv($data, 'utf-8', 'gbk');
}
$video_store_db->update($data, array('vid'=>$vid));
echo json_encode(array('msg'=>'Edit successful', 'code'=>200,'vid'=>$vid));
?>