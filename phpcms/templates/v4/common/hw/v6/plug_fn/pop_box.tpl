{* 这是V6的弹出框插件 *}
{* 
 * 弹出框插件,wap-pc共用的弹出框
 * @author xukuikui
 * @date 2015-07-6
 * 这个弹出框插件，是pc,m端公用的
  *}
{require name="common:statics/css/hw/v6/pop_box.css"}
<!-- 弹出框开始 -->
<!-- 遮罩层开始 -->
<!-- <div class="mask-bg">
    
</div> -->
<!-- 遮罩层结束 -->

<!--未登录-->
<div class="pop pop-play pop-login">
    <p class="pop-play-close"><img src="/statics/v4/common/img/hw/v6/pop_close.png" height="16" width="16" class="close"></p>
    <p class="pop-play-word pop-msg">未登录？</p>
    <p class="clearfix">
        <input type="button" class="pop-play-cancel pop-cancel" value="取消">
        <input type="button" class="pop-play-ok pop-ok" value="前往登录">
    </p>
</div>
<!-- 发帖失败 -->
<div class="pop pop-play pop-warn">
    <p class="pop-play-close"><img src="/statics/v4/common/img/hw/v6/pop_close.png" class="close"></p>
    <p class="pop-play-word pop-msg">突破经典的飞行射击类精品手机游戏。继承了经典飞机大战简单爽快的操作体验，玩法更多样。这么好玩的游戏，确定不玩吗？</p>
</div>
<!-- 成功 -->
<div class="pop pop-post-ok">   
    <img src="/statics/v4/common/img/hw/v6/pop_ok.png" height="37" width="38"><span class="pop-msg">成功</span>
</div>
<!-- 失败 -->
<div class="pop pop-top-fail">
    <img src="/statics/v4/common/img/hw/v6/pop_fail.png" height="37" width="38"><span class="pop-msg">失败</span>
</div>
<!-- 弹出框结束 -->
