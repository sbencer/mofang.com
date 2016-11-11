<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-10">
	<form name="searchform" action="" method="get" >
		<input type="hidden" value="kaifu" name="m">
		<input type="hidden" value="kaifu" name="m">
		<input type="hidden" value="admin_kaifu" name="c">
		<input type="hidden" value="game_info" name="a">
		<table width="100%" cellspacing="0" class="search-form">
		    <tbody>
				<tr>
					<td align="center">
						<div class="explain-col">
							<select name="game_sort">
								<?php  foreach( $game_sort as $s_key => $s_value ):?>
									<option value='<?php echo $s_key;?>' <?php if($game_info == $s_key) echo 'selected';?>><?php echo $s_value;?></option>
								<?php endforeach;?>
							</select>
							<input name="keywords" type="text" value="<?php echo stripslashes($_GET['keywords'])?>" style="width:330px;" class="input-text" />
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
	            <th ><?php echo L('game_name');?></th>
				<th width="100"><?php echo L('game_belong');?></th>
	            <th width="100"><?php echo L('addtime');?></th>
	            </tr>
	        </thead>
		    <tbody>
			<?php foreach($game_infos as $game_item) { ?>
			<tr onclick="select_list(this,'<?php echo safe_replace($game_item['title']);?>','<?php echo $game_item['id'];?>','<?php echo $game_item['catid'];?>')" class="cu" title="<?php echo L('click_to_select');?>">
				<td align='left' ><?php echo $game_item['title'];?></td>
				<td align='center'><?php echo $categorys[$game_item['catid']];?></td>
				<td align='center'><?php echo format::date($game_item['inputtime']);?></td>
			</tr>
			 <?php }?>
			</tbody>
	    </table>
	   <div id="pages"><?php echo $pages;?></div>
	</div>
</div>

<style type="text/css">
 .line_ff9966,.line_ff9966:hover td{
	background-color:#FF9966;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
	function select_list(obj,title,id,catid) {
		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {
			$(obj).attr('class','');
		}else{
			$('tr').attr('class','');
			$(obj).attr('class','line_ff9966');
		}
		$("#game_name",window.parent.document).val(title);
		$("#game_id",window.parent.document).val(id);
		$("#game_catid",window.parent.document).val(catid);
		$("#sel_priv",window.parent.document).attr('onclick',"omnipotent('select_id','?m=kaifu&c=admin_kaifu&a=game_priv&gameid="+id+"','選擇禮包',1)");
	}
</SCRIPT>
</body>
</html>
