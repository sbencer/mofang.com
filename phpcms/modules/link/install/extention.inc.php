<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'link', 'parentid'=>29, 'm'=>'link', 'c'=>'link', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_link', 'parentid'=>$parentid, 'm'=>'link', 'c'=>'link', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_link', 'parentid'=>$parentid, 'm'=>'link', 'c'=>'link', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'delete_link', 'parentid'=>$parentid, 'm'=>'link', 'c'=>'link', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'link_setting', 'parentid'=>$parentid, 'm'=>'link', 'c'=>'link', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'add_type', 'parentid'=>$parentid, 'm'=>'link', 'c'=>'link', 'a'=>'add_type', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'list_type', 'parentid'=>$parentid, 'm'=>'link', 'c'=>'link', 'a'=>'list_type', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'check_register', 'parentid'=>$parentid, 'm'=>'link', 'c'=>'link', 'a'=>'check_register', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$link_db = pc_base::load_model('link_model');
$link_db->insert(array('siteid'=>1,'typeid'=>$typeid,'linktype'=>'1','name'=>'PHPCMS','url'=>'http://www.phpcms.cn','logo'=>'http://www.phpcms.cn/images/logo_88_31.gif','passed'=>1,'addtime'=>SYS_TIME)); 
$link_db->insert(array('siteid'=>1,'typeid'=>$typeid,'linktype'=>'1','name'=>'盛大在線','url'=>'http://www.sdo.com','logo'=>'http://www.snda.com/cn/logo/comp_logo_sdo.gif','passed'=>1,'addtime'=>SYS_TIME));

$language = array('link'=>'友情鏈接', 'add_link'=>'添加友情鏈接', 'edit_link'=>'編輯友情鏈接', 'delete_link'=>'刪除友情鏈接', 'link_setting'=>'模塊配置', 'add_type'=>'添加類別', 'list_type'=>'分類管理', 'check_register'=>'審核申請');
?>