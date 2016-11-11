{* 侧边人气新闻、最新新闻 *}
{require name="tw_mofang:statics/css/v4/widget_news_list.css"}
<div class="side-news all-border marginB10">
    <p class="side-news-btn clearfix">
        <span class="side-active">
            人氣新聞
        </span>
        <span>
            最新新聞
        </span>
    </p>
    <div class="news-con-wrap">
    	{pc M=content action=hits catid=10000050 day=30 order='views desc' num=10 cache=3600}
	        <ul class="side-news-con">
	        	{foreach $data as $val}
		          	<li class="ell">
		                <em>{$val@iteration}</em>
		                <a href="{$val.url}" target="_blank">
		                    {$val.title}
		                </a>
		            </li>
	          {/foreach}		
	        </ul>
        {/pc}
        
       {pc M=content action=lists catid=10000050 order='id desc' num=10 cache=3600}
	        <ul class="side-news-con" style="display: none">
	        	{foreach $data as $val}
	            <li class="ell">
	                <em>{$val@iteration}</em>
	                <a href="{$val.url}" target="_blank">
			                    {$val.title}
			            </a>
	            </li>
	          {/foreach}		
	        </ul>
       {/pc} 
    </div>
</div>
