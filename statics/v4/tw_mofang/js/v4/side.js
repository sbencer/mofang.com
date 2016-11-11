define('v4/side', ["jquery","jquery/tabs","jquery/Swiper"], function(require, exports, module) {
  	var $ = require("jquery");
  	var tab = require('jquery/tabs');
    require("jquery/Swiper");

    //侧边人气新闻、最新新闻列表
    $(".side-news").tabs({
      tabList: ".side-news-btn span",               // 标题列表
      tabContent: ".news-con-wrap .side-news-con",            //内容列表
      tabOn: "side-active",                 //菜单划过的类名
      action: "mouseover",                // click || mouseover
    });
   
})
seajs.use(["v4/side"])
