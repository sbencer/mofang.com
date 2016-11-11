{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='common/hw/hw_mf_site_tw.tpl'}

{* 头部添加环境变量 *}
{block name=head}
	{$smarty.block.parent}
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<meta property="fb:app_id" content="1500638963557330" /> 
	<meta property="og:type"   content="article" /> 
	<meta property="og:url"    content="{trim($comment_article_url)}" /> 
	<meta property="og:title"  content="{$title}" /> 
	<meta property="og:image"  content="{$thumb}" /> 
	<meta property="og:description"  content="{$description}" /> 
    <!-- Facebook Pixel Code -->
    {literal}
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','//connect.facebook.net/en_US/fbevents.js');

    fbq('init', '131091923935688');
    fbq('track', "PageView");
    fbq('track', 'ViewContent');</script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=131091923935688&ev=PageView&noscript=1"
    /></noscript>
    {/literal}
    <!-- End Facebook Pixel Code -->
{/block}

{block name="body"}
	{block name="header"}
		{include file="tw_tyong/widget/common/header.tpl"}
	{/block}
	{block name="ty-main"}
		<div class="tyong-main" style="background-image: url({$web_background}); background-position: 50% 0%; background-repeat: repeat;">
            <a href="{if $web_bg_url}{$web_bg_url}{else}javascript:;{/if}" class="tyong-bg" data-uri="{$web_header}" style="background-image: url({$web_header}); background-position: 50% 0%; background-repeat: no-repeat;"></a>
			<div class="tyong-main-con" style="margin-top: 15px;">
            	
                {block name="slider_and_live"}
                    {if $module_setting_type['slider'] && $module_setting_type['slider']['disable_type'] != 1}
						{include file="tw_tyong/widget/video/slider.tpl"}
					{/if}
					{if $module_setting_type['live'] && $module_setting_type['live']['disable_type'] != 1}
				    	{include file="tw_tyong/widget/video/live.tpl"}
				    {/if}

                {/block}

				{block name="ty-bread"}
					{include file="tw_tyong/widget/common/bread.tpl"}
				{/block}
				{block name="ty-content"}
					<div class="ty-content clearfix">
					{block name="ty-con-left"}

					{/block}
					{block name="ty-con-right"}
					
					{/block}	
					</div>
				{/block}	
			</div>
		</div>
	{/block}
	{block name="footer"}
		{include file="tw_tyong/widget/common/footer.tpl"}
	{/block}
    {block name="bottom_content"}
		{include file="tw_tyong/widget/floatLayer.tpl"}
	{/block}
	{block name="sidebar"}
		{if $is_float}
		{foreach $floating as $val}
		<div class="demo">
			<a href="{$val.link}" target="_blank"><img src="{$val.pic}" alt="{$val.name}"></a>
			<img id="demo" src="/statics/v4/tw_tyong/img/colse_03.png">
		</div>
		{/foreach}
		{/if}
	{/block}
	{block name="style"}
		{require name="tw_tyong:statics/css/index.css"}
		{require name="common:statics/css/common-ref.css"}
		{require name="tw_tyong:statics/css/bg_color/bg_{if !empty($partition_color)}{$partition_color}{else}red{/if}.css"}
	{/block}
{/block}
{* 统计代码 *}
{block name="tongji"}
<div style="display: none">
    {$statistical_code}
    {literal}
    <!-- Start Alexa Certify Javascript -->
    <script type="text/javascript">
    _atrk_opts = { atrk_acct:"yaoJi1a8Dy00w9", domain:"mofang.com.tw",dynamic: true};
    (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
    </script>
    <noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=yaoJi1a8Dy00w9" style="display:none" height="1" width="1" alt="" /></noscript>
    <!-- End Alexa Certify Javascript -->
    {/literal}
</div>
{/block}
