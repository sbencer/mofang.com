{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}
{block name="main-content"}
<div class="hw-main-content j_left">
    <div class="article-list-con mb20 clearfix">
        <div class="hw-con-left">
            {* 文章詳情頁左側 *}
            {include file="tw_mofang/widget/article/article_detail_con.tpl"}
            {* 登陸資訊 *}
            {include file="tw_mofang/widget/bef_login/login_mess.tpl"}
            {* 登陸注意事項 *}
            {include file="tw_mofang/widget/bef_login/login_notice.tpl"}
            {* share *}
            {include file="tw_mofang/widget/common/share.tpl"}
            {* 作者資訊*}
            {include file="tw_mofang/widget/article/author_mess.tpl"}
            {* 延伸閱讀 *}
            {include file="tw_mofang/widget/article/extend_read.tpl"}
            {* 評論 *}
            {include file="tw_mofang/widget/common/discuss.tpl"}
        </div>
        <div class="hw-con-right ">
		{* 新闻推荐 *}
		{include file="tw_mofang/widget/article/hot_peo.tpl"}
		{* 魔方遊戲 *}
		{*include file="tw_mofang/widget/article/mf_game.tpl"*}
		{* 发烧攻略 *}
		{include file="tw_mofang/widget/article/mf_gonglue.tpl"}
		{* 礼包 *}
		{include file="tw_mofang/widget/article/mf_prize.tpl"}
		{* 攻略助手  *}
		{* include file="tw_mofang/widget/game/mf_app.tpl" *}
		{* 美图欣赏 *}
		{* include file="tw_mofang/widget/article/pic_enjoy.tpl" *}
		{* 最新影音 *}
		{include file="tw_mofang/widget/article/last_video.tpl"}
        </div>
    </div>
</div>
<script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}

