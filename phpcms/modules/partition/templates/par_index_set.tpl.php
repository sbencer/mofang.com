<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>

<div class="pad-10">
<form action="?m=partition&c=partition&a=par_game_seting" method="post" id="myform">
<fieldset>
	<legend>首頁通用浮窗配置</legend>
	<table width="100%"  class="table_form">
    <tr>
    <th width="120">是否顯示：</th>
    <td class="y-bg"><input type="checkbox" name="setting[is_partition]" value="1" <?php if ($setting['is_partition']==1){echo 'checked';}?> /></td>
  </tr> 
  <!--遊戲信息配置開始-->
  <tr>
    <th width="120">左遊戲信息<font color=red>詳細</font>配置： </th>
    <td class="y-bg"> </td>
  </tr>
   <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                遊戲名:<input name='setting[ganme_name][name]' value="<?php echo $setting['ganme_name']['name'];?>" type='text' style='width:120px;'/>
            </td>
        </tr>
        <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
              遊戲圖像:
               <?php 
                    $topic_pic_0 = $setting['ganme_name']['pic'];
                    $curr_form_html = form::images_partition('setting[ganme_name][pic]', 'game_name_pic', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
               </td>
        </tr>
        <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                領取禮包URL：<input name='setting[ganme_name][get_url]' value="<?php echo $setting['ganme_name']['get_url'];?>" id="redirect" style="width:300px;" />
                預約禮包URL：<input name='setting[ganme_name][well_url]' value="<?php echo $setting['ganme_name']['well_url'];?>" id="redirect" style="width:300px;" />

            </td>
        </tr>
        <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                遊戲主頁URL：<input name='setting[ganme_name][index_url]' value="<?php echo $setting['ganme_name']['index_url'];?>" id="redirect" style="width:300px;" />
                </td>
        </tr>
        <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                遊戲評分(1-5分)：<input  style="width:150px;" name='setting[ganme_name][pingfeng]' value="<?php echo $setting['ganme_name']['pingfeng'];?>" id="redirect" style="width:300px;" />

            </td>
        </tr>
         <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                遊戲系統：
                <select name="setting[ganme_name][xitong]">
                    <option class="cl_me_1" value="1">蘋果,安卓</option>
                    <option class="cl_me_2" value="2">安卓</option>
                    <option class="cl_me_3" value="3">蘋果</option>
                </select>

                </td>
        </tr>
        <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                遊戲大小：<input  style="width:150px;" name='setting[ganme_name][size]' value="<?php echo $setting['ganme_name']['size'];?>" id="redirect" style="width:300px;" />

            </td>
        </tr>
        <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                遊戲類型：<input  style="width:150px;" name='setting[ganme_name][type]' value="<?php echo $setting['ganme_name']['type'];?>" id="redirect" style="width:300px;" />

            </td>
        </tr>
         <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                開服狀態：<input  style="width:150px;" name='setting[ganme_name][kf]' value="<?php echo $setting['ganme_name']['kf'];?>" id="redirect" style="width:300px;" />

            </td>
        </tr>
        <tr>
          <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                遊戲描述:
                <textarea cols="50" rows="4"name='setting[ganme_name][description]' value=""><?php echo trim($setting['ganme_name']['description']);?></textarea>
                  
                
                </td>
        </tr>
  <!--遊戲信息結束-->
  <!--2個帶描述的-->
  <tr>
    <th width="120">浮窗<font color=red>2圖片</font>配置： </th>
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
                描述:<input name='setting[floating][0][description]' style="width:200px" value="<?php echo $setting['floating'][0]['description'];?>" type='text' style='width:120px;'/>
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
                描述:<input name='setting[floating][1][description]' style="width:200px" value="<?php echo $setting['floating'][1]['description'];?>" type='text' style='width:120px;'/>
                </td>
        </tr> 
    <!--2個帶描述的-->
    <!--2個圖片的開始-->
<tr>
    <th width="120">浮窗<font color=red>2無標題圖片</font>配置： </th>
    <td class="y-bg"> </td>
  </tr>
   <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">   
                <?php 
                    $topic_pic_0 = $setting['floating_no'][0]['pic'];
                    $curr_form_html = form::images_partition('setting[floating_no][0][pic]', 'floating_no_pic1', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[floating_no][0][link]' value="<?php echo $setting['floating_no'][0]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 
       <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">              
                <?php 
                    $topic_pic_0 = $setting['floating'][0]['pic'];
                    $curr_form_html = form::images_partition('setting[floating_no][1][pic]', 'floating_no_pic2', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[floating_no][1][link]' value="<?php echo $setting['floating_no'][1]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

  <tr>
    <!--2個帶圖片的結束2-->
    <th width="120">浮窗<font color=red>攻略</font>配置： ：</th>
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
   <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article][3][name]' value="<?php echo $setting['floating_article'][3]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article][3][link]' value="<?php echo $setting['floating_article'][3]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 


  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article][4][name]' value="<?php echo $setting['floating_article'][4]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article][4][link]' value="<?php echo $setting['floating_article'][4]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 

   <tr>
    <th width="120">浮窗<font color=red>遊戲問答</font>配置： ：</th>
    <td class="y-bg"> </td>
  </tr>

  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article_ans][0][name]' value="<?php echo $setting['floating_article_ans'][0]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article_ans][0][link]' value="<?php echo $setting['floating_article_ans'][0]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 


  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article_ans][1][name]' value="<?php echo $setting['floating_article_ans'][1]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article_ans][1][link]' value="<?php echo $setting['floating_article_ans'][1]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 


  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article_ans][2][name]' value="<?php echo $setting['floating_article_ans'][2]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article_ans][2][link]' value="<?php echo $setting['floating_article_ans'][2]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 
  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article_ans][3][name]' value="<?php echo $setting['floating_article_ans'][3]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article_ans][3][link]' value="<?php echo $setting['floating_article_ans'][3]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 


  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article_ans][4][name]' value="<?php echo $setting['floating_article_ans'][4]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article_ans][4][link]' value="<?php echo $setting['floating_article_ans'][4]['link'];?>" id="redirect" style="width:300px;" />
  </td>
  </tr> 
  <tr>
    <th width="120">進入專區<font color=red>信息</font>配置： ：</th>
    <td class="y-bg"> </td>
  </tr>
  <tr>
  <th style="width:130px;text-align:right;"></th>
  <td style="text-align:left;" colspan="3">
      標題：<input name='setting[floating_article_ans][5][name]' value="<?php echo $setting['floating_article_ans'][5]['name'];?>" type='text' style='width:300px;'/>
      URL：<input name='setting[floating_article_ans][5][link]' value="<?php echo $setting['floating_article_ans'][5]['link'];?>" id="redirect" style="width:300px;" />
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