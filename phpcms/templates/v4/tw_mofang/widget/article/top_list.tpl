<div class="top-list">
	<div class="hw-carouse-header clearfix mb10">
		<div class="hw-header-list">
		{pc M=content action=category catid=$top_parentid num=25 siteid=$siteid order='id DESC'}
			<a href="{cat_url($top_parentid)}" {if $top_parentid == $catid}class="active"{/if}>綜合</a>
			{foreach $data as $val}
			<a href="{$val.url}" {if $val.catid == $catid}class="active"{/if}>{$val.catname}</a>
			{/foreach}
            {if $top_parentid == 10000050}
			<a href="{cat_url(10000111)}" target="_blank">事前登錄</a>
            {/if}
            <a href="{cat_url(10000149)}" class="curr" target="_blank">ChinaJoy 2015</a>
		{/pc}
		</div>
	</div>
	<div class="top-list-con-wrap">
		<div class="top-list-con clearfix">
		{pc M=content action=lists catid=$catid field='id,title,url,thumb' order='id desc' num=7}
		{foreach $data as $val}
			{if $val@first}
			<a href="{$val.url}" target="_blank" class="fl first">
				<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
				<p>{$val.title}</p>
			</a>
			{else}
			<a href="{$val.url}" target="_blank" class="fl">
				<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				<p>{$val.title}</p>
			</a>
			{/if}
		{/foreach}
		{/pc}
		</div>
	</div>
</div>
{require name="tw_mofang:statics/css/article/top_list.css"}
