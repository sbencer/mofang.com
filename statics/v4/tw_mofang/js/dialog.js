define("article/dialog", ["jquery",'jquery/bxslider'], function(require, exports, module) {

	var $ = require("jquery");
	
    var dialog = function(option){

        var setting = {
            dialogTpl:"",
            closeBtn:"",
            autoHtime:"",
            autoStime:""
        };
        this.diaEle = $("<div>").addClass("j_dialog dialog-wrap");
        setting_ = option?$.extend(true,setting,option):setting;
        this.setting =setting_;
        $(this.setting.dialogTpl).appendTo(this.diaEle)
        this.init();

    };
    dialog.prototype = {
        creatMask:function(){
            if(!$("mask").length)
            var maskEle = $("<div>").addClass('mask');
            var wS = this.screenSize();
            maskEle.css({
                "height":Math.max(wS.h,wS.dh),
                "width":Math.max(wS.w,wS.dw)
            });
            return this.maskEle=maskEle;
        },
        showDialog:function(){
            var dialogTpl =$(this.diaEle);
            this.creatMask();
            this.rendEle();
            this.setPosition();
            this.maskEle.fadeIn(400);
            dialogTpl.fadeIn(600);
        },
        hideDialog:function(){
            var dialogTpl = this.diaEle;
            var this_ = this;
            this.maskEle.fadeOut(400,function(){
                this_.removeDialog();
            });
            $(dialogTpl).fadeOut(600);
        },
        removeDialog:function(){
            $(this.maskEle).remove();
            $(this.diaEle).remove();
        },
        screenSize:function(){
            var o = null;
            var h = $(window).height();//$(document).width() 区别在于 低版本浏览器不会把滚动条算在里面
            var w = $(window).width();
            var dh = $(document).height();
            var dw = $(document).width();
            var 
            o ={
                h:h,
                w:w,
                dh:dh,
                dw:dw
            };
            return o;
        },
        setPosition:function(){
            var o = this.screenSize();
            var diaEle = this.diaEle;
            var scroTop = $(document).scrollTop();

            var dw = diaEle.outerWidth(),
                dh = diaEle.outerHeight();
            var pos = {
                t:(o.h-dh)/2+scroTop,
                l:(o.w-dw)/2
            };
            diaEle.css({
                top:pos.t,
                left:pos.l
            });
        },
        rendEle:function(){
            var diaEle = this.diaEle;
            diaEle.appendTo("body").hide();
            if(!$(".mask").length)
            this.maskEle.appendTo('body').hide();
        },
        handBind:function(flag){
            var closeBtn = $(this.setting.closeBtn);
            var this_ = this;
            $(window).on("resize",function(){
                this_.rePosition();
            })
            $(window).on("scroll",function(){
                if(this_.diaEle.height()<$(window).height())
                this_.rePosition();
            })
            $(document).on("click",this.setting.closeBtn,function(){
                this_.hideDialog();
            });
        },
        rePosition:function(){
            return this.setPosition();
        },
        autoHide:function(){
            var this_ = this;
            if(this.setting.autoHtime!=""){
                setTimeout(function(){
                   this_.hideDialog.call(this_)
                },this.setting.autoHtime);
            }
        },
       // autoShow:function(){
        //    var this_ = this;
        //    if(this.setting.autoHtime!=""){
       //         setTimeout(function(){
       //            this_.hideDialog.call(this_)
       //         },this.setting.autoHtime);
       //     }
       // },
        init:function(){ 
            this.autoHide();
            this.handBind();
            this.showDialog();
        }
    }
    if (typeof module != "undefined" && module.exports) {
        module.exports = dialog;
    }
})
// define("a/d",["jquery","article/dialog"],function(require, exports, module){
//     var $ = require("jquery");
//     var dialog = require("article/dialog");
//     var tpl = "";
    
//     $(".dialog-btn").on("click",function(){
//         var dia = new dialog({
//             dialogTpl:".j_dialog",
//             closeBtn:".j_close"
//         })
//         return false;
//     })
// })
// seajs.use(["a/d"]);
