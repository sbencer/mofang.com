<?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:45:42
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/common/hw/jiajia_api.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9738937375667f6c36f1251-07664529%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd19e3662b34c95faa9be367d3edc3c0bcc72a4ce' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/common/hw/jiajia_api.tpl',
      1 => 1456799846,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9738937375667f6c36f1251-07664529',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5667f6c36fb313_14745299',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5667f6c36fb313_14745299')) {function content_5667f6c36fb313_14745299($_smarty_tpl) {?>
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
        if (/jiajia/i.test(ua)) {
            return true;
        } else {
            return false;
        }
        return true;
    }
    if (!inJiajia()) {
        log("not in jiajia");
        return false;
    }

    log("init jiajia api");
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