<?php
/**
 * 获取日历展示html
 * 传入需要展示的年月，以及是否需要展示事件
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

pc_base::load_sys_class('smarty','',0);

$year = intval($_GET['year']);
$month = intval($_GET['month']);
$event = $_GET['event'];

echo get_calendar($year, $month,$event);

function get_calendar($year, $month, $event) {
    $event_arr = array();
    $tag = pc_base::load_app_class('content_tag', 'content');
    // 如果需要事件查询，则查询目标年月事件
    if($event == 1) {
        $event_arr = $tag->event(array('year'=>$year, 'month'=>$month,'catid'=>37, 'num'=>30));
        if($month != date('m') || $year != date('Y')) {
            $smarty = new CSmarty();
            $smarty->assign('event', $event_arr);
            echo $smarty->fetch('tw_acg/widget/events.tpl');
        }
    }
    echo $calstr = $tag->calendar(array('year'=>$year, 'month'=>$month, 'event'=>$event_arr));
}

