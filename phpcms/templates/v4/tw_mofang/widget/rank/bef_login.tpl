<div class="mf-game-wrap w310 mb10">
	<div class="hw-common-title">
		<h3>事前登錄</h3>
	</div>
	<div class="mf-game-con">
	{pc M=content action=lists catid=10000111  order='id desc' num=6}
		{foreach $data as $val}
		<div class="mf-game-li clearfix">
			<a href="{$val.url}" target="_blank" class="fl mf-game-li-left">
				<img src="{$val.icon}" alt="{$val.title}">
			</a>
			<h4>
				<a href="{$val.url}" target="_blank">{$val.title}</a>
			</h4>
			<span>上架時間: {$val.inputtime|date_format:"%Y.%m.%d"}</span>
		</div>
		{/foreach}
	{/pc}
	</div>
</div>
{require name="tw_mofang:statics/css/article/mf_game.css"}
