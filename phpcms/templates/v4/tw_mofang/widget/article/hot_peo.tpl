
<div class="article-new-tuijian w310 mb10">
	<div class="hw-common-title">
		<h3>新聞推薦</h3>
	</div>
	<div class="hw-common-con">
		<div class="article-new-tablist j_tab_wrap">
			<div class="article-new-tab">
				<span class="curr j_tab">人氣新聞</span>
				<span class="j_tab tab-right">最新新聞</span>
			</div>
			<div class="article-new-tab-con">
				{pc M=content action=hits catid=10000050 day=30 order='views desc' num=10 cache=3600}
				<div class="article-tab-con j_con">
					{foreach $data as $val}
					{if $val@iteration == 1}
					<div class="new-tuijian-li">
						<span class="red fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{elseif $val@iteration == 2}
					<div class="new-tuijian-li">
						<span class="orange fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{elseif $val@iteration == 3}
					<div class="new-tuijian-li">
						<span class="blue fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{else}
					<div class="new-tuijian-li">
						<span class="grey fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{/if}
					{/foreach}					
				</div>
				{/pc}
				{pc M=content action=lists catid=10000050 order='id desc' num=10 cache=3600}
				<div class="article-tab-con disno j_con">
					{foreach $data as $val}
					{if $val@iteration == 1}
					<div class="new-tuijian-li">
						<span class="red fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{elseif $val@iteration == 2}
					<div class="new-tuijian-li">
						<span class="orange fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{elseif $val@iteration == 3}
					<div class="new-tuijian-li">
						<span class="blue fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{else}
					<div class="new-tuijian-li">
						<span class="grey fl">{$val@iteration}</span>
						<a href="{$val.url}" target="_blank">{$val.title}</a>
					</div>
					{/if}
					{/foreach}		
				</div>
				{/pc}
			</div>
		</div>
	</div>
</div>

{require name="tw_mofang:statics/css/article/hot_peo.css"}
{require name="tw_mofang:statics/js/tab.js"}
