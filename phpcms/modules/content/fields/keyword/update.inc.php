	function keyword($field, $value) {

		$content_db = pc_base::load_model('content_model');
		$model_arr = getcache('model', 'commons');
		$content_db->table_name = $content_db->db_tablepre.$model_arr[$this->modelid]['tablename'];

		$keyword_db = pc_base::load_model('keywords_model');
		$keydata_db = pc_base::load_model('keywords_data_model');

		// 獲得文章catid,id字段信息
		if (!$data = $content_db->get_one(array('id'=>$this->id),'catid,id')) {
			return false;
		}

		$keydata_db->delete(array('aid'=>$data['id']));

		$tags = preg_split('/\s*(,|，)\s*/',$value);
		$tags = array_filter($tags,trim);

		$key = 0;
		foreach($tags as $word){
			
			if(!$keyword_id = $keyword_db->get_one(array('name'=>$word,'type'=>++$key),'id')){
				$keyword_id['id'] = $keyword_db->insert(array('listorder'=>0,'name'=>$word,'type'=>$key,'count'=>0),true);
			}
			
			$keyword_id = $keyword_id['id'];
			$keydata_db->insert(array('kid'=>$keyword_id,'catid'=>$data['catid'],'aid'=>$data['id']));
			$count = $keydata_db->get_one(array('kid'=>$keyword_id),'count(*)');
			$keyword_db->update(array('count'=>$count['count(*)']),array('id'=>$keyword_id));

		}
	}
