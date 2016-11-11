<?php 
/**
 *  model.class.php 數據模型基類
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-7
 */
defined('IN_PHPCMS') or exit('Access Denied');
pc_base::load_sys_class('db_factory', '', 0);
class model {
	
	//數據庫配置
	protected $db_config = '';
	//數據庫連接
	protected $db = '';
	//調用數據庫的配置項
	protected $db_setting = 'default';
	//數據表名
	protected $table_name = '';
	//表前綴
	public  $db_tablepre = '';
	
	public function __construct() {
		if (!isset($this->db_config[$this->db_setting])) {
			$this->db_setting = 'default';
		}
		$this->table_name = $this->db_config[$this->db_setting]['tablepre'].$this->table_name;
		$this->db_tablepre = $this->db_config[$this->db_setting]['tablepre'];
		$this->db = db_factory::get_instance($this->db_config)->get_database($this->db_setting);
	}
		
	/**
	 * 執行sql查詢
	 * @param $where 		查詢條件[例`name`='$name']
	 * @param $data 		需要查詢的字段值[例`name`,`gender`,`birthday`]
	 * @param $limit 		返回結果範圍[例：10或10,10 默認為空]
	 * @param $order 		排序方式	[默認按數據庫默認方式排序]
	 * @param $group 		分組方式	[默認為空]
	 * @return array		查詢結果集數組
	 */
	final public function select($where = '', $data = '*', $limit = '', $order = '', $group = '', $key='') {
		if (is_array($where)) $where = $this->sqls($where);
		return $this->db->select($data, $this->table_name, $where, $limit, $order, $group, $key);
	}

	/**
	 * 查詢多條數據並分頁
	 * @param $where
	 * @param $order
	 * @param $page
	 * @param $pagesize
	 * @return unknown_type
	 */
	final public function listinfo($where = '', $order = '', $page = 1, $pagesize = 20, $key='', $setpages = 10,$urlrule = '',$array = array()) {
		$where = to_sqls($where);
		$this->number = $this->count($where);
		$page = max(intval($page), 1);
		$offset = $pagesize*($page-1);
		$this->pages = pages($this->number, $page, $pagesize, $urlrule, $array, $setpages);
		$array = array();
		return $this->select($where, '*', "$offset, $pagesize", $order, '', $key);
	}

	/**
	 * 獲取單條記錄查詢
	 * @param $where 		查詢條件
	 * @param $data 		需要查詢的字段值[例`name`,`gender`,`birthday`]
	 * @param $order 		排序方式	[默認按數據庫默認方式排序]
	 * @param $group 		分組方式	[默認為空]
	 * @return array/null	數據查詢結果集,如果不存在，則返回空
	 */
	final public function get_one($where = '', $data = '*', $order = '', $group = '') {
		if (is_array($where)) $where = $this->sqls($where);
		return $this->db->get_one($data, $this->table_name, $where, $order, $group);
	}
	
	/**
	 * 直接執行sql查詢
	 * @param $sql							查詢sql語句
	 * @return	boolean/query resource		如果為查詢語句，返回資源句柄，否則返回true/false
	 */
	final public function query($sql) {
		return $this->db->query($sql);
	}
	
	/**
	 * 執行添加記錄操作
	 * @param $data 		要增加的數據，參數為數組。數組key為字段值，數組值為數據取值
	 * @param $return_insert_id 是否返回新建ID號
	 * @param $replace 是否採用 replace into的方式添加數據
	 * @return boolean
	 */
	final public function insert($data, $return_insert_id = false, $replace = false) {
		return $this->db->insert($data, $this->table_name, $return_insert_id, $replace);
	}
	
	/**
	 * 獲取最後一次添加記錄的主鍵號
	 * @return int 
	 */
	final public function insert_id() {
		return $this->db->insert_id();
	}
	
	/**
	 * 執行更新記錄操作
	 * @param $data 		要更新的數據內容，參數可以為數組也可以為字符串，建議數組。
	 * 						為數組時數組key為字段值，數組值為數據取值
	 * 						為字符串時[例：`name`='phpcms',`hits`=`hits`+1]。
	 *						為數組時[例: array('name'=>'phpcms','password'=>'123456')]
	 *						數組的另一種使用array('name'=>'+=1', 'base'=>'-=1');程序會自動解析為`name` = `name` + 1, `base` = `base` - 1
	 * @param $where 		更新數據時的條件,可為數組或字符串
	 * @return boolean
	 */
	final public function update($data, $where = '') {
		if (is_array($where)) $where = $this->sqls($where);
		return $this->db->update($data, $this->table_name, $where);
	}
	
	/**
	 * 執行刪除記錄操作
	 * @param $where 		刪除數據條件,不充許為空。
	 * @return boolean
	 */
	final public function delete($where) {
		if (is_array($where)) $where = $this->sqls($where);
		return $this->db->delete($this->table_name, $where);
	}
	
	/**
	 * 計算記錄數
	 * @param string/array $where 查詢條件
	 */
	final public function count($where = '') {
		$r = $this->get_one($where, "COUNT(*) AS num");
		return $r['num'];
	}
	
	/**
	 * 將數組轉換為SQL語句
	 * @param array $where 要生成的數組
	 * @param string $font 連接串。
	 */
	final public function sqls($where, $font = ' AND ') {
		if (is_array($where)) {
			$sql = '';
			foreach ($where as $key=>$val) {
				$sql .= $sql ? " $font `$key` = '$val' " : " `$key` = '$val'";
			}
			return $sql;
		} else {
			return $where;
		}
	}
	
	/**
	 * 獲取最後數據庫操作影響到的條數
	 * @return int
	 */
	final public function affected_rows() {
		return $this->db->affected_rows();
	}
	
	/**
	 * 獲取數據表主鍵
	 * @return array
	 */
	final public function get_primary() {
		return $this->db->get_primary($this->table_name);
	}
	
	/**
	 * 獲取表字段
	 * @return array
	 */
	final public function get_fields() {
		return $this->db->get_fields($this->table_name);
	}
	
	/**
	 * 檢查表是否存在
	 * @param $table 表名
	 * @return boolean
	 */
	final public function table_exists($table){
		return $this->db->table_exists($this->db_tablepre.$table);
	}
	
	final public function list_tables() {
		return $this->db->list_tables();
	}
	/**
	 * 返回數據結果集
	 * @param $query （mysql_query返回值）
	 * @return array
	 */
	final public function fetch_array() {
		$data = array();
		while($r = $this->db->fetch_next()) {
			$data[] = $r;		
		}
		return $data;
	}
	
	/**
	 * 返回數據庫版本號
	 */
	final public function version() {
		return $this->db->version();
	}
}