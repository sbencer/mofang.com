/**
 * @brief
 * @param 'language'
 * @return Object
 */
define('language', function(require, exports, module) {
    var language = {
        "ZH": {
            "header": {
                "login": "登录",
                "register": "快速注册"
            },
            "login": {
                "user": "邮箱/手机",
                "old_user":"用户名",
                "pass": "输入密码",
                "savePass": "记住密码",
                "forgotPass": "忘记密码",
                "loginEnter": "登录",
                "usernameLogin": "用户名登陆",
                "email_phone_login": "邮箱或手机登录",
                "secCode": "请输入验证码",
                "secPhoneCode":"请输入短信验证码"
            },
            "register": {
                "registerItem": [
                    "邮箱",
                    "密码",
                    "再次输入",
                    "昵称"
                ],
                "email": "输入邮箱",
                "pass": "输入密码",
                "oncePass": "再次输入密码",
                "niceName": "输入昵称",
                "registerEnter": " 立即注册",
                "phoneCode":"获取短信验证码"
            },
            "vcode": "验证码",
            "otherLogin": {
                "weibo": "新浪微博",
                "qq": "QQ"
            },
            "errorTips": {
                "login": {
                    "user": "请输入登录名",
                    "pass": "请输入密码",
                    "error": "帐号或密码错误"
                },
                "vcode": "验证码格式错误",
                "register": {
                    "email": "请正确填写Email地址",
                    "pass": "密码不正确",
                    "diffPass": "两次密码不同",
                    "niceName": "用户名格式错误"
                }
            }
        },
        "EN": {
            "header": {
                "login": "Quick Login",
                "register": "Quick Register"
            },
            "login": {
                "user": "Username/Email",
                "pass": "Input Password",
                "savePass": "Remember the Password",
                "loginEnter": "Login"
            },
            "register": {
                "registerItem": [
                    "Email",
                    "Password",
                    "Input again",
                    "Nickname"
                ],
                "email": "Input Email",
                "pass": "Input Password",
                "oncePass": "Input Again",
                "niceName": "Input Nickname",
                "registerEnter": " Register Now"
            },
            "vcode": "Verification Code",
            "otherLogin": {
                "fb": "Facebook",
                "gg": "Google",
                "tt":"Twitter"
            },
            "errorTips": {
                "login": {
                    "user": "Input Login Name",
                    "pass": "Input Password",
                    "error": "Incorrect Account or Password"
                },
                "vcode": "Incorrect Verification Code",
                "register": {
                    "email": "Input Email address in correct format",
                    "pass": "Wrong Password",
                    "diffPass": "Different Password",
                    "niceName": "Wrong Username Format"
                }
            }
        },

        "JP": {
            "header": {
                "login": "即ログイン",
                "register": "アカウント作成"
            },
            "login": {
                "user": "ユーザー名/メール",
                "pass": "パスワード",
                "savePass": "ログインしたままにする",
                "loginEnter": "ログイン"
            },
            "register": {
                "registerItem": [
                    "メール",
                    "パスワード",
                    "再入力",
                    "ニックネーム"
                ],
                "email": "メールアドレス",
                "pass": "パスワード",
                "oncePass": "再入力",
                "niceName": "ニックネーム",
                "registerEnter": " アカウント作成"
            },
            "vcode": "認証コード",
            "otherLogin": {
                "fb": "Facebook",
                "gg": "Google",
                "tt":"Twitter"
            },
            "errorTips": {
                "login": {
                    "user": "ユーザー名を入力してください",
                    "pass": "パスワードを入力してください",
                    "error": "アカウントかパスワードが間違っています"
                },
                "vcode": "認証コードのタイプが間違っています",
                "register": {
                    "email": "有効なメールアドレスを入力してください",
                    "pass": "パスワードが間違っています",
                    "diffPass": "パスワードが一致していません",
                    "niceName": "ユーザー名のタイプが間違っています"
                }
            }
        },
        "TW": {
            "header": {
                "login": "快速登錄",
                "register": "快速註冊"
            },
            "login": {
                "user": "用戶名/郵箱",
                "pass": "輸入密碼",
                "savePass": "記住密碼",
                "loginEnter": "登錄"
            },
            "register": {
                "registerItem": [
                    "郵箱",
                    "密碼",
                    "再次輸入",
                    "昵稱"
                ],
                "email": "輸入郵箱",
                "pass": "輸入密碼",
                "oncePass": "再次輸入密碼",
                "niceName": "輸入昵稱",
                "registerEnter": " 立即註冊"
            },
            "vcode": "驗證碼",
            "otherLogin": {
                "fb": "Facebook",
                //"gg": "Google",
                //"tt":"Twitter"
            },
            "errorTips": {
                "login": {
                    "user": "請輸入登錄名",
                    "pass": "請輸入密碼",
                    "error": "帳號或密碼錯誤"
                },
                "vcode": "驗證碼格式錯誤",
                "register": {
                    "email": "請正確填寫Email地址",
                    "pass": "密碼不正確",
                    "diffPass": "兩次密碼不同",
                    "niceName": "用戶名格式錯誤"
                }
            }
        }
    };
    module.exports = language;
});
