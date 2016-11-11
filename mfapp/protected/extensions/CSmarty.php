<?php

Yii::$enableIncludePath = false;
require_once(Yii::getPathOfAlias('application.extensions') . '/smarty/v4/smarty/Smarty.class.php');
define('SMARTY_BASE_PATH', Yii::getPathOfAlias('application.extensions.smarty.v4'));
define('SMARTY_VIEW_PATH', Yii::getPathOfAlias('webroot.themes.partition'));

class CSmarty extends Smarty { 
    public function __construct() {
        parent::__construct();  
        $this->setTemplateDir(SMARTY_VIEW_PATH . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'v4');
        $this->setCompileDir(SMARTY_VIEW_PATH . DIRECTORY_SEPARATOR . 'templates_c');
        $this->setConfigDir(SMARTY_VIEW_PATH . DIRECTORY_SEPARATOR . 'config');
        $this->setCacheDir(SMARTY_VIEW_PATH . DIRECTORY_SEPARATOR . 'cache');
        $this->addPluginsDir(SMARTY_BASE_PATH . DIRECTORY_SEPARATOR . 'plugin');
        $this->addConfigDir(SMARTY_VIEW_PATH . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'v4' . DIRECTORY_SEPARATOR . 'fis_config');
        $this->registerPlugin('function','test_data', 'test_data');
    }
    public function init() {} 
}

function test_data($params, &$smarty) {
    $c1 = $params['c1'];
    $c2 = $params['c2'];
    $c3 = $params['c3'];
    $r = array();
    if (isset($c3)) {
        for ($i = 0; $i < $c3; $i++) {
            $r[$i] = test_data(array(
                "c1"=>$c1,
                "c2"=>$c2
            ));
        }
    }else if(isset($c2)) {
        for ($i = 0; $i < $c2; $i++) {
            $r[$i] = test_data(array(
                "c1"=>$c1
            ));
        }
    }else{
        for ($i = 0; $i < $c1; $i++) {
            $r[$i] = array();
        }
    }
    if (isset($smarty)) {
        $smarty->assign("data",$r);
        return "";
    }else{
        return $r;
    }
}
?>
