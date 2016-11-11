<?php defined('IN_PHPCMS') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="96%">
    <tr>
        <td>
            <input type="radio" name="setting[boxtype]" value="radio" <?php if($setting['boxtype']=='radio') echo 'checked';?> onclick="$('#setcols').show();$('#setsize').hide();"/> 单选按钮
            <input type="radio" name="setting[boxtype]" value="checkbox" <?php if($setting['boxtype']=='checkbox') echo 'checked';?> onclick="$('#setcols').show();$('setsize').hide();"/> 复选框
        </td>
    </tr>
</table>
