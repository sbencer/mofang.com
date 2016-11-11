{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base.tpl'}
{block name='content'}
    <div class="m-content">
    	{*相關分類資訊*}
        {include file="tw_acg/widget/wap/sort_list.tpl"}
    </div>
{/block}
{block name='footer'}
{/block}