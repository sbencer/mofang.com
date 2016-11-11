
	function relation($field, $value, $fieldinfo) {
		extract($fieldinfo);
		$content_db = pc_base::load_model('content_model');
		$text_html = '';
		if ($value) {
			$ids = array_filter(explode('|', $value));
			if ($ids) {
				foreach ($ids as $id) {
					list($model_id, $content_id) = explode('-', $id);
					$content_db->set_model($model_id);
					$content_info = $content_db->get_one(array('id'=>$content_id), 'id, title');
					$sid = "relation_{$field}_{$id}";
					$text_html .= "<li id='{$sid}' style='width:210px;float:left;padding-right:5px;'>·<span>{$content_info['title']}</span><a href='javascript:;' class='close' onclick=\"remove_mfrelation('{$sid}','{$id}', '$field')\"></a></li>";
				}
			}
		}
		$formtext = "<input type='hidden' name='info[{$field}]' id='relation_{$field}' value='{$value}' style='50' >
		<div>
<input type='button' value='添加{$name}' onclick=\"omnipotent('select_{$field}','?m=content&c=content&a=public_mfrelation&modelids={$modelids}&field={$field}','選擇{$name}',1)\" class='button'>
<ul class='list-dot' id='relation_{$field}_text'>{$text_html}</ul></div>
";
		return $formtext;
	}
