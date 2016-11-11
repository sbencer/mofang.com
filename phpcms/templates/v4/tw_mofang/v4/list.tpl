{extends file='tw_mofang/v4/tw_base.tpl'}

{* 主体区域 *}
{block name=main}
    {require name="tw_mofang:statics/css/v4/index.css"}
    {require name="tw_mofang:statics/css/v4/list.css"}
	{require name="tw_mofang:statics/js/v4/side.js"}
    <div class="list-wrap w1200 marginB10">
        <div class="ads-wrap clearfix marginB10">
	    <div class="ads-big fl">	
                {pc M=content action=lists catid=10000092 field='id,title,url,thumb' order='listorder desc, id desc' num=1 cache=600}	
                    {foreach $data as $val}	
                        <a href="{$val.url}" target="_blank" class="gg-l">	
                            <img src="{$val.thumb}" alt="{$val.title}">	
                        </a>	
                    {/foreach}	
                {/pc}	
            </div>	
            <div class="ads-small fr">	
                {pc M=content action=lists catid=10000067 field='id,title,url,thumb' order='listorder desc, id desc' num=1 cache=600}	
                    {foreach $data as $val}	
                        <a href="{$val.url}" target="_blank" class="gg-r">	
                            <img src="{$val.thumb}" alt="{$val.title}">	
                        </a>	
                    {/foreach}	
                {/pc}	
            </div>	
        </div>
        <div class="list">
            <div class="list-img all-border marginB10">
                <p class="list-type marginB10">
									 {pc M=content action=category catid=$top_parentid num=6 siteid=$siteid order='id DESC'}
											<a href="{cat_url($top_parentid)}" {if $top_parentid == $catid}class="list-type-active"{/if}>綜合</a>
										  	{foreach $data as $val}
													<a href="{$val.url}" {if $val.catid == $catid}class="list-type-active"{/if}>{$val.catname}</a>
									      {/foreach}
						            {if $top_parentid == 10000050}
													<a href="{cat_url(10000111)}" target="_blank">事前登錄</a>
						            {/if}		        
									  {/pc}
                </p>
                <dl class="clearfix">
                 {pc M=content action=lists listtype='intag' catid=$catid field='id,title,url,thumb,tag' order='id desc' num=7}
                 {foreach $data as $val}
		   {if $val@first}
	                    <dt class="list-img-special">
	                        <a href="{get_tag_url($val.tag)}" target="_blank" class="tag tag-qingbao">{get_tag($val.tag)}</a>
	                        <a href="{$val.url}" target="_blank">
	                            <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
	                            <p class="list-img-info ell">{$val.title}</p>
	                        </a>
	                    </dt>
                   
                   {else}
								  
	                    <dd>
	                        <a href="" target="_blank" class="tag tag-qingbao">{get_tag($val.tag)}</a>
	                        <a href="{$val.url}" target="_blank">
	                            <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
	                            <p class="list-img-info ell">{$val.title}</p>
	                        </a>
	                    </dd>
                    
                    {/if}
                   {/foreach}
                 {/pc}   
                </dl>
            </div>
            <div class="list-article-other clearfix">
                <div class="list-article all-border fl">
		     {pc M=content action=lists listtype='intag' catid=$catid field='id,title,url,thumb,description,username,inputtime,tag' order='id desc' skip=7 num=15 page=$page}
                    		<h3>
                    			{if $catid == "10000056"} 
                    				情報
                    			{elseif $catid == "10000050"}
                    				綜合
                    			{elseif $catid == "10000051"}
                    				遊戲
                    			{elseif $catid == "10000272"}
                    				動漫
                    			{elseif $catid == "10000053"}
                    				趣味
                    			{elseif $catid == "10000054"}
                    				產業
					{elseif $catid == "10000222"}
                    				女性向
                    				{/if}
                    		新聞</h3>
                    		 
                       <div class="list-article-con">
                       {foreach $data as $val}
                            <dl>
                                <dt class="list-article-img fl">
                                    <a href="" target="_blank" class="tag tag-qingbao">{get_tag($val.tag)}</a>
                                    <a href="{$val.url}" target="_blank">
                                        <img src="{$val.thumb}" alt="{$val.title}">
                                    </a>
                                </dt>
                                <a href="{$val.url}" target="_blank">
	                                <dd class="list-article-title">
	                                    {$val.title}
	                                </dd>
	                                <dd class="list-article-time">
	                                    更新 : {$val.inputtime|date_format}
	                                </dd>
	                                <dd class="list-article-info">
	                                    {str_cut(mftrim($val.description),160)}
	                                </dd>
                                </a>
                            </dl>
                        {/foreach}
                        <p class="list-page">
                        	{mfpages($total, $page, $pagesize)}
                        	{*
                        		 <a href="" class="page-home">首页</a>
                            <a href="" class="page-normal page-prev">&lt;</a>
                            <a href="" class="page-normal page-active">1</a>
                            <a href="" class="page-normal">2</a>
                            <a href="" class="page-normal">3</a>
                            <a href="" class="page-normal">4</a>
                            <a href="" class="page-normal">5</a>
                            <a href="" class="page-normal page-next">&gt;</a>
                            <a href="" class="page-last">最底</a>
													*}
                        </p>
                    </div>
                  {/pc}
                </div>
                <div class="list-other fr">
                    {include file="tw_mofang/v4/widget_news_list.tpl"}
                    {include file="tw_mofang/v4/widget_raiders.tpl"}
                    {include file="tw_mofang/v4/widget_latest_video.tpl"}
                </div>
            </div>
        </div>
    </div>
{/block}
