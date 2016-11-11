{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/wap/base_test.tpl'}
{block name='content'}
    <div class="m-content">
        {* 分类 *}
        {include file="tw_acg/widget/wap/classify.tpl"}
    </div>
{/block}