<div class="sorts clearfix">
    <div class="list_title clearfix">
        <h2 class="fl">{$tag}相關分類資訊</h2>
    </div>
    <ul class="sort_list append clearfix">
        {foreach $data as $val}
        <li>
            <a href="{$val.url}" class="fl">
                <img src="{qiniuthumb($val.thumb,320,180)}" class="fl">
                <p>{$val.title}</p>
            </a>
        </li>
        {/foreach}
    </ul>
    <a class="load_more" href="javascript:;"><span>還要查看更多</span></a>
</div>
{require name="tw_acg:statics/wap/css/sort_list.css"}
{require name="tw_acg:statics/wap/js/load_more.js"}

