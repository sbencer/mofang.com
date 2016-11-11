<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="partition" name="m">
<input type="hidden" value="partition" name="c">
<input type="hidden" value="public_relation_game_list" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
				每頁條數：
				<input name="pagesize" id="pagesize" type="text" value="<?php echo stripslashes($_GET['pagesize'])?>" style="width:20px;" class="input-text" />
				關鍵字：<input name="keywords" type="text" value="<?php echo stripslashes($_GET['keywords'])?>" style="width:330px;" class="input-text" />
				<input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th >遊戲名稱</th>
			<th width="100">圖標</th>
            <th width="100">入庫時間</th>
            </tr>
        </thead>
    <tbody>
	<?php foreach($infos as $r) { ?>
	<tr onclick="select_list(this,'<?php echo safe_replace($r['name']);?>',<?php echo $r['id'];?>)" class="cu" title="<?php echo L('click_to_select');?>">
		<td align='left' title="<?php echo $r['comment']?>"><?php echo $r['name'];?></td>
		<td align='center'><img src="<?php echo $r['icon'];?>" style="width:60px;"></td>
		<td align='center'><?php echo date("Y-m-d H:i:s",$r['create_time']);?></td>
	</tr>
	 <?php }?>
	    </tbody>
    </table>
   <div id="pages"><?php echo pages($totals,$page,$pagesize);?></div>
</div>
</div>
<style type="text/css">
 .line_ff9966,.line_ff9966:hover td{
	background-color:#FF9966;
}
 .line_fbffe4,.line_fbffe4:hover td {
	background-color:#fbffe4;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function select_list(obj,title,id) {
		var relation_ids = $("#relation_hao",window.parent.document).val();
		var sid = 'game<?php echo $modelid;?>'+id;
		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {
			$(obj).attr('class','line_fbffe4');
			window.top.$('#'+sid).remove();
			if(relation_ids !='' ) {
				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				$.each(r_arr, function(i, n){
					if(n!=id) {
						if(i==0) {
							newrelation_ids = n;
						} else {
						 newrelation_ids = newrelation_ids+'|'+n;
						}
					}
				});
				$("#relation_hao",window.parent.document).val(newrelation_ids);
			}
		} else {
			$(obj).attr('class','line_ff9966');
			var str = "<li id='"+sid+"' style=\"width: 210px;float: left;padding-right: 5px;\">·<span>"+title+"</span><a href='javascript:;' class='close' onclick=\"remove_relation_game_partition('relation_hao','"+sid+"',"+id+")\"></a></li>";
			$("#relation_hao_text",window.parent.document).append(str);

			if(relation_ids =='' ) {
				$("#relation_hao",window.parent.document).val(id);
			} else {
				relation_ids = relation_ids+'|'+id;
				$("#relation_hao",window.parent.document).val(relation_ids);
			}
		}
}
//-->
</SCRIPT>
</body>
</html>