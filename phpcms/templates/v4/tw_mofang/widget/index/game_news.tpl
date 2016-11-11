<div class="hot-news-wrap">
	<div class="hw-common-title">
		<a href="{cat_url(10000051)}" target="_blank" class="hw-common-more fr">更多 <em>></em></a>
		<h3>遊戲新聞</h3>
	</div>
	<div class="hw-common-con">
		<div class="hot-news-con clearfix">
		{pc M=content action=position posid=10000012 order='inputtime desc' num=5}
			{foreach $data as $val}
			<div class="hot-news-li hot-comm-li fl mb20">
				<a href="{$val.url}" class="imgarea" target="_blank">
					{if $val['tag']}<span class="hot-news-tag">{get_tag($val['tag'])}</span>{/if}
					<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				</a>
				<p>
					<a href="{$val.url}" class="hot-new-intro" target="_blank">{$val.title}</a>
                    {*<span class="hot-news-author">作者：{$val.outhorname}</span>*}
					<span class="hot-news-change">更新：{$val.inputtime|date_format}</span>
				</p>
			</div>
			{/foreach}
		{/pc}
		</div>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/hot_news.css"}
