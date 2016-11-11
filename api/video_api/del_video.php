<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
 * 
 * 視頻刪除接收接口 在vms系統中刪除視頻時，會調用此接口
 * 
 * @author				chenxuewang
 * @link				http://www.phpcms.cn http://www.ku6.cn
 * @copyright			CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 * @license				http://www.phpcms.cn/license/
 * 
 * 
 * *************************************
 *              			           *
 *                 參數說明            *
 *                                     *
 * ************************************* 
 * 
 * vid，視頻vid，視頻的唯一的標示符。區分視頻
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

$vid = $_POST['ku6vid'];
if (!$vid) {
	echo json_encode(array('msg'=>'Vid do not empty', 'code'=>4));
	exit;
}

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

$video_store_db->update(array('status'=>'-30'), array('vid'=>$vid));
echo json_encode(array('msg'=>'Delete video successful', 'code'=>200,'vid'=>$vid));
?>