<div class="show-header-wrap">
    <div class="show-header">
	<div class="show-header-app J_hover_app">
	    <h2 class=""><a href="">手游助手APP</a><i class="show-down-icon"></i></h2>
	    <div class="show-header-app-down J_app_down">
            <ul>
                <script type="text/javascript" src="http://www.mofang.com/index.php?m=mofangapp&c=index&a=dom_list&app=yxb"></script>
            </ul>
	    </div>
	</div>
	<div class="show-header-logo">
	    <h1><a href="#get_category_url('www')" target="_blank">魔方网主站</a></h1>
	</div>
	<div class="show-header-menu">
	    <ul>
		<li><a href="#get_category_url('ios')" target="_blank">苹果游戏</a></li>
		<li><a href="#get_category_url('android')" target="_blank">安卓游戏</a></li>
		<li><a href="#get_category_url('fahao')" target="_blank">发号中心</a></li>
		<li><a href="#get_category_url('bbs')" target="_blank">魔方论坛</a></li>
		<li><a href="http://www.mofang.com/sitemap.html" target="_blank">站点地图</a></li>
	    </ul>
	</div>
	<div class="show-header-user" id="header-user-login">
	    <!-- 登录 -->
	    <span style="display:none;" id="header-user-info">
		<img style="height:20px;width:20px; border-radius: 50%;vertical-align: middle; margin-right: 4px;" src="/statics/v4/common/img/user_icon.png" alt="" />
		<a href="#get_category_url('user')" class="show-header-user-name" id="logined" target="_blank"></a>
		<b class="user-line">|</b>
		<a href="javascript:void(0)" id="logout">退出</a>
	    </span>
	    <!-- 未登录 -->
	    <span class="loginout" id="header-user-nologin">
		<img src="/statics/v4/common/img/v_user_no.png" alt="" />
		<a href="javascript:void(0)" class="" id="login">登录</a>
		<b class="user-line">|</b>
		<a id="reg" href="javascript:void(0)">注册</a>
	    </span>
	    {* 快速登录框 *}
	    <div class="register_box" style="display:none">
	      <a class="close" target="_blank" title="关闭"></a>
	      <div class="infobox" id="fmBox">
		  <div class="register_tab">
		      <ul>
			  <li class="current">快速登录</li>
			  <li>快速注册</li>
		      </ul>
		  </div>

		  <!-- 登陆 -->
		  <div class="register_cont" id="login-cont">
		    <div class="before">
		      <div class="prompt" id="loginMsgBox" style="display:none">
			<a class="prompt_close" target="_self" href="javascript:void(0)"></a>
			<p></p>
		      </div>
		      <form>
			<div class="login"><label class="input_tips">用户名/邮箱</label><span class="img01"></span><input id="accountLogin" type="text" value=""></div>
			<div class="password"><label class="input_tips">输入密码</label><span class="img02"></span><input id="passwordLogin" type="password"></div>
			<div class="validate validate1"><input class="W_input" type="text" maxlength="6" id="verifyCodeLogin" placeholder="" value=""><span class="validatecode_img"><img id="vcode_img_login" src="http://u.mofang.com/captcha/captcha"></span></div>
			<div class=" forget_password"><input id="rememberLogin2" class="W_checkbox" type="checkbox" checked="checked">记住密码</div>
			<div class="dl_btn dl_btn1"><a class="Login_btn" id="submitLogin2" target="_self" href="javascript:void(0);" action-type="btn_submit"><span>登录</span></a></div><br>
		      </form>
		    </div>
		  </div>
		  <!-- 注册 -->
		  <div class="register_cont" style="display:none" id="register-cont">
		    <div class="prompt promptfalse" id="regMsgBox" style="display:none">
		      <a class="prompt_close" target="_self" href="javascript:void(0)"></a>
		      <p></p>
		    </div>
		    <div class="reginfo">
		      <ul>
			<li><label class="input_tips">输入邮箱</label><span class="mail">邮箱</span>&nbsp;<input id="userMailReg" type="text" value=""></li>
			<li><label class="input_tips">输入密码</label><span class="passwd">密码</span>&nbsp;<input id="userPasswordReg" type="password" value=""></li>
			<li><label class="input_tips">再次输入密码</label><span class="agin">再次输入&nbsp;</span><input id="repeatPasswordReg" type="password" value=""></li>
			<li><label class="input_tips">输入昵称</label><span class="name_ios">昵称</span>&nbsp;<input id="userNameReg" type="text" value=""></li>
		      </ul>
		      <div class="validate"><span class="yanzheng">验证码</span><input class="W_input" type="text" maxlength="6" id="verifyCodeReg" value="" placeholder=""><span class="validatecode_img"><img id="vcode_img_reg" src="http://u.mofang.com/captcha/captcha"></span></div>
		      <div class="dl_btn"><a class="Login_btn" target="_self" href="javascript:void(0);" id="submitReg"><span>立即注册</span></a></div><br>
		    </div>
		  </div>

	      </div>
	      <div class="cooperate">
		  <div class="weibobox">
		      快速登录：
		      <a class="weibo01" id="sinaweibo" target="_top" href="http://u.mofang.com/account/weibo">新浪微博</a>
		      <a class="weibo02" id="qq" href="http://u.mofang.com/account/qq">QQ</a>
		  </div>
		  {* <div class="help">
		      <a class="font04" href="#" target="_blank">忘记密码？</a>|
		      <a href="#" target="_blank" class="font05"> 帮助中心</a>
		  </div> *}
	      </div>
	    </div>
	</div>
    </div>
</div>
{require name="common:statics/js/video-head.js"}
{script}
    setTimeout(function(){
	seajs.use(['common/head_video','login/check']);
    },1000)
{/script}
