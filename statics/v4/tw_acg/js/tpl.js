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

    var tpl = '<div class="register_box" style="display:none">'+
                  '<a class="close" target="_blank" title="关闭"></a>'+
                  '<div class="infobox" id="fmBox">'+
                      '<div class="acg_login_title">'+
                          '<h2>次元角落</h2>'+
                          '<span>～在虛與實之中尋找感動～</span>'+
                      '</div>'+
                      '<div class="register_cont" id="login-cont">'+
                       '<div class="before">'+
                          '<div class="prompt" id="loginMsgBox" style="display:none">'+
                            '<a class="prompt_close" target="_self" href="javascript:void(0)"></a>'+
                            '<p></p>'+
                          '</div>' +
                          '<form>' +
                           ' <div class="login"><label class="input_tips">'+i18n.login.user+'</label><span class="img01"></span><input id="accountLogin" type="text" value=""></div>'+
                           ' <div class="password"><label class="input_tips">'+i18n.login.pass+'</label><span class="img02"></span><input id="passwordLogin" type="password"></div>'+
                           ' <div class="validate validate1"><input class="W_input" type="text" maxlength="6" id="verifyCodeLogin" placeholder="請輸入驗證碼" value=""><span class="validatecode_img"><img id="vcode_img_login" src="'+defaultURL+'/captcha/captcha"></span></div>'+
                           ' <div class=" forget_password"><input id="rememberLogin2" class="W_checkbox" type="checkbox" checked="checked">'+i18n.login.savePass+'</div>'+
                           ' <div class="dl_btn dl_btn1"><a class="Login_btn" id="submitLogin2" target="_self" href="javascript:void(0);" action-type="btn_submit"><span>'+i18n.login.loginEnter+'</span></a></div><br>'+
                           ' <div class="row_reg"><p class="fr"><span> 還沒有成為會員？｜</span><a class="tab_reg" href="javascript:;">前往註冊</a></p></div>'+ 
                          '</form>'+
                        '</div>'+
                      '</div>'+
                      '<div class="register_cont" style="display:none" id="register-cont">'+
                        '<div class="prompt promptfalse" id="regMsgBox" style="display:none">'+
                          '<a class="prompt_close" target="_self" href="javascript:void(0)"></a>'+
                          '<p></p>'+
                        '</div>'+
                        '<div class="reginfo">'+
                          '<ul>'+
                            '<li><label class="input_tips">'+i18n.register.email+'</label><span class="mail img01">'+i18n.register.registerItem[0]+'</span>&nbsp;<input id="userMailReg" type="text" value=""></li>'+
                            '<li><label class="input_tips">'+i18n.register.pass+'</label><span class="passwd img02">'+i18n.register.registerItem[1]+'</span>&nbsp;<input id="userPasswordReg" type="password" value=""></li>'+
                            '<li><label class="input_tips">'+i18n.register.oncePass+'</label><span class="agin img02">'+i18n.register.registerItem[2]+'&nbsp;</span><input id="repeatPasswordReg" type="password" value=""></li>'+
                            '<li><label class="input_tips">'+i18n.register.niceName+'</label><span class="name_ios img01">'+i18n.register.registerItem[3]+'</span>&nbsp;<input id="userNameReg" type="text" value=""></li>'+
                          '</ul>'+
                          '<div class="validate"><input class="W_input" type="text" maxlength="6" id="verifyCodeReg" value="" placeholder="請輸入驗證碼"><span class="validatecode_img"><img id="vcode_img_reg" src="'+defaultURL+'/captcha/captcha"></span></div>'+
                          '<div class="dl_btn"><a class="Login_btn" target="_self" href="javascript:void(0);" id="submitReg"><span>'+i18n.register.registerEnter+'</span></a></div><br>'+
                          ' <div class="row_reg"><p class="fr"><span>已經是會員了？｜ </span><a class="tab_login" href="javascript:;">前往登入</a></p></div>'+ 
                        '</div>'+
                      '</div>'+

                  '</div>'+
                  '<div class="acg_cooperate">'+
                      '<div class="third-party">'+ 
                      '<h4><span>第三方合作登錄</span></h4>'+
                      '</div>'+
                      '<div class="line third-party-list">'+
                          '<a class="uc-facebook-icon" href="/account/facebook">Facebook</a>'+
                      '</div>'+
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
