	function downfiles($field, $value) {
		$files = $_POST[$field.'_fileurl'];
		$files_name = $_POST[$field.'_filename'];
		$array = $temp = array();
		if(!empty($files)) {
			foreach($files as $key=>$file) {
					$array[$files_name[$key]] = $file;
			}
		}
		$array = array2string($array);
		return $array;
	}
