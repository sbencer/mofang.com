{* 用户信息/登陆注册 *}
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