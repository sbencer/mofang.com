<div class="right_cont">
	<div class="right_top">
		{*游戏下载*}
		{include file="tw_tyong/widget/common/game_load.tpl"}
		{include file="tw_tyong/widget/carouse.tpl"}
		{include file="tw_tyong/widget/active_time.tpl"}
		{if $is_newbbs}
			{include file="tw_tyong/widget/article_new.tpl"}
		{else}
			{include file="tw_tyong/widget/article_bbs.tpl"}
		{/if}
		{if $is_ad}
		{foreach $banner_ad as $val}
		<div class="introduce" style="margin-bottom: 10px;">
			<a target="_blank" href="{$val.link}" ><img src="{$val.pic}"></a>
		</div>
		{/foreach}
		{/if}

		{if !empty($module_setting)}
	        {foreach from=$module_setting key=md_k item=md_v}
	            {if $md_k > 2 && $md_v['disable_type'] != 1}
				{include file="tw_tyong/widget/"|cat:$md_v.type|cat:".tpl"}
				{/if}
	        {/foreach}
	    {/if}
	</div>
</div>
{require name="tw_tyong:statics/css/con_right.css"}