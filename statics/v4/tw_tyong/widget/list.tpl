<div class="article-new mb10">
	<div class="nav-common title2-bg">
		<!-- <a href="#" class="more-common fr">更多<em>></em></a> -->
		<ul class="nav-com-list clearfix">
			<li>
			{pc M=partition action=idtoname catid=$smarty.get.catid}
			<a href="#" style="font-size: 14px;">{$data['catname']}</a>
	        {/pc}
			</li>
		</ul>
	</div>
	<div class="common-con">
		<div class="article-new-con">
			{pc M=partition action=lists2 partid=$smarty.get.catid makeurl=1 fields='id,catid,url,title,inputtime,description,thumb' currpage=$smarty.get.page pagenum=6}
			<ul class="article-new-list">
				{foreach from=$data.contents item=val}
				<li class="clearfix">
					<a href="{get_info_url($val.catid,$val.id)}"  class="fl img-area">
						<img src="{qiniuthumb($val.thumb,218,130,$no_pic)}" alt="{$val.title}"/>
					</a>
					<div class="txt-area">
						<h3><a href="{get_info_url($val.catid, $val.id)}">{$val.title}</a></h3>
						<time>
							<span>{date('Y-m-d',$val.inputtime)}</span>
							<span>{date('H:i:s',$val.inputtime)}</span>
							<span>作者： {$val.username}</span>
						</time>
						<p>
							{if $val.description}
                                    {mb_strimwidth($val.description,0,155,'...')}
                                {else}
                                    暂无描述
                            {/if}
                        </p>			
					
						{*<div class="relate-link">
							<a href="#">宫廷Q传</a>
						</div>*}
					
					</div>
				</li>
				{/foreach}
			</ul>
			<div class="page">
			{mfpages($data.count_all, $smarty.get.page, 6, get_part_url( $smarty.get.catid, 'tyong', true), array(), 4, '上一页', '下一页')}
			</div>
		</div>	
	</div>

</div>
{require name="tw_tyong:statics/css/article_new.css"}
