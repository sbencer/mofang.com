<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">輸入框大小</td>
      <td><input type="text" name="setting[size]" value="<?php echo $setting['size'];?>" size="6" class="input-text"></td>
    </tr>
    <tr> 
      <td width="100">默認行為</td>
      <td>
      	<input type="radio" name="setting[action]" value="1" <?php if($setting['action'] == 1) echo 'checked';?>>轉向&nbsp;
      	<input type="radio" name="setting[action]" value="0" <?php if($setting['action'] == 0) echo 'checked';?>>不轉向
      </td>
    </tr>
</table>