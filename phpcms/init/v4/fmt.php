<?php
if(!defined("MFE_BASE_PATH")){
    exit("MFE_BASE_PATH not defined");
}

require_once (MFE_BASE_PATH . '/format.php');

function display($tpl) {
    global $smarty;
    $fmt = $_GET['format'];
    $format = new Format;
    $html = $smarty->fetch($tpl);
    if (isset($fmt)) {
        $formatted_html = $format->HTML($html);
        echo $formatted_html;
    }else{
        echo $html;
    }
}

