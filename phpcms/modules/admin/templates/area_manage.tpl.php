<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>
<form name="myform" action="?m=admin&c=area&a=listorder" method="post">
<div class="pad-10">
<div class="content-menu ib-a blue line-x">
<a class="add fb" href="?m=admin&c=area&a=add&productid=<?php echo $productid;?>&pc_hash=<?php echo $_SESSION['pc_hash'];?>" target="right"><em><?php echo L('add_sub_area');?></em></a>　
</div>
<div class="explain-col">
<?php echo L('area_cache_tips');?>，<a href="?m=admin&c=area&a=public_cache&menuid=43&module=admin"><?php echo L('update_cache');?></a>
</div>
<div class="bk10"></div>
<div class="table-list">
    <table width="100%" cellspacing="0" >
        <thead>
            <tr>
            <th width="40"><?php echo L('category');?>ID</th>
            <th ><?php echo L('area_item_name');?></th>
            <th align='center' width='80'><?php echo L('area_category_name');?></th>
            <th align='center' width="40"><?php echo L('items');?></th>
            <th align='center' width="30"><?php echo L('vistor');?></th>
			<th width="250"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
    <tbody>
    <?php echo $areas;?>
    </tbody>
    </table>

    <div class="btn">
	<input type="hidden" name="pc_hash" value="<?php echo $_SESSION['pc_hash'];?>" />
	<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" /></div>  </div>
</div>
</div>
</form>
</body>
</html>
