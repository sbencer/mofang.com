	function editor($field, $value, $fieldinfo) {
		//是否允許用戶上傳附件 ，後台管理員開啟此功能
		extract($fieldinfo);
		extract(string2array($setting));
		$allowupload = defined('IN_ADMIN') ? 1 : 0;
		if(!$value) $value = $defaultvalue;
		if($minlength || $pattern) $allow_empty = '';
		if($errortips) $this->formValidator .= '$("#'.$field.'").formValidator({'.$allow_empty.'onshow:"",onfocus:"'.$errortips.'"}).inputValidator({min:1,onerror:"'.$errortips.'"});';
		return "<div id='{$field}_tip'></div>".'<textarea name="info['.$field.']" id="'.$field.'" boxid="'.$field.'">'.$value.'</textarea>'.form::editor($field,$toolbar,'member','','',$allowupload,1,'',300);
	}
