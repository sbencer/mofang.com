define("hw_wap/swipeSlider", ["swipe"],
function(require) {
    var e = require("swipe"),
    s = document.getElementById("slideBox"),
    i = document.getElementById("slidePage").getElementsByTagName("li");
    window.mySwipe = new e(s, {
        startSlide: 0,
        speed: 300,
        auto: 3e3,
        continuous: !0,
        callback: function(e) {
            for (var s = i.length; s--;) i[s].className = " ";
            i[e].className = "sliderCurr"
        }
    })
}),
seajs.use(["hw_wap/swipeSlider"]);