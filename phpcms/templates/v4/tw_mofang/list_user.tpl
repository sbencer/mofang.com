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
<div class="hw-main-content j_left">
    <div class="hw-main-common w1000 mb10">
        {* list top *}
        {include file="tw_mofang/widget/user/top_list.tpl"}
    </div>
    <div class="user-list-con mb20 clearfix">
        <div class="article-con-left fl">
            {* 作者簡介 *}
            {include file="tw_mofang/widget/user/author_intro.tpl"}
            {* 游戏新闻 *}
            {include file="tw_mofang/widget/user/game_new.tpl"}
        </div>
        
        {* new 推荐 *}
        {include file="tw_mofang/widget/article/article_con_right.tpl"}
    </div>
</div>
{/block}
{block name="sidebar"}
{*側邊欄*}
    {include file="tw_mofang/widget/common/sidebar.tpl"}
{/block}
