<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>菜單ID</td>
      <td><input type="text" id="linkageid" name="setting[linkageid]" value="0" size="5" class="input-text"> 
	  <input type='button' value="在列表中選擇" onclick="omnipotent('selectid','?m=admin&c=linkage&a=public_get_list','在列表中選擇')" class="button">
		請到導航 擴展 > 聯動菜單 > 添加聯動菜單</td>
    </tr>
	<tr>
	<td>顯示方式</td>
	<td>
      	<input name="setting[showtype]" value="0" type="radio">
        只顯示名稱
        <input name="setting[showtype]" value="1" type="radio">
        顯示完整路徑  
        <input name="setting[showtype]" value="2" type="radio">
        返回菜單id		
	</td></tr>
	<tr> 
      <td>路徑分隔符</td>
      <td><input type="text" name="setting[space]" value="" size="5" class="input-text"> 顯示完整路徑時生效</td>
    </tr>		
</table>