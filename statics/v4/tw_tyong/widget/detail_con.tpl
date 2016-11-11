<div class="detail-con mb10">
	<div class="article-title">
		<h3>{$rs.title}</h3>
		<div class="article-pos">
			{foreach $keywords as $keyword}
			<span>【{$keyword}】</span>
			{/foreach}
		</div>
		<div class="article-autor">
			<span>作者：{if $rs.outhorname}{$rs.outhorname}{else}{$username}{/if}</span>
			<span>時間：{date('Y-m-d', $rs.inputtime)}</span>
		</div>
		<div style="float:left;margin:-20px 140px 0 0;width:300px;">
			<div class="fb-like" data-href="{$comment_article_url}" data-send="true" data-show-faces="false" data-width="120" data-layout="button_count" data-share="false" data-action="recommend"></div>
			<div class="g-plusone" data-size="medium" data-href="{$comment_article_url}"></div>
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="{$comment_article_url}"></a>
		</div>

	</div>
	<div class="article-con">
		{if $youtube_id}
		<iframe width="660" height="370" src="https://www.youtube.com/embed/{$youtube_id}" frameborder="0" allowfullscreen></iframe>
		{/if}

		{$content}
		
	</div>
</div>

<div class="newlist">
	<div class="newlist-top">
		<h3>相關內容</h3>
	</div>
	<ul>
	{foreach $relate_article_array as $v}                          
		<li>
			<a href="{$v.url}"> 
				<i></i>
				{$v.title}
			</a>
		</li>
	{/foreach}
	</ul>
</div>

<div class="w720s">
	<div id="fb-root"></div>
    <div class="fb-comments" data-href="{$comment_article_url}" data-numposts="5" data-colorscheme="light" data-width="700"></div>
</div>

{literal}
	<!-- facebook sdk -->
	<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.3&appId=1500638963557330";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- twitter sdk -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<!-- twitter sdk -->
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
{/literal}
{require name="tw_tyong:statics/css/detail_con.css"}
