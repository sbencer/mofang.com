{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}
{block name="bread"}
{/block}
{block name="main-content"}
<div class="j_left hw-main-content mb20">
    <div class="prefecture-con">
        <div class="hw-prefecture-top mb10">
            {* 熱門專區 *}
            {include file="tw_mofang/widget/prefecture/hot_pre.tpl"}
            {* 熱門專區列表 *}
            {include file="tw_mofang/widget/prefecture/hot_pre_bttm.tpl"}
        </div>
        <div class="hw-prefecture-bttm">
            {* 新遊專區 *}
            {include file="tw_mofang/widget/prefecture/new_game_pre.tpl"}
        </div>
    </div>
</div>
{/block}
{block name='sidebar'}
    {*側邊欄*}
    {include file="tw_mofang/widget/common/sidebar.tpl"}
    {require name="tw_mofang:statics/css/article/dialog.css"}
{/block}






