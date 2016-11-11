{*
    **************************************************
    * 通用布局模板: 还未使用
    * 模块: content/product/show_base_yii.tpl
    * 模块: content/show_base.tpl
    *
    *  main              : 主体区域
    *  footer            : 页面底部
    *  statistical       : 统计代码
    *
    ***************************************************
*}

{extends file='common/base.tpl'}

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

{* 主体区域 *}
{block name=body}
    {$smarty.block.parent}
    {require name="content:statics/css/common-v4.css"}
    {require name="content:statics/css/tiplog.css"}

    {* show头部 *}
    {require name="content:statics/css/show-header.css"}
    {require name="content:statics/js/video_head.js"}
    {require name="content:statics/js/mfshare.js"}
    {require name='content:statics/js/search.js'}
    <div class="show-header-wrap">
        <div class="show-header clearfix">
            <div class="show-header-app J_hover_app">
                <h2 class=""><a href="http://app.mofang.com">手游助手APP</a><i class="show-down-icon"></i></h2>
                <div class="show-header-app-down J_app_down">
                    <ul>
                        <script type="text/javascript" src="http://www.mofang.com/index.php?m=mofangapp&c=index&a=dom_list&app=yxb"></script>
                    </ul>
                </div>
            </div>
            <div class="show-header-logo">
                <h1><a href="http://www.mofang.com" target="_blank">魔方网主站</a></h1>
            </div>

            {* 导航菜单 *}
            <div class="show-header-menu">
                <ul class="top-menu-bar">
                    {* 资讯 *}
                    <li class="top-menu-box">
                        <a href="javascript:void(0);" target="_blank">资讯</a>
                        <div class="top-meun-list">
                            <a href="http://www.mofang.com/news/1016-1.html" target="_blank">新闻</a>
                            <a href="http://www.mofang.com/pandian/1017-1.html" target="_blank">盘点</a>
                            <a href="http://www.mofang.com/bagua/1018-1.html" target="_blank">八卦</a>
                            <a href="http://www.mofang.com/gonglue/689-1.html" target="_blank">攻略</a>
                            <a href="http://c.mofang.com" target="_blank">产业</a>
                            <a href="http://www.mofang.com/wenda/1022-1.html" target="_blank">问答</a>
                        </div>
                    </li>

                    {* 找游戏 *}
                    <li><a href="http://game.mofang.com/" target="_blank">找游戏</a></li>
                    {* 视频 *}
                    <li><a href="http://v.mofang.com" target="_blank">视频</a></li>
                    {* 发号 *}
                    <li><a href="http://fahao.mofang.com" target="_blank">发号</a></li>
                    {* 互动 *}
                    <li><a href="http://bbs.mofang.com" target="_blank">论坛</a></li>
                </ul>
            </div>

            {* 搜索框 *}
            <div class="show-header-search">
                <input class="show-header-search-text" type="text"
                    name="q-header" autocomplete="off" placeholder="请输入搜索内容"
                    onkeydown="{literal}if(event.keyCode==13){search.click()}{/literal}" />
                <button class="show-header-search-btn" type="submit" id="search-header"></button>
            </div>

            {* 用户信息/登陆注册 *}
            <div class="show-header-user" id="header-user-login">

                {* 登录 *}
                <span style="display:none;" id="header-user-info">
                    <img src="../statics/img/video/user_icon.png" alt="" />
                    <a href="#" class="show-header-user-name" id="logined" target="_blank"></a>
                    <b class="user-line">|</b>
                    <a href="javascript:void(0);" id="logout">退出</a>
                </span>

                {* 未登录 *}
                <span class="loginout" id="header-user-nologin" style="display:none;">
                    <img src="../statics/img/video/v_user_no.png" alt="" />
                    <a href="javascript:void(0);" class="" id="login">登录</a>
                    <b class="user-line">|</b>
                    <a id="reg" href="javascript:void(0)">注册</a>
                </span>

                {include file='content/login.tpl'}
            </div>
        </div>
    </div>

    {* 主体区域 *}
    {block name=main}

    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}
        {require name="content:statics/css/show-footer.css"}
        <div class="show-footer">
        <div class="footer-bd grid-970 clearfix">
                    <div class="footer-bd-log">
                        <img src="../statics/img/video/footer_logo.png" alt="魔方网">
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

    {/block}

{/block}
