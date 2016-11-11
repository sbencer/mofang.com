{*

    **************************************************
    * 创建静态页面时，在头部引用mfe框架和基础样式
    ***************************************************
*}

{htmljs mode=NOSCRIPT sampleRate=0 fid=false framework="common:statics/js/loader/sea.js" }
{headjs}


    {require name="common:statics/css/cssreset.css"}
    {require name="common:statics/css/cssbase.css"}
    {require name="common:statics/css/cssfonts.css"}
    {require name="common:statics/css/common.css"}
    {require name="common:statics/css/js/base.css"}
    {require name="common:statics/css/js/index.css"}

    {* <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> *}
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />
    {* IE6 png 图像处理
    <!--[if IE 6]>
        <script src="/statics/v4/common/js/loader/dd_belatedpng.js"></script>
        <script>
            DD_belatedPNG.fix('.pngfix');
        </script>
    <![endif]-->
    *}

    {* ie8 以下浏览器html5兼容层 *}

    <!--[if lt IE 9]>
        <script src="/statics/v4/common/js/loader/html5shiv.js"></script>
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

    {require name="common:statics/css/mofang_reset.css"}
    {require name="common:statics/css/common.css"}
    {require name="common:statics/css/login.css"}

{/headjs}

{bodyjs}

{/bodyjs}
{/htmljs}
