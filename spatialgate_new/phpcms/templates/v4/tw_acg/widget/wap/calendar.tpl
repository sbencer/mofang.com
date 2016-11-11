<div class="calendar">
    <div class="list_title clearfix">
        <h2 class="fl">活動行事歷</h2>
    </div>
    {pc M="content" action="event" catid="37" num="30" return="event"}
    {pc M="content" action="calendar" event=$event return="calstr"}
    <div id="calendar">
        {$calstr}
    </div>
    {/pc}
    {foreach $event as $val}
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
	<div class="mask"></div>
</div>


{require name="tw_acg:statics/wap/css/activity_alert.css"}
{require name="tw_acg:statics/wap/css/calendar.css"}
{*require name="tw_acg:statics/wap/js/calendar.js"*}
