<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'fulltext_search', 'parentid'=>'29', 'm'=>'search', 'c'=>'search_type', 'a'=>'init', 'data'=>'', 'listorder'=>14, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'search_setting', 'parentid'=>$parentid, 'm'=>'search', 'c'=>'search_admin', 'a'=>'setting', 'data'=>'', 'listorder'=>1, 'display'=>'1'));
$menu_db->insert(array('name'=>'createindex', 'parentid'=>$parentid, 'm'=>'search', 'c'=>'search_admin', 'a'=>'createindex', 'data'=>'', 'listorder'=>2, 'display'=>'1'));


?>