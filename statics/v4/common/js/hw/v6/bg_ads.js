define('bg_ads', ['jquery'], function(require, exports, module) {
    var $ = jQuery = require("jquery");

    /*$(conWrapper).bg_ads({   //conWrapper  主体内容容器的选择器
        adBox : ".screen-AD",      //放置广告所有内容的最外层容器的选择器
        adWrapper : ".mofang-ad",  //广告图的上一层容器的选择器
        adPic : ".mofang-ad img",  //广告图img的选择器
        adCon : ".mofang-ad-con",  //广告图上的 a 的选择器
        adHorn: "#mfHorn",        //放置小喇叭内容的链接的选择器
        animHeight: "500px",      //展开广告时主体内容下沉的高度
        defHeight: "100px",       //主体内容初始状态 距最顶部的高度
        allowDeploy: true          //是否允许主体内容下沉
    })*/


    /*
        小喇叭内容配置  放置小喇叭内容的容器 设置  id  为 mfHorn
    */
    /*var ajaxMethod = 'jsonp',

        USE_LOCAL_URL = 0,

        USE_TEST_URL = 1,

        ONLINE_URL = 1;

    var bgAdsDataUrl = "",

        hornDaraUrl = "",

        keyUrl = "",

        bgAdsKey = 0,

        hornKey = 0,

        locationHref = "";

    if(USE_LOCAL_URL){
        bgAdsDataUrl = "";
        hornDaraUrl = "";
         keyUrl = "";
    };

    if(USE_TEST_URL){
        bgAdsDataUrl = "http://zr.test.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
        hornDaraUrl = "http://zr.test.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
        keyUrl = "http://zr.test.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb_hit";
    };

    if(ONLINE_URL){
        bgAdsDataUrl = "http://www.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
        hornDaraUrl = "http://www.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
        keyUrl = "http://www.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb_hit";
    };

    function bgAdsData(){
        $.ajax({
            type: "get",
            url: bgAdsDataUrl,
            data: {
                "type": "bt"
            },
            dataType: ajaxMethod,
            beforeSend:function(){

            },
            success:function(res){
                if(res && res.code == 0){
                    $(".mofang-ad img").attr("src",res.data.pic);
                    $(".mofang-ad a").attr("data-href",res.data.url);
                    bgAdsKey = res.data.key;
                }
            },
            complete:function(){

            }
        });
    };

    function hornData(){
        $.ajax({
            type: "get",
            url: hornDaraUrl,
            data: {
                "type": "lb"
            },
            dataType: ajaxMethod,
            beforeSend:function(){

            },
            success:function(res){
                if(res && res.code == 0){
                    $("#mfHorn").html(res.data.title).attr("data-href",res.data.url);
                    hornKey = res.data.key;
                }
            },
            complete:function(){

            }
        });
    };

    function keyData(data){
        $.ajax({
            type: "get",
            url: keyUrl,
            data: data,
            dataType: ajaxMethod,
            beforeSend: function(){

            },
            success: function(res){
            },
            complete: function(){
            }
        });
    };
    hornData()
    bgAdsData();

    $(".mofang-ad-con").on("click",function(e){
        e.preventDefault();
        locationHref = $(this).attr("data-href");
        keyData({
            "type": "bt",
            "key" : bgAdsKey
        });
        window.open(locationHref);
    });

    $("#mfHorn").on("click",function(e){
        e.preventDefault();
        e.stopPropagation();
        locationHref = $(this).attr("data-href")
        keyData({
            "type": "lb",
            "key" : hornKey
        });
        window.open(locationHref);
    });*/

    $.fn.bg_ads = function(options){
        var defaults = {
            adBox : ".screen-AD",
            adWrapper : ".mofang-ad",
            adPic : ".mofang-ad img",
            adCon : ".mofang-ad-con",
            adHorn: "#mfHorn",
            animHeight: "500px",
            defHeight: "100px",
            allowDeploy: true
        };
        var options = $.extend(true,defaults,options);
        var _this = this;
        var ajaxMethod = 'jsonp',

            USE_LOCAL_URL = 0,

            USE_TEST_URL = 1,

            ONLINE_URL = 1;

        var bgAdsDataUrl = "",

            hornDaraUrl = "",

            keyUrl = "",

            bgAdsKey = 0,

            hornKey = 0,

            locationHref = "";

        if(USE_LOCAL_URL){
            bgAdsDataUrl = "";
            hornDaraUrl = "";
             keyUrl = "";
        };

        if(USE_TEST_URL){
            bgAdsDataUrl = "http://zr.test.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
            hornDaraUrl = "http://zr.test.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
            keyUrl = "http://zr.test.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb_hit";
        };

        if(ONLINE_URL){
            bgAdsDataUrl = "http://www.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
            hornDaraUrl = "http://www.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb";
            keyUrl = "http://www.mofang.com/api_v2.php?op=mofang&file=article&action=bt_lb_hit";
        };
        function bgAdsData(){
            $.ajax({
                type: "get",
                url: bgAdsDataUrl,
                data: {
                    "type": "bt"
                },
                dataType: ajaxMethod,
                beforeSend:function(){

                },
                success:function(res){
                    if(res && res.code == 0){
                        $(options.adPic).attr("src",res.data.pic);
                        $(options.adCon).attr("data-href",res.data.url);
                        bgAdsKey = res.data.key;
                    }
                },
                complete:function(){

                }
            });
        };

        function hornData(){
            $.ajax({
                type: "get",
                url: hornDaraUrl,
                data: {
                    "type": "lb"
                },
                dataType: ajaxMethod,
                beforeSend:function(){

                },
                success:function(res){
                    if(res && res.code == 0){
                        $(options.adHorn).html(res.data.title).attr("data-href",res.data.url);
                        hornKey = res.data.key;
                    }
                },
                complete:function(){

                }
            });
        };

        function keyData(data){
            $.ajax({
                type: "get",
                url: keyUrl,
                data: data,
                dataType: ajaxMethod,
                beforeSend: function(){

                },
                success: function(res){
                },
                complete: function(){
                }
            });
        };
        hornData()
        bgAdsData();
        $(options.adCon).on("click",function(e){
            e.preventDefault();
            locationHref = $(this).attr("data-href");
            keyData({
                "type": "bt",
                "key" : bgAdsKey
            });
            window.open(locationHref);
        });

        $(options.adHorn).on("click",function(e){
            e.preventDefault();
            e.stopPropagation();
            locationHref = $(this).attr("data-href")
            keyData({
                "type": "lb",
                "key" : hornKey
            });
            window.open(locationHref);
        });

        if(options.allowDeploy){
            $(options.adBox).click(function (e) {
                if($(window).height() < 700){
                    var h = $(window).height()-100;
                    $(_this).animate({"margin-top":h});
                    $(options.adCon).css("height",h);
                }else{
                    $(_this).animate({"margin-top" : options.animHeight});
                     $(options.adCon).css("height" , options.animHeight);
                }
            });
            $(_this).click(function (e){
                $(this).animate({
                    "margin-top" : options.defHeight
                });
            });
        }
        
    }

    if (typeof module != "undefined" && module.exports) {
        module.exports.$ = $;
    }
    
});