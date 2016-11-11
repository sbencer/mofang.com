<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr>
      <td width="100">可關聯的模型ID</td>
      <td><input type="text" name="setting[modelids]" value="<?php echo $setting['modelids'];?>" size="50" class="input-text"> <br />
	  多個模型ID間請用 , 隔開</td>
    </tr>
</table>