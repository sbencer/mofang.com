{* css加载 *}
<style>
    .support-btn { background: url(http://sts0.mofang.com/statics/s/partition/xj/images/zan02_5f0ad074.jpg); height: 181px; width: 200px; display: block;}
    .support-oppose { width:200px; float:left; overflow:hidden;}
    .support-btn:hover { background: url(http://sts0.mofang.com/statics/s/partition/xj/images/zan01_93b16e49.jpg);}
    .oppose-btn { background: url(http://sts0.mofang.com/statics/s/partition/xj/images/zcai02_c94cc10f.jpg); height: 181px; width: 200px; display: block;}
    .oppose-btn:hover { background: url(http://sts0.mofang.com/statics/s/partition/xj/images/zcai01_e5ca61cd.jpg);}
    .mf-commom-vote b { width: 210px; text-align: center; float: left; height: 35px; line-height: 35px; font-size: 14px;}
</style>

{* js加载 *}
{require name="common:statics/js/p/vote.js"}
<div class="mf-commom-vote">
   <div class="support-oppose">
       <a href="javascript:;" class="support-btn" name="{if $smarty.get.catid && $smarty.get.id}{$smarty.get.catid}|{$smarty.get.id}{else}{$data}{/if}"></a>
       <b>共有<i class="support-count">0</i>人赞过</b>
   </div>
   <div class="support-oppose">
       <a href="javascript:;" class="oppose-btn" name="{if $smarty.get.catid && $smarty.get.id}{$smarty.get.catid}|{$smarty.get.id}{else}{$data}{/if}"></a>
       <b>共有<i class="oppose-count">0</i>人踩过</b>
   </div>
</div>

