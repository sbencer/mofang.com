<div class="hot-video-wrap">
	<div class="hw-common-title">
		<a href="{cat_url(10000060)}" target="_blank" class="hw-common-more fr">更多 <em>></em></a>
		<h3>魔客派</h3>
	</div>
	<div class="hw-common-con">
		<div class="video-ce-con clearfix">
		{pc M=content action=lists catid=10000060 field='id,url,title,thumb' order='listorder desc, id desc' num=8}
			{foreach $data as $val}
			<div class="video-ce-li fl mb20">
				<a href="{$val.url}" target="_blank">
					<img src="{qiniuthumb($val.thumb,260,146)}" alt="">
					<p>
						<span>{$val.title}</span>
					</p>
				</a>
			</div>
			{/foreach}
		{/pc}
		</div>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/video_ce.css"}
