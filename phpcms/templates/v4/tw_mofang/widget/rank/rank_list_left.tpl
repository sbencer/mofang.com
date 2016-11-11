<div class="rank-list-left">
	<div class="rank-list-title">
		<span class="fr">昨日人氣</span>
		<span>排行</span>
		<span>遊戲名稱</span>
	</div>
	<div class="rank-content clearfix">
		{pc M=content action=getGameRankingMore return=game_ranking_more}
		<ul class="fl left">
			{foreach $game_ranking_more as $index => $val}
			<li class="rank-list">
				<span class="rank-num">{$index+1}</span>
				<a href="{$val.strategy_url}" target="_blank">{$val.name}</a>
				{if $val.ud > 0 && $val.ud != 10000}<i class="num-hot">+{$val.ud}</i>{/if}
				<span class="rank-view fr">{$val.score}</span>
			</li>
			{/foreach}
		</ul>
		{/pc}
	</div>
</div>
{require name="tw_mofang:statics/css/rank/rank_list_left.css"}
