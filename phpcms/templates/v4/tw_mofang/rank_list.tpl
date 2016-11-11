{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}
{block name="ggao"}
{/block}
{block name="bread"}
{/block}
{block name="main-content"}
<div class="hw-main-content j_left">
    <div class="video-play-con mb20 clearfix">
        <div class="hw-con-left">
            {* 游戏排行榜top50 *}
            {include file="tw_mofang/widget/rank/rank_list_left.tpl"}
        </div>
        <div class="hw-con-right">
            {* 事前登錄 *}
            {include file="tw_mofang/widget/rank/bef_login.tpl"}
            {* 發號中心 *}
            {include file="tw_mofang/widget/rank/fahao.tpl"}
            {* 新闻推荐 *}
            {include file="tw_mofang/widget/article/hot_peo.tpl"}
            {* 最新影音 *}
            {include file="tw_mofang/widget/article/last_video.tpl"}
            {* 最新專區 *}
            {include file="tw_mofang/widget/rank/last_zhuan.tpl"}
        </div>
    </div>
</div>
<script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}
{block name='sidebar'}
    {*側邊欄*}
    {include file="tw_mofang/widget/common/sidebar.tpl"}
{/block}
