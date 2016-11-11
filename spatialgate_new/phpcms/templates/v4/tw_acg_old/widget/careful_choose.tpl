	<div class="choose clearfix">
		<div class="title">
			<h2 class="fl">精選專欄</h2>
			<a href="{cat_url(16)}" class="more">更多</a>
		</div>
		<ul>
		{pc M="content" action="lists" catid="16" order="listorder DESC" thumb="1" num="6"}
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
	{require name="tw_acg:statics/css/information.css"}