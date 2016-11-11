<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('UNINSTALL') or exit('Access Denied');

$menu_db = pc_base::load_model('menu_model');
$menu_db->delete(array('name'=>'statistics'));

?> 
