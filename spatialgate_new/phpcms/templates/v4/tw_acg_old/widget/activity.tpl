<div class="activity">
	<div class="activity_list">
		<h2>{date('m')}月 活動快訊</h2>
        {pc M="content" action="event" catid="37" num="30" order="activetime asc" return="event"}
        <ul>
            {foreach $event as $key=>$val}
			<li><a class="fancybox" href="#event-{$key}">{$val.title}</a></li>
            {/foreach}
		</ul>
        {/pc}
		<i class="icon_calendar" title="切換行事曆"></i>
	</div>
    {pc M="content" action="calendar" event=$event return="calstr"}{/pc}
	<div id="calendar">
		<div class="mounth_tab">
			<p>
				<span class="prev_mounth">{date('m', strtotime("-1 month"))}月</span>
				<span class="this_mounth">{date('m')}月</span>
				<span class="next_mounth">{date('m', strtotime("+1 month"))}月</span>
			</p>
			<i class="icon_act_list" title="切換活動快訊"></i>
		</div>
		{$calstr}
	</div>
</div>
{foreach $event as $key=>$val}
<div class="activity_alert" id="event-{$val.id}">
    <h2 class="activity_title">
        <span>{$val.activedate}</span>
        <span>{$val.title}</span>
        <span>{$val.keywords}</span>
    </h2>
    <ul class="activity_content">
        <li>
            <span>活動時間:</span>
            {$val.activetime}
        </li>
        <li>
            <span>活動地址:</span>
            {$val.activeaddr}
        </li>
        <li>
            <span>網&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;站:</span>
            <a href="{$val.website}">{$val.website}</a>
        </li>
        <li>
            <span>客服聯絡:</span>
            {$val.teline}
        </li>
    </ul>
    <a class="close_btn" href="javascript:;"></a>
</div>
{/foreach}
{require name="tw_acg:statics/css/activity.css"}
{require name="tw_acg:statics/js/dialog.js"} 
