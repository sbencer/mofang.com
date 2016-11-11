{*

    **************************************************
    * 创建静态页面时，在头部引用mfe框架和基础样式
    ***************************************************
*}

{htmljs mode=NOSCRIPT sampleRate=0 fid=false framework="common:statics/js/loader/sea.js" }
{headjs}

    <meta charset="utf-8"/>

    {* 使用IE最高版本渲染,如果有chrome frome插件,则使用chrome frame *}
    <!--[if !IE]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--<![endif]-->

    {* 让360浏览器默认以chrome内核显示 *}
    <meta name="renderer" content="webkit">

    <title>{block name=title}{strip}
        {$title}
    {/strip}{/block}</title>

    <meta name="keywords" content="{block name=keywords}{/block}">

    <meta name="description" content="{block name=description}{/block}">
    {* {require name="common:statics/css/cssfonts.css"}
    {require name="common:statics/css/cssreset.css"}
    {require name="common:statics/css/cssbase.css"}
    {require name="common:statics/css/common.css"}
    {require name="common:statics/css/browser_update.css"} *}
    {require name="common:statics/css/v6/base.css"}
    {require name="common:statics/css/v6/browser_update.css"}
    {require name="common:statics/css/v6/common.css"}
    {require name="common:statics/css/v6/comment.css"}
    {require name="common:statics/css/v6/pop_box.css"}


    {* <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /> *}
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />

    {* IE6 png 图像处理 *}
    <!--[if IE 6]>
        <script src="../statics/js/loader/dd_belatedpng.js"></script>
        <script>
            DD_belatedPNG.fix('.pngfix');
        </script>
    <![endif]-->


    {* ie8 以下浏览器html5兼容层 *}
    <!--[if lt IE 9]>
        <script src="../statics/js/loader/html5shiv.js"></script>
    <![endif]-->

    {if $MFE_USE_COMBO}
        {if $MFE_DEBUG}
            {require name='common:statics/js/loader/sea.js'}
            {require name='common:statics/js/loader/sea/combo.js'}
        {else}
            {require name='common:statics/js/loader/boot.js'}
        {/if}
    {else}
        {require name='common:statics/js/loader/sea.js'}
    {/if}

    {require name='modules:statics/js/sea-config.js'}


    {* 在头部添加环境变量 *}
    <script>
        {* 组件之间调用 *}
        var MFE = {};

        {* 与后台数据交互 *}
        var CONFIG = {};
    </script>

    {require name='common:statics/js/base-config.js'}

    {*　通用样式　*}
    {* {require name="common:statics/css/common-ref.css"} *}

{/headjs}

{bodyjs}

{/bodyjs}
{/htmljs}
