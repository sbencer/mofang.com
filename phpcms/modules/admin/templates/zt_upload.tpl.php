<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<table width="500" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td><div class="explain-col" style="border:1px solid #8D7862;margin-bottom:5px;"> 
		<a href="?m=admin&c=ztzip&a=show_rec" >查看記錄</a>
		</div>
		</td>
		</tr>
        <tr style=" ">     
             <td>
                 <div style="border:1px solid #8D7862;margin-bottom:5px;" class="explain-col"> 
                     <p>需要注意:</p>
                     <p style="color:red">1,壓縮包格式必須為zip格式</p>
                     <p style="color:red">2,壓縮包名不能又特殊符號</p>
                     <br>
                     <p>下載參考壓縮包:    <a href="abc.zip" title="參考壓縮包">abc.zip</a></p>
                 </div>
             </td>
         </tr>
    </tbody>
</table>
<form name="myform" id="myform" action="?m=admin&c=ztzip&a=zt_upload" method="post" enctype="multipart/form-data" >
<input type="hidden" name="zt_name" size="20" value="<?php echo $_GET['zt_name'];?>">	
<div class="table-list">
<table width="500" cellspacing="0">	
<tbody>
<tr>
<td align="center" width="10%"><?php echo L('username')?>:</td>
<td align="left" width="10%"><?php echo $userinfo['username']?></td>
<td align="center" width="10%"></td>
</tr>
<tr>
<td align="center" width="10%"><?php echo L('email')?>:</td>
<td align="left" width="10%"><?php echo $userinfo['email']?></td>
<td align="center" width="10%"></td>
</tr>
<tr>
<td align="center" width="10%"><?php echo L('is_ren')?>:</td>
<td align="left" width="10%"><input type="radio" name="zt_ren" value="1"><?php echo L('cover')?> &nbsp;&nbsp;<input type="radio" name="zt_ren" value="0"><?php echo L('edit_name')?></td>
<td align="center" width="10%"></td>
</tr>
<tr style="display:none">
<td align="center" width="10%"><?php echo L('new_name')?>:</td>
<td align="left" width="10%"><input type="text" name="zt_new_name" value=""></td>
<td align="center" width="10%"></td>
</tr>
<tr>
<td align="center" width="10%"><?php echo L('plan_file')?>:</td>
<td align="left" width="10%"><input type="file" name="file_upload" value=""></td>
<td align="center" width="10%"></td>
</tr>
<tr>
<td align="center" width="10%"> </td>
<td align="left" width="10%"><input type="submit" name="dosubmit" id="dosubmit" value="確定提交"></td>
<td align="center" width="10%"></td>
</tr>
</tbody>
</table>
</div>
</form>
</div>
<script type="text/javascript">
$(function(){
	$("form[name='myform']").find("input[name='zt_ren']").click(function(){
		if($(this).val() !=1){
		$(this).parent("td").parent("tr").next("tr").css("display","table-row");
		}else{
		$(this).parent("td").parent("tr").next("tr").css("display","none");
		}
	});
});
</script>
</body>
</html>
