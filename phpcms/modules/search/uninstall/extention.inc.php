<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied');

$menu_db = pc_base::load_model('menu_model');
$menu_db->delete(array('name'=>'fulltext_search'));
$menu_db->delete(array('name'=>'search_setting'));
$menu_db->delete(array('name'=>'createindex'));

// if(!$typeid) return FALSE;
?> 