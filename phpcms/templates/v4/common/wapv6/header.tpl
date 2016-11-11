<div class="header">
	<div class="nav clearfix">
		<a href="javascript:;" class="menu-l" id="menu"></a>
		<div class="nav-logo">
			<img src="/statics/v4/common/img/wapv6/nav_logo.png" alt="">
		</div>
		<button type="button" class="menu-r"></button>
		{block name=search}
		<div class="search">
			<span class="ser-close-icon"></span>
            {if $smarty.get.q}
                {if isset($smarty.get.type)}
                    {$search_param='/tag/'|cat:$smarty.get.q|cat:'-'|cat:$smarty.get.type|cat:'-1.html'}
                {else}
                    {$search_param='/tag/'|cat:$smarty.get.q|cat:'-news-1.html'}
                {/if}
                {$input_param=''}
            {else}
                {$search_param=''}
                {$input_param='<input type="hidden" name="m" value="search"/><input type="hidden" name="a" value="new_init"/><input type="hidden" name="type" value="news"/>'}
            {/if}
			<form id="formSearch" action="http://m.mofang.com{$search_param}" method="get">
				<input type="submit" class="ser-sub" value=""/>
			    {$input_param}	
				<input type="text" placeholder="" name="q" value="{$smarty.get.q}" class="ser-text"/>
			</form>
		</div>
		{/block}
	</div>	
</div>



