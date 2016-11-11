var MF = MF || {};
var o = 1;
MF = {
	folding:function(isOpen){
		var shareObj = $(".share_box");
		var shareList = $(".share_list li");
		var shareBtn = $(".share_box p");

		if(isOpen){
			shareList.slice(3).hide();
			shareBtn.removeClass("close_btn").addClass("open_btn");
			o = 0;
		}
		else{
			shareList.slice(3).show();
			shareBtn.removeClass("open_btn").addClass("close_btn");
			o = 1;
		}
	},
	grade: function(tagObj, isSendData){
        var gradeObj = $(tagObj);
        var ca = "active";

        gradeObj.bind("mouseover", function(){
            var _index = $(this).index()+1;
            gradeObj.removeClass(ca).slice(0, _index).addClass(ca);
        });

        gradeObj.bind("mouseout", function(){
            gradeObj.removeClass(ca);
        });

        gradeObj.bind("click", function(){
            var _ind = $(this).index();
            var getAttrData = gradeObj.eq(_ind).attr("score-data");     // 获取选中的自定义属性score-data的值
            gradeObj.unbind("mouseover");
            gradeObj.unbind("mouseout");
            gradeObj.unbind("click");
            console.log(getAttrData);

            // ajax请求服务器....
            if(isSendData){
                 $.ajax({
                     url:"" + getAttrData,
                     type : "get",
                     dataType:"",
                     success : function(data){
                         $("#scoreBox").html(data + "人评分");
                     }
                 });
            }
            else{
               $("#setGrade").val(getAttrData);
            }
        })
	},
	gotoTop: function(){
        $('html,body').animate({scrollTop:0}, {duration: 1000});
	},
	overtab: function(obj,centext){
		var childs = $(obj);
		childs.mouseover(function(){
			var _index = $(this).index();
			var _jt = $(centext);

			for(var i=0; i<childs.length; i++){
				childs.eq(i).removeClass("current");
			}
			$(this).addClass("current");
			_jt.hide().eq(_index).show();
		});
	},
	tab: function(obj,centext){
		var childs = $(obj);
		childs.click(function(){
			var _index = $(this).index();
			var _jt = $(centext);

			for(var i=0; i<childs.length; i++){
				childs.eq(i).removeClass("current");
			}
			$(this).addClass("current");
			_jt.hide().eq(_index).show();
		});
	},
    search: function(){     // 搜索
        $("#mfSearch").focus(function(){
            var prompt = "试试搜索游戏名或类型";
            if($(this).val() == prompt){
                $(this).val("");
                $(this).addClass("font03").focus();
            }
        });

        $("#mfSearch").blur(function(){
            if($(this).val() === ""){
                $(this).val("试试搜索游戏名或类型");
                $(this).removeClass("font03");
            }
        });

        $("#mfSearch").keyup(function(e){
            var getKeyCode = e.keyCode;
            var searchURL = "";         // 关键字地址
            if(getKeyCode === 13){
                window.location.href = searchURL + $(this).val();
            }
        })
    }
};

/**
 * @info: 焦点图
 */
;(function($){
    $.fn.FocusPicFader = function(options){
        var o = $.extend({
            nodes: "li",    // 图片节点
            texts: "p",     // title节点
            navs: "span",   // 按钮节点
            initial:0,      // 初始位置
            activeClass:"current",  // 按钮焦点class名
            fx:"fader",     // 效果 "fader"淡入淡出
            event: "mouseover",  // "click" 点击, mouseover 移入
            autoTime:2000   // 定时播放时间
        }, options);

        return this.each(function(){
            var _this = this;
            var _node = $(o.nodes, _this);
            var _texts = $(o.texts, _this);
            var _navs = $(o.navs, _this);
            var _len = _navs.length;
            var current = o.initial;
            var timer = null;

            var init = function(){  // 初始化
                _node.eq(o.initial).css({"z-index": 5}).fadeIn("slow");
                _texts.eq(o.initial).css({"z-index": 5}).fadeIn("slow");
                _navs.eq(o.initial).addClass("current");
            };
            init();

            var picRun = function(num){
                current = num;
                if(current > _len-1){
                    current = 0;
                    picRun(current);
                }
                else{
                    _navs.removeClass(o.activeClass).eq(num).addClass(o.activeClass);
                    _texts.fadeOut().eq(num).fadeIn("slow");
                    //_node.css("z-index",3).eq(num).css("z-index", 5);
                    _node.fadeOut().eq(num).fadeIn("slow");
                }
            };

            _navs.bind(o.event, function(){
                var index = $(this).index();
                picRun(index);
            });

            timer = setInterval(function(){
                current++;
                picRun(current);
            }, o.autoTime);

            _node.hover(function(){
                clearInterval(timer);
            },function(){
                timer = setInterval(function(){
                    current++;
                    picRun(current);
                }, o.autoTime);
            });

            _navs.hover(function(){
                clearInterval(timer);
            },function(){
                timer = setInterval(function(){
                    current++;
                    picRun(current);
                }, o.autoTime);
            });
        })
    }
})(jQuery);
