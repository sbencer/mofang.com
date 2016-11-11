<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class area_model extends model {
	public $table_name = '';
	public function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'area';
		parent::__construct();
	}

	/**
	 * 更新全部緩存
	 */
	public function cache() {
		$products = array();
		$sql = "SELECT `id`, `title`, `area_level` FROM `phpcms_product` WHERE `area_level` > 0 ORDER BY `area_level`";
		$ret = $this->query($sql);
		if ($ret) {
			while ($line = $this->db->fetch_next()) {
				$products[$line['id']] = $line;
			}
		} else {
			return;
		}
		setcache('product_content', $products, 'commons');
		$areas = array();
		$areas = $this->areas = array();
		$this->areas = $this->select(array(),'*',10000,'productid, id ASC');
		$products = array();
		$categories = array();
		foreach ($this->areas as $area) {
			$areas[$area['id']] = $area;
			$products[$area['productid']][$area['id']] = $area;
			$categories[$area['catid']][$area['id']] = $area;
		}
		foreach ($products as $productid => $product_areas) {
			setcache('product_areas_'.$productid,$product_areas,'commons');
		}
		foreach ($categories as $catid => $category_areas) {
			setcache('category_areas_'.$catid,$category_areas,'commons');
		}
		setcache('area_content',$areas,'commons');
		return true;
	}

	/**
	 * 搜索專區
	 */
	public function search ($name) {
		if($name) {
			$product_model = pc_base::load_model('content_model');
			$product_model->table_name = $this->db_tablepre . 'product';
			if(preg_match('/([a-z]+)/i',$name)) {
				$name = strtolower(trim($_GET['name']));
				$result = $product_model->select("(letter LIKE('$name%') OR initial LIKE('$name%')) AND area_level = 1",'id,title,letter',10);
			} else {
				$name = trim($_GET['name']);
				$result = $product_model->select("title LIKE('$name%')",'id,title,letter',10);
			}
			return $result;
		}
	}

	/**
	 * 根據產品 id 查詢產品名稱
	 */
	public function get_product_name($productid) {
		$product_model = pc_base::load_model('content_model');
		$product_model->table_name = $this->db_tablepre . 'product';
		if ($productid) {
			$row = $product_model->get_one(array('id'=>$productid), 'title');
			if ($row) {
				return $row['title'];
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>
