<div class="top-list">
	<div class="hw-carouse-header clearfix mb10">
		<div class="hw-header-list">
		{pc M=content action=category catid=$top_parentid num=25 siteid=$siteid order='id DESC'}
			<a href="{cat_url($top_parentid)}" {if $top_parentid == $catid}class="active"{/if}>綜合</a>
			{foreach $data as $val}
			<a href="{$val.url}" {if $val.catid == $catid}class="active"{/if}>{$val.catname}</a>
			{/foreach}
		{/pc}
		</div>
	</div>
	<div class="top-list-con-wrap">
		<div class="top-list-con clearfix">
		{pc M=content action=user_lists catid=10000050 outhorname={$smarty.get.outhorname} field='id,title,url,thumb,description,outhorname,username,inputtime' order='id desc' num=18 page=$page}
		{foreach $data as $val}
		{if $val@index < 7}
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
		{/if}
		{/foreach}
		{/pc}
		</div>
	</div>
</div>
{require name="tw_mofang:statics/css/article/top_list.css"}
