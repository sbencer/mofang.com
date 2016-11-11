<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>

<div class="pad-10">

	<form name="searchform" action="" method="get" >
		<input type="hidden" value="partition" name="m">
		<input type="hidden" value="partition" name="c">
		<input type="hidden" value="game_info" name="a">
		<table width="100%" cellspacing="0" class="search-form">
		    <tbody>
				<tr>
					<td align="center">
						<div class="explain-col">
							<select name="game_sort">
								<?php  foreach( $game_sort as $s_key => $s_value ):?>
									<option value='<?php echo $s_key;?>' <?php if($game_info == $s_key) echo 'selected';?>><?php echo $s_value;?></option>
								<?php endforeach;?>
							</select>
							<input name="keywords" type="text" value="<?php echo stripslashes($_GET['keywords'])?>" style="width:330px;" class="input-text" />
							<input type="submit" name="dosubmit" class="button" value="<?php echo L('search');?>" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	
	<div class="table-list">
	    <table width="100%" cellspacing="0" >
	    
	        <thead>
	            <tr>
	            <th ><?php echo L('game_name');?></th>
				<th width="100"><?php echo L('game_belong');?></th>
	            <th width="100"><?php echo L('addtime');?></th>
	            </tr>
	        </thead>
	        
		    <tbody>
			<?php foreach($game_infos as $game_item) { ?>
			<tr onclick="select_list(this,'<?php echo safe_replace($game_item['title']);?>','<?php echo $game_item['id'];?>')" class="cu" title="<?php echo L('click_to_select');?>">
				<td align='left' ><?php echo $game_item['title'];?></td>
				<td align='center'><?php echo $categorys[$game_item['catid']];?></td>
				<td align='center'><?php echo format::date($game_item['inputtime']);?></td>
			</tr>
			 <?php }?>
			</tbody>
	    </table>
	   <div id="pages"><?php echo $pages;?></div>
	</div>

</div>


<style type="text/css">
 .line_ff9966,.line_ff9966:hover td{
	background-color:#FF9966;
}
 .line_fbffe4,.line_fbffe4:hover td {
	<!-- background-color:#fbffe4; -->
}
</style>
<SCRIPT LANGUAGE="JavaScript">

<!--
	function select_list123(obj,title,id) {//這個函數未啟用,保留作下面函數參考
		var relation_ids = window.top.$('#relation').val();
		var sid = 'v<?php echo $modelid;?>'+id;
		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {
			$(obj).attr('class','line_fbffe4');
			window.top.$('#'+sid).remove();
			if(relation_ids !='' ) {
				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				$.each(r_arr, function(i, n){
					if(n!=id) {
						if(i==0) {
							newrelation_ids = n;
						} else {
						 newrelation_ids = newrelation_ids+'|'+n;
						}
					}
				});
				window.top.$('#relation').val(newrelation_ids);
			}
		} else {
			$(obj).attr('class','line_ff9966');
			var str = "<li id='"+sid+"'>·<span>"+title+"</span><a href='javascript:;' class='close' onclick=\"remove_relation('"+sid+"',"+id+")\"></a></li>";
			window.top.$('#relation_text').append(str);
			if(relation_ids =='' ) {
				window.top.$('#relation').val(id);
			} else {
				relation_ids = relation_ids+'|'+id;
				window.top.$('#relation').val(relation_ids);
			}
		}
}
//-->


<!--
	function select_list(obj,title,id) {//選擇選項
		var game_str = $('[name=game_sort] option:selected').val();
		
		var input_id = '#relation_hao';
		var relation_ids = window.parent.$(input_id).val();

		var sid = 'relation_hao_'+id;
		if($(obj).attr('class')=='line_ff9966' || $(obj).attr('class')==null) {//反選取消遊戲選擇

			//還原顏色
			$(obj).attr('class','line_fbffe4');
			//移除選項
			window.parent.$('#'+sid).remove();

			if(relation_ids !='' ) {
				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				hidden_id = game_str + '-' + id;
				$.each(r_arr, function(i, n){
					//alert(i);
					//alert(n);
					if(n!= hidden_id) {//非取消選擇的項扔保留在隱藏域
						if(i==0) {
							newrelation_ids = n;
						} else {
						 newrelation_ids = newrelation_ids+'|'+n;
						}
					}
				});
				window.parent.$(input_id).val(newrelation_ids);
			}

			//if(relation_ids !='' ) {
			//	var r_arr = relation_ids.split('|');
			//	var newrelation_ids = '';
			//	newrelation_ids = $.grep(r_arr,function(v){return v != '' && v!= id;}).join('|');
			//	window.parent.$(input_id).val('|' + newrelation_ids + '|');
			//}

		} else {//選擇遊戲

			game_data = game_str + '-' + id;
			$(obj).attr('class','line_ff9966');
			//var str = "<li id='"+sid+"'>·<span>"+title+"</span><a href='javascript:;' class='close' onclick=\"remove_relation('"+sid+"',"+id+")\"></a></li>";
			var str = "<li id='"+sid+"' style='width:210px;float:left;padding-right:5px;'>·<span>"+title+"</span><a href='javascript:;' class='close' style='padding-bottom:5px;' onclick=\"remove_relation_game('"+sid+"','"+id+"','"+game_data+"')\"></a></li>";

			if(relation_ids !='' ) {//
				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				hidden_id = game_str + '-' + id;
				var not_append = 0;
				$.each(r_arr, function(i, n){
					if(n == hidden_id) {//非取消選擇的項扔保留在隱藏域
						not_append = 1;
					}
				});
				if( not_append !=1 ){
					window.parent.$('#relation_hao_text').append(str);
				}
			}else{
				window.parent.$('#relation_hao_text').append(str);
			}

			//隱藏域內容處理
			if(relation_ids =='' ) {//隱藏域無內容
				window.parent.$(input_id).val(game_str + '-' +id);
			} else {//隱藏域已有內容,需加處理

				var r_arr = relation_ids.split('|');
				var newrelation_ids = '';
				hidden_id = game_str + '-' + id;
				var not_append2 = 0;
				$.each(r_arr, function(i, n){
					if(n == hidden_id) {//非取消選擇的項扔保留在隱藏域
						not_append2 = 1;
					}
				});
				if( not_append2 !=1 ){
					relation_ids = relation_ids+'|'+ game_str + '-' +id;
					window.parent.$(input_id).val(relation_ids);
				}
			}

				//$(obj).attr('class','line_ff9966');
				//var str = "<li id='"+sid+"' style='width:210px;float:left;padding-right:5px;'>·<span>"+title+"</span><a href='javascript:;' class='close' style='padding-bottom:5px;' onclick=\"remove_mfrelation('"+sid+"','"+id+"', 'hao')\"></a></li>";
				//if(relation_ids =='' || relation_ids == '||' ) {
				//	window.parent.$(input_id).val('|' + game_str + '-' + id + '|');
				//	window.parent.$('#relation_hao_text').append(str);
				//	//window.parent.$('#relation_hao_text').val(str);
				//} else {
				//	var r_arr = relation_ids.split('|');
				//	var newrelation_ids = '';
				//	newrelation_ids = $.grep(r_arr,function(v){return v != '';});
				//	if (newrelation_ids.indexOf(id) == -1) {
				//		newrelation_ids.push( game_str + '-'  + id);
				//		window.parent.$('#relation_hao_text').append(str);
				//	}
				//	window.parent.$(input_id).val('|' + newrelation_ids.join('|') + '|');
				//}
				
		}
	}
//-->
</SCRIPT>
</body>
</html>
