<div class="detail">
	<div class="detail-title">
		<h2>{$title}</h2>
		{foreach $keywords as $keyword}
		{if $keyword}<span>【<a href="{tag($keyword)}">{$keyword}</a>】</span>{/if}
		{/foreach}
		<ul class="clearfix">
			<li>
				<h3>作者 : {$authorname|default:$username}</h3>
				<h3>時間 : {date("Y-m-d", $rs.updatetime)}</h3>
				<h3 class="bg_img">{get_views("c-{$modelid}-{$id}")}</h3>
			</li>
			<li>
				<span>分享到:</span>
				<a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));" class="fb"></a>
				<a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" class="tw"></a>
				<a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" class="gp"></a>
				<a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));" class="pu"></a>
			</li>
		</ul>
	</div>
	<div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div>
	<div class="detail-con">
		{$content}
	</div>
	<div class="detail-share">
		<div class="share-con">
			<ul class="clearfix">
				<span>分享到:</span>
				<li><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));" class="fac"></a></li>
				<li><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" class="twi"></a></li>
				<li><a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" class="goo"></a></li>
				<li><a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));" class="pol"></a></li>
			</ul>
			<div class="auto-bt">
				<a href="{$smarty.const.APP_PATH}" class="return-head">回站台首頁</a>
				<a href="mailto:acgmofang@mofang.com.tw" class="infor-mes">情報投稿信箱</a>
				<a href="{cat_url($catid)}" class="return-list">回主題列表</a>
			</div>
			<div class="bt-pot clearfix">
				<a href="{$previous_page['url']}" class="bt-left">< < 上一篇<p>{$previous_page['title']}</p></a>
				<a href="{$next_page['url']}" class="bt-right">下一篇 > ><p>{$next_page['title']}</p></a>
			</div>
		</div>
	</div>
	<div class="detail-comments">	
		<div class="title">
			<h2>留下你的回應吧！</h2>
		</div>
		<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.5&appId=1500638963557330";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-comments" data-href="{$url}" data-width="725" data-numposts="5"></div>
	</div>
	<div class="detail-sort">
		<div class="title">
			<h2>相關分類</h2>
		</div>
		<ul class="clearfix">
		{pc module="content" action="types" typeid=$typeid}
			{foreach $data as $val}
			<li>
				<a href="{$smarty.const.APP_PATH}/index.php?m=content&c=tag&catid={$catid}&tag={$val.name}">{$val.name}（{$val.total}）</a>
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
	<div class="detail-read">
		<div class="title">
			<h2>延伸閱讀</h2>
		</div>
		<ul class="clearfix">
		{pc module="content" action="relation" relation=$relation id=$rs['id'] catid=$catid num="10" keywords=$keywords}
        	{foreach $data as $val}
			<li>
				<a href="{$val.url}"><img src="{qiniuthumb($val.thumb, 260, 146)}">
					<span>{$val.title}</span>
				</a>
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
</div>

{require name="tw_acg:statics/css/detail.css"}