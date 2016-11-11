{* 工具条样式 *}
{require name="common:statics/css/v5/show-header.css"}
{require name="common:statics/css/zh_cn/login.css"}

{* 鼠标划过手游APP按钮 *}
{require name="common:statics/js/v5/video_head.js"}
{* 导航条搜索功能 *}
{require name="common:statics/js/v5/search.js"}
{* 专区导航菜单 *}
{require name='common:statics/js/top_json.js'}

<div class="show-header-wrap">
    <div class="show-header clearfix">

        {* 手游助手APP *}
        <div class="show-header-app J_hover_app">
            <h2 class=""><a href="http://app.mofang.com">手游助手APP</a><i class="show-down-icon"></i></h2>
            <div class="show-header-app-down J_app_down">
                <ul>
                    <script type="text/javascript" src="http://www.mofang.com/index.php?m=mofangapp&c=index&a=dom_list&app=yxb"></script>
                </ul>
            </div>
        </div>

        {* logo *}
        <div class="show-header-logo">
            <h1><a href="http://www.mofang.com" target="_blank">魔方网主站</a></h1>
        </div>

        {* 导航菜单 *}
        <div class="show-header-menu">
            <ul class="top-menu-bar">

                {* 资讯 *}
                <li class="top-menu-box">
                    <a href="javascript:void(0);" onclick="return false;" target="_blank">资讯</a>
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
            <form class="headerForm">
            <input class="show-header-search-text" type="text"name="q-header" autocomplete="off" placeholder="请输入搜索内容" />
            <input class="show-header-search-btn" type="submit" id="search-header" value=""/>
            </form>
        </div>


        {* 用户信息/登陆注册 *}
        {block name="user-login"}
        <div class="show-header-user" id="header-user-login">

            {* 登录 *}
            <span style="display:none;" id="header-user-info">
                <img src="/statics/v4/common/img/v5/video/user_icon.png" alt="" />
                <a href="#" class="show-header-user-name" id="logined" target="_blank"></a>
                <b class="user-line">|</b>
                <a href="javascript:void(0);" id="logout">退出</a>
            </span>

            {* 未登录 *}
            <span class="loginout" id="header-user-nologin" style="display:none;">
                <img src="/statics/v4/common/img/v5/video/v_user_no.png" alt="" />
                <a href="javascript:void(0);" class="" id="login">登录</a>
                <b class="user-line">|</b>
                <a id="reg" href="javascript:void(0)">注册</a>
            </span>
            {script}
                seajs.use("login/check")
            {/script}

            {*{include file='common/v5/login.tpl'}*}
        </div>
        {/block}
    </div>
</div>
