<?php
/**
 * 这个是用那个chart的数据，然后形成的一个页面，如果这个建好后那个就没有用了chunk可以删除的
 */
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<div class="pad_10">
    <div class="common-form">
        <form action="?m=admin&c=shorturlcount&a=chartCount" method="get">
            <table width="100%" class="table_form contentWrap">
                <input type="hidden" name="m" value="admin"/>
                <input type="hidden" name="c" value="shorturlcount"/>
                <input type="hidden" name="a" value="chartCount"/>
                <input type="hidden" name="showType" value="chunk"/>
                <input type="hidden" name="menuid" value="<?=$_GET['menuid']?>" />
                <tr>
                    <td  width="80"><?php echo L('shorturlcount_time')?></td>
                    <td>
                        <input type="text" name="begintime"  class="input-text" value="<?php if(!empty($begintime)){ echo date('Y-m-d', $begintime);}else{
                            echo $begintime;
                        }?>"/> -
                        <input type="text" name="endtime"  class="input-text"  value="<?php if(!empty($endtime)){ echo date('Y-m-d', $endtime);}?>"/>  <?=L('shorturlcount_timelabel')?> （20130205）
                    </td>
                </tr>
                <tr>
                    <td><?php echo L('shorturl_pname');?></td>
                    <td>
                        <select name="cid[]" multiple>
                            <?php
                            printSelect($formatAllClass, 0, $cid);
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo L('shorturl_type');?></td>
                    <td>
                        <input type="radio" name="type" value="day" <?php if (isset($type)) { echo $type=='day'? 'checked="checked"' : '';}?>/><?php echo L('shorturl_type_day');?>
                        <input type="radio" name="type" value="week" <?php if (isset($type)) { echo $type=='week'? 'checked="checked"' : '';}?>/><?php echo L('shorturl_type_week');?>
                        <input type="radio" name="type" value="month" <?php if (isset($type)) { echo $type=='month'? 'checked="checked"' : '';}?>/><?php echo L('shorturl_type_monty');?>
                    </td>
                </tr>
            </table>

            <div class="bk15"></div>

            <Input type="submit" />
            <a href="<?php
            if (isset($_GET['cid'])) {
                $queryData = array(
                    'menuid' => $_GET['menuid'],
                    'begintime' => $_GET['begintime'],
                    'endtime' => $_GET['endtime'],
                    'pc_hash' => $_GET['pc_hash'],
                    'type' => $_GET['type'],
                    'showType' => 'chart',
                    'cid' => $cid
                );
                printf('?m=admin&c=shorturlcount&a=chartCount&%s',
                    http_build_query($queryData)
                );
            } else {
                printf('?m=admin&c=shorturlcount&a=chartCount&menuid=%s&pc_hash=%s&showType=chart',
                    $_GET['menuid'], //menuid
                    $_GET['pc_hash']
                );
            }
            ?>"><?=L('shorturl_menu_chart_m')?></a>


            <a href="<?php
            if (isset($_GET['cid'])) {
                $queryData = array(
                    'menuid' => $_GET['menuid'],
                    'begintime' => $_GET['begintime'],
                    'endtime' => $_GET['endtime'],
                    'pc_hash' => $_GET['pc_hash'],
                    'type' => $_GET['type'],
                    'showType' => 'excel',
                    'cid' => $cid,
                );
                printf('?m=admin&c=shorturlcount&a=chartCount&%s',
                    http_build_query($queryData)
                );
            }
            ?>"><?=L('excel_button_name')?></a>
        </form>

            <?php
                if ($shorturlData) {
            ?>
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td><?=L('adclass_name')?></td>
                    <td><?=L('shorturl_original_url')?></td>
                    <td><?=L('shorturl_short')?></td>
                    <td><?=L('shorturl_date')?></td>
                    <td><?=L('shorturlcount_count')?></td>
                    <td><?=L('shorturlcount_uniquecount')?></td>
                    <td><?=L('shorturlcount_facebookcount')?></td>
                    <td><?=L('shorturlcount_twittercount')?></td>
                    <td><?=L('shorturlcount_plurkcount')?></td>
                    <td><?=L('shorturlcount_googlecount')?></td>
                    <td><?=L('shorturlcount_yahoocount')?></td>
                    <td><?=L('shorturlcount_baiducount')?></td>
                    <td><?=L('shorturlcount_othercount')?></td>
                </tr>
                <?php foreach ($shorturlData as $val) {?>
                    <?php foreach ($chartData[$val['id']] as $index=>$valTotal) {?>
                    <tr>
                        <td><?=$allClassData[$val['cid']]['name']?></td>
                        <td><?=$val['url']?></td>
                        <td><?=$val['shorturl']?></td>
                        <td><?php
                            switch($type) {
                                case 'day':
                                    echo date("Y/m/d", $index);
                                    break;
                                case 'week':
                                    echo substr($index, 0, 4) . "年" . substr($index, 4, 2) ."周";
                                    break;
                                case 'monty':
                                    echo substr($index, 0, 4) . "年" . substr($index, 4, 2) ."月";
                                    break;
                            }?></td>
                        <td><?php echo  $valTotal['total'];?></td>
                        <td><?php echo  $valTotal['uniquetotal'];?></td>
                        <td><?php echo  $valTotal['facebooktotal'];?></td>
                        <td><?php echo  $valTotal['twittertotal'];?></td>
                        <td><?php echo  $valTotal['plurktotal'];?></td>
                        <td><?php echo  $valTotal['googletotal'];?></td>
                        <td><?php echo  $valTotal['yahoototal'];?></td>
                        <td><?php echo  $valTotal['baidutotal'];?></td>
                        <td><?php echo  $valTotal['othertotal'];?></td>
                    </tr>
                    <?php }?>
                <?php }?>
            </table>
            <?php
                }
            ?>

    </div></div>
</body>
</html>


