{*
    * -->> base/seajs_base.tpl
    *************************
    *  泰文base基类模板
    *************************
    *
    *
    *************************
*}
{extends file='common/seajs_base.tpl'}

{* 在头部添加环境变量 *}
{block name=head}

    {*登录 login css 域名配置*}
    {$smarty.block.parent}
    <script>
        var lang_conf = "TW";
        var defaultURL = "http://u.mofang.com.tw";
    </script>
    {require name="common:statics/css/thai/login.css"}
    {require name="common:statics/js/base-config.js"}
    {require name="common:statics/css/common-ref.css"}
    {script}
    {*seajs.use(["login/check"])*}
    {/script}   
{/block}
