<div class="hw-carouse-wrap mb10">
	<div class="hw-carouse-header clearfix mb10">

	</div>
	<div class="hw-carouse-con clearfix">
		{pc M=content action=position posid=10000007 order='listorder desc, id desc' num=4}
		<div class="carouse-con-left fl">
			<div class="carouse-list j_silder">
				{foreach $data as $val}
				<div class="carouse-li">
					<a href="{$val.url}" target="_blank">
						<img src="{qiniuthumb($val.thumb,800,450)}" alt="{$val.title}">
                        <p>{$val.title}</p>
					</a>
				</div>
				{/foreach}
			</div>
		</div>
		{/pc}
		<ul class="carouse-con-right fr">
		{pc M=content action=position posid=10000008 order='listorder desc, id desc' num=6}
			{foreach $data as $val}
			<li class="car-con-rig-li">
				<a href="{$val.url}" target="_blank">
					<img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
					<p>{$val.title}</p>
				</a>
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
</div>
{* {require name="hw_mfang:statics/js/search.js"} *}
{require name="tw_mofang:statics/css/v3/carouse.css"}
{require name="tw_mofang:statics/js/carouse.js"}
