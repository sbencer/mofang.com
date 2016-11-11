<div class="hot-author-wrap">
	<div class="hw-common-title">
		<!-- <a href="#" class="hw-common-more fr">更多 ></a> -->
		<h3>人氣專欄</h3>
	</div>
	<div class="hw-common-con">
		<div class="hot-author-con clearfix">
		{pc M=content action=lists catid=10000069 field='id,url,title,shortname,thumb,description' order='listorder desc, id desc' num=5}
			{foreach $data as $val}
			<div class="hot-author-li fl mb20">
				<a href="{$val.url}" target="_blank" title="{$val.title}">
					<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				</a>
				<a href="{$val.url}" target="_blank" class="author-wd"  title="{$val.title}">{$val.title}</a>
				<span class="hot-news-author">作者：<em>{$val.shortname}</em></span>
				<span class="hot-author-intro">{$val.description}</span>
				
			</div>
			{/foreach}
		{/pc}
		</div>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/hot_author.css"}
