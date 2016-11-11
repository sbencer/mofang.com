<div class="works-title clearfix">
    <div class="title-img fl">
        <a href="javascript:;">
            <img src="{$thumb}">
        </a>
    </div>
    <div class="title-intro fl">
        <h2><a href="javascript:;">{$title}</a></h2>
        {*<p class="pop_like already">999</p>*}
        <div class="text">
            <span></span>
            <p>{$description}</p>
        </div>
    </div>
</div>
{$data = string2array($episode_list)}
<div class="con-chapter">
    <ul class="chapter-ul clearfix">
        {foreach $data as $val}
        <li><a href="{$smarty.const.APP_PATH}cartoon/{if $catid == 46}anicomic{else}manga{/if}/{$catid}-{$id}-{$val.eid}.html">{$val.title}</a></li>
        {/foreach}
    </ul>
</div>
<a class="works_back" href="javascript:;">回到上一頁</a>