{extends file='tw_mofang/v4/tw_base.tpl'}

{* 主体区域 *}
{block name=main}
    {require name="tw_mofang:statics/css/v4/index.css"}
    {require name="tw_mofang:statics/css/v4/article.css"}
	{require name="tw_mofang:statics/js/v4/side.js"}
    <div class="arc-wrap w1200">
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
        <div class="arc-crumbs all-border marginB10">
		<a href="http://{$smarty.server.SERVER_NAME}">首頁</a>
                {mfcatpos3($catid, '>')}
                {if $title}><span class="">{$title}</span>{/if}
        </div>
        <div class="arc-con clearfix">
            <div class="arc-info-extend fl">
                <div class="arc-info all-border marginB10">
                    <dl class="clearfix">
			<dt class="arc-info-title">
                            {$title}
                        </dt>
                        <dd class="arc-info-author fl">作者：<a href="{get_user_url($outhorname)}" target="_blank">{if $outhorname}{$outhorname}{else}{$username}{/if}</a> 來源：魔方網 {if $copyfrom}{$copyfrom}{else}魔方網{/if}</dd>
                        <dd class="arc-info-date fr">更新時間：2016.07.14  15:03</dd>
                    </dl>
                    <p class="arc-keywords">
			關鍵詞：
                        {foreach $keywords as $val}
				<b><a href="{get_search_url($val)}" target="_blank" class="arc-link">{$val}</a></b>
			{/foreach}
                    </p>
                    <div class="arc-info-detail">
                    	<span class="arc-detail-zan"><div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div></span>
                        {force_balance_tags($content)}
                        <span class="arc-detail-zan"><div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div></span>        
                    </div>
                </div>
                <div class="arc-arc-extend all-border marginB10">
                    <h3 class="title">延伸閱讀</h3>
                    <div class="arc-extend-wrap">
                        <ul class="arc-extend-article clearfix">
                        	{if $relation_game_array}
														{pc M=content action=gameinfo_lists catid=$catid gameid=$relation_game_array id=$id num=4 cache=600}{/pc}
													{else}
														{pc M=content action=lists catid=$catid order='id desc' num=4 cache=3600}{/pc}
													{/if}
                           {foreach $data as $val}
                                <li>
                                    <a href="{$val.url}" target="_blank">
                                    <img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
                                    <p class="extend-arcticle-info">
                                        {$val.title}
                                    </p>
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                        <ul class="arc-extend-other clearfix">
			   							{pc M=content action=relation_tag tag=$tag nid=$id  field='id,title,url,thumb' order='listorder desc, id desc' num=4 cache=600}	
	                      {foreach $data as $val}
	                        <li>
	                           <a href="{$val.url}" target="_blank">{$val.title}</a>
	                        </li>
	                      {/foreach}
	                    {/pc}
                            <a href="{get_tag_url($tag)}" target="_blank" class="more">看更多 ></a>
                        </ul>
                    </div>
                </div>
                <div class="arc-author-extend all-border marginB10">
                    <h3 class="title">作者資訊</h3>
                    <div class="author-extend-wrap">
                        <dl class="clearfix">
										    <dt class="author-extend-img">
							                    <a href="{get_user_url($outhorname)}" target="_blank" class="fl">
										        				<img src="{qiniuthumb($val.avatars,80,80)}" alt="{$outhorname}" class="j_error">
																	</a>
                            </dt>
                            <dd class="author-extend-desc">
                                <a href="{get_user_url($outhorname)}" target="_blank"><span class="author-extend-title">作者：{$outhorname}</span></a>
																{if $val.description}{$val.description}{else}作者還沒有添加任何簡介 敬請期待 {/if}
                            </dd>
                            <dd class="author-extend-more">
                                <span class="author-extend-title">更多 {$outhorname} 的文章</span>
                                <ul>
                                    {pc M=content action=user_lists catid=10000050 outhorname={$outhorname} field='id,title,url,thumb,description,outhorname,username,inputtime' order='id desc' num=3}				      
																      {foreach $data as $val}
																            <li class="ell"><a href="{$val.url}" target="_blank">{$val.title}</a></li>
																		 	{/foreach}				     
																	  {/pc}
                                </ul>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="arc-comment all-border">
			{* FB評論 *}
			{include file="tw_mofang/widget/common/discuss.tpl"}                    
                </div>
            </div>
            <div class="arc-related fr">
                {include file="tw_mofang/v4/widget_news_list.tpl"}
                {include file="tw_mofang/v4/widget_raiders.tpl"}
                {include file="tw_mofang/v4/widget_latest_video.tpl"}
            </div>
        </div>
    </div>
{/block}
