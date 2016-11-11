 <div class="left_cont">
 	{if $card_db_ename}
 	<div class="select-list">
		<div class="ic_bg j_select"><span class="open lin_jian"></span><a href="#">遊戲圖鑑</a></div>
		<ul class="select-li j_select_con disnos" style="display:block;">
		{pc M=partition action=card_category dbid=$card_db_ename cache=3600}
			{foreach $data as $val}
			<li class="none_bg_diff">
				<a href="{card_list_url($val.id, $smarty.get.p)}">{$val.name}</a>
				<img src="/statics/v4/tw_tyong/img/jianb_2_03.jpg">
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
	{/if}

 	{pc M=partition action=wiki partid=$partition_id cache=3600}{/pc}
 	{foreach $data as $val}
 	{if $val.catname && $val.child}
	<div class="select-list">
		<div class="ic_bg j_select"><span class="open lin_jian"></span><a href="#">{$val.catname}</a></div>
		<ul class="j_select_con disno" {if strstr($val.arrchildid, $info_part_id)}style="display:block;"{/if}>
			{foreach $val.child as $child}
			{if $child.catname}
			<li class="lin_bg">
				<div class="jiao-tab j_select">
					<em class="lin_add"></em>
					<a class="fl" href="{if $child.child}javascript:;{else}{$child.url}{/if}">{$child.catname}</a>
					<img src="/statics/v4/tw_tyong/img/jianb_1_03.jpg">
				</div>				
				
				{if $child.child}
				<ul class="select-li j_select_con disnos" {if array_key_exists($info_part_id, $child.child)}style="display:block;"{/if}>
					{foreach $child.child as $r}
					{if $r.catname}
					<li class="none_bg">
						<a href="{$r.url}">{$r.catname}</a>
						<img src="/statics/v4/tw_tyong/img/jianb_2_03.jpg">
					</li>
					{/if}		
					{/foreach}
				</ul>
				{else}
				<ul class="select-li j_select_con disnos" {if ($info_part_id == $child.catid)}style="display:block;"{/if}>
				{pc M=partition action=lists2 partid=$child.catid makeurl=1 fields='id,catid,url,title,inputtime' pagenum=20 cache=3600}{/pc}
					{foreach $data.contents as $r}
					<li class="none_bg">
						<a href="{get_info_url($r.catid, $r.id)}">{$r.shortname}</a>
						<img src="/statics/v4/tw_tyong/img/jianb_2_03.jpg">
					</li>
					{/foreach}
					{if $data.count_all > 20}
					<li class="none_bg">
						<a href="{get_part_url($child.catid)}">更多...</a>
						<img src="/statics/v4/tw_tyong/img/jianb_2_03.jpg">
					</li>
					{/if}
				</ul>
				{/if}
			</li>
			{/if}
			{/foreach}
		</ul>
	</div>
	{elseif $val.catname}
	<div class="select-list">
		<div class="ic_bg j_select"><span class="open lin_jian"></span><a href="#">{$val.catname}</a></div>
		<ul class="j_select_con index_left_con">
		{pc M=partition action=lists2 partid=$val.catid makeurl=1 fields='id,catid,url,title,inputtime' pagenum=5}{/pc}
			{foreach $data.contents as $v}
			<li>
				<a href="{get_info_url($v.catid, $v.id)}">{$v.shortname}</a><span>{date("m-d", $v.inputtime)}</span>
			</li>
			{/foreach}
			{if $data.count_all > 20}
			<li>
				<a href="{get_part_url($val.catid)}">更多...</a>
			</li>
			{/if}
		</ul>
	</div>
	{/if}
	{/foreach} 
	<div class="select-list">
		<div class="ic_bg j_select"><span class="open lin_jian"></span><a href="#">熱門文章</a></div>
		<ul class="j_select_con index_left_con">
		{pc M=partition action=latest partid=$partition_id num=10}
			{foreach $data as $val}
			<li>
				<a href="{get_info_url($val.catid, $val.id)}">{$val.shortname}</a><span>{date("m-d", $val.inputtime)}</span>
			</li>
			{/foreach}
		{/pc}
		</ul>
	</div>
</div>


{require name="tw_tyong:statics/css/common/con_left.css"}
