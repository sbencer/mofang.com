{if !empty($module_setting[$module_name]['gls']) && !empty($module_setting[$module_name]['guide']['guide_arr']) && $module_setting[$module_name]['disable_type'] == 0 }
    {$gls=explode(',',$module_setting[$module_name]['gls'])}
    {$guide=explode(',',$module_setting[$module_name]['guide']['guide_arr'])}
    {$guide_pid=$module_setting[$module_name]['guide']['guide_pid']}
    {$guide_type=$module_setting[$module_name]['guide']['guide_type']}
    {$module_style=1}
{else if (!empty($gls_arr) && !empty($guideline['guide_arr']) && $newgls_guide_disable_type == 0)}
    {$gls=explode(',',$gls_arr)}
    {$guide=explode(',',$guideline.guide_arr)}
    {$guide_pid=$guideline.guide_pid}
    {$guide_type=$guideline.guide_type}
    {$module_style=1}
{/if}

{if $module_style}
<div class="strat clearfix">
    {* 魔方攻略 *}
    <div class="strat-side">
        <div class="hd-bg clearfix">
            <ul class="strat-side-hd clearfix">
                {if ( !empty($bbs_cat_api_url) && !empty($gls) )}
                    {foreach from=$gls item=gls_val}
                    {pc M=partition action=idtoname catid=$gls_val}
                        <li class="{if $gls_val@first }hot-curr{/if}">
                            {mb_strimwidth($data['catname'],0,8)}
                            <span class="line"></span>
                        </li>
                    {/pc}
                    {/foreach}
                    <li>
                        论坛热贴
                        <span class="line"></span>
                    </li>
                {elseif ( empty($bbs_cat_api_url) && !empty($gls) )}
                    {foreach from=$gls item=gls_val}
                    {pc M=partition action=idtoname catid=$gls_val}
                        <li class="{if $gls_val@first }hot-curr{/if}">
                            {if isset($luntan_title) }
                                {$luntan_title}
                            {else}
                                {mb_strimwidth($data['catname'],0,8)}
                            {/if}
                            <span class="line"></span>
                        </li>
                    {/pc}
                    {/foreach}
                {else}
                    <li class="hot-curr">论坛热贴<span class="line"></span></li>
                {/if}
        	</ul>
            {if ( empty($bbs_cat_api_url) && count($gls) == 1 ) }
                <a href="{get_part_url($gls[0], 'tyong')}" target="_blank"><span class="hd-more">更多&gt;&gt;</span></a>
            {/if}
        </div>
        <div class="strat-side-bd j_tabs_con">
            {if !empty($gls)}
                {foreach from=$gls item=gls_val}
                <ul class="clearfix j_tabs_c {if !($gls_val@first) }fn-hide{/if}">
                    {pc M=partition action=lists2 partid=$gls_val makeurl=1 fields='id,catid,url,title,inputtime,thumb' pagenum=6}
                        {foreach from=$data.contents item=val}
                            <li class="clearfix">
                                <a href="{get_info_url($val.catid, $val.id)}" target="_blank">{mb_strimwidth($val.title,0,36)}</a>
                                <span class="info-more fn-right" style="margin-right:10px;">{date('m-d', $val.inputtime)}</span>
                            </li>
                        {/foreach}
                    {/pc}
                </ul>
                {/foreach}
            {/if}
            {if !empty($bbs_cat_api_url)}
            <ul class="clearfix j_tabs_c {if !empty($gls) }fn-hide{/if}">
                <script type="text/javascript" src="http://bbs.mofang.com/api.php?mod=js&amp;bid={$bbs_cat_api_url}"></script>
            </ul>
            {/if}
        </div>
    </div>
    {* 新手指引 *}
    <div class="strat-guide" id="guide">
    	<div class="hd-bg clearfix">
            <ul class="strat-side-hd clearfix">
                <li class="hot-curr">新手指引<span class="line"></span></li>
            </ul>
            {if !empty($guide_pid)}<a href="{get_part_url($guide_pid,'tyong')}" target="_blank"><span class="hd-more">更多&gt;&gt;</span></a>{/if}
        </div>
        <div class="guide-list">
            {if $guide_type == 1 }
                {foreach from=$guide key=key item=val}
                    <dl class="strat-one" style="{strip}background-color:
                        {if ($partition_type == 'darkblue' || $partition_type == null ) }
                            {if $key%2 == 0 }rgb(31, 34, 41);{else}rgb(36, 40, 48);{/if}
                        {else}
                            {if $key%2 == 0 }rgb(255, 255, 255);{else}rgb(240, 240, 240);{/if}
                        {/if}
                        {/strip}">
                        {pc M=partition action=idtoname catid=$val}
                            <dt class="strat-guide-hd"><span class="{if $key > 1 }ui-bd-green{else}ui-bd{/if}">{$data['catname']}</span></dt>
                        {/pc}
                        <dd class="{if $key > 1 }ui-last{else}ui-first{/if} clearfix">
                            {pc M=partition action=lists2 partid=$val order='`listorder` DESC' makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=8}
                                {foreach from=$data.contents item=val}
                                    <a href="{get_info_url($val.catid,$val.id)}" target="_blank">{mb_strimwidth($val.shortname,0,16)}</a>
                                    {if !($val@last) }|{/if}
                                {/foreach}
                            {/pc}
                        </dd>
                    </dl>
                {/foreach}
            {else}
                <div class="strat-side-bd j_tabs_con">
                    <ul class="clearfix j_tabs_c">
                        {pc M=partition action=lists2 partid=$guide[0] makeurl=1 fields='id,catid,url,title,inputtime,thumb' pagenum=6}
                            {foreach from=$data.contents item=val}
                            <li class="clearfix">
                                <a href="{get_info_url($val.catid, $val.id)}" style="width:500px;">{mb_strimwidth($val['title'],0,60)}</a>
                                <span class="info-more fn-right" style="margin-right:10px;">{date('m-d', $val['inputtime'])}</span>
                            </li>
                            {/foreach}
                        {/pc}
                    </ul>
                </div>
            {/if}
        </div>
    </div>
</div>
{/if}
