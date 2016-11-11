	function package($field, $value) {
		$files = $_POST['package_fileurl'];
		$files_id = $_POST['package_fileid'];
		//$files_alt = $_POST['package_filename'];
		$array = $temp = array();
		if(!empty($files)) {
			foreach($files as $key=>$file) {
					$temp['fileid'] = !empty($files_id[$key])?:0;
					$temp['fileurl'] = $file;
					//$temp['filename'] = $files_alt[$key];
			}
		}
		$array = array2string($temp);
		return $array;
	}
