{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}
{block name="main-content"}
<div class="hw-main-content">
    <div class="article-list-con mb20">
        <div class="hw-con">
            {* 文章詳情頁左側 *}
            {include file="tw_mofang/widget/article/article_detail_con_new.tpl"}
            {* 登陸資訊 *}
            {include file="tw_mofang/widget/bef_login/login_mess.tpl"}
            {* 登陸注意事項 *}
            {include file="tw_mofang/widget/bef_login/login_notice_new.tpl"}
            {* share *}
            {include file="tw_mofang/widget/common/share_new.tpl"}
            {* 作者資訊*}
            {include file="tw_mofang/widget/article/author_mess_new.tpl"}
            {* 延伸閱讀 *}
            {include file="tw_mofang/widget/article/extend_read_new.tpl"}
            {* 評論 *}
            {include file="tw_mofang/widget/common/discuss_new.tpl"}
        </div>
    </div>
</div>
<script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}

