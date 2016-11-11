define('tw/show', ["jquery"], function(require, exports, module) {
  	var $ = require("jquery");

    $.fn.show = function(options){
        var this_ = $(this),
        data = {
            
        }
        
        this_.options = options;
        
    }
})
seajs.use(["tw/show"])
