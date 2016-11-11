<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="public_relationlist" name="a">
<input type="hidden" value="<?php echo $modelid;?>" name="modelid">
<fieldset>
	<legend>當前所在專區</legend>
	<label class='ib' style='width:128px'><input type='radio' name='select_siteid' checked >
		<?php echo $partition_array['catname'];?></label>
</fieldset>
    <div style="width:500px; padding:2px; border:1px solid #d8d8d8; float:left; margin-top:10px; margin-right:10px; overflow:hidden">
    <table width="100%" cellspacing="0" class="table-list" >
            <thead>
                <tr>
                <th width="100">欄目ID</th>
                <th >欄目名稱</th>
                <th width="150" >所屬模型</th>
                </tr>
            </thead>
        <tbody id="load_catgory">
        <?php echo $categorys;?>	
        </tbody>
        </table>
    </div>

    <div style="overflow:hidden;_float:left;margin-top:10px;*margin-top:0;_margin-top:0; width:144px">
    <fieldset>
        <legend>選擇的欄目</legend>
    <ul class='list-dot-othors' id='catname'></ul>
    </fieldset>
    </div>
</div>
<style type="text/css">
.line_ff9966,.line_ff9966:hover td{background-color:#FF9966}
.line_fbffe4,.line_fbffe4:hover td {background-color:#fbffe4}
.list-dot-othors li{float:none; width:auto}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function select_list(obj,title,id) {
		var relation_ids = window.top.$('#relation').val();
		var sid = 'v'+id;
		$(obj).attr('class','line_fbffe4');
		var str = "<li id='"+sid+"'>·<input type='hidden' name='othor_catid["+id+"]' value='"+id+"'><span>"+title+"</span><a href='javascript:;' class='close' onclick=\"remove_id('"+sid+"')\"></a></li>";

		window.top.$('#add_othors_text').append(str);
		$('#catname').append(str);
		if(relation_ids =='' ) {
			window.top.$('#relation').val(id);
		} else {
			relation_ids = relation_ids+'|'+id;
			window.top.$('#relation').val(relation_ids);
		}
}

function change_siteid(siteid,partition_id,parentid) {
		$("#load_catgory").load("?m=partition&c=content&a=public_getsite_categorys&siteid="+siteid+"&partition_id="+partition_id+'&parentid='+parentid);
}
//移除ID
function remove_id(id) {
	$('#'+id).remove();
	window.top.$('#'+id).remove();
}
change_siteid(1,<?php echo $partition_id;?>,<?php echo $parentid;?>);
//-->
</SCRIPT>
</body>
</html>