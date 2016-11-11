<?php
    defined('IN_ADMIN') or exit('No permission resources.');
    $show_dialog = $show_header = 1;
    include $this->admin_tpl('header');
?>

<?php if( $show_header ) { ?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) { echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';} else {$big_menu = '';} ?>
    <?php if(!$parentid) { echo admin::submenu($_GET['menuid'],$big_menu);} ?>
    </div>
</div>
<?php } ?>

<?php if( $parentid ) {?>
<p style="padding-left:10px;">
    <span style="color:purple;">當前位置:&nbsp;<?php echo $curr_parent_name;?> </span>
</p>
<?php }?>

<style type="text/css">
    html{_overflow-y:scroll}
</style>

<form name="myform" action="?m=partition&c=partition&a=listorder" method="post">
    <div class="pad_10">
        <div class="bk10"></div>
        <div class="table-list">
            <table width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <th width="38"><?php echo L('listorder');?></th>
                        <!-- <th width="100">活動id</th> -->
                        <th>活動名稱</th>
                        <th width="100">活動英文標識</th>
                        <th width="100">活動單頁標識</th>
                        <th width="400"><?php echo L('operations_manage');?></th>
                    </tr>
                </thead>
                <tbody>
                <?php echo $categorys;?>
                </tbody>
            </table>

            <div class="btn">
                <input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
                <input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" />
            </div>
        </div>
    </div>
</form>

<script language="JavaScript">
<!--
    window.top.$('#display_center_id').css('display','none');
//-->
</script>

<script type="text/javascript">

function import_c(id) {
    window.top.art.dialog({id:'import'}).close();
    window.top.art.dialog({title:'<?php echo L('import_news')?>--', id:'import', iframe:'?m=partition&c=partition&a=import&specialid='+id ,width:'700px',height:'500px'}, function(){var d = window.top.art.dialog({id:'import'}).data.iframe;// 使用內置接口獲取iframe對象
    var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'import'}).close()});
}

</script>
</body>
</html>
