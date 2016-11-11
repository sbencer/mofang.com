{*

    **************************************************
    *  V4主站顶部信息
    **************************************************
*}
{require name="common:statics/css/sub-header.css"}
<div class="show-header-wrap">
    <div class="show-header">
        <div class="show-header-app J_hover_app">
            <div class="ty_sy"><a href="http://app.mofang.com">手游助手APP</a><i class="show-down-icon"></i></div>
            <div class="show-header-app-down J_app_down">
                <ul>
                    <script type="text/javascript" src="http://www.mofang.com/index.php?m=mofangapp&c=index&a=dom_list&app=yxb"></script>
                </ul>
            </div>
        </div>
        <div class="show-header-logo">
            <div class="my_index"><a href="{get_category_url('www')}" target="_blank">魔方网主站</a></div>
        </div>
        <div class="show-header-menu">
            <ul class="top-menu-bar">
                <li class="top-menu-box">
                <a href="javascript:void(0);" onclick="return false;" target="_blank">资讯</a>
                    <div class="top-meun-list">
                        <a href="http://www.mofang.com/xinyou/" target="_blank">新闻</a>
                        <a href="http://www.mofang.com/pandian/" target="_blank">盘点</a>
                        <a href="http://www.mofang.com/bagua/" target="_blank">八卦</a>
                        <a href="http://www.mofang.com/gonglue/" target="_blank">攻略</a>
                        <a href="http://c.mofang.com" target="_blank">产业</a>
                        {*<a href="{cat_url(1020)}" target="_blank">厂商</a>
                        <a href="{cat_url(1021,1)}" target="_blank">硬件</a>*}
                        <a href="{cat_url(1022,1)}" target="_blank">问答</a>
                        {*<a href="{cat_url(1029)}" target="_blank">图片</a>
                        <a href="{cat_url(1039)}" target="_blank">专题</a>*}
                    </div>
                </li>
                <li><a href="http://game.mofang.com/" target="_blank">找游戏</a></li>
                <li><a href="http://v.mofang.com" target="_blank">视频</a></li>
                <li><a href="{get_category_url('fahao')}" target="_blank">发号</a></li>
                {if isset($smarty.get.p)}
                <li class="top-menu-box j_hover_menu">
                    <a href="javascript:void()" target="_blank">专区</a>
                    <div class="top-menu-wrap j_hover_menu clearfix">
                    </div>
                </li>
                {/if}
                <li><a href="{get_category_url('bbs')}" target="_blank">论坛</a></li>
            </ul>
        </div>
        <div class="show-header-search">
            <form class="headerForm">
            <input class="show-header-search-text" type="text" name="q-header" autocomplete="off" placeholder="请输入搜索内容">
            <input class="show-header-search-btn" type="submit" id="search-header" value=""></input>
            </form>:
        </div>

        <div class="show-header-user" id="header-user-login">
            {* 登录 *}
            <span class="loginout" style="display:none;" id="header-user-info">
                <img src="/statics/v4/common/img/user_icon.png" />
                <a href="{get_category_url('user')}" class="show-header-user-name" id="logined" target="_blank"></a>
                <b class="user-line">|</b>
                <a href="javascript:void(0)" id="logout">退出</a>
            </span>
            {* 未登录 *}
            <span class="loginout" id="header-user-nologin">
                <img src="/statics/v4/common/img/v_user_no.png" />
                <a href="javascript:void(0)" class="" id="login">登录</a>
                <b class="user-line">|</b>
                <a id="reg" href="javascript:void(0)">注册</a>
            </span>
            
        </div>
    </div>
</div>
<div id="tableList"></div>

{require name="common:statics/js/head_hover.js"}
{require name='common:statics/js/top_json.js'}
{require name='content:statics/js/search.js'}

{script}
    setTimeout(function(){
        seajs.use(['common/header_hover','login/check']);
    },1000)
{/script}
