define('v4/index', ["jquery","jquery/tabs","jquery/Swiper"], function(require, exports, module) {
    var $ = require("jquery");
    var tab = require('jquery/tabs');
    require("jquery/Swiper");

    //跑马灯效果
    function autoScroll(obj){
        $(obj).find("ul:first").animate({marginTop: "-41px"},500,function(){
            $(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
        });
    };
    var scrollInter = setInterval(function(){
        autoScroll("#indexLamp");   
    },5000);
    $("#indexLamp").hover(function(){
        clearInterval(scrollInter);
    },function(){
        scrollInter = setInterval(function(){
            autoScroll("#indexLamp");   
        },5000);
    });

    //widget_index_part1处的tab选项卡
    $(".list-arc").tabs({
        tabList: ".arc-tab-btn span",               // 标题列表
        tabContent: ".arc-tab-wrap .arc-tab-con",            //内容列表
        tabOn: "arc-btn-active",                 //菜单划过的类名
        action: "mouseover",                // click || mouseover
    });
    //新上市游戏
    $(".extend-game-tab").tabs({
        tabList: ".game-tab-btn span",               // 标题列表
        tabContent: ".game-con-wrap .game-tab-con",            //内容列表
        tabOn: "game-active",                 //菜单划过的类名
        action: "mouseover",                // click || mouseover
    });
    //首屏焦点图
    var mySwiper = $("#focus-swiper").swiper({
        autoplay: 5000,
        loop: "true"
    });
    $(".focus-swiper-prev").on("click",function(){
        mySwiper.swipePrev();
    });
    $(".focus-swiper-next").on("click",function(){
        mySwiper.swipeNext();
    });

    //cosplay img 比例缩放
    resizeCosImg();
    function resizeCosImg(){
        function sizaChange(){
            $(".atlas-list li").each(function(){
                var _this = this;
                var imgObj = $(_this).find("img");
                var imgH = imgObj.height();
                var imgW = imgObj.width();

                var liH = $(_this).height();
                var liW = $(_this).width();
                if((liH/liW) > (imgH/imgW)){
                    imgObj.addClass("img-height");
                }else{
                    imgObj.addClass("img-width");
                }
            });
        };

        var imgdefereds=[];
        $('.atlas-list li img').each(function(){
            var dfd=$.Deferred();
            $(this).bind('load',function(){
                dfd.resolve();
            }).bind('error',function(){
            //图片加载错误，加入错误处理
            // dfd.resolve();
            });
            if(this.complete) setTimeout(function(){
                dfd.resolve();
            },1000);
            imgdefereds.push(dfd);
        });
        $.when.apply(null,imgdefereds).done(function(){
            sizaChange();
        });
    }

    
})
seajs.use(["v4/index"])
