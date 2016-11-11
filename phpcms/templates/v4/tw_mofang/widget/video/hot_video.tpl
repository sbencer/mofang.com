<div class="hot-video mb10">
{pc M=content action=lists catid=10000058 order='listorder desc, id desc' num=9}
	{$num = 1}
	{foreach $data as $key=>$val}
	{if $key !== $id && $num <=8}
	<div class="hot-video-li clearfix mb10">
		<a href="{$val.url}" target="_blank" class="fl hot-video-imgarea">
			<img src="{qiniuthumb($val.thumb,260,146)}" alt="">
			<!-- <span>hot</span> -->
		</a>
		<div class="hot-video-txtarea">
			<h3><a href="{$val.url}" target="_blank">{$val.title}</a></h3>
			<span class="hot-video-num">{get_views('c-11-'|cat:$val.id)}</span>
			<span class="hot-video-time">發佈時間：<b>{$val.inputtime|date_format:"%Y-%m-%d"}</b></span>
		</div>
	</div>
	{$num = $num + 1}
	{/if}
	{/foreach}
{/pc}
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/video/hot_video.css"}
