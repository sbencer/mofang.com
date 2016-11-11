<div class="evaluating">
	<h3 class="h3_title">評測專區</h3>
	<ul class="evaluating_list">
	{pc M=content action=lists catid=10000069 order='listorder desc, id desc' num=3}
		{foreach $data as $val}
		<li>
			<a class="a_img" href="{$val.url}">
				<img src="{qiniuthumb($val.thumb,400,224)}">
				<p>
					<!-- <span class="type orange">動作</span> -->
					{mb_substr($val.title,0,17)}
				</p>
			</a>
			<p class="intro">
				作者：<span>{$val.shortname|default:$val.username}</span><br/>
				{mb_substr($val.description,0,43)}...
			</p>
		</li>
		{/foreach}
	</ul>
</div>
{require name="tw_mofang:statics/css/v3/evaluating.css"}