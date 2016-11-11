<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">取值範圍</td>
      <td><input type="text" name="setting[minnumber]" value="<?php echo $setting['minnumber'];?>" size="5" class="input-text"> - <input type="text" name="setting[maxnumber]" value="<?php echo $setting['maxnumber'];?>" size="5" class="input-text"></td>
    </tr>
	<tr> 
      <td>小數位數：</td>
      <td>
	  <select name="setting[decimaldigits]">
	  <option value="-1" <?php if($setting['decimaldigits']==-1) echo 'selected';?>)>自動</option>
	  <option value="0" <?php if($setting['decimaldigits']==0) echo 'selected';?>>0</option>
	  <option value="1" <?php if($setting['decimaldigits']==1) echo 'selected';?>>1</option>
	  <option value="2" <?php if($setting['decimaldigits']==2) echo 'selected';?>>2</option>
	  <option value="3" <?php if($setting['decimaldigits']==3) echo 'selected';?>>3</option>
	  <option value="4" <?php if($setting['decimaldigits']==4) echo 'selected';?>>4</option>
	  <option value="5" <?php if($setting['decimaldigits']==5) echo 'selected';?>>5</option>
	  </select>
    </td>
    </tr>
	<tr> 
      <td>輸入框長度</td>
      <td><input type="text" name="setting[size]" value="<?php echo $setting['size'];?>" size="3" class="input-text"> px</td>
    </tr>
	<tr> 
      <td>默認值</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $setting['defaultvalue'];?>" size="40" class="input-text"></td>
    </tr>
	<tr> 
	  <td>是否作為區間字段</td>
	  <td>
	  <input type="radio" name="setting[rangetype]" value="1" <?php if($setting['rangetype']) echo 'checked';?> /> 是 
	  <input type="radio" name="setting[rangetype]" value="0" <?php if(!$setting['rangetype']) echo 'checked';?> /> 否 　　注：區間字段可以通過filters('字段名稱','模型id','自定義數組')調用
	  </td>
	</tr>		
</table>