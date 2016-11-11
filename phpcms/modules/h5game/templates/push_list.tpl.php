<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_header = $show_validator = 1;
include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		<?php if (is_array($html) && $html['validator']){ echo $html['validator']; unset($html['validator']); }?>
	})
//-->
</script>
<div class="pad-10">
<div class="col-tab">
<ul class="tabBut cu-li">
<li class="on">推送到指定位置</li>

</ul>
<div class='content' style="height:auto;">
<form action="?m=h5game&c=h5game&a=push" method="post" name="myform" id="myform">
<input type="hidden" name="ids" value="<?php echo $ids;?>">
<table width="100%" class="table_form">
<tbody>
    <tr>
    <th width="80">推薦位：</th>
    <td class="y-bg">
      <label class="ib" style="width:120px"><input type="checkbox" name="posid[]" id="_1" value="1"> 今日推薦</label>
      <label class="ib" style="width:120px"><input type="checkbox" name="posid[]" id="_2" value="2"> 最佳更新</label>
      <label class="ib" style="width:120px"><input type="checkbox" name="posid[]" id="_2" value="3"> 最多人玩</label>
      <label class="ib" style="width:120px"><input type="checkbox" name="posid[]" id="_2" value="4"> 月排行</label>
      <label class="ib" style="width:120px"><input type="checkbox" name="posid[]" id="_2" value="5"> android遊戲推薦</label>
      <label class="ib" style="width:120px"><input type="checkbox" name="posid[]" id="_2" value="6"> IOS遊戲推薦</label>
    </td>
  </tr>
  
</tbody>
</table>

<div class="bk15"></div>

<input type="hidden" name="return" value="<?php echo $return?>" />
<input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>
</div>
</div>
</body>
</html>