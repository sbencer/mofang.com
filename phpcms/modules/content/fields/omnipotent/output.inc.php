
	function omnipotent($field, $value) {
		switch ( $field ) {
			case 'author':
				$author_db = pc_base::load_model('content_model');
				$author_db->table_name = $author_db->db_tablepre . 'author';

				$row = $author_db->get_one(array('id'=>$value), 'title');
				if ($row) {
					return $row['title'];
				} else {
					return NULL;
				}
				break;

			case 'price':
				if ($this->data['limit_free'] && $this->data['limit_free_timeline'] > time()) {
					return '限時免費';
				} elseif ($this->data['price_number'] == 0) {
					return '免費';
				} else {
					if ($this->data['price_unit'] == 2) {
						return '$' . number_format($this->data['price_number'], 2);
					} else {
						return '￥' . number_format($this->data['price_number'], 2);
					}
				}
				break;

			default:
				break;
		}
	}

