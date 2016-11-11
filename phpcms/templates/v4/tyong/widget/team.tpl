{if !empty($module_setting[$module_name]['team_arr']) && $module_setting[$module_name]['disable_type'] == 0 }
    {$team=explode(',',$module_setting[$module_name]['team_arr'])}
    {$fuben=explode(',',$module_setting[$module_name]['fuben'])}
    {$team_title=$module_setting[$module_name]['team_title']}
    {$team_type=$module_setting[$module_name]['team_type']}
    {$module_style=1}
{else if !empty($team_arr['team_arr']) && $team_arr['disable_type']==0 }
    {$team=explode(',',$team_arr['team_arr'])}
    {$fuben=explode(',',$team_arr['fuben'])}
    {$team_title=$team_arr['team_title']}
    {$team_type=$team_arr['team_type']}
    {$module_style=1}
{/if}

{if $module_style}
    {* 团队副本 *}
    <div class="clearfix {strip}
        {if $_GET['iframe'] == 1 }
            w960
        {else}
            w988
        {/if}{/strip} mb-10 j_tab_tuandui" id="team">

        <div class="hd-bg clearfix">
            <ul class="strat-side-hd clearfix">
                <li class="hot tuj">
                    {if !empty($team_title) }
                        {$team_title}
                    {else}
                        副本信息
                    {/if}
                    <span class="line"></span>
                </li>
            </ul>
            <ul class="fr yingxiong j_tabs_title">
                {foreach from=$team item=team_val}
                    {pc M=partition action=idtoname catid=$team_val}
                        <li class="{if $team_val@first }hot-curr{/if}">{$data['catname']}</li>
                    {/pc}
                {/foreach}
            </ul>
        </div>
        <div class="j_tabs_con">
            {foreach from=$team item=team_val}
                {pc M=partition action=lists2 partid=$team_val makeurl=1 order='`listorder` ASC' fields='id,catid,url,title,shortname,inputtime,thumb' nums=14}
                {$data = $data['contents']}
                <div class="hd-bg-bttm clearfix j_tabs_c {if !($team_val@first) }fn-hide{/if}">
                    <div class="hd-bg-left fn-left">
                        <div class="shang"><em></em></div>
                        <div class="team_fu_par">
                            <ul class="team_fu team_hd j_tabs_title">
                                {foreach from=$data item=val}
                                    <li class="{if $val@first }hot-curr{/if}" ><p class="team_fu_xuan">{mb_strimwidth($val['shortname'],0,16)}</p></li>
                                {/foreach}
                            </ul>
                        </div>
                        <div class="xia"><em></em></div>
                    </div>
                    <div class="hd-bg-left-par">
                    {if $team_type == 1 }
                        {foreach from=$data item=val}
                            <div class="hd-bg-con clearfix fn-right j_tabs_c {if !($val@first) }fn-hide{/if}">
                                <div class="team_bd fl clearfix">
                                    {force_balance_tags($val['content'])}
                                </div>
                            </div>
                        {/foreach}
                    {else}
                        {foreach from=$data item=val}
                            <div class="hd-bg-con clearfix fn-right j_tabs_c {if !($val@first) }fn-hide{/if}">
                                <div class="team_bd fl clearfix">
                                    <a class="fl mar_20">
                                        <img src="{qiniuthumb($val['thumb'],348,238)}" title="{$val['title']}">
                                    </a>
                                    <div class="fl xiongmao_left  clearfix">
                                        <h3>{$val['title']}</h3>
                                        <div class="xiongmao_size clearfix">
                                            {mb_strimwidth(preg_replace("/\s/","",strip_tags(trim(force_balance_tags($val['content'])))) , 0 , 320 , '...')}
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        {/foreach}
                    {/if}
                    </div>
                    <div style="height:200px;">
                        {foreach from=$fuben item=fuben_val}
                        <div class="team_bd_two fl clearfix">
                            {pc M=partition action=idtoname catid=$fuben_val}
                                <div class="about">
                                    <strong>{$data['catname']}</strong>
                                    <span class="fr">
                                        <a href="{get_part_url($fuben_val,'ybtx')}" target="_blank">更多>></a>
                                    </span>
                                </div>
                            {/pc}
                            <ul>
                                {pc M=partition action=lists2 partid=$fuben_val makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=5}
                                    {$gl1 = $data['contents']}
                                    {foreach from=$gl1 item=gl1_val}
                                        <li><a class="fl" href="{get_info_url($gl1_val['catid'], $gl1_val['id'])}" target="_blank">{mb_strimwidth($gl1_val['title'],0,44)}</a><em class="fr">{date('m-d',$gl1_val['inputtime'])}</em></li>
                                    {/foreach}
                                {/pc}
                            </ul>
                        </div>
                        {/foreach}
                    </div>
                </div>
                {/pc}
            {/foreach}
        </div>
    </div>
{/if}
