	function posid($field, $value, $fieldinfo) {
		$setting = string2array($fieldinfo['setting']);
		$position = getcache('position','commons');
		if(empty($position)) return '';
		$array = array();
		foreach($position as $_key=>$_value) {
			if($_value['modelid'] && ($_value['modelid'] !=  $this->modelid) || ($_value['catid'] && strpos(','.$this->categorys[$_value['catid']]['arrchildid'].',',','.$this->catid.',')===false)) continue;
			$array[$_key] = $_value['name'];
		}
		$posids = array();
		if(ROUTE_A=='edit') {
			$this->position_data_db = pc_base::load_model('position_data_model');
			$result = $this->position_data_db->select(array('id'=>$this->id,'modelid'=>$this->modelid),'*','','','','posid');
			$posids = implode(',', array_keys($result));
		} else {
			$posids = $setting['defaultvalue'];
		}
		
		// 權限設置
		$disabled = '';
		$this->priv_db = pc_base::load_model('category_priv_model');
		$result = $this->priv_db->get_one(array("catid"=>$_GET['catid'],"roleid"=>$_SESSION['roleid'],"action"=>"commend"));
		if($_SESSION['roleid'] != 1 && !$result){$disabled = 'disabled';}

		return "<input type='hidden' $disabled name='info[$field][]' value='-1'>".form::checkbox($array,$posids,"name='info[$field][]' $disabled",'',$setting['width']);
	}
