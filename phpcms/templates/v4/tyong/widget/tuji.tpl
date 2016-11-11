{if !empty($module_setting[$module_name]['tuji_arr']) && $module_setting[$module_name]['disable_type'] == 0 }
    {$tuji=explode(',',$module_setting[$module_name]['tuji_arr'])}
    {$tuji_pid=$module_setting[$module_name]['tuji_pid']}
    {$module_style=1}
{else if !empty($tuji_arr['tuji_arr']) && $tuji_arr['disable_type']==0 }
    {$tuji=explode(',',$tuji_arr['tuji_arr'])}
    {$tuji_pid=$tuji_arr.tuji_pid}
    {$module_style=1}
{/if}

{if $module_style}
    {* 专区图集 *}
    <div id="image-list" class="j_tabs">
        <div class="hd-bg">
            <ul class="strat-side-hd clearfix">
                {foreach from=$tuji item=tuji_val}
                    {pc M=partition action=idtoname catid=$tuji_val}
                    <li class="{if $tuji_val@first }hot-curr{/if}">
                        {$data.catname}<span class="line"></span>
                    </li>
                    {/pc}
                {/foreach}
            </ul>
            {if !empty($tuji_pid)}
                <a href="{get_part_url($tuji_pid, 'tyong')}" target="_blank">
                    <span class="hd-more">更多>></span>
                </a>
            {/if}
        </div>
        <div class="strat-video-bd clearfix j_tabs_con">
            {foreach from=$tuji item=tuji_val}
                {pc M=partition action=lists2 partid=$tuji_val makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=5}
                {$data = $data['contents']}
                    <ul class="j_tabs_c {if !($tuji_val@first) }fn-hide{/if}">
                        {foreach from=$data item=val}
                        <li class="strat-video-item">
                        <a href="{get_info_url($val.catid,$val.id)}" target="_blank">
                            <img src="{qiniuthumb($val.thumb,197,135)}" title="{$val.shortname}"/>
                        </a>
                        <a href="{get_info_url($val.catid,$val.id)}" target="_blank"><span>{$val.shortname}</span></a>
                            
                        </li>
                        {/foreach}
                    </ul>
                {/pc}
            {/foreach}
        </div>
    </div>
{/if}
