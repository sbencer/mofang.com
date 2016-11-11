<?php
/**
 * 分頁函數
 * 
 * @param $num 信息總數
 * @param $curr_page 當前分頁
 * @param $pageurls 鏈接地址
 * @return 分頁
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
		$multipage .= '<a class="page-l" target="_self" href="'.$pageurls[$perpage][0].'">'.L('previous').'</a>';
		if($curr_page==1) {
			$multipage .= ' <a target="_self" class="page-on">1</a>';
		} elseif($curr_page>6 && $more) {
			$multipage .= ' <a target="_self" href="'.$pageurls[1][0].'">1</a>..';
		} else {
			$multipage .= ' <a target="_self" href="'.$pageurls[1][0].'">1</a>';
		}
	}
	for($i = $from; $i <= $to; $i++) {
		if($i != $curr_page) {
			$multipage .= ' <a target="_self" href="'.$pageurls[$i][0].'">'.$i.'</a>';
		} else {
			$multipage .= ' <a target="_self" class="page-on">'.$i.'</a>';
		}
	}
	if($curr_page<$pages) {
		if($curr_page<$pages-5 && $more) {
			$multipage .= ' ..<a target="_self" href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a target="_self" class="page-r" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</a>';
		} else {
			$multipage .= ' <a target="_self" href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a target="_self" class="page-r" href="'.$pageurls[$curr_page+1][0].'">'.L('next').'</a>';
		}
	} elseif($curr_page==$pages) {
		$multipage .= ' <a target="_self" class="page-on">'.$pages.'</span> <a target="_self" class="page-r" href="'.$pageurls[$curr_page][0].'">'.L('next').'</a>';
	}
	return $multipage;
}

/**
 * 文章標籤名稱獲取
 * @params $tid 文章內保存的tag類型的id
 * return string 返回tag對應的中文信息
 */
 function get_tag($tid) {
    $tags = array(
        '1' =>'情報',
        '2' => '產業',
        '3' => '趣味',
        '4' => '動漫',
        '5' => '評測',
        '6' => '攻略',
        '7' => '採訪',
        '8' =>'專訪',
        '9' => '女性向'
    );
    
    return $tags[$tid]?:'';    
     
 }
 
 /**
 * 文章標籤新聞鏈結獲取
 * @params $tid 文章內保存的tag類型的id
 * return string 返回tag對應的中文信息
 */
 function get_tag_url($tid) {
    $tags = array(
        '1' => '/tag/10000286-1.html',
        '2' => '/tag/10000287-1.html',
        '3' => '/tag/10000288-1.html',
        '4' => '/tag/10000289-1.html',
        '5' => '/tag/10000290-1.html',
        '6' => '/tag/10000291-1.html',
        '7' => '/tag/10000292-1.html',
        '8' => '/tag/10000293-1.html',
        '9' => '/tag/10000294-1.html',
    );
    
    return $tags[$tid]?:'';    
     
 }

?>
