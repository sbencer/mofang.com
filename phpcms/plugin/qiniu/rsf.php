<?php

require_once("http.php");

define('Qiniu_RSF_EOF', 'EOF');

/**
 * 1. 首次請求 marker = ""
 * 2. 無論 err 值如何，均應該先看 items 是否有內容
 * 3. 如果後續沒有更多數據，err 返回 EOF，markerOut 返回 ""（但不通過該特征來判斷是否結束）
 */
function Qiniu_RSF_ListPrefix(
	$self, $bucket, $prefix = '', $marker = '', $limit = 0) // => ($items, $markerOut, $err)
{
	global $QINIU_RSF_HOST;

	$query = array('bucket' => $bucket);
	if (!empty($prefix)) {
		$query['prefix'] = $prefix;
	}
	if (!empty($marker)) {
		$query['marker'] = $marker;
	}
	if (!empty($limit)) {
		$query['limit'] = $limit;
	}

	$url =  $QINIU_RSF_HOST . '/list?' . http_build_query($query);
	list($ret, $err) = Qiniu_Client_Call($self, $url);
	if ($err !== null) {
		return array(null, '', $err);
	}

	$items = $ret['items'];
	if (empty($ret['marker'])) {
		$markerOut = '';
		$err = Qiniu_RSF_EOF;
	} else {
		$markerOut = $ret['marker'];
	}
	return array($items, $markerOut, $err);
}

