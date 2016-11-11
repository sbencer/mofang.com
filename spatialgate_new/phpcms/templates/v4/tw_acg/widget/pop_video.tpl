{pc M="content" action="lists" catid="42" num="1"}{/pc}
{foreach $data as $val}
<div class="index_video">
	<a class="fancybox" href="#pop_video">
		<img src="http://pic0.mofang.com.tw/2015/1105/20151105055033785.jpg">
		<span class="icon_player"></span>
	</a>
	<span class="video_title">進擊的巨人展 WALL TAIPEI 開展典禮 三浦春馬擊破台北牆</span>
	<a class="video_more" href="https://www.youtube.com/watch?v=9V0SisqjxD4&list=PL2nfB3t9wW_97Tjz59uvoc68SgKRayh94" target="_blank">看更多&gt;</a>
	<i class="icon_tj"></i>
</div>
{$channel_id=substr(strrchr($val.url, "/"), 1)}
<div id="pop_video" class="pop_video">
	<iframe width="640" height="360" src="https://www.youtube.com/embed/videoseries?list=PL2nfB3t9wW_97Tjz59uvoc68SgKRayh94" frameborder="0" allowfullscreen></iframe>
	<a class="close_btn" href="javascript:;"></a>
</div>
{/foreach}
{require name="tw_acg:statics/css/entrance.css"} 
{require name="tw_acg:statics/css/jquery.fancybox.css"}
{require name="tw_acg:statics/js/dialog.js"} 