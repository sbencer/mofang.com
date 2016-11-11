{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base_test.tpl'}
{block name='content'}
    <div class="m-content">
        {include file="tw_acg/widget/wap/activity.tpl"}
    </div>
    
        <div class="icon-menu"></div>
        <div class="icon-search"></div>
    	{*热门搜索*}
        
{/block}