<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"<?php echo L('input_catname');?>",onfocus:"<?php echo L('input_catname');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_catname');?>"}).defaultPassed();
	})
//-->
</script>

<form name="myform" id="myform" action="?m=admin&c=area&a=edit" method="post">
<input type='hidden' name='info[productid]' value='<?php echo $productid?>'>
<input type='hidden' name='id' value='<?php echo $id;?>'>
<div class="pad-10">
<div class="col-tab">

<ul class="tabBut cu-li">
<li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',3,1);"><?php echo L('catgory_basic');?></li>
<li id="tab_setting_2" onclick="SwapTab('setting','on','',3,2);"><?php echo L('catgory_template');?></li>
<li id="tab_setting_3" onclick="SwapTab('setting','on','',3,3);"><?php echo L('catgory_seo');?></li>
</ul>
<div  id="div_setting_1" class="contentList pad-10">
<table width="100%" class="table_form ">
      <tr>
        <th width="200"><?php echo L('product_name')?>：</th>
        <td>
        	<?php echo $productname;?>
		</td>
      </tr>
      <tr>
        <th width="200"><?php echo L('parent_area')?>：</th>
        <td>
		<?php echo form::select_area('product_areas_'.$productid,$parentid,'name="info[parentid]" id="parentid" onchange="change_parent_area(this.value)"',L('please_select_parent_area'));?>
		</td>
      </tr>
      <tr>
        <th width="200"><?php echo L('area_category_name')?>：</th>
        <td>
        	<?php echo $area_menus[$catid]['catname'];?>
		</td>
      </tr>

      <tr>
        <th><?php echo L('catname')?>：</th>
        <td>
        <input type="text" name="info[name]" id="name" class="input-text" value="<?php echo $name;?>">
		</td>
      </tr>
  </table>
</div>
<div id="div_setting_2" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
	<tr>
		<th width="200"><?php echo L('available_styles');?>：</th>
		<td>
			<?php echo form::select($template_list, $setting['template_list'], 'name="setting[template_list]" id="template_list" onchange="load_file_list(this.value)"', L('please_select'))?>
		</td>
	</tr>
	<tr>
		<th width="200"><?php echo L('category_list_tpl')?>：</th>
		<td  id="list_template">
		</td>
	</tr>
	<tr>
		<th width="200"><?php echo L('content_tpl')?>：</th>
		<td  id="show_template">
		</td>
	</tr>
	  <tr>
        <th width="200"><?php echo L('apply_template_to_child');?></th>
        <td><input type='radio' name='template_child' value='1'> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
          <input type='radio' name='template_child' value='0' checked> <?php echo L('no');?></td></td>
      </tr>
</table>
</div>
<div id="div_setting_3" class="contentList pad-10 hidden">
<table width="100%" class="table_form ">
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
</table>
</div>
 <div class="bk15"></div>
	<input name="catid" type="hidden" value="<?php echo $catid;?>">
    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">

</form>
</div>

</div>
<!--table_form_off-->
</div>

<script language="JavaScript">
<!--
	$(function(){
		var url = $('#url').val();
		if(!url.match(/^http:\/\//)) $('#url').val('');
	})
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
	function change_parent_area(areaid) {
		if (parseInt(areaid)) {
			$.getJSON('?m=admin&c=area&a=public_get_catid&areaid='+areaid,
				function(data) {
					$('#catid_select').val(data.catid);
					$('#catid_select').attr('disabled', true);
					$('#catid_input').val(data.catid);
					$('#catid_input').attr('disabled', false);
				});
		} else {
			$('#catid_select').val(0);
			$('#catid_select').attr('disabled', false);
			$('#catid_input').val(0);
			$('#catid_input').attr('disabled', true);
		}
	}
	function load_file_list(id) {
		if(id=='') return false;
		$.getJSON('?m=admin&c=category&a=public_tpl_file_list&style='+id+'&catid=<?php echo $catid?>', function(data){$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
	}
	<?php if(isset($setting['template_list']) && !empty($setting['template_list'])) echo "load_file_list('".$setting['template_list']."')"?>
	<?php if($parentid) echo "change_parent_area($parentid);";?>
//-->
</script>