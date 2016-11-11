<div class="carouse-wrap clearfix w720 mb10">
	{if $slide_id}
	<div class="carouse-left fl">
		<ul class=" j_carouse">
		{pc M=partition action=partition_contents partid=$slide_id makeurl=1 fields='id,catid,url,title,inputtime,thumb' nums=$slide_nums}
			{foreach $data as $val}
			<li>
				<a href="{$val.url}">
					<img src="{qiniuthumb($val.thumb,640,360)}" alt="{$val.title}">
				</a>
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
	{/if}
	{if $news_arr}
	<div class="carouse-right fr">
		<ul class="gonggao-list">
		{pc M=partition action=partition_contents partid=$news_arr makeurl=1 fields='id,catid,url,title,inputtime,thumb' nums=8}
			{foreach $data as $val}
			<li>
				<a href="{$val.url}">{$val.title}</a>
				<span>{date("m-d", $val.inputtime)}</span>
			</li>
			{/foreach}
		{/pc}
		</ul>
		<a href="{get_part_url($news_arr)}" class="look-more">
			查看更多<em>></em>
		</a>
	</div>
	{/if}
</div>
{require name="tw_tyong:statics/css/carouse.css"}
