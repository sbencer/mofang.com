	function keyword($field, $value) {
	    if($value == '') return '';

		$tags = preg_split('/\s*(,|，)\s*/', $value);
		return array_filter($tags,trim);
	}
