<div class="news clearfix">
	<div class="title">
		<h2 class="fl">鮮新聞</h2>
		<a class="batch fr" href="javascript:;">換一批</a>
	</div>
	<ul>
	{pc M="content" action="lists" catid="12" order="listorder DESC" thumb="1" num="5"}
        {foreach $data as $val}
		<li>
			<a href="{$val.url}">
				<img src="{qiniuthumb($val.thumb, 320, 180)}" alt="">
				<span>{$val.title}</span>
			</a>
		</li>
		{/foreach}
	{/pc}
	</ul>
</div>
{require name="tw_acg:statics/css/news.css"}
{require name="tw_acg:statics/js/batch.js"}