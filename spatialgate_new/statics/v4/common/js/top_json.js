/*
 * 专区导航
 */
define('zhuanqu/nav',['jquery','handlebars'],function(require,exports,module){

	var Handlebars = require("handlebars"),
		$ = jquery = require("jquery");

	var IS_JSONP = 0;

	var JSONSTYLE = 'jsonp';

	if(!IS_JSONP){
		JSONSTYLE="json";
	};
	//要传入的参数
	var data_nav = {};
	//模板
	var nav_templ = '{{#each this}}<div class="top-meun-list fl"><a href="javascript:void()" target=_blank class=wd-orange>{{name}}</a>{{#each info}}<a href="{{url}}" target=_blank>{{name}}</a>{{/each}}</div>{{/each}}';
	//请求json数据
	$.ajax({
		url:'http://www.mofang.com/index.php?m=prefecture_nav4&c=index&a=json_lists',
		type:"GET",
		dataType:'jsonp',
		success:function(data){
			var data_ = null;
			if(typeof data == "string"){
				data_ = JSON.parse(data);
			}else{
				data_ = data;
			}
			data_nav = {
				ele:".top-menu-wrap",
				data:data_,
				myTemplate:nav_templ
			};
			mapRender(null,data_nav);
		},
		error:function(data){
			console.log(data);
		}
	});
	//回调函数
	var mapRender = function(err,option){
		if(err){
			return false;
		};
		var nav_templ = option.myTemplate,
			eleRender = option.ele,
			data_tem = option.data;
		var myTemplate = Handlebars.compile(nav_templ);
	    //将json对象用刚刚注册的Handlebars模版封装，得到最终的html，插入到基础table中。
	    $(eleRender).html(myTemplate(data_tem));
        return true;
	};
	/////////////////// export module ////////////////////////
	if (typeof module!="undefined" && module.exports ) {
	}
});
seajs.use(["zhuanqu/nav"]);
