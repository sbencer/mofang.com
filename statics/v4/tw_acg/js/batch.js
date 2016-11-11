define('acg/batch', ['handlebars','jquery'], function(require, exports, module) {
    var Handlebars = require("handlebars");
    var $ = jquery = jQuery = require("jquery");

    var isTEST = false;
    var SURL = null;
    SURL = "http://www.spatialgate.com.tw/index.php?m=content&c=index&a=ajax_lists&catid=22&pagesize=5";
    if(isTEST){
        SURL = "http://www.dev.spatialgate.com.tw/index.php?m=content&c=index&a=ajax_lists&catid=22&pagesize=5";
    }
    var page = 1;
    var aTpl = '{{#each this}}<li>\
					<a href="{{url}}">\
						<img src="{{thumb}}" alt="{title}">\
                    	<span>{{title}}</span>\
                  	</a>\
				</li>{{/each}}';
    var sLock = true;//ajax lock;

    var renderTpl = function(data,tpl){
        var myTemplate = Handlebars.compile( tpl );
        var renderEle = myTemplate(data);
        $(".news ul").html(renderEle);
        return renderEle;
    }
    
    var ajxFn = function(callback){
        if(!sLock){
            return false;
        }
        sLock = false;
        page++;
        $.ajax({
            url:SURL,
            data:{"page":page},
            type:"GET",
            dataType:"json",
            success:function(data){
                if(data.length == 0){
                    console.log("無更多");
                }else{
                    sLock = true;
                    callback(data,aTpl);
                }
            },
            error:function(){
                console.log("請求錯誤");
            }
        })
    }

    var loadHand = function(eleMore){
        $(eleMore).on("click",function(){
            ajxFn(renderTpl)
            return false;
        })
    }
    loadHand($(".batch"));

    if (typeof module != "undefined" && module.exports) {
        //module.exports = carouse;
    }
});

seajs.use(['acg/batch'])
