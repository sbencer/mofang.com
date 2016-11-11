{*
    **************************************************
    * -->> common/base.tpl
    **************************************************
    *  顶部导航条
    *  友情链接部分
    *  版权信息
    * 以后公用部分从这里继承（pc从这里继承）
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
{block name='body'}

 {require name="common:statics/css/hw/v6/base.css"}
 {require name="common:statics/css/hw/v6/browser_update.css"}
{require name='common:statics/css/hw/v6/common.css'}
{require name='common:statics/js/hw/v6/common.js'}
    {literal}
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T2VNZ3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T2VNZ3');</script>
    <script>
    	console.log("这是海外v6");
    </script>
    <!-- End Google Tag Manager -->
    {/literal}
<div class="page">
    {* 顶部工具条 *}
    {* logo *}
    {* 主体区域 *}
    {block name='header'}
        {include file="common/hw/v1/header.tpl"}
    {/block}
    <div class="out-con clearfix">
    {block name='main'}
	
    {/block}
    </div>
    {* 友情链接 *}
    {block name='t_link'}

    {/block}
	
    {* 页面底部、版权信息等*}
    {block name='footer'}
        {include file="common/hw/v1/footer.tpl"}
    {/block}
    
    {* 弹出框 *}
    {block name=pop}
        {include file='common/hw/v6/plug_fn/pop_box.tpl'}
    {/block}
    
    {block name='login'}
    {/block}
    {block name='sidebar'}
        {*側邊欄*}  
    {/block}
    {* 前端业务模块的共用代码 *}
    
    {block name=mfe_common}
        {* 此处不要添加代码, 这里主要处理每个业务模块共用的base里面共用的css,js,tmp的逻辑 *}
    {/block}
</div>
{/block}

