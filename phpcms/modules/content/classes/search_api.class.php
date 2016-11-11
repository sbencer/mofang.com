<?php
defined('IN_PHPCMS') or exit('No permission resources.');
/**
 * 全站搜索內容入庫接口
 */
class search_api extends admin {
	private $siteid,$categorys,$db,$catids;
	public function __construct() {
		$this->siteid = $this->get_siteid();
		$this->categorys = getcache('category_content_'.$this->siteid,'commons');
		$this->db = pc_base::load_model('content_model');
		// 獲得所有可以被索引的欄目id
		foreach ($this->categorys as $v) {
			if ($v['issearch'] == 1) {
				$catids[] = $v['catid']; 
			}
		}
		$this->catids = implode(',', $catids);
	}
	public function set_model($modelid) {
		$this->modelid = $modelid;
		$this->db->set_model($modelid);
	}
	
	/**
	 * 全文索引API
	 * @param $pagesize 每頁條數
	 * @param $page 當前頁
	 */
	public function fulltext_api($pagesize = 100, $page = 1) {

		$system_keys = $model_keys = array();
		$fulltext_array = getcache('model_field_'.$this->modelid,'model');
		// 模型主表字段
		foreach($fulltext_array AS $key=>$value) {
			if($value['issystem'] && $value['issearch']) {
				$system_keys[] = $key;
			}
		}
		if(empty($system_keys)) return '';
		$system_keys = 't.id,inputtime,'.implode(',',$system_keys);
		$offset = $pagesize*($page-1);

		//模型從表字段
		foreach($fulltext_array AS $key=>$value) {
			if(!$value['issystem'] && $value['issearch']) {
				$model_keys[] = $key;
			}
		}
		if (!empty($model_keys)) {
			$model_keys = ','.implode(',',$model_keys);
		} else {
			$model_keys = '';
		}

		$table = $this->db->table_name;
		$table_data = $table.'_data';
		$this->db->query("SELECT {$system_keys}{$model_keys} FROM $table t, $table_data d WHERE catid IN ($this->catids) AND t.id=d.id AND status=99 LIMIT {$offset},{$pagesize}");
		$result = $this->db->fetch_array();

        $types = array('1'=>'news', '3'=>'picture', '11'=>'video', '20'=>'game', '21'=>'game');

		//處理結果
		foreach($result as $key => $r) {
            $temp = array();

            $res = $this->db->query("SELECT p.arrparentid,p.catid FROM phpcms_partition p LEFT JOIN phpcms_partition_games g 
					ON g.part_id=p.catid WHERE g.modelid={$this->modelid} AND g.gameid={$r['id']}");
            $partition_info = $this->db->fetch_array();
            $specialids = array();
            foreach ($partition_info as $val) {
                $specialids[] = $val['catid'];
            }

            foreach ($r as $k => $v) {
				$temp[$k] = $v;
            }

            $temp['modelid'] = $this->modelid;
            $temp['types'] = $types[$this->modelid];
            $temp['ukid'] = $r['catid'].'0'.$r['id'];

			if ($partition_info) {
				$partitions = explode(',', $partition_info[0]['arrparentid']);
				$temp['partition'] = $partitions[1];
				$temp['specialid'] = implode('/', $specialids);
			} else {
                unset($temp['specialid']);
				$temp['partition'] = 0;
			}
			
            if ($temp['description']) {
                $temp['description'] = strip_tags($temp['description']);
            }
            if ($temp['content']) {
                $temp['content'] = strip_tags($temp['content']);
            }

			$data[$r['id']] = $temp;
		}
		return $data;
	}

	/**
	 * 計算總數
	 * @param $modelid
	 */
	public function total($modelid) {
		$this->modelid = $modelid;
		$this->db->set_model($modelid);
		return $this->db->count("catid in ($this->catids)");
	}
}
