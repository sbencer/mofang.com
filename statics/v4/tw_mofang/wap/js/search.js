define('hw/search', ['handlebars','jquery'], function(require, exports, module) {
    var Handlebars = require("handlebars");
    var $ = jquery = jQuery = require("jquery");
    
	/*var pagenum;
	if($('#news').val() !== undefined){
		pagenum = 3;
	}else{
		pagenum = 6;
	}*/
	
    var page = 1;
    var sTpl = '{{#each this}}<li>\
					<a href="{{url}}" class="fl">\
						<img class="fl" src="{{thumb}}" alt="{{title}}">\
						{{title}}\
					</a>\
				</li>{{/each}}';
	
    var sLock = true;//ajax lock;  
	
    var renderTpl = function(data,tpl){
        var myTemplate = Handlebars.compile( tpl );
        var renderEle = myTemplate(data);
        $(".search-content .search_con").append(renderEle);
        return renderEle;
    }
   
    var ajxsFn = function(callback,SearchURL){
        if(!sLock){
            return false;
        }
        sLock = false;
        $.ajax({
            url:SearchURL,
            data:{"page":page},
            type:"GET",
            dataType:"json",
            success:function(data){
				if(data.length == 0){
					$('.search-content .empty').show();
					$('.search_con').html("");
				}else{
					$('.search-content .empty').hide();
					$('.search_con').html("");
				}
				sLock = true;
				callback(data,sTpl);
            },
            error:function(){
                console.log("請求錯誤");
            }
        })
    }
	
	var loadHand = function(eleMore){
        $(eleMore).on("keydown",function(){
			
			if(event.keyCode==13){
				keywords = document.getElementById('search-input').value;
				_SearchURL =SearchURL+keywords;
				console.log(_SearchURL);
				ajxsFn(renderTpl,_SearchURL)
				return false;
			}
        })
    }
    loadHand($("#search-input"));
	
    if (typeof module != "undefined" && module.exports) {
        //module.exports = carouse;
    }
	
	
	
});

seajs.use(['hw/search'])
