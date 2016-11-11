{*
    * -->> base/seajs_base.tpl
    *************************
    *  base基类模板
    *************************
    *
    *
    *************************
*}
{extends file='common/seajs_base.tpl'}

{* 在头部添加环境变量 *}
{block name=head}

    {*登录 login css 域名配置*}

    {if $smarty.const.SITEID == 3}
        {require name="hw_mfang:statics/css/hw_idx_jp.css"}
        {require name="common:statics/css/login_jp.css"}
        <script>
            var lang_conf = "JP";
            var defaultURL = "http://u.mofang.jp";
        </script>
        {$smarty.block.parent}
    {else if $smarty.const.SITEID == 2}
        {require name="hw_mfang:statics/css/hw_idx_en.css"}
        {require name="common:statics/css/login_en.css"}
        <script>
            var lang_conf = "EN";
            var defaultURL = "http://u.appmofang.com";
        </script>
        {$smarty.block.parent}
    {else}
        <script>
            var lang_conf = "ZH";
            var defaultURL = "http://u.mofang.com";
        </script>

        {$smarty.block.parent}
        {require name='common:statics/css/zh_cn/login.css'}
        {require name='common:statics/js/zh_cn/base-config.js'}
    {/if}
    
{/block}
