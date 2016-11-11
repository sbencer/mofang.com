<?php
defined('IN_PHPCMS') or exit('No permission resources.'); 

/**
 * 
 * 視頻狀態接收接口 vms系統收到ku6系統中視頻狀態改變時post到cms系統中，此接口負責接收數據改變視頻庫中視頻的狀態
 * 
 * @author				chenxuewang
 * @link				http://www.phpcms.cn http://www.ku6.cn
 * @copyright			CopyRight (c) 2006-2012 上海盛大網絡發展有限公司
 * @license			http://www.phpcms.cn/license/
 * ---------------------------------------------------------------------
 * 參數說明
 * vid, picpath, size, timelen, status
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
 */

$video_setting = getcache('video');
pc_base::load_app_func('global', 'video');

pc_base::load_app_class('ku6api', 'video', 0);
$ku6api = new ku6api($video_setting['skey'], $video_setting['sn']);

$msg = $ku6api->update_video_status_from_vms();
exit($msg);
?>