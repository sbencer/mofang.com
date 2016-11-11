<div class="hw-carouse-wrap pre-carouse-wrap mb10">
	<div class="hw-common-title">
		<h3>熱門專區</h3>
	</div>
	<div class="hw-carouse-con clearfix">
		<div class="pre-carouse-left fl">
		{pc M=content action=position posid=10000009 order='listorder desc, id desc' num=4}
			<div class="carouse-list j_silder">
				{foreach $data as $val}
				<div class="carouse-li">
					<a href="{$val.url}" target="_blank">
						<img src="{qiniuthumb($val.thumb,800,450)}" alt="{$val.title}">
                        <p>{$val.title}</p>
					</a>
				</div>
				{/foreach}
			</div>
            {*<div class="pic-detail-list j_pic_list" style="display:none;">
				{foreach $data as $val}
				<div class="pic-detail j_pic_li" style="display:none;">
					<div class="carouse-game clearfix">
						<a href="#" class="fl">
							<img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.title}">
						</a>
						<h3><a href="#">{$val.title}</a></h3>
						<span>大小：500M</span>
					</div>
					
					<p>{$val.description}</p>
					<a href="{$val.url}" target="_blank" class="enter-pre">進入專區</a>
				</div>
				{/foreach}
			</div>
			<div class="pic-detail-wrap j_detail">
			{foreach $data as $val}
				{if $val@first}
				<div class="pic-detail">
					<div class="carouse-game clearfix">
						<a href="#" class="fl">
							<img src="{qiniuthumb($val.icon,80,80)}" alt="{$val.title}">
						</a>
						<h3><a href="#">{$val.title}</a></h3>
						<span>大小：500M</span>
					</div>
					
					<p>{$val.description}</p>
					<a href="{$val.url}" target="_blank" class="enter-pre">進入專區</a>
				</div>
				{/if}
			{/foreach}
			</div>*}
		{/pc}
		</div>
		<div class="pre-carouse-right fr">
			<div class="pre-carouse-wrap clearfix">
			{pc M=content action=lists catid=$top_parentid order='listorder desc, id desc' num=6}
				{foreach $data as $val}
				<div class="pre-car-li">
					<a href="{$val.url}" target="_blank" >
						<img src="{qiniuthumb($val.icon,80,80)}" alt="">
						<span class="pre-game-name">{$val.title}</span>
						<span class="pre-enter">進入專區</span>
						{if $val.highlight==1}
						<span class="pre-tag">hot</span>
						{/if}
					</a>
				</div>
				{/foreach}
			{/pc}
			</div>
		</div>
	</div>
</div>
{require name="tw_mofang:statics/css/prefecture/hot_pre.css"}
{require name="tw_mofang:statics/js/carouse.js"}
