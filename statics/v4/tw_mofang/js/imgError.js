define("imgEror", ["jquery"], function(require, exports, module) {

	var $ = require("jquery");
    var url = '/statics/v4/tw_mofang/img/not.jpg';
    $(".j_error").each(function(){
        if($(this).attr("src")==""){
            $(this).attr("src",url);
            return false;
        }
        $(this).on("onerror",function(){
            $(this).attr("src",url);
        })
    })	
})
seajs.use(["imgEror"])
