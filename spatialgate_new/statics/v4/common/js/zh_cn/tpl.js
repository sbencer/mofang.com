/**
 * @return Object
 * @gahao 1/21 添加海外站分享
 */
define('tpl',['language'], function(require, exports, module) {
    /*
     * lang_conf 和 defaultURL 需要php渲染
     * 如果不渲染则走中文配置。
     */
    var language = require("language");
    var lang_conf =  window.lang_conf || "ZH";
    var defaultURL =  window.defaultURL || "http://u.mofang.com";

    var i18n = language[lang_conf];
    var hwShare = '<div class="hw-share">'+i18n.header.login+'：'+
                      '<a class="fb-share" id="fb" target="_top" href="'+defaultURL+'/account/facebook">'+i18n.otherLogin.fb+'</a>'+
                      '<a class="gg-share" id="gg" target="_top" href="'+defaultURL+'/account/google">'+i18n.otherLogin.gg+'</a>'+
                      '<a class="tt-share" id="tt" target="_top" href="'+defaultURL+'/account/twitter">'+i18n.otherLogin.tt+'</a>'+
                  '</div>';

    var zhShare = '<div class="weibobox"> '+i18n.header.login+'：'+
                      '<a class="weibo01" id="sinaweibo" target="_top" href="'+defaultURL+'/account/weibo">'+i18n.otherLogin.weibo+'</a>'+
                      '<a class="weibo02" id="qq" href="'+defaultURL+'/account/qq">'+i18n.otherLogin.qq+'</a>'+
                  '</div>';

    var shareTpl = {
      'TW':hwShare,
      'JP':hwShare,
      'EN':hwShare,
      'ZH':zhShare
    };

    var zhForgotPassUrl = 'http://u.mofang.com/home/forgetpassword/index';//简中找回密码url

    var forgotPassUrl = {
        'ZH':zhForgotPassUrl
    } 

    var tpl = '<div class="register_box login-wrap">'+
                    '<a class="close" target="_blank" title="关闭"></a>'+
                    '<div class="infobox" id="fmBox">'+
                        '<div class="register_tab">'+
                            '<ul>'+
                                '<li class="current">'+i18n.header.login+'</li>'+
                                '<li>'+i18n.header.register+'</li>'+
                            '</ul>'+
                        '</div>'+

                        '<div class="register_cont" id="CLoginCont">'+
                        '   <div class="prompt" id="loginMsgBox" style="display:none">'+
                            '   <a class="prompt_close" target="_self" href="javascript:void(0)"></a>'+
                            '   <p></p>'+
                            '</div>' +
                            '<div class="uc-box-bd" >'+
                                '<ul class="uc-login" id="login-cont">'+
                                    '<li>'+
                                        '<div class="login-item">'+
                                            '<label for=""></label>'+
                                            '<div class="login-icon user-icon"></div>'+
                                            '<input class="logintext loginname" name="loginname" id="CLoginUser" type="text" placeholder="'+ i18n.login.user+'">'+
                                            '<span class="username_err"></span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li>'+
                                        '<div class="login-item">'+
                                            '<label for=""></label>'+
                                            '<div class="login-icon pwd-icon"></div>'+
                                            '<div class="pwd-change"></div>'+
                                            '<input class="logintext loginpwd " name="loginpwd" id="CPasswordLogin" type="password" placeholder="'+ i18n.login.pass+'">'+
                                            '<span class="password_err"></span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li class="special-item">'+
                                        '<div class="login-item">'+
                                            '<label for=""></label>'+
                                            '<input class="logintext logincode" name="logincode" type="text" id="CVerifyCodeLogin" placeholder="'+ i18n.login.secCode+'" flag="false">'+
                                            '<div class="code-img">'+
                                                '<img id="vcode_img_login" src="'+defaultURL+'/captcha/captcha">'+
                                            '</div>'+
                                            '<span class="verifycode_err"></span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li>'+
                                        '<div class="login-item clearfix">'+
                                            '<span>'+
                                                '<input id="CAutoLogin" name="rememberMe" type="checkbox" class="MFcheckbox" tabindex="3">'+
                                            '<label for="">'+ i18n.login.savePass+'</label>'+
                                            '</span>'+
                                            '<span class="back-pwd" style="float: right;">'+
                                                '<a href="'+forgotPassUrl[lang_conf]+'" target="_blank">'+i18n.login.forgotPass+'</a>'+
                                            '</span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li class="special-item">'+
                                        '<div class="login-item">'+
                                            '<input class="loginbtn" name="loginbtn" id="CSubmitLogin" type="submit" value="'+ i18n.login.loginEnter+'">'+
                                        '</div>'+
                                    '</li>'+
                                    '<li>'+
                                        '<div class="login-item clearfix">'+
                                            '<a class="old-user" href="javascript:void(0)" target="_black">'+ i18n.login.usernameLogin+'<b>&gt;&gt;</b></a>'+
                                        '</div>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                        '<div class ="register_cont" style="display:none" id="CRegisterCont">'+//注册
                            '<div class="prompt promptfalse" id="regMsgBox" style="display:none">'+
                                '<a class="prompt_close" target="_self" href="javascript:void(0)"></a>'+
                                '<p></p>'+
                            '</div>'+
                            '<div class="uc-box-bd" >'+
                                '<ul class="uc-login">'+
                                    '<li>'+
                                        '<div class="login-item">'+
                                            '<label for=""></label>'+
                                            '<div class="login-icon user-icon"></div>'+
                                            '<input class="logintext loginname" name="loginname" id="CRegUser" type="text" placeholder="'+ i18n.login.user+'">'+
                                            '<span class="username_err"></span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li>'+
                                        '<div class="login-item">'+
                                            '<label for=""></label>'+
                                            '<div class="login-icon pwd-icon"></div>'+
                                            '<div class="pwd-change"></div>'+
                                            '<input class="logintext loginpwd " name="loginpwd" id="CPasswordReg" type="password" placeholder="'+ i18n.login.pass+'">'+
                                            '<span class="password_err"></span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li class="special-item">'+
                                        '<div class="login-item">'+
                                            '<label for=""></label>'+
                                            '<input class="logintext logincode" name="logincode" type="text" id="CVerifyCodeReg" placeholder="'+ i18n.login.secCode+'" flag="false">'+

                                            '<div class="code-img">'+
                                                '<img id="vcode_img_reg" src="'+defaultURL+'/captcha/captcha">'+
                                            '</div>'+
                                            '<span class="verifycode_err"></span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li class="special-item phone" style="display:none">'+
                                        '<div class="login-item">'+
                                            '<label for=""></label>'+
                                            '<input class="logintext logincode" name="logincode" type="text" id="CPhoneCodeReg" placeholder="'+ i18n.login.secPhoneCode+'" flag="false">'+

                                            '<div class="code-img">'+
                                                '<span class="">'+i18n.register.phoneCode+'</span>'+
                                            '</div>'+
                                            '<span class="verifycode_err"></span>'+
                                        '</div>'+
                                    '</li>'+
                                    '<li class="special-item">'+
                                        '<div class="login-item">'+
                                            '<input class="loginbtn" name="loginbtn" id="CSubmitReg" type="submit" value="'+ i18n.register.registerEnter+'">'+
                                        '</div>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="cooperate">'+
                        shareTpl[lang_conf]+
                    '</div>'+
                '</div>';

    if (typeof module != "undefined" && module.exports) {
        /**
         * description
         *  @param {type} name description
         *  @param {type} name description
         *  @return {type} description
         */
        module.exports = {
            tpl : tpl,
            i18n : i18n
        };
    }
});
