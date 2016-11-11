{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/base_test.tpl'}
{block name='main'}
        {include file="tw_acg/widget/float_video.tpl"}
        {include file="tw_acg/widget/at_top.tpl"}
        {include file="tw_acg/widget/works.tpl"}
{/block}