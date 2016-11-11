{*
    
    *************************
    *  专区通用模板base
    *************************
    *
    *  main_content :主体区域
    *  
    *************************
*}


{extends file='base/360base.tpl'}


{* 头部设置样式 *}
{block name="head"}
    {$smarty.block.parent}
    {if $smarty.get.iframe }
        {require name="tyong/css/{if !empty($partition_type)}{$partition_type|cat:"123"}{else}darkblue123{/if}/model.css"}
    {else}
        {require name="tyong/css/{if !empty($partition_type)}{$partition_type}{else}darkblue{/if}/model.css"}
    {/if}

    {require name="tyong/css/relaxed.css"}
    {require name="tyong/css/{if !empty($partition_type)}{$partition_type}{else}darkblue{/if}/common.css"}
    {require name="tyong/css/{if !empty($partition_type)}{$partition_type}{else}darkblue{/if}/ref_sidebar.css"}

    <base target="_blank">

    {if $smarty.get.iframe}
    {literal}
        <style>
        .header{display:none;}
        .main-top{display:none;}
        .t-fooher{display:none;}
        .side-bar{display:none;}
        </style>
    {/literal}
    {else}
    {literal}
        <style>
        .hh-content-con-toptitle{display:none;}
        </style>
    {/literal}
    {/if}
{/block}


{* 主体区域 *}
{block name="main"}
    {$smarty.block.parent}
    {* 主要内容区域 *}
    <div class="main">
        {* 顶部 *}
        <div class="main-top" id="top">
            {* 头图 *}
            {pc M=partition action=partition_info partid=$partition_id fields=setting}
            <div class="main-top-pic" style="background:url({$data.setting.web_header}) center 0 no-repeat;height: 340px;"></div>
            {/pc}

            <div class="main-top-nav">
                <div class="top-nav-con clearfix" style="height:{$nav_height}px;">
                    <div class="top-nav-conl">
                        <div class="top-nav-detail clearfix">
                            <a href="{partition_url()}">首页</a>
                            {foreach from=$part_nav item=nav_val}
                                {if $nav_val.nav_type == 1 }
                                    <a href="{get_part_url($nav_val.nav_value, 'tyong')}" target="_blank">{mb_strimwidth($nav_val.name,0,8)}</a>
                                {else}
                                    <a href="{$nav_val.nav_value}" target="_blank">{mb_strimwidth($nav_val.name,0,8)}</a>
                                {/if}
                            {/foreach}
                        </div>
                        <div class="top-navl-center clearfix">
                            {foreach from=$little_nav item=little_nav_val}
                            <div class="top-nav-race fn-left">
                                {if $little_nav_val['type']=='list_id'}
                                    <span class="nav-race-title">{$little_nav_val['title']}：</span>
                                    {$partid_arr=explode(',',$little_nav_val['partid_arr'])}
                                    {foreach from=$partid_arr item=val}
                                        {pc M=partition action=idtoname catid=$val}
                                        <a class="race-c" href="{get_part_url($val, 'tyong')}" target="_blank">{$data['catname']}</a>
                                        <em>|</em>
                                        {/pc}
                                    {/foreach}
                                {else}
                                    <span class="nav-race-title">{$little_nav_val['name']}：</span>
                                    {pc M=partition action=lists2 partid=$little_nav_val['partid'] makeurl=1 fields='id,catid,url,shortname,inputtime,thumb' pagenum=$little_nav_val['nums']}
                                        {foreach from=$data['contents'] item=val}
                                        <a class="race-c" href="{get_info_url($val['catid'], $val['id'])}" target="_blank">{$val['shortname']}</a>
                                        {if !($val@last) }<em>|</em>{/if}
                                        {/foreach}
                                    {/pc}
                                {/if}
                            </div>
                            {/foreach}
                        </div>
                    </div>
                    <a class="enter-luntan" href="{strip}
                        {if !empty($bbs_nav_url) }
                            {$bbs_nav_url}
                        {else}
                            http://bbs.mofang.com/
                        {/if}
                    {/strip}" target="_blank"></a>
                </div>
            </div>
        </div>

        <div class="main-content clearfix">

            {block name="main_content"}
                {* 主内容区域 *}
            {/block}

        </div>
    </div>
{/block}


