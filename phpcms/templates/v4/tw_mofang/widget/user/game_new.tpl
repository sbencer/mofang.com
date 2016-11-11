<div class="hw-game-new ">
	<div class="hw-common-title">
		<h3>作者新聞</h3>
	</div>
	<div class="hw-common-con">
		<div class="game-new-con">
		{pc M=content action=user_lists catid=10000050 outhorname={$smarty.get.outhorname} field='id,title,url,thumb,description,outhorname,username,inputtime' order='id desc' num=18 page=$page}
		{foreach $data as $val}
			{if $val@index > 7}
			<div class="game-new-li clearfix">
				<a href="{$val.url}" target="_blank" class="fl">
					<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				</a>
				<h3>
					<a href="{$val.url}" target="_blank">{$val.title}</a>
				</h3>
				<div class="game-new-li-intro">
					<span>作者：<em>{if $val.outhorname}{$val.outhorname}{else}{$val.username}{/if}</em></span>
					<span>更新：{$val.inputtime|date_format}</span>
				</div>
				<p>{str_cut(mftrim($val.description),160)}<span class="article-more">[<a href="{$val.url}" target="_blank">繼續閱讀</a>]</span></p>
			</div>
			{/if}
		{/foreach}
		</div>
	</div>
	{* page *}
	{include file="tw_mofang/widget/common/page.tpl"}
</div>
{require name="tw_mofang:statics/css/user/game_new.css"}
