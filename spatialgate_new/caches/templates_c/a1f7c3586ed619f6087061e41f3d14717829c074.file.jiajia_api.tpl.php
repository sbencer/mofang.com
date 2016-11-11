<?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:08:04
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/common/p/jiajia_api.tpl" */ ?>
<?php /*%%SmartyHeaderCode:169713300056027f1f363376-95233877%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1f7c3586ed619f6087061e41f3d14717829c074' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/common/p/jiajia_api.tpl',
      1 => 1443006345,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '169713300056027f1f363376-95233877',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_56027f1f37a617_03157022',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56027f1f37a617_03157022')) {function content_56027f1f37a617_03157022($_smarty_tpl) {?>
<script>
(function(win) {
    // win.SIMULATE_API = true;
    function log(){
        // console.log.apply(console,arguments);
    }
    function inJiajia() {
        if (win.SIMULATE_API) {
            return true;
        }
        var ua = navigator.userAgent.toLowerCase();
        if (/mfyxb/i.test(ua)) {
            return true;
        } else {
            return false;
        }
        return true;
    }
    if (!inJiajia()) {
        log("not in mfyxb");
        return false;
    }

    log("init mfyxb api");
    if (win.mofang && win.mofang.login) {
        return false;
    }
    var o = win.mofang = {};
    var iosApi = function(name) {
        var args = [];
        for (var i = 1; i < arguments.length; i++) {
            args.push('"' + arguments[i] + '"');
        }
        var argStr = args.join(",");
        var funCall = "jiajiajs." + name + "(" + argStr + ")" + ";";
        window.location.href = funCall;
        console.log(funCall);
    };
    var methods = "closeWeb,startGame,copyToClip,setShareInfo,showToast,getAtom,login,shareWeb,refreshUserInfo,relationArticleClick,downloadGame,clickImage".split(",");
    methods.forEach(function(method,index,arr){
        o[method] = (function() {
            return function() {
                var args = [method];
                for (var i = 0; i < arguments.length; i++) {
                    args.push(arguments[i]);
                }
                iosApi.apply(o, args);
            };
        })();
    });
    return true;
})(window);

</script>
<?php }} ?>