{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base.tpl'}
{block name="head"}
    {$smarty.block.parent}
    <script>
        var SURL = "{$smarty.const.APP_PATH}index.php?m=content&c=tag&ajax=1&tag={$tag}";
        var tplEle = "news_tag";
        var catid = '{$smarty.get.catid}'; 
        var page = 1;
    </script>
{/block}
{block name='content'}
    <div class="m-content">
        {*文章列表*}
        {include file="tw_acg/widget/wap/news_tag.tpl"}
	 </div>
{/block}

{block name='footer'}

{/block}
