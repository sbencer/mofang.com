<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%">
	<tr> 
      <td>地圖接口選擇</td>
      <td>
	  <input type="radio" name="setting[maptype]" value="2" <?php if($setting['maptype']==2) echo 'checked';?>> 百度地圖

	  </td>
    </tr>	
	<tr> 
      <td>地圖API Key </td>
      <td><input type="text" name="setting[api_key]" value="<?php echo $setting['api_key'];?>" size="30" class="input-text"></td>
    </tr>	
	<tr> 
      <td>默認城市</td>
      <td><input type="text" name="setting[defaultcity]" value="<?php echo $setting['defaultcity'];?>" size="30" class="input-text"></td>
    </tr>
	<tr> 
      <td width="100">熱門城市</td>
      <td>
	  <textarea style="height:100px;width:100px;" id="options" cols="20" rows="2" name="setting[hotcitys]"><?php echo $setting['hotcitys'];?></textarea> 多個城市請使用半角逗號分隔</td>
    </tr>	
	<tr> 
      <td>地圖尺寸 </td>
      <td>
	  寬度: <input type="text" name="setting[width]" value="<?php echo $setting['width'];?>" size="10" class="input-text">px 
	  高度: <input type="text" name="setting[height]" value="<?php echo $setting['height'];?>" size="10" class="input-text">px
	  </td>
    </tr>		
</table>