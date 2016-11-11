define('index/tabs', ["jquery","jquery/tabs"], function(require, exports, module) {
  	var $ = require("jquery");
  	var tab = require('jquery/tabs');
    $(".j_tab_wrap").tabs({
      tabList: ".j_tab",               // 标题列表
      tabContent: ".j_con",            //内容列表
      tabOn: "curr",                 //菜单划过的类名
      action: "mouseover",                // click || mouseover
    })
    if($(".j_hot_tab").length){
        require("tw/tabs");
        $(".j_hot_tab").tabChange({
          tabList: ".j_tab",               // 标题列表
          tabContent: ".j_con",            //内容列表
          tabOn: "curr",                 //菜单划过的类名
          action: "hover",                // click || mouseover
          switchTime:800
        })
    }

    //好礼抢先拿选项卡切换更多链接
    tabHref();
    function tabHref(){
      $('.prize-last-wrap .j_tab').mouseover(function(){
        var href = $(this).attr('data-href');
        $('.prize-last-wrap .hw-common-more').attr('href',href);
      })
    }
})
seajs.use(["index/tabs"])
