<?php 
class attachment {
	var $contentid;
	var $module;
	var $catid;
	var $attachments;
	var $field;
	var $imageexts = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
	var $uploadedfiles = array();
	var $downloadedfiles = array();
	var $error;
	var $upload_root;
	var $siteid;
	var $site = array();
	
	function __construct($module='', $catid = 0,$siteid = 0,$upload_dir = '') {
		$this->catid = intval($catid);
		$this->siteid = intval($siteid)== 0 ? 1 : intval($siteid);
		$this->module = $module ? $module : 'content';
		pc_base::load_sys_func('dir');		
		pc_base::load_sys_class('image','','0');
		$this->upload_root = pc_base::load_config('system','upload_path');
		$this->upload_func = 'copy';
		$this->upload_dir = $upload_dir;
	}
	/**
	 * 附件上傳方法
	 * @param $field 上傳字段
	 * @param $alowexts 允許上傳類型
	 * @param $maxsize 最大上傳大小
	 * @param $overwrite 是否覆蓋原有文件
	 * @param $thumb_setting 縮略圖設置
	 * @param $watermark_enable  是否添加水印
	 */
	function upload($field, $alowexts = '', $maxsize = 0, $overwrite = 0,$thumb_setting = array(), $watermark_enable = 1) {
		if(!isset($_FILES[$field])) {
			$this->error = UPLOAD_ERR_OK;
			return false;
		}
		if(empty($alowexts) || $alowexts == '') {
			$site_setting = $this->_get_site_setting($this->siteid);
			$alowexts = $site_setting['upload_allowext'];
		}
		$fn = $_GET['CKEditorFuncNum'] ? $_GET['CKEditorFuncNum'] : '1';
			
		$this->field = $field;
		$this->savepath = $this->upload_root.$this->upload_dir.date('Y/md/');
		$this->alowexts = $alowexts;
		$this->maxsize = $maxsize;
		$this->overwrite = $overwrite;
		$uploadfiles = array();
		$description = isset($GLOBALS[$field.'_description']) ? $GLOBALS[$field.'_description'] : array();
		if(is_array($_FILES[$field]['error'])) {
			$this->uploads = count($_FILES[$field]['error']);
			foreach($_FILES[$field]['error'] as $key => $error) {
				if($error === UPLOAD_ERR_NO_FILE) continue;
				if($error !== UPLOAD_ERR_OK) {
					$this->error = $error;
					return false;
				}
				$uploadfiles[$key] = array('tmp_name' => $_FILES[$field]['tmp_name'][$key], 'name' => $_FILES[$field]['name'][$key], 'type' => $_FILES[$field]['type'][$key], 'size' => $_FILES[$field]['size'][$key], 'error' => $_FILES[$field]['error'][$key], 'description'=>$description[$key],'fn'=>$fn);
			}
		} else {
			$this->uploads = 1;
			if(!$description) $description = '';
			$uploadfiles[0] = array('tmp_name' => $_FILES[$field]['tmp_name'], 'name' => $_FILES[$field]['name'], 'type' => $_FILES[$field]['type'], 'size' => $_FILES[$field]['size'], 'error' => $_FILES[$field]['error'], 'description'=>$description,'fn'=>$fn);
		}

		if(!dir_create($this->savepath)) {
			$this->error = '8';
			return false;
		}
		if(!is_dir($this->savepath)) {
			$this->error = '8';
			return false;
		}
		@chmod($this->savepath, 0777);

		if(!is_writeable($this->savepath)) {
			$this->error = '9';
			return false;
		}
		if(!$this->is_allow_upload()) {
			$this->error = '13';
			return false;
		}
		$aids = array();
		foreach($uploadfiles as $k=>$file) {
			$fileext = fileext($file['name']);
			if($file['error'] != 0) {
				$this->error = $file['error'];
				return false;				
			}
			if(!preg_match("/^(".$this->alowexts.")$/", $fileext)) {
				$this->error = '10';
				return false;
			}
			if($this->maxsize && $file['size'] > $this->maxsize) {
				$this->error = '11';
				return false;
			}
			if(!$this->isuploadedfile($file['tmp_name'])) {
				$this->error = '12';
				return false;
			}
			$temp_filename = $this->getname($fileext);
			$savefile = $this->savepath.$temp_filename;
			$savefile = preg_replace("/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i", "_\\1\\2", $savefile);
            $filepath = preg_replace(new_addslashes("|^".$this->upload_root."|"), "", $savefile);

            //又拍雲設置
            //$upyun_info = pc_base::load_config('upyun');
            //pc_base::load_sys_class('upyun','',0);
            //$upyun = new UpYun($upyun_info['bucketname'], $upyun_info['username'], $upyun_info['password']);
            //$file_datas = file_get_contents($file['tmp_name']);

            //try {
            //    if($upyun->writeFile('/'.$filepath,$file_datas, true)){
            //        $this->uploadeds++;
            //        @unlink($file['tmp_name']);
            //        $uploadedfile = array('filename'=>$file['name'], 'filepath'=>$upyun_info['url'].$filepath, 'filesize'=>$file['size'], 'fileext'=>$fileext, 'fn'=>$file['fn']);
            //        //沒有設置縮略圖,又拍雲有自帶的
            //        $aids[] = $this->add($uploadedfile);
            //    }
            //} catch ( Exception $e ) {
            //    var_dump($_FILES);
            //    var_dump($e->getMessage());
            //    return false;
            //}

            //七牛雲設置
            $qiniu_info = pc_base::load_config('qiniu');
            pc_base::load_plugin_class('qiniu','qiniu',0);
            Qiniu_SetKeys($qiniu_info['accessKey'], $qiniu_info['secretKey']);
            $putPolicy = new Qiniu_RS_PutPolicy($qiniu_info['bucket']);
            $upToken = $putPolicy->Token(null);
            $putExtra = new Qiniu_PutExtra();
            $putExtra->Crc32 = 1;
            list($ret, $err) = Qiniu_PutFile($upToken, $filepath, $file['tmp_name'], $putExtra);
            if ($err !== null) {
                var_dump(json_encode($err));
                var_dump($err);
                return false;
            } else {
                $this->uploadeds++;
                @unlink($file['tmp_name']);

                // 計算圖片URL
                $imgurl = 'http://pics.mofang.com.tw/' . $filepath;
                $n = crc32($imgurl) % 3;
                $imgurl = preg_replace('/pics.mofang.com.tw/', "pic$n.mofang.com.tw", $imgurl);

                $uploadedfile = array('filename'=>$file['name'], 'filepath'=>$imgurl, 'filesize'=>$file['size'], 'fileext'=>$fileext, 'fn'=>$file['fn']);
                $aids[] = $this->add($uploadedfile);
            }
            continue;

            if(!$this->overwrite && file_exists($savefile)) continue;
            $upload_func = $this->upload_func;
            if(@$upload_func($file['tmp_name'], $savefile)) {
				$this->uploadeds++;
				@chmod($savefile, 0644);
				@unlink($file['tmp_name']);
				$file['name'] = iconv("utf-8",CHARSET,$file['name']);
				$uploadedfile = array('filename'=>$file['name'], 'filepath'=>$filepath, 'filesize'=>$file['size'], 'fileext'=>$fileext, 'fn'=>$file['fn']);
				$thumb_enable = is_array($thumb_setting) && ($thumb_setting[0] > 0 || $thumb_setting[1] > 0 ) ? 1 : 0;	
				$image = new image($thumb_enable,$this->siteid);				
				if($thumb_enable) {
					$image->thumb($savefile,'',$thumb_setting[0],$thumb_setting[1]);
				}
				if($watermark_enable) {
					$image->watermark($savefile, $savefile);
				}
				if($uploadedfile['fileext'] == 'apk'){
					$infos = get_apk_info($uploadedfile['filepath']);
					$uploadedfile['xml'] = $infos['xml'];
					unset($infos['xml']);
					$uploadedfile['infos'] = json_encode($infos);
					$aids[] = $this->add_package($uploadedfile);
				}else if($uploadedfile['fileext'] == 'ipa'){
					$infos = get_ipa_info($uploadedfile['filepath']);
					$uploadedfile['xml'] = $infos['xml'];
					unset($infos['xml']);
					//var_dump($infos);
					$uploadedfile['infos'] = json_encode($infos);
					$aids[] = $this->add_package($uploadedfile);
				}else{
					$aids[] = $this->add($uploadedfile);
				}
				
			}
		}
		return $aids;
	}
	
	/**
	 * 附件下載
	 * Enter description here ...
	 * @param $field 預留字段
	 * @param $value 傳入下載內容
	 * @param $watermark 是否加入水印
	 * @param $ext 下載擴展名
	 * @param $absurl 絕對路徑
	 * @param $basehref 
	 */
	function download($field, $value,$watermark = '0',$ext = 'gif|jpg|jpeg|bmp|png', $absurl = '', $basehref = '')
	{
		global $image_d;
		$this->att_db = pc_base::load_model('attachment_model');
		$upload_url = pc_base::load_config('system','upload_url');
		$this->field = $field;
		$dir = date('Y/md/');
		$uploadpath = $upload_url.$dir;
		$uploaddir = $this->upload_root.$dir;
		$string = new_stripslashes($value);
		if(!preg_match_all("/(href|src)=([\"|']?)([^ \"'>]+\.($ext))\\2/i", $string, $matches)) return $value;
		$remotefileurls = array();
		foreach($matches[3] as $matche)
		{
			if(strpos($matche, '://') === false) continue;
			dir_create($uploaddir);
			$remotefileurls[$matche] = $this->fillurl($matche, $absurl, $basehref);
		}
		unset($matches, $string);
		$remotefileurls = array_unique($remotefileurls);
		$oldpath = $newpath = array();
		foreach($remotefileurls as $k=>$file) {
            if(strpos($file, '://') === false || strpos($file, $upload_url) !== false) continue;
            if(preg_match('#^http://pic[s\d]\.mofang\.com#', $file)) continue;
            $filename = fileext($file);
            $file_name = basename($file);
            $filename = $this->getname($filename);
            $filepath = $dir.$filename;
            $newfile = $uploaddir.$filename;

            $file_content = file_get_contents($file);
            //七牛雲上傳
            $qiniu_info = pc_base::load_config('qiniu');
            pc_base::load_plugin_class('qiniu','qiniu',0);
            Qiniu_SetKeys($qiniu_info['accessKey'], $qiniu_info['secretKey']);
            $putPolicy = new Qiniu_RS_PutPolicy($qiniu_info['bucket']);
            $upToken = $putPolicy->Token(null);
            $putExtra = new Qiniu_PutExtra();
            $putExtra->Crc32 = 1;
            list($ret, $err) = Qiniu_Put($upToken, $filepath, $file_content, $putExtra);
            if ($err !== null) {
            } else {
                $imgurl = 'http://pics.mofang.com.tw/' . $filepath;
                $n = crc32($imgurl) % 3;
                $imgurl = preg_replace('/pics.mofang.com.tw/', "pic$n.mofang.com.tw", $imgurl);

                $oldpath[] = $file;
                $GLOBALS['downloadfiles'][] = $newpath[] = $imgurl;
                $fileext = fileext($filename);
                $downloadedfile = array('filename'=>$file['name'], 'filepath'=>$imgurl, 'filesize'=>$file['size'], 'fileext'=>$fileext, 'fn'=>$file['fn']);
                $aid = $this->add($downloadedfile);
                $this->downloadedfiles[$aid] = $filepath;
            }
		}
		return str_replace($oldpath, $newpath, $value);
	}

    function download_pic($imgurl) {
        if (!$imgurl) {
            return '';
        } elseif (preg_match('#^http://pic[\d]\.mofang\.com.tw#', $imgurl)) {
            return $imgurl;
        } elseif (preg_match('#^http://pics\.mofang\.com.tw#', $imgurl)) {
            $n = crc32($imgurl) % 3;
            $imgurl = preg_replace('/pics.mofang.com.tw/', "pic$n.mofang.com.tw", $imgurl);
            return $imgurl;
        }

        $qiniu_info = pc_base::load_config('qiniu');
        pc_base::load_plugin_class('qiniu','qiniu',0);
        Qiniu_SetKeys($qiniu_info['accessKey'], $qiniu_info['secretKey']);
        $putPolicy = new Qiniu_RS_PutPolicy($qiniu_info['bucket']);
        $upToken = $putPolicy->Token(null);
        $putExtra = new Qiniu_PutExtra();
        $putExtra->Crc32 = 1;

        $filename = fileext($imgurl);
        $filename = $this->getname($filename);
        $dir = date('Y/md/');
        $filepath = $dir.$filename;
        $file_datas = file_get_contents($imgurl);

        list($ret, $err) = Qiniu_Put($upToken, $filepath, $file_datas, $putExtra);
        if ($err !== null) {
            return $imgurl;
        } else {
            $imgurl = 'http://pics.mofang.com.tw/' . $filepath;
            $n = crc32($imgurl) % 3;
            $imgurl = preg_replace('/pics.mofang.com.tw/', "pic$n.mofang.com.tw", $imgurl);

            $oldpath[] = $file;
            $GLOBALS['downloadfiles'][] = $newpath[] = $imgurl;
            $fileext = fileext($filename);
            $downloadedfile = array('filename'=>$file['name'], 'filepath'=>$imgurl, 'filesize'=>$file['size'], 'fileext'=>$fileext, 'fn'=>$file['fn']);
            $aid = $this->add($downloadedfile);
            return $imgurl;
        }
    }

	/**
	 * 附件刪除方法
	 * @param $where 刪除sql語句
	 */
	function delete($where) {
		$this->att_db = pc_base::load_model('attachment_model');
		$result = $this->att_db->select($where);
		foreach($result as $r) {
			$image = $this->upload_root.$r['filepath'];
			@unlink($image);
			$thumbs = glob(dirname($image).'/*'.basename($image));
			if($thumbs) foreach($thumbs as $thumb) @unlink($thumb);
		}
		return $this->att_db->delete($where);
	}
	
	/**
	 * 附件添加如數據庫
	 * @param $uploadedfile 附件信息
	 */
	function add($uploadedfile) {
		$this->att_db = pc_base::load_model('attachment_model');
		$uploadedfile['module'] = $this->module;
		$uploadedfile['catid'] = $this->catid;
		$uploadedfile['siteid'] = $this->siteid;
		$uploadedfile['userid'] = $this->userid;
		$uploadedfile['uploadtime'] = SYS_TIME;
		$uploadedfile['uploadip'] = ip();
		$uploadedfile['status'] = pc_base::load_config('system','attachment_stat') ? 0 : 1;
		$uploadedfile['authcode'] = md5($uploadedfile['filepath']);
		$uploadedfile['filename'] = strlen($uploadedfile['filename'])>49 ? $this->getname($uploadedfile['fileext']) : $uploadedfile['filename'];
		$uploadedfile['isimage'] = in_array($uploadedfile['fileext'], $this->imageexts) ? 1 : 0;
		$aid = $this->att_db->api_add($uploadedfile);
		$this->uploadedfiles[] = $uploadedfile;
		return $aid;
	}
		
	/**
	 * 軟件包添加如數據庫
	 * @param $uploadedfile 附件信息
	 */
	function add_package($uploadedfile) {
		$this->att_db = pc_base::load_model('app_package_model');
		$packageinfo['id'] = null;
		$packageinfo['pid'] = 0;
		$packageinfo['filename'] = strlen($uploadedfile['filename'])>49 ? $this->getname($uploadedfile['fileext']) : $uploadedfile['filename'];
		$packageinfo['size'] = $uploadedfile['filesize'];
		$packageinfo['filepath'] = $uploadedfile['filepath'];
		$packageinfo['userid'] = $this->userid;
		$packageinfo['uploadtime'] = SYS_TIME;
		$packageinfo['uploadip'] = ip();
		$packageinfo['infos'] = $uploadedfile['infos'];
		$packageinfo['xml'] = $uploadedfile['xml'];
		$aid = $this->att_db->api_add($packageinfo);
		$this->uploadedfiles[] = $uploadedfile;
		return $aid;
	}
	
	function set_userid($userid) {
		$this->userid = $userid;
	}
	/**
	 * 獲取縮略圖地址..
	 * @param $image 圖片路徑
	 */
	function get_thumb($image){
		return str_replace('.', '_thumb.', $image);
	}


	/**
	 * 獲取附件名稱
	 * @param $fileext 附件擴展名
	 */
	function getname($fileext){
		return date('Ymdhis').rand(100, 999).'.'.$fileext;
	}

	/**
	 * 返回附件大小
	 * @param $filesize 圖片大小
	 */
	
	function size($filesize) {
		if($filesize >= 1073741824) {
			$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
		} elseif($filesize >= 1048576) {
			$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
		} elseif($filesize >= 1024) {
			$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
		} else {
			$filesize = $filesize . ' Bytes';
		}
		return $filesize;
	}
	/**
	* 判斷文件是否是通過 HTTP POST 上傳的
	*
	* @param	string	$file	文件地址
	* @return	bool	所給出的文件是通過 HTTP POST 上傳的則返回 TRUE
	*/
	function isuploadedfile($file) {
		return is_uploaded_file($file) || is_uploaded_file(str_replace('\\\\', '\\', $file));
	}
	
	/**
	* 補全網址
	*
	* @param	string	$surl		源地址
	* @param	string	$absurl		相對地址
	* @param	string	$basehref	網址
	* @return	string	網址
	*/
	function fillurl($surl, $absurl, $basehref = '') {
		if($basehref != '') {
			$preurl = strtolower(substr($surl,0,6));
			if($preurl=='http://' || $preurl=='ftp://' ||$preurl=='mms://' || $preurl=='rtsp://' || $preurl=='thunde' || $preurl=='emule://'|| $preurl=='ed2k://')
			return  $surl;
			else
			return $basehref.'/'.$surl;
		}
		$i = 0;
		$dstr = '';
		$pstr = '';
		$okurl = '';
		$pathStep = 0;
		$surl = trim($surl);
		if($surl=='') return '';
		$urls = @parse_url(SITE_URL);
		$HomeUrl = $urls['host'];
		$BaseUrlPath = $HomeUrl.$urls['path'];
		$BaseUrlPath = preg_replace("/\/([^\/]*)\.(.*)$/",'/',$BaseUrlPath);
		$BaseUrlPath = preg_replace("/\/$/",'',$BaseUrlPath);
		$pos = strpos($surl,'#');
		if($pos>0) $surl = substr($surl,0,$pos);
		if($surl[0]=='/') {
			$okurl = 'http://'.$HomeUrl.'/'.$surl;
		} elseif($surl[0] == '.') {
			if(strlen($surl)<=2) return '';
			elseif($surl[0]=='/') {
				$okurl = 'http://'.$BaseUrlPath.'/'.substr($surl,2,strlen($surl)-2);
			} else {
				$urls = explode('/',$surl);
				foreach($urls as $u) {
					if($u=="..") $pathStep++;
					else if($i<count($urls)-1) $dstr .= $urls[$i].'/';
					else $dstr .= $urls[$i];
					$i++;
				}
				$urls = explode('/', $BaseUrlPath);
				if(count($urls) <= $pathStep)
				return '';
				else {
					$pstr = 'http://';
					for($i=0;$i<count($urls)-$pathStep;$i++) {
						$pstr .= $urls[$i].'/';
					}
					$okurl = $pstr.$dstr;
				}
			}
		} else {
			$preurl = strtolower(substr($surl,0,6));
			if(strlen($surl)<7)
			$okurl = 'http://'.$BaseUrlPath.'/'.$surl;
			elseif($preurl=="http:/"||$preurl=='ftp://' ||$preurl=='mms://' || $preurl=="rtsp://" || $preurl=='thunde' || $preurl=='emule:'|| $preurl=='ed2k:/')
			$okurl = $surl;
			else
			$okurl = 'http://'.$BaseUrlPath.'/'.$surl;
		}
		$preurl = strtolower(substr($okurl,0,6));
		if($preurl=='ftp://' || $preurl=='mms://' || $preurl=='rtsp://' || $preurl=='thunde' || $preurl=='emule:'|| $preurl=='ed2k:/') {
			return $okurl;
		} else {
			$okurl = preg_replace('/^(http:\/\/)/i','',$okurl);
			$okurl = preg_replace('/\/{1,}/i','/',$okurl);
			return 'http://'.$okurl;
		}
	}

	/**
	 * 是否允許上傳
	 */
	function is_allow_upload() {
        if($_groupid == 1) return true;
		$starttime = SYS_TIME-86400;
		$site_setting = $this->_get_site_setting($this->siteid);
		return ($uploads < $site_setting['upload_maxsize']);
	}
	
	/**
	 * 返回錯誤信息
	 */
	function error() {
		$UPLOAD_ERROR = array(
		0 => L('att_upload_succ'),
		1 => L('att_upload_limit_ini'),
		2 => L('att_upload_limit_filesize'),
		3 => L('att_upload_limit_part'),
		4 => L('att_upload_nofile'),
		5 => '',
		6 => L('att_upload_notemp'),
		7 => L('att_upload_temp_w_f'),
		8 => L('att_upload_create_dir_f'),
		9 => L('att_upload_dir_permissions'),
		10 => L('att_upload_limit_ext'),
		11 => L('att_upload_limit_setsize'),
		12 => L('att_upload_not_allow'),
		13 => L('att_upload_limit_time'),
		);
		
		return iconv(CHARSET,"utf-8",$UPLOAD_ERROR[$this->error]);
	}
	
	/**
	 * ck編輯器返回
	 * @param $fn 
	 * @param $fileurl 路徑
	 * @param $message 顯示信息
	 */
	
	function mkhtml($fn,$fileurl,$message) {
		$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$fn.', \''.$fileurl.'\', \''.$message.'\');</script>';
		exit($str);
	}
	/**
	 * flash上傳調試方法
	 * @param $id
	 */
	function uploaderror($id = 0)	{
		file_put_contents(PHPCMS_PATH.'xxx.txt', $id);
	}
	
	/**
	 * 獲取站點配置信息
	 * @param  $siteid 站點id
	 */
	private function _get_site_setting($siteid) {
		$siteinfo = getcache('sitelist', 'commons');
		return string2array($siteinfo[$siteid]['setting']);
	}
}
?>
