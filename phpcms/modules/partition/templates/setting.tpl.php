<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
<form action="?m=partition&c=partition&a=setting" method="post" id="myform">
<fieldset>
	<legend>通用浮窗配置</legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="120">是否顯示：</th>
    <td class="y-bg"><input type="checkbox" name="setting[is_partition]" value="1" <?php if ($setting['is_partition']==1){echo 'checked';}?> /></td>
  </tr> 
  <tr>
    <th width="120">浮窗<font color=red>圖片</font>配置： </th>
    <td class="y-bg"> </td>
  </tr>


        <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[floating][0][name]' value="<?php echo $setting['floating'][0]['name'];?>" type='text' style='width:120px;'/>
                <?php 
                    $topic_pic_0 = $setting['floating'][0]['pic'];
                    $curr_form_html = form::images_partition('setting[floating][0][pic]', 'floating_pic1', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[floating][0][link]' value="<?php echo $setting['floating'][0]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

   <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[floating][1][name]' value="<?php echo $setting['floating'][1]['name'];?>" type='text' style='width:120px;'/>
                <?php 
                    $topic_pic_0 = $setting['floating'][1]['pic'];
                    $curr_form_html = form::images_partition('setting[floating][1][pic]', 'floating_pic2', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[floating][1][link]' value="<?php echo $setting['floating'][1]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

         <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[floating][2][name]' value="<?php echo $setting['floating'][2]['name'];?>" type='text' style='width:120px;'/>
                <?php 
                    $floating_0 = $setting['floating'][2]['pic'];
                    $curr_form_html = form::images_partition('setting[floating][2][pic]', 'floating_pic3', $floating_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[floating][2][link]' value="<?php echo $setting['floating'][2]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

  <tr>
    <th width="120">浮窗<font color=red>文字</font>配置： ：</th>
    <td class="y-bg"> </td>
  </tr>

  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article][0][name]' value="<?php echo $setting['floating_article'][0]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article][0][link]' value="<?php echo $setting['floating_article'][0]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 


  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article][1][name]' value="<?php echo $setting['floating_article'][1]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article][1][link]' value="<?php echo $setting['floating_article'][1]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 


  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article][2][name]' value="<?php echo $setting['floating_article'][2]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article][2][link]' value="<?php echo $setting['floating_article'][2]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 


</table>

<div class="bk15"></div>
<input type="submit" id="dosubmit" name="dosubmit" class="button" value="<?php echo L('submit')?>" />
</fieldset>
</form>
</div>
</body>
</html>