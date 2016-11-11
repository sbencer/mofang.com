<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);
class keywords extends admin {
function __construct() {
$this->db = pc_base::load_model('keywords_model');
parent::__construct();
}

function init () {
		$datas = array();
		$datas = $this->db->listinfo('','listorder ASC',$_GET['page']);
		$pages = $this->db->pages;

		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=admin&c=copyfrom&a=add\', title:\''.L('keywords_add').'\', width:\'580\', height:\'240\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('keywords_add'));
		include $this->admin_tpl('keywords_list');
	}

/**
* 關鍵詞添加
*/
function add() {
	if(isset($_POST['dosubmit'])){
		if(empty($_POST['info']['keyword']) || empty($_POST['info']['pinyin']) || empty($_POST['info']['searchnums'])){
			echo L('search_word_error_input');
			return false;
		}
		$this->db->insert($_POST['info']);
		showmessage(L('operation_success'),'?m=admin&c=search_keyword&a=add',”, 'add');
	}else{
		$show_validator = $show_scroll = $show_header = true;
		include $this->admin_tpl('search_keyword_add');
	}
}

/**
* 關鍵詞修改
*/
function edit() {
	if(isset($_POST['dosubmit'])){
		$keywordid = intval($_GET['keywordid']);
		if(empty($_POST['info']['keyword']) || empty($_POST['info']['pinyin']) || empty($_POST['info']['searchnums'])){
			echo L('search_word_error_input');
			return false;
		}
		$this->db->update($_POST['info'],array('keywordid'=>$keywordid));
		showmessage(L('operation_success'),'?m=admin&c=search_keyword&a=edit',”, 'edit');
	}else{
		$show_validator = $show_scroll = $show_header = true;
		$info = $this->db->get_one(array('keywordid'=>$_GET['keywordid']));
		if(!$info) showmessage(L('specified_word_not_exist'));
		extract($info);
		include $this->admin_tpl('search_keyword_edit');
	}
}
/**
* 關鍵詞刪除
*/
function delete() {
	if(is_array($_POST['keywordid'])){
		foreach($_POST['keywordid'] as $keywordid_arr) {
			$this->db->delete(array('keywordid'=>$keywordid_arr));
		}
		showmessage(L('operation_success'),'?m=admin&c=search_keyword');
	} else {
		$keywordid = intval($_GET['keywordid']);
		if($keywordid < 1) return false;
			$result = $this->db->delete(array('keywordid'=>$keywordid));
		if($result){
			showmessage(L('operation_success'),'?m=admin&c=search_keyword');
		}else {
			showmessage(L(“operation_failure”),'?m=admin&c=search_keyword');
		}
	}
}
/**
 * 關鍵字自動補全
 */
 function get_keywords() {
 	$term = trim($_GET['term']);
 	$type = intval($_GET['count']);
 	$result = $this->db->query("select name value from phpcms_keywords where name like '%{$term}%' and type={$type}");

 	$rows = $this->db->affected_rows();
 	$key = 0;

 	echo '[';
 	foreach($this->db->fetch_array() as $val){

 		echo json_encode($val);
 		if($rows > ++$key) {
 			echo ',';
 		}
 	}
 	echo ']';
 }

}
?>