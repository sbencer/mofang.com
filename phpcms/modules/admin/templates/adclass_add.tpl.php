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
        <form name="myform" action="?m=admin&c=adclass&a=add" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td  width="80"><?php echo L('adclass_name')?></td>
                    <td><input type="text" name="name" value="<?php echo $info[name]?>" class="input-text" id="name"></input></td>
                </tr>
                <tr>
                    <td><?php echo L('adclass_parent_name');?></td>
                    <td>
                        <select name="pid">
                            <OPTGROUP LABEL="<?php echo L('adclass_select_parent');?>">
                            <option value="0"><?php echo L('adclass_top');?></option>
                            <?php
                                foreach ($topClass as $val) {
                                    echo '<option value="', $val['id'], '">', $val['name'], '</option>';
                                }
                            ?>
                            </OPTGROUP>
                        </select>
                    </td>
                </tr>
            </table>

            <div class="bk15"></div>
            <input name="dosubmit" type="submit" value="<?php echo L('submit')?>"  id="dosubmit">
        </form>
    </div></div>
</body>
</html>
<script type="text/javascript">
    function category_load(obj)
    {
        var modelid = $(obj).attr('value');
        $.get('?m=admin&c=position&a=public_category_load&modelid='+modelid,function(data){
            $('#load_catid').html(data);
        });
    }
</script>


