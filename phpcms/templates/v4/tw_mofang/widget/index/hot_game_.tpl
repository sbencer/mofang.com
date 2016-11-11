<div class="hot-game-wrap">
	<div class="hot-game-classify mb10 j_hot_tab">
		<div class="hot-game-top fl">
			<span class="curr j_tab">熱門遊戲</span>
			<span class="j_tab">魔方推薦</span>
		</div>
		<div class="j_con_wrap">
			<div class="game-class-right clearfix j_con">
			{pc M=content action=lists catid=10000064 order='listorder desc, id desc' num=9}
				{foreach $data as $val}
				<a href="{$val.url}" target="_blank" class="fl">
					<img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}">
					<span>{$val.title}</span>
				</a>
				{/foreach}
			{/pc}
			</div>
			<div class="game-class-right clearfix disno j_con">
			{pc M=content action=lists catid=10000065 order='listorder desc, id desc' num=9}
				{foreach $data as $val}
				<a href="{$val.url}" target="_blank" class="fl">
					<img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}">
					<span>{$val.title}</span>
				</a>
				{/foreach}
			{/pc}
			</div>
		</div>
		
	</div>
	<div class="game-recommend">
		<ul class="clearfix">
			<li class="game-recommend-title fl">
				<span>人氣專區</span>
				<a href="{cat_url(10000070)}" target="_blank">更多 <em>></em></a>
			</li>
			{pc M=content action=lists catid=10000066 order='listorder desc, id desc' num=5}
			{foreach $data as $val}
			{if $val@iteration == 1}
			<li class="game-recommend-li fl w490 purple">
			<a href="{$val.url}" target="_blank">
					<img src="{$val.thumb}" alt="{$val.title}">
					<div class="game-recom-wd">
						<h5>{$val.title}</h5>
						<span>{$val.description}</span>
					</div>
					<span class="mask-bd"></span>
				</a>
			</li>
			{continue}
			{elseif $val@iteration == 2}
			<li class="game-recommend-li fl red w328">
			{elseif $val@iteration == 3}
			<li class="game-recommend-li fl blue w326">
			{elseif $val@iteration == 4}
			<li class="game-recommend-li fl orange w326">
			{elseif $val@iteration == 5}
			<li class="game-recommend-li fl yellow w328">
			{/if}
				<a href="{$val.url}" target="_blank">
					<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
					<div class="game-recom-wd">
						<h5>{$val.title}</h5>
						<span>{$val.description}</span>
					</div>
					<span class="mask-bd"></span>
				</a>
			</li>
			{/foreach}
			{/pc}
		</ul>
	</div>
</div>
{require name="tw_mofang:statics/js/tab_change.js"}
{require name="tw_mofang:statics/js/tab.js"}
{require name="tw_mofang:statics/css/hot_game.css"}
