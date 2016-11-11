{*

    *************************
    *  移动端doctype定义
    *************************
    *
    *  wap所有模板文件都需从此模板继承
    *
    *  title  : 页面title
    *  head   : 插入到head
    *  body   : 插入到body
    *  keyword
    *  description
    *
    *************************
*}
{* BIGPIPE QUICKLING NOSCRIPT *}
<!doctype html>

{html mode=NOSCRIPT framework="common:statics/js/loader/sea.js" }
{head}
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    {* iphone app *}
    <meta name="apple-itunes-app" content="app-id=1059683792" />
    {* phone numer select *}
    <meta name="format-detection" content="telephone=no" />
    <title>{block name=title}{strip}
        {$title}
    {/strip}{/block}</title>

    <meta name="keywords" content="{block name=keywords}{strip}
        {$keywords}
    {/strip}{/block}">

    <meta name="description" content="{block name=description}{strip}
        {$description}
    {/strip}{/block}">

    {require name="common:statics/css/wapv6/base.css"}
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /> -->
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />
    {* 加加内页接口 *}
    {include file='common/wapv6/plug_fn/mfyxb_api.tpl'}
    {block name="seajs"}
        {if $MFE_USE_COMBO}
            {if $MFE_DEBUG}
                {require name='common:statics/js/loader/sea.js'}
                {require name='common:statics/js/loader/sea/combo.js'}
            {else}
                {require name='common:statics/js/loader/boot.js'}
            {/if}
        {else}
            {require name='common:statics/js/loader/sea.js'}
        {/if}
        {require name='modules:statics/js/sea-config.js'}
        {require name='common:statics/js/wapv6/wap-config.js'}
        {require name='modules:statics/js/mfe/jweixin_1.0.0-config.js'}
    {/block}

    {block name="px2rem"}
        <script>
        (function(w){
            adaptation(750);
            //适配
            function adaptation(size){
                if(document.documentElement.clientWidth>size){
                    document.documentElement.style.fontSize=size/26.66666666+'px';
                }else{
                    document.documentElement.style.fontSize=document.documentElement.clientWidth/26.66666666+'px';
                }
            } 
        })(window);
        </script>
    {/block}
    
    <script>
        
        {* 组件之间调用 *}
        var MFE = {};

        {* 与后台数据交互 *}
        var CONFIG = {};

        {* 是否使用跨子域的登陆方式 *}
        CONFIG['pageId'] = "";
    </script>

    {block name=head}

    {/block}

{/head}

{body}

    {block name=body}
    
    {/block}
    
    {* 微信分享 *}
    {block name=wxshare}
        <script>
        (function(){
         // 微信分享处理
        function is_weixin(){
            var ua = navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i)=="micromessenger") {
                return true;
            } else {
                return false;
            }
        }
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
            var share_url = wx_share_url || window.location.href;
            var share_img = wx_share_img || "";
            var share_title = wx_share_title || document.title;
            var share_content = wx_share_content || document.title;

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
                    };
                wx.ready(function(res){
                      /*wx.hideMenuItems({
                          menuList: [] // 要隐藏的菜单项，所有menu项见附录3
                      });*/
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

{/body}
{/html}
