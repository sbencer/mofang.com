define('mfe/ad',['jquery'],function(require, exports, module) {
    var $ = require('jquery');


    function after(n,fn){
        window.setTimeout(fn,n*1000);
    }
    var baidu = {
        A:function(id,eid){
            if($("#"+eid).length){
                window.BAIDU_CLB_fillSlotAsync(id,eid);
            }
        },
        boot:function(next){
            $.getScript("http://cbjs.baidu.com/js/m.js", function() {
                next();
            });
        }
    };
    module.exports = {
        after:after,
        baidu:baidu
    };
});
