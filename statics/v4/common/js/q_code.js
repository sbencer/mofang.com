define('qcode_menu', ['jquery'], function(require, exports, module) {
    var $ =  require("jquery");
    $(function () {
        /* 二维码弹出层 */
        var winObj = $(window),
            doc = $(document),
            pop = $(".popup"),
         win = {
             T: winObj.scrollTop(),
             L: winObj.scrollLeft(),
             H: winObj.height(),
             W: winObj.width()
         },
         doc = {
             H : doc.height(),
             W : doc.width()
         };
         obj = {
             H: pop.outerHeight(true),
             W: pop.outerWidth(true),
             L: pop.offset().left,
             T: pop.offset().top
         };

         pop.css({
             left: ((win.W - obj.W) / 2) + win.L,
         });
        $('.popup_qr').mouseenter(function(){
            $('.popup_code').show();
        }).mouseleave(function(){
            $('.popup_code').hide();
        });

        $('.popup_close').click(function(){
            $('.popup').hide();
        });
        $('.popup_close').show();
    })
});
seajs.use("qcode_menu");
