<div class="swiper-container">
	<div class="swiper-wrapper">
	{pc M="content" action="lists" catid="44" order="listorder desc" num="7"}
		{foreach $data as $val}
		<div class="swiper-slide"> 
			<a target="_blank" href="{$val.url}"><img src="{$val.thumb}"></a> 
		</div> 
		{/foreach}
	{/pc}
	</div>
	<div class="pagination"></div>
	<div class="swiper-mask"></div>
</div>
{require name="tw_acg:statics/css/swiper.min.css"}
{require name="tw_acg:statics/css/comics_slide.css"}
{require name="tw_acg:statics/js/comics.js"}