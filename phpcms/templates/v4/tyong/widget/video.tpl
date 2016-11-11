{if !empty($module_setting[$module_name]['video_arr']) && $module_setting[$module_name]['disable_type'] == 0 }
    {$video=explode(',',$module_setting[$module_name]['video_arr'])}
    {$video_pid=$module_setting[$module_name]['video_pid']}
    {$module_style=1}
{else if !empty($video['video_arr']) && $video['disable_type']==0 }
    {$video=explode(',',$video['video_arr'])}
    {$module_style=1}
{/if}

{if $module_style}
    {* 专区视频 *}
    <div class="strat-video j_tabs" id="video">
        <div class="hd-bg">
            <ul class="strat-side-hd clearfix">
                {foreach from=$video item=video_val}
                    {pc M=partition action=idtoname catid=$video_val}
                    <li class="{if $video_val@first }hot-curr{/if}">{mb_strimwidth($data.catname,0,8)}<span class="line"></span></li>
                    {/pc}
                {/foreach}
            </ul>
            {if !empty($video_pid)}<a href="{get_part_url($video_pid, 'tyong')}" target="_blank"><span class="hd-more">更多>></span></a>{/if}
        </div>
        <div class="strat-video-bd clearfix j_tabs_con">
            {foreach from=$video item=video_val}
                {pc M=partition action=lists2 partid=$video_val makeurl=1 fields='id,catid,url,shortname,inputtime,thumb' pagenum=12}
                    <ul class="j_tabs_c {if !($video_val@first) }fn-hide{/if}">
                        {foreach from=$data.contents item=val}
                            <li class="strat-video-item"><a href="{get_info_url($val.catid, $val.id)}" target="_blank"><img src="{qiniuthumb($val.thumb,175,103)}" title="{$val.shortname}"/><span class="video-start"></span><span>{$val.shortname}</span></a></li>
                        {/foreach}
                    </ul>
                {/pc}
            {/foreach}
        </div>
    </div>
{/if}
