<div class="industry-new-wraps">
	<div class="industry-focus-wrap">
		<div class="hw-common-title">
			<h3>產業新聞</h3>
			<a href="{cat_url(10000054)}" target="_blank" class="hw-common-more fr">
					更多 
			<em>></em>
			</a>
		</div>
		{pc M=content action=lists catid=10000054 order='inputtime desc' num=4}{/pc}
		<div class="hw-common-special">
			<ul>
            {foreach $data as $val}
            	{if $val@index < 2}
                <li>
					<a href="{$val.url}" target="_blank" >
					<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
					<span>{$val.title}</span>
					</a>
				</li>
				{/if}
            {/foreach}
			</ul>
		</div>
		<div class="hw-common-con">
			<ul class="common">
				{foreach $data as $val}
				{if $val@index >= 2}
				<li>
					<div class="industry-news-img">
						
						<a href="{$val.url}" target="_blank" class="imgarea">
							{if $val['tag']}<span class="hot-news-tag">{get_tag($val['tag'])}</span>{/if}
							<img src="{qiniuthumb($val.thumb,260,146)}" alt="{$val.title}">
						</a>
					</div>
					<div class="industry-news-list">
						<h4><a href="{$val.url}" target="_blank">{$val.title}</a></h4>
						<p class="industry-news-author">
							<span class="author ml10">
										作者：
							<a href="{get_user_url($val.outhorname)}" target="_blank">{$val.outhorname}</a>
							</span>
							<span class="time">更新：{date('M j,Y',$val.inputtime)}</span>
						</p>
						<p class="industry-news-container">
									<!-- {$val.description} -->
									{mb_substr($val.description,0,50,'utf-8')}...
							<a href="{$val.url}" target="_blank">[更多]</a>
						</p>
					</div>
				</li>
				{/if}
				{/foreach}
			</ul>
		</div>
	</div>
	<div class="industry-focus-list">
		<ul>
			{pc M=content action=lists catid=10000134 order='listorder desc, id desc' num=3}
			  	{foreach $data as $val}
                <li >
                    <a href="{$val.url}" target="_blank">
                        <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                    </a>
                </li>
                {/foreach}
                
       		{/pc}
		</ul>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/industry_focus.css"}
