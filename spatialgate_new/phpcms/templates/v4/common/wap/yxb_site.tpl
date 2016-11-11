{*
    **************************************************
    * --> 移动端魔方游戏宝
    **************************************************
    *  顶部导航条
    *  友情链接部分
    *  版权信息
    **************************************************
    *  main              : 主体区域
    *  t_link            : 友情链接
    *  footer            : 页面底部
    ***************************************************
    *  2015/4/14
    *  Eilvein
*}

{extends file='common/wap/doc.tpl'}

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
    {require name="common:statics/js/m/m-config.js"}
 {include file='common/p/jiajia_api.tpl'}
    {* 头部*}
    {block name=header}
    {/block}

    {* 全局通用seed　*}

    {* 主体区域 *}
    {block name=main}

    {/block}

    {* 友情链接 *}
    {block name=t_link}
    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}

    {/block}

    {* 统计 *}
    <div style="display:none;">
    </div>

{/block}
