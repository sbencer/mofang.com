define("loadmore/common",["jquery", "mfe/wapLoadMore"],function(require, exports, module) {
	var $ = require("jquery");
    var loadmore = require("mfe/wapLoadMore");

    var _this = $(".list-load-more");
    var url = $(_this).attr("Url-data");
    var catid = $(_this).attr("Catid-data");
    var pagenum = $(_this).attr("Pagenum-data") ? $(_this).attr("Pagenum-data") : 5;
    var currpage = $(_this).attr("Currpage-data") ? $(_this).attr("Currpage-data") : 1;
    var tpl = $(_this).attr("Tpl-data");
    var box = $(_this).siblings();
    $(_this).loadMore({
        obj: box,
        insertMode:'append',
        data:{
            catid:catid,
            pagesize:pagenum,
            currpage:currpage,
            tpl:tpl
        },
        ajaxData:{
            url:url,
            dataType:'json'
        }
    });
});
seajs.use("loadmore/common");
