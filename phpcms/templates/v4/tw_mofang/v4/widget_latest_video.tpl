{* 侧边最新影音 *}
{require name="tw_mofang:statics/css/v4/widget_latest_video.css"}
<div class="side-latest all-border marginB10">
    <h3 class="title">
        <a href="http://www.mofang.com.tw/Videos/10000058-1.html" target="_blank" class="more">更多></a>
        最新影音
    </h3>
    {pc M=content action=lists catid=10000058 field='id,title,url,thumb' order='listorder desc, id desc' num=2 cache=3600}
    <div class="side-latest-wrap">
      {foreach $data as $val}
	 {if $val@first}
	        <dl>
	            <a href="{$val.url}" target="_blank">
	                <dt class="side-latest-img">
	                    <img src="{$val.thumb}" alt="{$val.title}">
	                </dt>
	                <dd class="ell">
	                    {$val.title}
	                </dd>
	            </a>
	        </dl>
        {else}
	        <dl class=" marginB10">
	            <a href="{$val.url}" target="_blank">
	                <dt class="side-latest-img">
	                    <img src="{$val.thumb}" alt="{$val.title}">
	                </dt>
	                <dd class="ell">
	                    {$val.title}
	                </dd>
	            </a>
	        </dl>
         {/if}
      {/foreach}
    </div>
    {/pc}

</div>
