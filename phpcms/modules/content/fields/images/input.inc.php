	function images($field, $value) {
		//取得圖片列表
		$pictures = $_POST[$field.'_url'];
		//取得圖片說明
		$pictures_alt = isset($_POST[$field.'_alt']) ? $_POST[$field.'_alt'] : array();
		$array = $temp = array();
		if(!empty($pictures)) {
			foreach($pictures as $key=>$pic) {
				$temp['url'] = $this->attachment->download_pic($pic);
				$temp['alt'] = $pictures_alt[$key];
				$array[$key] = $temp;
			}
		}
		$array = array2string($array);
		return $array;
	}