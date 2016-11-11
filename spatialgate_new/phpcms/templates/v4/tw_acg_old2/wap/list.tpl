{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base.tpl'}

{block name="head"}
    {$smarty.block.parent}
    <script>
        var SURL = "{$smarty.const.APP_PATH}index.php?m=content&c=index&a=ajax_lists";
		var tplEle = "news_list";
        var catid = '{$smarty.get.catid}'; 
        var page = 4;
    </script>
{/block}

{block name='content'}
    <div class="m-content">
    	{*热门新闻*}
        {include file="tw_acg/widget/wap/hots_list.tpl"}
        {*文章列表*}
        {include file="tw_acg/widget/wap/news_list.tpl"}
	 </div>
{/block}

{block name='footer'}

{/block}
