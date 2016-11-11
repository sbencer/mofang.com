<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
$this_dialog=1;
?>

<div class="pad-10">
	<div class="table-list">
	    <table width="100%" cellspacing="0" >
	        <thead>
	            <tr>
	            <th>禮包名稱</th>
				<th width="150">禮包類型</th>
	            <th width="150"><?php echo L('add_time');?></th>
	            </tr>
	        </thead>
		    <tbody>
				<?php if(isset($privs)){foreach($privs as $game_priv) { ?>
					<tr class="" onclick="select_list(this,'<?php echo safe_replace($game_priv['name']);?>','<?php echo $game_priv['id'];?>')" title="<?php echo L('click_to_select');?>">
						<td align='left' ><?php echo mb_strimwidth($game_priv['name'],0,40);?></td>
						<td align='center'><?php echo $game_priv['privilege_type'];?></td>
						<td align='center'><?php echo date('Y-m-d H:i',$game_priv['intime']);?></td>
					</tr>
				<?php 
					}}else{
						echo '<tr><td colspan="3" align="center">沒有與該遊戲相關禮包！</td></tr>';
					}
				?>
			</tbody>
	    </table>
	   <!-- <div id="pages"><?php echo $pages;?></div> -->
	</div>
</div>
<style type="text/css">
 .line_ff9966,.line_ff9966:hover td{
	background-color:#FF9966;
}
</style>
<script language="javascript">
	function select_list(obj,name,privid) {

		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {
			$(obj).attr('class','');
		}else{
			$('tr').attr('class','');
			$(obj).attr('class','line_ff9966');
		}
		$("#priv_name",window.parent.document).val(name);
		$("#priv_id",window.parent.document).val(privid);
	}
</script>