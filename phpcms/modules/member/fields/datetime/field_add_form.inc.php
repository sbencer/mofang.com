<table cellpadding="2" cellspacing="1" bgcolor="#ffffff">
	<tr> 
      <td><strong>時間格式：</strong></td>
      <td>
	  <input type="radio" name="setting[fieldtype]" value="date" checked>日期（<?php echo date('Y-m-d');?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="datetime_a">日期+12小時制時間（<?php echo date('Y-m-d h:i:s');?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="datetime">日期+24小時制時間（<?php echo date('Y-m-d H:i:s');?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="int">整數 顯示格式：
	  <select name="setting[format]">
	  <option value="Y-m-d Ah:i:s">12小時制:<?php echo date('Y-m-d h:i:s');?></option>
	  <option value="Y-m-d H:i:s">24小時制:<?php echo date('Y-m-d H:i:s');?></option>
	  <option value="Y-m-d H:i"><?php echo date('Y-m-d H:i');?></option>
	  <option value="Y-m-d"><?php echo date('Y-m-d');?></option>
	  <option value="m-d"><?php echo date('m-d');?></option>
	  </select>
	  </td>
    </tr>
	<tr> 
      <td><strong>默認值：</strong></td>
      <td>
	  <input type="radio" name="setting[defaulttype]" value="0" checked/>無<br />
	 </td>
    </tr>
</table>