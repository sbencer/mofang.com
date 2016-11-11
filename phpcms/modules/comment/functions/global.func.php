<?php

/*
 * 獲取文章評論用戶數
 * $commentid 評論id
 *
 **/
function count_users( $commentid, $siteid ){

	$comment_db = pc_base::load_model('comment_model');
	$comment_data_db = pc_base::load_model('comment_data_model');

	if (empty($commentid)) return false;
	if (empty($siteid)) {
		pc_base::load_app_func('global', 'comment');
		list($module,$contentid, $siteid) = decode_commentid($commentid);
	}
	$comment = $comment_db->get_one(array('commentid'=>$commentid, 'siteid'=>$siteid));
	if (!$comment) return false;
	//設置存儲數據表
	$comment_data_db->table_name($comment['tableid']);
	$count_user = $comment_data_db->get_one("`commentid`='".$commentid."'", 'count(DISTINCT `userid`) as count_user');
	$count_user = $count_user['count_user'];

	return $count_user;
}

/**
 * 解析評論ID
 * @param $commentid 評論ID
 */
function decode_commentid($commentid) {
	return explode('-', $commentid);
}

/**
 * 方向生成
 * @param $direction
 */
function direction($direction) {
	switch($direction){
		case 1:
			return '<img src="'.IMG_PATH.'/icon/zheng.png" />';
		break;
		case 2:
			return '<img src="'.IMG_PATH.'/icon/fan.png" />';
		break;
		case 3:
			return '<img src="'.IMG_PATH.'/icon/zhong.png" />';
		break;
	}
}
 
/**
 * 通過API接口調用標題和URL數據
 * @param string $commentid    評論ID
 * @return array($title, $url)   返回數據
 */
function get_comment_api($commentid) {
	list($modules, $contentid, $siteid) = id_decode($commentid);
	if (empty($modules) || empty($siteid) || empty($contentid)) {
		return false;
	}
	$comment_api = '';
	$module = explode('_', $modules);
	$comment_api = pc_base::load_app_class('comment_api', $module[0]);
	if (empty($comment_api)) return false;
	return $comment_api->get_info($modules, $contentid, $siteid);
}
