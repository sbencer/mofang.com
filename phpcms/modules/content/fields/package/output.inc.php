	function package($field, $value) {
		extract(string2array($this->fields[$field]['setting']));
		$list_str = array();
		$file_list = string2array($value);
		if(is_array($file_list) && $file_list['fileurl']) {
			return $file_list['fileurl'];
		}
		return false;
	}