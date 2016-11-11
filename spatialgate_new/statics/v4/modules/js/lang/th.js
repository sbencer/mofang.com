/*
 *泰文(泰国)语言包，更新此语言包请同步更新其他的语言包
 *@autor,xukuikui
 *@date,2015.10.19
 *
 *json值只能为字符串格式，正则也是以字符串也是以字符串更是存储
 */

define('lang/th',[],function (require,exports,module) {
	
	if(typeof MF != "object"){
		var MF = {};	
	}
	if(typeof MF.I18N != "object"){
		MF.I18N={};
	}
	
	MF.I18N['th'] = {
		"labelMap":{
			"serviceAgree":"请同意服务协议",
			"thirdPartyLogin":"第三方登录"
		},
		"account":{
			"name":"账号",
			"reg":"",
			"isEmpty":"手机号或邮箱不能为空",
			"isError":"账号错误"
		},
		"username":{
			"name":"用户名",
			"reg":"",
			"isEmpty":"用户名不能为空",
			"isError":"用户名错误"
		},
		"phone":{
			"name":"手机号",
			"reg":"^1[34578]\d{9}$",
			"isEmpty":"手机号不能为空",
			"isError":"手机号格式不正确"
		},
		"email":{
			"name":"邮箱",
			"reg":"^([a-z0-9]*[-_]?[a-z0-9]+)+@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z0-9]+([\.][a-z]+)?$",
			"isEmpty":"邮箱不能为空",
			"isError":"邮箱格式不正确",
			"success":"邮件已发送",
			"reSend":"重新发送邮件"
		},
		"password":{
			"name":"密码",
			"reg":"^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~\-_]{6,16}$",
			"isEmpty":"密码不能为空",
			"isError":"6-16位数字、字母或常用符号，字母区分大小写",
			"isEqual":"两次密码不一致"
		},
		"vcode":{
			"name":"验证码",
			"reg":"",
			"isEmpty":"验证码不能为空",
			"isError":"验证码错误",
			"minlength":"验证码长度为6位",
			"maxlength":"验证码长度为6位"
		},
		"login":{
			"name":"登录",
			"loginSuc":"登录成功",
			"loginErr":"登录失败"
		},
		"reg":{
			"name":"注册",
			"regSuc":"注册成功",
			"regErr":"注册失败"
		},
		"text":{
			"name":"短信",
			"textSend":"短信已发送",
			"textReSend":"重新发送",
			"textSuc":"短信发送成功",
			"textErr":"短信发送失败"
		},
		"network":{
			"name":"网络",
			"networkErr":"网络异常",
			"networkWait":"网络请求中"
		}

	};

	if (typeof module!="undefined" && module.exports ) {
        module.exports = MF.I18N['th'];
    }
});
