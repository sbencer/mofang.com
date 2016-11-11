<div class="hw-game-new fl">
	<div class="hw-common-title">
		<h3>遊戲新聞</h3>
	</div>
	<div class="hw-common-con">
		<div class="game-new-con">
		{pc M=content action=lists catid=$catid field='id,title,url,thumb,description,username,inputtime,tag' order='id desc' skip=7 num=15 page=$page}
			{foreach $data as $val}
			<div class="game-new-li hot-comm-li clearfix">
				<a href="{$val.url}" target="_blank" class="imgarea fl">
					{if $val['tag']}<span class="hot-news-tag">{get_tag($val['tag'])}</span>{/if}
					<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				</a>
				<h3>
					<a href="{$val.url}" target="_blank">{$val.title}</a>
				</h3>
				<div class="game-new-li-intro">
					<span>作者：<em>{$val.username}</em></span>
					<span>更新：{$val.inputtime|date_format}</span>
				</div>
				<p>{str_cut(mftrim($val.description),160)}<span class="article-more">[<a href="{$val.url}" target="_blank">繼續閱讀</a>]</span></p>
			</div>
			{/foreach}
		{/pc}
		</div>
	</div>
	{* page *}
	{include file="tw_mofang/widget/common/page.tpl"}
</div>
{require name="tw_mofang:statics/css/article/game_new.css"}
