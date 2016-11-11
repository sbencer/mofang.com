<?php
/**
 * 獲取關鍵字接口
 */
defined('IN_PHPCMS') or exit('No permission resources.'); 

echo get_keywords();

function get_keywords() {
    $db = pc_base::load_model('content_model');

    $db->table_name = $db->db_tablepre."iosgames";
    $keywordi = $db->select('','title');
    $keywordis = split_keywords($keywordi);

    $db->table_name = $db->db_tablepre."androidgames";
    $keyworda = $db->select('','title');
    $keywordas = split_keywords($keyworda);

    $keywords = array_merge($keywordas,$keywordis);

    foreach ($keywords as $keyword) {
        if (empty($keyword)) continue;
        $return[$keyword] = "{$keyword}/n/null/null";
    }
    return implode("\n", $return);
}

/**
 * 從查詢結果中生成不重復的中文關鍵字
 * @param resource $resource 數據庫查詢結果集
 * @param array $keyword 關鍵字數組
 */
function split_keywords($resource) {
    foreach ($resource as $row) {
        preg_match_all('/[\x{4e00}-\x{9fa5}]{2,}/u',$row['title'],$match);
        foreach ($match[0] as $val) {
            $keyword[$val] = $val;
        }
    }
    return $keyword;
}

?>
