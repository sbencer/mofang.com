<?php

/**
 *
 *   // 依賴模塊
 *   define("MFE_TEMPLATES_RELEASE_VERSION_ID","zhangzhiwei_12_1413783075"); // 模板版本,當版本號不同時會同步模板
 *
 *   // 調試模式
 *   define('MFE_TEMPLATES_DEBUG',true); // 是否開啟調試模式
 *   define('TEMPLATES_CHANNEL',zhangzhiwei_12); // 調試時的模板通道編號
 *
 */


// 發布版本標識
defined("MFE_TEMPLATES_RELEASE_VERSION_ID") or define("MFE_TEMPLATES_RELEASE_VERSION_ID","");

// 調試的通道
if(isset($_GET['templates_channel'])){ // url 參數中獲取
    define('MFE_TEMPLATES_CHANNEL',$_GET['templates_channel']);
}
else if(isset($_SERVER['HTTP_TEMPLATES_CHANNEL']) ){ // http header 中獲取
    define('MFE_TEMPLATES_CHANNEL',$_SERVER['HTTP_TEMPLATES_CHANNEL']);
}
else if(defined('TEMPLATES_CHANNEL') and defined('TEMPLATES_CHANNEL')){ // 從外部定義的常量中獲取
    define('MFE_TEMPLATES_CHANNEL',TEMPLATES_CHANNEL);
}else{
    define('MFE_TEMPLATES_CHANNEL',"");
}

// 是否啟用調試模式
$mfe_templates_debug = false;
function is_mfe_debug(){
    global $mfe_templates_debug;
    return $mfe_templates_debug;
}

if(!defined('MFE_TEMPLATES_DEBUG')){
    $mfe_templates_debug = false;
}else if(MFE_TEMPLATES_DEBUG){
    $mfe_templates_debug = true;
}else{
    $mfe_templates_debug = false;
}

// 如果設置調試通道,則自動開啟調試模式
if(isset($_SERVER['HTTP_TEMPLATES_CHANNEL']) or isset($_GET['templates_channel'])){
    $mfe_templates_debug = true;
}
// TODO:調試模式和線上模式使用不同的目錄,以便不影響線上環境正常運行

// 模板服務器域名
defined('MFE_TEMPLATES_SERVER') or define('MFE_TEMPLATES_SERVER','http://templates.mofang.com');

// 外網模板服務器地址
defined('MFE_TEMPLATES_SERVER_ONLINE') or define('MFE_TEMPLATES_SERVER_ONLINE','http://templates-online.mofang.com');

// 調試的模板路徑
defined('MFE_TEMPLATES_CHANNEL_PATH') or define('MFE_TEMPLATES_CHANNEL_PATH',MFE_TEMPLATES_SERVER.'/channel');

// 調試的實際模板路徑
defined('MFE_TEMPLATES_CHANNEL_PATH_REAL') or define('MFE_TEMPLATES_CHANNEL_PATH_REAL',MFE_TEMPLATES_SERVER.'/channel/'.MFE_TEMPLATES_CHANNEL.'/templates/v4');

// 模板服務器接口路徑
defined('MFE_TEMPLATES_API') or define('MFE_TEMPLATES_API',MFE_TEMPLATES_SERVER.'/api');


// 如果是線上環境
if(!is_mfe_debug()){ // 線上模式
    // 手動更新:
    // 1.檢查本地上線版本
    // 2.更新版本
    function get_data_dir(){
        return dirname(__FILE__).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR;
    }
    function get_local_version($name){
        $version_filename =  get_data_dir().$name;
        $versionStr = @file_get_contents($version_filename);
        return $versionStr;
    }
    function write_local_version($name,$version){
        $version_filename =  get_data_dir().$name;
        $success = @file_put_contents($version_filename,$version);
        return $success;
    }
    // 鎖處理
    function set_lock ($name){
        $filename = get_data_dir().$name.".lock";
        $result = @file_put_contents($filename,1);
        if($result){
            return true;
        }else{
            return false;
        }
    }
    function clear_lock($name){
        $command = "rm -rf ".get_data_dir().$name.".lock";
        exec($command,$output,$result);
        if($result != 0){
            return false;
        }else{
            return true;
        }
    }
    function is_lock($name){
        $filename = get_data_dir().$name.".lock";
        return @file_exists($filename);
    }

    function need_update_templates(){
        $versionStr = get_local_version("pre_release_version");
        if($versionStr == MFE_TEMPLATES_RELEASE_VERSION_ID){
            return false;
        }else{
            return true;
        }
    }

    $updated_once = false;
    if(need_update_templates()){
        $update_once = true;
        if(is_lock("pre_release") or is_lock("release")){
            echo "模板更新中";
            die;
        }

        function get_pre_release_dir(){
            return get_data_dir().'pre_release'.DIRECTORY_SEPARATOR;
        }
        function get_channel_name(){
            $arr = explode("_",MFE_TEMPLATES_RELEASE_VERSION_ID);
            array_pop($arr);
            $channel = implode('_',$arr);
            return $channel;
        }
        function clear_exit(){
            clear_lock('pre_release');
            // 清理文件夾
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf templates_backup";
            $command .= "&& rm -rf pre_release";
            $command .= "&& rm -rf templates_merge";
            exec($command,$output,$result);
            if($result != 0){
                echo "清理失敗";
                die;
            }
            die;
        }
        // 更新模板
        function update_templates(){
            // 鎖定模板更新操作
            $result = set_lock('pre_release');
            if(!$result){
                echo "設置模板包鎖失敗";
                die;
            }
            // 創建所需要的目錄
            $command = "mkdir -p ".get_data_dir()."pre_release";
            $command .= "&& mkdir -p ".get_data_dir()."current";
            $command .= "&& mkdir -p ".get_data_dir()."current/templates";
            $command .= "&& mkdir -p ".get_data_dir()."current/cache";
            $command .= "&& mkdir -p ".get_data_dir()."current/templates_c";
            $command .= "&& chmod 777 ".get_data_dir()."current/cache";
            $command .= "&& chmod 777 ".get_data_dir()."current/templates_c";
            exec($command,$output,$result);
            if($result != 0){
                echo "模板包創建所需目錄失敗";
                clear_exit();
            }
            // 下載模板包:
            $tar_name = MFE_TEMPLATES_RELEASE_VERSION_ID.".tar.gz";
            // 模板包地址
            $templates_package_name = MFE_TEMPLATES_SERVER_ONLINE.'/pre_release/'.$tar_name;
            // 獲取模板md5,用於比較下載的文件是否完整
            $package_md5_url = MFE_TEMPLATES_SERVER_ONLINE.'/api/get_md5.php?name=pre_release/'.$tar_name;
            $package_md5 = @file_get_contents($package_md5_url);
            if(!$package_md5 or strlen($package_md5)!=32){
                echo "無法獲取模板md5校驗值";
                clear_exit();
            }
            // 下載模板包
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $templates_package_name);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            $destination = get_pre_release_dir().$tar_name;
            $file = @fopen($destination, "w");
            @fputs($file, $data);
            @fclose($file);
            if(!file_exists($destination)){
                echo "寫入模板包文件失敗";
                clear_exit();
            }
            // 更新文件權限
            $command = "chmod 777 ".realpath($destination);
            exec($command,$output,$result);
            if($result != 0){
                echo "修改模板包權限失敗";
                clear_exit();
            }
            // 校驗md5
            $package_downloaded_md5 = md5_file($destination);
            if($package_md5 != $package_downloaded_md5){
                echo "下載模板包錯誤";
                die;
            }
            // 解壓模板
            $command = "cd ".get_pre_release_dir();
            $command .= "&& tar -zxvf ".$tar_name;
            exec($command,$output,$result);
            if($result != 0){
                echo "解壓模板包失敗";
                clear_exit();
            }
            //創建新的模板文件目錄
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf templates_merge";
            $command .= "&& cp -rf current/templates templates_merge";
            exec($command,$output,$result);
            if($result != 0){
                echo "創建新模板目錄失敗";
                clear_exit();
            }
            // 復制解壓的模板文件到新的模板文件
            $command = "cd ".get_data_dir();
            $command .= "&& cp -rf pre_release/templates templates_merge/templates";
            exec($command,$output,$result);
            if($result != 0){
                echo "覆蓋模板文件失敗";
                echo $output;
                die;
                clear_exit();
            }
            // 使用新的模板文件
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf templates_backup";
            $command .= "&& mv current/templates templates_backup";
            $command .= "&& mv templates_merge current/templates";
            exec($command,$output,$result);
            if($result != 0){
                echo "更換新模板文件失敗";
                die;
            }

            //更新版本號
            $success = write_local_version("pre_release_version",MFE_TEMPLATES_RELEASE_VERSION_ID);
            if(!$success){
                echo "寫入模板版本失敗";
                die;
            }

            // 清理文件夾
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf templates_backup";
            $command .= "&& rm -rf pre_release";
            $command .= "&& rm -rf templates_merge";
            exec($command,$output,$result);
            if($result != 0){
                echo "更換新模板文件失敗";
                die;
            }

            $result = clear_lock('pre_release');
            if(!$result){
                echo "清除模板包鎖失敗";
                die;
            }
            // 通知服務器清除tar包
            $cleanup_url = MFE_TEMPLATES_SERVER_ONLINE.'/api/cleanup.php?name=pre_release/'.$tar_name;
            $result = @file_get_contents($cleanup_url);
        }
        update_templates();
    }

    // 自動更新:
    function get_local_release_version(){
        // 獲取當前release的版本
        $array = array();
        $path = realpath(get_data_dir())."/release/packages";
        if(!is_dir($path)){
            return 0;
        }
        $handle = opendir($path); //當前目錄
        while (false !== ($file = readdir($handle))) { //遍歷該php文件所在目錄
            @list($filename,$ext1,$ext2)=explode(".",$file);//獲取擴展名
            if($ext1=="tar" and $ext2 = "gz") { //文件過濾
                if (!is_dir('./'.$file)) { //文件夾過濾
                    if($pattern = '/^[0-9]\d*$/'){
                        preg_match($pattern, $filename, $matches);
                        $array[]= intval($filename);//把符合條件的文件名存入數組
                    }
                }
            }
        }
        if(!empty($array)){
            $pos = array_search(max($array), $array);
            $filename = $array[$pos];
        }else{
            $filename = 0;
        }
        return $filename;
    }
    function get_online_release_version(){
        $get_release_version_url = MFE_TEMPLATES_SERVER_ONLINE.'/api/get_release_version.php';
        $result = @file_get_contents($get_release_version_url);
        return intval($result);
    }
    function need_update_release(){
        // 更新版本
        $s = intval(date('s'));
        // 10秒鐘更新一次版本
        if(defined("DEBUG") and DEBUG){
            $delay = 1;
        }else{
            $delay = 10;
        }
        $timeout =  ($s % $delay) == 0;
        if($timeout){
            $v1 = get_local_release_version();
            $v2 = get_online_release_version();
            if( $v1 != $v2  && $v2 !=0){
                return true;
            }
            return false;
        }else{
            return false;
        }
    }
    if(need_update_release() && !$updated_once){

        if(is_lock("pre_release") or is_lock("release")){
            echo "模板更新中";
            die;
        }

        function get_release_dir(){
            return get_data_dir().'release'.DIRECTORY_SEPARATOR;
        }
        function get_channel_name(){
            echo "get_channel_name error";die;
            return $channel;
        }
        function clear_release_exit(){
            clear_lock('release');
            // 清理文件夾
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf templates_backup";
            $command .= "&& rm -rf release/tmp";
            exec($command,$output,$result);
            if($result != 0){
                echo "release:清理失敗";
                die;
            }
            die;
        }
        // 更新模板
        function update_templates(){
            // 鎖定模板更新操作
            $result = set_lock('release');
            if(!$result){
                echo "release:設置模板包鎖失敗";
                die;
            }
            // 創建所需要的目錄
            $command = "mkdir -p ".get_data_dir()."release";
            $command .= "&& mkdir -p ".get_data_dir()."release/packages";
            $command .= "&& chmod 777 ".get_data_dir()."release/packages";
            $command .= "&& mkdir -p ".get_data_dir()."release/tmp";
            $command .= "&& chmod 777 ".get_data_dir()."release/tmp";
            $command .= "&& mkdir -p ".get_data_dir()."current";
            $command .= "&& mkdir -p ".get_data_dir()."current/templates";
            $command .= "&& mkdir -p ".get_data_dir()."current/cache";
            $command .= "&& chmod 777 ".get_data_dir()."current/cache";
            $command .= "&& mkdir -p ".get_data_dir()."current/templates_c";
            $command .= "&& chmod 777 ".get_data_dir()."current/templates_c";
            exec($command,$output,$result);
            if($result != 0){
                echo "release:模板包創建所需目錄失敗";
                clear_release_exit();
            }
            // 下載模板包:
            /* $version_number = get_local_release_version() + 1; */
            $version_number = get_online_release_version();
            $tar_name = $version_number.".tar.gz";
            // 模板包地址
            $templates_package_name = MFE_TEMPLATES_SERVER_ONLINE.'/release/'.$tar_name;
            // 獲取模板md5,用於比較下載的文件是否完整
            $package_md5_url = MFE_TEMPLATES_SERVER_ONLINE.'/api/get_md5.php?name=release/'.$tar_name;
            $package_md5 = @file_get_contents($package_md5_url);
            if(!$package_md5 or strlen($package_md5)!=32){
                echo "release:無法獲取模板md5校驗值";
                clear_release_exit();
            }
            // 下載模板包
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $templates_package_name);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);
            $destination = get_release_dir()."packages/".$tar_name;
            $file = @fopen($destination, "w");
            @fputs($file, $data);
            @fclose($file);
            if(!file_exists($destination)){
                echo "release:寫入模板包文件失敗";
                clear_release_exit();
            }
            // 更新文件權限
            $command = "chmod 777 ".realpath($destination);
            exec($command,$output,$result);
            if($result != 0){
                echo "release:修改模板包權限失敗";
                clear_release_exit();
            }
            // 校驗md5
            $package_downloaded_md5 = md5_file($destination);
            if($package_md5 != $package_downloaded_md5){
                echo "release:下載模板包錯誤";
                die;
            }
            // 解壓模板
            $command = "cd ".get_release_dir();
            $command .= "&& mv packages/".$tar_name." tmp/".$tar_name;
            $command .= "&& cd tmp";
            $command .= "&& tar -zxvf ".$tar_name;
            $command .= "&& cd ..";
            $command .= "&& mv tmp/".$tar_name." packages/".$tar_name;
            exec($command,$output,$result);
            if($result != 0){
                echo "release:解壓模板包失敗";
                clear_release_exit();
            }
            //創建新的模板文件目錄
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf release/tmp/templates_merge";
            $command .= "&& cp -rf current/templates release/tmp/templates_merge";
            exec($command,$output,$result);
            if($result != 0){
                echo "release:創建新模板目錄失敗";
                clear_release_exit();
            }
            // 復制解壓的模板文件到新的模板文件
            $command = "cd ".get_data_dir();
            $command .= "&& cp -rf release/tmp/templates release/tmp/templates_merge/templates";
            exec($command,$output,$result);
            if($result != 0){
                echo "release:覆蓋模板文件失敗";
                clear_release_exit();
            }
            // 使用新的模板文件
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf templates_backup";
            $command .= "&& mv current/templates templates_backup";
            $command .= "&& mv release/tmp/templates_merge current/templates";
            exec($command,$output,$result);
            if($result != 0){
                echo "release:更換新模板文件失敗";
                die;
            }
            //更新版本號
            $success = write_local_version("release_version",$version_number);
            if(!$success){
                echo "release:寫入模板版本失敗";
                die;
            }
            // 清理文件夾
            $command = "cd ".get_data_dir();
            $command .= "&& rm -rf templates_backup";
            $command .= "&& rm -rf release/tmp";
            exec($command,$output,$result);
            if($result != 0){
                echo "release:更換新模板文件失敗";
                die;
            }
            // 清除lock
            $result = clear_lock('release');
            if(!$result){
                echo "release:清除模板包鎖失敗";
                die;
            }
            if($version_number < get_online_release_version()){
                echo "[".$version_number ."]系統升級中...請稍等<script>setTimeout(function(){window.location.reload()},2000);</script>";
                die;
            }
        }
        update_templates();
    }
}

/*
 * 讀取模板文件時間
 */
function mfe_net_file_exists($file){
    $filename = str_replace(MFE_TEMPLATES_CHANNEL_PATH."/",'',$file);
    $filename = "channel/".MFE_TEMPLATES_CHANNEL."/templates/v4/".$filename;
    $url = MFE_TEMPLATES_API."/filetime.php?name=".$filename;
    $time = file_get_contents($url);
    if(!$time){
        echo "找不到模板:".$filename;
        die;
    }
    return $time;
}

defined("MFE_SMART_DEBUG") || define("MFE_SMART_DEBUG",0);
defined("MFE_BASE_PATH") || define('MFE_BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);



require_once (MFE_BASE_PATH."smarty".DIRECTORY_SEPARATOR."Smarty.class.php");
$smarty = new Smarty();
$smarty->setLeftDelimiter("{");
$smarty->setRightDelimiter("}");
$smarty->setConfigDir(MFE_BASE_PATH."config");
$smarty->addPluginsDir(MFE_BASE_PATH."plugin");


if(is_mfe_debug()){
    $smarty->setTemplateDir(MFE_TEMPLATES_CHANNEL_PATH);
    if(!is_dir(MFE_BASE_PATH."data/debug/cache") or !is_dir(MFE_BASE_PATH."data/debug/templates_c") ){
        $command = "mkdir -p ".MFE_BASE_PATH."data/debug/cache";
        $command .= "&& mkdir -p ".MFE_BASE_PATH."data/debug/templates_c";
        $command .= "&& chmod 777 ".MFE_BASE_PATH."data/debug/cache";
        $command .= "&& chmod 777 ".MFE_BASE_PATH."data/debug/templates_c";
        exec($command,$output,$result);
        if($result != 0){
            echo "清理失敗";
            die;
        }
    }
    $smarty->setCacheDir(MFE_BASE_PATH."data/debug/cache");
    $smarty->setCompileDir(MFE_BASE_PATH."data/debug/templates_c");
}
else{
    defined("MFE_SMARTY_TEMPLATES") || define('MFE_SMARTY_TEMPLATES', MFE_BASE_PATH."data/current/templates".DIRECTORY_SEPARATOR. "templates".DIRECTORY_SEPARATOR. "v4".DIRECTORY_SEPARATOR);
    $smarty->setTemplateDir(MFE_SMARTY_TEMPLATES);
    $smarty->setCacheDir(MFE_BASE_PATH."data/current/cache");
    $smarty->setCompileDir(MFE_BASE_PATH."data/current/templates_c");
}

$smarty->addConfigDir(MFE_SMARTY_TEMPLATES."fis_config");
defined('SMARTY_PHP_ALLOW') or define('SMARTY_PHP_ALLOW',true);
$smarty->php_handling = SMARTY_PHP_ALLOW ;

if(is_mfe_debug()){
    $smarty->debugging_ctrl = 'URL'; // 調試模式開啟 url調試
    $smarty->caching = false;        // 調試模式停用緩存
}

function test_data($params,&$smarty) {
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
$smarty->registerPlugin('function','test_data', "test_data");
