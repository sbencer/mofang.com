{extends file='tyong/base.tpl'}

{* 主体区域 *}
{block name="main"}
    {* 主要内容区域 *}
    <div class="main">
        {* 搜索结果 *}
        <div class="main-content clearfix">
            <div class="fl">
                <div class="content_list">
                    <div class="header_backg"></div>
                    <div class="ContentPublic">
                        {if $data['news']}
                            <ul>
                                {foreach from=$data.news item=val}
                                <li class="content_list_cont clearfix">
                                    <div class="img_show">
                                        <a href="{get_info_url($val.catid, $val.id)}" target="_blank"><img src="{qiniuthumb($val.thumb,218,130)}" title="{$val.title}" /></a>
                                    </div>
                                    <div class="content_lst">
                                        <h3><a class="content_lst_title" href="{get_info_url($val.catid, $val.id)}" target="_blank">{$val.title}</a><span class="lst_title_info">{date('Y-m-d H:i:s',$val.inputtime)}</span></h3>
                                        <p class="content_lst_artic">
                                            {if $val.description}
                                                {mb_strimwidth($val.description,0,112,'...')}
                                            {else}
                                                暂无描述
                                            {/if}
                                        </p>
                                        {$tags=preg_split('/\s*(,|，)\s*/', $val.keywords)}
                                        {foreach from=$tags item=v}
                                            <span>
                                                <a href="{get_search_url($v)}" target="_blank">{$v}</a>
                                                {if !($v@last)}|{/if}
                                            </span>
                                        {/foreach}
                                        {* <p class="content_lst_tag">
                                            <span>相关攻略</span>
                                            <span>玩家体验到最原汁原味</span>
                                            <span>炉石传说内侧</span>
                                        </p> *}
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                        {/if}
                        {*<div class="page-wrapper">
                            <div class="page-nav">
                                {mfpages($data['count_all'], $smarty.get.page, 12, get_part_url( $smarty.get.catid, 'tyong', true), array(), 5, '上一页', '下一页')}
                            </div>
                        </div>*}
                    </div>
                    <div class="foter"></div>
                </div>
            </div>
            <div class="fr w288 clearfix">
                {include file="tyong/widget/ldown.tpl"}
                {include file="tyong/widget/hot_news.tpl"}
                {include file="tyong/widget/hot_pic.tpl"}
                {include file="tyong/widget/hot_video.tpl"}
            </div>
            {require name="tyong/js/content.js"}
            {* 快捷导航 *}
            <div class="side-bar side-pos sidebar-meuns {if $partition_type=='darkblue'}darkColor{/if}">
                <h3 class="sidebar-tit">快捷导航</h3>
                <ul class="side-bar-nav">
                    {if !isset($fastnav) }
                        {foreach from=$fast_nav item=nav_val}
                            {if $nav_type != 1 }
                                <li><a href="{get_part_url($nav_val['fastnav_id'], 'tyong')}" target="_blank">{$nav_val['title']}</a></li>
                            {else}
                                <li><a href="{$nav_val['fastnav_id']}" target="_blank">{$nav_val['title']}</a></li>
                            {/if}
                        {/foreach}
                    {else}
                        {foreach from=$fastnav item=fn_val}
                        {pc M=partition action=idtoname catid=$fn_val}
                        <li><a href="{get_part_url($fn_val, 'tyong')}" target="_blank">{mb_strimwidth($data['catname'],0,8)}</a></li>
                        {/foreach}
                    {/if}
                </ul>
                <ul class="sidebar-meuns-icon">
                    {* 专区论坛 *}
                    {if !empty($bbs_nav_url)}
                        <li class="forum-icon"><a href="{$bbs_nav_url}" target="_blank">专区论坛</a></li>
                    {/if}
                    {* 精品专区 *}
                    <li class="zqu-icon"><a href="http://www.mofang.com/specials/614-1.html" target="_blank">精品专区</a></li>
                    {* 魔方礼包 *}
                    {if !empty($mf_libao_url) }
                        <li class="libao-icon"><a href="{$mf_libao_url}" target="_blank">发号礼包</a></li>
                    {/if}
                    {* 腾讯群组 *}
                    {if !array_is_null($qq_qun_url)}
                        <li class="jliu-icon">
                            <a href="http://shang.qq.com/wpa/qunwpa?idkey={$qq_qun_url.qun_idkey}" target="_blank">玩家交流</a>
                            <span class="qq-qun">{$qq_qun_url.qun_hao}</span>
                        </li>
                    {/if}
                    <li class="top-icon"><a class="side-go-top" href="#top" target="_self">返回顶部</a></li>
                </ul>
            </div>
            {*快捷导航结束*}
        </div>
    </div>
    {require name="tyong:statics/js/search.js"}
{/block}