<?php $show_header = $show_validator = $show_scroll = 1; include $this->admin_tpl('header', 'attachment');?>
<link href="<?php echo JS_PATH?>swfupload/swfupload.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swfupload.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/fileprogress.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/package.js"></script>
<script type="text/javascript">
<?php echo initupload($_GET['module'],$_GET['catid'],$args,$this->userid,$this->groupid,$this->isadmin)?>
</script>
<div class="pad-10">
    <div class="col-tab">
        <ul class="tabBut cu-li">
            <li id="tab_swf_1" style="height:24px"><?php echo L('upload_attachment')?></li>
        </ul>
         <div id="div_swf_1" class="content pad-10">
        	<div>
				<div class="addnew" id="addnew">
					<span id="buttonPlaceHolder"></span>
				</div>
				<input type="button" id="btupload" value="<?php echo L('start_upload')?>" onClick="swfu.startUpload();" />
                <div id="nameTip" class="onShow"><?php echo L('upload_up_to')?><font color="red"> <?php echo $file_upload_limit?></font> <?php echo L('attachments')?>,<?php echo L('largest')?> <font color="red"><?php echo $file_size_limit?></font></div>
                <div class="bk3"></div>
				
            </div> 	
    		<div class="bk10"></div>
        	<fieldset class="blue pad-10" id="swfupload">
        	<legend><?php echo L('lists')?></legend>
        	<ul class="attachment-list"  id="fsUploadProgress">    
        	</ul>
    		</fieldset>
    	</div>
    <div id="att-status" class="hidden"></div>
     <div id="att-status-del" class="hidden"></div>
    <div id="att-id" class="hidden"></div>
    <div id="att-name" class="hidden"></div>
<!-- swf -->
</div>
</body>
<script type="text/javascript">
if ($.browser.mozilla) {
	window.onload=function(){
	  if (location.href.indexOf("&rand=")<0) {
			location.href=location.href+"&rand="+Math.random();
		}
	}
}
function imgWrap(obj){
	$(obj).hasClass('on') ? $(obj).removeClass("on") : $(obj).addClass("on");
}

function SwapTab(name,cls_show,cls_hide,cnt,cur) {
    for(i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).addClass(cls_show);
			 $('#tab_'+name+'_'+i).removeClass(cls_hide);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).removeClass(cls_show);
			 $('#tab_'+name+'_'+i).addClass(cls_hide);
		}
	}
}

function addonlinefile(obj) {
	var strs = $(obj).val() ? '|'+ $(obj).val() :'';
	$('#att-status').html(strs);
}

function set_iframe(id,src){
	$("#"+id).attr("src",src); 
}
function album_cancel(obj,id,source){
	var src = $(obj).children("img").attr("path");
	var filename = $(obj).attr('title');
	if($(obj).hasClass('on')){
		$(obj).removeClass("on");
		var imgstr = $("#att-status").html();
		var length = $("a[class='on']").children("img").length;
		var strs = filenames = '';
		$.get('index.php?m=attachment&c=attachments&a=swfupload_json_del&aid='+id+'&src='+source+'&filename='+filename);
		for(var i=0;i<length;i++){
			strs += '|'+$("a[class='on']").children("img").eq(i).attr('path');
			filenames += '|'+$("a[class='on']").children("img").eq(i).attr('title');
		}
		$('#att-status').html(strs);
		$('#att-status').html(filenames);
	} else {
		var num = $('#att-status').html().split('|').length;
		var file_upload_limit = '<?php echo $file_upload_limit?>';
		if(num > file_upload_limit) {alert('<?php echo L('attachment_tip1')?>'+file_upload_limit+'<?php echo L('attachment_tip2')?>'); return false;}
		$(obj).addClass("on");
		$.get('index.php?m=attachment&c=attachments&a=swfupload_json&aid='+id+'&src='+source+'&filename='+filename);
		$('#att-status').append('|'+src);
		$('#att-id').append('|'+id);
		$('#att-name').append('|'+filename);
	}
}
</script>
</html>
