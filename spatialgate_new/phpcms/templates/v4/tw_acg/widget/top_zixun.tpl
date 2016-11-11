<div class="top_zixun">
	<a class="fl" href="{cat_url(12)}"><img src='/statics/v4/tw_acg/img/top_zixun_img.jpg' alt="新聞速報"></a>
	<ul class="top_zx_list">
	{pc M="content" action="lists" modelid="1" order="listorder DESC" thumb="1" num="10"}
		{foreach $data as $val}
		<li><a href="{$val.url}">{$val.title}</a></li>
		{/foreach}
	{/pc}
	</ul>
</div>
{require name="tw_acg:statics/css/top_zixun.css"}