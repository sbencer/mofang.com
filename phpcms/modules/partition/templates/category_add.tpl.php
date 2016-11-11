<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#modelid").formValidator({onshow:"<?php echo L('select_model');?>",onfocus:"<?php echo L('select_model');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('select_model');?>"});
		$("#catname").formValidator({onshow:"<?php echo '請輸入欄目名稱';?>",onfocus:"<?php echo '請輸入欄目名稱';?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo '請輸入欄目名稱';?>"});
		$("#catdir").formValidator({onshow:"<?php echo L('input_dirname');?>",onfocus:"<?php echo L('input_dirname');?>"}).regexValidator({regexp:"^([a-zA-Z0-9、-]|[_]){0,30}$",onerror:"<?php echo L('enter_the_correct_catname');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_dirname');?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=category&a=public_check_catdir",datatype : "html",cached:false,getdata:{parentid:'parentid'},async:'false',success : function(data){	if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('catname_have_exists');?>",onwait : "<?php echo L('connecting');?>"});
		$("#url").formValidator({onshow:" ",onfocus:"<?php echo L('domain_name_format');?>",tipcss:{width:'300px'},empty:true}).inputValidator({onerror:"<?php echo L('domain_name_format');?>"}).regexValidator({regexp:"http:\/\/(.+)\/$",onerror:"<?php echo L('domain_end_string');?>"});
		$("#template_list").formValidator({onshow:"<?php echo L('template_setting');?>",onfocus:"<?php echo L('template_setting');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('template_setting');?>"});
	})
//-->
</script>

<form name="myform" id="myform" action="?m=partition&c=partition&a=add" method="post">
<div class="pad-10">
<div class="col-tab">

	<ul class="tabBut cu-li">
		<li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',12,1);"><?php echo L('catgory_basic');?></li>
		<li id="tab_setting_3" onclick="SwapTab('setting','on','',12,3);"><?php echo L('catgory_template');?></li>
		<li id="tab_setting_4" onclick="SwapTab('setting','on','',12,4);"><?php echo L('catgory_seo');?></li>
		<!-- <li id="tab_setting_5" onclick="SwapTab('setting','on','',9,5);"><?php echo L('catgory_private');?></li> -->
		<?php if(!$is_parent['parentid'] && !$do_show){?><li id="tab_setting_6" onclick="SwapTab('setting','on','',12,6);">關聯遊戲</li><?php }?>
		<?php if(!$is_parent['parentid'] && !$do_show){?><li id="tab_setting_7" onclick="SwapTab('setting','on','',12,7);">頭圖</li><?php }?>
		<?php if(!$is_parent['parentid'] && !$do_show){?><li id="tab_setting_8" onclick="SwapTab('setting','on','',12,8);">跳轉button</li><?php }?>
		<?php if(!$is_parent['parentid'] && !$do_show){?><li id="tab_setting_9" onclick="SwapTab('setting','on','',12,9);">遊戲下載信息</li><?php }?>
		<?php if(!$is_parent['parentid'] && !$do_show){?><li id="tab_setting_10" onclick="SwapTab('setting','on','',12,10);">助手下載信息</li><?php }?>
		<?php if(!$is_parent['parentid'] && !$do_show){?><li id="tab_setting_11" onclick="SwapTab('setting','on','',12,11);">模板基本配置</li><?php }?>
		<?php if(!$is_parent['parentid'] && !$do_show){?><li id="tab_setting_12" onclick="SwapTab('setting','on','',12,12);">button項&nbsp;<font color="green">v2</font></li><?php }?>
	</ul>

<div id="div_setting_1" class="contentList pad-10">

<table width="100%" class="table_form ">
 <tr>
     <th><?php echo L('add_category_types');?>：</th>
      <td>
	  <input type='radio' name='addtype' value='0' checked id="normal_addid"> <?php echo L('normal_add');?>&nbsp;&nbsp;&nbsp;&nbsp;
	  <!-- <input type='radio' name='addtype' value='1'  onclick="$('#catdir_tr').html(' ');$('#normal_add').html(' ');$('#normal_add').css('display','none');$('#batch_add').css('display','');$('#normal_addid').attr('disabled','true');this.disabled='true'"> <?php echo L('batch_add');?></td> -->
    </tr>

      <?php if($parentid){?>
      <tr>
        <th width="200">上級分區：</th>
        <td>
		<?php //echo form::select_category('category_content_'.$this->siteid,$parentid,'name="info[parentid]" id="parentid"',L('please_select_parent_category'),0,-1);?>
		<?php echo form::select_partition($is_sub,$sub_id[1],'category_content_'.$this->siteid,$catid,'name="info[parentid]" id="parentid"','請選擇上級分區',0,-1);?>
		<?php //echo form::select_partition(0,0,'category_content_'.$this->siteid,$parentid,'name="info[parentid]" id="parentid"','請選擇上級分區',0,-1);?>
	</td>
      </tr>
      <?php }?>

      <tr>
        <th>欄目名稱：</th>
        <td>
        <span id="normal_add">
            <input type="text" name="info[catname]" id="catname" class="input-text" value="">&nbsp;&nbsp;&nbsp;&nbsp;
            總係數：<input type="text" name="setting[rate_weight]" class="input-text" value="1.0" />
        </span>
        <span id="batch_add" style="display:none">
        <table width="100%" class="sss"><tr><td width="310"><textarea name="batch_add" maxlength="255" style="width:300px;height:60px;"></textarea></td>
        <td align="left">
        <?php echo L('batch_add_tips');?>
 </td></tr></table>
        </span>
		</td>
	    <tr>
            <th>攻略欄目：</th>
            <td><input type="text" name="setting[app_gonglue_cha]" class="input-text" value="<?php $setting['app_gonglue_cha'];?>" /></td>
        </tr>

	<?php if($parentid){?>
		<tr>
			<th>Tab標簽：</th>
			<td>
		  		<input type='radio' name='info[is_tab]' value='1' id="normal_addid"> 是&nbsp;&nbsp;&nbsp;&nbsp;
		  		<input type='radio' name='info[is_tab]' value='0' checked id="normal_addid"> 否&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<th>Tab標簽(<font color="green">New助手</font>)：</th>
			<td>
		  		<input type='radio' name='info[is_tab2]' value='1' id="normal_addid"> 是&nbsp;&nbsp;&nbsp;&nbsp;
		  		<input type='radio' name='info[is_tab2]' value='0' checked id="normal_addid"> 否&nbsp;&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
	    <tr>
			<th>Tab圖片(<font color="green">New助手</font>)：</th>
            <td><?php echo form::images('setting[new_tab_image]', 'image', $setting['new_tab_image'], 'content');?></td>
        </tr>
		<tr>
			<th>列表樣式：</th>
			<td>
				<input type='radio' name='info[cont_type]' value='1' checked> 文字列表&nbsp;&nbsp;
				<input type='radio' name='info[cont_type]' value='2'> 圖文列表&nbsp;&nbsp;
				<input type='radio' name='info[cont_type]' value='3'> 圖鑑列表&nbsp;&nbsp;
				<input type='radio' name='info[cont_type]' value='4'> 圖文數值列表(卡牌庫)&nbsp;&nbsp;
				<input type='radio' name='info[cont_type]' value='5'> 視頻列表及詳情頁
			</td>
		</tr>
		<tr>
			<th>內容樣式：</th>
			<td>
				<input type='radio' name='info[cont_style]' value='0' checked> 默認&nbsp;&nbsp;
				<input type='radio' name='info[cont_style]' value='1'> 滑動&nbsp;&nbsp;
				<input type='radio' name='info[cont_style]' value='2'> 卡牌&nbsp;&nbsp;
			</td>
		</tr>
	<?php }?>

	<?php if(!$is_parent['parentid'] && !$do_show){?>

	<tr>
        <th>推薦位欄目：</th>
        <td><input type="text" name="info[rec_channel]" class="input-text" value="" /></td>
      </tr>

	<tr>
        <th>Android包：</th>
        <td>
            <input type="text" name="info[pack_android]" class="input-text" value="" />&nbsp;&nbsp;&nbsp;&nbsp;
            APP係數：<input type="text" name="setting[app_weight]" class="input-text" value="1.0" />
        </td>
      </tr>

	<tr>
        <th>iOS包：</th>
        <td><input type="text" name="info[pack_ios]" class="input-text" value="" /></td>
      </tr>
    <tr>
        <th>Web頭圖：</th>
		<td>
            <?php echo form::upfiles('setting[web_header]', 'web_header', '', 'web_header', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?>
        </td>
    </tr>
    <tr>
        <th>專區背圖：</th>
        <td>
            <?php echo form::upfiles('setting[web_background]', 'web_background', '', 'web_background', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?>
            &nbsp;&nbsp;背圖鏈接：&nbsp;
            <input name='setting[web_bg_url]' type='text' id='meta_title' value='' size='60' maxlength='60'>
        </td>
    </tr>
      <?php }?>


	<?php if(!$is_parent['parentid'] && !$do_show){?>
 	<tr>
		<th>是否上線：</th>
		<td>
			<input type='radio' name='info[is_online]' value='0' checked id="normal_addid"> 不上線&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='info[is_online]' value='1' > 上線</td>
	</tr>
 	<tr>
		<th>獨立域名：</th>
		<td>
			<input type='radio' name='info[is_domain]' value='0' checked id="normal_addid"> 不啟用&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='info[is_domain]' value='1' > 啟用</td>
	</tr>
    <tr>
		<th>專區類型：</th>
		<td>
			<input type='radio' name='setting[is_official]' value='0' checked id="normal_addid"> 普通&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[is_official]' value='1' > 官網
        </td>
	</tr>
	<tr>
		<th width="200">Smarty模板：</th>
		<td>
			<input type='radio' name='setting[is_general_template]' value='0' id="normal_addid"> 否&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[is_general_template]' value='1' checked> 是&nbsp;&nbsp;&nbsp;&nbsp;
            註：除老的簡轉繁專區外，其他都選‘是’
        </td>
	</tr>
    <tr>
        <th width="200">啟用搜索：</th>
        <td>
            <input type='radio' name='setting[is_search]' value='0' checked id="normal_addid"> 不啟用&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='radio' name='setting[is_search]' value='1' > 啟用
            &nbsp;&nbsp;&nbsp;&nbsp;搜索代碼：&nbsp;
            <input name='setting[search_code]' type='text' id='meta_title' value='' size='40' maxlength='40'>
        </td>
    </tr>
	<tr>
		<th width="200">卡牌數據庫標識：</th>
		<td><input name='setting[card_db_ename]' type='text' id='meta_title' value='' size='60' maxlength='60'></td>
	</tr>
	<tr>
		<th width="200">英文標識：</th>
		<td>
            <input name='info[domain_dir]' type='text' id='meta_title' value='' size='60' maxlength='60'>&nbsp;&nbsp;&nbsp;&nbsp;
            專區係數：<input type="text" name="setting[strategy_weight]" class="input-text" value="1.0" />
        </td>
	</tr>
	<tr>
		<th width="200">社區id：</th>
		<td>
            <input name='info[bbs_id]' type='text' id='meta_title' value='' size='60' maxlength='60'>&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='radio' name='setting[is_newbbs]' value='0' <?php if( !$setting['is_newbbs'] ) echo "checked";?> id="normal_addid"> 老bbs&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='radio' name='setting[is_newbbs]' value='1' <?php if( $setting['is_newbbs'] ) echo "checked";?> > 新feed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            BBS係數：<input type="text" name="setting[bbs_weight]" class="input-text" value="1.0" />
        </td>
	</tr>
	<?php }?>

    <?php if($parentid){?>
        <tr>
            <th>圖鑑圖片：</th>
            <td>
                <?php echo form::upfiles('setting[tj_pic]', 'tj_pic', '', 'tj_pic', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?>
            </td>
        </tr>
        <tr>
            <th>欄目跳轉鏈接：</th>
            <td><input name='setting[tj_link]' type='text' id='meta_title' value='' size='60' maxlength='60'></td>
        </tr>
	<?php }?>

	 <tr>
        <th><?php if(!$is_parent['parentid'] && !$do_show){ echo "專區圖片"; }else{ echo "欄目圖片"; }?>：</th>
        <td><?php echo form::images('info[image]', 'image', $image, 'content');?></td>
      </tr>

	 <tr>
      <th><?php echo L('workflow');?>：</th>
      <td>
	  <?php
		$workflows = getcache('workflow_'.$this->siteid,'commons');
		if($workflows) {
			$workflows_datas = array();
			foreach($workflows as $_k=>$_v) {
				$workflows_datas[$_v['workflowid']] = $_v['workname'];
			}
			echo form::select($workflows_datas,'','name="setting[workflowid]"','不需要審核');
		} else {
			echo '<input type="hidden" name="setting[workflowid]" value="">';
			echo L('add_workflow_tips');
		}
	?>
	  </td>
    </tr>

    <tr>
         <th><?php echo L('ismenu');?>：</th>
          <td>
          <input type='radio' name='info[ismenu]' value='1' checked> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
          <input type='radio' name='info[ismenu]' value='0'  > <?php echo L('no');?></td>
        </tr>
    <tr>

</table>

</div>


<!-- 模板選擇  -->
<div id="div_setting_3" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
    <tbody>
        <tr>
            <td width="120">模板類型：</td> 
            <td>
			    <input type='radio' name='setting[template_type]' onclick="show_tem_type(this.value)" value='0' <?php if(!$setting['template_type']) echo "checked";?> checked id="normal_addid"> 通用模板&nbsp;&nbsp;&nbsp;&nbsp;
	  		    <input type='radio' name='setting[template_type]' onclick="show_tem_type(this.value)" value='1' <?php if($setting['template_type']) echo "checked";?> > 新模板
                &nbsp;&nbsp;&nbsp;
                <input type='radio' name='setting[template_type]' onclick="show_tem_type(this.value)" value='2' <?php if($setting['template_type']) echo "checked";?> > 自定義模板
            </td>
        </tr>
    </tbody>

    <!-- 老模板 -->
    <tbody id="tem_type_0" <?php if($setting['template_type']!=0) echo 'style="display:none"';?> >
        <tr>
            <th width="200"></th>
            <td id="other_template"><font color=red>使用專區通用配置模板</font></td>
        </tr> 
    </tbody>

    <!-- 新模板 -->
    <tbody id="tem_type_1" <?php if($setting['template_type']!=1) echo 'style="display:none"';?> >
        <?php if(!$parentid){?>
        <tr>
            <th width="200"><?php echo L('category_index_tpl')?>：</th>
            <td>
                <input type="text" name="setting[tem_new][index]" style="width:300px;" class="input-text" value="">
            </td>
        </tr>
        <?php }?>
        <tr>
            <th width="200">列表頁模板：</th>
            <td>
                <input type="text" name="setting[tem_new][list]" style="width:300px;" class="input-text" value="">
            </td>
        </tr>
        <tr>
            <th width="200"><?php echo L('content_tpl')?>：</th>
            <td>
                <input type="text" name="setting[tem_new][content]" style="width:300px;" class="input-text" value="">
            </td>
        </tr>
    </tbody>

    <!-- 自定義模板 -->
    <tbody id="tem_type_2" <?php if($setting['template_type']!=2) echo 'style="display:none"';?> >
        <?php if(!$parentid){?>
        <tr>
            <th width="200">自定義首頁：</th>
            <td>
                <input type="text" name="setting[tem_new_2][index]" style="width:300px;" class="input-text" value="">
            </td>
        </tr>
        <?php }?>
        <tr height="36">
            <th width="200">自定義列表頁模板：</th>
            <td>
                <input type="text" name="setting[tem_new_2][list]" style="width:300px;" class="input-text" value="" >
            </td>
        </tr>
        <tr>
            <th width="200">自定義內容頁模板：</th>
            <td>
                <input type="text" name="setting[tem_new_2][content]" style="width:300px;" class="input-text" value="">
            </td>
        </tr>

        <!-- 測試模版功能 -->
        <?php if(!$parentid){?>
        <tr>
            <td width="120">測試模板配置：</td> 
        <td>
        </td>
        </tr>
        <tr>
        <th width="200">測試首頁：</th>
            <td>
                <input type="text" name="setting[tem_new_test][index]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_test']['index'];?>">
            </td>
        </tr>
        <tr height="36">
        <th width="200">測試列表頁：</th>
            <td>
                <input type="text" name="setting[tem_new_test][list]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_test']['list'];?>" >
            </td>
        </tr>
        <tr>
            <th width="200">測試內容頁：</th>
            <td>
                <input type="text" name="setting[tem_new_test][content]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_test']['content']; ?>">
            </td>
        </tr>
        <tr>
            <td width="120">
                <input name="dosubmit_test" type="button" value="發布測試" class="button" onclick="javascript:window.top.art.dialog({id:'import',iframe:'?m=partition&c=partition&a=push_partition&p=<?php echo $_GET['catid'];?>', title:'專區發布', width:'700', height:'100', lock:true}, function(){var d = window.top.art.dialog({id:'import'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'import'}).close()});void(0);">
            </td> 
            <td>
            </td>
        </tr>
        <?php } ?>
    </tbody>



</table>
</div>

<!-- SEO設置  -->
<div id="div_setting_4" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">

	<!--
	<tr>
		<th width="200"><strong>綁定域名：</strong></th>
		<td><input name='setting[domain]' type='text' id='meta_title' value='' size='60' maxlength='60'></td>
	</tr>
	-->

	<tr>
      <th width="200"><?php echo L('meta_title');?></th>
      <td><input name='setting[meta_title]' type='text' id='meta_title' value='<?php echo $setting['meta_title'];?>' size='60' maxlength='60'></td>
    </tr>
    <tr>
      <th ><?php echo L('meta_keywords');?></th>
      <td><textarea name='setting[meta_keywords]' id='meta_keywords' style="width:90%;height:40px"><?php echo $setting['meta_keywords'];?></textarea></td>
    </tr>
    <tr>
      <th ><strong><?php echo L('meta_description');?></th>
      <td><textarea name='setting[meta_description]' id='meta_description' style="width:90%;height:50px"><?php echo $setting['meta_description'];?></textarea></td>
    </tr>


    <!--浮窗內容配置 !$parentid為空，則說明是專區頂級欄目，則顯示。否則不顯示（目前此處功能預留，備後面如果專區需要顯示獨立的浮窗用）  -->   
        <?php if(!$parentid){?>
        <tr style="height:36px;" class="tr_bor_top">
            <th>是否顯示浮窗：</th>
            <td>
                <input type="radio" name="setting[tem_setting][is_partition]" value="0" id="is_partition" checked=""> 不顯示&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="setting[tem_setting][is_partition]" value="1" > 顯示</td>
        </tr>
        <tr style="height:36px;" >
            <th style="width:130px;text-align:right;">浮窗<font color="red">圖片</font>配置：</th>
            <td style="text-align:left;" colspan="3">
                
            </td>
        </tr> 

        <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[tem_setting][floating][0][name]' value="<?php echo $setting['tem_setting']['floating'][0]['name'];?>" type='text' style='width:80px;'/>
                <?php 
                    $topic_pic_0 = $setting['tem_setting']['floating'][0]['pic'];
                    $curr_form_html = form::images_partition('setting[tem_setting][floating][0][pic]', 'floating_pic1', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[tem_setting][floating][0][link]' value="<?php echo $setting['tem_setting']['floating'][0]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

   <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[tem_setting][floating][1][name]' value="<?php echo $setting['tem_setting']['floating'][1]['name'];?>" type='text' style='width:80px;'/>
                <?php 
                    $topic_pic_0 = $setting['tem_setting']['floating'][1]['pic'];
                    $curr_form_html = form::images_partition('setting[tem_setting][floating][1][pic]', 'floating_pic2', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[tem_setting][floating][1][link]' value="<?php echo $setting['tem_setting']['floating'][1]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

        <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[tem_setting][floating][2][name]' value="<?php echo $setting['tem_setting']['floating'][2]['name'];?>" type='text' style='width:80px;'/>
                <?php 
                    $floating_0 = $setting['tem_setting']['floating'][2]['pic'];
                    $curr_form_html = form::images_partition('setting[tem_setting][floating][2][pic]', 'floating_pic3', $floating_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[tem_setting][floating][2][link]' value="<?php echo $setting['tem_setting']['floating'][2]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

<!--浮窗文字配置-->
        <tr style="height:36px;" class="">
            <th style="width:130px;text-align:right;">浮窗<font color="red">文字</font>配置：</th>
            <td style="text-align:left;" colspan="3">
                
            </td>
        </tr> 

        <tr>
        <th style="width:130px;text-align:right;"></th>
        <td style="text-align:left;" colspan="3">
            標題：<input name='setting[tem_setting][floating_article][0][name]' value="<?php echo $setting['tem_setting']['floating_article'][0]['name'];?>" type='text' style='width:300px;'/>
            URL：<input name='setting[tem_setting][floating_article][0][link]' value="<?php echo $setting['tem_setting']['floating_article'][0]['link'];?>" id="redirect" style="width:300px;" />
        </td>
        </tr> 


        <tr>
        <th style="width:130px;text-align:right;"></th>
        <td style="text-align:left;" colspan="3">
            標題：<input name='setting[tem_setting][floating_article][1][name]' value="<?php echo $setting['tem_setting']['floating_article'][1]['name'];?>" type='text' style='width:300px;'/>
            URL：<input name='setting[tem_setting][floating_article][1][link]' value="<?php echo $setting['tem_setting']['floating_article'][1]['link'];?>" id="redirect" style="width:300px;" />
        </td>
        </tr> 


        <tr>
        <th style="width:130px;text-align:right;"></th>
        <td style="text-align:left;" colspan="3">
            標題：<input name='setting[tem_setting][floating_article][2][name]' value="<?php echo $setting['tem_setting']['floating_article'][2]['name'];?>" type='text' style='width:300px;'/>
            URL：<input name='setting[tem_setting][floating_article][2][link]' value="<?php echo $setting['tem_setting']['floating_article'][2]['link'];?>" id="redirect" style="width:300px;" />
        </td>
        </tr> 
        <?php  } ?>
        <!--浮空配置結束-->
    
</table>
</div>

<!--
<div id="div_setting_5" class="contentList pad-10 hidden">
<table width="100%" >
		<tr>
        <th width="200"><?php echo L('role_private')?>：</th>
        <td>
			<table width="100%" class="table-list">
			  <thead>
				<tr>
				  <th align="left"><?php echo L('role_name');?></th><th><?php echo L('view');?></th><th><?php echo L('add');?></th><th><?php echo L('edit');?></th><th><?php echo L('delete');?></th><th><?php echo L('listorder');?></th><th><?php echo L('push');?></th><th><?php echo L('move');?></th>
			  </tr>
			    </thead>
				 <tbody>
				<?php
				$roles = getcache('role','commons');
				foreach($roles as $roleid=> $rolrname) {
				$disabled = $roleid==1 ? 'disabled' : '';
				?>
		  		<tr>
				  <td><?php echo $rolrname?></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="init,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="add,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="edit,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="delete,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="listorder,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="push,<?php echo $roleid;?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> value="move,<?php echo $roleid;?>" ></td>
			  </tr>
			  <?php }?>

			 </tbody>
			</table>
		</td>

      </tr>
		<tr><td colspan=2><hr style="border:1px dotted #F2F2F2;"></td>
		</tr>

	  <tr>
        <th width="200"><?php echo L('group_private')?>：</th>
        <td>
			<table width="100%" class="table-list">
			  <thead>
				<tr>
				  <th align="left"><?php echo L('group_name');?></th><th><?php echo L('allow_vistor');?></th><th><?php echo L('allow_contribute');?></th>
			  </tr>
			    </thead>
				 <tbody>
			<?php
			$group_cache = getcache('grouplist','member');
			foreach($group_cache as $_key=>$_value) {
			if($_value['groupid']==1) continue;
			?>
		  		<tr>
				  <td><?php echo $_value['name'];?></td>
				  <td align="center"><input type="checkbox" name="priv_groupid[]" value="visit,<?php echo $_value['groupid'];?>" ></td>
				  <td align="center"><input type="checkbox" name="priv_groupid[]" value="add,<?php echo $_value['groupid'];?>" ></td>
			  </tr>
			<?php }?>
			 </tbody>
			</table>
		</td>
      </tr>
</table>
</div>
-->

<!-- 關聯遊戲  -->
<?php if(!$is_parent['parentid'] && !$do_show){?>
<div id="div_setting_6" class="contentList pad-10 hidden">
<table width="100%" class="table_form">

	<!--
	<tr>
		<th width="200"><?php echo L('contribute_add_point');?></th>
      		<td><input name='setting[presentpoint]' type='text' value='1' size='5' maxlength='5' style='text-align:center'> <?php echo L('contribute_add_point_tips');?></td>
	</tr>
	-->

	<tr>
		<th width="200"><strong>所屬遊戲：</strong></th>
		<td>
			<input type="hidden" name="relation_game" id="relation_hao" value style="50">
			<div>
			<!-- <input type="text" id='relation_hao_text' /> -->
			<ul class='list-dot' style='line-height:28px;' id="relation_hao_text"></ul>
			<input type="button" value="選擇所屬遊戲" onclick="omnipotent('select_hao','?m=partition&c=partition&a=public_relation_game_list','選擇所屬遊戲(新)',1)" class="button">
			</div>
		</td>
	</tr>
</table>
</div>
<?php }?>

<!-- 頭圖  -->
<?php if(!$is_parent['parentid'] && !$do_show){?>
<div id="div_setting_7" class="pad-10 hidden">
<table width="100%">
	<tr>
		<th width="10%">名稱</th>
		<th width="30%">圖片</th>
		<th width="30%">跳轉</th>
		<th width="8%">操作</th>
		<th width="3%"></th>
	</tr>
	<tr style="margin-top:10px;">
		<td><input name='header_pic[0][name]' type='text' style='margin-top:8px;width:300px;'/></td>
		<td style="text-align:center;"><?php echo form::upfiles('header_pic[0][image]', 'pic_url', '', 'hao', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
		<td style="text-align:center;">
	  		<input type='radio' name='header_pic[0][redirect_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='header_pic[0][redirect_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
			<input name='header_pic[0][redirect]' id="redirect" style="margin-top:8px;width:300px;" />
		</td>
		<td style="text-align:center;"><a href="javascript:void(0)" class="dele_header_pic">刪除</a></td>
		<td style="text-align:center;"><a href="javascript:void(0)" class="add_header_pic">新增</a></td>
	</tr>
</table>
</div>
<?php }?>

<!-- 跳轉button -->
<?php if(!$is_parent['parentid'] && !$do_show){?>
<div id="div_setting_8" class="pad-10 hidden">
<table width="100%">

	<tr>
		<th width="10%">名稱</th>
		<th width="30%">圖片</th>
		<th width="30%">跳轉</th>
		<th width="8%">操作</th>
		<th width="3%"></th>
	</tr>

	<tr style="margin-top:10px;">
		<td><input name='redirect_button[0][name]' type='text' style="margin-top:8px;width:300px;"/></td>
		<td style="text-align:center;"><?php echo form::upfiles('redirect_button[0][image]', 'pic_url2', '', 'hao2', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
		<td>
	  		<input type='radio' name='redirect_button[0][redirect_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='redirect_button[0][redirect_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
			<input name='redirect_button[0][redirect]' id="redirect_btn" style="margin-top:8px;width:300px;" />
		</td>
		<td style="text-align:center;"><a href="javascript:void(0)" class="dele_redirect_button">刪除</a></td>
		<td style="text-align:center;"><a href="javascript:void(0)" class="add_redirect_button">新增</a></td>
	</tr>
</table>
</div>
<?php }?>

<!-- 遊戲下載信息 -->
<?php if(!$is_parent['parentid'] && !$do_show){?>
<style type="text/css">
    .app_down_logo{
        margin-top:8px;
        width:300px;
    }
</style>
<div id="div_setting_9" class="pad-10 hidden">
<table width="100%">
    <tr>
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:39px;">app名：</span>
		    <input name='setting[app_down][name]' type='text' style="margin-top:8px;width:300px;" />
        </td>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:23px;">遊戲Logo：</span>
            <?php echo form::upfiles('setting[app_down][image]', 'pic_url3', '', 'hao3', '', 50, 'app_down_logo', '', 'gif|jpg|jpeg|png|bmp')?>
        </td>
    </tr>
    <tr>
        <td style="text-align:left;" colspan="2">
            <span style="padding-right:23px;">遊戲描述：</span>
            <textarea rows="3" cols="50" name='setting[app_down][desc]' style="margin-top:8px;width:300px;" ></textarea></td>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:23px;">IOS下載：</span>
		    <input name='setting[app_down][ios]' type='text' style="margin-top:8px;width:300px;"/>
        </td>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">
            Android下載：
		    <input name='setting[app_down][android]' type='text' style="margin-top:8px;width:300px;"/>
        </td>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:25px;">二維碼：</span>
            <?php echo form::upfiles('setting[app_down][qrcode]', 'app_down_qr', '', 'app_down_qr', '', 50, 'app_down_logo', '', 'gif|jpg|jpeg|png|bmp')?>
        </td>
    </tr>
</table>
</div>
<?php }?>
<!-- 助手下載信息 -->
<?php if(!$is_parent['parentid'] && !$do_show){?>
<div id="div_setting_10" class="pad-10 hidden">
<table width="100%">
    <tr>
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:39px;">助手名：</span>
		    <input name='setting[app_help][name]' type='text' style="margin-top:8px;width:300px;" />
        </td>
    </tr>
    <tr style="padding-top:20px;">
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:23px;">助手Logo：</span>
            <?php echo form::upfiles('setting[app_help][image]', 'pic_url4', '', 'hao3', '', 50, 'app_down_logo', '', 'gif|jpg|jpeg|png|bmp')?>
        </td>
    </tr>
    <tr>
    <tr>
        <td style="text-align:left;" colspan="2">
            <span style="padding-right:23px;">助手描述：</span>
            <textarea rows="3" cols="50" name='setting[app_help][desc]' style="margin-top:8px;width:300px;" ></textarea></td>
    </tr>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:23px;">IOS下載：</span>
		    <input name='setting[app_help][ios]' type='text' style="margin-top:8px;width:300px;"/>
        </td>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">
            Android下載：
		    <input name='setting[app_help][android]' type='text' style="margin-top:8px;width:300px;"/>
        </td>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">
            <span style="padding-right:25px;">二維碼：</span>
            <?php echo form::upfiles('setting[app_help][qrcode]', 'app_help_qr', '', 'app_help_qr', '', 50, 'app_down_logo', '', 'gif|jpg|jpeg|png|bmp')?>
        </td>
    </tr>
</table>
</div>
<?php }?>

<!-- 助手下載信息 -->
<?php if(!$is_parent['parentid'] && !$do_show){?>
<div id="div_setting_11" class="pad-10 hidden">
<table width="100%">
    <?php if(false){?>
    <tr>
		<td style="text-align:left;" colspan="4">
            <span style="padding-right:28px;">通用模板：</span>
			<input type='radio' name='setting[tem_setting][tem_type]' value='0' checked id="normal_addid"> 通用模板1&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[tem_setting][tem_type]' value='1' > 通用模板2&nbsp;&nbsp;&nbsp;&nbsp;
            <input type='radio' name='setting[tem_setting][tem_type]' value='2' > 通用模板3
        </td>
    </tr>
    <?php }?>
    <tr>
		<td style="text-align:left;" colspan="3">
            <span style="padding-right:39px;">輪播圖：</span>
            <span>欄目id</span>
		    <input name='setting[tem_setting][slide][catid]' type='text' style="margin-top:8px;width:60px;" />
            <span style="padding-left:10px;">調取條數</span>
		    <input name='setting[tem_setting][slide][nums]' type='text' style="margin-top:8px;width:60px;" />&nbsp;(0或不填為不限制)
        </td>
    </tr>
    <tr>
		<td style="text-align:left;" colspan="2">大導航欄鏈接:</td>
    </tr>
	<tr style="margin-top:10px;">
        <td style="width:50px;"></td>
        <td style="width:100px;">排序：<input name='setting[tem_setting][nav][0][listorder]' type='text' style='margin-top:8px;width:50px;'/></td>
		<td style='width:220px;' >名字：<input name='setting[tem_setting][nav][0][name]' type='text' style='margin-top:8px;width:200px;'/></td>
		<td style="text-align:left;width:350px;"><input type='radio' name='setting[tem_setting][nav][0][nav_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[tem_setting][nav][0][nav_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;<input name='setting[tem_setting][nav][0][nav_value]' id="redirect" style="margin-top:8px;width:300px;" /></td>
		<td style="text-align:left;width:30px;">
            <a href="javascript:void(0)" class="dele_nav_item">刪除</a>
        </td>
		<td style="text-align:left;width:30px;">
            <a href="javascript:void(0)" class="add_nav_item">新增</a>
        </td>
        <td style="width:350px;"></td>
	</tr>
    <tr>
		<td style="text-align:left;" colspan="3">
            <span style="padding-right:39px;">論壇鏈接：</span>
        </td>
    </tr>
    <tr>
        <td style="width:50px;"></td>
        <td style="width:50px;">導航鏈接：</td>
		<td style="text-align:left;width:400px;">
		    <input name='setting[tem_setting][nav][bbs_nav_url]' type='text' style="margin-top:8px;width:300px;" />&nbsp;("進入論壇"鏈接)
        </td>
    </tr>
    <tr>
        <td style="width:50px;"></td>
        <td style="width:50px;">帖子鏈接：</td>
		<td style="text-align:left;width:490px;">
		    <input name='setting[tem_setting][nav][bbs_cat_url]' type='text' style="margin-top:8px;width:300px;" />&nbsp;(帖子欄目"更多"鏈接)
        </td>
    </tr>
    <tr>
        <td style="width:50px;"></td>
        <td style="width:50px;">帖子接口鏈接：</td>
		<td style="text-align:left;width:490px;">
		    <input name='setting[tem_setting][nav][bbs_cat_api_url]' type='text' style="margin-top:8px;width:300px;" />&nbsp;(論壇熱帖欄目html接口鏈接)
        </td>
    </tr>
</table>
<table width="100%">
	<tr>
        <td>專題4圖:</td>
	</tr>
	<tr style="margin-top:10px;">
		<td><input name='setting[tem_setting][topic_pic][0][name]' type='text' style='margin-top:8px;width:300px;'/></td>
		<td style="text-align:center;"><?php echo form::upfiles('setting[tem_setting][topic_pic][0][pic]', 'topic_pic1', '', 'topic_pic1', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
		<td style="text-align:center;">
	  		<input type='radio' name='setting[tem_setting][topic_pic][0][type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[tem_setting][topic_pic][0][type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
			<input name='setting[tem_setting][topic_pic][0][link]' id="redirect" style="margin-top:8px;width:300px;" />
		</td>
	</tr>
	<tr style="margin-top:10px;">
		<td><input name='setting[tem_setting][topic_pic][1][name]' type='text' style='margin-top:8px;width:300px;'/></td>
		<td style="text-align:center;"><?php echo form::upfiles('setting[tem_setting][topic_pic][1][pic]', 'topic_pic2', '', 'topic_pic2', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
		<td style="text-align:center;">
	  		<input type='radio' name='setting[tem_setting][topic_pic][1][type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[tem_setting][topic_pic][1][type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
			<input name='setting[tem_setting][topic_pic][1][link]' id="redirect" style="margin-top:8px;width:300px;" />
		</td>
	</tr>
	<tr style="margin-top:10px;">
		<td><input name='setting[tem_setting][topic_pic][2][name]' type='text' style='margin-top:8px;width:300px;'/></td>
		<td style="text-align:center;"><?php echo form::upfiles('setting[tem_setting][topic_pic][2][pic]', 'topic_pic3', '', 'topic_pic3', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
		<td style="text-align:center;">
	  		<input type='radio' name='setting[tem_setting][topic_pic][2][type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[tem_setting][topic_pic][2][type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
			<input name='setting[tem_setting][topic_pic][2][link]' id="redirect" style="margin-top:8px;width:300px;" />
		</td>
	</tr>
	<tr style="margin-top:10px;">
		<td><input name='setting[tem_setting][topic_pic][3][name]' type='text' style='margin-top:8px;width:300px;'/></td>
		<td style="text-align:center;"><?php echo form::upfiles('setting[tem_setting][topic_pic][3][pic]', 'topic_pic4', '', 'topic_pic4', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
		<td style="text-align:center;">
	  		<input type='radio' name='setting[tem_setting][topic_pic][3][type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[tem_setting][topic_pic][3][type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
			<input name='setting[tem_setting][topic_pic][3][link]' id="redirect" style="margin-top:8px;width:300px;" />
		</td>
	</tr>
</table>
</div>
<?php }?>

<?php if(!$is_parent['parentid'] && !$do_show){?>
<div id="div_setting_12" class="pad-10 hidden">
<table width="100%">
	<tr style="margin-top:10px;">
        <td style="width:100px;">排序：<input name='setting[button_v2][0][listorder]' type='text' style='margin-top:8px;width:50px;'/></td>
		<td style='width:240px;' >名字：<input name='setting[button_v2][0][name]' type='text' style='margin-top:8px;width:200px;'/></td>
		<td style="width:300px;">
            圖片：<?php echo form::upfiles('setting[button_v2][0][image]', 'button_pic_url', '', 'hao', '', 30, '', '', 'gif|jpg|jpeg|png|bmp')?>
        </td>
		<td style="text-align:left;width:430px;">
	  		<input type='radio' name='setting[button_v2][0][button_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[button_v2][0][button_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[button_v2][0][button_type]' value='2' class="redirect_type" /> 瀏覽器&nbsp;&nbsp;&nbsp;
	  		<input type='radio' name='setting[button_v2][0][button_type]' value='3' class="redirect_type" /> 卡牌&nbsp;&nbsp;&nbsp;
            <input name='setting[button_v2][0][button_value]' id="redirect" style="margin-top:8px;width:300px;" />
        </td>
		<td style="text-align:left;width:30px;">
            <a href="javascript:void(0)" class="dele_button_item">刪除</a>
        </td>
		<td style="text-align:left;width:30px;">
            <a href="javascript:void(0)" class="add_button_item">新增</a>
        </td>
        <td style="width:100px;"></td>
	</tr>
</table>
</div>
<?php }?>

 <div class="bk15"></div>
 	<input type="hidden" id="max_redirect_btn_nums" value="0" />
 	<input type="hidden" id="max_header_pic_nums" value="0" />
 	<input type="hidden" id="max_nav_item_nums" value="0" />
 	<input type="hidden" id="upload_img_id" >
 	<input type="hidden" id="max_button_item_nums" value="0" />
	<input name="catid" type="hidden" value="<?php echo $catid;?>">
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
</form>
</div>

</div>
<!--table_form_off-->
</div>

<script type="text/javascript">

	//跳轉button
	$(".add_redirect_button").live("click",
		function(){

			var new_btn_nums = parseInt($("#max_redirect_btn_nums").val()) + 1;
			$.ajax({
				url: "?m=partition&c=partition&a=ajax_upload_img&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
				async : false,
				data : "curr_id=" + new_btn_nums,
				type:"post",
				success: function( data  ){
					//console.log(data);
					data = eval(data);
					$ap_html = "<tr style='margin-top:10px;'><td><input name='redirect_button["+ new_btn_nums +"][name]' type='text' class='input-text' style='margin-top:8px;width:300px;'/></td><td style='text-align:center;'>" + data +"</td><td><input type='radio' name='redirect_button["+ new_btn_nums +"][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='redirect_button["+ new_btn_nums +"][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='redirect_button["+ new_btn_nums +"][redirect]' class='input-text' id='redirect_btn' style='margin-top:8px;width:300px;' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_redirect_button'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_redirect_button'>新增</a></td></tr>";
					//$(this).parent().parent().after($ap_html);
					//$("#max_redirect_btn_nums").val(new_btn_nums);
				}
			});

			$(this).parent().parent().after($ap_html);
			$("#max_redirect_btn_nums").val(new_btn_nums);
		}
	)
	$(".dele_redirect_button").live("click",
		function(){
			//alert($(this).parent().parent().html());
			$(this).parent().parent().remove();
		}
	)

	//頭圖
	$(".add_header_pic").live("click",
		function(){

			var new_header_pic_nums = parseInt($("#max_header_pic_nums").val()) + 1;
			$.ajax({
				url: "?m=partition&c=partition&a=ajax_upload_img2&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
				async : false,
				data : "curr_id=" + new_header_pic_nums,
				type:"post",
				success: function( data  ){
					//console.log(data);
					data = eval(data);
					$ap_html = "<tr style='margin-top:10px;'><td><input name='header_pic["+ new_header_pic_nums +"][name]' type='text' class='input-text' style='margin-top:8px;width:300px;'/></td><td style='text-align:center;'>" + data +"</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='header_pic["+ new_header_pic_nums +"][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='header_pic["+ new_header_pic_nums +"][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='header_pic["+ new_header_pic_nums +"][redirect]' style='margin-top:8px;width:300px;' class='input-text' id='redirect_btn' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_header_pic'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_header_pic'>新增</a></td></tr>";
					//$(this).parent().parent().after($ap_html);
					//$("#max_redirect_btn_nums").val(new_btn_nums);
				}
			});

			$(this).parent().parent().after($ap_html);
			$("#max_header_pic_nums").val(new_header_pic_nums);
		}
	)

	//導航鏈接項修訂
	$(".add_nav_item").live("click",
		function(){

			var max_nav_item_nums = parseInt($("#max_nav_item_nums").val()) + 1;
			$ap_html = "<tr style='margin-top:10px;'><td style='width:50px;'></td><td style='width:100px;'>排序：<input name='setting[tem_setting][nav]["+max_nav_item_nums+"][listorder]' type='text' style='margin-top:8px;width:50px;' class='input-text' /></td><td style='width:220px;' >名字：<input name='setting[tem_setting][nav]["+max_nav_item_nums+"][name]' type='text' style='margin-top:8px;width:200px;' class='input-text' /></td><td style='text-align:left;width:350px;'><input type='radio' name='setting[tem_setting][nav]["+max_nav_item_nums+"][nav_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[tem_setting][nav]["+max_nav_item_nums+"][nav_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;<input name='setting[tem_setting][nav]["+max_nav_item_nums+"][nav_value]' id='redirect' style='margin-top:8px;width:300px;' class='input-text' /></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='add_nav_item'>新增</a></td><td style='width:350px;'></td></tr>";

			$(this).parent().parent().after($ap_html);
			$("#max_nav_item_nums").val(max_nav_item_nums);
		}
	)
	$(".dele_nav_item").live("click",
		function(){
			$(this).parent().parent().remove();
		}
	)



	$(".dele_header_pic").live("click",
		function(){
			//alert($(this).parent().parent().html());
			$(this).parent().parent().remove();
		}
	)
	
	//Banner v2
	$(".add_button_item").live("click",
		function(){
			var max_button_item_nums = parseInt($("#max_button_item_nums").val()) + 1;
			$.ajax({
				url: "?m=partition&c=partition&a=ajax_upload_img3&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
				async : false,
				data : "curr_id=" + max_button_item_nums,
				type:"post",
				success: function( data ){
					data = $.parseJSON(data);
                    $ap_html = "<tr style='margin-top:10px;'><td style='width:100px;'>排序：<input name='setting[button_v2]["+max_button_item_nums+"][listorder]' type='text' style='margin-top:8px;width:50px;' class='input-text' /></td><td style='width:280px;' >名字：<input name='setting[button_v2]["+max_button_item_nums+"][name]' type='text' style='margin-top:8px;width:200px;' class='input-text' /></td><td style='width:300px;'>圖片："+data+"</td><td style='text-align:left;width:430px;'><input type='radio' name='setting[button_v2]["+max_button_item_nums+"][button_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[button_v2]["+max_button_item_nums+"][button_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[button_v2]["+max_button_item_nums+"][button_type]' value='2' class='redirect_type' /> 卡牌&nbsp;&nbsp;&nbsp;<input name='setting[button_v2]["+max_button_item_nums+"][button_value]' id='redirect' style='margin-top:8px;width:300px;' class='input-text' /></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='dele_button_item'>刪除</a></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='add_button_item'>新增</a></td><td style='width:100px;'></td></tr>";
				}
			});
			$(this).parent().parent().after($ap_html);
			$("#max_button_item_nums").val(max_button_item_nums);
		}
	)
	$(".dele_button_item").live("click",
		function(){
			$(this).parent().parent().remove();
		}
	)
</script>


<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
	function SwapTab(name,cls_show,cls_hide,cnt,cur){
		for(i=1;i<=cnt;i++){
			if(i==cur){
				 $('#div_'+name+'_'+i).show();
				 $('#tab_'+name+'_'+i).attr('class',cls_show);
			}else{
				 $('#div_'+name+'_'+i).hide();
				 $('#tab_'+name+'_'+i).attr('class',cls_hide);
			}
		}
	} 

	function load_file_list(id) {
		if(id=='') return false;
		$.getJSON('?m=admin&c=category&a=public_tpl_file_list_partition&style='+id+'&catid=<?php echo $parentid?>', function(data){$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
	}
	// change_tpl('');

    //顯示模板配置
    function show_tem_type(obj) {
        for (var i=0; i<=2; i++){
            if (obj==i){
                $('#tem_type_'+i).show();
            } else {
                $('#tem_type_'+i).hide();
            }
        }
    }
 
//-->
</script>
