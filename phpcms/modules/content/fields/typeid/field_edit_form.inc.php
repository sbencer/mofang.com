<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="96%">
	<tr> 
      <td>默認值</td>
      <td>
	  <input type="hidden" name="setting[minnumber]" value="<?php echo $setting['minnumber'];?>">
	  <input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="input-text"> 正整數 最大長度 5 </td>
    </tr>
</table>