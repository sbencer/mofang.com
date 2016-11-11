<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class vote_option_model extends model {
	function __construct() {
		$this->db_config = pc_base::load_config('database');
		$this->db_setting = 'default';
		//$this->db_tablepre = $this->db_config[$this->db_setting]['tablepre'];
		$this->table_name = 'vote_option';
		parent::__construct();
	}
	/**
	 * 說明:添加投票選項操作
	 * @param $data 選項數組
	 * @param $subjectid 投票標題ID
	 */
	function add_options($data, $subjectid,$siteid)
	{
		//判斷傳遞的數據類型是否正確 
		if(!is_array($data)) return FALSE;
		if(!$subjectid) return FALSE;
		foreach($data as $key=>$val)
		{
			if(trim($val)=='') continue;
			$newoption=array(
					'subjectid'=>$subjectid,
					'siteid'=>$siteid,
					'option'=>$val,
					'image'=>'',
					'listorder'=>0
			);
			$this->insert($newoption);

		}
		return TRUE;
	}

	/**
	 * 說明:更新選項  
	 * @param $data 數組  Array ( [44] => 443 [43(optionid)] => 334(option 值) )
	 * @param $subjectid
	 */
	function update_options($data)
	{
		//判斷傳遞的數據類型是否正確 
		if(!is_array($data)) return FALSE;
		foreach($data as $key=>$val)
		{
			if(trim($val)=='') continue;
			$newoption=array(
					'option'=>$val,
			);
			$this->update($newoption,array('optionid'=>$key));

		}
		return TRUE;
	}
	/**
	 * 說明:選項排序
	 * @param  $data 選項數組
	 */
	function set_listorder($data)
	{
		if(!is_array($data)) return FALSE;
		foreach($data as $key=>$val)
		{
			$val = intval($val);
			$key = intval($key);
			$this->db->query("update $tbname set listorder='$val' where {$keyid}='$key'");
		}
		return $this->db->affected_rows();
	}
	/**
	 * 說明:刪除指定 投票ID對應的選項 
	 * @param $data
	 * @param $subjectid
	 */
	function del_options($subjectid)
	{
		if(!$subjectid) return FALSE;
		$this->delete(array('subjectid'=>$subjectid));
		return TRUE;
			
	}

	/**
	 * 說明: 查詢 該投票的 選項
	 * @param $subjectid 投票ID 
	 */
	function get_options($subjectid)
	{
		if(!$subjectid) return FALSE;
		return $this->select(array('subjectid'=>$subjectid),'*','',$order = 'optionid ASC');
			
	}
	/**
	 * 說明:刪除單條對應ID的選項記錄 
	 * @param $optionid 投票選項ID
	 */
	function del_option($optionid)
	{
		if(!$optionid) return FALSE;
		return $this->delete(array('optionid'=>$optionid));
	}
}
?>