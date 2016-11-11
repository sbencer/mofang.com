	function downfiles($field, $value) {
		extract(string2array($this->fields[$field]['setting']));
		$list_str = array();
		$file_list = string2array($value);
		if(is_array($file_list)) {
			foreach($file_list as $_k=>$_v) {	
				if($_v){
					$filefrom = $_k ? $_k : L('click_to_down');
					if($downloadlink) {
						$a_k = urlencode(sys_auth("i=$this->id&s=&m=1&f=$_v&d=$downloadtype&modelid=$this->modelid&catid=$this->catid", 'ENCODE', pc_base::load_config('system','auth_key')));
						$list[$filefrom] = $a_k;
					} else {
						$list[$filefrom] = $_v;
					}
				}
			}
		}
		return $list;
	}
