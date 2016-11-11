<div class="tyong-carouse-wrap">
	<div class="top-list">
    {pc M=partition action=partition_contents partid={$module_setting_type['slider']['video_arr']} makeurl=1 fields='id,catid,url,title,description,inputtime,thumb' nums=6}{/pc}
		<div id="slider" class="flexslider">
            <ul class="top-list-big slides" id="slides">
            	<span style="display:none">1</span>
                {foreach $data as $val}
                {$return = preg_match("/src=\"(.*?)\"/", $val.content,$videos)}
                {if $val@iteration == 1}
                {if $val.youtube_id}
                <li class="flex-active-slide mofBox" data-src="https://www.youtube.com/embed/{$val.youtube_id}">
                {else}
                <li class="flex-active-slide mofBox" data-src="{$videos[1]}">
                {/if}
                    <a href="javascript:;" title="{$val.title}" target="_blank" style="background-image:url({$val.thumb})"></a>
                </li>
                {else}
                {if $val.youtube_id}
                <li class="mofBox" data-src="https://www.youtube.com/embed/{$val.youtube_id}">
                {else}
                <li class="mofBox" data-src="{$videos[1]}">
                {/if}
                    <a href="javascript:;" title="{$val.title}" target="_blank" style="background-image:url({$val.thumb})"></a>
                </li>
                {/if}
                {/foreach}
            </ul>
        </div>
		<div class="carousel-wrap">
			<div class="video-descript-wrap fl">
            {foreach $data as $val}
                {if $val@iteration == 1}
                <p class="video-descript">{$val.title}</p>
                {else}
                <p class="video-descript disno">{$val.title}</p>
                {/if}
            {/foreach}
            </div>
			<div class="carousel-list-wrap fr">
				<div id="carousel" class="flexslider smll-img">
                	<ul class="top-list-smll slides" id="carouse-list">
                    {foreach $data as $val}
                        {if $val@iteration == 1}
                        <li class="flex-active-slide">
                            <a href="javascript:;" title="{$val.title}">
                                <img src="{$val.thumb}" alt="{$val.title}" draggable="false">
                                <em class="mask"></em>
                            </a>
                        </li>
                        {else}
                        <li>
                            <a href="javascript:;" title="{$val.title}">
                                <img src="{$val.thumb}" alt="{$val.title}" draggable="false">
                                <em class="mask"></em>
                            </a>
                        </li>
                        {/if}
                    {/foreach}
                    </ul>
                </div>	
			</div>
		</div>
	</div>
</div>
{require name="tw_tyong:statics/css/slider.css"}
{require name="tw_tyong:statics/js/slider.js"}
