<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('payment_mode').L('name')?>",onfocus:"<?php echo L('payment_mode').L('name').L('empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('payment_mode').L('name').L('empty')?>"});
})
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=pay&c=payment&a=<?php echo $_GET['a']?>" method="post" id="myform">
<fieldset>
<legend><?php echo L('說明')?></legend>
<?php if($pay_name =='支付寶'){?>
<table width="100%" class="table_form" id="taobao">
<tr><td>
<img src="<?php echo IMG_PATH;?>taobao_log.png">支付寶為國內領先的支付平台!<br>
PHPCMS聯合支付寶推出優惠套餐：無預付/年費，單筆費率階梯0.7%-1.2%，無流量限制。交易越多，費率越低！<br><br>
<a href="https://www.alipay.com/" style="color:red;" target="_blank">了解詳情</a>  <a href="http://help.alipay.com/support/help_detail.htm?help_id=241435" style="color:red;" target="_blank">如何簽約</a><br><br>
<a href=" http://fun.alipay.com/xtsz/phpcms.htm" target="_blank" title="點擊申請"><img src="<?php echo IMG_PATH;?>taobao_sq.jpg"></a><br>
已經簽約的用戶，可直接在下方填寫相關賬號信息即可。
</td></tr>
</table>
<?php }?>

<?php if($pay_name =='盛付通'){?>
<table width="100%" class="table_form" id="taobao">
<tr><td>
<img src="<?php echo IMG_PATH;?>snda_log.jpg">盛付通是盛大網絡創辦的中國領先的在線支付平台，致力於為互聯網用戶和企業提供便捷、安全的支付服務。通過與各大銀行、通信服務商等簽約合作，提供具備相當實力和信譽保障的支付服務！<a href="http://zhuanye.shengpay.com/SP/Business/quicklygather.aspx" style="color:red;" target="_blank">前往了解詳情！</a><br><br> 
<a href="http://zhuanye.shengpay.com/ProLogin.aspx" target="_blank" title="點擊申請"><img src="<?php echo IMG_PATH;?>taobao_sq.jpg"></a><br><br>
已經簽約的用戶，可直接在下方填寫相關賬號信息即可。
</td></tr>
</table>
<?php }?>

</fieldset>
<div class="bk15"></div>
<fieldset>
<legend><?php echo L('parameter_config')?></legend>
<table width="100%" class="table_form">
<tr>
<td  width="120"><?php echo L('payment_mode')?></td> 
<td><?php echo $pay_name?></td>
</tr>
<tr>
<td  width="120"><?php echo L('payment_mode').L('name')?></td> 
<td><input type="text" name="name" value="<?php echo $name ? $name : $pay_name?>" class="input-text" id="name"></input></td>
</tr>

<?php foreach ($config as $conf => $name) {?>
 <tr>
  <td><?php echo $name['name']?></td>
	<td>
	<?php if($name['type'] == 'text'){?>
	<input type="text"  class="input-text" name="config_value[]" id="<?php echo $conf?>" value="<?php echo $name['value']?>" size="40"></input>
	<?php } elseif($name['type'] == 'select') { ?>
		<select name="config_value[]" value="0">
		 <?php foreach ($name['range'] as $key => $v) {?>
		<option value="<?php echo $key?>" <?php if($key == $name['value']){ ?> selected="" <?php } ?> ><?php echo $v?></option>
		 <?php }?>
		</select>
	<?php }?>
	<input type="hidden" value="<?php echo $conf?>" name="config_name[]"/>
	</td>
 </tr>
<?php }?>

<tr>
<td><?php echo L('payment_mode').L('desc')?></td> 
<td>
<textarea name="description" rows="2" cols="10" id="description" class="inputtext" style="height:100px;width:300px;"><?php echo $pay_desc?></textarea>
<?php echo form::editor('description', 'desc');?>
</td>
</tr>
<tr>
<td  width="120"><?php echo L('listorder')?></td> 
<td><input type="text" name="pay_order" value="<?php echo $pay_order?>" class="input-text" id="pay_order" size="3"></input></td>
</tr>
<tr>
<td  width="120"><?php echo L('online')?>?</td> 
<td><?php echo $is_online ? L('yes'):L('no')?></td>
</tr>
<tr>
<td  width="120"><?php echo L('pay_factorage')?>：</td> 
<td id="paymethod"><input name="pay_method" value="0" type="radio" <?php echo ($pay_method == 1) ? '': 'checked'?>> <?php echo L('pay_method_rate')?>&nbsp;&nbsp;&nbsp;<input name="pay_method" value="1" type="radio" <?php echo ($pay_method == 0) ? '': 'checked'?>> <?php echo L('pay_method_fix')?>&nbsp;&nbsp;&nbsp; </td>
</tr>
<tr><td></td>
<td>
<div id="rate" <?php echo ($pay_method == 0) ? '': 'class="hidden"'?>>
<?php echo L('pay_rate')?><input type="text" size="3" value="<?php echo $pay_fee?>" name="pay_rate">&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;<?php echo L('pay_method_rate_desc')?>
</div>
<div id="fix" <?php echo ($pay_method == 1) ? '': 'class="hidden"'?>>
<?php echo L('pay_fix')?><input type="text" name="pay_fix" size="3" value="<?php echo $pay_fee?>">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo L('pay_method_fix_desc')?>
</div>
</td>
</tr>
	</table>
</fieldset>

    <div class="bk15"></div>
	<input type="hidden"  name="pay_name" value="<?php echo $pay_name?>" />
	<input type="hidden"  name="pay_id" value=<?php echo $pay_id?> />
	<input type="hidden"  name="pay_code" value=<?php echo $pay_code?> />
	<input type="hidden"  name="is_cod" value=<?php echo $is_cod?> />
	<input type="hidden"  name="is_online" value=<?php echo $is_online?> />
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog" id="dosubmit">
</form>
</div></div>
</body>
</html>
<script type="text/javascript">

$(document).ready(function() {
	$("#paymethod input[type='radio']").click( function () {
		if($(this).val()== 0){
			$("#rate").removeClass('hidden');
			$("#fix").addClass('hidden');
			$("#rate input").val('0');
		} else {
			$("#fix").removeClass('hidden');
			$("#rate").addClass('hidden');
			$("#fix input").val('0');
		}	
	});
});
function category_load(obj)
{
	var modelid = $(obj).attr('value');
	$.get('?m=admin&c=position&a=public_category_load&modelid='+modelid,function(data){
			$('#load_catid').html(data);
		  });
}
</script>

