{if $bbs_id}
<div class="article-new mb10 j_wrap">
	<div class="nav-common title2-bg">
		<a href="http://bbs.mofang.com.tw/forum-{$bbs_id}-1.html" target="_blank" class="more-common fr">更多<em>></em></a>
		{pc M=partition action=bbs_post fid=$bbs_id type=newPost num=4 return=bbs_post}{/pc}
		{pc M=partition action=bbs_post fid=$bbs_id type=newReply num=4 return=bbs_reply}{/pc}
		{pc M=partition action=bbs_post fid=$bbs_id type=weekHots num=4 return=bbs_hots}{/pc}
		<ul class="nav-com-list clearfix j_tabs">
			{if $bbs_post}
			<li class="bg-line">
				<a href="#">最新文章</a>
			</li>
			{/if}
			{if $bbs_reply}
			<li class="bg-line">
				<a href="#">最新回覆</a>
			</li>
			{/if}
			{if $bbs_hots}
			<li>
				<a href="#">熱門文章</a>
			</li>
			{/if}
		</ul>
	</div>
	<div class="common-con">
		<div class="article-new-con">
			<div class="article-new">
				<ul class="article-new-list j_con">
					{foreach $bbs_post as $val}
					<li class="clearfix">
						<a href="http://bbs.mofang.com.tw/thread-{$val.tid}-1-1.html" class="fl img-area" target="_blank">
							<img src="{if $val.attachmentimage}http://bbs.mofang.com.tw/data/attachment/forum/{$val.attachmentimage}{else}{$no_pic}{/if}" alt="{$val.subject}">
						</a>
						<div class="txt-area">
							<h3><a href="http://bbs.mofang.com.tw/thread-{$val.tid}-1-1.html" target="_blank">{$val.subject}</a></h3>
							<time>
								<span>{date("Y-m-d H:i:s", $val.dateline)}</span>
							</time>
							<p>{$val.shortmessage}</p>
							{*<div class="relate-link">
								<a href="#">宮廷Q轉</a>
								<a href="#">攻略</a>
							</div>*}
						</div>
					</li>
					{/foreach}
				</ul>
			</div>
			<div class="article-new" style="display:none;">
				<ul class="article-new-list j_con">
					{foreach $bbs_reply as $val}
					<li class="clearfix">
						<a href="http://bbs.mofang.com.tw/thread-{$val.tid}-1-1.html" class="fl img-area" target="_blank">
							<img src="{if $val.attachmentimage}http://bbs.mofang.com.tw/data/attachment/forum/{$val.attachmentimage}{else}{$no_pic}{/if}" alt="{$val.subject}">
						</a>
						<div class="txt-area">
							<h3><a href="http://bbs.mofang.com.tw/thread-{$val.tid}-1-1.html" target="_blank">{$val.subject}</a></h3>
							<time>
								<span>{date("Y-m-d H:i:s", $val.dateline)}</span>
							</time>
							<p>{$val.shortmessage}</p>
							{*<div class="relate-link">
								<a href="#">宮廷Q轉</a>
								<a href="#">攻略</a>
							</div>*}
						</div>
					</li>
					{/foreach}
				</ul>
			</div>
			<div class="article-new" style="display:none;">
				<ul class="article-new-list j_con">
					{foreach $bbs_hots as $val}
					<li class="clearfix">
						<a href="http://bbs.mofang.com.tw/thread-{$val.tid}-1-1.html" class="fl img-area" target="_blank">
							<img src="{if $val.attachmentimage}http://bbs.mofang.com.tw/data/attachment/forum/{$val.attachmentimage}{else}{$no_pic}{/if}" alt="{$val.subject}">
						</a>
						<div class="txt-area">
							<h3><a href="http://bbs.mofang.com.tw/thread-{$val.tid}-1-1.html" target="_blank">{$val.subject}</a></h3>
							<time>
								<span>{date("Y-m-d H:i:s", $val.dateline)}</span>
							</time>
							<p>{$val.shortmessage}</p>
							{*<div class="relate-link">
								<a href="#">宮廷Q轉</a>
								<a href="#">攻略</a>
							</div>*}
						</div>
					</li>
					{/foreach}
				</ul>
			</div>
		</div>	
	</div>
</div>
{/if}
{require name="tw_tyong:statics/css/article_new.css"}