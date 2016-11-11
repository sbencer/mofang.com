// 魔方网注册和登陆
var MFLogin1 = MFLogin1 || {};

MFLogin1 = {

    // 各焦点
    objName : {
        "usernameReg"    : $("#usernameReg1"),     // 登陆用户名
        "emailReg"   : $("#emailReg1"),    // 密码
        "faceReg" : $("#faceReg1"),  // 验证码
        "applyTermReg" : $("#applyTermReg1"),  // 验证码
        "submitReg"   : $("#submitReg1"),    // 记住密码
        "usernameLogin"     : $("#usernameLogin1"),      // 注册用户名
        "passwordLogin"     : $("#passwordLogin1"),      // 邮箱
        "faceLogin"     : $("#faceLogin1"),      // 邮箱
        "submitLogin"     : $("#submitLogin1"),      // 登陆按钮
        "msgBox"          : $("#msgBox1"),      // 登录提示窗口
    },

    regStr: {
        usReg  : /^[A-Z0-9._%+-]{5,20}$/i,        // 用户名6-32位字母和数字，以字母开头
        pwReg  : /^.{6,20}$/,
        mailReg: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i        // 邮箱
    },

    urlBase: {
        loginURL      : "?m=member&c=index&a=ajax_login",      // 登陆send url
        regURL        : "?m=member&c=index&a=ajax_register",      // 注册send url
    },

    // 错误提示
    msgPrompt: function(obj, msg){
        obj.slideDown().find("p").html(msg);
    },

    // 输入正确
    msgRight: function(obj){
         obj.slideUp().find("p").html("");
    },

    /*
     * 注册块
     * */
    usernameReg: function(){     // 效验用户名
        var _namePath = MFLogin1.objName;
        var usernameVal = $.trim(_namePath.usernameReg.val());
        if(!MFLogin1.regStr.usReg.test(usernameVal)){
            MFLogin1.msgPrompt(_namePath.msgBox, "用户名格式错误");
            _namePath.usernameReg.focus();
            return false;
        }
        else{
            MFLogin1.msgRight(_namePath.msgBox);
            return true;
        }
    },

    emailReg: function(){    // 效验邮箱
        var _namePath = MFLogin1.objName;
        var mailVal = $.trim(_namePath.emailReg.val());
        if(!MFLogin1.regStr.mailReg.test(mailVal)){
            MFLogin1.msgPrompt(_namePath.msgBox, "请正确填写Email地址");
            _namePath.emailReg.focus();
            return false;
        }
        else{
            MFLogin1.msgRight(_namePath.msgBox);
            return true;
        }
    },

    applyTermReg: function(){    // 效验证码
        var _namePath = MFLogin1.objName;
        var applyTermVal = $.trim(_namePath.applyTermReg.attr('checked'));
        if(!(applyTermVal)){
            MFLogin1.msgPrompt(_namePath.msgBox, "必须同意网站服务条款才能继续注册");
            return false;
        }
        else{
            MFLogin1.msgRight(_namePath.msgBox);
            return true;
        }
    },

    reg: function(){   // 注册
        var _namePath = MFLogin1.objName;
        var username = $.trim(_namePath.usernameReg.val());
        var mail = $.trim(_namePath.emailReg.val());
        var connect_avatar = _namePath.faceReg.attr('checked') ? 1 : 0;

        if(!MFLogin1.usernameReg()){ return false; }
        if(!MFLogin1.emailReg()){ return false; }
        if(!MFLogin1.applyTermReg()){ return false; }

        $.ajax({
            url:MFLogin1.urlBase.regURL,
            type: "post",
            data: "username=" + username + "&email=" + mail + "&connect_avatar=" + connect_avatar,
            success: function(data){
                // 返回格式 {returtate:0}  0 注册成功  1、注册失败
		data = $.parseJSON(data);
                switch (data.code){
                    case 0:
			//location.reload();
			location.href="index.php";
                        break;
                    case 1:
                        MFLogin1.msgPrompt(_namePath.msgBox, data.msg);
                        break;
                }
            }
        });
    },

    /*
    * 登陆块
    * */
    usernameLogin: function(){    // 效验用户名
        var _namePath = MFLogin1.objName;
        var _usernameVal = $.trim(_namePath.usernameLogin.val());
        if(!MFLogin1.regStr.usReg.test(_usernameVal)){
            MFLogin1.msgPrompt(_namePath.msgBox, "用户名格式错误");
            _namePath.usernameLogin.focus();
            return false;
        }
        else{
            MFLogin1.msgRight(_namePath.msgBox);
            return true;
        }
    },

    passwordLogin:function(){    // 效验登陆密码
        var _namePath = MFLogin1.objName;
        var _passwordVal = $.trim(_namePath.passwordLogin.val());
        if(!MFLogin1.regStr.pwReg.test(_passwordVal)){
            MFLogin1.msgPrompt(_namePath.msgBox, "密码格式错误");
            _namePath.passwordLogin.focus();
            return false;
        }
        else{
            MFLogin1.msgRight(_namePath.msgBox);
            return true;
        }
	},

    login: function(){     // 登陆
        var _namePath = MFLogin1.objName;
        if(!MFLogin1.usernameLogin()){ return false;}
        if(!MFLogin1.passwordLogin()){ return false; }
        //if(!MFLogin.regVerifyCodeLogin()){ return false; }


        var connect_avatar = _namePath.faceLogin.attr('checked') ? 1 : 0;
        var username = _namePath.usernameLogin.val();
        var password = _namePath.passwordLogin.val();
        //var verifyCode = _namePath.verifyCodeLogin.val();
        var sendURL = MFLogin1.urlBase.loginURL;
        $.ajax({
            url: sendURL,
            type: "post",
            //data: "username=" + username + "&password=" + password + "&code=" + verifyCode,
            data: "username=" + username + "&password=" + password + "&connect_avatar=" + connect_avatar,
            success: function(data){
                // 返回格式 {login:0}  0 成功  1、验证码错误
				data = $.parseJSON(data);
                switch (data.code){
                    case 0:
			//location.reload();
			location.href="index.php";
                        break;
                    case 1:
                        MFLogin1.msgPrompt(_namePath.msgBox, data.msg);
                        break;
                }
            }
        });
    },

    // 注册和登陆切换
    tag: function(initial){
        var _ind = initial;
        $(".register_tab1 li").removeClass("current").eq(_ind).addClass("current");
        $("#fmBox1 .register_cont1").hide().eq(_ind).show();
    },

    // 初始配置
    init: function(){
        var _name = MFLogin1.objName;

        $(".register_tab1 li").bind("click", function(){ // 注册/登陆切换
            var cur = $(this).index();
            MFLogin1.tag(cur);
        });

        _name.usernameReg.blur(function(){ MFLogin1.usernameReg(); })
        _name.emailReg.blur(function(){ MFLogin1.emailReg(); })
        _name.applyTermReg.click(function(){ MFLogin1.applyTermReg(); })

        _name.submitReg.click(function(){
            MFLogin1.reg();
        });

        _name.usernameLogin.blur(function(){ MFLogin1.usernameLogin(); });
        _name.passwordLogin.blur(function(){ MFLogin1.passwordLogin(); });

        _name.submitLogin.bind("click", function(){// 登陆
		MFLogin1.login();
        });

        // 关闭提示框
        $("#msgBox1 .prompt_close1").click(function(){
			MFLogin1.msgRight($(this).parent());
        })
    }
};
MFLogin1.init();
