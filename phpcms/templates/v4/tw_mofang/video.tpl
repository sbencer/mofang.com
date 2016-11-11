{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}

{block name="main-content"}
<div class="hw-main-content">
    <div class="hw-main-common w1000_nb mb10">
        {* carouse *}
        {include file="tw_mofang/widget/video/carouse.tpl"}
    </div>
    <div class="hw-main-common w1000 mb10">
        {* 人氣閱讀 *}
        {include file="tw_mofang/widget/video/hot_read.tpl"}
    </div>
    <div class="hw-main-common w1000 mb10">
        {* hot author *}
        {include file="tw_mofang/widget/video/moke.tpl"}
    </div>
    <div class="hw-main-common w1000 mb10">
        {* 網絡精選 *}
        {include file="tw_mofang/widget/video/network.tpl"}
    </div>
    <div class="hw-main-common w1000 mb10">
        {* 遊戲評鑑 *}
        {include file="tw_mofang/widget/video/game_ce.tpl"}
    </div>
</div>
{/block}
