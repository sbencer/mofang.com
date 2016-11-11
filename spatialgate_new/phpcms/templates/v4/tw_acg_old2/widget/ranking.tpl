<div class="hot-ranking clearfix">
	<div class="title">
		<h2 class="fl">人氣排行</h2>
		<div class="tab fr">
			<a class="curr" href="javascript:void(0);">動畫<i></i></a>
			<a href="javascript:void(0);">小說<i></i></a>
			<a href="javascript:void(0);">漫畫<i></i></a>
		</div>
	</div>
	<div class="tab_con">
		<ul class="article_list">
		{pc M="content" action="hits" catid="6" num="5" order="views DESC" cache="0"}
			{foreach $data as $val}
			<li><a href="{$val.url}">{$val@iteration}.{$val.title}</a></li>
			{/foreach}
		{/pc}
		</ul>
		<ul class="article_list disno">
		{pc M="content" action="hits" catid="21" num="5" order="views DESC" cache="0"}
			{foreach $data as $val}
			<li><a href="{$val.url}">{$val@iteration}.{$val.title}</a></li>
			{/foreach}
		{/pc}
		</ul>
		<ul class="article_list disno">
		{pc M="content" action="hits" catid="9" num="5" order="views DESC" cache="0"}
			{foreach $data as $val}
			<li><a href="{$val.url}">{$val@iteration}.{$val.title}</a></li>
			{/foreach}
		{/pc}
		</ul>

	</div>
</div>
{require name="tw_acg:statics/css/entrance.css"}
