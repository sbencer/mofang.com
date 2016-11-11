{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/base.tpl'}

{block name='main'}
	{*列表页*} 
    <div class="sort">
    	<div class="sort_left">
    		{*广告位and列表*}
    		{include file="tw_acg/widget/search.tpl"}
    	</div>
        <div class="sort_right">
            {*次元话题*}
            {include file="tw_acg/widget/acg_topic.tpl"}
            <div class="row-white"></div>
            {*次元讨论入口 关键字*}
            {include file="tw_acg/widget/entrance.tpl"}
            {*人气排行*}
            {include file="tw_acg/widget/ranking.tpl"}
            {*也別錯過這裏的情報哦！*}
            {include file="tw_acg/widget/miss_information.tpl"}
            {*热门推荐大图*}
            {include file="tw_acg/widget/game_introduce.tpl"}
        </div>
    </div>
{/block}
