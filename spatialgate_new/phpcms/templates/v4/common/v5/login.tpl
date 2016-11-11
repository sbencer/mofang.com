{require name="common:statics/css/v5/login.css"}
<div class="register_box" style="display:none">
    <a class="close" target="_blank" title="关闭"></a>
    <div class="infobox" id="fmBox">
        <div class="register_tab">
          <ul>
            <li class="current">快速登录</li>
            <li>快速注册</li>
          </ul>
        </div>
        <div class="register_cont" id="login-cont">
          <div class="before">
            <div class="prompt" id="loginMsgBox" style="display:none">
              <a class="prompt_close" target="_self" href="javascript:void(0)"></a>
              <p></p>
            </div>
            <form>
              <div class="login"><label class="input_tips">用户名/邮箱</label><span class="img01"></span><input id="accountLogin" type="text" value=""></div>
              <div class="password"><label class="input_tips">输入密码</label><span class="img02"></span><input id="passwordLogin" type="password" value=""></div>
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
              <li><label class="input_tips">再次输入密码</label><span class="agin">再次输入&nbsp;</span><input id="repeatPasswordReg" type="password" value="" ></li>
              <li><label class="input_tips">输入昵称</label><span class="name_ios">昵称</span>&nbsp;<input id="userNameReg" type="text" value=""></li>
            </ul>
            <div class="validate"><span class="yanzheng">验证码</span><input class="W_input" type="text" maxlength="6" id="verifyCodeReg" value="" placeholder=""><span class="validatecode_img"><img id="vcode_img_reg" src="http://u.mofang.com/captcha/captcha"></span></div>
            <div class="dl_btn"><a class="Login_btn" target="_self" href="javascript:void(0);" id="submitReg"><span>立即注册</span></a></div><br>
          </div>
        </div>
    </div>
    <div class="cooperate">
        <div class="weibobox">快速登录：
            <a class="weibo01" id="sinaweibo" target="_top" href="http://u.mofang.com/account/weibo">新浪微博</a>
            <a class="weibo02" id="qq" href="http://u.mofang.com/account/qq">QQ</a>
        </div>
        {* <div class="help">
            <a class="font04" href="#" target="_blank">忘记密码？</a>|<a href="#" target="_blank" class="font05"> 帮助中心</a>
        </div> *}
    </div>
</div>
{script}
    seajs.use("login/check")
{/script}
