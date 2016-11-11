	function copyfrom($field, $value, $fieldinfo) {
		$value_data = '';
		$copyfroms = '';
		if($value && strpos($value,'|')!==false) {
			$arr = explode('|',$value);
			$value = $arr[0];
			$value_data = $arr[1];
		}
		$copyfrom_array = getcache('copyfrom','admin');
		$copyfrom_datas = array(L('copyfrom_tips'));
		if(!empty($copyfrom_array)) {
			foreach($copyfrom_array as $_k=>$_v) {
				if($this->siteid==$_v['siteid']) $copyfrom_datas[$_k] = $_v['sitename'];
			}
		}
		foreach($copyfrom_datas as $val){
			$copyfroms .= '"'.$val.'",';
		}
		return "<input type='text' id='copyfrom' name='info[$field]' value='$value' style='width: 400px;' class='input-text'><ul id='copyfroms' style='float:left;position:absolute;'></ul>".form::select($copyfrom_datas,$value_data,"name='{$field}_data' ","","onchange=copychange()").
		'<script>
		function copychange(){if($(\'select[name="'.$field.'_data"] option:selected\').val()!=0){$(\'input[name="info\['.$field.'\]"]\').val($(\'select[name="'.$field.'_data"] option:selected\').text());}else{$(\'input[name="info\['.$field.'\]"]\').val("");}}
		$( "#copyfrom" ).autocomplete({source: [ '.$copyfroms.' ]});
		</script>';
	}
