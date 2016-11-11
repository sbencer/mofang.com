<div class="coserBox">
	<p class="blue">
		<a class="curr" href="{cat_url(14)}">COS</a>
		<a href="{cat_url(38)}">創作</a>
	</p>
	<div class="coser">
    {pc M="content" action="lists" catid="14" order="listorder DESC" thumb="1" num="5"}
		{foreach $data as $val}
		<a href="{$val.url}"><img src="{qiniuthumb($val.thumb,320,180)}" alt="{$val.title}"></a>
		{/foreach}
	{/pc}
	</div>
	<div class="coser disno">
    {pc M="content" action="lists" catid="38" order="listorder DESC" thumb="1" num="5"}
		{foreach $data as $val}
		<a href="{$val.url}"><img src="{qiniuthumb($val.thumb,320,180)}" alt="{$val.title}"></a>
		{/foreach}
	{/pc}
	</div>
</div>
{require name="tw_acg:statics/css/coser.css"}
{require name="tw_acg:statics/js/common.js"}