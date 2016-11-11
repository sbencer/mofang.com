<div class="article-detail-con mb10 w680">
	<div class="article-detail-top">
		<h1>{$title}</h1>
		<div class="article-detail-wrap clearfix">
			<!-- <a href="#" class="fl">
				<img src="http://u.mofang.com.tw/profile/getuseravatar?uid={get_uid($username)}" alt="">
			</a> -->
			<p class="article-author">作者：<a href="{get_user_url($outhorname)}" target="_blank">{if $outhorname}{$outhorname}{else}{$username}{/if}</a>&nbsp;&nbsp;來源：{if $copyfrom}{$copyfrom}{else}魔方網{/if}</p>
			<p class="article-change">更新時間：{$updatetime}</p>
		</div>
	</div>
	<div class="article-detail-con-wrap">
		<div class="key-wd mb20">
			<span>關鍵詞：</span>
			{foreach $keywords as $val}
			<b><a href="{get_search_url($val)}" target="_blank">{$val}</a></b>
			{/foreach}
		</div>
		<div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div>
		{force_balance_tags($content)}
		<div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div>
	</div>
	{if $pages}
	<div class="hw-page">
		{$pages}
		<!-- <a href="" class="prev"></a>
		<a href="#" class="active">1</a>
		<a href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a href="" class="next"></a> -->
	</div>
    {/if}
    {*include file="tw_mofang/widget/common/page.tpl"*}

</div>
{require name="tw_mofang:statics/css/article/article_detail_con.css"}
{require name="tw_mofang:statics/js/cppaste.js"}
{require name="tw_mofang:statics/css/page.css"}
