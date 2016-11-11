<?php
class FISBlockFisWidget{//為了處理參數壓棧，定義一個靜態變量：參數棧
    private static $_vars = array();
    public static function push($params, &$tpl_vars){
        self::$_vars[] = $tpl_vars;
        foreach($params as $key => $value){
            if($value instanceof Smarty_Variable){
                $tpl_vars[$key] = $value;
            } else {
                $tpl_vars[$key] = new Smarty_Variable($value);
            }
        }
    }
    public static function pop(&$tpl_vars){
        $tpl_vars = array_pop(self::$_vars);
    }
}

function smarty_block_widget_inline($params, $content, Smarty_Internal_Template $template, &$repeat){
    if(!$repeat){//block 定義結束
        FISBlockFisWidget::pop($template->tpl_vars);
        return $content;
    }else{//block 定義開始
        FISBlockFisWidget::push($params, $template->tpl_vars);
    }
}
