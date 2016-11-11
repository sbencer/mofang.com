<div class="extend-read-wrap mb10 w1000">
	<div class="hw-common-title">
		<h3>延伸閱讀</h3>
	</div>
	<div class="hw-common-con">
		<div class="extend-read-con clearfix">
		{if $relation_game_array}
			{pc M=content action=gameinfo_lists catid=$catid gameid=$relation_game_array id=$id num=6 cache=600}{/pc}
		{else}
			{pc M=content action=lists catid=$catid order='id desc' num=6 cache=3600}{/pc}
		{/if}
		{foreach $data as $val}
			<a href="{$val.url}" class="fl" title="{$val.title}">
				<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
				<p>{$val.title}</p>
			</a>
		{/foreach}	
		</div>
	</div>
</div>
{require name="tw_mofang:statics/css/article/extend_read_new.css"}
