{pc M=partition action=activity_lists pid=$partition_id}{/pc}
{if $data['data']}
<div class="time-wrap mb10">
	<div class="nav-common title2-bg">
		<ul class="nav-com-list clearfix">
			<li class="class1">
				活動任務時間表
			</li>
		</ul>
	</div>
	<div class="common-con-nobrd">
		<div class="time-con">
			<table class="table">
			<thead style="background-color:{$data['setting']['color_t']}">
				<th>開始</th>
				<th>結束</th>
				<th>活動名稱</th>
			</thead>
			<tbody>
			{assign var='circles'  value=array('每週一','每週二','每週三','每週四','每週五','每週六','每週日')}
			{foreach $data['data'] as $val}
				<tr style="background-color:{$data['setting'][$val.status]}">
					<th class="f_weight">{if $val.circle < 7}{$circles[$val.circle]}{else}{date("Y-m-d", $val.start_time)}{/if}</th>
					<th class="f_weight">{if $val.circle < 7}{$circles[$val.circle]}{elseif $val.limit_time}未定{else}{date("Y-m-d", $val.end_time)}{/if}</th>
					<th>
						<a href="{$val.url}"><img src="{$val.image}"><p>{$val.title}</p>
					  </a>
					</th>
				</tr>
			  {/foreach}
			</tbody>
		</table>
		</div>
	</div>
</div>
{/if}
{require name="tw_tyong:statics/css/active_time.css"}
