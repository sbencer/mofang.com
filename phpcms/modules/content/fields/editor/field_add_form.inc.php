<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">編輯器樣式：</td>
      <td><input type="radio" name="setting[toolbar]" value="basic" checked> 簡潔型 <input type="radio" name="setting[toolbar]" value="full"> 標準型 </td>
    </tr>
	<tr> 
      <td>默認值：</td>
      <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:100px;width:250px;"></textarea></td>
    </tr>
	<tr> 
      <td>是否啟用關聯鏈接：</td>
      <td><input type="radio" name="setting[enablekeylink]" value="1"> 是 <input type="radio" name="setting[enablekeylink]" value="0" checked> 否  <input type="text" name="setting[replacenum]" value="1" size="4" class="input-text"> 替換次數 （留空則為替換全部）</td>
    </tr>
	<tr> 
      <td>關聯鏈接方式：</td>
      <td><input type="radio" name="setting[link_mode]" value="1" <?php if($setting['link_mode']==1) echo 'checked';?>> 關鍵字鏈接 <input type="radio" name="setting[link_mode]" value="0" <?php if($setting['link_mode']==0) echo 'checked';?>> 網址鏈接  </td>
    </tr>
	<tr> 
      <td>是否保存遠程圖片：</td>
      <td><input type="radio" name="setting[enablesaveimage]" value="1"> 是 <input type="radio" name="setting[enablesaveimage]" value="0" checked> 否</td>
    </tr>
	<tr> 
      <td>編輯器默認高度：</td>
      <td><input type="text" name="setting[height]" value="200" size="4" class="input-text"> px</td>
    </tr>
</table>