{if !empty($gls_arr)}
{$gls=explode(',',$gls_arr)}
<div class="hot_new">
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
{/if}