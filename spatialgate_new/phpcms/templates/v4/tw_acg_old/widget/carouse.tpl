<div class="carouse-con-left fl">
	<div class="carouse-list j_silder">
	{pc module="content" action="position" posid="18" order="listorder DESC" thumb="1" num="5"}
		{foreach $data as $val}
		<div class="carouse-li">
			<a href="{$val.url}" target="_blank">
				<img src="{qiniuthumb($val.thumb,800,450)}" alt="">
                <p>
                	<span>{$val.title}</span>
                	{trim($val.description)}
                </p>
			</a>
		</div>
		{/foreach}
	{/pc}
	</div>
</div>
{require name="tw_acg:statics/css/carouse.css"}
{require name="tw_acg:statics/js/carouse.js"} 

