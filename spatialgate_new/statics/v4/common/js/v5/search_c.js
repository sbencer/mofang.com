//**************************************/
/**
 * 搜索
 * jozhliu 2014-03-28
 */
seajs.use(['jquery'],function($) {

    //域名
    var DOMAIN = {
        TW:{
            pc:"http://www.mofang.com.tw",
            mb:"http://www.m.mofang.com.tw"
        }
    }

    //判断设备
    function IsPC(){  
         var userAgentInfo = navigator.userAgent;  
         var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");  
         var flag = true;  
         for (var v = 0; v < Agents.length; v++) {  
             if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = false; break; }  
         }  
         return flag;  
    };
    var  DEV = null;
    if(IsPC){
        DEV = "pc";
    }

    //window.domain = defaultURL||"http://www.mofang.com";
    $("#search-header").click(
    function (){
        key = $(":input[name=q-header]").val();
        if(key != '') {
            window.open(DOMAIN[lang_conf][DEV] + "/index.php?m=search&q=" + key );
        }else{
        	//window.open('http://www.mofang.com/zqnr/935-1.html');
            alert("請您輸入搜索的內容！");
        }
        return false;
    });

});
