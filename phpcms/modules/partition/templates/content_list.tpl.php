<?php 
defined('IN_ADMIN') or exit('No permission resources.'); 
$show_header = 1;
include $this->admin_tpl('header','admin');
?>

<div class="subnav"> 
<div class="content-menu ib-a blue line-x">
　<?php if(isset($big_menu)) { foreach($big_menu as $big) { echo '<a class="add fb" href="'.$big[0].'"><em>'.$big[1].'</em></a>　'; } }?>&nbsp;<a class="on" href="?m=partition&c=partition&a=init&parentid=<?php echo $the_parentid; ?>"><em><?php echo '返回欄目列表';?></em></a></div>

    	<p style="margin-top:5px;padding-left:10px;">
		<span style="color:purple;">當前位置:&nbsp;<?php echo $curr_parent_name;?> </span>
	</p>


<!-- <a href="?m=partition&c=partition&a=init&parentid=<?php echo $parentid;?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>" ><em>返回欄目列表</em></a> -->
</div>

 

<div id="searchid" >
<form name="searchform" action="" method="get">
<input type="hidden" value="partition" name="m">
<input type="hidden" value="partition" name="c">
<input type="hidden" value="search_article" name="a">
<input type="hidden" value="1317" name="catid">
<input type="hidden" value="<?php echo $parentid;?>" name="parentid">
<input type="hidden" value="0" name="steps">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $_SESSION['pc_hash']; ?>" name="pc_hash">
<table width="96%" cellspacing="0" class="search-form" style="margin-left: 20px;">
    <tbody>
        <tr>
        <td>
        <div class="explain-col">
 
                添加時間：
                <link rel="stylesheet" type="text/css" href="http://www.mofang.com/statics/js/calendar/jscal2.css">
            <link rel="stylesheet" type="text/css" href="http://www.mofang.com/statics/js/calendar/border-radius.css">
            <link rel="stylesheet" type="text/css" href="http://www.mofang.com/statics/js/calendar/win2k.css">
            <script type="text/javascript" src="http://www.mofang.com/statics/js/calendar/calendar.js"></script>
            <script type="text/javascript" src="http://www.mofang.com/statics/js/calendar/lang/en.js"></script><input type="text" name="start_time" id="start_time" value="" size="10" class="date input-text" readonly="">&nbsp;<script type="text/javascript">
            Calendar.setup({
            weekNumbers: false,
            inputField : "start_time",
            trigger    : "start_time",
            dateFormat: "%Y-%m-%d",
            showTime: false,
            minuteStep: 1,
            onSelect   : function() {this.hide();}
            });
        </script>- &nbsp;<input type="text" name="end_time" id="end_time" value="" size="10" class="date input-text" readonly="">&nbsp;<script type="text/javascript">
            Calendar.setup({
            weekNumbers: false,
            inputField : "end_time",
            trigger    : "end_time",
            dateFormat: "%Y-%m-%d",
            showTime: false,
            minuteStep: 1,
            onSelect   : function() {this.hide();}
            });
        </script>               
                <select name="posids"><option value="" selected="">全部</option>
                <option value="1">推薦</option>
                <option value="2">不推薦</option>
                </select>               
                <select name="searchtype">
                    <option value="0" selected="">標題</option>
                    <option value="1">簡介</option>
                    <option value="2">用戶名</option>
                    <option value="3">ID</option>
                </select>
                
                <input name="keyword" type="text" value="" class="input-text">
                <input type="submit" name="search" class="button" value="搜索">
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
            <th width="37"><?php echo L('listorder');?></th>
            <th width="60">ID</th>
			<th><?php echo L('content_title')?></th>
			<th width="120"><?php echo L('for_type')?></th>
            <th width="90"><?php echo L('inputman')?></th>
            <th width="120"><?php echo L('input_time')?></th>
			<th width="200"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
<tbody>
    <?php foreach ($datas as $r) {
    	if ($r['curl']) {
    		$content_arr = explode('|', $r['curl']);
    		$r['url'] = go($content_arr['1'], $content_arr['0']);
    	}
    ?>
        <tr>
		<td align="center" width="40"><input class="inputcheckbox " name="id[]" value="<?php echo $r['id'].'-'.$r['sort_value'];?>" type="checkbox"></td>
        <td align='center' width="37"><input name="listorders[<?php echo $r['id']?>]" type="text" size="3" value="<?php echo $r['listorder'];?>" class="input-text-c input-text"/></td>
		<td align='center' width="60"><?php echo $r['id'];?></td>
		<td><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></td>
		<td align='center' width="120"><?php echo $r['sort_name'];?></td>
		<td align='center' width="90"><?php echo $r['username'];?></td>
		<td align='center' width="120"><?php echo format::date($r['inputtime'],1);?></td>
		<!-- <td align='center' width="200"><a href="javascript:;" onclick="javascript:openwinx('?m=partition&c=content&a=edit&specialid=<?php echo $r['specialid']?>&id=<?php echo $r['id']?>','')"><?php echo L('content_edit')?></a> </td> -->
		<td align='center'><a href="javascript:;" onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $r['catid'];?>&id=<?php echo $r['id']?>','')"><?php echo L('edit');?></a> 
        
        <!--
        &nbsp;&nbsp;
        <a href="javascript:confirmurl('?m=partition&c=partition&a=delete&partitionid=<?php echo $r[''] ?>&id=<?php echo $r['id'];?>','確認要刪除 『 極品評測 』 嗎？')">刪除</a>
        -->
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
