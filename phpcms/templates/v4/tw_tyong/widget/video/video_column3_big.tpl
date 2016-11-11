<div class="zq_video clearfix">
	<div class="nav-common title2-bg mb10">
		<a href="{get_part_url($module_setting_type['video/video_column3_big']['video_arr'])}" class="more-common fr">更多<em>&gt;</em></a>
		<ul class="nav-com-list clearfix">
			<li class="class1">
			   {$module_setting_type['video/video_column3_big']['video_title']}
			</li>
		</ul>
	</div>
    <!--video_list start-->
    <ul class="zq_video_list have_big clearfix">
    {pc M=partition action=partition_contents partid={$module_setting_type['video/video_column3_big']['video_arr']} makeurl=1 fields='id,catid,url,title,description,inputtime,thumb' nums=5}
        {foreach $data as $val}
        {if $val@iteration == 1}
        {$return = preg_match("/src=\"(.*?)\"/", $val.content,$videos)}
        {if $val.youtube_id}
        <li class="big mofBox" data-src="https://www.youtube.com/embed/{$val.youtube_id}">
        {else}
        <li class="big mofBox" data-src="{$videos[1]}">
        {/if}
        	<a href="javascript:;">
            	<img src="{qiniuthumb($val.thumb,320,180)}" alt="{$val.title}">
                <i class="i_player"></i>
                <div class="describe">
                	<span class="text">{$val.title}</span>
                    <span class="q_player">立即播放</span>
                </div>
            </a>
        </li>
        {else}
        {$return = preg_match("/src=\"(.*?)\"/", $val.content,$videos)}
        {if $val.youtube_id}
        <li class="mofBox" data-src="https://www.youtube.com/embed/{$val.youtube_id}">
        {else}
        <li class="mofBox" data-src="{$videos[1]}">
        {/if}
        	<a href="javascript:;">
            	<img src="{qiniuthumb($val.thumb,320,180)}" alt="{$val.title}">
                <i class="i_player"></i>
                <div class="describe">
                	<span class="text">{$val.title}</span>
                    <span class="q_player">立即播放</span>
                </div>
            </a>
        </li>
        {/if}
        {/foreach}
    {/pc}
    </ul>
    <!--video_list end-->
</div>
{require name="tw_tyong:statics/css/zq_video.css"}