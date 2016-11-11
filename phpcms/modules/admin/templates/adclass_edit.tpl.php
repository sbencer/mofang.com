<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<script type="text/javascript">
    <!--
    $(function(){
        $.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
        $("#name").formValidator({onshow:"<?php echo L('input').L('adclass_name')?>",onfocus:"<?php echo L('adclass_name').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('adclass_name').L('not_empty')?>"});
    })
    //-->
</script>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="?m=admin&c=adclass&a=edit" method="post" id="myform">
            <input type="hidden" name="id" value="<?=$oneClass['id']?>">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td  width="80"><?php echo L('adclass_name')?></td>
                    <td><input type="text" name="name" value="<?=$oneClass['name']?>" class="input-text" id="name" /></td>
                </tr>
                <tr>
                    <td><?php echo L('adclass_parent_name');?></td>
                    <td>
                        <select name="pid">
                            <OPTGROUP LABEL="<?php echo L('adclass_select_parent');?>">
                            <option value="0" <?php if($oneClass['pid'] == 0){echo "selected='selected'";}?>><?php echo L('adclass_top');?></option>
                            <?php
                                foreach ($topClass as $val) {
                                    echo '<option value="', $val['id'], '" ', ($oneClass['pid'] == $val['id'] ? "selected='selected'" : '') ,'>', $val['name'], '</option>';
                                }
                            ?>
                            </OPTGROUP>
                        </select>
                    </td>
                </tr>
            </table>

            <div class="bk15"></div>
            <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog" id="dosubmit">
        </form>
    </div></div>
</body>
</html>



