<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td width="100">選項列表</td>
      <td><textarea name="setting[options]" rows="2" cols="20" id="options" style="height:100px;width:400px;">選項名稱1|選項值1</textarea></td>
    </tr>
	<tr> 
      <td>選項類型</td>
      <td>
	  <input type="radio" name="setting[boxtype]" value="radio" checked onclick="$('#setcols').show();$('#setsize').hide();"/> 單選按鈕 
	  <input type="radio" name="setting[boxtype]" value="checkbox" onclick="$('#setcols').show();$('setsize').hide();"/> 復選框 
	  <input type="radio" name="setting[boxtype]" value="select" onclick="$('#setcols').hide();$('setsize').show();" /> 下拉框 
	  <input type="radio" name="setting[boxtype]" value="multiple" onclick="$('#setcols').hide();$('setsize').show();" /> 多選列表框
	  </td>
    </tr>
	<tr> 
      <td>字段類型</td>
      <td>
	  <select name="setting[fieldtype]" onchange="javascript:fieldtype_setting(this.value);">
	  <option value="varchar">字符 VARCHAR</option>
	  <option value="tinyint">整數 TINYINT(3)</option>
	  <option value="smallint">整數 SMALLINT(5)</option>
	  <option value="mediumint">整數 MEDIUMINT(8)</option>
	  <option value="int">整數 INT(10)</option>
	  </select> <span id="minnumber" style="display:none"><input type="radio" name="setting[minnumber]" value="1" checked/> <font color='red'>正整數</font> <input type="radio" name="setting[minnumber]" value="-1" /> 整數</span>
	  </td>
    </tr>
<tbody id="setcols" style="display:">
	<tr> 
      <td>每列寬度</td>
      <td><input type="text" name="setting[width]" value="100" size="5" class="input-text"> px</td>
    </tr>
</tbody>
<tbody id="setsize" style="display:none">
	<tr> 
      <td>高度</td>
      <td><input type="text" name="setting[size]" value="1" size="5" class="input-text"> 行</td>
    </tr>
</tbody>
	<tr> 
      <td>默認值</td>
      <td><input type="text" name="setting[defaultvalue]" size="40" class="input-text"></td>
    </tr>
	<tr> 
      <td>輸出格式</td>
      <td>
	  <input type="radio" name="setting[outputtype]" value="1" checked /> 輸出選項值 
	  <input type="radio" name="setting[outputtype]" value="0" /> 輸出選項名稱
	  </td>
    </tr>
</table>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function fieldtype_setting(obj) {
	if(obj!='varchar') {
		$('#minnumber').css('display','');
	} else {
		$('#minnumber').css('display','none');
	}
}
//-->
</SCRIPT>