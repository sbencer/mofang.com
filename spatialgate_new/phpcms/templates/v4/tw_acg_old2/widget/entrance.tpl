{*次元討論入口*}
<div class="hot-font clearfix">
	<h2>熱門關鍵字</h2>
	<div class="font_list clearfix">
	{pc module="content" action="types" num="20" cache="3600"}
        {foreach $data as $val}
		<a class="f{$val.total%10+10}" href="{tag($val.name)}">{$val.name}</a>
		{/foreach}
	{/pc}
	</div>
</div>
{require name="tw_acg:statics/css/entrance.css"} 