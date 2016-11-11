<div class="header">
	<div class="head_nav">
		<div class="nav_top">
			<div class="logo">
				<a href="http://www.mofang.com.tw/" target="_blank"><img src="/statics/v4/tw_tyong/img/nav_logo_03.jpg"></a>
			</div>
			<div class="top">
				<h4 class="text">
				<form action="http://www.mofang.com.tw/index.php" target="_blank">
					<input type="hidden" name="m" value="search">
					<input type="text" name="q" placeholder="找遊戲 找攻略"  class="text2">
					<input type="submit" class="img">
				</form>
				</h4>
				<p class="icon">
					<a href="#"><img src="/statics/v4/tw_tyong/img/nav_adg_03.jpg" alt=""></a>
					<a href="#"><img src="/statics/v4/tw_tyong/img/nav_ff_03.jpg" alt=""></a>
					<a href="#"><img src="/statics/v4/tw_tyong/img/nav_fly_03.jpg" alt=""></a>
				</p>
				<p class="ty-login"><a href="#" id="login">登錄</a>|<a href="#" id="reg">註冊</a></p>
			</div>
		</div>
	</div>
	<div class="nav_bott">
		<div class="nav">
			{$nav_1 = array_slice($part_nav,0,2)}
			{$nav_2 = array_slice($part_nav,2,2)}
			<ul class="nav_list1">
				<li class="nav_l"><a href="{partition_url()}">首頁</a></li>
				{foreach $nav_1 as $val}
            	{if $val.nav_type == 1 }
            		<li class="nav_l"><a href="{get_part_url($val.nav_value, 'tyong')}">{mb_strimwidth($val.name,0,8)}</a></li>
            	{else}
            		<li class="nav_l"><a href="{$val.nav_value}">{mb_strimwidth($val.name,0,8)}</a></li>
            	{/if}
            	{/foreach}
			</ul>
			<ul class="nav_list2">
			{foreach $nav_2 as $val}
            	{if $val.nav_type == 1 }
            	<li class="nav_r">
                	<a href="{get_part_url($val.nav_value, 'tyong')}">{mb_strimwidth($val.name,0,8)}</a>
                    <div class="dropdown">
                        <a href="#2">攻略影片</a>
                        <a href="#2">歷史直播</a>
                        <a href="#2">女王跳舞</a>
                    </div>
                </li>
            	{else}
            	<li class="nav_r"><a href="{$val.nav_value}">{mb_strimwidth($val.name,0,8)}</a></li>
            	{/if}
            {/foreach}
			</ul>
		</div>
	</div>
</div>	
{require name="tw_tyong:statics/css/common/header.css"}
