<?php 
defined('IN_ADMIN') or exit('No permission resources.'); 
$show_header = 1;
include $this->admin_tpl('header','admin');
?>

<div class="subnav"> 
    <div class="content-menu ib-a blue line-x">
        <a class="add fb" href="?m=partition&c=activity&a=add&menuid=&catid=<?php echo $_GET['catid'];?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>"><em><?php echo L('add_activity');?></em></a> | 
        <a class="fb" href="?m=partition&c=partition&a=init"><em><?php echo '返回專區列表';?></em></a>
    </div>
</div>

<div id="searchid" >
    <form name="searchform" action="" method="get">
        <input type="hidden" value="partition" name="m">
        <input type="hidden" value="activity" name="c">
        <input type="hidden" value="manage" name="a">
        <input type="hidden" value="<?php echo $_GET['catid']; ?>" name="catid">
        <input type="hidden" value="<?php echo $_SESSION['pc_hash']; ?>" name="pc_hash">
        <table width="96%" cellspacing="0" class="search-form" style="margin-left: 20px;">
            <tbody>
                <tr>
                    <td>
                        <div class="explain-col">
                        標題背景色：<input id="bgcolor" name="bgcolor" type="text" value="<?php echo $data['color_t']?:"#fff"; ?>" class="iColorPicker" readonly />&nbsp;&nbsp;
                        進行中活動：<input id="oncolor" name="oncolor" type="text" value="<?php echo $data['color_o']?:"#fff"; ?>" class="iColorPicker" readonly />&nbsp;&nbsp;
                        未來的活動：<input id="wlcolor" name="wlcolor" type="text" value="<?php echo $data['color_w']?:"#fff"; ?>" class="iColorPicker" readonly />&nbsp;&nbsp;
                        超鏈接顏色：<input id="lkcolor" name="lkcolor" type="text" value="<?php echo $data['color_l']?:"#fff"; ?>" class="iColorPicker" readonly />&nbsp;&nbsp;
                        <input type="submit" name="search" class="button" value="提交修改">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
   
<div class="pad-10">
<div class="table-list">
<form name="myform" action="?m=partition&c=content&a=listorder&specialid=<?php echo $_GET['specialid']?>" method="post">
    <table width="100%">
        <thead>
            <tr>
			<th width="40"><input type="checkbox" value="" id="check_box" onclick="selectall('id[]');"></th>
            <th width="60">ID</th>
			<th><?php echo L('content_title')?></th>
			<th width="120"><?php echo '週期任務';?></th>
            <th width="120"><?php echo L('start_time')?></th>
            <th width="120"><?php echo L('end_time')?></th>
			<th width="200"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
<tbody>
    <?php foreach ($lists as $r) {
    ?>
        <tr>
		<td align="center" width="40"><input class="inputcheckbox " name="id[]" value="<?php echo $r['id'].'-'.$r['sort_value'];?>" type="checkbox"></td>
		<td align='center' width="60"><?php echo $r['id'];?></td>
		<td><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></td>
        <?php $circle = array('','星期一','星期二','星期三','星期四','星期五','星期六','星期日',9=>'非週期'); ?>
		<td align='center' width="90"><?php echo $circle[$r['circle']];?></td>
		<td align='center' width="120"><?php if($r['limit_time'] == 0) {echo format::date($r['start_time'],1);}else{echo '0000-00-00 --:--:--';}?></td>
		<td align='center' width="120"><?php if($r['limit_time'] == 0) {echo format::date($r['end_time'],1);}else{echo '0000-00-00 --:--:--';}?></td>
		<td align='center'><a href='?m=partition&c=activity&a=edit&catid=<?php echo $r['pid'];?>&id=<?php echo $r['id']?>','')"><?php echo L('edit');?></a> 
        &nbsp;&nbsp;
        <a href="javascript:confirmurl('?m=partition&c=activity&a=delete&partitionid=<?php echo $r['pid'] ?>&id=<?php echo $r['id'];?>','確認要刪除 『 <?php echo $r['title'] ?> 』 嗎？')">刪除</a>
        </td>
	</tr>
     <?php }?>
</tbody>
     </table>
    <div class="btn" <?php  if($is_search==1){?> style="display:none;"<?php }?>>
        <label for="check_box"><?php echo L('selected_all')?>/<?php echo L('cancel')?></label>
        <input type="submit" class="button" value="<?php echo L('listorder')?>" onclick="myform.action='?m=partition&amp;c=content&amp;a=listorder&amp;dosubmit=1&amp;specialid=<?php echo $_GET['specialid']?>';myform.submit();"/>
        <input type="submit" class="button" value="<?php echo L('delete')?>" onclick="if(confirm('<?php echo L('confirm', array('message' => L('selected')))?>')){document.myform.action='?m=partition&c=content&a=delete&specialid=<?php echo $_GET['specialid']?>'}else{return false;}"/>
    </div>
    <div id="pages"><?php echo $pages;?></div>
</form>
</div>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript">
setcookie('refersh_time', 0);
function refersh_window() {
	var refersh_time = getcookie('refersh_time');
	if(refersh_time==1) {
		window.location.reload();
	}
}

setInterval("refersh_window()", 5000);
</script>
</body>
</html>
