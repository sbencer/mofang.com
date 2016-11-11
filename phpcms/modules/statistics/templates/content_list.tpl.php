<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','statistics');
?>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.sgallery.js"></script>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="statistics" name="m">
<input type="hidden" value="index" name="c">
<input type="hidden" value="content_list" name="a">
<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
        <td>
            <div class="explain-col">
                編輯：
                <?php echo form::select($members, $username, 'name="user"', L('please_select'))?>
                類型：
                <select name="model">
					<option value='news' <?php if($_GET['model']=='news') echo 'selected';?>>文章</option>
					<option value='picture' <?php if($_GET['model']=='picture') echo 'selected';?>>圖片</option>
					<option value='video' <?php if($_GET['model']=='video') echo 'selected';?>>視頻</option>
					<option value='iosgames' <?php if($_GET['model']=='iosgames') echo 'selected';?>>iOS遊戲</option>
					<option value='androidgames' <?php if($_GET['model']=='androidgames') echo 'selected';?>>Android遊戲</option>
				</select>
                開始時間：<?php echo form::date('start_time',$starttime,'1','0','true','1')?>
                結束時間：<?php echo form::date('end_time',$endtime,'1','0','true','1')?>  
                <input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
		    </div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
			<th><?php echo L('title');?></th>
            <th width="60"><?php echo L('hits');?></th>
            <th width="90">發布人員</th>
            <th width="118">發布時間</th>
			<th width="72"><?php echo L('operations_manage');?></th>
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($datas)) {
		$sitelist = getcache('sitelist','commons');
		$release_siteurl = $sitelist[$category['siteid']]['url'];
		$path_len = -strlen(WEB_PATH);
		$release_siteurl = substr($release_siteurl,0,$path_len);
		$this->hits_db = pc_base::load_model('hits_model');
		
		foreach ($datas as $r) {
			$hits_r = $this->hits_db->get_one(array('hitsid'=>'c-'.$model_arr[$model].'-'.$r['id']));
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['id'];?></td>
		<td>
		<?php
		if($status==99) {
			if($r['islink']) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} elseif(strpos($r['url'],'http://')!==false) {
				echo '<a href="'.$r['url'].'" target="_blank">';
			} else {
				echo '<a href="'.$release_siteurl.$r['url'].'" target="_blank">';
			}
		} else {
			echo '<a href="javascript:;" onclick=\'window.open("?m=content&c=content&a=public_preview&steps='.$steps.'&catid='.$r['catid'].'&id='.$r['id'].'","manage")\'>';
		}?><span<?php echo title_style($r['style'])?>><?php echo $r['title'];?></span></a> <?php if($r['thumb']!='') {echo '<img src="'.IMG_PATH.'icon/small_img.gif" title="'.L('thumb').'">'; } if($r['posids']) {echo '<img src="'.IMG_PATH.'icon/small_elite.gif" title="'.L('elite').'">';} if($r['islink']) {echo ' <img src="'.IMG_PATH.'icon/link.png" title="'.L('islink_url').'">';}?></td>
<?php if ($exists_gameid): ?>
		<td align='center'><?php if ($r['gameid']):?><span class='green'>是</span><?php else: ?><span class='red'>否</span><?php endif;?></td>
<?php endif; ?>
		<td align='center' title="<?php echo L('today_hits');?>：<?php echo $hits_r['dayviews'];?>&#10;<?php echo L('yestoday_hits');?>：<?php echo $hits_r['yestodayviews'];?>&#10;<?php echo L('week_hits');?>：<?php echo $hits_r['weekviews'];?>&#10;<?php echo L('month_hits');?>：<?php echo $hits_r['monthviews'];?>"><?php echo $hits_r['views'];?></td>
		<td align='center'>
		<?php
		if($r['sysadd']==0) {
			echo "<a href='?m=member&c=member&a=memberinfo&username=".urlencode($r['username'])."&pc_hash=".$_SESSION['pc_hash']."' >".$r['username']."</a>"; 
			echo '<img src="'.IMG_PATH.'icon/contribute.png" title="'.L('member_contribute').'">';
		} else {
			echo $r['username'];
		}
		?></td>
		<td align='center'><?php echo format::date($r['inputtime'],1);?></td>
		<td align='center'><a href="javascript:;" onclick="javascript:openwinx('?m=content&c=content&a=edit&catid=<?php echo $r['catid'];?>&id=<?php echo $r['id']?>','')"><?php echo L('edit');?></a></td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn"><label for="check_box"><?php echo L('selected_all');?>/<?php echo L('cancel');?></label>
		<input type="hidden" value="<?php echo $pc_hash;?>" name="pc_hash">
		<?php echo runhook('admin_content_init')?>
	</div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>cookie.js"></script>
<script type="text/javascript"> 
<!--
setcookie('refersh_time', 0);
function refersh_window() {
	var refersh_time = getcookie('refersh_time');
	if(refersh_time==1) {
		window.location.reload();
	}
}
setInterval("refersh_window()", 3000);
var pc_hash = '<?php echo $pc_hash;?>';
//-->
</script>
</body>
</html>
