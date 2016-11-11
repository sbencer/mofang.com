<?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:28:46
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/common/hw/jiajia_api.tpl" */ ?>
<?php /*%%SmartyHeaderCode:175651292357ccd85e17c577-22781458%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c9f77e886bdb44231c8d61a739ec6ce235a9175' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/common/hw/jiajia_api.tpl',
      1 => 1473041737,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '175651292357ccd85e17c577-22781458',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_57ccd85e187ef3_25858659',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57ccd85e187ef3_25858659')) {function content_57ccd85e187ef3_25858659($_smarty_tpl) {?>
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