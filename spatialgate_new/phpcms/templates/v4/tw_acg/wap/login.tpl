{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base_test.tpl'}
{block name='content'}
    <div class="m-content">
    	{*热门搜索*}
        {include file="tw_acg/widget/wap/login.tpl"}
	 </div>
{/block}