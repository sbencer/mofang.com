{*

    *************************
    *  活动页面
    *************************
    *  所有移动端活动页面从此页面继承
    *
    *  m_huodong -> m_doctype
    *
    * main 子页面区域
    *
    *************************
*}
{extends file='common/hw/m_base.tpl'}

{block name=body}
    {require name="common:statics/css/v1/m_base.css"}
    {require name="jiajia_weixin_tw:statics/css/m_base.css"}
    {require name="jiajia_weixin_tw:statics/css/header_load.css"}
    {block name="jiajia-hd"}
    {*加加微信头*}
    <div id="J_header" class="jiajia-header" style="position:fixed;width:100%;top:0;left:0;z-index:10000;">
        <!--<div class="load-btn">
            <a href="http://goo.gl/G2tRn4" class="and-btn">and下载</a>
            <a href="http://x.co/6Tqyq" class="ios-btn">ios下载</a>
        </div>-->
        <div class="load_btn">
            <a href="http://x.co/6Tqyq" class="ios_btn">ios下载</a>
        	<a href="http://goo.gl/G2tRn4" class="android_btn">android下载</a>
        </div>
        <img src="http://pic2.mofang.com/376/210/fb3fe95189d20b4a7899d48e0da32554f69c98ae" alt="魔方游戏宝">
    </div>
    {/block}
    {literal}
    <style>
    .simple-shadow{
        box-shadow: 0px 3px 5px rgba(0,0,0,0.4);
    }
    </style>
    <script>

        var SIMULATE_API = 0;

        // 判断是否在加加内
        function inJiajia(){
            if(SIMULATE_API){
                return true;
            }
            var ua = navigator.userAgent.toLowerCase();
            if(/jiajia/i.test(ua)) {
                return true;
            } else {
                return false;
            }
            return true;
        }

        function is_weixin(){
            var ua = navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i)=="micromessenger") {
                return true;
            } else {
                return false;
            }
        }

        //是否显示jiajia header
        function jiajiaDownShow () {
            var node = document.getElementById("J_header");
            if(!node){
                return false;
            }
            if(inJiajia()){
                node.parentNode.removeChild(node);
            }else{
                node.style.display = "block";
            }
        }

        jiajiaDownShow();

        (function(){

            var jiaHeader = document.getElementById("J_header");
            if(!jiaHeader){
                return false;
            }

           var btn = document.getElementById("btn_download_jiajia");
            var bd = document.body;
            //var ss = btn.style;
            function r(){
                var ww = jiaHeader.offsetWidth;
                var radius = 165/640;
                var radius2 = 98/640;
                var r2 = 70/165;
                var wn = ww * radius;
                ss.width = wn + "px";
                ss.height = wn * r2 + "px";
                var pt = (ww * radius2);
                bd.style.paddingTop =  pt + "px";
            }
           // window.onresize = r;
           /* document.onscroll = function(){
                var header = document.getElementById("J_header");
                if(document.body.scrollTop > 10){
                    var ncls = header.getAttribute("class");
                    if(ncls.indexOf('simple-shadow')==-1){
                        header.setAttribute("class",ncls + " simple-shadow");
                    }
                }else{
                    var ncls = header.getAttribute("class");
                    ncls = ncls.replace("simple-shadow","");
                    header.setAttribute("class",ncls);
                }
            }*/
           // r();
           // r();
           // r();
        })();
    </script>
    {/literal}

        {$smarty.block.parent}

    {block name=huodong}

    {/block}

    <script>

        // 微信分享处理
        if(is_weixin()){

            var share_url = wx_share_url;
            var share_img = wx_share_img;
            var share_title = wx_share_title || document.title ;
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
                        title:share_title
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
    </script>
{/block}
