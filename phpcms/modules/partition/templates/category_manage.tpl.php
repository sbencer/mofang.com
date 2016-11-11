<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<div class="pad_10">

<div class="bk10"></div>
<?php if($is_search){
?>

<div id="searchid">
<form name="searchform" action="" method="get">
<input type="hidden" value="partition" name="m">
<input type="hidden" value="partition" name="c">
<input type="hidden" value="search_article" name="a">
<input type="hidden" value="1317" name="catid">
<input type="hidden" value="<?php echo $parentid;?>" name="parentid">
<input type="hidden" value="0" name="steps">
<input type="hidden" value="1" name="search">
<input type="hidden" value="<?php echo $_SESSION['pc_hash']; ?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
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
                <input type="button" name="all_article" class="button" value="查看當前專區最近文章發布" onclick="javascript:window.top.art.dialog({id:'import',iframe:'?m=partition&c=content&a=init_all&partitionid=<?php echo $_GET['parentid'];?>', title:'查看當前專區文章', width:'800', height:'400', lock:true}, function(){var d = window.top.art.dialog({id:'import'}).data.iframe;return false;});void(0);"> 

                </div>
        </td>
        </tr>
    </tbody>
</table>
</form>
</div>
<?php } else { ?>
<div id="searchid">
<form name="searchform" action="" method="get">
<input type="hidden" value="partition" name="m">
<input type="hidden" value="partition" name="c">
<input type="hidden" value="init" name="a"> 
<input type="hidden" value="<?php echo $_SESSION['pc_hash']; ?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
        <tr>
            <td>
                <div class="explain-col">
                    <input name="keyword" id="keyword" type="text" value="<?php echo $keyword; ?>" class="input-text">
                    <input type="submit" name="search" class="button" value="搜索专区"> 不填寫關鍵字搜索，顯示全部專區
                </div>
            </td>
        </tr>
    </tbody>
</table>
</form>
</div>

<?php } ?>


<form name="myform" action="?m=partition&c=partition&a=listorder" method="post">
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th width="38"><?php echo L('listorder');?></th>
            <th width="50"><?php if(!$parentid){ echo "分區id"; }else{ echo "欄目id";} ?></th>
            <th >分區名稱</th>
	    <th ><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php echo $categorys;?>
    </tbody>
    </table>

    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</form>

<div id="pages"><?php echo $pages;?></div>

</div>
</div>
<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>

<script type="text/javascript">

//導入文章 
function import_c(id) {
    window.top.art.dialog({id:'import'}).close();
    window.top.art.dialog({title:'<?php echo L('import_news')?>--', id:'import', iframe:'?m=partition&c=partition&a=import&specialid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'import'}).data.iframe;// 使用內置接口獲取iframe對象
    var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'import'}).close()});
}

//直接添加信息
function add_c(partition_id) {
    window.top.art.dialog({id:'add'}).close();
    window.top.art.dialog({title:'添加文章--', id:'add', iframe:'?m=partition&c=content&a=add&partition_id='+partition_id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'add'}).data.iframe;// 使用內置接口獲取iframe對象
    var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'add'}).close()});
}

</script>
</body>
</html>
