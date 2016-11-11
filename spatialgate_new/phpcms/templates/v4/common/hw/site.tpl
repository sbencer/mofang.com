{*
    **************************************************
    * --> 台湾移动端模板
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
    {require name="common:statics/css/hw/wap/site.css"}
	{require name="common:statics/js/m/m_config.js"}
    {require name="common:statics/js/m/top.js"}

    <div class="wrapper">
	{* wap 头部*}
	{block name=header}
        {include file='common/hw/v1/m_header.tpl'}
	{/block}

	{*　wap全局通用seed　*}

	{* 主体区域 *}
	<div class="bd">
	    {block name=main}

	    {/block}
	</div>

	{* 友情链接 *}
	{block name=t_link}
	{/block}

	{* 页面底部、版权信息等*}
	{block name=footer}
        {include file='common/hw/v1/m_footer.tpl'}
	{/block}
    {block name=tongji}
		{literal}
			<div style="display:none;">
				<!-- Start Alexa Certify Javascript -->
				<script type="text/javascript">
				_atrk_opts = { atrk_acct:"yaoJi1a8Dy00w9", domain:"mofang.com.tw",dynamic: true};
				(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
				</script>
				<noscript>&lt;img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=yaoJi1a8Dy00w9" style="display:none" height="1" width="1" alt="" /&gt;</noscript>
				<!-- End Alexa Certify Javascript -->
			</div>
		{/literal}
    {/block}
    </div>

{/block}
