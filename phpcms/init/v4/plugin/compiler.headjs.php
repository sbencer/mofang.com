<?php

function smarty_compiler_headjs($arrParams,  $smarty){
    $strAttr = '';
    foreach ($arrParams as $_key => $_value) {
        $strAttr .= ' ' . $_key . '="<?php echo ' . $_value . ';?>"';
    }
    return '';
}

function smarty_compiler_headjsclose($arrParams,  $smarty){
    $strResourceApiPath = preg_replace('/[\\/\\\\]+/', '/', dirname(__FILE__) . '/lib/FISPagelet.class.php');
    $strCode = '<?php ';
    $strCode .= 'if(!class_exists(\'FISPagelet\', false)){require_once(\'' . $strResourceApiPath . '\');}';
    $strCode .= 'echo FISPagelet::cssHook();';
    $strCode .= '?>';
    $strCode .= '<?php ';
    $strCode .= 'if(!class_exists(\'FISPagelet\', false)){require_once(\'' . $strResourceApiPath . '\');}';
    $strCode .= 'echo FISPagelet::jsLoaderHook();';
    $strCode .= '?>';
    return $strCode;
}
