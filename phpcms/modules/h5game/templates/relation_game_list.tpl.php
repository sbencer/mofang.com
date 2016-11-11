<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="kaifu" name="m">
<input type="hidden" value="admin_kaifu" name="c">
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
	function select_list(obj,title,id) {
		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {
			$(obj).attr('class','');
		}else{
			$('tr').attr('class','');
			$(obj).attr('class','line_ff9966');
		}
		$("#game_name",window.parent.document).val(title);
		$("#new_gameid",window.parent.document).val(id);
		// $("#game_catid",window.parent.document).val(catid);
		$("#game_catid",window.parent.document).val(0);//定死為0（新產品庫沒有安卓和IOS之分,智超開發前台時只要是0就是新產品庫，URL為李偉產品庫的URL）
		$("#sel_priv",window.parent.document).attr('onclick',"omnipotent('select_id','?m=kaifu&c=admin_kaifu&a=game_priv&gameid="+id+"','選擇禮包',1)");
	}
</SCRIPT>
</body>
</html>