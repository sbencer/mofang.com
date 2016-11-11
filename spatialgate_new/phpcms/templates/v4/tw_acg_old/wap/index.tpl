{*
    base            : seajs
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base.tpl'}
{block name='content'}
    <div class="m-content">
        {* 轮播图 *}
        {include file="tw_acg/widget/wap/swipe_slider.tpl"}
        {*new图片*}
        {include file="tw_acg/widget/wap/picture.tpl"}
        {*首页list*}
        {include file="tw_acg/widget/wap/news.tpl"}
        {*排行榜*}
        {*include file="tw_acg/widget/wap/ranking.tpl"*}
        {*日历*}
        {include file="tw_acg/widget/wap/calendar.tpl"}
        {*热门搜索*}
        {include file="tw_acg/widget/wap/hot_search.tpl"}
        {*活动详情*}
        {*include file="tw_acg/widget/wap/activity_alert.tpl"*}
    </div>
{/block}
