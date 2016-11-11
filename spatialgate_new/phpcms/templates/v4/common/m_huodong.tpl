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
{extends file='common/m_base.tpl'}

{block name=body}
    {* 微信分享api *}
     {require name='modules:statics/js/mfe/jweixin_1.0.0-config.js'}
        {* require('modules:statics/js/mfe/jweixin_1.0.0.js'); *}
    {block name="jiajia-hd"}
    {*加加微信头*}
    <div id="J_header" class="jiajia-header" style="position:fixed;width:100%;top:0;left:0;z-index:10000;">
        <img src="/statics/v4/common/img/weixin/yxb_banner.jpg" alt="魔方游戏宝">
        <a id="btn_download_jiajia" href="http://app.mofang.com/yxb/download?pf=android" class="once-down">立即下载</a>
    </div>
    {/block}
    {literal}
    <style>
    .simple-shadow{
        box-shadow: 0px 3px 5px rgba(0,0,0,0.4);
    }
    </style>
    <script>
    //分享
    var wx_share_url= "";
    var wx_share_img= "";
    var wx_share_title=document.title;
    var wx_share_content="";
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
            }
            r();
            r();
            r();
        })();
    </script>
    {/literal}

	{$smarty.block.parent}

    {block name=huodong}

    {/block}
    
<script>
(function(){
 // 微信分享处理
if(is_weixin()){

    var wxAppId = "{$signPackage['appId']}";
    var wxTimestamp = "{$signPackage['timestamp']}";
    var wxNonceStr = "{$signPackage['nonceStr']}";
    var wxSignature = "{$signPackage['signature']}";

    wx.config({
    debug: false,
    appId: wxAppId,
    timestamp: parseFloat(wxTimestamp),
    nonceStr: wxNonceStr,
    signature: wxSignature,
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'onMenuShareTimeline',
      'onMenuShareAppMessage'
    ]
    });
    var share_url = wx_share_url || "";
    var share_img = wx_share_img || "";
    var share_title = wx_share_title || document.title;
    var share_content = wx_share_content || "";

   //分享
    function share(param){
        var _param = {
                title : param.title,// 分享标题
                link : param.link,// 分享链接
                imgUrl : param.imgUrl,// 分享图标
                desc : param.desc,// 分享描述,分享给朋友时用
                type : param.type,// 分享类型,music、video或link，不填默认为link,分享给朋友时用
                dataUrl : param.dataUrl, // 如果type是music或video，则要提供数据链接，默认为空,分享给朋友时用
                calback:param.calback//分享回调
            }
            wx.ready(function(res){
                  wx.hideMenuItems({
                      menuList: ['menuItem:openWithSafari','menuItem:share:brand'] // 要隐藏的菜单项，所有menu项见附录3
                  });
                  //校验分享接口是否可用
                  wx.checkJsApi({
                      jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','hideMenuItems'],
                      success: function(res) {
                          if((res.checkResult.onMenuShareTimeline=!!false) || (res.checkResult.onMenuShareAppMessage=!!false)){
                              return false;
                          }
                      }
                  });
                  //分享到朋友圈
                  wx.onMenuShareTimeline({
                      title : _param.title,
                      link : _param.link,
                      imgUrl : _param.imgUrl, 
                      success : function (res) { 
                          // 用户确认分享后执行的回调函数
                          _param.calback();

                      },
                      cancel: function (res) { 
                          // 用户取消分享后执行的回调函数
                      }
                  });
                  //分享给朋友
                  wx.onMenuShareAppMessage({
                      title : _param.title, 
                      desc : _param.desc, 
                      link : _param.link, 
                      imgUrl : _param.imgUrl, 
                      type : _param.type, 
                      dataUrl : _param.dataUrl, 
                      success : function (res) { 
                          // 用户确认分享后执行的回调函数
                          _param.calback();
                      },
                      cancel: function (res) { 
                          // 用户取消分享后执行的回调函数
                      }
                  });
            }); 
    }   
    document.addEventListener('WeixinJSBridgeReady', function() {
        var share_param = {
            title:share_title,
            desc:share_content,
            link: share_url,
            imgUrl: share_img,
            type:'',
            dataUrl:'',
            calback:function(){
              console.log("分享回调");
            }
        };  
        //分享调用
        share(share_param);
    });
} 
})();

    
</script>
{/block}

