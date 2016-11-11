{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='common/hw/m_base.tpl'}

{block name='body'}
	<div class="wrapper">
	{* header *}
    {block name='content'}
        
    {/block}
    {*footer*}
    {require name="tw_acg:statics/wap/css/g.css"}
    {require name="tw_acg:statics/wap/css/common.css"}
    {require name="tw_acg:statics/wap/js/common.js"}
    </div>
    
{/block}
