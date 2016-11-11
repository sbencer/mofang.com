<div class="brand">
	<div class="brand-title">
		<h3 class="h3_title">品牌館</h3>
	</div>
	<div class="brand-img" style="float: left;">
		{pc M=content action=lists catid=10000254 order='listorder asc, id desc' num=3}
        	{foreach $data as $val}
			<a href="{$val['url']}"><img src="{$val['thumb']}"></a> 
			{/foreach}
		{/pc}
	</div>
</div>

{require name="tw_mofang:statics/css/v3/brand.css"}