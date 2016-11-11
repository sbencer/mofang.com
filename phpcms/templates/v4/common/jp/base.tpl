{*
    * -->> base/seajs_base.tpl
    *************************
    *  base基类模板
    *************************
    *  登录注册
    *  统计代码
    *************************
*}
{extends file='common/seajs_base.tpl'}

{* 头部添加环境变量 *}
{block name=head}
    {$smarty.block.parent}
    <script>
        var lang_conf = "TW";
        var defaultURL = "http://u.mofang.com.tw";
    </script>
    {require name="common:statics/css/login.css"}
    {require name="common:statics/js/base-config.js"}
    {require name="common:statics/css/common-ref.css"}
    {script}
        seajs.use(["login/check"])
    {/script}   
{/block}
{block name='tongji'}
{literal}

	{*统计代码*}
    
{/literal}
{/block}
