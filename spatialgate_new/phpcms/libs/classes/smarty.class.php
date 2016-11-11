<?php
/**
 * Created by PhpStorm.
 * User: yuzhiguo
 * Date: 15/9/23
 * Time: 上午7:06
 */

define("MFE_BASE_PATH", PHPCMS_PATH . "phpcms/init/");
define("MFE_SMARTY_TEMPLATES", PHPCMS_PATH . "phpcms/templates/v4/");

require_once (MFE_BASE_PATH."smarty".DIRECTORY_SEPARATOR."Smarty.class.php");

class CSmarty extends Smarty{

    /**
     * Initialize new Smarty object

     */
    public function __construct()
    {
        parent::__construct();
        // 插件目錄
        defined("MFE_BASE_PATH") || DEFINE('MFE_BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
        // 模板目錄 mfe工具 v4 fis本地調試使用 /templates/v4/
        defined("MFE_LOCAL") || DEFINE('MFE_SMARTY_TEMPLATES', MFE_BASE_PATH."templates".DIRECTORY_SEPARATOR."v4".DIRECTORY_SEPARATOR);
        // 是否啟啟用模板調試
        defined("MFE_SMERT_DEBUG") || define("MFE_SMART_DEBUG",0);

        $this->smarty = $this;
        $this->setConfigDir(MFE_BASE_PATH."config")
            ->setCacheDir(MFE_BASE_PATH."cache")
            ->setCompileDir(PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR."templates_c".DIRECTORY_SEPARATOR)
            ->addPluginsDir(MFE_BASE_PATH."plugin");

        $this->setTemplateDir(MFE_SMARTY_TEMPLATES);
        $this->addConfigDir(MFE_SMARTY_TEMPLATES."fis_config");
        $this->php_handling = SMARTY_PHP_ALLOW ;
        $this->debugging_ctrl = 'URL';
        //$smarty->force_compile = true;

    }

}