    function typeid($field, $value) {
        if($this->fields[$field]['boxtype'] == 'checkbox') {
            if(!is_array($value) || empty($value)) return false;
            array_shift($value);
            $value = implode(',', $value);
            return $value;
        } else {
            return $value;
        }
    }