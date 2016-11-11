// JavaScript Document
define("tw_tyong/slider", ["jquery", "jquery/flexslider"],
function(require) {
    var i = jquery = require("jquery");
    require("jquery/flexslider"),
    i("#carousel").flexslider({
        animation: "slide",
        controlNav: !1,
        slideshow: !0,
        animationLoop: !1,
        itemWidth: 83,
        itemMargin: 10,
        asNavFor: "#slider",
        after: function() {}
    }),
    i("#slider").flexslider({
        animation: "slide",
        controlNav: !1,
        animationLoop: !0,
        slideshow: !0,
        directionNav: !0,
        slideshowSpeed: 8e3,
        sync: "#carousel",
        after: function() {
            var e = i(".flex-active-slide").index(),
            n = i(".video-descript-wrap").children("p");
            n.eq(e - 2).show().siblings().hide()
        }
    }),
    i(".j_hover").hover(function() {
        i(this).find(".j_wd").hide(),
        i(this).find(".j_mask").stop().animate({
            left: 0
        })
    },
    function() {
        var e = i(this).find(".j_mask").outerWidth(),
        n = i(this);
        i(this).find(".j_mask").stop().animate({
            left: -e
        },
        function() {
            n.find(".j_wd").show()
        })
    })
}),
seajs.use(["tw_tyong/slider"]);