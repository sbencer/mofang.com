<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">

<div class="bk10"></div>
<div class="pad-lr-10">
<table width="85%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col"> 
		<a href="?m=admin&c=ztzip&a=zt_upload" >返回</a>
		</div>
		</td>
		</tr>
    </tbody>
</table>
<div class="table-list">
    <table width="85%" cellspacing="0">
        <thead>
		<tr>
		<th width="10%">ID</th>
		<th width="15%" align="left" ><?php echo L('username')?></th>
		<th width="15%" align="left" ><?php echo L('zip_name')?></th>
		<th width="15%" ><?php echo L('inputtime')?></th>
		<th width="15%" ><?php echo L('type')?></th>
		<th width="15%" ><?php echo L('edit_name')?></th>
		</tr>
        </thead>
        <tbody>
		<?php 
		if(is_array($infos)){
			foreach($infos as $info){
		?>
		<tr>
		<td width="10%" align="center"><?php echo $info['id']?></td>
		<td width="15%" ><?php echo $info['username']?></td>
		<td width="15%" ><?php echo $info['zip_file']?></td>
		<td width="15%"  class="text-c"><?php echo date("Y-m-d H:i:s",$info['inputtime'])?></td>
		<td width="15%"  class="text-c"><?php if($info['type'] == 1){echo "覆蓋舊目錄";}elseif($info['type']==0){echo "更新文件名";}elseif($info['type'] ==3){echo "正常操作";}?></td>
		<td width="15%" ><?php echo $info['new_file_name']?></td>
		</tr>
		<?php 
			}
		}
		?>
		
</tbody>
</table>
</div>
</div>

<div id="pages" style="width: 300px;"><?php echo $pages;?></div>
<script type="text/javascript">

</script>
</body>
</html>