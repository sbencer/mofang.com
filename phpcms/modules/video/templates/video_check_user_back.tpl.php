<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>member_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	 $("#email").formValidator({onshow:"請輸入E-mail",onfocus:"請輸入E-mail",oncorrect:"E-mail格式正確"}).regexValidator({regexp:"email",datatype:"enum",onerror:"E-mail格式錯誤"});
})
//-->
</script>
<div class="pad-10">
<div class="explain-col search-form">
<font color="#cc0000"><?php echo L('1、當前域名已經登記，請輸入初始完善資料時填寫的EMAIL，進行驗證碼驗證！<br> 2、你也可以直接填寫對應的配置信息，進行提交！');?></font>
</div>

<div class="common-form">
<form name="myform" action="?m=video&c=video&a=check_user_back&pc_hash=<?php echo $_GET['pc_hash'];?>" method="post" id="myform">
<fieldset>
	<legend><?php echo L('開通方式1：郵箱驗證');?></legend>
<table width="100%" class="table_form">
	<tr>
		<td  width="120"><?php echo L('email');?></td> 
		<td>
		<input name="email"  type="text" id="email"  size="40" value="">
		<input type="button" onclick="send_code()" value="<?php echo L('發送驗證碼')?>" class="button" name="sendcode" id="sendcode"> 
		</td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('驗證碼');?><div id="all"></div>  </td> 
		<td><input type="text" name="code" size="40" value="" id="code"></td>
	</tr> 
	<tr>
		<td  width="120"></td> 
		<td><input name="dosubmit_new" type="submit" value=" <?php echo L('submit')?> " class="button" id="dosubmit_new"></td>
	</tr> 
</table>
</fieldset>

</form>

<!--填寫skey_sn-->
<br>
<form name="myform2" action="?m=video&c=video&a=setting&pc_hash=<?php echo $_GET['pc_hash'];?>" method="post" id="myform2">
<fieldset>
	<legend><?php echo L('開通方式2：配置完善');?></legend>
<table width="100%" class="table_form">
	<tr>
		<td  width="120"><?php echo L('vms_sn');?></td> 
		<td><input name="setting[sn]"  type="text" id="sn"  size="40" value=""> </td>
	</tr>
	<tr>
		<td  width="120"><?php echo L('vms_skey');?></td> 
		<td><input type="text" name="setting[skey]" size="40" value="" id="skey"></td>
	</tr> 
	<tr>
		<td  width="120"><?php echo L('video_api_url');?> </td> 
		<td><?php echo APP_PATH;?>api.php?op=video_api</td>
	</tr>
	<tr>
		<td  width="120"></td> 
		<td><input name="dosubmit" type="submit" value=" <?php echo L('submit')?> " class="button" id="dosubmit">
</td>
	</tr> 
</table>
</fieldset>

</form>
</div>
<script type="text/javascript">
<!--
function send_code() {
	var email = $("#email").val(); 
	var pc_hash = "<?php echo $_GET['pc_hash'];?>";
	if(email==''){
		alert('email 不能為空！');return false;
	}
	$.get('?m=video&c=video&a=send_code&pc_hash='+pc_hash,{ email:email,random:Math.random()}, function(data){
		if(data==1) { 
			$("#sendcode").attr("disabled", true);
			$("#sendcode").val('驗證碼已發送!');
			alert('驗證碼發送成功，請查收！'); 
		}else{
  			alert("驗證碼發送失敗，請檢測郵箱是否正確！");
		}
	}); 
} 
//-->
</script>
</body>
</html>