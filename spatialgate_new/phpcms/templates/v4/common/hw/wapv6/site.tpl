{*
    **************************************************
    * --> 移动端都从这里继承
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

{block name=body}
    {$smarty.block.parent}
    {require name="common:statics/css/hw/wapv6/common.css"}
    {require name="common:statics/js/hw/wapv6/common.js"}
    <div class="wrapper">
    	{* wap 头部*}
    	{block name=header}
           
    	{/block}

    	{*　wap全局通用seed　*}

    	{* 主体区域 *}
        <div class="out-con">
           {block name=main} 
           {/block}
        </div>

    	{* 友情链接 *}
    	{block name=t_link}
    	{/block}

    	{* 页面底部、版权信息等*}
    	{block name=footer}
            
    	{/block}

        {* 统计代码 *}
        {block name=tongji}
            {* 此处不要添加统计代码,统计代码已经拆分到各个业务模块 *}
        {/block}
    </div>

    
    {* 弹出框 *}
    {block name=pop}
        {include file='common/hw/v6/plug_fn/pop_box.tpl'}
    {/block}
	
    {* 前端业务模块的共用处理 *}
    {block name=mfe_common}
        {* 此处不要添加代码, 这里主要处理每个业务模块里面共用的base的css,js,tmp的逻辑*}
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
