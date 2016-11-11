<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 刪除30天前的消息隊列
 */
function del_queue() {
	$times = SYS_TIME-2592000;
	$queue = pc_base::load_model('queue_model');
	$queue->delete("times <= $times");
}