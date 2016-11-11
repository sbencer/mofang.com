<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">取值範圍</td>
      <td><input type="text" name="setting[minnumber]" value="1" size="5" class="input-text"> - <input type="text" name="setting[maxnumber]" value="" size="5" class="input-text"></td>
    </tr>
	<tr> 
      <td>小數位數：</td>
      <td>
	  <select name="setting[decimaldigits]">
	  <option value="-1">自動</option>
	  <option value="0" selected>0</option>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
	  </select>
    </td>
    </tr>
	<tr> 
      <td>默認值</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo $defaultvalue?>" size="40" class="input-text"></td>
    </tr>

	<tr> 
	  <td>是否作為區間字段</td>
	  <td>
	  <input type="radio" name="setting[rangetype]" value="1"/> 是 
	  <input type="radio" name="setting[rangetype]" value="0" checked />否 　　注：區間字段可以通過filters('字段名稱','模型id','自定義數組')調用
	  </td>
	</tr>	
</table>