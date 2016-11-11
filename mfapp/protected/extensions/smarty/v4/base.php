<?php
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

DEFINE('MFE_BASE_PATH', __DIR__.DIRECTORY_SEPARATOR);

require_once (MFE_BASE_PATH.'smarty.php');
require_once (MFE_BASE_PATH.'fmt.php');
require_once (MFE_BASE_PATH.'i18n.php');
