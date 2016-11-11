<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">文本框長度</td>
      <td><input type="text" name="setting[size]" value="<?php echo $setting['size'];?>" size="10" class="input-text"><div class="onShow">默認值請用', '隔開，即使一個默認值也需要分隔</div></td>
    </tr>
	<tr> 
      <td>默認值</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="118" class="input-text"></td>
    </tr>
</table>