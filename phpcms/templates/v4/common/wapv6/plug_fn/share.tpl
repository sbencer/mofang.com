{* 这是分享框插件 *}
{require name="common:statics/css/wapv6/common.css"}
<div class="share-menu">
    <div class="share-list">
        <p class="pop-play-close close"></p>
        {block name=datashare}
        <p><a href="javascript:mfshare('qzone','')" class="zone-share"></a><em>QQ空间</em></p>
        <p><a href="javascript:;" class="weixin-share"></a><em>微信</em></p>
        <p><a href="javascript:mfshare('weibo','')" class="weibo-share"></a><em>新浪微博</em></p>
       	<p><a href="javascript:mfshare('baidu','')" class="baidu-share"></a><em>百度</em></p>
       	{/block}
    </div>
    <div class="cancel-btn">取 消</div>
</div>
<div class="share-weixin-pop">
    <span class="pop-msg"></span>
</div>

