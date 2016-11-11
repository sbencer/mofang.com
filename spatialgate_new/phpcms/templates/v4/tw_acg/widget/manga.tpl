<div id="manga" class="comics_show clearfix">
	<img src="/statics/v4/tw_acg/img/logo_manga.jpg" alt="">
	<div class="comics_list_box">
		<ul class="comics_list">
			<li>
			{pc M="content" action="lists" catid="47" order="listorder desc" num="10"}
				{foreach $data as $val}
				<dl data-catid="{$val.catid}" data-id="{$val.id}">
					<dt><a href="javascript:;"><img src="{$val.thumb}" alt="{$val.title}"></a></dt>
					<dd>
						<a href="javascript:;">{$val.title}</a>
						{*<span class="icon_like">999</span>*}
					</dd>
				</dl>
				{/foreach}
			{/pc}
			</li>
			<li>
			{pc M="content" action="lists" catid="47" order="listorder desc" num="10" page="2"}
				{foreach $data as $val}
				<dl data-catid="{$val.catid}" data-id="{$val.id}">
					<dt><a href="javascript:;"><img src="{$val.thumb}" alt="{$val.title}"></a></dt>
					<dd>
						<a href="javascript:;">{$val.title}</a>
						{*<span class="icon_like">999</span>*}
					</dd>
				</dl>
				{/foreach}
			{/pc}
			</li>
		</ul>
	</div>
	<a class="btn_prev" href="javascript:;"></a>
	<a class="btn_next" href="javascript:;"></a>
</div>
{require name="tw_acg:statics/css/comics_show.css"}
{require name="tw_acg:statics/js/comics_show.js"}