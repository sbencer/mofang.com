<?php
/**
 *  mysql.class.php 數據庫實現類
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-6-1
 */

final class mysql {

	/**
	 * 數據庫配置信息
	 */
	private $config = null;

	/**
	 * 數據庫連接資源句柄
	 */
	public $link = null;

	/**
	 * 最近一次查詢資源句柄
	 */
	public $lastqueryid = null;

	/**
	 *  統計數據庫查詢次數
	 */
	public $querycount = 0;

	public function __construct() {

	}

	/**
	 * 打開數據庫連接,有可能不真實連接數據庫
	 * @param $config	數據庫連接參數
	 *
	 * @return void
	 */
	public function open($config) {
		$this->config = $config;
		if($config['autoconnect'] == 1) {
			$this->connect();
		}
	}

	/**
	 * 真正開啟數據庫連接
	 *
	 * @return void
	 */
	public function connect() {
		$func = $this->config['pconnect'] == 1 ? 'mysql_pconnect' : 'mysql_connect';
		if(!$this->link = @$func($this->config['hostname'], $this->config['username'], $this->config['password'], 1)) {
			$this->halt('Can not connect to MySQL server');
			return false;
		}

		if($this->version() > '4.1') {
			$charset = isset($this->config['charset']) ? $this->config['charset'] : '';
			$serverset = $charset ? "character_set_connection='$charset',character_set_results='$charset',character_set_client=binary" : '';
			$serverset .= $this->version() > '5.0.1' ? ((empty($serverset) ? '' : ',')." sql_mode='' ") : '';
			$serverset && mysql_query("SET $serverset", $this->link);
		}

		if($this->config['database'] && !@mysql_select_db($this->config['database'], $this->link)) {
			$this->halt('Cannot use database '.$this->config['database']);
			return false;
		}
		$this->database = $this->config['database'];
		return $this->link;
	}

	/**
	 * 數據庫查詢執行方法
	 * @param $sql 要執行的sql語句
	 * @return 查詢資源句柄
	 */
	private function execute($sql) {
		if(!is_resource($this->link)) {
			$this->connect();
		}

		$this->lastqueryid = mysql_query($sql, $this->link) or $this->halt(mysql_error(), $sql);

		$this->querycount++;
		return $this->lastqueryid;
	}

	/**
	 * 執行sql查詢
	 * @param $data 		需要查詢的字段值[例`name`,`gender`,`birthday`]
	 * @param $table 		數據表
	 * @param $where 		查詢條件[例`name`='$name']
	 * @param $limit 		返回結果範圍[例：10或10,10 默認為空]
	 * @param $order 		排序方式	[默認按數據庫默認方式排序]
	 * @param $group 		分組方式	[默認為空]
	 * @param $key 			返回數組按鍵名排序
	 * @return array		查詢結果集數組
	 */
	public function select($data, $table, $where = '', $limit = '', $order = '', $group = '', $key = '') {
		$where = $where == '' ? '' : ' WHERE '.$where;
		$order = $order == '' ? '' : ' ORDER BY '.$order;
		$group = $group == '' ? '' : ' GROUP BY '.$group;
		$limit = $limit == '' ? '' : ' LIMIT '.$limit;
		$field = explode(',', $data);
		array_walk($field, array($this, 'add_special_char'));
		$data = implode(',', $field);

		$sql = 'SELECT '.$data.' FROM `'.$this->config['database'].'`.`'.$table.'`'.$where.$group.$order.$limit;
		$this->execute($sql);
		if(!is_resource($this->lastqueryid)) {
			return $this->lastqueryid;
		}

		$datalist = array();
		while(($rs = $this->fetch_next()) != false) {
			if($key) {
				$datalist[$rs[$key]] = $rs;
			} else {
				$datalist[] = $rs;
			}
		}
		$this->free_result();
		return $datalist;
	}

	/**
	 * 獲取單條記錄查詢
	 * @param $data 		需要查詢的字段值[例`name`,`gender`,`birthday`]
	 * @param $table 		數據表
	 * @param $where 		查詢條件
	 * @param $order 		排序方式	[默認按數據庫默認方式排序]
	 * @param $group 		分組方式	[默認為空]
	 * @return array/null	數據查詢結果集,如果不存在，則返回空
	 */
	public function get_one($data, $table, $where = '', $order = '', $group = '') {
		$where = $where == '' ? '' : ' WHERE '.$where;
		$order = $order == '' ? '' : ' ORDER BY '.$order;
		$group = $group == '' ? '' : ' GROUP BY '.$group;
		$limit = ' LIMIT 1';
		$field = explode( ',', $data);
		array_walk($field, array($this, 'add_special_char'));
		$data = implode(',', $field);

		$sql = 'SELECT '.$data.' FROM `'.$this->config['database'].'`.`'.$table.'`'.$where.$group.$order.$limit;
		$this->execute($sql);
		$res = $this->fetch_next();
		$this->free_result();
		return $res;
	}

	/**
	 * 遍歷查詢結果集
	 * @param $type		返回結果集類型
	 * 					MYSQL_ASSOC，MYSQL_NUM 和 MYSQL_BOTH
	 * @return array
	 */
	public function fetch_next($type=MYSQL_ASSOC) {
		$res = mysql_fetch_array($this->lastqueryid, $type);
		if(!$res) {
			$this->free_result();
		}
		return $res;
	}

	/**
	 * 釋放查詢資源
	 * @return void
	 */
	public function free_result() {
		if(is_resource($this->lastqueryid)) {
			mysql_free_result($this->lastqueryid);
			$this->lastqueryid = null;
		}
	}

	/**
	 * 直接執行sql查詢
	 * @param $sql							查詢sql語句
	 * @return	boolean/query resource		如果為查詢語句，返回資源句柄，否則返回true/false
	 */
	public function query($sql) {
		return $this->execute($sql);
	}

	/**
	 * 執行添加記錄操作
	 * @param $data 		要增加的數據，參數為數組。數組key為字段值，數組值為數據取值
	 * @param $table 		數據表
	 * @param $return_insert_id		是否返回 insert_id
	 * @param $replace 		是否替換衝突的數據
	 * @return boolean
	 */
	public function insert($data, $table, $return_insert_id = false, $replace = false) {
		if(!is_array( $data ) || $table == '' || count($data) == 0) {
			return false;
		}

		$fielddata = array_keys($data);
		$valuedata = array_values($data);
		array_walk($fielddata, array($this, 'add_special_char'));
		array_walk($valuedata, array($this, 'escape_string'));

		$field = implode (',', $fielddata);
		$value = implode (',', $valuedata);

		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$sql = $cmd.' `'.$this->config['database'].'`.`'.$table.'`('.$field.') VALUES ('.$value.')';
		$return = $this->execute($sql);
		return $return_insert_id ? $this->insert_id() : $return;
	}

	/**
	 * 執行批量添加記錄操作
	 * @param $data 		要增加的數據，參數為二維數組。第二級數組key為字段值，數組值為數據取值
	 * @param $table 		數據表
	 * @param $return_insert_id		是否返回 insert_id
	 * @param $replace 		是否替換衝突的數據
	 * @return boolean
	 */
	public function batch_insert($data, $table, $return_insert_id = false, $replace = false, $ignore = false) {
		if(!is_array( $data ) || $table == '' || count($data) == 0) {
			return false;
		}

		$fielddata = array_keys($data[0]);
		array_walk($fielddata, array($this, 'add_special_char'));
		$field = implode (',', $fielddata);

		foreach ($data as $item) {
			$valuedata = array_values($item);
			array_walk($valuedata, array($this, 'escape_string'));
			$values[] = '(' . implode (',', $valuedata) . ')';
		}
		$value = implode(', ', $values);

		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
        $cmd = $ignore ? 'INSERT IGNORE INTO' : $cmd;
		$sql = $cmd.' `'.$this->config['database'].'`.`'.$table.'`('.$field.') VALUES '.$value;
		$return = $this->execute($sql);
		return $return_insert_id ? $this->insert_id() : $return;
	}

	/**
	 * 獲取最後一次添加記錄的主鍵號
	 * @return int
	 */
	public function insert_id() {
		return mysql_insert_id($this->link);
	}

	/**
	 * 執行更新記錄操作
	 * @param $data 		要更新的數據內容，參數可以為數組也可以為字符串，建議數組。
	 * 						為數組時數組key為字段值，數組值為數據取值
	 * 						為字符串時[例：`name`='phpcms',`hits`=`hits`+1]。
	 *						為數組時[例: array('name'=>'phpcms','password'=>'123456')]
	 *						數組可使用array('name'=>'+=1', 'base'=>'-=1');程序會自動解析為`name` = `name` + 1, `base` = `base` - 1
	 * @param $table 		數據表
	 * @param $where 		更新數據時的條件
	 * @return boolean
	 */
	public function update($data, $table, $where = '') {
		if($table == '' or $where == '') {
			return false;
		}

		$where = ' WHERE '.$where;
		$field = '';
		if(is_string($data) && $data != '') {
			$field = $data;
		} elseif (is_array($data) && count($data) > 0) {
			$fields = array();
			foreach($data as $k=>$v) {
				switch (substr($v, 0, 2)) {
					case '+=':
						$v = substr($v,2);
						if (is_numeric($v)) {
							$fields[] = $this->add_special_char($k).'='.$this->add_special_char($k).'+'.$this->escape_string($v, '', false);
						} else {
							continue;
						}

						break;
					case '-=':
						$v = substr($v,2);
						if (is_numeric($v)) {
							$fields[] = $this->add_special_char($k).'='.$this->add_special_char($k).'-'.$this->escape_string($v, '', false);
						} else {
							continue;
						}
						break;
					default:
						$fields[] = $this->add_special_char($k).'='.$this->escape_string($v);
				}
			}
			$field = implode(',', $fields);
		} else {
			return false;
		}

		$sql = 'UPDATE `'.$this->config['database'].'`.`'.$table.'` SET '.$field.$where;
		return $this->execute($sql);
	}

	/**
	 * 執行刪除記錄操作
	 * @param $table 		數據表
	 * @param $where 		刪除數據條件,不充許為空。
	 * 						如果要清空表，使用empty方法
	 * @return boolean
	 */
	public function delete($table, $where) {
		if ($table == '' || $where == '') {
			return false;
		}
		$where = ' WHERE '.$where;
		$sql = 'DELETE FROM `'.$this->config['database'].'`.`'.$table.'`'.$where;
		return $this->execute($sql);
	}

	/**
	 * 獲取最後數據庫操作影響到的條數
	 * @return int
	 */
	public function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	/**
	 * 獲取數據表主鍵
	 * @param $table 		數據表
	 * @return array
	 */
	public function get_primary($table) {
		$this->execute("SHOW COLUMNS FROM $table");
		while($r = $this->fetch_next()) {
			if($r['Key'] == 'PRI') break;
		}
		return $r['Field'];
	}

	/**
	 * 獲取表字段
	 * @param $table 		數據表
	 * @return array
	 */
	public function get_fields($table) {
		$fields = array();
		$this->execute("SHOW COLUMNS FROM $table");
		while($r = $this->fetch_next()) {
			$fields[$r['Field']] = $r['Type'];
		}
		return $fields;
	}

	/**
	 * 檢查不存在的字段
	 * @param $table 表名
	 * @return array
	 */
	public function check_fields($table, $array) {
		$fields = $this->get_fields($table);
		$nofields = array();
		foreach($array as $v) {
			if(!array_key_exists($v, $fields)) {
				$nofields[] = $v;
			}
		}
		return $nofields;
	}

	/**
	 * 檢查表是否存在
	 * @param $table 表名
	 * @return boolean
	 */
	public function table_exists($table) {
		$tables = $this->list_tables();
		return in_array($table, $tables) ? 1 : 0;
	}

	public function list_tables() {
		$tables = array();
		$this->execute("SHOW TABLES");
		while($r = $this->fetch_next()) {
			$tables[] = $r['Tables_in_'.$this->config['database']];
		}
		return $tables;
	}

	/**
	 * 檢查字段是否存在
	 * @param $table 表名
	 * @return boolean
	 */
	public function field_exists($table, $field) {
		$fields = $this->get_fields($table);
		return array_key_exists($field, $fields);
	}

	public function num_rows($sql) {
		$this->lastqueryid = $this->execute($sql);
		return mysql_num_rows($this->lastqueryid);
	}

	public function num_fields($sql) {
		$this->lastqueryid = $this->execute($sql);
		return mysql_num_fields($this->lastqueryid);
	}

	public function result($sql, $row) {
		$this->lastqueryid = $this->execute($sql);
		return @mysql_result($this->lastqueryid, $row);
	}

	public function error() {
		return @mysql_error($this->link);
	}

	public function errno() {
		return intval(@mysql_errno($this->link)) ;
	}

	public function version() {
		if(!is_resource($this->link)) {
			$this->connect();
		}
		return mysql_get_server_info($this->link);
	}

	public function close() {
		if (is_resource($this->link)) {
			@mysql_close($this->link);
		}
	}

	public function halt($message = '', $sql = '') {
		if($this->config['debug']) {
			$this->errormsg = "<b>MySQL Query : </b> $sql <br /><b> MySQL Error : </b>".$this->error()." <br /> <b>MySQL Errno : </b>".$this->errno()." <br /><b> Message : </b> $message <br /><a href='http://faq.phpcms.cn/?errno=".$this->errno()."&msg=".urlencode($this->error())."' target='_blank' style='color:red'>Need Help?</a>";
			$msg = $this->errormsg;
			echo '<div style="font-size:12px;text-align:left; border:1px solid #9cc9e0; padding:1px 4px;color:#000000;font-family:Arial, Helvetica,sans-serif;"><span>'.$msg.'</span></div>';
			exit;
		} else {
			return false;
		}
	}

	/**
	 * 對字段兩邊加反引號，以保證數據庫安全
	 * @param $value 數組值
	 */
	public function add_special_char(&$value) {
		if('*' == $value || false !== strpos($value, '(') || false !== strpos($value, '.') || false !== strpos ( $value, '`')) {
			//不處理包含* 或者 使用了sql方法。
		} else {
			$value = '`'.trim($value).'`';
		}
		if (preg_match("/\b(select|insert|update|delete)\b/i", $value)) {
			$value = preg_replace("/\b(select|insert|update|delete)\b/i", '', $value);
		}
		return $value;
	}

	/**
	 * 對字段值兩邊加引號，以保證數據庫安全
	 * @param $value 數組值
	 * @param $key 數組key
	 * @param $quotation
	 */
	public function escape_string(&$value, $key='', $quotation = 1) {
		if ($quotation) {
			$q = '\'';
		} else {
			$q = '';
		}
		$value = $q.$value.$q;
		return $value;
	}
}
?>
