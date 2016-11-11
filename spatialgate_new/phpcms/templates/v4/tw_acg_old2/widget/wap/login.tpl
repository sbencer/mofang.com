<div class="page">
    <div class="zq_header">
    	<a href="#2" class="icon-menu"></a>
    	<a href="#2" class="up curr">登入</a>
    	<a href="#2" class="in curr">注册</a>
    	<span class="icon-search"></span>
    </div>
    <div class="enter-con">
    		<h2>次元入口</h2>
    		<p>歡迎來到虛與實的角落～</p>
    </div>
    <div class="login-form show">
        <form id="loginForm" name="loginForm" method="post" action="" autocomplete="off" novalidate="novalidate">
            <div class="line">
                <div class="err"></div>
                <div class="ra">
                	<span class="uc-username-icon">用戶名:</span>
                	<input type="text" class="input" placeholder="請輸入用户名" id="username" name="username">
            	</div>
            </div>
            <div class="ras">
                <span class="uc-password-icon">密碼:</span>
                <input type="password" class="input" placeholder="請輸入密碼" id="password" name="password">
                <s class="eye eye-close"></s>
            </div>
           {* <!-- show hide -->
            <div class="line code-show-hide hide clearfix">
                <div class="err"></div>
                <input type="text" class="input code vcode" placeholder="请输入验证码" id="vcode" name="vcode">
                <span class="code-img"><img src="http://u.mofang.com/captcha/captcha" alt=""></span>
            </div>
            <div class="line line-rmb clearfix">
                <p class="rmb l"><span class="reme remend"></span>记住我</p>
                <p class="forget r"><a href="/home/forgetpassword/index">忘记密码</a></p>
            </div>
            *}
            <div class="line line-btn">
                <input type="submit" class="btn" value="登入">
            </div>
        </form>
    </div>
    <div class="line line-tab clearfix">
        <p class="forget fl"><a href="javascript:;" class="m-tab" data-side="账号登录">注册</a></p>
        <p class="forget fr"><a href="#2">忘記密碼?</a></p>
    </div>
    <div class="onekey-login">
    	<h4>
    		<span>一鍵登錄</span>
    	</h4>
    </div>
    <div class="onekey-login-list">
    	<a href="#2" class="fb"><p>Face book</p></a>
    	<a href="#2" class="link"><p>LINE</p></a>
    </div>
</div>

{require name="tw_acg:statics/wap/css/login.css"}
{require name="tw_acg:statics/wap/css/common.css"}