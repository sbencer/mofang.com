<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="public_relationlist" name="a">
<input type="hidden" value="1" name="authorlist">
<input type="hidden" value="<?php echo $modelid;?>" name="modelid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
				<select name="field">
					<option value='title' <?php if($_GET['field']=='title') echo 'selected';?>><?php echo L('title');?></option>
					<option value='keywords' <?php if($_GET['field']=='keywords') echo 'selected';?> ><?php echo L('keywords');?></option>
					<option value='description' <?php if($_GET['field']=='description') echo 'selected';?>><?php echo L('description');?></option>
					<option value='id' <?php if($_GET['field']=='id') echo 'selected';?>>ID</option>
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
            <th ><?php echo L('title');?></th>
			<th width="100"><?php echo L('belong_category');?></th>
            <th width="100"><?php echo L('addtime');?></th>
            </tr>
        </thead>
    <tbody>
	<?php foreach($infos as $r) { ?>
	<tr onclick="select_list(this,'<?php echo safe_replace($r['title']);?>',<?php echo $r['id'];?>)" class="cu" title="<?php echo L('click_to_select');?>">
		<td align='left' ><?php echo $r['title'];?></td>
		<td align='center'><?php echo $this->categorys[$r['catid']]['catname'];?></td>
		<td align='center'><?php echo format::date($r['inputtime']);?></td>
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
 .line_fbffe4,.line_fbffe4:hover td {
	background-color:#fbffe4;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function select_list(obj,title,id) {
		$(obj).attr('class','line_ff9966');
		window.top.$('#authorname').val(title);
		window.top.$('#author').val(id);
		window.top.art.dialog({id:'selectauthor'}).close();
	}
//-->
</SCRIPT>
</body>
</html>