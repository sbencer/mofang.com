<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'statistics');
?>
<script type="text/javascript" src="<?php echo JS_PATH?>jquery.sgallery.js"></script>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="statistics" name="m">
<input type="hidden" value="index" name="c">
<input type="hidden" value="init" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
        <td>
            <div class="explain-col">
                分組：
                <select name="group">
					<option value='0' <?php if($_GET['group']=='0') echo 'selected';?>>全部</option>
                    <?php
                        foreach($this->groups as $id=>$name) {
                            if ($_GET['group'] == $id) {
                                echo "<option value='$id' selected>$name</option>";
                            } else {
                                echo "<option value='$id'>$name</option>";
                            }
                        }
                    ?>
                </select>
                類型：
                <select name="model">
					<option value='all' <?php if($_GET['model']=='all') echo 'selected';?>>全部</option>
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
<div class="table-list">
    <table width="100%" cellspacing="0">
        <thead>
		<tr>
		<th width="20%">編輯姓名</th>
        <th width="10%" >發帖數
        <div class="tab-use">
        	<div style="position:relative">
        	<a href="<?php echo $request_url;?>&order=ASC&by=num"><div class="arrows cu"></div></a>
            </div>
        </div>
        </th>
        <th width="20%" >查看數
        <div class="tab-use">
        	<div style="position:relative">
        	<a href="<?php echo $request_url;?>&order=ASC&by=view"><div class="arrows cu"></div></a>
            </div>
        </div>
        </th>
        <th width="20%" >回復數
        <div class="tab-use">
        	<div style="position:relative">
        	<a href="<?php echo $request_url;?>&order=ASC&by=comment"><div class="arrows cu"></div></a>
            </div>
        </div>
        </th>
		</tr>
        </thead>
        <tbody>
        <tr>
        <?php foreach($user_info as $key=>$val){ ?>
        <td width="20%"  align="center"><a href="<?php echo $list_url.'&user='.$key;?>"><?php echo $val['user']?></a></td>
        <td width="10%"  align="center"><?php echo $val['num']?></td>
        <td width="20%"  align="center"><?php echo $val['view']?></td>
        <td width="20%"  align="center"><?php echo $val['comment']?></td>
        </tr>
        <?php 
            }
        ?>
        </tbody>
    </table>

</div>
</body>
</html>
