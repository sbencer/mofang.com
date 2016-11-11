{*

    * -->> common/base.tpl
    **************************************************
    *  主站二级页定义
    *
    *  1.顶部工具条
    *  2.版权信息
    *  3.统计代码
    *
    **************************************************
    *
    *  main              : 主体区域
    *  footer            : 页面底部
    *  statistical       : 统计代码
    *
    ***************************************************
*}

{extends file='common/hw/base.tpl'}


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

{* 在头部添加环境变量 *}
{block name=head}
    {$smarty.block.parent}
    {require name="common:statics/js/base-config.js"}
    {require name="common:statics/css/common-ref.css"}
    {require name="common:statics/css/login_jp.css"}
{/block}


{* html body *}
{block name=body}

    {* 顶部工具条 *}
    {* logo *}
    
    {* 主体区域 *}
    {block name=main}

    {/block}
    {* 友情链接 *}
    {block name=t_link}

    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}
        {include file="common/sub_footer.tpl"}
    {/block}
    {block name=login}
        {include file="common/login.tpl"}
    {/block}
{/block}