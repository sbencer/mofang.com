/*
 * 所有专区 右下角弹出信息
 */
define('p/popup', ['jquery','jquery/easing'], function(require, exports, module) {
    if(window.parent!==window){
        return false;
    }

    var $ = require('jquery');
    var jQuery = $;
    require('jquery/easing');

    (function($) {
        var timer;
        $.fn.src = function(url, onLoad, options) {
            setIFrames($(this), onLoad, options, function() {
                this.src = url;
            });
            return $(this);
        };
        $.fn.squirt = function(content, onLoad, options) {
            setIFrames($(this), onLoad, options, function() {
                var doc = this.contentDocument || this.contentWindow.document;
                doc.open();
                doc.writeln(content);
                doc.close();
            });
            return this;
        };
        function setIFrames(iframes, onLoad, options, iFrameSetter) {
            iframes.each(function() {
                if (this.tagName == "IFRAME") setIFrame(this, onLoad, options, iFrameSetter);
            });
        }
        function setIFrame(iframe, onLoad, options, iFrameSetter) {
            iframe.onload = null;
            if (timer) clearTimeout(timer);

            var defaults = {
                timeoutDuration: 0,
                timeout: null
            };
            var opts = $.extend(defaults, options);
            if (opts.timeout && !opts.timeoutDuration) opts.timeoutDuration = 60000;

            opts.frameactive = true;
            var startTime = (new Date()).getTime();
            if (opts.timeout) {
                var timer = window.setTimeout(function() {
                    opts.frameactive = false;
                    iframe.onload = null;
                    if (opts.timeout) opts.timeout(iframe, opts.timeout);
                }, opts.timeoutDuration);
            };

            var onloadHandler = function() {
                var duration = (new Date()).getTime() - startTime;
                if (timer) window.clearTimeout(timer);
                if (onLoad && opts.frameactive) onLoad.apply(iframe, [duration]);
                opts.frameactive = false;
            };
            iFrameSetter.apply(iframe);
            iframe.onload = onloadHandler;
            opts.completeReadyStateChanges = 0;
            iframe.onreadystatechange = function() { // IE ftw
                if ((++opts.completeReadyStateChanges) == 3)
                    onloadHandler();
            };

            return iframe;
        };

    })(jQuery);

    function Popup() {
        var DEBUG = 0;
        var url = CONFIG.partationPopupUrl;
        var bd = $("body");
        bd.css({
            position:"relative",
            height:"100%",
            overflow:"auto"
        });
        DEBUG && alert(1);
        if(DEBUG){
            url = "http://www.mofang.com/index.php?m=partition&c=index&a=floating&p=sklr";
        }

        var w = 292;
        var h = 334;
        var sp = 30;

        var btnW = 40;
        var btnH = 40;

        var bd = $("body");
        var p = $("<div></div>");
        p.css({
            position: "fixed",
            right: 0,
            bottom: -h-sp,
            width: w,
            height: h,
            zIndex:99999999

        });
        p.appendTo(bd);

        var iframe = $("<iframe></iframe>");
        DEBUG && alert(2);
        iframe.css({
            width:w,
            height:h,
            left:0,
            top:0,
            border:"none",
            zIndex:1,
            position:"absolute"
        });
        iframe.attr('allowTransparency',true);
        iframe.appendTo(p);

        var btnClose = $("<div></div>");
        btnClose.css({
            width:btnW,
            height:btnH,
            left:w - btnW,
            top:0,
            cursor:"pointer",
            zIndex:2,
            position:"absolute"
        });
        btnClose.click(function(){
            hide();
            return false;
        });
        btnClose.appendTo(p);

        // 隐藏图层
        function hide(){
            p.animate({
                bottom:-h -sp
            },2000,"easeOutElastic",function(){
                p.remove();
            });
        }
        // 显示图层
        function show(){
            p.animate({
                bottom:0
            },1000,"easeOutExpo");
        }


        var options = {
          timeout: function() {
              // alert("oops! timed out.");
          },
          timeoutDuration: 30000
        };
        p.hide();
        iframe.src(url, function(){
            setTimeout(function(){
                p.show();
                show();
            },1500);
        }, options);
    }

    setTimeout(function(){
        new Popup();
    },1000);
});
