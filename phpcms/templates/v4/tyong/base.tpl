{*
    
    *************************
    *  专区通用模板base
    *************************
    *
    *  main_content :主体区域
    *  
    *************************
*}


{extends file='common/mofang_site_v4.tpl'}


{* 头部设置样式 *}
{block name="head"}
    {$smarty.block.parent}
    <meta name="baidu-site-verification" content="BiY98mhcKV" />
    {if $smarty.get.iframe }
        {require name="tyong:statics/css/{if !empty($partition_type)}{$partition_type|cat:"123"}{else}darkblue123{/if}/model.css"}
    {else}
        {require name="tyong:statics/css/{if !empty($partition_type)}{$partition_type}{else}darkblue{/if}/model.css"}
    {/if}

    {require name="tyong:statics/css/relaxed.css"}
    {require name="tyong:statics/css/{if !empty($partition_type)}{$partition_type}{else}darkblue{/if}/common.css"}
    {require name="tyong:statics/css/{if !empty($partition_type)}{$partition_type}{else}darkblue{/if}/ref_sidebar.css"}

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
                    {* 专区搜索 *}
                    <div class="top-nav-conr fn-right">
                        <div class="top-nav-search">
                            <form action="javascript:;"  method="get" id="search">
                                <input type="text" class="search-ipt" name="q" value="搜索专区攻略资讯" autocomplete="off" onFocus="if(value==defaultValue){ this.value='' }" onBlur="if(value=='') this.value=defaultValue">
                                <input type="hidden" name="p" id="partition_id" value="{$partition_id}">
                                <input type="hidden" id="cid" value="{$smarty.get.catid}">
                                <input type="hidden" id="contid" value="{$smarty.get.id}">
                                <input type="hidden" id="pname" value="{$smarty.get.p}">
                                <input type="submit" class="search-icon">
                            </form>
                        </div>
                        <div class="search-con">
                            {$tags=preg_split('/\s*(,|，)\s*/', $SEO.keyword)}
                            {foreach from=$tags key=key item=v}
                                {if $key<3}
                                    <a href="{get_part_search_url($v,$partition_id,'news')}" target="_blank">{$v}</a>
                                    {*{if !($v@last)}|{/if}*}
                                {/if}
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

            {* 快捷导航 *}
            <div class="side-bar side-pos sidebar-meuns {if $partition_type=='darkblue'}darkColor{/if}">
                <h3 class="sidebar-tit">快捷导航</h3>
                <ul class="side-bar-nav">
                    {if !isset($fastnav) }
                        {foreach from=$fast_nav item=nav_val}
                            {if $nav_val.nav_type == 1 }
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
                    <li class="zqu-icon"><a href="http://www.mofang.com/zqnr/935-1.html" target="_blank">精品专区</a></li>
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
{/block}


{* 修改友情链接 *}
{block name="t_link"}
    <div class="t-links">
        <span>友情链接：</span>
        {if $link.type == 1 }
            {foreach from=$link.links item=v}
                <a href="{$v.url}" target="_blank">{$v.title}</a>
            {/foreach}

            {pc M=link action=lists typeid=536}
                {if $data}
                    {foreach from=$data item=v}
                    <a href="{$v.url}" target="_blank">{$v.name}</a>  
                    {/foreach}
                {/if}
            {/pc}
        {elseif $link.type == 2 }
            {pc M=link action=lists typeid=536}
                {if $data}
                    {foreach from=$data item=v}
                    <a href="{$v.url}" target="_blank">{$v.name}</a>  
                    {/foreach}
                {/if}
            {/pc}

            {foreach from=$link.links item=v}
                <a href="{$v.url}" target="_blank">{$v.title}</a>
            {/foreach}
        {else}
            {foreach from=$link.links item=v}
                <a href="{$v.url}" target="_blank">{$v.title}</a>
            {/foreach}
        {/if}
    </div>
{/block}


{* 增加统计代码 *}
{block name="statistical"}
    {if $smarty.get.iframe }
    <script type="text/javascript">
        var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cspan id='cnzz_stat_icon_1000258491'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/q_stat.php%3Fid%3D1000258491' type='text/javascript'%3E%3C/script%3E"));
    </script>
    {else}
    {$statistical_code}
    <script type="text/javascript">
        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fc010118fc9ccb89ca3c38b4808b4dd4e' type='text/javascript'%3E%3C/script%3E"));
    </script>
    {/if}
{/block}
