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

{extends file='common/v5.5/seajs_base.tpl'}

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
{block name=body}
{require name='common:statics/css/v5.5/common.css'}
{require name='common:statics/js/v5.5/common.js'}
<div class="page">
    {$smarty.block.parent}
    {* 导航菜单 *}
    {block name=header}
        {include file='common/v5.5/header.tpl'}
    {/block}

    {* 主体区域 *}
    <div class="out-con clearfix">
        {block name=main}

        {/block} 
    </div>
    

    {* 弹出框 *}
    {block name=pop}
        {include file='common/v5.5/plug_fn/pop_box.tpl'}
    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}
        {include file='common/v5.5/footer.tpl'}
    {/block}
    {* 统计代码 *}
    <div style="display: none">
    {block name=tongji}
        {* 此处为整个魔方网项目通用的的统计代码 *}
            {* 百度统计 *}
            {literal}
            <script>
              var _hmt = _hmt || [];
                (function() {
                  var hm = document.createElement("script");
                  hm.src = "//hm.baidu.com/hm.js?c010118fc9ccb89ca3c38b4808b4dd4e";
                  var s = document.getElementsByTagName("script")[0];
                  s.parentNode.insertBefore(hm, s);
                })();
            </script>
            {/literal}
    {/block}
    </div>

    {* 前端业务模块的共用代码 *}
    {block name=mfe_common}
        {* 此处不要添加代码, 这里主要处理每个业务模块共用的base里面共用的css,js,tmp的逻辑 *}
    {/block}
</div>
{/block}

