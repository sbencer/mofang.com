{*

    * -->> common/base.tpl
    **************************************************
    *  台湾主站基本模板
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
    {* logo *}
    {* 主体区域 *}
    {block name='header'}
        {include file="common/hw/v3/header.tpl"}
    {/block}
    {block name='main'}

    {/block}
    {* 友情链接 *}
    {block name='t_link'}

    {/block}

    {* 页面底部、版权信息等*}
    {block name='footer'}
        {include file="common/hw/v1/footer.tpl"}
    {/block}
	{block name="floatLayer"}
        <!--浮层 start-->
        <div class="floatLayer">
            <div class="content">
                <p class="coming_soon_text">敬請期待！稍等一下吧，我們快準備好囉！</p>
                <a class="mf_sure_btn" href="javascript:;">確定</a>
                <a class="mfBox_close" href="javascript:;">x</a>
            </div>
        </div>
        <div class="mask"></div>
        <!--浮层 end-->
    {/block}
    
    {block name='login'}
    {/block}
    {block name='sidebar'}
        {*側邊欄*}  
    {/block}
{/block}

