    function relation($field, $value) {
        if ($value) {
            $ids = array_filter(explode('|', $value));
            $result = array();
            foreach ($ids as $id) {
                $result[] = array_combine(array('model_id', 'content_id'), explode('-', $id));
            }

            return $result;
        } else {
            return NULL;
        }
    }
