<div class="v-moke">
	<div class="hw-common-title">
		<a href="{cat_url(10000059)}" target="_blank" class="hw-common-more fr">更多 <em>></em></a>
		<h3>手遊NEW GAME</h3>
	</div>
	<div class="hw-common-con">
		<div class="moke-wrap">
			<div class="moke-top clearfix">
			{pc M=content action=lists catid=10000059 field='id,title,url,thumb' order='listorder desc, id desc' num=7}
				{foreach $data as $val}
					{if $val@first}
					<a href="{$val.url}" target="_blank" class="first mb10 fl">
						<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
						<p><span>{$val.title}</span></p>
					</a>
					{else}
					<a href="{$val.url}" target="_blank" class="moke-common mb10 fl">
						<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
						<p><span>{$val.title}</span></p>
					</a>
					{/if}
				{/foreach}
			{/pc}
			</div>
			{*
			<div class="moke-bttm clearfix">
				<a href="#" class="moke-tuijian fl">
					<img src="/statics/v4/tw_mofang/img/ex_01.jpg" alt="">
				</a>
				<a href="#" class="moke-common fl">
					<img src="/statics/v4/tw_mofang/img/ex_01.jpg" alt="">
					<p>《看我72變·波多野聯盟》聖誕節の特別坊市</p>
				</a>	
				<a href="#" class="moke-common fl">
					<img src="/statics/v4/tw_mofang/img/ex_01.jpg" alt="">
					<p>《看我72變·波多野聯盟》聖誕節の特別坊市</p>
				</a>	
			</div>
			*}
		</div>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/video/moke.css"}
