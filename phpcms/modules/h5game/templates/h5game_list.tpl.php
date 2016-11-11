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
<a href="index.php?m=h5game&c=h5game&a=position&positionid=5&menuid=<?php echo $_GET['menuid'];?>">android排行</a>  &nbsp;&nbsp;
<a href="index.php?m=h5game&c=h5game&a=position&positionid=6&menuid=<?php echo $_GET['menuid'];?>">ios排行</a>  
</div>


        </td>
        </tr>
    </tbody>
</table>

<form name="searchform" action="" method="get"> 
<input type="hidden" value="h5game" name="m">
<input type="hidden" value="h5game" name="c">
<input type="hidden" value="init" name="a">	
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td align="left">
		<div class="explain-col"> 
				關鍵字：<input name="keywords" type="text" value="" style="width:330px;" class="input-text">
				<input type="submit" name="search_dosubmit" class="button" value="搜索">
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form name="myform" action="" method="post">
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th width="35" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
					<th align="center">圖標</th>
					<th align="center">遊戲名稱</th>
					<th align="center">是否支持安卓</th>
					<th align="center">是否支持IOS</th>
					<th align="center">是否支持IPAD</th>
					<th align="center">來源</th>
					<th align="center">狀態</th>
					<th width="180" align="center">管理操作</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(is_array($records)){
					foreach ($records as $re) { 
				?>
					<tr>
						<td align="center"><input type="checkbox" name="id[]" value="<?php echo $re['id']?>"></td>
						<td align="center">
							<?php if($re['comefrom']==1){?>
								<a href="<?php echo APP_PATH;?>h5games/<?php echo urlencode($re['gamename']);?>/index/index.html" target="_blank" title="打開玩一下"><img src="<?php echo $re['icon'];?>" width="50" height="50"></a>
							<?php }else{?>
								<a href="<?php echo $re['link'];?>" target="_blank" title="打開玩一下"><img src="<?php echo $re['icon'];?>" width="50" height="50"></a>
							<?php } ?>
						</td>
						<td align="center"><?php echo $re['gamename']?></td>
						<td align="center"><?php if($re['ios']=='1'){ echo "支持";  }else{ echo "<font color=red>不支持</font>";}?></td>
						<td align="center"><?php if($re['android']=='1'){ echo "支持";  }else{ echo "<font color=red>不支持</font>";}?></td>
						<td align="center"><?php if($re['ipad']=='1'){ echo "支持";  }else{ echo "<font color=red>不支持</font>";}?></td>
						<td align="center"><?php if($re['comefrom']==1){echo '抓取';}else{echo '<font color=red>手動添加</font>';}?></td>
						<td align="center"><?php if($re['status']==99){echo '正常';}else{echo '關閉';}?></td>
						<td align="center">
							<a href="?m=h5game&c=h5game&a=edit&id=<?php echo $re['id'];?>"><?php echo L('edit');?></a> |
							<a href='?m=h5game&c=h5game&a=delete&id=<?php echo new_addslashes($re['id']);?>' onClick="return confirm('<?php echo L('vote_confirm_del');?>')"><?php echo L('delete');?></a>
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
			<a href="#" onClick="javascript:$('input[type=checkbox]').attr('checked', false)"><?php echo L('cancel')?></a>
			<input name="submit" type="submit" class="button" value="確認刪除" onClick="document.myform.action='?m=h5game&c=h5game&a=delete';return confirm('確認刪除')">&nbsp;&nbsp;
			<input type="button" class="button" value="推送" onclick="push();">
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

	//推薦到遊戲推薦位
	function push() {
	var str = 0;
	var id = tag = '';
	$("input[name='id[]']").each(function() {
		if($(this).attr('checked')=='checked') {
			str = 1;
			id += tag+$(this).val();
			tag = '|';
		}
	});
	if(str==0) {
		alert('您沒有勾選信息');
		return false;
	}


	window.top.art.dialog({id:'push'}).close();
	window.top.art.dialog({title:'推送遊戲推薦位：',id:'push',iframe:'?m=h5game&c=h5game&a=push&ids='+id,width:'800',height:'500'}, function(){var d = window.top.art.dialog({id:'push'}).data.iframe;// 使用內置接口獲取iframe對象
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'push'}).close()});
} 
</script> 
</body>
</html>