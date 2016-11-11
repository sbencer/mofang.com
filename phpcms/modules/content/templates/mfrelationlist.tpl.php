<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<div class="pad-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="content" name="m">
<input type="hidden" value="content" name="c">
<input type="hidden" value="public_mfrelation" name="a">
<input type="hidden" value="<?php echo $type; ?>" name="type">
<input type="hidden" value="<?php echo $field; ?>" name="field">
<input type="hidden" value="<?php echo $modelids_str; ?>" name="modelids">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="center">
		<div class="explain-col">
<?php if (count($modelids) > 1):?>
			<select name="modelid">
<?php foreach($modelids as $mid):?>
				<option value='<?php echo $mid;?>' <?php if($mid==$modelid) echo 'selected';?>><?php echo $model_cache[$mid]['name'];?></option>
<?php endforeach;?>
			</select>
<?php else:?>
			<input name="modelid" type="hidden" value="<?php echo $modelid;?>" />
<?php endif;?>
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
	<tr onclick="select_list(this,'<?php echo safe_replace($r['title']);?>','<?php echo $modelid . '-' . $r['id'];?>')" class="cu" title="<?php echo L('click_to_select');?>">
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
	// function select_list(obj,title,id) {
	// 	$(obj).attr('class','line_ff9966');
	// 	window.top.$('#relation_<?php echo $field; ?>_name').val(title);
	// 	window.top.$('#relation_<?php echo $field; ?>').val(id);
	// 	window.top.art.dialog({id:'select_<?php echo $field; ?>'}).close();
	// }
	function select_list(obj,title,id) {
		var input_id = '#relation_<?php echo $field; ?>';
		var relation_ids = window.top.$(input_id).val();
		var sid = 'relation_<?php echo $field;?>_'+id;
		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {
			$(obj).attr('class','line_fbffe4');
			window.top.$('#'+sid).remove();
			if(relation_ids !='' ) {
				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				newrelation_ids = $.grep(r_arr,function(v){return v != '' && v!= id;}).join('|');
				window.top.$(input_id).val('|' + newrelation_ids + '|');
			}
		} else {
			$(obj).attr('class','line_ff9966');
			var str = "<li id='"+sid+"' style='width:210px;float:left;padding-right:5px;'>·<span>"+title+"</span><a href='javascript:;' class='close' onclick=\"remove_mfrelation('"+sid+"','"+id+"', '<?php echo $field; ?>')\"></a></li>";
			<?php if($type) { ?>
			if(relation_ids =='' ) {
				window.top.$(input_id).val('|' + id + '|');
				window.top.$('#relation_<?php echo $field; ?>_text').append(str);
			} else {
				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				newrelation_ids = $.grep(r_arr,function(v){return v != '';});
				if (newrelation_ids.indexOf(id) == -1) {
					newrelation_ids.push(id);
					window.top.$('#relation_<?php echo $field; ?>_text').append(str);
				}
				window.top.$(input_id).val('|' + newrelation_ids.join('|') + '|');
			}
			<?php }else{ ?>
				if(relation_ids =='' ) {
				window.top.$(input_id).val('|' + id + '|');
				window.top.$('#relation_<?php echo $field; ?>_text').append(str);
				window.top.art.dialog({id:'select_gameid'}).close();
			} else {
				// var r_arr = relation_ids.split('|');
				// var newrelation_ids = '';
				window.top.$('#relation_<?php echo $field; ?>_text').text('');
				// alert(hh.html);
				// newrelation_ids = $.grep(r_arr,function(v){return v != '';});
				// if (newrelation_ids.indexOf(id) == -1) {
				// 	newrelation_ids.push(id);
				// 	window.top.$('#relation_<?php echo $field; ?>_text').html();
				// }
				// window.top.$(input_id).val('|' + newrelation_ids.join('|') + '|');
				window.top.$(input_id).val('|' + id + '|');
				window.top.$('#relation_<?php echo $field; ?>_text').append(str);
				window.top.art.dialog({id:'select_gameid'}).close();
			}
			<?php } ?>
		}
	}
//-->
</SCRIPT>
</body>
</html>
