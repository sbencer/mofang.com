{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/base.tpl'}

{block name="head"}
    {$smarty.block.parent}
    <script>
        var SURL = "{$smarty.const.APP_PATH}index.php?m=content&c=index&a=ajax_lists&date_format=1&exp=views";
        var tplEle = "news_list";
        var catid = '{$smarty.get.catid}'; 
        var page = 1;
    </script>
{/block}

{block name='main'}
    {*acg 速报*}
    {include file="tw_acg/widget/top_zixun.tpl"}     

    {block name='infinite_list'}
        {*瀑布流列表页*} 
        {include file="tw_acg/widget/infinite_list.tpl"}  
    {/block}
    {include file="tw_acg/widget/side_fix.tpl"}  
{/block}

