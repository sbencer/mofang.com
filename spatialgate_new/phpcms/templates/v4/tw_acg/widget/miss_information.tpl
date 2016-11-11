{if $posid}
<div class="miss_info">	
	<div class="title">
		<h2>也別錯過這裏的情報哦！</h2>
	</div>
	<ul>
	{pc M="content" action="position" posid=$posid order="listorder DESC" thumb="1" num="5"}
        {foreach $data as $val}
		<li>
			<a href="{$val.url}">
				<img src="{qiniuthumb($val.thumb, 320, 180)}">
				<span>{$val.title}</span>
			</a>
		</li>
		{/foreach}
	{/pc}
	</ul>
</div>
{/if}
{require name="tw_acg:statics/css/detail.css"}