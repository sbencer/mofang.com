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
		// $multipage .= '<a class="page-l" target="_self" href="'.$pageurls[$perpage][0].'">'.L('previous').'</a>';
		$multipage .= '<a class="page-l" target="_self" href="javascript:void(0);">'.L('previous').'</a>';
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
		// $multipage .= ' <a target="_self" class="page-on">'.$pages.'</span> <a target="_self" class="page-r" href="'.$pageurls[$curr_page][0].'">'.L('next').'</a>';
		$multipage .= ' <a target="_self" class="page-on">'.$pages.'</span> <a target="_self" class="page-r" href="javascript:void(0);">'.L('next').'</a>';
	}
	return $multipage;
}

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
?>
