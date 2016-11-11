<?php
/**
 *  專區專題文件發布程序，同步到七牛雲 
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class push_zt  extends admin {
 	private $db, $pos_data; //數據調用屬性
 	
	public function __construct() {
		// $this->db = pc_base::load_model('partition_model');
	}

	//發布
	public function init($zt_name,$new_name){
		$source = PHPCMS_PATH.'ztnew'.DIRECTORY_SEPARATOR.$zt_name;//源臨時目錄
		$target = PHPCMS_PATH.'zt_new'.DIRECTORY_SEPARATOR.$zt_name;//專題正式目錄
		$module = 'event'.DIRECTORY_SEPARATOR.$new_name;
		$prefix = 's'; 
	    $this->convert_templates($source,$target,$zt_name,$new_name,$prefix);
	    return 1;
	}

	public function traverse($path = '.',$base_path="") {
	    $current_dir = opendir($path);
	    $arr = array();
	    while(($file = readdir($current_dir)) !== false) {
	        $sub_dir = $path . DIRECTORY_SEPARATOR . $file;
	        if($file == '.' || $file == '..') {
	            continue;
	        } else if(is_dir($sub_dir)) {
	            $sub_arr = $this->traverse($sub_dir,$file);
	            $arr = array_merge($arr,$sub_arr);
	        } else {
	            if($base_path){
	                $arr[] = $base_path."/".$file;
	            }else{
	                $arr[] = $file;
	            }
	        }
	    }
	    return $arr;
	}

	/*
	 * <img src="../img/xxx.jpg"/>
	 * <script src="../js/index.js"></script>
	 * <link href="../css/index.js"></script>
	 * background-image:url(../img/xx.jpg);
	 */
	//對文件內部的圖片，CSS，JS進行七牛地址的處理  
	//$filename :　待處理的文件地址　　
	public function process_file($filename,$source,$target,$zt_name,$new_name,$prefix){
	    $content = file_get_contents($filename);
	    $base_path = "http://sts0.mofang.com/zt_new/".$zt_name.'/'.$new_name.'/';

	    preg_match_all('/((\.\.|\.)\/(img|css|js|images)\/.*\.(js|css|jpg|png|gif|swf|htc))/i',$content,$matches);
	    $files = $matches[1];
	    foreach ($files as $file) {
	        $s_file = str_replace(array("../","./"),"",$file);
	        $resource_filename = $source."/".$new_name.'/'.$s_file;
	        if(!file_exists($resource_filename)){
	            continue;
	        }
	        $md5_code = $this->get_md5_code($resource_filename);

            $pos_num = strripos($s_file,'.');
            $ext = substr($s_file, $pos_num);//取出文件 後綴
            $first = substr($s_file, 0,$pos_num);//取出文件名
	        // list($name,$ext) = split("\.",$s_file);
	        $s = $base_path.$first."_".$md5_code.$ext;
	        $content = str_replace(array($file),$s,$content);
	    }
	    file_put_contents($filename,$content);
	}
	public function get_md5_code($source_file){
	    $md5str = md5_file($source_file);
	    return substr($md5str,0,8);
	}
	
	//zt_name :  當前專題的英文名  $new_name：當前專題的英文文件夾名 
	public function convert_templates($source,$target,$zt_name,$new_name,$prefix){
	    $list = $this->traverse($source."/".$new_name);//獲取專題源目錄地址
	    // $process_ext = ['js','css','tpl','html','htm']; PHP有些版本不支持 
	    $process_ext = array('js','css','tpl','html','htm');
	    foreach ($list as $file) {//獲取目錄下的文件
	        preg_match('/(.*)\.(.*)/',$file,$matches);
	        $file_name = $matches[1];
	        $file_ext = $matches[2];
	        if(!$file_name || !$file_ext){
	            continue;
	        }
	        // 移動文件
	        $source_file = $source."/".$new_name."/".$file_name.".".$file_ext;
	        if(!file_exists($source_file)){
	        	echo $file;exit;
	        }
	        $md5_code = $this->get_md5_code($source_file);
	        if($file_ext=="tpl" || $file_ext=="html" || $file_ext=="htm"){//頁面模版保持原有名稱 
	            $target_file = $target."/".$new_name."/".$file_name.".".$file_ext;
	        }else{//靜態資源生成新的文件名，供七牛來抓數據 
	            $target_file = $target."/".$new_name."/".$file_name."_".$md5_code.".".$file_ext;
	        }
	        //創建目錄文件夾
	        $target_path = dirname($target_file);
	        if (!is_dir($target_path)){
	            mkdir($target_path,0777,true);
	        }
	        //復制對應的文件 
	        $res=copy($source_file,$target_file);
	        chmod($target_file,0777);
	        if(in_array($file_ext,$process_ext)){//對js,css,html,tpl,htm格式的文件內部的路徑進行處理 
	            $this->process_file($target_file,$source,$target,$zt_name,$new_name,$prefix);
	        }
	    }
	}
	 
}
 ?>