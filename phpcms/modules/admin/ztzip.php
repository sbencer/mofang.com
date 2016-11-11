<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
set_time_limit(0);
class ztzip extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('linkage_model');
		$this->sites = pc_base::load_app_class('sites');
		$this->admin_member = pc_base::load_model('admin_model');
		$this->ziplog = pc_base::load_model('ziplog_model');
		$this->filepath =  PHPCMS_PATH."ztnew".DIRECTORY_SEPARATOR;
		pc_base::load_sys_class('form', '', 0);
		$this->childnode = array();
	}
	
	/**
	 * 聯動菜單列表
	 */
	public function init() {
		$where = array('keyid'=>0);
		$infos = $this->db->select($where);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=linkage&a=add\', title:\''.L('linkage_add').'\', width:\'500\', height:\'220\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('linkage_add'));
		include $this->admin_tpl('linkage_list');
	}
	/**
	 *顯示上傳記錄
	 * 
	 */
	public function show_rec(){
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1; 
		$infos = $this->ziplog->listinfo("",$order = 'inputtime DESC',$page, $pages = '20'); 
 		$pages = $this->ziplog->pages;
		include $this->admin_tpl('zt_show_rec');
		}

	
		
	/**
	 *上傳壓縮包
	 * 
	 */
	 public function zt_upload(){
		$uid = param::get_cookie('userid');
		$userinfo = $this->admin_member->get_one(array("userid"=>$uid));
		$zt_name = $_REQUEST['zt_name'];
		if(isset($_POST['dosubmit'])){
				//增加同一專區下多個專題的上傳
				$zt_name = $_POST['zt_name'];
				$msg ="";
				$msg = "用戶名<span style='color:green'>".$userinfo['username']."</span>";
				
				$log['username']=$userinfo['username'];
				$log['userid']=$userinfo['userid'];
				$log['zip_file'] = $_FILES['file_upload']['name'];
				
				$nowfile = dirname(__FILE__).DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR;	//加載文件路徑
				//$propath = "e:".DIRECTORY_SEPARATOR."ect"; //文件存放路徑
				$propath = dirname(dirname(dirname(dirname(__FILE__)))).DIRECTORY_SEPARATOR."ztnew".DIRECTORY_SEPARATOR.$zt_name;				//文件存放路徑
				$uf_file = dirname(__FILE__).DIRECTORY_SEPARATOR."source"; //zip上傳路徑
				if(empty($_FILES['file_upload']['name'])){
					showmessage('請上傳文檔！', HTTP_REFERER);//1上傳是否為空
				}else{
					//2確定名字
					$name = pathinfo($_FILES['file_upload']['name']);
					if(!empty($_POST['zt_new_name']) && !$_POST['zt_ren']){
						$filename = trim($_POST['zt_new_name']).".".trim($name['extension']);
					}elseif($_POST['zt_ren']){
						$filename = trim($_FILES['file_upload']['name']);				
					}else{
						showmessage(L('filename_notempty'), HTTP_REFERER);
					}
					//3查看路徑
					$new_name = $name['filename'];

					if(is_dir($uf_file.DIRECTORY_SEPARATOR.$new_name)){
					//如果目錄存在就查看是否覆蓋或者重新命名
						if($_POST['zt_ren']){ //覆蓋刪除並創建目錄
							$log['type']=1;
							echo "覆蓋路線";
							if($this->deldir($uf_file.DIRECTORY_SEPARATOR.$new_name)){//刪除掉已有名字的目錄
								$this->deldir($propath.DIRECTORY_SEPARATOR.$new_name);
								
								$mk_rs = mkdir($uf_file.DIRECTORY_SEPARATOR.$new_name,777);//創建目錄
								chmod($uf_file.DIRECTORY_SEPARATOR.$new_name,0777);
								if($mk_rs){
									$cp = $this->user_UpFiles($uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR,"file_upload",204800,'zip',$name['basename']);//上傳到服務器									
									if(!empty($cp)){
										$ztmsg = $msg.",上傳專題包<span style='color:green'>".$cp."</span>,文件大小<span style='color:green'>".$_FILES['file_upload']['size']."字節</span>";
										$ztmsg.=",壓縮包選擇覆蓋替換";
									}
									require_once($nowfile.'pclzip.lib.php');
									//echo $uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR.$name['basename'];
									$archive = new PclZip($uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR.$name['basename']);
									
										if ($archive->extract(PCLZIP_OPT_PATH, $uf_file.DIRECTORY_SEPARATOR.$new_name,PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
											die("Error : ".$archive->errorInfo(true));
											$ztmsg.=",解壓<span style='color:red'>有問題</span>";
										}else{
											$ztmsg.=",解壓<span style='color:red'>成功</span>";
										}
											$unlink_zip = unlink($uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR.$new_name.".zip");
											if($unlink_zip){
												$ztmsg.=",原壓縮包已經刪除 ";
											}
											$cp_rs = $this->recurse_copy($uf_file.DIRECTORY_SEPARATOR.$new_name,$propath.DIRECTORY_SEPARATOR.$new_name);
											if($cp_rs){
												$log['inputtime']=time();

												/** 復制到正式的專題目錄下(zt_new)  - 王官慶添加  **/
												$push_zt = pc_base::load_app_class('push_zt','admin',1);
												$return = $push_zt->init($zt_name,$new_name); 

												if($this->ziplog->insert($log)){
													$ztmsg.=",拷貝成功";
													showmessage($ztmsg, HTTP_REFERER,5000);
												};
												
											}else{
												$ztmsg.=",拷貝失敗";
												showmessage($ztmsg, HTTP_REFERER);
											}
			
								}
								
							}else{
								echo "刪除失敗,文件夾權限不夠";
							}
						}else{//重命名目錄
							$log['type']=0;
							echo "重命名路線";
							$new_p = pathinfo($filename);
							if(is_dir($uf_file.DIRECTORY_SEPARATOR.$new_p['filename'])){//新名字已存在返回
								showmessage("zip名稱重復,請在重命名", HTTP_REFERER);
							}else{//可以創建新目錄
								$mk_rs = mkdir($uf_file.DIRECTORY_SEPARATOR.$new_p['filename'],0777);//創建目錄
								chmod($uf_file.DIRECTORY_SEPARATOR.$new_name,0777);
								if($mk_rs){
									$cp = $this->user_UpFiles($uf_file.DIRECTORY_SEPARATOR.$new_p['filename'].DIRECTORY_SEPARATOR,"file_upload",204800,'zip',$new_p['basename']);//上傳到服務器									
									if(!empty($cp)){
										$ztmsg = $msg.",上傳專題包原名字".$_FILES['file_upload']['name'].",新名字<span style='color:green'>".$cp."</span>,文件大小<span style='color:green'>".$_FILES['file_upload']['size']."字節</span>";
										$ztmsg.=",壓縮包選擇新名字替換";
										$log['new_file_name']=$cp;
									}
									require_once($nowfile.'pclzip.lib.php');
									//echo $uf_file.DIRECTORY_SEPARATOR.$new_p['filename'].DIRECTORY_SEPARATOR.$name['basename'];
									$archive = new PclZip($uf_file.DIRECTORY_SEPARATOR.$new_p['filename'].DIRECTORY_SEPARATOR.$new_p['basename']);
									
										if ($archive->extract(PCLZIP_OPT_PATH, $uf_file.DIRECTORY_SEPARATOR.$new_p['filename'],PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
											die("Error : ".$archive->errorInfo(true));
											$ztmsg.=",解壓<span style='color:red'>有問題</span>";
										}else{
											$ztmsg.=",解壓<span style='color:red'>成功</span>";
										}
										$unlink_zip = unlink($uf_file.DIRECTORY_SEPARATOR.$new_p['filename'].DIRECTORY_SEPARATOR.$new_p['filename'].".zip");
											if($unlink_zip){
												$ztmsg.=",原壓縮包已經刪除 ";
											}
										$cp_rs = $this->recurse_copy($uf_file.DIRECTORY_SEPARATOR.$new_p['filename'],$propath.DIRECTORY_SEPARATOR.$new_p['filename']);
											if($cp_rs){
												$log['inputtime']=time();
												
												/** 復制到正式的專題目錄下(zt_new)  - 王官慶10.9  **/
												$push_zt = pc_base::load_app_class('push_zt','admin',1);
												$return = $push_zt->init($zt_name,$new_name); 

												if($this->ziplog->insert($log)){
													$ztmsg.=",拷貝成功";
													
												};
												
											}else{
												$ztmsg.=",拷貝失敗";
												showmessage($ztmsg, HTTP_REFERER);
											}
								}
							}
							
						}
					}else{
					
						$log['type']=3;
						
						echo "正常路線";

						$mk_rs = mkdir($uf_file.DIRECTORY_SEPARATOR.$new_name,0777);//創建目錄
						chmod($uf_file.DIRECTORY_SEPARATOR.$new_name,0777);
						if($mk_rs){
							$cp = $this->user_UpFiles($uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR,"file_upload",204800,'zip',$name['basename']);//上傳到服務器									
							if(!empty($cp)){
								$ztmsg = $msg.",上傳專題包<span style='color:green'>".$cp."</span>,文件大小<span style='color:green'>".$_FILES['file_upload']['size']."字節</span>";
								$ztmsg.=",直接按名字覆蓋替換";
							}
							require_once($nowfile.'pclzip.lib.php');
							//echo $uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR.$name['basename'];
							$archive = new PclZip($uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR.$name['basename']);
							
								if ($archive->extract(PCLZIP_OPT_PATH, $uf_file.DIRECTORY_SEPARATOR.$new_name,PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
									die("Error : ".$archive->errorInfo(true));
									$ztmsg.=",解壓<span style='color:red'>有問題</span>";
								}else{
									$ztmsg.=",解壓<span style='color:red'>成功</span>";
								}
									$unlink_zip = unlink($uf_file.DIRECTORY_SEPARATOR.$new_name.DIRECTORY_SEPARATOR.$new_name.".zip");
											if($unlink_zip){
												$ztmsg.=",原壓縮包已經刪除 ";
											}
									$cp_rs = $this->recurse_copy($uf_file.DIRECTORY_SEPARATOR.$new_name,$propath.DIRECTORY_SEPARATOR.$new_name);
								
									if($cp_rs){
										$log['inputtime']=time();
										
										/** 復制到正式的專題目錄下(zt_new)  - 王官慶添加  **/
										$push_zt = pc_base::load_app_class('push_zt','admin',1);
										$return = $push_zt->init($zt_name,$new_name); 

										if($this->ziplog->insert($log)){
											$ztmsg.=",拷貝成功";
											showmessage($ztmsg, '', '30000', 'import');
											// showmessage($ztmsg,HTTP_REFERER,5000);
										};
										
									}else{
										$ztmsg.=",拷貝失敗";
										showmessage($ztmsg, HTTP_REFERER);
									}
						}
					}
					
					
					
					if($name['extension'] != 'zip'){
						showmessage(L('must_zip'), HTTP_REFERER);
					}
				}
		}else{
			
			include $this->admin_tpl('zt_upload');
		}
	}
	/**
	 *覆蓋清除目錄
	 * @param $path 指定路徑
	 * @return bool true/false
	 */
	protected function deldir($path){
		if(!is_dir($path)){
			return false;
		}	
		$fh = opendir($path);
		while(($row = readdir($fh)) !== false){
		//過濾 . ..
			if($row == "." || $row == ".."){
				continue;
			}
			if(!is_dir($path.DIRECTORY_SEPARATOR.$row)){
				unlink($path.DIRECTORY_SEPARATOR.$row);
			}
			$this->deldir("".$path.DIRECTORY_SEPARATOR.$row);
		}
		closedir($fh);
		if(!rmdir($path)){
			showmessage(L('dir_no_permissions'), HTTP_REFERER);
		}
		return true;	
	}
	/**
	 *上傳函數
	 * @param $path 指定路徑
	 * @return bool true/false
	 */
	protected function user_UpFiles($dir, $file_var, $max_size='', $type='', $name=false){
	$upfile=& $_FILES["$file_var"]; 
	$upfilename =  $upfile['name']; 
	if(!empty($upfilename)){
		if(!is_uploaded_file($upfile['tmp_name'])) { 
			showmessage('上傳失敗：你選擇的文件無法上傳', HTTP_REFERER);
			exit(); 
		}elseif($max_size>0 && $upfile['size']/1024>$max_size){ 
			showmessage("上傳失敗：文件大小不能超過  ".$max_size."KB", HTTP_REFERER);
			exit(); 
		}
		$ext_name = strtolower(str_replace(".","",strrchr($upfilename, ".")));
		if(!empty($type)){
			$arr_type=explode('/',$type);
			$arr_type=array_map("strtolower",$arr_type);
			if (!in_array($ext_name,$arr_type)){
				showmessage("上傳失敗：只允許上傳 ".$type." 的文件！", HTTP_REFERER);
				exit(); 
			}
			
		}

		if(!is_bool($name)){
			$uploadname=$name;
		}elseif ($name==true){
			$uploadname=time().mt_rand(100,999).".".$ext_name;
		}		
		if(!move_uploaded_file($upfile['tmp_name'], $dir.$uploadname)) { 
			
			//showmessage('上傳失敗：文件上傳出錯！', HTTP_REFERER);
			exit(); 
		} 

		return $uploadname; 
	}
	}
	
	protected function recurse_copy($src,$dst) { 
    $dir = opendir($src); 
	if(!$dir){
		return false;
	}
    if(!mkdir($dst,0777)){
		return false;
	}
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
	return true;
	}

	//專題名稱列表（存一個專區多個專題的問題）
	public function zt_list(){
		$source_url =  PHPCMS_PATH."ztnew";
		$dir_list = array();
		$dir_list = scandir($source_url);
		$list = glob($source_url.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);
		foreach ($list as $key=>$v) {
			$dirname = basename($v);
			if ($siteid && !in_array($dirname, $template)) continue;
			if (file_exists($v.DIRECTORY_SEPARATOR.'config.php')) {
				$arr[$key] = include $v.DIRECTORY_SEPARATOR.'config.php';
				if (!$disable && isset($arr[$key]['disable']) && $arr[$key]['disable'] == 1) {
					unset($arr[$key]);
					continue;
				}
			} else {
				$arr[$key]['name'] = $dirname;
			}
			$arr[$key]['dirname']=$dirname;
		}
		$list = $arr;
		// $big_menu = array('javascript:window.top.art.dialog({id:\'import\',iframe:\'?m=admin&c=ztzip&a=add_zt\', title:\'添加專區模版\', width:\'500\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'import\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'import\'}).close()});void(0);', '增加新的專區');
		include $this->admin_tpl('style_list','');

	}

	//更新各專區中文標識名
	public function updatename(){
		$name = isset($_POST['name']) ? $_POST['name'] : showmessage(L('illegal_operation'), HTTP_REFERER);
		if (is_array($name)) {
			foreach ($name as $key=>$val) {
				$filepath = $this->filepath.$key.DIRECTORY_SEPARATOR.'config.php';
				if (file_exists($filepath)) {
					$arr = include $filepath;
					$arr['name'] = $val;
				} else {
					$arr = array('name'=>$val,'disable'=>0, 'dirname'=>$key);
				}
				@file_put_contents($filepath, '<?php return '.var_export($arr, true).';?>');
			}
			showmessage(L('operation_success'), HTTP_REFERER);
		} else {
			showmessage(L('illegal_parameters'), HTTP_REFERER);
		}
	}

	//所選擇專區下所有的專題文件夾列表
	public function list_init(){
		$zt_name  = $_GET['zt_name'];
		if(!$zt_name){
			showmessage('請選擇所在的專區', HTTP_REFERER);
		}
	}

	//創建專區目錄
	public function add_zt_name(){
		if(isset($_POST['dosubmit_add_ztname'])){
			$zt_name = $_POST['zt_name'];
			//判斷目錄是否存在，存在剛不允許再次創建
			
			if(is_dir($this->filepath.$zt_name)){
				showmessage('該專區目錄文件夾已經存在！請勿重復創建！正在返回..... ', HTTP_REFERER);
			}
			$mk_rs = mkdir($this->filepath.$zt_name,777);//創建目錄
			chmod($this->filepath.$zt_name,0777);
			if($mk_rs){
				showmessage('創建成功！正在返回..... ', HTTP_REFERER);
			}else{
				showmessage('創建失敗！正在返回..... ', HTTP_REFERER);
			}
		}
	}


	
/* 	protected function action_zip($path,$filename){
		$mk_rs = mkdir($path,777);//創建目錄
		if($mk_rs){
		$cp = $this->user_UpFiles($path.DIRECTORY_SEPARATOR,"file_upload",204800,'zip',$filename);//上傳到服務器									
		if(!empty($cp)){
		$ztmsg = $msg.",上傳專題包<span style='color:green'>".$cp."</span>,文件大小<span style='color:green'>".$_FILES['file_upload']['size']."字節</span>";
		$ztmsg.=",壓縮包選擇新名字替換";
		}
		require_once($nowfile.'pclzip.lib.php');
		//$uf_file.DIRECTORY_SEPARATOR.$new_p['filename'].DIRECTORY_SEPARATOR.$new_p['basename']
		$archive = new PclZip($path.DIRECTORY_SEPARATOR.$filename);

		if ($archive->extract(PCLZIP_OPT_PATH, $uf_file.DIRECTORY_SEPARATOR.$new_p['filename'],PCLZIP_OPT_REMOVE_PATH, 'install/release') == 0) {
		die("Error : ".$archive->errorInfo(true));
		$ztmsg.=",解壓<span style='color:red'>有問題</span>";
		}else{
		$ztmsg.=",解壓<span style='color:red'>成功</span>";
		}
		echo $ztmsg;
		}
	} */
}
?>