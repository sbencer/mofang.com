// *************************************

/**
 * [function_name description]
 * @param  {[type]} argument
 * @return {[type]}
 */
define("hw/loginTip",['jquery',"mfe",'transform', 'mf/login','mf/floatLayer'],function(require,exports,module){
	var $ = jquery = require("jquery"),
		mfe = require("mfe");
	var $ = require("jquery");
    var MFLogin = require('mf/login');

    MFLogin.onLoginSuc = function(data,loginWay){

    	if(loginWay==-1){
    		setTimeout(function(){
    			alert( data.data.nickname + "：您已经注册成功！" )
    		},1000)
    	}else if(loginWay==0){
    		setTimeout(function(){
    			alert( "欢迎回来，" + data.data.nickname );
    		},1000)
    	}
    	
    }

	if (typeof module!="undefined" && module.exports ) {
       // module.exports = ;
    }
	
})
seajs.use(["hw/loginTip"])
