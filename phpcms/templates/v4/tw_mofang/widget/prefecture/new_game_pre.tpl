<div class="new-game-pre" id ="new-game">
	<div class="hw-common-title">
		<h3>新遊專區</h3>
	</div>
	<div class="hw-common-con">
		<div class="new-game-style">
		{pc M=content action=category catid=$top_parentid num=25 siteid=$siteid order='listorder ASC'}
			<span class="new-game-tit">類型：</span>
			<a href="{cat_url($top_parentid)}#new-game" {if $top_parentid == $catid}class="active"{/if}>全部</a>
			{foreach $data as $val}
			<a href="{$val.url}#new-game" {if $val.catid == $catid}class="active"{/if}>{$val.catname}</a>
			{/foreach}
		{/pc}
		</div>
		<div class="new-game-con clearfix">
		{pc M=content action=lists catid=$catid order='listorder desc, id desc' num=18 page=$page}
			{foreach $data as $val}
			<div class="new-game-li fl">
				<a href="{$val.url}" class="" target="_blank">
					<img src="{qiniuthumb($val.icon,144,144)}" alt="{$val.title}">
					<span>{$val.title}</span>
				</a>
			</div>
			{/foreach}
		{/pc}	
		</div>
		{include file="tw_mofang/widget/common/page.tpl"}
	</div>
</div>
{require name="tw_mofang:statics/css/prefecture/new_game_pre.css"}

