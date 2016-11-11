{extends file='tw_tyong/ty_base.tpl'}

{block name="slider_and_live"}
	{include file="tw_tyong/widget/slider.tpl"}
{/block}
{block name="ty-con-left"}
	{include file="tw_tyong/widget/common/wiki.tpl"}
{/block}
{block name="ty-con-right"}
	{include file="tw_tyong/widget/con_right_detail.tpl"}
    <script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}
