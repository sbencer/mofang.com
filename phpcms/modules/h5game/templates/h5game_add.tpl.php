<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
	<form method="post" action="?m=h5game&c=h5game&a=add" name="myform" id="myform">
		<fieldset>
			<legend>H5遊戲添加</legend>
			<table class="table_form" width="100%" cellspacing="0">
				<tbody> 
					<tr>
						<th><strong>圖標上傳：</strong></th>
						<td>
							<div>
								<?php echo form::images('info[icon]', 'icon', $image, 'content');?>
							</div>
						</td>
					</tr>
					<tr>
						<th><strong>縮略圖上傳：</strong></th>
						<td>
							<div>
								<?php echo form::images('info[thumb]', 'thumb', $thumb_image, 'content_thumb');?>
							</div>
						</td>
					</tr>
					<tr>
						<th><strong>遊戲名：</strong></th>
						<td><input name="info[gamename]" id="gamename" class="input-text" type="text" size="50" value=""/></td>
					</tr>
					<tr>
						<th><strong>簡介：</strong></th>
						<td>
							<textarea style="height: 100px; width: 400px;" id="description" cols="20" rows="3" name="info[description]" class="input-text"></textarea>
						</td>
					</tr>


					<tr>
						<th><strong>詳情：</strong></th>
						<td>
							<textarea style="height: 100px; width: 400px;" id="content" cols="20" rows="3" name="info[content]" class="input-text"></textarea>
						</td>
					</tr>

					<tr>
						<th><strong>遊戲鏈接：</strong></th>
						<td><input name="info[link]" id="link" class="input-text" type="text" size="50" value=""/></td>
					</tr>
					<tr>
						<th><strong>大小：</strong></th>
						<td><input name="info[size]" id="size" class="input-text" type="text" size="20" value=""/>(示例：10M )</td>
					</tr>

					<tr>
						<th><strong>熱度值：</strong></th>
						<td><input name="info[hot]" id="hot" class="input-text" type="text" size="20" value=""/></td>
					</tr>

					<tr>
						<th><strong>支持平台：</strong></th>
						<td>
							<label class="ib" style="width:120px"><input type="checkbox" name="info[android]" id="android" value="1"> 安卓</label>
							<label class="ib" style="width:120px"><input type="checkbox" name="info[ios]" id="ios" value="1"> IOS</label>
							<label class="ib" style="width:120px"><input type="checkbox" name="info[ipad]" id="ipad" value="1"> IPAD</label>
						</td>
					</tr>


					<tr>
						<th><strong>所屬分類：</strong></th>
						<td> 
							<select name="info[category]" id="category">
								<option value="1">休閒類</option>
								<option value="2">益智類</option>
								<option value="3">冒險類</option>
								<option value="4">體育類</option>
								<option value="5">射擊類</option>
								<option value="6">策略類</option>
								<option value="7">敏捷類</option>
							</select>
						</td>
					</tr>

					<tr>
						<th><strong>狀態：</strong></th>
						<td>
							<select name="info[status]" id="status">
								<option value="99">開放</option>
								<option value="0">關閉</option> 
							</select>
						</td>
					</tr> 
				</tbody>
			</table>
			
			<div class="bk15"></div>
			<input type="submit" value="提交" class="button" name="dosubmit" id="dosubmit">
		</fieldset>
	</form>
</div>
