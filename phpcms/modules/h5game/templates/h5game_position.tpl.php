<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog=1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">

	<table width="100%" cellspacing="0" class="search-form">
    <tbody>
        <tr>
        <td>
<div class="explain-col">
<a href="index.php?m=h5game&c=h5game&a=position&positionid=1&menuid=<?php echo $_GET['menuid'];?>">今日推薦</a> &nbsp;&nbsp;
<a href="index.php?m=h5game&c=h5game&a=position&positionid=2&menuid=<?php echo $_GET['menuid'];?>">最佳更新</a> &nbsp;&nbsp;
<a href="index.php?m=h5game&c=h5game&a=position&positionid=3&menuid=<?php echo $_GET['menuid'];?>">最多人玩</a> &nbsp;&nbsp;
<a href="index.php?m=h5game&c=h5game&a=position&positionid=4&menuid=<?php echo $_GET['menuid'];?>">月排行</a> &nbsp;&nbsp;
<a href="index.php?m=h5game&c=h5game&a=position&positionid=5&menuid=<?php echo $_GET['menuid'];?>">android排行</a> &nbsp;&nbsp;
<a href="index.php?m=h5game&c=h5game&a=position&positionid=6&menuid=<?php echo $_GET['menuid'];?>">IOS排行</a> 
</div>
        </td>
        </tr>
    </tbody>
</table>

<form name="myform" id="myform" action="" method="post">
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
					<th align="center" width="40">排序</th>
					<th align="center" width="150">圖標</th>
					<th align="center">遊戲名稱</th>
					<th align="center">狀態</th>
					<th width="180" align="center">管理操作</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(is_array($array)){
					foreach ($array as $re) {
						// echo format::date( $re['time'] ,1);
				?>
					<tr>
						<td align="center"><input type="checkbox" name="id[]" value="<?php echo $re['id']?>"></td>
						<td align="center"><input type="text" name="listorders[<?php echo $re['id'];?>]" value="<?php echo $re['listorder']?>" size="5"></td>
						<td align="center"><a href="<?php echo $re['link'];?>" target="_blank" title="打開玩一下"><img src="<?php echo $re['icon'];?>" width="50" height="50"></a></td>
						<td align="center"><?php echo $re['gamename']?></td>
						<td align="center"><?php if($re['status']==99){echo '正常';}else{echo '關閉';}?></td>
						<td align="center">
							<a href='?m=h5game&c=h5game&a=position_setting&id=<?php echo $re['id'];?>' onClick="return confirm('確認改變其實狀態嗎?')">改變狀態</a>&nbsp;&nbsp;&nbsp;
							<a href='?m=h5game&c=h5game&a=position_delete&id=<?php echo $re['id'];?>' onClick="return confirm('確實刪除?')">刪除</a>
						</td>
					</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
		<div class="btn">
			<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', true)"><?php echo L('selected_all')?></a>/
			<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', false)"><?php echo L('cancel')?></a>&nbsp;&nbsp;
			<input type="button" class="button" value="排序" onclick="document.myform.action='?m=h5game&c=h5game&a=position&dosubmit=1';myform.submit();">
		</div>
	</div>
	<div id="pages"><?php echo $pages?></div>
</form>
</div>
<script type="text/javascript">
	//修改
	function edit(id, name) {
		window.top.art.dialog({id:'edit'}).close();
		window.top.art.dialog(
			{title:'<?php echo L('edit')?> '+name+' ',id:'edit',iframe:'?m=h5game&c=h5game&a=edit&id='+id,width:'700',height:'300'},
			function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;},
			function(){window.top.art.dialog({id:'edit'}).close()}
		);
	}
</script>
</body>
</html>