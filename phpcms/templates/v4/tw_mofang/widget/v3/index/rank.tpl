<div class="rank-wrap">
	<div class="rank-title">
		<a href="/ranking/10000135-1.html" class="fr" target="_blank">更多 <em>></em></a>
		<h3 class="h3_title">遊戲排行榜</h3>
		<p>人氣計算為攻略區、討論區及攻略助手加總</p>
	</div>
	<div class="rank-content clearfix">
		{pc M=content action=getGameRanking page=1 num=10 return=game_ranking_1}
		<ul class="fl left">
			{foreach $game_ranking_1 as $index => $val}
			<li class="rank-list">
				<span class="rank-num">{$index+1}</span>
				<a href="{$val.strategy_url}" target="_blank">{$val.name}</a>
				{if $val.is_new}<i class="icon"></i>{/if}
				<span class="rank-view fr">{$val.score}</span>
			</li>
			{/foreach}
		</ul>
		{/pc}
		
		{pc M=content action=getGameRanking page=2 num=10 return=game_ranking_2}
		<ul class="fr">
			{foreach $game_ranking_2 as $index => $val}
			<li class="rank-list">
				<span class="rank-num">{$index+11}</span>
				<a href="{$val.strategy_url}" target="_blank">{$val.name}</a>
				{if $val.is_new}<i class="icon"></i>{/if}
				<span class="rank-view fr">{$val.score}</span>
			</li>
			{/foreach}
		</ul>
		{/pc}
	</div>
</div>
{require name="tw_mofang:statics/css/v3/rank_index.css"}
