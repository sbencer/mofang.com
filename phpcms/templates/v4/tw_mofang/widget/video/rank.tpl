<div class="hw-carouse-wrap v-carouse-wrap">
	<div class="hw-carouse-con clearfix">
		<div class="v-carouse-left fl">
		{pc M=content action=position posid=10000006 order='listorder desc, id desc' num=4}
			<div class="carouse-list j_silder">
				{foreach $data as $val}
				<div class="carouse-li">
					<a href="{$val.url}" target="_blank">
						<img src="{qiniuthumb($val.thumb,800,450)}" alt="{$val.title}">
					</a>
				</div>
				{/foreach}
			</div>
			<div class="pic-detail-list j_pic_list" style="display:none;">
				{foreach $data as $val}
				<div class="pic-detail-li j_pic_li pic-detail" style="display:none;">
					<h4>{$val.title}</h4>
					<div class="carouse-game clearfix">
						<a href="{$val.url}" target="_blank" class="fl">
							<img src="http://u.mofang.com/web/account/getuseravatar?uid={get_uid($username)}" alt="{$val.title}">
						</a>
						<span class="pic-author">作者：<em>{$val.username}</em></span>
					</div>
					<p>{$val.description}</p>
				</div>
				{/foreach}
			</div>
			<div class="pic-detail-wrap j_detail">
			{foreach $data as $val}
				{if $val@first}
				<div class="pic-detail">
					<h4>{$val.title}</h4>
					<div class="carouse-game clearfix">
						<a href="{$val.url}" target="_blank" class="fl">
							<img src="http://u.mofang.com/web/account/getuseravatar?uid={get_uid($username)}" alt="{$val.title}">
						</a>
						<span class="pic-author">作者：<em>{$val.username}</em></span>
					</div>
					<p>{$val.description}</p>
				</div>
				{/if}
			{/foreach}
			</div>
		{/pc}
		</div>
		<div class="v-carouse-right fr">
		{pc M=content action=lists catid=10000068 num=1}
			{foreach $data as $val}
			<div class="v-game-relate clearfix mb10">
				<a href="{$val.url}" target="_blank" class="fl">
					<img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}">
				</a>
				<h3><a href="{$val.url}" target="_blank">{$val.title}</a></h3>
				<span class="v-versions">版本：{$val.shortname}</span>
				<div class="v-game-cost">
					<span>費用：<em class="and">免費</em><em class="ios">$14.5</em></span>
				</div>
			</div>
			<p class="v-game-intro">{$val.description}</p>
			<a href="{$val.url}" target="_blank" class="know-more">了解更多詳情</a>	
			{/foreach}
		{/pc}
		</div>
	</div>
</div>
{require name="tw_mofang:statics/css/video/carouse.css"}
{require name="tw_mofang:statics/js/carouse.js"}
