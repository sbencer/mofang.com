{*

    *************************
    *  活动页面
    *************************
    *  所有移动端活动页面从此页面继承
    *
    *  wapv6/huodong -> wapv6/doctype
    *
    * main 子页面区域
    *
    *************************
*}
{extends file='common/wapv6/doctype.tpl'}

{block name=body}
    {block name="mfyxb-hd"}
    {*魔方游戏宝微信头*}
    <div id="J_header" class="mfyxb-header" style="position:fixed;width:100%;top:0;left:0;z-index:10000;">
        <img src="/statics/v4/common/img/wapv6/weixin/yxb_banner.jpg" alt="魔方游戏宝" style="width:100%;display:block;">
        <a id="btn_download_mfyxb" href="http://app.mofang.com/yxb/download?pf=android" class="once-down" style="display: block;color: #ff7800;border-radius: 4px;text-align: center;width: 165px;height: 70px;line-height: 35px;font-size: 14px;position: absolute;right: 3%;top: 12%;background-color: none;background-image: url(/statics/v4/common/img/wapv6/weixin/btn_down.png);background-position: center;background-repeat: no-repeat;text-indent: -99999px;overflow: hidden;-webkit-background-size: contain;background-size: contain;">立即下载</a>
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
    function inMfyxb(){
        if(SIMULATE_API){
            return true;
        }
        var ua = navigator.userAgent.toLowerCase();
        if(/mfyxb/i.test(ua)) {
            return true;
        } else {
            return false;
        }
        return true;
    }
    //是否在微信内
    function is_weixin(){
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            return true;
        } else {
            return false;
        }
    }

    //是否显示mfyxb header
    function mfyxbDownShow () {
        var node = document.getElementById("J_header");
        if(!node){
            return false;
        }
        if(inMfyxb()){
            node.parentNode.removeChild(node);
        }else{
            node.style.display = "block";
        }
    }

    mfyxbDownShow();

    (function(){

        var jiaHeader = document.getElementById("J_header");
        if(!jiaHeader){
            return false;
        }

        var btn = document.getElementById("btn_download_mfyxb");
        var bd = document.body;
        var ss = btn.style;
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
        window.onresize = r;
        document.onscroll = function(){
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
        };
        r();
    })();
    </script>
    {/literal}

    {$smarty.block.parent}

    {block name=main}

    {/block}
    

{/block}

