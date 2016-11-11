{extends file='tyong/base.tpl'}

{block name=main_content}
<style type="text/css">
<!--
.publicFont img{
max-width:630px;
width:expression(document.body.clientWidth > 630?"630px":"auto" ); 
border:0
}

-->
</style> 
{* 百度分享 *}
{literal}
<script>
    window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"0","bdPos":"right","bdTop":"100"}};
    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
{/literal}

    <div class="breadcrumb">
        <span>您正在访问：</span>
        <a href="{partition_url()}">首页</a> &gt;
        {*<a href="/">当前栏目</a> &gt;
        <a href="/">二级栏目</a> &gt;*}
        {$part_info=id_to_partinfo($smarty.get.id,$partition_id)}
        <a href="{get_part_url($part_info['catid'], 'tyong')}">{$part_info['catname']}</a> &gt;
        <span>正文</span>
    </div>
    <div class="fl clearfix">
        <div class="w690 fl ">
            <div class="header_backg"></div>
            <div class="ContentPublic">
                {if $modelid != 11 }
                    <div class="publicTitle">
                        <h3>{$rs.title}</h3>
                        {$tags=preg_split('/\s*(,|，)\s*/', $rs.keywords)}
                        {foreach from=$tags item=v}
                            <span style="display: none;">
                                <a href="{get_part_search_url($v,$partition_id)}" target="_blank">{$v}</a>
                                {if !($v@last)}|{/if}
                            </span>
                        {/foreach}
                        <p class="time"><span>时间：{date('Y-m-d', $rs.inputtime)}</span> <span>作者：{$rs.outhorname}</span><span>来源：{get_copyfrom($rs.copyfrom)}</span></p>
                {else}
                    <div class="publicTitle_video clearfix">
                        <h2 class="clearfix">{$rs.title}</h2> 
                        {$tags=preg_split('/\s*(,|，)\s*/', $rs.keywords)}
                        {foreach from=$tags item=v}
                            <span>
                                <a href="{get_part_search_url($v)}" target="_blank">{$v}</a>
                                {if !($v@last)}|{/if}
                            </span>
                        {/foreach}
                        <div class="shareBox fr clearfix">
                            <h3 class="share-tit">分享到</h3>
                            <ul class="share-list">
                                <li><a href="javascript:mfshare('weibo', '{$rs.title}');" class="sina" target="_self"></a></li>
                                <li><a href="javascript:mfshare('tqq', '{$rs.title}');" class="tx" target="_self"></a></li>
                                <li><a href="javascript:mfshare('qzone', '{$rs.title};')" class="kj" target="_self"></a></li>
                                <li><a href="javascript:mfshare('baidu', '{$rs.title};')" class="baidu" target="_self"></a></li>
                            </ul>
                        </div>
                {/if}
                </div>
                {if !empty($partition_type)}
                    <div class="publicFont" style="background-color: #F1F1F1;padding: 5px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$description}
                    </div>
                {else}
                    <div class="publicFont" style="padding: 5px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$description}
                    </div>
                {/if}
                <div class="publicFont">
                    {$content}
                </div>
                <div class="page-wrapper">
                    <div class="page-nav">
                        {$pages}
                    </div>
                </div>
                {if $modelid != 11 }
                <div class="contentShare">
                    {*<p class="fr speak">有话要说：<a href="">魔方网投稿指南>></a></p>*}
                    <p class="contentTag">责任编辑：{$rs.username}</p>
                    <div class="shareBox">
                        <h3 class="share-tit">分享到</h3>
                        <ul class="share-list">
                            <li><a href="javascript:mfshare('weibo', '{$rs.title}');" class="sina" target="_self"></a></li>
                            <li><a href="javascript:mfshare('tqq', '{$rs.title}');" class="tx" target="_self"></a></li>
                            <li><a href="javascript:mfshare('qzone', '{$rs.title};')" class="kj" target="_self"></a></li>
                            <li><a href="javascript:mfshare('baidu', '{$rs.title};')" class="baidu" target="_self"></a></li>
                        </ul>
                    </div>
                </div>
                {/if}
                <div class="context">
                    <p style="float:left;">上一篇：<a href="{$pre_url.url}">{mb_strimwidth($pre_url.title, 0, 24, '...')}</a></p>
                    <p style="float:right;">下一篇：<a href="{$next_url.url}">{mb_strimwidth($next_url.title, 0, 24, '...')}</a></p>
                </div>
                <div class="aboutContent">
                    <h4>相关内容</h4>
                    <ul class="relate_cont">
                        {*{foreach from=$relate_article_array key=r_k item=r_v}
                            <li><a href="{$r_v.url}" target="_blank">{$r_v.title}</a></li>
                        {/foreach}*}
                    </ul>
                </div>
                <div class="clearfix">
                    {if $allow_comment && module_exists('comment')}
                        <div id="comment_iframe_pos" url='{$smarty.const.APP_PATH}index.php?m=comment&c=index&a=init&commentid={id_encode("content_{$smarty.get.catid}",$rs.id,1)}&iframe=1&partition=tyong&partition_type={$partition_type}'>
                            
                        </div>
                    {/if}
                </div>
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
