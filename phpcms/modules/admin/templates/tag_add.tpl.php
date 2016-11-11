<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<form method="post" action="?m=admin&c=linktag&a=tag_add" id="myform" name="myform">
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li onclick="SwapTab('setting','on','',6,1);" class="on" id="tab_setting_1">基本選項</li>
</ul>
<div class="contentList pad-10" id="div_setting_1">
<table width="100%" class="table_form ">
	<tbody>
		<tr>
         <?php echo L('linktag_name');?>： <input type="text" name="tag_name" class="tag_in" value="四字以內"/>
		<span style="display:none;color:red;font-size:10px" id="tag_tip">該標簽已存在</span>
		<span style="display:none;color:red;font-size:10px" id="tag_tip2"></span>
		
		</tr><br>
		<tr> 
		<?php echo L('chose_item');?>： <select name='parent_id' id="">
					<option value="0">作為一級分類</option>
					<?php echo $item;?>
					</select>
		</tr><br>
		<input type="submit" class="button" name="submit" value="提交" />
	</tbody>
</table>
</div></div></div>

<input type="hidden" name="pc_hash" value="kMr4sv" />
</form>
<script>
	$('.tag_in').bind('focus',function(){
		$(this).val('');
	});
	$('.tag_in:first').bind('blur',function(){			
		var  a = "<?php echo $_SESSION['pc_hash'];?>";		
		var tag_name=$(this).val();
		if(tag_name == ''){
			$('#tag_tip2').text('不可為空');
			$('#tag_tip2').css({'display':'inline'});
		}else{
			$('#tag_tip2').css({'display':'none'});
		}		
		$.post('index.php?m  =  admin&c  =  linktag&a  =  tag_check',({'pc_hash':a,'tag_name':tag_name}),function(data){			
			if(data == 1){
				//1表示標簽已經存在
				$('#tag_tip').css({'display':'inline'});
			}else{
				$('#tag_tip').css({'display':'none'});				
			}
		});
	});
</script>