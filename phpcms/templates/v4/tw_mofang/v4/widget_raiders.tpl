{* 侧边发烧攻略 *}
{require name="tw_mofang:statics/css/v4/widget_raiders.css"}
<div class="side-raiders all-border marginB10">

    <h3 class="title">
        <a href="http://www.mofang.com.tw/Zones/10000070-1.html" target="_blank" class="more">更多></a>
        發燒攻略
    </h3>
    {pc M=content action=lists catid=10000070 field='id,title,url,thumb' order='listorder desc, id desc' num=2 cache=3600}
    	{foreach $data as $val}
		    <div class="side-raiders-wrap">
		    	{if $val@first}
		        <dl>
		            <a href="{$val.url}" target="_blank">
		                <dt class="side-raiders-img">
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
		                <dt class="side-raiders-img">
		                    <img src="{$val.thumb}" alt="{$val.title}">
		                </dt>
		                <dd class="ell">
		                    {$val.title}
		                </dd>
		            </a>
		        </dl>
		        {/if}
		    </div>
		  {/foreach}
     {/pc}

</div>
