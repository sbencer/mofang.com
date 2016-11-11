<div class="video-zhuan mb10">
	<div class="nav-common title2-bg mb10">
		<a href="{get_part_url({$module_setting_type['video/video_column32']['video_arr']})}" class="more-common fr">更多<em>></em></a>
		<ul class="nav-com-list clearfix">
			<li class="class1">
			   {$module_setting_type['video/video_column32']['video_title']}
			</li>
		</ul>
	</div>
	<div class="common-con-nobd">
		<div class="video-zhuan-wrap">
		{pc M=partition action=partition_contents partid={$module_setting_type['video/video_column32']['video_arr']} makeurl=1 fields='id,catid,url,title,description,inputtime,thumb' nums=6}
			<ul class="clearfix">
				{foreach $data as $val}
				{$return = preg_match("/src=\"(.*?)\"/", $val.content,$videos)}
				{if $val.youtube_id}
				<li class="fl mofBox" data-src="https://www.youtube.com/embed/{$val.youtube_id}">
				{else}
				<li class="fl mofBox" data-src="{$videos[1]}">
				{/if}
					<a href="javascript:;">
						<img src="{qiniuthumb($val.thumb,320,180)}" alt="{$val.title}">
						<div class="video-hover">	
							<span><i></i></span>
						</div>
						<div class="p">
							{$val.title}
							<div class="video-hovers">	
								<span><i></i></span>
								立即播放
							</div>
						</div>
					</a>
				</li>
				{/foreach}
			</ul>
		{/pc}
		</div>
	</div>
</div>
<div class="floatLayer">
    <div class="content">
    	<iframe width="800" height="450" src="https://www.youtube.com/embed/ktgrINi4gh8" frameborder="0" allowfullscreen></iframe>
        <a class="mofBox_close" href="javascript:;">x</a>
    </div>
</div>
<div class="mask"></div>
{require name="tw_tyong:statics/css/video_zhuan.css"}
{require name="tw_tyong:statics/css/floatLayer.css"}
{require name="tw_tyong:statics/js/floatLayer.js"}

