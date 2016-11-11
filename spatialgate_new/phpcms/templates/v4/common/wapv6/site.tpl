{*
    **************************************************
    * --> 移动端都从这里继承
    **************************************************
    *  顶部导航条
    *  友情链接部分
    *  版权信息
    **************************************************
    *  main              : 主体区域
    *  t_link            : 友情链接
    *  footer            : 页面底部
    ***************************************************
*}

{extends file='common/wapv6/doctype.tpl'}

{* 标题 *}
{block name=title}{strip}
    {if $SEO.title}
        {$SEO.title}
    {else}
        {$SEO.site_title}
    {/if}
{/strip}{/block}

{* 关键词 *}
{block name=keywords}{strip}
    {$SEO.keyword}
{/strip}{/block}

{* 页面描述 *}
{block name=description}{strip}
    {$SEO.description}
{/strip}{/block}

{block name=body}
    {$smarty.block.parent}
    {require name="common:statics/css/wapv6/common.css"}
    {require name="common:statics/js/wapv6/common.js"}
    <div class="wrapper">
    	{* wap 头部*}
    	{block name=header}
            {include file='common/wapv6/header.tpl'}
    	{/block}

    	{*　wap全局通用seed　*}

    	{* 主体区域 *}
        <div class="out-con">
           {block name=main} 
           {/block}
        </div>

    	{* 友情链接 *}
    	{block name=t_link}
    	{/block}

    	{* 页面底部、版权信息等*}
    	{block name=footer}
            {include file='common/wapv6/footer.tpl'}
    	{/block}

        {* 统计代码 *}
        {block name=tongji}
            {* 此处不要添加统计代码,统计代码已经拆分到各个业务模块 *}
        {/block}
    </div>

    
    {* 侧边导航 *}
    {block name=left_menu}
        {include file='common/wapv6/left_menu.tpl'}
    {/block}
    {* 弹出框 *}
    {block name=pop}
        {include file='common/v6/plug_fn/pop_box.tpl'}
    {/block}
    {* 分享 *}
    {block name=share}
        {include file='common/wapv6/plug_fn/share.tpl'}
    {/block}
    
    {* wrapper以外的特殊出来的代码出来 *}
    {block name=fixed}
       {include file='common/wapv6/plug_fn/movetop.tpl'}
    {/block}

    {* 前端业务模块的共用处理 *}
    {block name=mfe_common}
        {* 此处不要添加代码, 这里主要处理每个业务模块里面共用的base的css,js,tmp的逻辑*}
    {/block}
{/block}
