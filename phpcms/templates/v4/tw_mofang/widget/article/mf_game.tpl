<div class="mf-game-wrap w310 mb10">
	<div class="hw-common-title">
        <a href="http://game.mofang.com.tw/" target="_blank" class="hw-common-more fr">更多遊戲 <em>&gt;</em></a>
		<h3>魔方遊戲</h3>
	</div>
	<div class="mf-game-con">
	{pc M=content action=lasest_games num=6 cache=3600}
		{foreach $data as $val}
		<div class="mf-game-li clearfix">
			<a href="{$val.url}" target="_blank" class="fl mf-game-li-left">
				<img src="{qiniuthumb($val.icon,57,57)}" alt="{$val.name}">
			</a>
			<h4>
				<a href="{$val.url}" target="_blank">{$val.name}</a>
			</h4>
			<span>上架時間: {$val.create_time|date_format:"%Y.%m.%d"}</span>
		</div>
		{/foreach}
	{/pc}
	</div>
</div>
{require name="tw_mofang:statics/css/article/mf_game.css"}
