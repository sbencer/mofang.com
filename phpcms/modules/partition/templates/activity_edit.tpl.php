<?php 
defined('IN_ADMIN') or exit('No permission resources.'); 
$show_header = 1;
include $this->admin_tpl('header','admin');
?>

<div class="subnav"> 
    <div class="content-menu ib-a blue line-x">
        <a class="add fb" href="?m=partition&c=activity&a=add&menuid=&catid=<?php echo $_GET['catid'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>"><em><?php echo L('add_activity');?></em></a> | 
        <a class="fb" href="?m=partition&c=activity&a=init&catid=<?php echo $_GET['catid']; ?>"><em><?php echo '返回活動列表';?></em></a>
    </div>
</div>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>mofang/colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>mofang/hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>mofang/cookie.js"></script>
<div class="pad-10">
<form method="post" action="?m=partition&c=activity&a=edit&pc_hash=<?php echo $_SESSION['pc_hash'];?>" name="myform" id="myform" enctype="multipart/form-data">

	<table class="table_form" width="100%" cellspacing="0">
    <input name="activity[id]" type="hidden" value="<?php echo $_GET['id']?>">
	<tbody>
		<tr>
			<th width="80"><strong><?php echo L('activety_title')?>：</strong></th>
			<td><input name="activity[title]" id="title" class="input-text" type="text" size="30" value="<?php echo $info['title']?>"></td>
			<td></td>
		</tr>

        <tr>
            <th>活動圖片：</th>
            <td>
                <?php
                    $activity_image = form::images_partition('activity[image]', 'web_background', $info['image'], 'image','','','input-text');
                    echo $activity_image;
                ?>
            </td>
        </tr>

		<tr>
			<th width="60"><strong><?php echo L('activity_url')?>：</strong></th>
			<td><input name="activity[url]" id="title" class="input-text" type="text" size="30" value="<?php echo $info['url']?>"></td>
			<td></td>
		</tr>

		<tr>
			<th width="60"><strong><?php echo L('activity_url')?>：</strong></th>
			<td>
            <select name="activity[circle]">
                <option value ="9" <?php if($info['circle'] == 9) echo 'selected';?>>非週期</option>
                <option value ="1" <?php if($info['circle'] == 1) echo 'selected';?>>星期一</option>
                <option value ="2" <?php if($info['circle'] == 2) echo 'selected';?>>星期二</option>
                <option value ="3" <?php if($info['circle'] == 3) echo 'selected';?>>星期三</option>
                <option value ="4" <?php if($info['circle'] == 4) echo 'selected';?>>星期四</option>
                <option value ="5" <?php if($info['circle'] == 5) echo 'selected';?>>星期五</option>
                <option value ="6" <?php if($info['circle'] == 6) echo 'selected';?>>星期六</option>
                <option value ="7" <?php if($info['circle'] == 7) echo 'selected';?>>星期日</option>
            </select>
            </td>
			<td></td>
		</tr>

		<tr>
			<th width="60"><strong><?php echo L('activity_limit')?>：</strong></th>
            <td><input name="activity[limit_time]" <?php if(!empty($info['limit_time'])) echo "checked";?> type="checkbox"/></td>
		</tr>

		<tr>
			<th><strong><?php echo L('startdate')?>：</strong></th>
			<td><?php echo form::date('activity[start_time]', date('Y-m-d H:i:s', $info['start_time']), 1)?></td>
			<td></td>
		</tr>

		<tr>
			<th><strong><?php echo L('enddate')?>：</strong></th>
			<td><?php echo form::date('activity[end_time]', date('Y-m-d H:i:s', $info['end_time']), 1);?></td>
			<td></td>
		</tr>
		
	</tbody>
	</table>

	<div style="margin-top:20px;margin-left:20px;">
		<input type="submit" name="dosubmit" id="dosubmit" value=" <?php echo L('ok')?> " class="button">
		<input type="reset" class="button" value=" <?php echo L('clear')?> ">
	</div>
</form>


</div>

</body>
</html>
<script type="text/javascript">
function load_file_list(id) {
	if (id=='') return false;
	$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&module=announce&templates=show&name=announce&pc_hash='+pc_hash, function(data){$('#show_template').html(data.show_template);});
}

$(document).ready(function(){
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
	$('#"title"').formValidator({onshow:"<?php echo L('input_privilege_title')?>",oncorrect:"<?php echo L('right')?>"}).inputValidator({min:1,onerror:"<?php echo L('title_cannot_empty')?>"});
	
});
</script>
