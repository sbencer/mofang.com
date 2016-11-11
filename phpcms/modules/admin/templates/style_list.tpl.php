<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header','admin');
?>
<div class="pad-lr-10">

<!--增加專區文件目錄-->
<div class="bk10"></div>	
<div id="searchid">
<form name="searchform" action="index.php?m=admin&c=ztzip&a=add_zt_name" method="post">
<input type="hidden" value="admin" name="m">
<input type="hidden" value="ztzip" name="c">
<input type="hidden" value="add_zt_name" name="a">  
<input type="hidden" value="<?php echo $_SESSION['pc_hash'];?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
<tbody>
<tr>
<td>
	<div class="explain-col">
		<input name="zt_name" id="zt_name" type="text" value="" class="input-text" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')">
		<input type="submit" name="dosubmit_add_ztname" class="button" value="增加專區目錄"> (*只能輸入英文和字母)
	</div>
</td>
</tr>
</tbody>
</table>
</form>
</div>

<div class="table-list">
<form action="?m=admin&c=ztzip&a=updatename" method="post">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="80">專區英文標識</th>
		<th>對應中文名稱</th>
		<th>添加作者</th>
		<th>狀態</th>
		<th width="250">操作</th>
		</tr>
        </thead>
<tbody>
<?php 
if(is_array($list)):
	foreach($list as $v):
?>
<tr>
<td width="80" align="center"><?php echo $v['dirname']?></td>
<td align="center"><input type="text" name="name[<?php echo $v['dirname']?>]" value="<?php echo $v['name']?>" /></td>
<td align="center"><?php if($v['homepage']) {echo  '<a href="'.$v['homepage'].'" target="_blank">';}?><?php echo $v['author']?><?php if($v['homepage']) {echo  '</a>';}?></td>
<td align="center"><?php if($v['disable']){echo L('icon_locked');}else{echo L("icon_unlock");}?></td>
<td align="center"  width="150"><a href="" onclick="javascript:window.top.art.dialog({id:'import',iframe:'?m=admin&c=ztzip&a=zt_upload&zt_name=<?php echo $v['dirname']?>', title:'專區專題上傳', width:'600', height:'400', lock:true}, function(){var d = window.top.art.dialog({id:'import'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'import'}).close()});void(0);">上傳專題</a> | <a href="?m=admin&c=zt_file&a=init&zt_name=<?php echo $v['dirname']?>">專題列表</a> </td>
</tr>
<?php 
	endforeach;
endif;
?> 

</tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="<?php echo L('submit')?>" /></div> 
</form>
</div>
</div>
<div id="pages"><?php echo $pages?></div>
</body>
</html>