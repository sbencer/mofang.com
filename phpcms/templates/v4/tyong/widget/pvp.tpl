{if !empty($module_setting[$module_name]['pvp_arr']) && $module_setting[$module_name]['disable_type'] == 0 }
    {$pvp=explode(',',$module_setting[$module_name]['pvp_arr'])}
    {$pvpv=$module_setting[$module_name]['pvpv']}
    {$pvp_pid=$module_setting[$module_name]['pvp_pid']}
    {$pvp_title=$module_setting[$module_name]['pvp_title']}
    {$module_style=1}
{else if !empty($pvp_arr['pvp_arr']) && $pvp_arr['disable_type']==0}
    {$pvp=explode(',',$pvp_arr['pvp_arr'])}
    {$pvpv=$pvp_arr['pvpv']}
    {$pvp_pid=$pvp_arr['pvp_pid']}
    {$pvp_title=$pvp_arr['pvp_title']}
    {$module_style=1}
{/if}

{if $module_style}
    <div class="pvp clearfix" id="pvp">
        <div class="hd-bg">
            <ul class="strat-side-hd clearfix">
                {foreach from=$pvp item=pvp_val}
                {pc M=partition action=idtoname catid=$pvp_val}
                <li class="{if $pvp_val@first }hot-curr{/if}">
                    {if !empty($pvp_title) }
                        {$pvp_title}
                    {else}
                        {mb_strimwidth($data.catname,0,8)}
                    {/if}
                    <span class="line"></span>
                </li>
                {/pc}
                {/foreach}
            </ul>
            {if !empty($pvp_pid)}
            <a href="{get_part_url($pvp_pid, 'pvp')}" target="_blank">
                <span class="hd-more">更多>></span>
            </a>
            {/if}
        </div>
        {* 攻略列表 *}
        <div class="pvp-con">
            {foreach from=$pvp item=pvp_val}
                <div class="pvp-side {if !($pvp_val@first) }fn-hide{/if}">
                    {pc M=partition action=lists2 partid=$pvp_val makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=9}
                    {$data = $data['contents'] }
                        <h3 style="text-align:center;">
                            <a class="pvp-side-title" href="{get_info_url($data[0]['catid'],$data[0]['id'])}" target="_blank">
                                {mb_strimwidth($data[0]['title'],0,36)}
                            </a>
                        </h3>
                        <ul class="clearfix">
                            {foreach from=$data key=key item=val}
                            {if !($val@first) }
                            <li class="pvp-side-item"><a href="{get_info_url($val['catid'], $val['id'])}" target="_blank">
                                {mb_strimwidth($val['title'],0,36)}</a>
                                <span class="info-more">{date('m-d',$val['inputtime'])}</span>
                            </li>
                            {/if}
                            {/foreach}
                        </ul>
                    {/pc}
                </div>
            {/foreach}
        </div>
        {* 攻略图文 *}
        <div class="pvp-cont">
            <ul>
                {if !empty($pvpv)}
                    {pc M=partition action=lists2 partid=$pvpv makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=8}
                        {$data = $data['contents'] }
                        {foreach from=$data item=val}
                        <li class="pvp-cont-item">
                            <a href="{get_info_url($val['catid'], $val['id'])}" target="_blank">
                                <img src="{qiniuthumb($val['thumb'],175,103)}" title="{$val['shortname']}"/>
                            </a>
                            
                            <a href="{get_info_url($val['catid'], $val['id'])}" target="_blank"><span>{$val['shortname']}</span></a>
                        </li>
                        {/foreach}
                    {/pc}
                {/if}
            </ul>
        </div>
    </div>
{/if}
