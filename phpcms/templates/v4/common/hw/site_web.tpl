{*
    **************************************************
    * -->> common/base.tpl
    **************************************************
    *  顶部导航条
    *  友情链接部分
    *  版权信息
    *
    **************************************************
    *
    *  main              : 主体区域
    *  t_link            : 友情链接
    *  footer            : 页面底部
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


{* html body *}
{block name=body}

    {literal}
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T2VNZ3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T2VNZ3');</script>
    <!-- End Google Tag Manager -->
    {/literal}

    {$smarty.block.parent}

    {*　通用样式　*}
    {require name="common:statics/css/common-ref.css"}

    {*　全局通用seed　*}
    {require name="common:statics/js/base-config.js"}
    {*　老版本的内容页，也许还在调用该函数　*}
    {require name="common:statics/js/v5/mfshare.js"}

    {* 导航菜单 *}
    {block name=toolbar}
    {include file='common/v5/header.tpl'}
    {/block}

    {* 主体区域 *}
    {block name=main}
    {/block}

    {* 友情链接 *}
    {block name=t_link}
    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}
        {include file='common/v5/footer.tpl'}
    {/block}
{/block}

