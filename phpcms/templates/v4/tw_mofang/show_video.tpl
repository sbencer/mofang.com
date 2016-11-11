{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}

{block name="main-content"}
<div class="hw-main-content j_left">
    <div class="video-play-con mb20 clearfix">
        <div class="hw-con-left">
            {* 視頻 *}
            {include file="tw_mofang/widget/video/video_detail.tpl"}
            {* share *}
            {include file="tw_mofang/widget/common/share.tpl"}
            {* 相關視頻 *}
            {include file="tw_mofang/widget/video/related_video.tpl"}
            {* 評論 *}
            {include file="tw_mofang/widget/common/discuss.tpl"}
        </div>
        <div class="hw-con-right">
            {* 右側推薦視頻 *}
            {include file="tw_mofang/widget/video/hot_video.tpl"}
        </div>
    </div>
</div>
<script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}
