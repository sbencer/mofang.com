define('tw/tabs', ['jquery'], function(require, exports, module) {
        var $ = jQuery = require("jquery");
        /**
         *  {
         *      switchTime:"400",
         *      tabList:"",
         *      tabContent:"",
         *      tabOn:"active",
         *      action:"click",
         *      berforeCallback:function(){},
         *      afterCallbakc:function(){}
         *  }
         * */
        $.fn.tabChange = function(options){

            var default_ = {
               switchTime:"400",
               tabList:"",
               tabContent:"",
               tabOn:"active",
               action:"click",
               beforeCallback:function(){},
               afterCallback:function(){}
            };

            var option_ = $.extend(default_,options);
            var this_ = $(this);
            var tab_ = this_.find(option_.tabList);
            var con_ = this_.find(option_.tabContent);
            var init_ = function(){
                tab_.eq(0).show();
                con_.eq(0).show();
                tabHandler();
                autoTab(0)
            }
            var index = 0;
            var timer = null;
            var len = this_.find(option_.tabList).length;
            //切換函數
            var tab = function(index){
                    option_.beforeCallback(index);
                    //tab 切換
                    tab_.eq(index).addClass(option_.tabOn);
                    tab_.eq(index).siblings().removeClass(option_.tabOn);
                    //con切換
                    con_.eq(index).siblings().fadeOut(100,function(){
                        con_.eq(index).fadeIn(200);
                    });
                    option_.afterCallback(index);
            }
            var tabHandler = function(){
                tab_.hover(function(){
                    clearTimeout(timer);
                    index = $(this).index();
                    tab(index);
                },function(){
                    autoTab(index);
                })
            }
            //自動切換
            var autoTab = function(index){
                clearTimeout(timer);
                timer =  setTimeout(function(){
                    index++;
                    if(index>=len){
                        index=0;
                    }
                    tab(index)
                    //option_.beforeCallback(index);
                    //tab 切換
                    //$(this).addClass(option_.tabOn);
                    //$(this).siblings().removeClass(option_.tabOn);
                    //con切換
                    //con_.eq(index).siblings().hide();
                    //con_.eq(index).show();
                    //option_.afterCallback(index);
                    autoTab(index);
                },8000)
            }
            init_();
        }

        if (typeof module != "undefined" && module.exports) {
            module.exports = $;
        }

})

