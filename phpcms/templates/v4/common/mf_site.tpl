{*

    * -->> base/base.tpl
    **************************************************
    *  主站定义 yii框架
    *
    *  1.顶部工具条
    *  2.友情链接
    *  3.版权信息
    *  4.统计代码
    *
    **************************************************
    *
    *  main              : 主体区域
    *  site_nav_content  : 全站导航内容部分
    *       (TODO:phpcms框架和yii框架的数据还不能同步,
    *           新版的yii暂且使用静态导航)
    *  footer            : 页面底部
    *  statistical       : 统计代码
    *
    ***************************************************
*}

{extends file='common/base.tpl'}


{* 关键词 *}
{block name=keywords}{strip}
    {$SEO.keyword}
{/strip}{/block}



{* 页面描述 *}
{block name=description}{strip}
    {$SEO.description}
{/strip}{/block}



{* 标题 *}
{block name=title}{strip}
    {if $SEO.title}
        {$SEO.title}
    {else}
        {$SEO.site_title}
    {/if}
{/strip}{/block}

{* 在头部添加环境变量 *}
{block name=head}
    <script>
        {* 组件之间调用 *}
        var MFE = {};

        {* 与后台数据交互 *}
        var CONFIG = {};
    </script>

    {$smarty.block.parent}
    {* <script src="./js/base-config.js" type="text/javascript" charset="utf-8"></script> *}

    {require name="common:statics/css/mofang_reset.css"}
    {require name="common:statics/css/common.css"}
    {require name="common:statics/css/login.css"}
    {require name="common:statics/css/nav_v4.css"}
{/block}


{* html body *}
{block name=body}

    {* 顶部工具条 *}
    <div class="show-header-wrap">
        <div class="show-header">
            <div class="show-header-app J_hover_app">
                <h2 class=""><a href="http://www.mofang.com/mokepi/934-1.html">手游助手APP</a><i class="show-down-icon"></i></h2>
                <div class="show-header-app-down J_app_down">
                    <ul>
                        <script type="text/javascript" src="http://www.mofang.com/index.php?m=mofangapp&c=index&a=dom_list&app=yxb"></script>
                    </ul>
                </div>
            </div>
            <div class="show-header-logo">
                <h1><a href="http://www.mofang.com/" target="_blank">魔方网主站</a></h1>
            </div>
            <div class="show-header-menu">
                <ul>
                    <li><a href="http://i.mofang.com/" target="_blank">苹果游戏</a></li>
                    <li><a href="http://a.mofang.com/" target="_blank">安卓游戏</a></li>
                    <li><a href="http://fahao.mofang.com/" target="_blank">发号中心</a></li>
                    <li><a href="http://bbs.mofang.com/" target="_blank">魔方论坛</a></li>
                    <li><a href="http://www.mofang.com/sitemap.html" target="_blank">站点地图</a></li>
                </ul>
            </div>
            {* <div class="show-header-user dis" id="header-user-login">
                <span style="display:none;" id="header-user-info">
                    <img src="/statics/v4/common/img/user_icon.png" alt="" />
                    <a href="" class="show-header-user-name" id="logined" target="_blank"></a>
                    <b class="user-line">|</b>
                    <a href="javascript:void(0)" id="logout">退出</a>
                </span>
                    <img src="/statics/v4/common/img/v_user_no.png" alt="" />
                    <a href="javascript:void(0)" class="" id="login">登录</a>
                    <b class="user-line">|</b>
                    <a id="reg" href="javascript:void(0)">注册</a>
                </span>
            </div> *}
        </div>
        {block name=header_submenu}
        {/block}
    </div>

    {* 主体区域 *}
    {block name=main}

    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}
        <div class="show-footer">
            <div class="footer-bd clearfix">
                <div class="footer-bd-log">
                    <img src="http://sts0.mofang.com/statics/images/mofang_v2/footer_logo_v4_b2624e1.png" alt="魔方网">
                </div>
                <div class="footer-bd-copy">
                    <ul class="clearfix">
                        <li><a href="http://www.mofang.com/about/index" target="_blank">关于我们</a><b class="ui-line">|</b></li>
                        <li><a href="http://www.mofang.com/about/join" target="_blank">诚聘英才</a><b class="ui-line">|</b></li>
                        <li><a href="http://www.mofang.com/about/contact" target="_blank">联系我们</a><b class="ui-line">|</b></li>
                        <li><a href="http://www.mofang.com/about/law" target="_blank">服务条款</a><b class="ui-line">|</b></li>
                        <li><a href="http://www.mofang.com/about/protect" target="_blank">权利保护</a></li>
                    </ul>
                    <p>© 2015 魔方网 MOFANG.COM 皖B2-20150012-1</p>
                </div>
            </div>
        </div>
        <!--Footer End-->
        {require name="common:statics/js/video-head.js"}
        {script}
            seajs.use(['common/head_video']);
        {/script}

    {/block}

{/block}
