{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base.tpl'}


{* 在头部添加环境变量 *}
{block name=head}
    {$smarty.block.parent}
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta property="fb:app_id" content="1500638963557330" /> 
    <meta property="og:type"   content="article" /> 
    <meta property="og:url"    content="{trim($url)}" /> 
    <meta property="og:title"  content="{$title}" /> 
    <meta property="og:image"  content="{$thumb}" /> 
    <meta property="og:description"  content="{$description}" /> 
    {$smarty.block.parent}
    {require name="common:statics/js/base-config.js"}
    {require name="tw_mofang:statics/css/hw_common.css"}
    {script} seajs.use("login/check"); {/script}
    <script>
        var parentId = {$top_parentid};
        var catid = {$catid};
    </script>

{/block}

<div class="tw_mofang">
{* 顶部工具条 *}

{* 主体区域 *}
{block name='main'}
    <div class="hw-video-main">
        <div class="hw-main-wrap">
        {block name="ggao"}
            <div class="ggao clearfix mb10">
            {pc M=content action=lists catid=10000092 field='id,title,url,thumb' order='listorder desc, id desc' num=1 cache=600}
            {foreach $data as $val}
                <a href="{$val.url}" target="_blank" class="gg-l">
                    <img src="{$val.thumb}" alt="{$val.title}">
                </a>
            {/foreach}
            {/pc}
            {pc M=content action=lists catid=10000067 field='id,title,url,thumb' order='listorder desc, id desc' num=1 cache=600}
            {foreach $data as $val}
                <a href="{$val.url}" target="_blank" class="gg-r">
                    <img src="{$val.thumb}" alt="{$val.title}">
                </a>
            {/foreach}
            {/pc}
            </div>
        {/block}
        {block name="bread"}
        <div class="hw-common-bread mb10 w1000">
            <h3>
                <a href="http://{$smarty.server.SERVER_NAME}">首頁</a>
                {mfcatpos3($catid, '<em>></em>')}
                {if $title}<em>></em><span class="curr">{$title}</span>{/if}
            </h3>
        </div>
        {/block}
        {block name="main-content"}
        
        {/block}
        </div>
    </div>
{/block}
{block name='footer'}
    {include file="common/hw/v1/footer_detail.tpl"}
{/block}
{block name='sidebar'}
    {*側邊欄*}
    {include file="tw_mofang/widget/common/sidebar.tpl"}
    {require name="tw_mofang:statics/css/article/dialog.css"}
    {require name="tw_mofang:statics/js/dialog.js"}
    {require name="tw_mofang:statics/js/scroll.js"}
{/block}
</div>

