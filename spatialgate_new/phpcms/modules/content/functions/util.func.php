<?php
/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $pageurls 链接地址
 * @return 分页
 */
function content_pages($num, $curr_page,$pageurls) {
	$multipage = '';
	$page = 11;
	$offset = 4;
	$pages = $num;
	$from = $curr_page - $offset;
	$to = $curr_page + $offset;
	$more = 0;
	if($page >= $pages) {
		$from = 2;
		$to = $pages-1;
	} else {
		if($from <= 1) {
			$to = $page-1;
			$from = 2;
		} elseif($to >= $pages) {
			$from = $pages-($page-2);
			$to = $pages-1;
		}
		$more = 1;
	}
	if($curr_page>0) {
		$perpage = $curr_page == 1 ? 1 : $curr_page-1;
		$multipage .= '<a class="a1" href="'.$pageurls[$perpage][0].'">'.L('previous').'</a>';
		if($curr_page==1) {
			$multipage .= ' <span>1</span>';
		} elseif($curr_page>6 && $more) {
			$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>..';
		} else {
			$multipage .= ' <a href="'.$pageurls[1][0].'">1</a>';
		}
	}
	for($i = $from; $i <= $to; $i++) {
		if($i != $curr_page) {
			$multipage .= ' <a href="'.$pageurls[$i][0].'">'.$i.'</a>';
		} else {
			$multipage .= ' <span>'.$i.'</span>';
		}
	}
	if($curr_page<$pages) {
		if($curr_page<$pages-5 && $more) {
			$multipage .= ' ..<a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</a>';
		} else {
			$multipage .= ' <a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</a>';
		}
	} elseif($curr_page==$pages) {
		$multipage .= ' <span>'.$pages.'</span> <a class="a1" href="'.$pageurls[$curr_page][0].'">'.L('next').'</a>';
	}
	return $multipage;
}

/**
 * 返回指定欄目的URL
 *
 * @param $catid 欄目id
 */
function cat_url($catid,$new_url=''){
	$siteids = getcache('category_content','commons');
	$siteid = $siteids[$catid];
	$category_arr = getcache('category_content_'.$siteid,'commons');
	if(!isset($category_arr[$catid])) return '';
	$url = $category_arr[$catid]['url'];
	if(strpos($url, '://') === false) $url = $siteurl.$url;
	if($new_url!=''){
		//對URL去掉catid-1.html操作
		$new_url = '';
		$new_url = str_replace("http://", '', $url);
		$array = explode("/", $new_url);
		$array_num = count($array);
		if($array_num==3){
			$url = "http://".$array[0].DIRECTORY_SEPARATOR.$array[1]."/";
		}
	}
	return $url;
}

?>