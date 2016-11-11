<?php
/**
 * 取得所有的
 */
function getAllAdData() {
    $key = "allAdData";
    if (!($data = getcache($key, '', 'memcache', 'html'))) {
        $db = pc_base::load_model('adclass_model');
        $sql = 'select *  from phpcms_adclass';
        $db->query($sql);
        $data = $db->fetch_array();
        if ($data) {
            setcache($key, $data, '', 'memcache', 'html', 3600);
        }
    }
    return $data;
}

function printAdClass($formatAllClass, $level=0) {
    $htmlTag = '<tr>
                        <th>%s</th>
                        <th align="left">%s</th>
                        <th>%s</th>
                        <th><a href="javascript:edit(%s, \'%s\')">%s</a></th>
                        </tr>';
    $levelStr = $level > 0 ? str_repeat("&nbsp;", $level) . '└' : '';
    foreach ($formatAllClass as $val) {
        printf($htmlTag,
            $val['id'],
            $levelStr . $val['name'],
            $val['parentname'],
            $val['id'],
            $val['name'],
            L('edit')
        );
        if ($val['son']) {
            printAdClass($val['son'], $level+4);
        }

    }
}


/**
 * 选择下拉框时候用到
 * @param $formatAllClass
 * @param int $level
 * @param array $selectArr
 */
function printSelect($formatAllClass, $level=0, $selectArr = array()) {
    $htmlTag = '<option value="%s" %s>%s</option>';
    $levelStr = $level > 0 ? str_repeat("&nbsp;", $level) . '└' : '';
    foreach ($formatAllClass as $val) {
        printf($htmlTag,
            $val['id'],
            in_array($val['id'], (array)$selectArr) ? ' selected="selected" ' : "",
            $levelStr . $val['name']
        );
        if ($val['son']) {
            printSelect($val['son'], $level+2, $selectArr);
        }

    }
}


/**
 * 族谱排列
 */
function getAllClass($allClass, $pid = 0) {
    if (!$allClass) {
        return array();
    }
    $data = array();
    foreach ($allClass as $index => $one) {
        $dataIndex = count($data);
        if ($one['pid'] == $pid) {
            $data[$dataIndex] = $one;
            unset($allClass[$index]);
            $data[$dataIndex]['son'] = getAllClass($allClass, $one['id']);
        }
    }
    return $data;
}