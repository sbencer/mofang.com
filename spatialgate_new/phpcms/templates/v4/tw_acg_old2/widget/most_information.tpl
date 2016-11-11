	<div class="most-info fl">
		<div class="title">
			<h2>最受關注的情報</h2>
		</div>
		<ul class="clearfix">
		{pc M="content" action="hits" catid="12" num="5" order="weekviews DESC" cache="0"}
			{foreach $data as $val}
			<li>
				<a href="{$val.url}">
					<img src="{qiniuthumb($val.thumb,260,146)}">
					<h3>{$val.title}</h3>
					<span>{trim($val.description)}</span>
				</a>
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
	<!--活动记事-->
	<div class="most-info fl">
		<div class="title">
			<h2 class="fl">活動記事</h2>
			<a href="{cat_url(20)}" class="more">更多</a>
		</div>
		<ul class="clearfix">
		{pc M="content" action="lists" catid="20" order="listorder DESC" thumb="1" num="5"}
			{foreach $data as $val}
			<li>
				<a href="{$val.url}">
					<img src="{qiniuthumb($val.thumb,260,146)}">
					<h3>{$val.title}</h3>
					<span>{trim($val.description)}</span>
				</a>
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
{require name="tw_acg:statics/css/information.css"}