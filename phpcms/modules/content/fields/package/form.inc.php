	function package($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		extract($setting);
		//引入上傳js文件
		if(!defined('IMAGES_INIT')) {
                        $str = '<script type="text/javascript" src="'.JS_PATH.'swfupload/swf2ckeditor.js"></script>';
                        define('IMAGES_INIT', 1);
                }
		//獲取字段配置
		$value = string2array(html_entity_decode($value,ENT_QUOTES));
                $html = '';
                if (defined('IN_ADMIN')) {
			$html = '<input name="info['.$field.']" type="hidden" value="1"><input id="fileid" type="hidden" name="package_fileid[]" value="'.$value[fileid].'"><input id="fileurl" type="text" name="package_fileurl[]" value="'.$value[fileurl].'" style="width:370px;" class="input-text">';
			$authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");
			$html .= $str."<input type=\"button\"  class=\"button\" value=\"上傳文件\" onclick=\"javascript:flashupload('package_multifile', '".L('attachment_upload')."','{$field}',change_multifile,'{$upload_number},{$upload_allowext},{$isselectimage}','content','$this->catid','{$authkey}')\"/> ";
			$html .= '<input type="button" class="button" id="check_romote" value="檢測遠程文件" onclick="$.get(\'?m=attachment&c=attachments&a=check_romote&catid='.$this->catid.'&sid=\'+Math.random()*5, {data:$(\'#fileurl\').val()}, function(data){data=eval(\'(\'+data+\')\'); if(data.status==\'200\') {$(\'#check_romote\').val(\'遠程文件可用\');$(\'#check_romote\').css(\'background-color\',\'#FF9900\');$(\'#filesize\').val(data.size);} else if(data.status==\'0\') {$(\'#check_romote\').val(\'文件不可用\');$(\'#check_romote\').css(\'background-color\',\'#FF0000\');}})" style="width:100px;"/>';
		}
		return $html;
	}
