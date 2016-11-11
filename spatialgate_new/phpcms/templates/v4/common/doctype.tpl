{*
    *************************
    *  全站doctype定义
    *************************
    *
    *  所有模板文件都需从此模板继承
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

    <title>{block name=title}{strip}
        {$title}
    {/strip}{/block}</title>

    <meta name="keywords" content="{block name=keywords}{/block}">

    <meta name="description" content="{block name=description}{/block}">

    {* SEO优化,为各页面添加其对应的移动页面访问地址 *}
    {block name=pctowap}
    <meta name="mobile-agent" content="format=html5; url={$wap_url}">
    <meta name="mobile-agent" content="format=xhtml; url={$wap_url}">
    <link rel="alternate" type="applicationnd.wap.xhtml+xml" media="handheld" href="{$wap_url}" />
    {/block}


    {require name="common:statics/css/cssreset.css"}
    {require name="common:statics/css/cssbase.css"}
    {require name="common:statics/css/cssfonts.css"}
    {require name="common:statics/css/common.css"}
    {require name="common:statics/css/browser_update.css"}

    {* <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /> *}
    {block name='ico'}
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />
    {/block}
    {* IE6 png 图像处理 *}
    <!--[if IE 6]>
        <script src="/statics/v4/common/js/loader/dd_belatedpng.js"></script>
        <script>
            DD_belatedPNG.fix('.pngfix');
        </script>
    <![endif]-->


    {* ie8 以下浏览器html5兼容层 *}
    <!--[if lt IE 9]>
        <script src="/statics/v4/common/js/loader/html5shiv.js"></script>
    <![endif]-->

    <script>

    {* 组件之间调用 *}
    var MFE = {};

    {* 与后台数据交互 *}
    var CONFIG = {};

    {* cnzz统计代码 *}
    CONFIG['cnzz_code'] = '{$cnzz_code}';

    </script>

    {block name=head}

    {/block}
{/head}

{body}

    {block name=body}

    {/block}

    {* 统计代码 *}
    {block name=tongji}
    {literal}
    <script>
        //load cnzz
        function loadScript(id,src, callback) {

            var cnzz_protocol = (("https:" == document.location.protocol) ? " https://": " http://");
            var cnzz_url = ""+cnzz_protocol+"w.cnzz.com/q_stat.php?id=" + id + "";

            var s, r, t;
            r = false;
            s = document.createElement('script');
            s.defer = "defer";
            s.async="async";
            s.type = 'text/javascript';
            s.src = src || cnzz_url;

            s.onload = s.onreadystatechange = function() {
                if (!r && (!this.readyState || this.readyState == 'complete')) {
                    r = true;
                   callback && callback();
                }
            };

            t = document.getElementsByTagName('script')[0];
            t.parentNode.insertBefore(s, t);
        }
        //封装多事件
        function bindEvent(obj, ev, fn) {
            if (obj.addEventListener) {
                obj.addEventListener(ev, fn, false);
            } else if(obj.attachEvent) {
                obj.attachEvent('on' + ev, function() {
                    fn.call(obj);
                })
            } else {
                obj['on'+ ev] = fn;
            }
        }
    </script>
    {/literal}
    <div style="display: none">
        {$smarty.const.STATISTICAL}

        {block name=statistical}

            {* 在不同页面增加不同统计代码 *}
            {if $cnzz_code}
                {literal}
                <script type="text/javascript">
                    bindEvent(window,"load",function(){
                        loadScript(CONFIG['cnzz_code']);
                    })
                </script>
                {/literal}
            {/if}

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
        {/block}

        {* 全站通用的 *}
        {* 百度 *}
        {literal}
        <script type="text/javascript">
        var _hmt = _hmt || [];
            (function() {
              var hm = document.createElement("script");
              hm.src = "//hm.baidu.com/hm.js?c010118fc9ccb89ca3c38b4808b4dd4e";
              var s = document.getElementsByTagName("script")[0];
              s.parentNode.insertBefore(hm, s);
            })();
        </script>
        {/literal}
    </div>
    {/block}

    {* 全站命令行招聘信息 *}
    {block name="jobs"}
        {if !$mfe_go_home }
    	<script>
    	    setTimeout(function(){
                seajs.use(['jobs']);
    	    },100);
    	</script>
        {/if}
    {/block}
    {* ie低版本浏览器提示 *}

    {* 所有专区右下角推送内容 *}
    {if $is_partition==1}
    {*
    <script language='javascript' src='http://rwq.youle55.com/r/er_18922_7637.js'></script>
    *}
    <script>
        window.CONFIG = window.CONFIG || {};
        CONFIG.partationPopupUrl = "{$floating_url}";
        seajs.use("p/popup");
    </script>
    {/if}

    {* ie6 firebug lite 调试工具 *}
    {if $smarty.get.firebug }
        <script type="text/javascript" src="https://getfirebug.com/firebug-lite-debug.js"></script>
    {/if}

{/body}
{/html}
