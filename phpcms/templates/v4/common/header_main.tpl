{* 头部header start *}
{require name="feed:statics/css/header-wrap.css"}
<div class="header-wrap J_navbar">
    <div class="header-content clearfix">
        <h1 class="header-logo">
            <a href="/">魔方网</a>
        </h1>
        <ul class="header-info-wrap clearfix">
            <li><a class="header-icon app-icon"  href=""></a></li>
            <li><a class="header-icon and-icon"  href=""></a></li>
            <li><a class="header-icon zhus-icon"  href=""></a></li>
        </ul>
        <div class="header-search">
            <form action="">
                <input class="header-search-text" type="text" placeholder="请输入搜索内容" />
                <button class="header-search-btn" type="submit"></button>
            </form>
            </div>
            <div class="header-user J_user">
                {* 登录 *}
                <h3 class="header-user-info" id="header-user-info">
                    <a href="http://u.mofang.com" target="_blank">
                        <span class="user-info-name"><i class="icon-down"></i></span>
                    </a>
                    <span class="user-line">|</span>
                    <a class="header-loginout header-loginout-icon" id="logout" href="">退出</a>
                </h3>
                {* 未登录 *}
                <h3 class="header-user-nologin" style="display:none;" id="header-user-nologin">
                    <span>
                        <a href="javascript:void(0)" id="login">登录</a>
                        <span class="user-line">|</span>
                        <a href="javascript:void(0)" id="reg">注册</a>
                    </span>
                </h3>
                {include file='content/login.tpl'}
                {* <div class="header-user-panel J_user_panel">
                    <ul class="header-user-panel-list">
                        <li class="header-mo-icon">魔币：<span class="header-user-num">100</span></li>
                        <li class="header-zuan-icon">魔钻：<span class="header-user-num">2000</span>span></li>
                    </ul>
                    <a class="header-loginout header-loginout-icon" id="logout" href="">退出</a>
                </div> *}
            </div>
    </div>
</div>
{* 头部header end *}
