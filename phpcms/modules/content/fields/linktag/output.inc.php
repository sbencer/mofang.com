
	function linktag($field, $value) {
		$linktag_content_db = pc_base::load_model('linktag_to_content_model');
		$linktag_db = pc_base::load_model('linktag_model');

		$data = $linktag_content_db->select(array('content_id'=>$this->id, 'catid'=>$this->data['catid']), 'linktag_id');
		if ($data) {
			foreach($data as $row) {
				$linktag_ids[] = $row['linktag_id'];
			}
		} else {
			return false;
		}

		$data = $linktag_db->select('tag_id in ('.implode(',',$linktag_ids).')', 'parent_id, tag_id, tag_name');
		if ($data) {
			foreach ($data as $row) {
				$tags[$row['parent_id'] . '_' . $row['tag_id']] = $row['tag_name'];
			}
			return $tags;
		} else {
			return false;
		}
	}
