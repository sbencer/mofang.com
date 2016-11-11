<?php

function smarty_compiler_bodyjs($arrParams,  $smarty){
    $strAttr = '';
    foreach ($arrParams as $_key => $_value) {
        $strAttr .= ' ' . $_key . '="<?php echo ' . $_value . ';?>"';
    }
    return '';
}

function smarty_compiler_bodyjsclose($arrParams,  $smarty){
    $strCode = '';
    $strCode .= '<?php ';
    $strCode .= 'if(class_exists(\'FISPagelet\', false)){';
    $strCode .= 'echo FISPagelet::jsHook();';
    $strCode .= '}';
    $strCode .= '?>';
    return $strCode;
}
