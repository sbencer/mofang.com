{if !empty($hot_video)}
<div class="hot-video fr" id="video">
    <div class="hd-bg">
        <ul class="strat-side-hd clearfix">
            <li class="hot-curr">游戏视频<span class="line"></span></li>
        </ul>
        <a href="{get_part_url($video, 'tyong')}" target="_blank"><span class="hd-more">更多>></span></a>
    </div>
    <div class="strat-video-bd clearfix j_tabs_con">
        <ul class="j_tabs_c">
            {pc M=partition action=lists2 partid=$video makeurl=1 fields='id,catid,url,shortname,inputtime,thumb' currpage=$page pagenum=6}
            {$data = $data['contents']}
            {foreach from=$data item=val}
            <li class="hot-video-item">
                <a href="{get_info_url($val['catid'], $val['id'])}" target="_blank">
                    <img src="{$val['thumb']}" title="{$val['shortname']}"/>
                    <span class="video-start"></span>
                    <span>{$val['shortname']}</span>
                </a>
            </li>
            {/foreach}
            {/pc}
        </ul>
    </div>
</div>
{/if}