    function typeid($field, $value) {

        $type_data_db = pc_base::load_model('type_data_model');

        $info['relateid'] = $this->id;
        $info['catid'] = $this->data['catid'];
        $info['modelid'] = $this->modelid;
        $info['siteid'] = 1;

        if(!empty($value) && is_array($value)) {

            if($_GET['a']=='edit') {
                $type_data_db->delete($info);
            }

            foreach($value as $r) {
                if($r != -99) {
                    $data = array_merge($info, array('typeid'=>$r));
                    $type_data_db->insert($data);
                }
            }
        } else {
            if($_GET['a']=='edit') {
                $type_data_db->delete($info);
            }
            $info['typeid'] = $value;
            $type_data_db->insert($info);
        }
    }