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
// define(function(require, exports, module){
// 	var $ = require("jquery"),
// 	Widget = require("widget");
	
// 	var scrollTop = Widget.extend({

// 		attr: {
// 			scrollName: '', // Element ID
// 			scrollDistance: 300, // Distance from top/bottom before showing element (px)
// 			scrollFrom: 'top', // 'top' or 'bottom'
// 			scrollSpeed: 300, // Speed back to top (ms)
// 			easingType: 'linear', // Scroll to top easing (see http://easings.net/
// 			activeScroll: 0

// 		},

// 		events: function(){
// 			var events = {},

// 			eventsEle = "click " + this.scrollName;
// 			eventsDoc = "scroll " + "document";
// 			eventsWin = "scroll " + "window";

// 			events[eventsEle] = '_scrollClick';
// 			events[eventsDoc] = '_scrollDoc'
// 			return events;
// 		},

// 		initProps: function () {
			

// 		},

// 		setPosition: function(ele){

// 			ele.css({
// 				position: 'fix',
// 				z-index: 99999
// 			});

// 		},

// 		_onRenderActiveScroll: function () {
			


// 		},

// 		_scrollClick: function () {
// 			this.set(activeScroll,0);
// 		},

// 		_scrollDoc: function (ev) {
// 			var scroDis = this.get('scrollDistance'),
// 			winHei = $(window).height(),
// 			docHei = $(document).height(),      
// 			disTop = $(window).scrollTop();

// 			if( disTop >= scroDis ){
// 				$(this.get('scrollName')).show();
// 			}else if( disTop < scroDis ){
// 				$(this.get('scrollName')).hide();
// 			}
// 			this.set

// 		},

// 		_switchTo: function (num) {
			


// 		},

// 		scrollTop: function () {
		 	


// 		},

// 		setup: function () {
			

// 		}
// 	})
// 	if (typeof module!="undefined" && module.exports ) {
// 	    module.exports = scrollTop;
// 	}
	
// })
