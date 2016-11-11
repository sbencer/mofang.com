/**
 *拖拽插件
 *@author xukuikui
 *@date 2015-1-14
 */
define('jquery/sliderMf', ['jquery'], function(require, exports, module){

    var $ = require("jquery");
    var jQuery = $;
    //拖拽插件
    ;(function($){
        $.fn.sliderMf=function(data){
            var defaults={
                renderTo: $(document.body),//某个容器,剩下的所有元素都在这个容器里面
                direction: 'default',//lr左右滑动，tb上下滑动,
                bur: '.bur',//滑动按钮
                burLine: '.bur-line',//进度条
                burSlider: '.slider',//满格的进度条
                burHover: 'bur-cur',//鼠标放上去，进度条的样式
                onChanging: function(){//滑动中执行的函数 返回滑动物体_this
                },
                onChanged: function(){//滑动结束执行的函数，返回滑动物体_this
                },
                value:{
                    maxValue:10,//最大的值
                    minValue:0,//最小的值
                    curValue:0//当前的值
                },
                burIsDis:''//是否改变滑动按钮的值
            };
            data=$.extend(true,defaults,data);

            var w=$(data.renderTo).find(data.burSlider).width()-$(data.renderTo).find(data.bur).width();// 滑动的宽度
            var h=$(data.renderTo).find(data.burSlider).width()-$(data.renderTo).find(data.bur).width();// 滑动的高度

            var oneW = w/data.value.maxValue;// 一个单位的宽度
            var oneH = h/data.value.maxValue;// 一个单位的高度

            startValue();
            function startValue(){// 初始化的效果
                if(data.burIsDis){
                    var burVal =  parseFloat(data.value.curValue);
                    if(data.value.maxValue<=1){
                        $(data.renderTo).find(data.bur).html(burVal.toFixed(2));
                    }else{
                        $(data.renderTo).find(data.bur).html(burVal);
                    } 
                }
                $(data.renderTo).find(data.bur).css({
                    left:(data.value.curValue/data.value.maxValue*w)+'px'
                });
                $(data.renderTo).find(data.burLine).css({
                    width:(data.value.curValue/data.value.maxValue*w)+'px'
                });
                
            }
            $(data.renderTo).find(data.bur).mousedown(function(event) {// 鼠标点击滑动物体按下
                $(this).addClass(data.burHover);
                var disX = event.pageX-$(this).position().left;
                var disY = event.pageY-$(this).position().top;
                var _this = this;
                $(document).bind('mousemove.myEvent',function(event) {
                    var l=event.pageX-disX;
                    var t=event.pageY-disY;

                    l<0 && (l=0);
                    t<0 && (t=0);

                    l>w && (l=w);
                    t>h && (t=h);

                    var lCurV=Math.floor(l/oneW);
                    var tCurV=Math.floor(t/oneH);
                    
                    if(data.value.maxValue<=1){
                        lCurV=parseFloat(l/oneW).toFixed(2);
                        tCurV=parseFloat(t/oneH).toFixed(2);
                    }
                    switch(data.direction){
                        case 'lr':
                            $(_this).css({
                                left: l+'px'
                            });
                            $(data.renderTo).find(data.burLine).css({
                                width: l+'px'
                            });
                            if(data.burIsDis){
                               $(data.renderTo).find(data.bur).html(lCurV); 
                            }
                        break;
                        case 'tb':
                            $(_this).css({
                                top: t+'px'
                            });
                            $(data.renderTo).find(data.burLine).css({
                                height: t+'px'
                            });
                            if(data.burIsDis){
                                $(data.renderTo).find(data.bur).html(tCurV);
                            }
                        break;

                        case 'default':
                            $(_this).css({
                                left: l+'px',
                                top: t+'px'
                            });
                            $(data.renderTo).find(data.burLine).css({
                                width: l+'px',
                                 height: t+'px'
                            });
                            if(data.burIsDis){
                               $(data.renderTo).find(data.bur).html(lCurV+'-'+tCurV);  
                            }
                    }
                    data.onChanging(_this);
                    
                });

                $(document).bind('mouseup.myEvent',function(event) {
                    $(document).unbind('mousemove.myEvent');
                    $(document).unbind('mouseup.myEvent');

                    data.onChanged(_this);
                   
                });
                return false;
            });
        };
    })(jQuery);

    if (typeof module!="undefined" && module.exports ) {
        module.exports = $;
    }

});
