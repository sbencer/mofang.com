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
      <td><input type="text" name="setting[defaultvalue]" value="<?=$defaultvalue?>" size="40" class="input-text"></td>
    </tr>
</table>