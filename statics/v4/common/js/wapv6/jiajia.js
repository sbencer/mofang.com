/**
 * 加加下载提示，页面微信分享
 */
define('m/jiajia',[], function(require, exports, module){

    var SIMULATE_API = 0;

    // 判断是否在加加内
    function inJiajia() {
        if (SIMULATE_API) {
            return true;
        }
        var ua = navigator.userAgent.toLowerCase();
        if (/jiajia/i.test(ua)) {
            return true;
        } else {
            return false;
        }
        return true;
    }

    function is_weixin() {
        var ua = navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == "micromessenger") {
            return true;
        } else {
            return false;
        }
    }

    //是否显示jiajia header
    function jiajiaDownShow() {
        var tip = document.getElementById("jiajia-download-tip");
        var s = tip.style;
        !inJiajia() ? s.display = 'block' : s.display = "none";
    }

    jiajiaDownShow();

    // 微信分享处理
    if (is_weixin()) {

        var share_url = wx_share_url;
        var share_img = wx_share_img;
        var share_title = wx_share_title || document.title;
        var share_content = wx_share_content;

        function onBridgeReady() {
            //转发朋友圈
            WeixinJSBridge.on("menu:share:timeline", function(e) {
                var url = share_url;
                var data = {
                    img_url: share_img,
                    img_width: "120",
                    img_height: "120",
                    link: url,
                    //desc这个属性要加上，虽然不会显示，但是不加暂时会导致无法转发至朋友圈，
                    desc: share_content,
                    title: share_title
                };
                WeixinJSBridge.invoke("shareTimeline", data, function(res) {
                    WeixinJSBridge.log(res.err_msg);
                });
            });
            //同步到微博
            WeixinJSBridge.on("menu:share:weibo", function() {
                var url = share_url;
                WeixinJSBridge.invoke("shareWeibo", {
                    "content": share_content,
                    "url": url
                }, function(res) {
                    WeixinJSBridge.log(res.err_msg);
                });
            });
            //分享给朋友
            WeixinJSBridge.on('menu:share:appmessage', function(argv) {
                var url = share_url;
                WeixinJSBridge.invoke("sendAppMessage", {
                    img_url: share_img,
                    img_width: "120",
                    img_height: "120",
                    link: url,
                    desc: share_content,
                    title: share_title
                }, function(res) {
                    WeixinJSBridge.log(res.err_msg);
                });
            });
        };
        document.addEventListener('WeixinJSBridgeReady', function() {
            onBridgeReady();
        });
    }
    module.exports = {
        inJiaJia :inJiajia,
        inWeixin:is_weixin
    };
});
seajs.use("m/jiajia");
