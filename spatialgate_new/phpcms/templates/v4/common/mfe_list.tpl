{extends file="common/seajs_base.tpl"}

{block name=body}

	<style type="text/css" media="screen">
	  .dir_list li{
	  list-style:circle;
	  }
	</style>
    <ul class="dir_list">
	  	{if !$noup}
        	<li><a href="?tpl={$up}">...</a></li>
		{/if}
        {foreach from=$mfe_list item=item}
        <li><a href="?tpl={$item}">{$item}</a></li>
        {/foreach}
    </ul>
    {if !$mfe_list}
        mfe 支撑模板,请勿继承此模板
    {/if}
    {* widget name='common:widget/sina.tpl' mode='QUICKLING' pagelet_id='' group='sina' *}
{/block}
