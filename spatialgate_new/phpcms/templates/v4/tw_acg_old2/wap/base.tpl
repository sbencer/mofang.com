{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='common/hw/m_base.tpl'}
{block name="head"}
    {$smarty.block.parent}
{/block}
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
	<div class="wrapper">
	{* header *}
	{include file="tw_acg/widget/wap/header.tpl"}
    {block name='content'}
    
    {/block}
    {block name='footer'}
        {*footer*}
        {include file="tw_acg/widget/wap/footer.tpl"}
    {/block}
    {* 回到顶部 *}
    <span class="go-up"></span>
    </div>
    {block name='sidebar'}
    	{* 左侧导航 *}
        {include file="tw_acg/widget/wap/classify.tpl"}
    	{* 右侧搜索 *}
        {include file="tw_acg/widget/wap/right_search.tpl"}
    {/block}
    {require name="tw_acg:statics/wap/css/g.css"}
    {require name="tw_acg:statics/wap/js/common.js"}
    {require name="tw_acg:statics/wap/js/go_top.js"}
    <script>
		var SearchURL = "{$smarty.const.APP_PATH}index.php?m=search&c=index&a=init&siteid=1&ajax=1&q=";
    </script>
    {block name='tongji'}
    <div style="display:none;">
        {literal}
            <!-- Start Alexa Certify Javascript -->
            <script type="text/javascript">
            _atrk_opts = { atrk_acct:"yaoJi1a8Dy00w9", domain:"spatialgate.com.tw",dynamic: true};
            (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
            </script>
            <noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=yaoJi1a8Dy00w9" style="display:none" height="1" width="1" alt="" /></noscript>
            <!-- End Alexa Certify Javascript -->  
        {/literal}
    </div>
    {/block}
{/block}

