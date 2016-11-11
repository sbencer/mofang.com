<div class="video-box">
	<h3 class="h3_title">影音評測</h3>
	<ul class="evaluating_list">
	{pc M=content action=position posid=10000004 order='listorder desc, id desc' num=6}
		{foreach $data as $val}
		<li>
			<a class="a_img" href="{$val.url}">
				<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
				<span class="player"></span>
				<p>
					<!-- <span class="type orange green blue">動作</span> -->
					{mb_substr($val.title,0,17)}
				</p>
			</a>
		</li>
		{/foreach}
	{/pc}
	</ul>
</div>
{require name="tw_mofang:statics/css/v3/evaluating.css"}