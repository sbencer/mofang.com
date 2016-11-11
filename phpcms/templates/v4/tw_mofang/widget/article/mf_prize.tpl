{if $relation_game}

	{$args['game_id'] = $relation_game}
	{$args['end_time'] = 0}
	{$args['expire'] = 9999999999}
	{$args['appkey'] = 10005}
	{$args['limit'] = 1}


	{$datas = mf_get_fahao($args)}
	{$datas = json_decode($datas,true)}
	
	{if !empty($datas['data'])}
	<div class="mf-prize">
		<div class="hw-common-title">
			<h3>禮包</h3>
		</div>        
		<div class="hw-common-con">
			{foreach $datas['data'] as $val}
	        {if $val@iteration <2}
			<div class="mf-prize-con">
				<div class="game-prize clearfix mb10">
					<a href="{$val.url}" target="_blank" class="fl">
						<img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.game_name}">
					</a>
					<h3><a href="{$val.url}" target="_blank">{$val.name}</a></h3>
					<span><em>{$val.left_count}</em> / {$val.total_count}</span>
					<div class="device-wrap">
						<a href="#" class="and"></a>
						<a href="#" class="ios"></a>
						<a href="#" class="mf"></a>
					</div>
				</div>
				<p class="mf-prize-wd mb10">
					{$val.description}
				</p>
	            <a href="{$val.url}" target="_blank" class="get-prize-btn">領取</a>
			</div>
			{/if}
			{/foreach}
		</div>
	</div>
	{/if}
	{require name="tw_mofang:statics/css/article/mf_prize.css"}
{/if}

