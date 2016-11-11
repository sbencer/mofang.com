<div class="hw-sidebar">
	<ul>
	{pc M=content action=lists catid=10000063 order='listorder desc, id desc' num=6 cache=3600}
		{foreach $data as $val}
		{if $val@iteration is odd by 1}
		<li class="bg-grey">
			<a href="{$val.url}" target="_blank">
				<img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}">
				<span>{$val.title}</span>
			</a>
		</li>
		{else}
		<li>
			<a href="{$val.url}" target="_blank">
				<img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}">
				<span>{$val.title}</span>
			</a>
		</li>
		{/if}
		{/foreach}
	{/pc}
	</ul>
	<span class="go-top j_top">返回</span>
</div>
{require name="tw_mofang:statics/css/sidebar.css"}
{require name="tw_mofang:statics/js/gotop.js"}
{* {require name="tw_mofang:statics/js/fix.js"}*}
