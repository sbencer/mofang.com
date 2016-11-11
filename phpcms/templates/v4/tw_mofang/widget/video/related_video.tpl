<div class="w680 related_video mb10">
	<div class="hw-common-title">
		<h3>相關視頻</h3>
	</div>
	<div class="hw-common-con">
		<div class="extend-read-con clearfix">
		{pc M=content action=relation catid=$catid keywords=$keywords num=4}
			{foreach $data as $val}
			<a href="{$val.url}" class="fl">
				<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				<p>{$val.shortname}</p>
				<span class="video-mask"></span>
				<span class="video-start-btn"></span>
			</a>
			{/foreach}
		{/pc}
		</div>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/article/extend_read.css"}
