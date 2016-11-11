{*

    * -->> common/base.tpl
    **************************************************
    *  h5 Game 独立模板
    **************************************************
    *
    *  main              : 主体区域
    *  header            : 页面头部
    *  footer            : 页面底部
    *  sidebar           : 页面侧边栏
    *  tongji            : 统计代码
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
{block name='body'}
	{require name="tw_acg:statics/css/common.css"}
    {require name="tw_acg:statics/js/common.js"}
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

    {* 顶部工具条 *}
    {block name='header'}
        {include file="tw_acg/widget/header.tpl"} 
    {/block}

    {* 主体区域 *}
    {block name='wrapper'}
        
    {/block}

    {* 弹出层 *}
    {block name='pop_box'}

    {/block}

    {* 返回 *}
    {block name='go_back'}
        
    {/block}
    
{/block}

