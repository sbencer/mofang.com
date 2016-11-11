{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='common/hw/v3/hw_mf_site_tw.tpl'}
  
{* 在头部添加环境变量 *}
{block name=head}

    {$smarty.block.parent}
    {require name="common:statics/js/base-config.js"}
    {require name="tw_mofang:statics/css/hw_common.css"}
    {require name="tw_mofang:statics/js/imgError.js"}
    {script} seajs.use("login/check"); {/script}
    <!-- Facebook Pixel Code -->
    {literal}
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','//connect.facebook.net/en_US/fbevents.js');

    fbq('init', '131091923935688');
    fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=131091923935688&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','//connect.facebook.net/en_US/fbevents.js');

    fbq('init', '1728653627355565');
    fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1728653627355565&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

	<!-- start for twitter code -->
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
        <!-- end for twitter code -->

        <!-- start for contentparty code -->
        <script id="lucy_js" src="https://contentparty.org/js/article_view.js" data-lucy-id="d14258cb3d043b098a0be1b89ff35ec6" data-uid="48d849715b94ab6fa2abf3aa8d0e3a8b"></script>
        <!-- end for contentparty code -->



    {/literal}

{/block}
<div class="tw_mofang">

{* 主体区域 *}

{block name='sidebar'}
    {*側邊欄*}
    {include file="tw_mofang/widget/common/sidebar.tpl"}
{/block}
</div>
{block name='tongji'}
    {$smarty.block.parent}
    {*include file="tw_mofang/widget/common/analyticstracking.tpl"*}
{/block}

