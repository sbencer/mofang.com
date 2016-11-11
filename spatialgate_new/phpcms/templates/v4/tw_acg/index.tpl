{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/base.tpl'}

{block name='main'}
	{*acg 速报*}
    {include file="tw_acg/widget/top_zixun.tpl"}  
    <div class="sort">
    	<div class="sort_left">
    		<div class="carouse-wrap m12 clearfix">
    			{*轮播图*}
    			{include file="tw_acg/widget/carouse.tpl"}
    			{*次元话题*}
    			{include file="tw_acg/widget/acg_topic.tpl"}
    		</div>
    		{*鲜新闻*}
    		{include file="tw_acg/widget/index_news.tpl"}
    	</div>
        <div class="sort_right">
            {*視頻彈窗*}
            {include file="tw_acg/widget/pop_video.tpl"}
            {*关键字*}
            {include file="tw_acg/widget/entrance.tpl"}
            {*活动*}
            {include file="tw_acg/widget/activity.tpl"} 
        </div>
    </div>
    {*广告位*}
    {pc M="content" action="lists" catid="35" order="listorder DESC" thumb="1" num="1"}{/pc}
    {foreach $data as $val}
    <div class="main_banner">
        <a href="{$val.url|default:'javascript:void(0);'}"><img src="{$val.thumb}"></a>
    </div>
    {/foreach}
    <div class="sort">
        <div class="sort_left">
            {*最受关注的情报 活动记事*}
            {include file="tw_acg/widget/most_information.tpl"}
        </div>
        <div class="sort_right">
            {*热门推荐大图*}
            {include file="tw_acg/widget/game_introduce.tpl"}
        </div>
    </div>
    {*精选专栏*}
    {include file="tw_acg/widget/careful_choose.tpl"}
    {*广告位*}
    {pc M="content" action="lists" catid="36" order="listorder DESC" thumb="1" num="1"}{/pc}
    {foreach $data as $val}
    <div class="main_banner">
        <a href="{$val.url|default:'javascript:void(0);'}"><img src="{$val.thumb}"></a>
    </div>
    {/foreach}
    <div class="sort">
    	<div class="sort_left">
    		{*超次元編輯推薦*}
    		{include file="tw_acg/widget/index_recommend.tpl"}
    	</div>
    	<div class="sort_right">
    		{*精彩COS集*}
    		{include file="tw_acg/widget/coser.tpl"}
        </div>
    </div>
{/block}
