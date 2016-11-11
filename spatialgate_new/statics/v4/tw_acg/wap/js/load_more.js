define('hw/load', ['handlebars','jquery'], function(require, exports, module) {
    var Handlebars = require("handlebars");
    var $ = jquery = jQuery = require("jquery");
 	
    
	/*var pagenum;
	if($('#news').val() !== undefined){
		pagenum = 3;
	}else{
		pagenum = 6;
	}*/
    // var page = 1;
    var aTpl = '{{#each this}}<li>\
					<a href="{{url}}" class="fl">\
						<img class="fl" src="{{thumb}}" alt="{{title}}">\
						<p>{{title}}</p>\
					</a>\
				</li>{{/each}}',
		iTpl = '{{#each this}}<li>\
					<a href="{{url}}">\
						<img src="{{thumb}}" alt="{{title}}">\
						<p><span>{{title}}</span></p>\
					</a>\
				</li>{{/each}}';
				
	
	var oTpl = {
		"news_list":aTpl,
		"photo":iTpl,
		"news_tag":aTpl
    }
    var sLock = true;//ajax lock;  
	
    var renderTpl = function(data,tpl){
        var myTemplate = Handlebars.compile( tpl );
        var renderEle = myTemplate(data);
        $(".append").append(renderEle);
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
            data:{"catid":catid,"page":page},
            type:"GET",
            dataType:"json",
            success:function(data){
				if(data.length == 0){
					$(".load_more span").html("親，已無更多數據");
					$(".load_more").off().css('background-color','#ccc');
				}else{
					sLock = true;
					callback(data,oTpl[tplEle]);
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
    loadHand($(".load_more"));
	
    if (typeof module != "undefined" && module.exports) {
        //module.exports = carouse;
    }
	
	
	
});

seajs.use(['hw/load'])
