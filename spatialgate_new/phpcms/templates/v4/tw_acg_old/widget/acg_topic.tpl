<div class="carouse-con-right fr">
	<div class="title">
		<h2>超次元話題</h2>
		<span>大家都在看什麽？</span>
	</div>
	<ul class="article_list">
	{pc M="content" action="position" posid="19" order="listorder DESC" thumb="1" num="6"}
        {foreach $data as $val}
		<li><a href="{$val.url}">{$val@iteration}.{$val.title}</a></li>
		{/foreach}
	{/pc}
	</ul>
	<a class="see_more" href="http://newbbs.mofang.com.tw/forum/6348.html"><span>前往次元討論區</span></a>
</div>
{require name="tw_acg:statics/css/carouse.css"}