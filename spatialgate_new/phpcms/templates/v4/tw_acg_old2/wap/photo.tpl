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
        var tplEle = "photo";
        var catid = '{$smarty.get.catid}';
        var page = 1;
    </script>
{/block}
{block name='content'}
    <div class="m-content">
        {include file="tw_acg/widget/wap/photo.tpl"}
    </div>
{/block}
{block name='footer'}

{/block}