  {* 右侧 *}
  <div class="header-login">
      {*
          <span class="header-login-user">
              <a href="">登录</a><b class="ui-line"> | 
              </b><a href="">注册</a>
          </span>
      *}
      {* 登陆之后的状态 *}
      <span class="header-login-user header-login-user login-after" id="header-user-info" style="display:none">
          <a target="_self" href="http://u.mofang.com/" id="logined"></a>
          <b class="ui-line"> | </b>
          <a href="javascript:void(0)" id="logout">退出</a>
      </span>

      {* 登陆之前 *}
      <span class="header-login-user login-before" id="header-user-nologin">
          <a target="_self" href="javascript:void(0)" id="login">登录</a>
          <b class="ui-line"> | </b>
          <a target="_self" href="javascript:void(0)" id="reg">注册</a>
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
                    <div class="password"><label class="input_tips">输入密码</label><span class="img02"></span><input id="passwordLogin" type="password"</div>
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

      {* 关注、订阅按钮 *}
      <span>
        <a class="icon icon-weibo" href="http://weibo.com/cubegame" target="_blank">关注</a>
        <a class="icon icon-weixin" id="index_weixin" href="javascript:void(0)">订阅</a>

          {* 微信扫一扫对话框 *}
          <div class="dialog_weixin" id="dialog_weixin" style="display:none;">
              <div class="weixn_top">
                  <span class="fl">微信一扫就关注</span>
                  <a href="javascript:;" class="fr" id="fr1" target="_self">
                      <img src="/statics/v4/common/img/img12.gif"/>
                  </a>
              </div>
              <div class="weixin_middle">
                  <div class="weixin_topic">
                      <span><img src="/statics/v4/common/img/img11.jpg"></span>
                      <ul>
                          <li>游戏新闻抢先看</li>
                          <li>即时搜攻略，通关无难事</li>
                      </ul>
                  </div>
                  <p>
                      扫描方法： <br/>
                      打开微信->点击右上角魔术棒->扫一扫->将摄像头对准左侧二维码
                  </p>
            </div>
          </div>

      </span>

      {* 魔方产品按钮 *}
      <span>
          <a class="icon mf-icon" href="http://www.mofang.com/appdownload/277-1.html" target="_blank">魔方产品</a>
      </span>

      {* 全站导航 *}
      <span class="header-login-nav">
          <a class="map-site" href="">全站导航</a><b class="ui-tring"></b>
          <div class="map-box">
              {block name=site_nav_content}
              {*
                  主站phpcms ，和新版yii数据不统一
              *}
              {/block}
          </div>
      </span>
      {* 全站导航结束 *}
  </div>
