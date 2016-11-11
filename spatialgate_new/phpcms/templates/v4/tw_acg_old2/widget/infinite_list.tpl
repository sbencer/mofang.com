<div class="container">
	<div id="infiniteBox" class="infiniteBox">
	{pc M="content" action="lists" catid=$catid order="id desc" num=10}
		{foreach $data as $val}
	    <div class="grid">
	      	<div class="imgholder">
	      		<a class="fancybox" href="{$val.thumb}">
	      			<img class="lazy" src="{$val.thumb}" data-original="{$val.thumb}"  />
	      		</a>
	    	</div>
	      	<p><a href="{$val.url}">{$val.title}</a></p>
	      	<p class="icon_horologe">
	      		{date("Y年m月d日 H:i:s", $val.inputtime)}
	      	</p>
	      	<p class="icon_view">
	      		{get_views("c-3-{$val.id}")}
	      	</p>
	    </div>
	    {/foreach}
	{/pc}
	</div>
	<!--loading start-->
	<img class="load-img" src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/loding_183e9ee.gif">
	<!--loading end-->
</div>
{require name="tw_acg:statics/css/infinite_list.css"}
{require name="tw_acg:statics/css/jquery.fancybox.css"}
{require name="tw_acg:statics/js/infinite_list.js"}