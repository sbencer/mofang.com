<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');

if(isset($_GET['action'])){
	$value = $_GET['value'];
?>
<form method="post" action="?m=admin&c=linktag&a=tag_update" id="myform" name="myform">
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li onclick="SwapTab('setting','on','',6,1);" class="on" id="tab_setting_1">基本選項</li>
</ul>
<div class="contentList pad-10" id="div_setting_1">
<table width="100%" class="table_form ">
	<tbody>
		<tr>
         <?php echo L('linktag_name');?>： <input type="text" readonly name="old_name" class="tag_in" value="<?php echo $value;?>" /> <?php echo L('linktag_rename');?>: <input type="text" name="tag_name" value="">
		<span style="display:none;color:red;font-size:10px" id="tag_tip">該標簽已存在</span>
		<span style="display:none;color:red;font-size:10px" id="tag_tip2"></span>	
		</tr><br>
		<tr> 
		<?php echo L('chose_item');?>： <select name='parent_id' id="">
					<option value="0">作為一級分類</option>
					<?php echo $item;?>
					</select>
		</tr><br>
		<input type="submit" class="button" name="submit" onclick="tag_updata()" value="提交" />
	</tbody>
</table>
</div></div></div>

<input type="hidden" name="pc_hash" value="kMr4sv" />
</form>
<?php
}else{
?>
<form name="myform" action="?m=admin&c=linktag&a=tag_list" method="post">
<div class="pad_10">
<div class="bk10"></div>
<div class="table-list">
    <table width="100%" cellspacing="0" >
  
    <?php echo $str;?>
 
    </table>
    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div> 
</div>
</div>
</div>
</form>
<?php } ?>
<script language="JavaScript">
//標簽禁用
function tag_delete(obj){
	var obj = $(obj);
	var a = "<?php echo $_SESSION['pc_hash'];?>";			
	var r = confirm("確認？");
	var tag_name = obj.parent().siblings('.tag_name').html();				
	if (r == true){	 
		$.post('index.php?m=admin&c=linktag&a=tag_delete',({'pc_hash':a,'tag_name':tag_name}),function(data){
				document.write(data);				
		});
	}
}
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
</body>
</html>
