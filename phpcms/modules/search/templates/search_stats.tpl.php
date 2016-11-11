<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad_10">
<div class="table-list">
<table width="100%" cellspacing="0">
    <thead>
    <tr>
    <th>搜索排名</th>
    <th>關鍵字</th>
    <th>小時搜索量</th>
    <th>今日搜索量</th>
    <th>本周搜索量</th>
    <th>本月搜索量</th>
    <th>總搜索量</th>
    </tr>
    </thead>
    <tbody>
<?php 
if(is_array($datas)):
	foreach($datas as $k=>$v):
?>
<tr>
<td align="center"><?php echo ($this->page-1)*$this->perpage+$k+1?></td>
<td align="center"><?php echo $v['keyword']?></td>
<td align="center"><?php echo $v['hourviews']?></td>
<td align="center"><?php echo $v['dayviews']?></td>
<td align="center"><?php echo $v['weekviews']?></td>
<td align="center"><?php echo $v['monthviews']?></td>
<td align="center"><?php echo $v['views']?></td>
</tr>
<?php 
	endforeach;
endif;
?>
</tbody>
</table>
<div class="btn">
</div>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
<script type="text/javascript">
<!--
function edit(id, name) {
	
	window.top.art.dialog({title:'<?php echo L('editing_data_sources_call')?>《'+name+'》',id:'edit',iframe:'?m=tag&c=tag&a=edit&id='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}

function copy_text(matter){

	matter.select();

	js1=matter.createTextRange();

	js1.execCommand("Copy");

	alert('<?php echo L('copy_code');?>');

	}

//-->
</script>
</body>
</html>
