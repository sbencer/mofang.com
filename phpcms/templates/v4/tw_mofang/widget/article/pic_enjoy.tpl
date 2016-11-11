<div class="pic-enjoy w310 mb10">
	<div class="hw-common-title">
        <a href="#" target="_blank" class="hw-common-more fr">更多 <em>&gt;</em></a>
		<h3>美圖欣賞</h3>
	</div> 
	<div class="hw-common-con">
		<div class="pic-enjoy-bd">
			{pc M=content action=lists catid=10000100 order='id desc' num=2}
				{foreach $data as $val}
				<a href="{$val.url}" class="mb10">
					<img src="{$val.thumb}" alt="{$val.title}" title="{$val.title}">
				</a>
				{/foreach}
			{/pc}
		</div>
	</div>
</div>
{require name="tw_mofang:statics/css/article/pic_enjoy.css"}
