	function sarcasm($field, $value) {

		// 只有添加默認吐槽功能，無須編輯
		if($_GET['a']=='add') {
			$sarcasm = pc_base::load_app_class('sarcasm','sarcasm');
			$db = pc_base::load_model('content_model');
			$model_arr = getcache('model', 'commons');
			$db->table_name = $db->db_tablepre.$model_arr[$this->modelid]['tablename'];

			array_shift($value);
			if(!empty($value)){
				$default = $value;
				$sarcasmid = "content_{$this->data['catid']}-{$this->id}-1";

				// 獲得文章信息
				if ($data = $db->get_one(array('id'=>$this->id),'title,url')) {
					$title = $data['title'];
					$url = $data['url'];
					unset($data);
				}else{
					return false;
				}

				// 插入新數據到吐槽數據表
				$siteid = $this->fields['catid']['siteid'];
				$data = array('userid'=>null, 'username'=>$SITE['name'].L('phpcms_friends'),'content'=>'');
				foreach($default as $msg){
					$data['content'] = $msg;
					$sarcasm->add($sarcasmid, $siteid, $data, $title, $url, true);
				}
			}
		} 
		
	}
