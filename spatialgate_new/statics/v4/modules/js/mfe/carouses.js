
/*
*  @author : gaohaohao
*  @email  : gaohaohao@mofang.com
*  example：
*      seajs.use("carouses", function(carouses) {
*           var carouses = new carouses({
*
*	      		carouEle: ".lunbo",
*	    		nextBtn: ".next-btn",
*        		prevBtn: ".prev-btn",
*        		eventType: "mouseover",
*        		element: ".lunbo-wrap"
*
*        	}).render()
*      });
* 参数说明：
*	carouEle:运动的元素。
*	prevBtn: 向前按钮
*	nextBtn: 向后按钮
*	eventType:显示当前为哪个焦点元素绑定的事件
*	activeIndex:加载时显示第几张图片，从1开始。一般不需要重置
*	speed:图片运动的速度
*	autoplay:自动轮播是true，反之是false。默认为true
* */

define('carouses',['jquery','widget'],function(require, exports, module){

	var $ = require("jquery"),
	Widget = require("widget");

	var carouse = Widget.extend({

		attrs: {

			carouEle: { //carouEle
				value: ".lunbo"
			},

			prevBtn: {
				value: ""
			},

			nextBtn: {
				value: ".pre-btn"
			},

			eventType: {
            	value: "mouseover"
            },

			activeIndex: {
				value: 1
			},
			speed:"500",
			//controls: "true",
			autoplay: true
		},
			
		initProps: function  () {

			var temEle = null,
			carouEle = $(this.get('carouEle')),
			eleNum = carouEle.children().length,
			hoverBtn = $("<div class='car-btn'></div>"),
			first_ele_clone = carouEle.children().eq(0).clone(true),
			last_ele_clone = carouEle.children(':last-child').clone(true);

			for (var i = 0; i < eleNum; i++) {
				if ( i==0 ) {
					temEle = $("<span class='active hoverEle'></span>");
					temEle.appendTo(hoverBtn);	
				}else{
					temEle = $('<span class="hoverEle"></span>');
					temEle.appendTo(hoverBtn);
				};
				
			};

			hoverBtn.appendTo(carouEle.parent().parent());
			first_ele_clone.appendTo(carouEle);
			last_ele_clone.prependTo(carouEle);

		},

		events: function  () { //events

			var events = {},
			eventType = this.get('eventType'),

			eventsBtn = eventType + ' .hoverEle',
			eventsPele = "click " + this.get('prevBtn'),
			eventsNele = "click " + this.get('nextBtn');

			events[eventsPele] = '_switchToPre';
			events[eventsNele] = '_switchToNext';
			events[eventsBtn] = '_switchHover';
			//console.log(events);
			return events;

		},

		

		_onRenderActiveIndex: function  (val,prev) {

			var carouEle = $(this.get('carouEle')),
			eleWid = carouEle.children().width(),
			eleNum = carouEle.children().length;
			direction = null;
			speed = this.get('speed');
			
			if( val == eleNum-2 && prev == 1 ){ //当运动到第一个时

				carouEle.stop().animate({ left: 0*eleWid }, speed,
					function  () {
					//debugger
					carouEle.css({left: -(val+1)*eleWid});
				});
				

			}else if(val == 1 && prev == eleNum-2 ){ //当运动到最后一个时

				carouEle.stop().animate({ left: -(eleNum-1)*eleWid }, speed,
					function () {
					carouEle.css({left: -1*eleWid})
				});
			
			}else{

				carouEle.stop().animate({ left: -val*eleWid }, speed)

			};
			$('.hoverEle').removeClass('active');
			val--;
			$('.hoverEle').eq(val).addClass('active');

		},

		//点击向前按钮
		_switchToPre: function  () {
			//debugger;
			clearTimeout(this._temp);
			var index = this.get('activeIndex'),
			_this = this;
			index--;
			this.switchTo(index);
			this._temp = setTimeout(function(){_this.autoplay()},4000)

		},
		//向后点击
		_switchToNext: function  () {

			clearTimeout(this._temp);
			var index = this.get('activeIndex'),
			_this = this;
			//debugger;
			index++;
			this.switchTo(index);
			this._temp = setTimeout(function(){_this.autoplay()},4000)

		},
		//btn hover
		_switchHover: function(ev){

			clearTimeout(this._temp)
			_this = this;
			var index = $(".car-btn .hoverEle").index(ev.target);
			index++;
			this.switchTo(index);
			this._temp = setTimeout(function(){_this.autoplay()},4000)

		},

		//自动轮播
		autoplay: function () {

			clearTimeout(this._temp);
			var auto = this.get("autoplay");
			if( !auto ){
				return;
			}
			var _this = this;
			this._temp = setTimeout(function(){
				$(_this.get('nextBtn')).trigger('click');
			},3000);

		},

		switchTo: function  (index) {
			
			var carouEle = $(this.get('carouEle')),
			eleNum = carouEle.children().length;
			//debugger;
			if( index == 0 ){
				this.set("activeIndex", eleNum-2);
			}else if( index == eleNum-1 ){
				this.set("activeIndex", 1);
			}else{
				this.set("activeIndex", index)
			}

		},
		// 实例化最后一步，用户自定义操作，提供给子类继承。
		setup: function(){
			
			var carouEle = $(this.get('carouEle')),
			son_hei = carouEle.children().height(),
			son_wid = carouEle.children().width();

			carouEle.css({
				width: 100000,
				height: son_hei,
				overflow: 'hidden',
				position: 'absolute',
				left: -son_wid
			});
			carouEle.children().css({
				float: 'left'
			});
			this.autoplay();
		}
	});
	
	if (typeof module!="undefined" && module.exports ) {
	    module.exports = carouse;
	}
});
