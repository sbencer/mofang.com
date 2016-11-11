<?php
defined('IN_ADMIN') or exit('No permission resources.');$addbg=1;
include $this->admin_tpl('header','admin');?>
<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<link rel="stylesheet" href="<?php echo CSS_PATH?>jquery-ui.min.css">
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery-ui.min.js"></script>
<script type="text/javascript">var catid=<?php echo $catid;?>;var action='<?php echo ROUTE_A;?>'</script>
<form name="myform" id="myform" action="?m=content&c=content&a=add" method="post" enctype="multipart/form-data">
<div class="addContent">
<div class="crumbs"><?php echo L('add_content_position');?></div>
<div class="col-right">
    	<div class="col-1">
        	<div class="content pad-6">
<?php
if(is_array($forminfos['senior'])) {
 foreach($forminfos['senior'] as $field=>$info) {
	if($info['isomnipotent']) continue;
	if($info['formtype']=='omnipotent') {
		foreach($forminfos['base'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
		foreach($forminfos['senior'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
	}
 ?>
	<h6><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?></h6>
	 <?php echo $info['form']?><?php echo $info['tips']?> 
<?php
} }
?>
<?php if($_SESSION['roleid']==1 || $priv_status) {?>
<h6><?php echo L('c_status');?></h6>
<span class="ib" style="width:90px"><label><input type="radio" name="status" value="99" checked/> <?php echo L('c_publish');?> </label></span>
<?php if($workflowid) { ?><label><input type="radio" name="status" value="1" > <?php echo L('c_check');?> </label><?php }?>
<?php }?>
          </div>
        </div>
    </div>
    <a title="展開與關閉" class="r-close" hidefocus="hidefocus" style="outline-style: none; outline-width: medium;" id="RopenClose" href="javascript:;"><span class="hidden">展開</span></a>
    <div class="col-auto">
    	<div class="col-1">
        	<div class="content pad-6">
<table width="100%" cellspacing="0" class="table_form">
	<tbody>	
<?php
if(is_array($forminfos['base'])) {
 foreach($forminfos['base'] as $field=>$info) {
	 if($info['isomnipotent']) continue;
	 if($info['formtype']=='omnipotent') {
		foreach($forminfos['base'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
		foreach($forminfos['senior'] as $_fm=>$_fm_value) {
			if($_fm_value['isomnipotent']) {
				$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
			}
		}
	}
 ?>
	<tr>
      <th width="80"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?>
	  </th>
      <td><?php echo $info['form']?>  <?php echo $info['tips']?></td>
    </tr>
<?php
} }
?>

	<!-- 專區列表  -->
    </tbody></table>
                </div>
        	</div>
        </div>
        
    </div>
</div>

<div class="fixed-bottom">
	<div class="fixed-but text-c">
    <div class="button"><input value="<?php echo L('save_close');?>" type="submit" name="dosubmit" class="cu" style="width:145px;" onclick="refersh_window()"></div>
    <div class="button"><input value="<?php echo L('save_continue');?>" type="submit" name="dosubmit_continue" class="cu" style="width:130px;" title="Alt+X" onclick="refersh_window()"></div>
    <div class="button"><input value="<?php echo L('c_close');?>" type="button" name="close" onclick="refersh_window();close_window();" class="cu" style="width:70px;"></div>
      </div>
</div>
</form>

</body>
</html>
<script type="text/javascript"> 

$("#parentid").change(
	function(){
		var catid = $(this).val();
		$.ajax({
			url: "?m=content&c=content&a=ajax_partition&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
			async : false,
			data : "catid=" + catid,
			type:"post",
			success: function( data  ){
				//console.log(data);
				//partition_html = eval( "("+data+")"  )
				//console.log(partition_html);
				$("#parentid").nextAll().remove();
				$("#parentid").after(data);
			}

		})
	}
);


function changeChild_notused(obj,catid){
	//分區實現思路->首先生成頂級分區,選擇更改時獲取當前分區catid,然後根據它jquery ajax獲取以該節點為直接父節點的節點,然後構造json列表傳回,接著進行判斷處理,提交時根據最大已選的id進行存值
	//子分區數據
	var json1=[
		{"id":5,
		"name":"我叫MT子分區1"
		},
		{"id":6,
		"name":"我叫MT子分區2"
		},
		{"id":7,
		"name":"我叫MT子分區3"
		}
	];

	//獲得當前選中的下拉框的值
	var selectValue = obj.val();
	//變動之前首先將其同後代都刪除  
	obj.nextAll().remove();
	var str = $("<select onchange='changeChild($(this),5)' name='son"+ catid +"'></select>");

	//構造option
	var option = "";
	option+= '<option value="0">選擇子分區</option>\n';
	json = eval('json'+catid);
	$.each(json,function(i,n){
		option+= '<option value="'+n.id+'">'+n.name+"</option>\n";
	});

	//構造新的select對象
	var temp=$(str).html(option);  
	//將新的select插入到當前元素的後面，作為兄弟節點  
	obj.after(temp);
}
//$(".root").change(function(){
//	alert( $(this).val() );
//	changeChild($(this),1);
//});

<!--
//只能放到最下面
var openClose = $("#RopenClose"), rh = $(".addContent .col-auto").height(),colRight = $(".addContent .col-right"),valClose = getcookie('openClose');
$(function(){
	if(valClose==1){
		colRight.hide();
		openClose.addClass("r-open");
		openClose.removeClass("r-close");
	}else{
		colRight.show();
	}
	openClose.height(rh);
	$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({id:'check_content_id',content:msg,lock:true,width:'200',height:'50'}, 	function(){$(obj).focus();
	boxid = $(obj).attr('id');
	if($('#'+boxid).attr('boxid')!=undefined) {
		check_content(boxid);
	}
	})}});
	<?php echo $formValidator;?>
	
/*
 * 設置外部鏈接行為
 */
 	var action = $("#link_action").attr('value');
 	if(action==1){
		$('#linkurl').attr('disabled',false);
		$('#islink').attr('checked',true);
	}else{
		$('#linkurl').attr('disabled',true);
		$('#islink').attr('checked',false);
	}
	$('.edit_content').hide();
	jQuery(document).bind('keydown', 'Alt+x', function (){close_window();});
})
document.title='<?php echo L('add_content');?>';
self.moveTo(-4, -4);
function refersh_window() {
	setcookie('refersh_time', 1);
}
openClose.click(
	  function (){
		if(colRight.css("display")=="none"){
			setcookie('openClose',0,1);
			openClose.addClass("r-close");
			openClose.removeClass("r-open");
			colRight.show();
		}else{
			openClose.addClass("r-open");
			openClose.removeClass("r-close");
			colRight.hide();
			setcookie('openClose',1,1);
		}
	}
)
//-->
</script>
