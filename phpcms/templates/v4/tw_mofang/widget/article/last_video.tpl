<div class="last-video-wrap w310 mb10">
	<div class="hw-common-title">
        <a href="http://www.mofang.com.tw/Videos/10000058-1.html" target="_blank" class="hw-common-more fr">更多 <em>&gt;</em></a>
		<h3>最新影音</h3>
	</div>
	<div class="last-video-con">
	{pc M=content action=lists catid=10000058 field='id,title,url,thumb' order='listorder desc, id desc' num=3 cache=3600}
		{foreach $data as $val}
		<div class="last-video-li">
			<a href="{$val.url}" target="_blank" class="last-video-top">
				<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
			</a>
			<p>
				<a href="{$val.url}" target="_blank">{$val.title}</a>
			</p>
		</div>
		{/foreach}
	{/pc}
	</div>
</div>
{require name="tw_mofang:statics/css/article/last_video.css"}
