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