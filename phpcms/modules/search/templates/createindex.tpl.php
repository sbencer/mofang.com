<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');?>
<div class="pad-10">
<div class="explain-col">
    重建索引將會清空原有的所有的索引內容 , 默認每輪更新100條 , 您可以在下面指定想要重建索引的類別 ！
</div>
<div class="bk10"></div>

<div class="table-list">
<table width="100%" cellspacing="0">

    <form action="" method="get">
        <input type="hidden" name="m" value="search">
        <input type="hidden" name="c" value="search_admin">
        <input type="hidden" name="a" value="createindex">
        <input type="hidden" name="menuid" value="909">
            <thead>
                <tr>
                    <th align="center" width="150">選擇需要更新的類別</th>
                    <th align="center">選擇操作內容</th>
                </tr>
            </thead>
            <tbody height="200" class="nHover td-line">
                <tr> 
                    <td align="center" rowspan="6" width="300">
                        <?php
                            foreach($datas as $_k=>$_v) {
                                if($_v['siteid']!=$this->siteid) continue;
                                $data[$_v['typeid']] = $_v['name'];
                            }
                            echo form::select($data, '', 'name="typeid" size="2" style="height:200px;width:130px;" onclick="change_model(this.value)"', '不限類別');
                        ?>
                    </td>
                </tr>
                <tr> 
                    <td align="left">
                        <input type="text" name="pagesize" value="100" size="5"> <?php echo L('tiao');?>
                        <input type="submit" name="dosubmit" class="button" value="<?php echo L('confirm_reindex');?>">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>

<script language="JavaScript">
<!--
	window.top.$('#display_center_id').css('display','none');
//-->
</script>
