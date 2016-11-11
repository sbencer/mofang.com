<div class="mf-gonglue w310 mb10">
	<div class="hw-common-title">

		<a href="http://www.mofang.com.tw/Zones/10000070-1.html" target="_blank" class="hw-common-more fr">更多</a>
		<h3>發燒攻略</h3>
	</div>        
	<div class="hw-common-con">
	    <div class="mf-gonglue-con">
		{pc M=content action=lists catid=10000070  thumb='1' order='id desc' num=1 moreinfo='1' cache=3600}
		{foreach $data as $val}
		<div class="gonglue-li">
		    <a href="{$val.url}" class="mb10">
			<img src="{$val.thumb}">
			<p>{$val.title}</p>
		    </a>
		</div>
		{/foreach}
		{/pc}
	    </div>
	</div>
</div>
{require name="tw_mofang:statics/css/article/mf_gonglue.css"}

