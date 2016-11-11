<div class="news clearfix">
    <div class="list_title clearfix">
        <h2 class="fl">ACG資訊看這邊</h2>
        <p class="fr"><a href="{cat_url(12)}">MORE>></a></p>
    </div>
    <ul class="substance clearfix">
    {pc module="content" action="position" posid="20" order="listorder DESC" thumb="1" num="10"}
        {foreach $data as $val}
        <li>
        	<a href="{$val.url}">
            <h3>{$val.title}</h3>
            <div class="list_content clearfix">
                <div class="fl"><img src="{qiniuthumb($val.thumb,320,180)}"></div>
                <p class="fl">{$val.description|truncate:70}</p>
            </div>
            </a>
        </li>
        {/foreach}
    {/pc}
    </ul>
</div>
{require name="tw_acg:statics/wap/css/index_news.css"}