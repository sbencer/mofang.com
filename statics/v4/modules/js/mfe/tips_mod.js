/*
*  @author : baozi
*  @email  : zhaoshuai@mofang.com
*  @depend : tips.css
*  example：
*      seajs.use("./tips_mod", function(Tips) {
*           var tips = new Tips({
*               element:".obj",  //要提示的对象
*               cont:"baozi",     //要提示的内容 "auto"为自动获取当前元素data-info属性
*               position:"left"   //提示信息方向
*           });
*      });
*
*
* */

define(function(require, exports, module) {

    /* 加载依赖样式*/
    //require('./tips.css');

        var $ = require("jquery"),
            Widget = require('widget');

        Tips = Widget.extend({

        /* 生成模板 */
        templ: $('<div class="text-tip"><i class="text-tip-arrow"></i><div class="text-tip-cont">asdas</div></div>').appendTo("body"),

        /* 默认混合参数 */
        attrs: {
            cont: '1',
            position: "left",
            color: '#fff'//????
        },

        /* 初始化 */
        setup: function() {

            var self = this;

            this.element.each(function() {

                $(this).hover(function() {
                    self.getPos($(this));
                },
                function() {
                    self.hide($(this));
                });
            });

            /* 渲染模板 */
            this.render();
        },

        /*
         * 定位检测
         * TODO 边缘检测
         *
         * */
        getPos: function(currObj) {

            var currLeft = currObj.offset().left,
                currTop = currObj.offset().top,

                tipsHeight = currObj.height(),
                tipsWidth = currObj.width(),

                tipsArr = this.templ;

            switch (this.get("position")) {

                case 'right':
                    tipsArr.css("top", currTop + tipsHeight / 2);
                    tipsArr.css("left", currLeft + tipsWidth + 10);
                    tipsArr.find(".text-tip-arrow").addClass("tip-arrow-right");
                    break;

                case 'top':
                    tipsArr.css("top", currTop - tipsHeight / 2);
                    tipsArr.css("left", currLeft);
                    break;

                case 'bottom':
                    tipsArr.css("top", currTop + tipsHeight + 10);
                    tipsArr.css("left", currLeft);
                   tipsArr.find(".text-tip-arrow").addClass("tip-arrow-bottom");
                    break;

                case 'left':
                    tipsArr.css("top", currTop + tipsHeight / 2);
                    tipsArr.css("left", currLeft - tipsWidth + 20);
                    tipsArr.find(".text-tip-arrow").addClass("tip-arrow-left");
                    break;

                default:
                    alert(1);
                }

            this.setCont(tipsArr,currObj);
        },


        /* 设置属性 */
        setCont : function (curObj,currObj) {

            var textTipCont =  curObj.find(".text-tip-cont");
            if(this.get("cont")=="auto") {

                textTipCont.text(currObj.attr("data-info"));

            } else {

                textTipCont.text(this.get("cont"));
            }

            this.show();
        },

        show: function() {
            this.templ.show();
        },

        hide: function() {
            this.templ.hide();
        }
    });

    if (typeof module != "undefined" && module.exports) {

        module.exports = Tips;
    }

});

