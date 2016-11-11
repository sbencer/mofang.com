<div class="top_img">
{pc M="content" action="lists" catid=28 order="listorder desc" num="1"}	
	{foreach $data as $val}
	<a href="{$val.url}"><img src="{$val.thumb}" alt="{$val.title}"></a>
	{/foreach}
{/pc}
</div>
<div class="listBox">
	<div class="title">
		<h2>{if $total}“{$keyword}”相關資訊{else}找不到相關文章{/if}</h2>
	</div>
	<div class="news_list">
		<ul class="news_list_ul clearfix">
			{foreach $result as $val}
			<li>
				<a class="fl" href="{$val.url}"><img src="{qiniuthumb($val.thumb,320,180)}" alt="{$val.title}"></a>
				<div class="fr">
					<h4><a href="{$val.url}">{$val.title}</a></h4>
					<p>{$val.description}</p>
					<div class="news_info">
						<span class="icon_horologe">{date("Y年m月d日 H:i", $val.updatetime)}</span>
						<span class="icon_view">瀏覽次數:{get_views("c-{$val.modelid}-{$val.id}")}</span>
						<a class="fr" href="{$val.url}">詳全文</a>
					</div>
					<div class="news_keywords">
						{$keywords=explode(',', $val.keywords)}
						關鍵字：
						{foreach $keywords as $keyword}
							{if $keyword}
								<a href="{tag($keyword)}">{$keyword}</a>
								{if !$keyword@last}/{/if}
							{/if}
						{/foreach}
					</div>
				</div>
			</li>
			{/foreach}
		{/pc}
		</ul>
		<div class="pageBox">
			<div class="pagin">
				{pages($total, $page, 10)}
			</div>
		</div>
	</div>
</div>
{require name="tw_acg:statics/css/list.css"}