<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<style type="text/css">
.table-list td b{color:#666}
.tpl_style{background-color:#FBFAE3}

</style>
<form name="myform" action="?m=admin&c=category&a=batch_edit" method="post">
<div class="pad_10">
<div class="explain-col">
<?php echo L('category_batch_tips');?></a>
</div>
<div class="bk10"></div>
<div id="table-lists" class="table-list" >
    <table height="auto" cellspacing="0" >
        <thead >
		<?php
		foreach($batch_array as $catid=>$cat) {
			$batch_array[$catid]['setting'] = string2array($cat['setting']);
			echo "<th width='260' align='left' ><strong>{$cat[catname]} （catid: <font color='red'>{$catid}</font>）</strong></th>";
		}
		?>
        </thead>
    <tbody>
     <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('catname')?>：</b><br><input type='text' name='info[<?php echo $catid;?>][catname]' id='catname' class='input-text' value='<?php echo $cat['catname']?>' style='width:250px'></td>
	<?php
		}
	?>
	 </tr>


	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('catgory_img')?>：</b><br><?php echo form::images('info['.$catid.'][image]', 'image'.$catid, $cat['image'], 'content','',23);?></td>
	<?php
		}
	?>
	 </tr>

	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('available_styles')?>：</b><br>
		<?php echo form::select($template_list, $cat['setting']['template_list'], 'name="setting['.$catid.'][template_list]" id="template_list" onchange="load_file_list(this.value,'.$catid.')"', L('please_select'))?>
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('category_index_tpl')?>：</b><br>
		<div id="category_template<?php echo $catid;?>">
		<?php echo form::select_template($cat['setting']['template_list'], 'content',$cat['setting']['category_template'],'name="setting['.$catid.'][category_template]" style="width:250px"','category');?>
		</div>
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('category_list_tpl')?>：</b><br>
		<div id="list_template<?php echo $catid;?>">
		<?php echo form::select_template($cat['setting']['template_list'], 'content',$cat['setting']['list_template'],'name="setting['.$catid.'][list_template]" style="width:250px"','list');?>
		</div>
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td class="tpl_style"><b><?php echo L('content_tpl')?>：</b><br>
		<div id="show_template<?php echo $catid;?>">
		<?php echo form::select_template($cat['setting']['template_list'], 'content',$cat['setting']['show_template'],'name="setting['.$catid.'][show_template]" style="width:250px"','show');?>
		</div>
		</td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('workflow')?>：</b><br><?php echo form::select($workflows_datas,$cat['setting']['workflowid'],'name="setting['.$catid.'][workflowid]"',L('catgory_not_need_check'));?></td>
	<?php
		}
	?>
	 </tr>

	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('meta_title')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][meta_title]' type='text' value='<?php echo $cat['setting']['meta_title'];?>' style='width:250px'>
		  </td>
	<?php
		}
	?>
	 </tr>

	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('meta_keywords')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][meta_keywords]' type='text' value='<?php echo $cat['setting']['meta_keywords'];?>' style='width:250px'>
		  </td>
	<?php
		}
	?>
	 </tr>
	 <tr>
	 <?php
		foreach($batch_array as $catid=>$cat) {
	?>
		<td><b><?php echo L('meta_description')?>：</b><br>
		<input name='setting[<?php echo $catid;?>][meta_description]' type='text' value='<?php echo $cat['setting']['meta_description'];?>' style='width:250px'>
		  </td>
	<?php
		}
	?>
	 </tr>

    </tbody>
    </table>
    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="hidden" name="type" value="<?php echo $type;?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" /></div>
	<BR><BR>
</div>
</div>
</div>
</form>

<script language="JavaScript">
<!--
$(document).keydown(function(event) {
	   if(event.keyCode==37) {
		   window.scrollBy(-100,0);
	   } else if(event.keyCode==39) {
		  window.scrollBy(100,0);
	   }
	});

function change_radio(oEvent,boxid,value,type) {
	altKey = oEvent.altKey;
	if(altKey) {
		var obj = $("input[boxid="+boxid+"][value="+value+"]");
		obj.attr('checked',true);
		if(type){
			obj.each(function(){
				urlrule(type,value,$(this).attr('catid'));
			})
		}
	}
}

window.top.$('#display_center_id').css('display','none');
function urlrule(type,html,catid) {
	if(type=='category') {
		if(html) {
			$('#category_php_ruleid'+catid).css('display','none');$('#category_html_ruleid'+catid).css('display','');
		} else {
			$('#category_php_ruleid'+catid).css('display','');$('#category_html_ruleid'+catid).css('display','none');;
		}
	} else {
		if(html) {
			$('#show_php_ruleid'+catid).css('display','none');$('#show_html_ruleid'+catid).css('display','');
		} else {
			$('#show_php_ruleid'+catid).css('display','');$('#show_html_ruleid'+catid).css('display','none');;
		}
	}
}
function load_file_list(id,catid) {
	if(id=='') return false;
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&batch_str=1&style='+id+'&catid='+catid, function(data){
	if(data==null) return false;
	$('#category_template'+catid).html(data.category_template);$('#list_template'+catid).html(data.list_template);$('#show_template'+catid).html(data.show_template);});
}
//-->
</script>
</body>
</html>
