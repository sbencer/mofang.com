<div class="hw-carouse-wrap mb10">
	<div class="hw-carouse-header clearfix mb10">
		{*<div class="hw-header-list">
		{pc M=content action=category catid=10000050 num=25 siteid=$siteid order='listorder ASC'}
			<a href="{cat_url(10000050)}" target="_blank">綜合</a>
			{foreach $data as $val}
			<a href="{$val.url}" target="_blank">{$val.catname}</a>
			{/foreach}
			<a href="{cat_url(10000111)}" target="_blank">事前登錄</a>
			<a href="{cat_url(10000149)}" class="curr" target="_blank">ChinaJoy 2015</a>
		{/pc}
		</div>*}
	</div>
	<div class="hw-carouse-con clearfix">
		{pc M=content action=position posid=10000007 order='listorder desc, id desc' num=4}
		<div class="carouse-con-left fl">
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
				<div class="pic-detail-li j_pic_li pic-detail" style="display:none;">
					<h4>{$val.title}</h4>
					<span class="pic-author">作者：<em>{$val.username}</em></span>
					<p>{$val.description}</p>
				</div>
				{/foreach}
			</div>
			<div class="pic-detail-wrap j_detail">
				<div class="pic-detail">
				{foreach $data as $val}
					{if $val@first}
					<h4>{$val.title}</h4>
					<span class="pic-author">作者：<em>{$val.username}</em></span>
					<p>{$val.description}</p>
					{/if}
				{/foreach}
				</div>
			</div>*}
		</div>
		{/pc}
		<div class="carouse-con-right fr">
		{pc M=content action=position posid=10000008 order='listorder desc, id desc' num=2}
			{foreach $data as $val}
			<div class="car-con-rig-li">
				<a href="{$val.url}" target="_blank">
					<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
					<p>{$val.title}</p>
				</a>
			</div>
			{/foreach}
		{/pc}
		</div>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/carouse.css"}
{require name="tw_mofang:statics/js/carouse.js"}
