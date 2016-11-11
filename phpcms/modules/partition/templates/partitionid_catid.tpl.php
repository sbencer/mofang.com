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
	<legend>專區視頻與視頻欄目對應關系配置</legend>
	<label class='ib' style='width:428px'>
    請在下面欄目填寫對應專區的ID，進行匹配
    </label>
</fieldset>
    <form name="myform" id="myform" action="?m=partition&c=partition&a=partitionid_catid" method="post">

    <div style="width:700px; padding:2px; border:1px solid #d8d8d8; float:left; margin-top:10px; margin-right:10px; overflow:hidden">
    <table width="100%" cellspacing="0" class="table-list" >
        <thead>
            <tr>
            <th width="100">欄目ID</th>
            <th width="180">欄目名稱</th>
            <th >對應專區ID</th>
            </tr>
        </thead>
    <tbody id="load_catgory">
    <?php echo $categorys;?>	
    </tbody>
    </table>
    </div>

    <div style="margin-top: 10px;float: left;margin-left: 20px;">
    <input id="dosubmit" name="dosubmit" class="button" value="提交" type="submit">

    <input name="dosubmit_test" value="開始導視頻" class="button" onclick="javascript:window.top.art.dialog({id:'import',iframe:'?m=partition&c=partition&a=partitionid_to_catid', title:'專區視頻導到欄目', width:'500', height:'200', lock:true}, function(){var d = window.top.art.dialog({id:'import'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'import'}).close()});void(0);" type="button" style="display:none;">
    </div>

    </form>

 
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

//-->
</SCRIPT>
</body>
</html>