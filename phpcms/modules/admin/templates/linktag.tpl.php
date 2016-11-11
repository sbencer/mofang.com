<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<form name="myform" action="?m=admin&c=linktag&a=tag_list" method="post">
<div class="pad_10">
<div class="bk10"></div>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th width="38"><?php echo L('listorder');?></th>
            <th>tag_id</th>
            <th><?php echo L('item_tag_name');?></th>
            <th ><?php echo L('linktag_name');?></th>
            <th align='center' ><?php echo L('linktag_use_count');?></th>         
			<th ><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php echo $str;?>
    </tbody>
    </table>
    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</div>
</div>
</form>
<script language="JavaScript">
//標簽恢復使用
function tag_recover(obj){
	var obj = $(obj);
	var  a = "<?php echo $_SESSION['pc_hash'];?>";
	var tag_name = obj.parent().siblings('.tag_name').html();						
	$.post('index.php?m=admin&c=linktag&a=tag_recover',({'pc_hash':a,'tag_name':tag_name}),function(data){
				document.write(data);					
			});		 		
}
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>
