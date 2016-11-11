	function image($field, $value) {
        $value = $this->attachment->download_pic($value);
		return trim($value);
	}
