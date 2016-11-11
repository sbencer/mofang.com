{if !empty($hot_pic)}

<div class="hot_girl fr">
    <div class="hd-bg">
        <ul class="strat-side-hd clearfix">
            <li class="hot-curr">美图壁纸<span class="line"></span></li>
        </ul>
        <a href="{get_part_url($pic,'tyong')}"><span class="hd-more">更多>></span></a>
    </div>
    <div class="hot_video_cont">
        <div class="strat-video-bd clearfix">
            <ul>
                {pc M=partition action=lists2 partid=$pic makeurl=1 fields='id,catid,url,shortname,inputtime,thumb' currpage=$page pagenum=6}
                {$data = $data['contents']}
                {foreach from=$data item=val}
                <li class="hot-video-item">
                    <a href="{get_info_url($val['catid'], $val['id'])}" target="_blank">
                        <img src="{$val['thumb']}" title="{$val['shortname']}"/>
                    </a>
                    <span>{$val['shortname']}</span>
                </li>
                {/foreach}
                {/pc}  
            </ul>
        </div>
    </div>
</div>
{/if}