//TODO 需要优化
//只需要提供一个data-num
define('jquery/roundRank',['jquery'],function(require, exports, module) {

    var $ = require("jquery");

    function RoundRank () {};

    RoundRank.prototype.init = function () {
        var roundWrap = $(".ui-round");
        roundWrap.each(function () {

            var self = $(this),
            roundDataNum = self.find(".J-num");

            initValue(roundDataNum.attr("data-num"));

            function initValue (dataNum) {
                setValue(dataNum)
            }
            function setValue (roundVal) {
                switch(roundVal) {
                    case "6":
                        roundDataNum.addClass("rank_6")
                        break;
                    case "7":
                        roundDataNum.addClass("rank_7")
                        break;
                    case "8":
                        roundDataNum.addClass("rank_8")
                        break;
                    case "9":
                        roundDataNum.addClass("rank_9")
                        break;
                    default:
                        break;
                        // code
                }
            };
        })
    }
    if (typeof module!="undefined" && module.exports ) {
        //debugger;
        module.exports = RoundRank;
    }
})




