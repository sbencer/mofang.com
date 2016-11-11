<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>允許上傳的文件類型</td>
      <td>
      	<input type="radio" name="setting[upload_allowext]" value="apk" size="40" class="input-text" checked>安卓apk&nbsp;
      	<input type="radio" name="setting[upload_allowext]" value="ipa" size="40" class="input-text">蘋果ipa&nbsp;
      	<input type="radio" name="setting[upload_allowext]" value="xap" size="40" class="input-text">微軟xap&nbsp;
      </td>
    </tr>
	<tr> 
      <td>是否從已上傳中選擇</td>
      <td><input type="radio" name="setting[isselectfile]" value="1"> 是 <input type="radio" name="setting[isselectimage]" value="0" checked> 否</td>
    </tr>
	<tr> 
      <td>允許同時上傳的個數</td>
      <td><input type="text" name="setting[upload_number]" value="10" size=3></td>
    </tr>
	<tr>
	<td>附件下載方式</td>
	<td>
      	<input name="setting[downloadlink]" value="0" type="radio">
        鏈接到真實軟件地址 
        <input name="setting[downloadlink]" value="1" checked="checked" type="radio">
        鏈接到跳轉頁面
      
	</td></tr>	
	<tr>
	<td>文件下載方式</td>
	<td>
      	<input name="setting[downloadtype]" value="0" type="radio">
        鏈接文件地址 
        <input name="setting[downloadtype]" value="1" checked="checked" type="radio">
        通過PHP讀取      
	</td></tr>		
</table>