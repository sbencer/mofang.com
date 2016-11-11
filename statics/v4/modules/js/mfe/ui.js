define('mfe/ui', ['jquery'], function(require, exports, module){
    var $ = jQuery = require("jquery");
    ////////////////////////////////////////////////////////////
    // carousel
    (function($){
        $.fn.carousel = function (options) {
            var settings = {
                carous: "",
                carousson: "",
                pre:"",
                next: ""
            };
            if (options) $.extend(settings, options);
            $(settings.carous).each(function(){
                var _this = $(this);
                var carousson = _this.find(settings.carousson);
                var pre = _this.find(settings.pre);
                var next = _this.find(settings.next);
                var chi = $(carousson).children().length;
              
                $(pre).click(function(){
                    var hgt = $(carousson).height();
                    if(!$(carousson).is(":animated")){
                        //console.log(1111)
                        var pos = -$(carousson).position().top;
                        if(chi>10){
                            if(pos!=0){
                              carousson.stop().animate({top:-pos+400},500);
                          }
                      } 
                    }
                });
                $(next).click(function(){
                    var hgt = $(carousson).height();
                    if(!$(carousson).is(":animated")){
                        var pos = -$(carousson).position().top;
                        if(chi>10){
                            if(hgt-pos-400>0 ){
                                carousson.stop().animate({top:-pos-400},500);
                        }else{
                        }
                    } 
                    } 
                });   
            });
        };
    })(jQuery);


    // tabs
    $(function () {
        $.fn.tabs = function (options) {
            var settings = {
                tabList: "",
                tabContent: "",
                    tabOn:"",
                action: ""
            };
            var _this = $(this);
            if (options) $.extend(settings, options);
            _this.find(settings.tabContent).eq(0).show(); //第一栏目显示
            _this.find(settings.tabList).eq(0).addClass(settings.tabOn);
            if (settings.action == "mouseover") {
                _this.find(settings.tabList).each(function (i) {
                    $(this).mouseover(function () {
                        $(this).addClass(settings.tabOn).siblings().removeClass(settings.tabOn);
                        var _tCon = _this.find(settings.tabContent).eq(i);
                        _tCon.show().siblings().hide();

                    }); //滑过切换              

                });

            }
            else if (settings.action == "click") {
                _this.find(settings.tabList).each(function (i) {
                    $(this).click(function () {
                        $(this).addClass(settings.tabOn).siblings().removeClass(settings.tabOn);
                        var _tCon = _this.find(settings.tabContent).eq(i);
                        _tCon.show().siblings().hide();
                    }); //点击切换
                });
            };

        };
    });

    // tabChange
    (function($){
        $.fn.tabChange = function(options){
            var settings = {
                hover_name:"",
                nor_name:"",
                content:""
            };
            if(options){$.extend(settings, options)};
            $(settings.content).each(function(){
                var _this = $(this);
                _this.children().eq(1).addClass(settings.hover_name);
                _this.children().eq(0).css({"margin":0});
                _this.children().hover(function(){
                    var index = $(this).index();
                    if(index ==0 ){
                        $(this).css({"margin":0});
                        $(this).parent().children().eq(1).addClass("bg-no").removeClass("bg-ha").siblings().addClass("bg-ha").removeClass("bg-no"); 
                    }else{
                        $(this).parent().children().eq(index+1).removeClass("bg-ha").addClass("bg-no").siblings().removeClass("bg-no").addClass("bg-ha");
                        _this.children().eq(0).removeClass("bg-ha").addClass("bg-no")
                        //$(this).css({"margin":"-1px"});
                    }
                });
            });
        }
    })(jQuery);

    ////////////////////////////////////////////////////////////
    if (typeof module!="undefined" && module.exports ) {
        module.exports = $;
    }

});