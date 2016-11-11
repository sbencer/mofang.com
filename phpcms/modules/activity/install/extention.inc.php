<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'activity', 'parentid'=>0, 'm'=>'activity', 'c'=>'activity', 'a'=>'init', 'data'=>'s=1', 'listorder'=>10, 'display'=>'1'), true);
$managerid = $menu_db->insert(array('name'=>'activity_manager', 'parentid'=>$parentid, 'm'=>'activity', 'c'=>'activity', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$activity_listid = $menu_db->insert(array('name'=>'activity_lists', 'parentid'=>$managerid, 'm'=>'activity', 'c'=>'activity', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_activity', 'parentid'=>$activity_listid, 'm'=>'activity', 'c'=>'activity', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('activity'=>'活動', 'activity_manager'=>'管理活動', 'activity_lists'=>'活動列表', 'add_activity'=>'添加活動');
?>