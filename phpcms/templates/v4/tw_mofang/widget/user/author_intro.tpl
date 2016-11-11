<div class="hw-author-intro w680 mb10">
	<div class="hw-common-title">
		<h3>作者簡介：</h3>
	</div>
	{pc M=admin action=userinfo outhorname=$smarty.get.outhorname}
	{foreach $data as $val}
	<div class="hw-common-con">
		<div class="author-intro-con">
			<div class="author-intro-detail clearfix">
				<img src="{$val.avatars}" alt="{$smarty.get.outhorname}">
				<div class="txt-area">
					<h3>作者：{$smarty.get.outhorname}</h3>
					<span>已發文章：（{$val.count}）</span>
					<p>{if $val.description}{$val.description}{else}作者还没有添加任何简介敬请期待{/if}</p>
				</div>
			</div>
		</div>
	</div>
	{/foreach}
	{/pc}
</div>
{require name="tw_mofang:statics/css/user/author_intro.css"}
