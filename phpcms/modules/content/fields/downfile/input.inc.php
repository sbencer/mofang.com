	function downfile($field, $value) {
		//取得鏡像站點列表
		$result = '';
		$server_list = count($_POST[$field.'_servers']) > 0 ? implode(',' ,$_POST[$field.'_servers']) : '';
		$result = $value.'|'.$server_list;
		return $result;
	}
