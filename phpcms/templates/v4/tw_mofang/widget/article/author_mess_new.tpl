{if $outhorname}
<div class="author-wrap mb10 w1000">
	<div class="hw-common-title">
		<h3>作者資訊</h3>
	</div>
	{pc M=admin action=userinfo outhorname=$outhorname}
	<div class="hw-common-con">
	{foreach $data as $val}
		<div class="author-con clearfix">
			<div class="author-img-wrap clearfix mb10">
				<a href="{get_user_url($outhorname)}" target="_blank" class="fl">
					<img src="{qiniuthumb($val.avatars,80,80)}" alt="{$outhorname}" class="j_error">
				</a>
				<h3><a href="{get_user_url($outhorname)}" target="_blank">作者：{$outhorname}</a></h3>
				<p>{if $val.description}{$val.description}{else}作者還沒有添加任何簡介 敬請期待 {/if}</p>
			</div>
			<div class="author-related">
				<div class="author-related-hd">
					<a href="{get_user_url($outhorname)}" class="fr" target="_blank">看更多 <em>></em></a>
					<h3>更多關於<em>{$outhorname}</em>的文章</h3>
				</div>
				<div class="author-related-bd">
				{pc M=content action=user_lists catid=10000050 outhorname={$outhorname} field='id,title,url,thumb,description,outhorname,username,inputtime' order='id desc' num=3}
					<ul class="">
						{foreach $data as $val}
						<li><a href="{$val.url}" target="_blank">{$val.title}</a></li>
						{/foreach}
					</ul>
				{/pc}
				</div>
				
			</div>
		</div>
	{/foreach}
	</div>
	{/pc}
</div>
{require name="tw_mofang:statics/css/article/author_mess.css"}
{/if}
