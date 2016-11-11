{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}
{block name='main'}
	{block name="main-content"}
		<div class="hw-main-content">
		    {* 事前登陸 *}
		    {include file="tw_mofang/widget/bef_login/login_list.tpl"}
		    {*include file="tw_mofang/widget/bef_login/login_notice.tpl"*}
		    {*include file="tw_mofang/widget/bef_login/login_mess.tpl"*}
		</div>
	{/block}
{/block}
{block name='tongji'}
    {$smarty.block.parent}
    {include file="tw_mofang/widget/common/analyticstracking.tpl"}
{/block}
