{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='common/hw/hw_mf_site_tw.tpl'}

{block name="body"}
	{block name="header"}
		{include file="tw_tyong/widget/header.tpl"}	
	{/block}
	{block name="ty-main"}
		<div class="tyong-main" style="background-image: url({$web_background}); background-position: 50% 0%; background-repeat: repeat;">
            <a href="{if $web_bg_url}{$web_bg_url}{else}javascript:;{/if}" class="tyong-bg" data-uri="{$web_header}" style="background-image: url({$web_header}); background-position: 50% 0%; background-repeat: no-repeat;"></a>
			<div class="tyong-main-con" style="margin-top: 15px;">
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
		{include file="tw_tyong/widget/footer.tpl"}
	{/block}
	{block name="style"}
		{require name="tw_tyong:statics/css/index.css"}
		{require name="common:statics/css/common-ref.css"}
		{require name="tw_tyong:statics/css/bg_color/bg_{if !empty($partition_color)}{$partition_color}{else}red{/if}.css"}
	{/block}
{/block}
