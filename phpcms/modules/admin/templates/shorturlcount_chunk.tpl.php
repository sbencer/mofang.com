<?php
/**
 * 这个是原来的表格的表现形式
 */
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<div class="pad_10">
    <div class="common-form">
        <form action="?m=admin&c=shorturlcount&a=index" method="get">
            <table width="100%" class="table_form contentWrap">
                <input type="hidden" name="m" value="admin"/>
                <input type="hidden" name="c" value="shorturlcount"/>
                <input type="hidden" name="a" value="index"/>
                <input type="hidden" name="menuid" value="<?=$_GET['menuid']?>" />
                <tr>
                    <td  width="80"><?php echo L('shorturlcount_time')?></td>
                    <td>
                        <input type="text" name="begintime" value="" class="input-text" /> -
                        <input type="text" name="endtime" value="" class="input-text" />  <?=L('shorturlcount_timelabel')?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo L('shorturl_pname');?></td>
                    <td>
                        <select name="cid[]" multiple>
                            <?php
                            printSelect($formatAllClass, $level=0);
                            ?>
                        </select>
                    </td>
                </tr>
            </table>

            <div class="bk15"></div>

            <Input type="submit" />
        </form>

            <?php
                if ($shorturlData) {
            ?>
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td><?=L('adclass_name')?></td>
                    <td><?=L('shorturl_short')?></td>
                    <td><?=L('shorturl_original_url')?></td>
                    <td><?=L('shorturlcount_count')?></td>
                </tr>
                <?php foreach ($shorturlData as $val) {?>
                    <tr>
                        <td><?=$allClassData[$val['cid']]['name']?></td>
                        <td><?=$val['shorturl']?></td>
                        <td><?=$val['url']?></td>
                        <td><?php echo empty($shorturlcount[$val['id']]['total']) ? 0 : $shorturlcount[$val['id']]['total'];?></td>
                    </tr>
                <?php }?>
            </table>
            <?php
                }
            ?>

    </div></div>
</body>
</html>


