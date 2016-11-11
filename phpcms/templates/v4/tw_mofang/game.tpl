{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}

{block name="main-content"}
<div class="hw-main-content j_left">
    <div class="game-recommend mb10">
        {include file="tw_mofang/widget/game/game_recom.tpl"}
    </div>
    <div class="game-product-con mb20 clearfix">
        <div class="hw-con-left">
            {* 遊戲簡介 *}
            {include file="tw_mofang/widget/game/game_intro.tpl"}
            {* 遊戲圖片 *}
            {include file="tw_mofang/widget/game/game_pic.tpl"}
            {* 分享 *}
            {include file="tw_mofang/widget/common/share.tpl"}
            {* 延伸閱讀 *}
            {include file="tw_mofang/widget/article/extend_read.tpl"}
            {* 相關影片 *}
            {include file="tw_mofang/widget/game/relev_movie.tpl"}
            {* 評論 *}
            {include file="tw_mofang/widget/common/discuss.tpl"}
        </div>
        <div class="hw-con-right">
            {* 右側推薦視頻 *}
            {include file="tw_mofang/widget/game/game_prefecture.tpl"}
            {* 禮包 *}
            {include file="tw_mofang/widget/article/mf_prize.tpl"}
            {* 攻略助手 *}
            {include file="tw_mofang/widget/game/mf_app.tpl"}
        </div>
    </div>
</div>
{/block}
