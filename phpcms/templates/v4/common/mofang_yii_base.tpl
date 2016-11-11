{*
    
    * --> common/base.tpl
    **************************************************
    * qulong
    * yii框架新模板,头部和底部使用js调用主站逻辑
    *  
    ***************************************************
*}

{extends file='common/mofang_site.tpl'}

{* html body *}
{block name=body}
    {require name="common:statics/css/mofang_reset.css"}
    {require name="common:statics/css/common.css"}
    {require name="common:statics/css/login.css"}


    {* 顶部工具条 *}
    
    {* 主体区域 *}
    {block name=main}
        <script src="http://www.mofang.com/index.php?m=content&c=index&a=scripts&t=js_toolbar_default"></script>        
    {/block}
    
    {* 页面底部、版权信息等*}
    {block name=footer}
        <script src="http://www.mofang.com/index.php?m=content&c=index&a=scripts&t=js_footer_simple"></script>

        <script>
          seajs.use(["login/check"]);
        </script>
    {/block}

{/block}



