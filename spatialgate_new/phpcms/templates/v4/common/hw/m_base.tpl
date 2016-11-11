
{extends file='common/hw/m_doctype.tpl'}

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

{block name=head}

	{$smarty.block.parent}
    <script>

    {* 组件之间调用 *}
    var MFE = {};

    {* 与后台数据交互 *}
    var CONFIG = {};

    </script>

{/block}

{block name="body"}
	{block name="main"}
	{/block}
	{block name="tongji"}
				
		{literal}
			<div style="display:none;">
				<script type="text/javascript">
				_atrk_opts = { atrk_acct:"yaoJi1a8Dy00w9", domain:"mofang.com.tw",dynamic: true};
				(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
				</script>
				<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=yaoJi1a8Dy00w9"  height="1" width="1" alt /></noscript>
			</div>
		{/literal}
	{/block}
{/block}
