define("dialog",['jquery'],function(require, exports, module){

	var $ = require("jquery");

	/*
    example:
     $('.btn').on('click', function() {
    		var _this = $(this);
		$.TipsDialog({
			mask: true, //遮罩层
			multiple: false, //是否实例
			timeout: 2,  //秒
			tipsTitl: "提示标题",
			tipsCont: _this.attr("data-tips"),//提示内容
			autoHide: false, //自动关闭
			closeBack: function (current) {//关闭按钮的回调
				console.log(current)
			}
		});
	});
	*/

	var Tips = function() {
		var that = this,
		body = $(document.body),
		tmpl = $('<div class="j_dialog dialog"><div class="dialog-hd"><h3 class="J_titl">提示信息</h3> <a class="dialog-hd-close J_close" target="_self" href="javascript:;"></a> </div> <div class="dialog-bd J_status"> <div class="dialog-bd-info clearfix"><span class="dialog-bd-status"></span> <span class="dialog-bd-mess">你发表的评论已经成功</span> </div> <p class="dialog-bd-more">不论你是你无牌还是扁平控，不论你走复古风还是爱未来感只要你的创意好</p> </div> <div class="dialog-ft J_ft"> <a class="dialog-ft-btn J_btn J_close"  target="_self" href="javascript:;">确定</a></div></div>');
		ifram = $('<iframe style="position:absolute;top:0;left:0;filter:alpha(opacity=0);z-index:99;"></iframe>');

		//dialog 模板
		this.el = $(tmpl);
		//dialog mask 模板
		this.mask = $('<div class="dialog-mask"></div>');
		this.el.appendTo(body);
		this.mask.appendTo(body);
		this.el.find('.J_btn, .J_close').on('click', function() {
			var isClose = that.closeBack({that:that,self:that.el});
			if(isClose==false){
				return false;
			}
            that.hide($(this));
		});
        this.el.find('.dialog-hd-close').on('click', function() {
            that.headBack(that);
		});
            


	},
	//默认参数
	defaultConfig = {
		mask: true,
		multiple: false,
		timeout: 1.8,
		tipsCont: "提示信息",
		tipsTitl: "提示标题",
		tipsInfo: "请写提示信息",
        tipsWrap: "",
        btnCon:"确定",
		showFooter: true,
		addStyle: false,
		autoHide : true,
		rightImg : false,
		closeBack: function (){},
        headBack: function () {}
	};
	Tips.prototype = {
		init: function(config) {
			this.config = $.extend({},defaultConfig, config);

			this.getXY();
			this.show();
			var jsTipsIcon = this.el.find(".J_status");

			if(this.config.rightImg == "wran") {
				jsTipsIcon.addClass("wran");
			} else if(this.config.rightImg == "error") {
				jsTipsIcon.addClass("error");
			} else {
				jsTipsIcon.removeClass("wran error");
			}
			if(this.config && this.config.tipsCont !="false") {
				this.el.find(".dialog-bd-mess").html(this.config.tipsCont);
			}
			if(this.config && this.config.tipsInfo !="false") {
				this.el.find(".dialog-bd-more").html(this.config.tipsInfo);
			}
			if(this.config && this.config.tipsTitl !="false") {
				this.el.find(".J_titl").html(this.config.tipsTitl);
			}
            if(this.config && this.config.tipsWrap !="") {
				this.el.find(".dialog-bd").html(this.config.tipsWrap);
			}
			if(this.config && this.config.addStyle !="false") {
				this.el.addClass(this.config.addStyle);
			}
			if(this.config && this.config.btnCon !="false") {
				this.el.find(".J_btn").html(this.config.btnCon);
			}
			if (this.config.showFooter) {
                this.el.find(".J_ft").show();
            } else {
                this.el.find(".J_ft").hide();
			}
			if(this.config.autoHide) {
				if (this.config && ! isNaN(this.config.timeout)) {
					clearTimeout(this._globalID);
					this.autoHide();
				}
			}
			return this;
		},
		//获取窗口高宽、滚动条偏移量
		getXY: function() {
			var winObj = $(window),
				doc = $(document),
				self = this,
			win = {
				T: winObj.scrollTop(),
				L: winObj.scrollLeft(),
				H: winObj.height(),
				W: winObj.width()
			},
			doc = {
				H : doc.height(),
				W : doc.width()
			},
			obj = {
				H: this.el.outerHeight(true),
				W: this.el.outerWidth(true),
				L: this.el.offset().left,
				T: this.el.offset().top
			};
			self.el.css({
				left: ((win.W - obj.W) / 2) + win.L,
				top: ((win.H - obj.H) / 2)
			});
			self.mask.css({
				height: Math.max(win.H ,doc.H),
				width: Math.max(win.W, doc.W)
			});
			var ie6=!-[1,]&&!window.XMLHttpRequest;
			if (ie6) {
			ifram.css({"width" : $(this.mask).width(),"height": $(this.mask).height()}).appendTo($(this.mask));
			};
			//if(this.config.size) {
			//winObj.bind("scroll resize",function () {
				////TODO 重新获取brower大小
				//var curTop = $(window).scrollTop(),
					//curWidth = $(window).width(),
					//curLeft = $(window).scrollLeft();
				//if(ie6) {
					//self.el.css({"top" : ((win.H - obj.H) / 2) + curTop});
				//}
				//self.el.css({"left" : ((curWidth - obj.W) / 2) + curLeft});
				//self.mask.css({"width" : curWidth});
			//})
			//}
		},
		autoHide: function() {
			var that = this;
			that._globalID = setTimeout(function() {
				that.hide(that.el.find("J_close"));
			},1000 * that.config.timeout);
		},
		show: function() {
			if (this.config.mask) this.mask.show();
			this.el.fadeIn();
		},
		hide: function(curObj) {
            var that = this;
			if(curObj.hasClass("J_btn")) {
				this.mask.fadeOut();
				this.el.fadeOut();
				clearTimeout(this._globalID);
			} else {
				this.mask.fadeOut();
				this.el.fadeOut();
				clearTimeout(this._globalID);
			}
			//关闭回调函数
			//if(typeof this.config.closeBack !== "undefined") {
				//this.config.closeBack(this.el);
			//}
		},
        closeBack: function (obj) {
			var isClose = this.config.closeBack(obj);
			return isClose;
        },
        headBack: function () {
            var that = this;
			//关闭回调函数
            if(typeof this.config.headBack !== "undefined") {
                this.config.headBack(that);
            }
        }
	};
	var instance = new Tips();

	//$.extend({
		$.fn.TipsDialog = function(config) {
			//实例判断
			var config = config || {};
				configMultiple = config.multiple;

				configMultiple = configMultiple || false;
			if (configMultiple) {
				var i = new Tips();
				return i.init(config);
			} else {
				return instance.init(config);
			}
		}
	//});

	//////////////////// export TipsDialog /////////////
	if (typeof module!="undefined" && module.exports ) {
	    module.exports = $.fn.TipsDialog;
	}
});
