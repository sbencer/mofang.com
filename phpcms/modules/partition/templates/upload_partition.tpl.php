<?php 
defined('IN_ADMIN') or exit('No permission resources.'); 
$show_header = $show_validator = $show_scroll = 1; 
include $this->admin_tpl('header','admin');
?>
<br />
<div class="pad-lr-10">

<div id="searchid" style="display:"> 
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col" id="text_string"> 
			專區模版正在發布中。。。請稍候！ <span id="num"></span>
		</div>
		</td>
		</tr>
    </tbody>
</table> 
</div> 

</div>
</body>
</html>
<script type="text/javascript">  
var i=0;
window.setInterval(function() {
i++;
$("#num").html(i);
}, 100);
$.ajax({
	type: "get", //get或post請求
	url: "<?php echo APP_PATH;?>index.php?m=partition&c=partition&a=upload_zq", //請求url
	data: { "catid":"<?php echo $catid;?>" }, //參數
	async: true, //同步請求， true為異步，默認情況都是異步
	success: function (data) { //請求成功後執行
		//操作...
		// clearInterval(timer1);
		$("#text_string").html('<font color=red>專區模版發布成功！！！請關閉小窗口</font>');
	},
	error: function () { //請求錯誤後執行
		alert("服務器上傳模版文件出錯！");
	}
});
</script>
