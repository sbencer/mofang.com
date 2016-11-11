<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>菜單ID</td>
      <td><input type="text" id="linkageid" name="setting[linkageid]" value="<?php echo $setting['linkageid'];?>" size="5"> 
	  <input type='button' value="在列表中選擇" onclick="omnipotent('selectid','?m=admin&c=linkage&a=public_get_list','在列表中選擇')" class="button">
		請到導航 擴展 > 聯動菜單 > 添加聯動菜單</td>
    </tr>
	<tr>
	<td>顯示方式</td>
	<td>
      	<input name="setting[showtype]" value="0" type="radio" <?php if($setting['showtype']==0) echo 'checked';?>>
        只顯示名稱
        <input name="setting[showtype]" value="1" type="radio" <?php if($setting['showtype']==1) echo 'checked';?>>
        顯示完整路徑  
        <input name="setting[showtype]" value="2" type="radio" <?php if($setting['showtype']==2) echo 'checked';?>>
        返回聯動菜單id 		
	</td></tr>
	<tr> 
      <td>路徑分隔符</td>
      <td><input type="text" name="setting[space]" value="<?php echo $setting['space'];?>" size="5" class="input-text"> 顯示完整路徑時生效</td>
    </tr>	
</table>