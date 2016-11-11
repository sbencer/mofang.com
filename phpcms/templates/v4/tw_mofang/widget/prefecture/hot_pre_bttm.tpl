<div class="hot-pre-bttm clearfix">
	<div class="hot-pre-bttm-wrap clearfix">
	{pc M=content action=position posid=10000010 order='listorder desc, id desc' num=5}
		{foreach $data as $val}
		<div class="hot-pre-bttm-li">
			<a href="{$val.url}" target="_blank" class="imgarea">
				<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
			</a>
			<div class="txtarea">
				<h3><a href="{$val.url}" target="_blank">{$val.title}</a></h3>
				<p>{$val.description}</p>
				<a href="{$val.url}" target="_blank" class="enter-pre">進入專區</a>
			</div>
		</div>
		{/foreach}
	{/pc}
	</div>
</div>
{require name="tw_mofang:statics/css/prefecture/hot_pre_bttm.css"}

