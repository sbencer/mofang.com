<div class="prize-last-wrap j_tab_wrap">
    <h3 class="h3_title">好禮搶先拿<a href="{get_category_url('fahao')}" target="_blank" class="hw-common-more fr">更多 <em>></em></a></h3>
    <div class="con-hd mlr-9 clearfix">
        <ul class="clearfix">
            <li class="j_tab curr" data-href="{get_category_url('fahao')}">虛寶中心</li>
            <li class="j_tab" data-href="http://www.mofang.com.tw/pregister/10000111-1.html">事前登入</li>
        </ul>
    </div>
    <div class="hw-common-con">
    {pc M=content action=fahao num=12}
        <div class="prize-last-con clearfix j_con">
        {foreach $data as $val}
        {if $val@iteration <= 6}
            {if $val@iteration is odd by 1}
            <div class="prize-last-li fl bg-one">
                <a href="{$val.url}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{$val.url}" target="_blank" class="get-prize">領取</a>
                <a href="{$val.url}" class="prize-name">{$val.name}</a>
            </div>
            {else}
            <div class="prize-last-li fl bg-two">
                <a href="{$val.url}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{$val.url}" target="_blank" class="get-prize">領取</a>
                <a href="{$val.url}" class="prize-name">{$val.name}</a>
            </div>
            {/if}
        {else}
            {if $val@iteration is even by 1}
            <div class="prize-last-li fl bg-one">
                <a href="{$val.url}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{$val.url}" target="_blank" class="get-prize">領取</a>
                <a href="{$val.url}" class="prize-name">{$val.name}</a>
            </div>
            {else}
            <div class="prize-last-li fl bg-two">
                <a href="{$val.url}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{$val.url}" target="_blank" class="get-prize">領取</a>
                <a href="{$val.url}" class="prize-name">{$val.name}</a>
            </div>
            {/if}
        {/if}
        {/foreach}
        </div>
    {/pc}
    
    {pc M=content action=lists catid=10000111 type=coupon order='id desc' num=12}
        <div class="prize-last-con clearfix disno j_con">
        {foreach $data as $val}
        {if $val@iteration <= 6}
            {if $val@iteration is odd by 1}
            <div class="prize-last-li fl bg-one">
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" target="_blank" class="get-prize">詳請</a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" class="prize-name">{$val.title}</a>
            </div>
            {else}
            <div class="prize-last-li fl bg-two">
                <a href="{if $val.islink}{$val.url}{else}{$val.site_url}{/if}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" target="_blank" class="get-prize">詳請</a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" class="prize-name">{$val.title}</a>
            </div>
            {/if}
        {else}
            {if $val@iteration is even by 1}
            <div class="prize-last-li fl bg-one">
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" target="_blank" class="get-prize">詳請</a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" class="prize-name">{$val.title}</a>
            </div>
            {else}
            <div class="prize-last-li fl bg-two">
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" target="_blank">
                    <img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.name}">
                </a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" target="_blank" class="get-prize">詳請</a>
                <a href="{if $val.islink}{$val.url}{else}{$site_url}{/if}" class="prize-name">{$val.title}</a>
            </div>
            {/if}
        {/if}
        {/foreach}
        </div>
    {/pc}
    </div>
</div>
{require name="tw_mofang:statics/css/v3/prize_last.css"}
