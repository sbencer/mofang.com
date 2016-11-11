<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
    <script type="text/javascript">
        <!--
        $(function(){
            $.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
            $("#url").formValidator({onshow:"<?php echo L('input').L('url')?>",onfocus:"<?php echo L('url').L('not_empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('url').L('not_empty')?>"});
        })
        //-->
    </script>
    <div class="pad_10">
        <div class="common-form">
            <form name="myform" action="?m=admin&c=shorturl&a=shortUrlAdd" method="post" id="myform">
                <table width="100%" class="table_form contentWrap">
                    <tr>
                        <td  width="80"><?php echo L('url')?></td>
                        <td><input type="text" name="url" value="<?php echo $info[name]?>" class="input-text" id="url"></input></td>
                    </tr>
                    <tr>
                        <td><?php echo L('shorturl_pname');?></td>
                        <td>
                            <select name="cid">
                            <?php
                                printSelect($formatAllClass, $level=0);
                            ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td  width="80"><?php echo L('hostweb')?></td>
                        <td>
                            <input type="radio" name="web" value="1" checked="checked" /><?=L('mofang')?>
                            <input type="radio" name="web" value="2" /><?=L('shortmf')?>
                        </td>
                    </tr>
                </table>

                <div class="bk15"></div>
                <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog" id="dosubmit">
                <Input type="submit" />
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


