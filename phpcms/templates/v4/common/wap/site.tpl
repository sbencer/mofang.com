{*
    **************************************************
    * --> 移动端
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
    {$smarty.block.parent}
    {require name="common:statics/css/wap/site.css"}
	{require name="common:statics/js/m/m-config.js"}
    {require name="common:statics/js/m/top.js"}

    <div class="wrapper">
	{* wap 头部*}
	{block name=header}
        {include file='common/wap/header.tpl'}
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
        {include file='common/wap/footer.tpl'}
	{/block}

    <div style="display:none;">
        <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000276053'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/q_stat.php%3Fid%3D1000276053' type='text/javascript'%3E%3C/script%3E"));</script>
    </div>

    </div>

{/block}
