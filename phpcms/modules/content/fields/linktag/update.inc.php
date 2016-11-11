    function linktag($field, $value) {

	$linktag_to_content = pc_base::load_model('linktag_to_content_model');
    $linktag_to_content->delete(array('content_id'=>$this->id, 'catid'=>$this->data['catid']));
	$other_tags = array(41,128,129,130,131);
    $check_user = array(19, 20);
	$status = 1;
    foreach ($value as $val) {
        if (!$val) continue;
        $tag = explode('-', $val);
        $data = array(
            'catid'=>$this->data['catid'],
            'content_id'=>$this->id,
            'linktag_id'=>$tag[1],
        );
        $linktag_to_content->insert($data);
        if (in_array($tag[1], $other_tags) && in_array($_SESSION['roleid'], $check_user)) {
            $status = 2;
	    }	
	    $tags_arr[$tag[0]][] = $tag[1];
	}	

	$content_db = pc_base::load_model('content_model');
	$model_arr = getcache('model', 'commons');
	$content_db->table_name = $content_db->db_tablepre.$model_arr[$this->modelid]['tablename'];
	

	foreach ($tags_arr as $tag) {
	    if (count($tag) > 1 && in_array($_SESSION['roleid'], $check_user)) {
		$content_db->update(array('linktags'=>2),array('id'=>$this->id));
		return;
	    }
	}
	$content_db->update(array('linktags'=>$status),array('id'=>$this->id));
    }
