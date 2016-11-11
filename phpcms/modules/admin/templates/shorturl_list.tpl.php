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
                    <th width="15%"><?php echo L('shorturl_original_url');?></th>
                    <th width="20%"><?php echo L('shorturl_short');?></th>
                    <th width="20%"><?php echo L('shorturl_option');?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($infos as $val) {
                ?>
                    <tr>
                        <td><?=$val['id']?></td>
                        <td><?=$val['cname']?></td>
                        <td><?=$val['url']?></td>
                        <td>
                            <?php
                                if($val['webhost'] == 1){
                                    echo shorturlDefine::$webs[$val['webhost']] . '/api.php?op=shorturl&url=' . $val['shorturl'];
                                } else {
                                    echo shorturlDefine::$webs[$val['webhost']] . '/' . $val['shorturl'];
                                }
                            ?>

                            </td>
                        <td><a href="?m=admin&c=shorturl&a=shortUrlDelete&id=<?=$val['id']?>" onclick="return confirm('<?=L('shorturl_delete_confirm')?>')"><?=L('shorturl_delete')?></a></td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div id="pages"><?php echo $this->db->pages;?></div>
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
