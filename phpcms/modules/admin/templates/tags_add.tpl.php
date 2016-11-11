<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<form method="post" action="?m=admin&c=linktag&a=tags_add" id="myform" name="myform">
	<div class="pad-10">
		<div class="col-tab">
		<ul class="tabBut cu-li">
			<li onclick="SwapTab('setting','on','',6,1);" class="on" id="tab_setting_1">基本選項</li>
		</ul>
				<div class="contentList pad-10" id="div_setting_1">
					<table width="100%" class="table_form">
						<tbody>
							<tr style="color:red">*多個請以回車隔開</tr><br>
							<tr>
								<textarea name="tags" id="tags" cols="60" rows="10"></textarea>
							</tr><br>
							<tr> 
							<?php echo L('chose_item');?>： 
							<select name='parent_id' id="">
										<option value="0">作為一級分類</option>
										<?php echo $item;?>
										</select>
							</tr><br>
							<input type="submit" class="button" name="submit" value="提交" />
						</tbody>
					</table>
				</div>
		</div>
	</div>

<input type="hidden" name="pc_hash" value="kMr4sv" />
</form>