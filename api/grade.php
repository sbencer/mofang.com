<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 遊戲評分腳本
 */

$action = !empty($_GET['a'])?$_GET['a']:'init';

$defense = new grade();
$defense->$action();

class grade {

    function __construct() {
        $this->db = pc_base::load_model('content_model');
        if ($_SERVER['HTTP_HOST'] == 'i.mofang.com') {
            $this->db->table_name = $this->db->db_tablepre.'iosgames';
        } else if($_SERVER['HTTP_HOST'] == 'a.mofang.com'){
            $this->db->table_name = $this->db->db_tablepre.'androidgames';
        } else {
            showmessage(L('呵呵O(∩_∩)O~'),'blank');
        }

        $this->comment = clone $this->db;
        $this->comment->table_name = $this->db->db_tablepre.'comment_data_1';
    }

    /**
     * 塔防迷評分無請求報錯
     */
    function init() {
        $info['error'] = true;
        $info['message'] = 'NO ACTION REQUEST';

        echo json_encode($info);
    }

    function refresh() {

        $result = $this->db->select('','catid,id');

        foreach ($result as $key => $v) {
            // 單遊戲平均分及評論數計算
            $commentid =  "content_{$v['catid']}-{$v['id']}-1";
            $info = $this->grading($commentid);
            $count = $info['count'];
            $avg = $info['avg'];

            $user_base = $count/($count+100);
            $dire_base = 100/($count+100);

            $user_grade = $user_base * $avg;

            // 更新評分數據
            $this->db->query("UPDATE {$this->db->table_name} SET score={$dire_base}*direction+{$user_grade} WHERE id={$v['id']}");
        }

        echo '評分更新成功~';
    }

    /**
     * 評分計算算法
     * @param $contentid
     */
    protected function grading($commentid) {

        $return['count'] = $count = $this->comment->count("commentid = '$commentid' AND direction != 0");

        $result = $this->comment->get_one("commentid = '$commentid' AND direction != 0",'AVG(direction)');
        $return['avg'] = $result['AVG(direction)'];

        return $return;

    }

    function __call($action, $param) {
        echo $action,' is not exit!';
    }


}

?>
