{*
    **************************************************
    * --> 移动端公共
    **************************************************
    *  顶部导航条
    *  友情链接部分
    *  版权信息
    **************************************************
    *  main              : 主体区域
    *  t_link            : 友情链接
    *  footer            : 页面底部
    ***************************************************
    *  2015/4/23
    *  Eilvein
*}

{extends file='common/wap/doc.tpl'}

{* 标题 *}
{block name=title}{strip}
    {if $SEO.title}
        {$SEO.title}
    {else}
        {$SEO.site_title}
    {/if}
{/strip}{/block}

{* 关键词 *}
{block name=keywords}{strip}
    {$SEO.keyword}
{/strip}{/block}

{* 页面描述 *}
{block name=description}{strip}
    {$SEO.description}
{/strip}{/block}

{block name=body}
    {$smarty.block.parent}
    {require name="common:statics/js/m/m-config.js"}

    {* 头部*}
    {block name=header}
    {/block}

    {* 全局通用seed　*}

    {* 主体区域 *}
    {block name=main}

    {/block}

    {* 友情链接 *}
    {block name=t_link}
    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}

    {/block}

    {* 统计 *}
    <div style="display:none;">
        {block name="statistical"}
            {$statistical_code}
        {/block}
        <script type="text/javascript">
            var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fc010118fc9ccb89ca3c38b4808b4dd4e' type='text/javascript'%3E%3C/script%3E"));
        </script>
    </div>
    {* share *}
<script>
 function is_weixin(){
    var ua = navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i)=="micromessenger") {
        return true;
    } else {
        return false;
    }
};
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
