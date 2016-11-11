<div id="anicomic" class="comics_show clearfix">
	<img src="/statics/v4/tw_acg/img/logo_anicomic.jpg" alt="">
	<div class="comics_list_box">
		<ul class="comics_list">
			<li>
			{pc M="content" action="lists" catid="46" order="listorder asc" num="5" page="1"}
				{foreach $data as $val}
				<dl data-catid="{$val.catid}" data-id="{$val.id}">
					<dt><a href="javascript:;"><img height="169" src="{$val.thumb}" alt="{$val.title}"></a></dt>
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
</div>
{*广告图*}
{pc M="content" action="lists" catid="45" order="listorder desc" num="1"}
	{foreach $data as $val}
	<a href="{$val.url}" style="width:888px; display:block; margin:0 auto; overflow:hidden;"><img width="888" src="{$val.thumb}" alt="{$val.title}"></a> 
	{/foreach}
{/pc}

{require name="tw_acg:statics/css/comics_show.css"}
{require name="tw_acg:statics/js/comics_show.js"}