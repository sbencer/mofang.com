{*
    *************************
    *  全站doctype定义
    *************************
    *
    *  pc所有模板文件都需从此模板继承
    *
    *  title  : 页面title
    *  head   : 插入到head
    *  body   : 插入到body
    *
    *************************
*}
{* BIGPIPE QUICKLING NOSCRIPT *}
<!doctype html>
{html mode=NOSCRIPT framework="common:statics/js/loader/sea.js" }
{head}

    <meta charset="utf-8"/>

    {* 使用IE最高版本渲染,如果有chrome frome插件,则使用chrome frame *}
    <!--[if !IE]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--<![endif]-->
    {block name=resp}
    {/block}

    {* 让360浏览器默认以chrome内核显示 *}
    <meta name="renderer" content="webkit">
    {* iphone app *}
    <meta name="apple-itunes-app" content="app-id=1059683792">
    <title>{block name=title}{strip}
        {$title}
    {/strip}{/block}</title>

    <meta name="keywords" content="{block name=keywords}{/block}">

    <meta name="description" content="{block name=description}{/block}">

    {require name="common:statics/css/v5.5/base.css"}
    {require name="common:statics/css/v5.5/browser_update.css"}

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

    <script>

    {* 组件之间调用 *}
    var MFE = {};

    {* 与后台数据交互 *}
    var CONFIG = {};
    CONFIG['cnzz_code'] = '{$cnzz_code}';
    </script>

    {block name=head}

    {/block}
{/head}

{body}

    {block name=body}

    {/block}
    
    
        {* 苹果市场下载分成 *}
        {block name=apple_ad_token}
            <div style="display: none">
            {* 苹果广告联盟令牌JS *}
            {if $ios_ad_token}
                {literal}
                <script type='text/javascript'>
                    // 苹果广告联盟令牌JS
                    var _merchantSettings=_merchantSettings || [];
                    _merchantSettings.push(['AT', '11lobr']);
                    (function(){
                        var autolink=document.createElement('script');
                        autolink.type='text/javascript';
                        autolink.async=true;
                        autolink.src= ('https:' == document.location.protocol) ?
                            'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' :
                            'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';
                        var s=document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(autolink, s);
                    })();
                </script>
                {/literal}
            {/if}
            </div>
        {/block}
    

    {* 全站命令行招聘信息 *}
    {if !$mfe_go_home }
    <script>
        setTimeout(function(){
            seajs.use(['jobs']);
        },100);
    </script>
    {/if}

{/body}
{/html}
