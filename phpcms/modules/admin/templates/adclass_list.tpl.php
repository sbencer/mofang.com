<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');?>

<form name="myform" action="?m=admin&c=position&a=listorder" method="post">
    <div class="pad_10">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th width="5%"  align="left">ID</th>
                    <th align="left" width="15%"><?php echo L('adclass_name');?></th>
                    <th width="15%"><?php echo L('adclass_parent_name');?></th>
                    <th width="20%"><?php echo L('adclass_operation');?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    printAdClass($formatAllClass)
                    ?>
                </tbody>
            </table>
    </div>
    </div>
</form>

<script type="text/javascript">
    function edit(id, name) {
        window.top.art.dialog({title:'<?php echo L('edit')?>--'+name, id:'edit', iframe:'?m=admin&c=adclass&a=edit&id='+id ,width:'500px',height:'360px'}, 	function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;
            var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
    }
</script>
</body>
</html>
