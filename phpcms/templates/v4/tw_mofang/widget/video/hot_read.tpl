<div class="hot-read-wrap">
	<div class="hw-common-title">
		<a href="{cat_url(10000195)}" class="hw-common-more fr">更多 <em>></em></a>
		<h3>手遊週報</h3>
	</div>
	<div class="hw-common-con">
		<div class="hot-read-con clearfix">
        {pc M=content action=lists catid=10000195 field='id,url,title,thumb' order='listorder desc, id desc' num=5}
			{foreach $data as $val}
			<div class="hot-read-li fl mb20">
				<a href="{$val.url}" target="_blank">
					<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				</a>
				<div class="hot-read-bttm">
					<a href="{$val.url}" target="_blank" class="read-wd">{$val.title}</a>
                    <span class="v-read-num">{get_views("c-11-{$val['id']}")*8+8}</span>
                    {*<span class="hot-read-intro">{$val.description|truncate:50}</span>*}
				</div>
			</div>
			{/foreach}
        {pc}
		</div>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/video/hot_read.css"}
