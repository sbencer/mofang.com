<div class="article-new mb10 j_wrap">
	<div class="nav-common title2-bg">
		<ul class="nav-com-list clearfix j_tabs">
		{$catid_arr = explode(',', $module_setting_type['custom_new']['video_arr'])}
		{foreach $catid_arr as $val}                                            
        	{pc M=partition action=idtoname catid=$val}
			<li class="bg-line">
				<a style="cursor: hand;cursor: pointer;" id="{$val.catid}">{$data['catname']}</a>
			</li>
          	{/pc}
      	{/foreach}
		</ul>
	</div>
	<div class="common-con">
		<div class="article-new-con">
			{foreach $catid_arr as $val}
				{pc M=partition action=lists2 partid=$val makeurl=1 fields='id,catid,url,title,inputtime,description,thumb' pagenum=4}
				<div class="article-new" {if !$val@first}style="display:none;"{/if}>
					<ul class="article-new-list j_con">
						{foreach $data.contents as $vv}
						<li class="clearfix">
						<a href="{get_info_url($vv.catid,$vv.id)}" class="fl img-area" target="_blank">
							<img src="{qiniuthumb($vv.thumb,218,130,$no_pic)}" alt="{$vv.title}">
						</a>
						<div class="txt-area">
							<h3><a href="{get_info_url($vv.catid,$vv.id)}" target="_blank">{$vv.title}</a></h3>
							<time>
								<span>{date("Y-m-d H:i:s", $vv.inputtime)}</span>
							</time>
							<p> 
								{if $vv.description}
                                    {mb_strimwidth($vv.description,0,155,'...')}
                                {else}
	                                    
	                            {/if}
		                    </p>
						</div>
					</li>
						{/foreach}
					</ul>
				</div>
				{pc}
			{/foreach}
		</div>	
	</div>
</div>
{require name="jp_tyong:statics/css/article_new.css"}
