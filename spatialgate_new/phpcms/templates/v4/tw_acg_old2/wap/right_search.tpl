<!-- {*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base_test.tpl'}
{block name='content'}
    <div class="m-content">
        <div class="icon-menu" style="right:0; left:auto;">menu</div>
        <div class="icon-search" style="left:0">search</div>
    	{*热门搜索*}
        {include file="tw_acg/widget/wap/right_search.tpl"}
        {include file="tw_acg/widget/wap/classify.tpl"}
	 </div>
{/block} -->
{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base_test.tpl'}
{block name='content'}
    <div class="m-content">
        {*热门搜索*}
        {include file="tw_acg/widget/wap/right_search.tpl"}
    </div>
{/block}