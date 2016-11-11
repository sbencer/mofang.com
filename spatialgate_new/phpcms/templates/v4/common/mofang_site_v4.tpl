{*

    * -->> common/base.tpl
    **************************************************
    *  主站二级页定义
    *
    *  1.顶部工具条
    *  2.版权信息
    *  3.统计代码
    *  ps: 本页面导入的工具条包含专区导航菜单,与v5/site.tpl不同
    *
    **************************************************
    *
    *  main              : 主体区域
    *  footer            : 页面底部
    *  statistical       : 统计代码
    *
    ***************************************************
*}
{extends file='common/base.tpl'}


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
{/block}


{* html body *}
{block name=body}

    {* 顶部工具条 *}
    {* logo *}
    {include file="common/toolbar_v4.tpl"}
    {* 主体区域 *}
    {block name=main}

    {/block}
    {* 友情链接 *}
    {block name=t_link}

    {/block}
    {* v6版弹出框 *}
    {block name=pop}
        {include file='common/v6/plug_fn/pop_box.tpl'}
    {/block}
    {* 页面底部、版权信息等*}
    {block name=footer}
        {include file="common/sub_footer.tpl"}
    {/block}
<!-- ok -->
{/block}
