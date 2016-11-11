 {* 快速登录框 *}
<div class="register_box" style="display:none">
  <a class="close" target="_blank" title="关闭"></a>

  <div class="infobox" id="fmBox">
      <div class="register_tab">
          <ul>
              <li class="current">{t}快速登录{/t}</li>
              <li>{t}快速注册{/t}</li>
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
            <div class="login"><label class="input_tips">{t}用户名/邮箱{/t}</label><span class="img01"></span><input id="accountLogin" type="text" value=""></div>
            <div class="password"><label class="input_tips">{t}输入密码{/t}</label><span class="img02"></span><input id="passwordLogin" type="password"></div>
            <div class="validate validate1"><input class="W_input" type="text" maxlength="6" id="verifyCodeLogin" placeholder="" value=""><span class="validatecode_img"><img id="vcode_img_login" src="http://u.mofang.com/captcha/captcha"></span></div>
            <div class=" forget_password"><input id="rememberLogin2" class="W_checkbox" type="checkbox" checked="checked">{t}记住密码{/t}</div>
            <div class="dl_btn dl_btn1"><a class="Login_btn" id="submitLogin2" target="_self" href="javascript:void(0);" action-type="btn_submit"><span>{t}登录{/t}</span></a></div><br>
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
            <li><label class="input_tips">{t}输入邮箱{/t}</label><span class="mail">{t}邮箱{/t}</span>&nbsp;<input id="userMailReg" type="text" value=""></li>
            <li><label class="input_tips">{t}输入密码{/t}</label><span class="passwd">密码{/t}</span>&nbsp;<input id="userPasswordReg" type="password" value=""></li>
            <li><label class="input_tips">{t}再次输入密码{/t}</label><span class="agin">{t}再次输入{/t}&nbsp;</span><input id="repeatPasswordReg" type="password" value=""></li>
            <li><label class="input_tips">{t}输入昵称{/t}</label><span class="name_ios">{t}昵称{/t}</span>&nbsp;<input id="userNameReg" type="text" value=""></li>
          </ul>
          <div class="validate"><span class="yanzheng">{t}验证码{/t}</span><input class="W_input" type="text" maxlength="6" id="verifyCodeReg" value="" placeholder=""><span class="validatecode_img"><img id="vcode_img_reg" src="http://u.mofang.com/captcha/captcha"></span></div>
          <div class="dl_btn"><a class="Login_btn" target="_self" href="javascript:void(0);" id="submitReg"><span>{t}立即注册{/t}</span></a></div><br>
        </div>
      </div>

  </div>
  <div class="cooperate">
      <div class="weibobox">
          {t}快速登录{/t}：
          <a class="weibo01" id="sinaweibo" target="_top" href="http://u.mofang.com/account/weibo">{t}新浪微博{/t}</a>
          <a class="weibo02" id="qq" href="http://u.mofang.com/account/qq">QQ</a>
      </div>
      {* <div class="help">
          <a class="font04" href="#" target="_blank">{t}忘记密码{/t}？</a>|
          <a href="#" target="_blank" class="font05"> {t}帮助中心{/t}</a>
      </div> *}
  </div>
</div>

{if $siteid == 2}
  {require name="common:statics/css/login_en.css"}
  {require name="common:statics/js/login_check_en.js"}
  {script}
    seajs.use(["login_en/check"]);
  {/script}
{else}
  {require name="common:statics/css/login_jp.css"}
  {require name="common:statics/js/login_check_jp.js"}
  {script}
    seajs.use(["login_jp/check"]);
  {/script}
{/if}

