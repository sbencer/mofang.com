define('atom',['base64'], function(require, exports, module){

    var base64 = require('base64');

    function atomDecode(str){
        var res = decodeURIComponent(str);
        res = base64.decode(res);
        var o = {
        };
        var arr = res.split('&');
        var flag = false;
        for( var i=0; i < arr.length; i++){
            flag = true;
            var item = arr[i].split('=');
            var key = item[0];
            var val = item[1];
            o[key] = val;
        }
        return flag ? o : null;
    }

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(window.location.search);
        return results == null ? "" : results[1];
    }

    function getAtomStr(key){
        key = key || "atom";
        var str = getParameterByName(key);
        if(!str){
            return null;
        }
        return str;
    }

    module.exports = {};

    module.exports.getAtomStr = getAtomStr;
    module.exports.decode = function(str){
        return atomDecode(str);
    };
    module.exports.fromUrl = function(key){
        var str = getAtomStr(key);
        if(!str){
            return null;
        }
        return atomDecode(str);
    };

});

