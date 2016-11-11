<div class="con_nav">
	<a href="{partition_url()}">首頁</a>
	{if $smarty.get.a == 'lists'}
	<em style="margin-left: 8px;"> > </em>
	<em style="margin-left: 8px;"> 列表頁</em>
	{elseif $smarty.get.a == 'show'}
	<em style="margin-left: 8px;"> > </em>
	<em style="margin-left: 8px;"> 詳情頁</em>
	{/if} 
	{if $is_search}
	<div class="uk-search fr">
    	
		<form action="http://{$smarty.server.SERVER_NAME}/{$smarty.get.p}/search/"  method="get" id="search">
        
			<input type="text" class="search-ipt" name="q" value="搜尋專區攻略資訊" autocomplete="off" onFocus="if(value==defaultValue){ this.value='' }" onBlur="if(value=='') this.value=defaultValue">
		<button></button>	
		</form>
	</div>
	{/if}
</div>

{require name="tw_tyong:statics/css/common/bread.css"}
