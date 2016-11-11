{*

    * -->> common/base.tpl
    **************************************************
    *  主站定义
    *
    *  1.顶部工具条
    *  2.友情链接
    *  3.版权信息
    *  4.统计代码
    *
    **************************************************
    *
    *  main              : 主体区域
    *  site_nav_content  : 全站导航内容部分
    *       (TODO:phpcms框架和yii框架的数据还不能同步,
    *           新版的yii暂且使用静态导航)
    *  footer            : 页面底部
    *  t_link            : 友情链接
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

{* 主体区域 *}
{block name=body}
    {$smarty.block.parent}

    {require name="common:statics/js/base-config.js"}
    {require name="common:statics/css/nav_v4.css"}
    {require name="common:statics/css/login.css"}

    {* 顶部工具条 *}
    {include file="common/v4/toolbar.tpl"}

    {* 主体区域 *}
    {block name=main}

    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}
        {include file="common/v4/footer.tpl"}
    {/block}
{/block}