{extends file='common/v5/site.tpl'}

{* 在head添加内容 *}
{block name=head}

    {if !$smarty.get.ptest}
	{$pp=''}
    {else}
	{$pp='/statics/s_test/partition/luobo2/'}
    {/if}

    {$smarty.block.parent}
    {* 头信息插入位置 *}
    {block name=phead}
    {/block}
{/block}

{* 主体区域 *}
{block name=main}
    {* css 插入位置 *}
    {block name=pcss}
    {/block}

    {* 主体区域 *}
    {block name=pmain}
    {/block}

    {* js插入位置 *}
    {block name=pjs}
    {/block}
{/block}

