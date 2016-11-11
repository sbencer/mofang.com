<div class="bef-login-wrap waterfall">
	<div class="bef-login-tag j_classic">
		<span class="">事前登錄好康區</span>
		{pc M=content action=category catid=$top_parentid num=25 siteid=$siteid order='id DESC'}
		<a href="javascript:;" data-region="all">全部</a>
		{foreach $data as $val}
		{$catdirs[$val.catid] = $val.catdir}
		<a href="javascript:;" data-region="{$val.catdir}">{$val.catname}</a>
		{/foreach}
		{/pc}
	</div>
	<div class="bef-login-list-wrap clearfix">
	{pc M=content action=lists catid=$top_parentid type=coupon order='id desc'}
		<div class="bef-login-list effect-1" id="j_login">
			{foreach $data as $val}
			<div class="login-li {$catdirs[$val.catid]} j_game_log">
				<a href="{$val.site_url}" class="img-area" target="_blank">
					<img src="{$val.icon}" alt="{$val.title}">
					<span class="sanjiao">
					</span>
				</a>
				<div class="txt-area">
					<p>
						{$val.title}
					</p>
					<div class="login-time">
						<span>登錄期限</span>
						{date('Y-m-d',$val.end_time)}
					</div>
					<div class="login-li-style">
						<h3 class="j_slider">事前登錄特典</h3>
						<div class="login-style-li j_slider_con" style="display:none;">
							<ul>
								{str_replace(array("\r\n", "\r", "\n"), "<br/>", $val.description)}
							</ul>
						</div>
					</div>
					<div class="login-game-enter-wrap">
						<div class="login-game-enter">
							<a href="{$val.url}" class="game-enter" target="_blank">遊戲 介紹</a>
							<a href="{$val.site_url}" class="game-enter" target="_blank">前往 登錄</a>
						</div>
					</div>
				</div>
		    </div>
			{/foreach}
	    {/pc}
	</div>
</div>
{require name="tw_mofang:statics/css/bef_login/login_list.css"}
{require name="tw_mofang:statics/js/masonry.js"}

