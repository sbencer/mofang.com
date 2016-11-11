
{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='common/hw/hw_mf_site_tw.tpl'}
{block name='main'}
<div class="hw-main-wrap j_left">
    <div class="mb20 clearfix">
        <div class="hw-con-left">
            {* pic *}
            {include file="tw_mofang/widget/pic/pic_detail.tpl"}
            {* share *}
            {*include file="tw_mofang/widget/common/share.tpl"*}
            {* 猜你喜欢 *}
            {*include file="tw_mofang/widget/video/related_video.tpl"*}
            {* 評論 *}
            {*include file="tw_mofang/widget/common/discuss.tpl"*}
        </div>
        <div class="hw-con-right">
            {* 右側推薦視頻 *}
            {include file="tw_mofang/widget/pic/hot_pic.tpl"}
        </div>
    </div>
</div>
{require name="tw_mofang:statics/css/hw_common.css"}
{/block}

