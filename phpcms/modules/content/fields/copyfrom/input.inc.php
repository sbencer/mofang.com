	function copyfrom($field, $value) {
		$field_data = $field.'_data';
		
		$db = pc_base::load_model('copyfrom_model');
		if($copyfrom_id = $db->get_one(array('sitename'=>$value),'id')){
			$value .= '|'.$copyfrom_id['id'];
		}else{
			$copyfrom_id = $db->insert(array('siteid'=>1,'sitename'=>$value),true);
			$infos = $db->select('','*','','listorder DESC','','id');
			setcache('copyfrom',$infos,'admin');
			$value .= '|'.$copyfrom_id;
		}
		return $value;
	}
