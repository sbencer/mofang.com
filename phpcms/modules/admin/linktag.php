<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin','admin',0);

class linktag extends admin {
	private $db;
	function __construct() {
		parent::__construct();
		$this->db = pc_base::load_model('linktag_model');
	}	
	//標簽類別管理
	public function item_tag () {
		if(isset($_GET['tag_id'])){
			$parent_id = $_GET['tag_id'];
			$tags = $this->db->listinfo(array('delete_flag'=>0,'parent_id'=>$parent_id),'sort', 1, 100);
			$str = "<thead>
					<tr><th width='38'>".L('listorder')."</th>
						<th>tag_id</th>
						<th>".L('linktag_name')."</th>
						<th align='center' >".L('linktag_use_count')."</th>         
						<th >".L('operations_manage')."</th>
					</tr>
				 </thead>";
			foreach($tags as $key => $v){
				$str.=" <tbody>";
				$name = $v['tag_name'];
				$str.= "<tr>
							<td width='38'><input name='sort[$name]' type='text' size='3' value='{$v['sort']}' class='input-text-c'></td>
							<td width='30' align='center'>{$v['tag_id']}</td>
							<td align='center' class='tag_name' id='{$v['tag_id']}'>{$v['tag_name']}</td>
							<td align='left' width='50'>{$v['count']}</td>
							<td align='center'> 
							<a href='?m=admin&c=linktag&a=item_tag&action=tag_rename&value={$v['tag_name']}'>".L('wap_edit')." </a>  | 
							<a href='javascript:;' onclick='tag_delete(this)'>".L('forbidden')."</a>
							</td>					
						</tr></tbody>";
			}
		}else {
			$tags = $this->db->listinfo(array('parent_id'=>0,'delete_flag'=>0),'sort', 1, 100);
			$str = "<thead>
					<tr><th width='38'>".L('listorder')."</th>
						<th>item_tag_id</th>
						<th>".L('item_tag_name')."</th>
						<th align='center' >".L('tags_count')."</th>         
						<th >".L('operations_manage')."</th>
					</tr>
				 </thead>";
			foreach($tags as $key=>$v){
				$item_count = $this->db->count(array('parent_id'=>$v['tag_id']));
				$str.=" <tbody>";
				$name = $v['tag_name'];
				$str.= "<tr>
				<td width='38'><input name='sort[$name]' type='text' size='3' value='{$v['sort']}' class='input-text-c'></td>
				<td width='30' align='center'>{$v['tag_id']}</td>
				<td align='center' class='tag_name' id='{$v['tag_id']}'>{$v['tag_name']}</td>
				<td align='left' width='50'>{$item_count}</td><td align='center'> 
					<a href='?m=admin&c=linktag&a=item_tag&tag_id={$v['tag_id']}'> ". L('check_tags')."</a> |	
					<a href='?m=admin&c=linktag&a=item_tag&action=tag_rename&value={$v['tag_name']}'>".L('wap_edit')." </a> 
				</td></tr></tbody>";
			}		
		}
		if(isset($_GET['action'])){
			$tags = $this->db->listinfo(array('parent_id'=>0,'delete_flag'=>0),'sort', 1, 100);
			$where = $this->db->get_one(array('tag_name'=>$_GET['value']));
			foreach($tags as $v) {
				if($v['tag_id'] == $where['parent_id']){
					$item .= "<option selected value='{$v['tag_id']}'>{$v['tag_name']}</option>";
				}else{
					$item .= "<option  value='{$v['tag_id']}'>{$v['tag_name']}</option>";
				}
			}
		}
		include $this->admin_tpl('item_tag');
	}
	//被禁標簽
	public function inits () {
		$tags = $this->db->listinfo('delete_flag=1','sort',1, 100);
		foreach($tags as $key=>$v){
			$parents = $this->db->get_one(array('tag_id'=>$v['parent_id']));
			$parent = $parents['tag_name'];
			$str.=" <tbody>";
			$name = $v['tag_name'];
			$str.= "<tr>
			<td width='38'><input name='sort[$name]' type='text' size='3' value='{$v['sort']}' class='input-text-c' readonly disabled></td>
			<td  align='center'>{$v['tag_id']}</td>
			<td align='center'>{$parent}</td>
			<td align='center' class='tag_name' id='{$v['tag_id']}'>{$v['tag_name']}</td>
			<td align='left' width='50'>{$v['count']}</td><td align='center'> 
				<a href='javascript:;' onclick='tag_recover(this)'> ". L('tag_recover')."</a> 	
			</td></tr></tbody>";
		}		
		include $this->admin_tpl('linktag');
	}
	  //添加標簽
	public function tag_add() {	
		if(isset($_POST['submit'])) {
			$arr['tag_name'] = trim($_POST['tag_name']);
			if($arr['tag_name']==''){
				showmessage('不能為空');exit;
			}		
			$a = $this->db->get_one(array('tag_name'=>$arr['tag_name']));
			if(empty($a)){
				$arr['create_time'] = time();
				$arr['parent_id'] = $_POST['parent_id'];
				if($this->db->insert($arr)){
					showmessage('添加成功');
				}
			}else{
				showmessage("標簽已存在");exit;
			}	
		}else{
			$tags = $this->db->listinfo(array('parent_id'=>0,'delete_flag'=>0),'sort',1,100);
			foreach($tags as $v) {
				$item .= "<option value='{$v['tag_id']}'>{$v['tag_name']}</option>";
			}
			include $this->admin_tpl('tag_add');
		}			
	}
	//標簽排序
	public function tag_list(){	
		$arr = $_POST['sort'];
		$flag = true;
		foreach($arr as $key=>$v){
			$data = array('sort'=>$v);
			$where = array('tag_name'=>$key);
			if(!$this->db->update($data,$where)){
				$flag = false;
			}		
		}
		if($flag){
			showmessage('操作成功');
		}
	}
	//檢查有沒有重復標簽  有則不能添加
	public function tag_check(){
		$arr['tag_name'] = trim($_GET['tag_name']);
		$a = $this->db->get_one(array('tag_name'=>$arr['tag_name']));
		if(!empty($a)){
			echo 1;
		}else{
			echo 0;
		}
	}
	//標簽禁用
	public function tag_delete(){
		$data = array('delete_flag'=>'1');
		$where = array('tag_name'=>$_POST['tag_name']);				
		if($this->db->update($data,$where)){
			showmessage('操作成功');	
		}else{
			showmessage('操作失敗');	
		}	
	}
	//修改標簽
	public function tag_update(){
		$tag_id = $this->db->get_one(array('tag_name'=>$_POST['old_name']));
		$_POST['tag_name'] = trim($_POST['tag_name']);
		$_POST['tag_name'] = empty($_POST['tag_name']) ? $_POST['old_name'] : $_POST['tag_name'];
		$data = array('tag_name'=>$_POST['tag_name'],'parent_id'=>$_POST['parent_id']);
		$where = array('tag_id'=>$tag_id['tag_id']);
		if($this->db->update($data,$where)){
			showmessage('操作成功');	
		}else{
			showmessage('操作失敗');	
		}
	}
	//恢復使用標簽
	public function tag_recover(){	
		$data = array('delete_flag'=>'0');
		$where = array('tag_name'=>$_POST['tag_name']);
		if($this->db->update($data,$where)){
			showmessage('操作成功');	
		}else{
			showmessage('操作失敗');	
		}
	}
	//批量添加標簽
	public function tags_add() {
		if($_POST['submit']){
			$tags = $_POST['tags'];
			$arr = explode("\n", $tags);
			$arr = array_unique($arr);
			$arr = array_filter($arr);
			$l = count($arr);
			for($i = 0;$i < $l;$i++) {
				$a = $this->db->get_one(array('tag_name'=>trim($arr[$i])));
				if(empty($a)){
					$data[$i]['parent_id'] = $_POST['parent_id'];
					$data[$i]['tag_name'] = trim($arr[$i]);
					$data[$i]['create_time'] = time();
				}
			}
			sort($data);
			if($this->db->batch_insert($data)){
				showmessage(L('add_success'));
			}else{
				showmessage('操作失敗,可能標簽重復');
			}
		}else{
			$tags = $this->db->listinfo(array('parent_id'=>0,'delete_flag'=>0),'sort',1,100);
			foreach($tags as $v) {
				$item .= "<option value='{$v['tag_id']}'>{$v['tag_name']}</option>";
			}
			include $this->admin_tpl('tags_add');
		}
	}
}
?>
