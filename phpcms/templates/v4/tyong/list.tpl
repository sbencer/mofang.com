{extends file='tyong/base.tpl'}

{block name=main_content}
    <div class="breadcrumb">
        <span>您正在访问：</span>
        <a href="{partition_url()}">首页</a> &gt;
        {*<a href="/">当前栏目</a> &gt;
        <a href="/">二级栏目</a> &gt;
        <a href="/">三级栏目</a> &gt;*}
        {pc M=partition action=idtoname catid=$smarty.get.catid}
            <span>{$data['catname']}</span>
        {/pc}
    </div>
    <div class="fl">
        <div class="content_list">
            <div class="header_backg"></div>
            <div class="ContentPublic">
                {pc M=partition action=lists2 partid=$smarty.get.catid makeurl=1 fields='id,catid,url,title,inputtime,description,thumb' currpage=$smarty.get.page pagenum=12}
                <ul>
                    {foreach from=$data.contents item=val}
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
                <div class="page-wrapper">
                    <div class="page-nav">
                        {mfpages($data['count_all'], $smarty.get.page, 12, get_part_url( $smarty.get.catid, 'tyong', true), array(), 5, '上一页', '下一页')}
                    </div>
                </div>
                {/pc}
            </div>
            <div class="foter"></div>
        </div>
    </div>
    <!-- 站长需要在每个页面的HTML代码中包含以下自动推送JS代码： -->

<script>

(function(){

    var bp = document.createElement('script');

    bp.src = '//push.zhanzhang.baidu.com/push.js';

    var s = document.getElementsByTagName("script")[0];

    s.parentNode.insertBefore(bp, s);

})();

</script>
    <div class="fr w288 clearfix">

        {include file="tyong/widget/ldown.tpl"}
        {include file="tyong/widget/hot_news.tpl"}
        {include file="tyong/widget/hot_pic.tpl"}
        {include file="tyong/widget/hot_video.tpl"}
    </div>

    {require name="tyong:statics/js/content.js"}
    {require name="tyong:statics/js/search.js"}
{/block}
{block name="t_link"}
{/block}
