<?php
/**
 *  專區模版文件發布程序
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class push_partition  extends admin {
 	private $db, $pos_data; //數據調用屬性
 	
	public function __construct() {
		$this->db = pc_base::load_model('partition_model');
	}

	//發布
	public function init($catid){ 
		$partition_array = $this->db->get_one(array("catid"=>$catid));
		$source = PHPCMS_PATH.'statics/s_test';
		$target = PHPCMS_PATH.'statics/s';
		$module = 'partition'.DIRECTORY_SEPARATOR.$partition_array['domain_dir'];
		$prefix = 's'; 
	    $this->convert_templates($source,$target,$module,$prefix);
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
	public function process_file($filename,$source,$target,$module,$prefix){
	    $content = file_get_contents($filename);
	    $base_path = "http://sts0.mofang.com/statics/".$prefix."/".$module;

	    preg_match_all('/((\.\.|\.)\/(img|css|js|images|image)\/.*\.(js|css|jpg|png|gif|swf|htc))/i',$content,$matches);
	    $files = $matches[1];
	    foreach ($files as $file) {
	        $s_file = str_replace(array("../","./"),"",$file);
	        $resource_filename = $source."/".$module."/".$s_file;
	        if(!file_exists($resource_filename)){
	            continue;
	        }
	        $md5_code = $this->get_md5_code($resource_filename);

            $pos_num = strripos($s_file,'.');
            $ext = substr($s_file, $pos_num);//取出文件 後綴
            $first = substr($s_file, 0,$pos_num);//取出文件 後綴
	        // list($name,$ext) = split("\.",$s_file);
	        $s = $base_path."/".$first."_".$md5_code.$ext;
	        $content = str_replace(array($file),$s,$content);
	    }
	    file_put_contents($filename,$content);
	}
	public function get_md5_code($source_file){
	    $md5str = md5_file($source_file)."";
	    return substr($md5str,0,8);
	}
	public function convert_templates($source,$target,$module,$prefix){
	    $list = $this->traverse($source."/".$module);
	    $process_ext = ['js','css','tpl'];
	    foreach ($list as $file) {
	        preg_match('/(.*)\.(.*)/',$file,$matches);
	        $file_name = $matches[1];
	        $file_ext = $matches[2];
	        if(!$file_name || !$file_ext){
	            continue;
	        }
	        // 移動文件
	        $source_file = $source."/".$module."/".$file_name.".".$file_ext;
	        $md5_code = $this->get_md5_code($source_file);
	        if($file_ext=="tpl"){
	            $target_file = $target."/".$module."/".$file_name.".".$file_ext;
	        }else{
	            $target_file = $target."/".$module."/".$file_name."_".$md5_code.".".$file_ext;
	        }

	        $target_path = dirname($target_file);
	        if (!is_dir($path)){
	            mkdir($target_path,0777,true);
	        }
	        $res=copy($source_file,$target_file);
	        chmod($target_file,0777);
	        if(in_array($file_ext,$process_ext)){
	            $this->process_file($target_file,$source,$target,$module,$prefix);
	        }
	    }
	}
	 
}
 ?>