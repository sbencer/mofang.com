{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/base.tpl'}

{block name=head}
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta property="fb:app_id" content="" />
    <meta property="og:type"   content="article" />
    <meta property="og:url"    content="{trim($url)}" />
    <meta property="og:title"  content="{$title}" />
    <meta property="og:image"  content="{$thumb}" />
    <meta property="og:description"  content="{$description}" />
    {$smarty.block.parent}
{/block}

{block name='main'}
    <div class="sort">
    	<div class="sort_left">
    		{*内容页文章内容*}
    		{include file="tw_acg/widget/detail.tpl"}
    		{*相关内容*}
    	</div>
        <div class="sort_right">
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
    <script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}
