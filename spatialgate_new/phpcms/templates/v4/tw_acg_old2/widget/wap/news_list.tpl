<div class="sorts clearfix">
    <ul class="sort_list append clearfix">
    {pc M="content" action="lists" catid=$catid order="listorder DESC" thumb="1" num="30"}
    {foreach $data as $val}
        {if $val@index >= 4}
        <li>
            <a href="{$val.url}" class="fl">
                <img src="{qiniuthumb($val.thumb,320,180)}" class="fl">
                <p>{$val.title}</p>
            </a>
        </li>
        {/if}
    {/foreach}
    {/pc}
    </ul>
    <a class="load_more" href="javascript:;"><span>還要查看更多</span></a>
</div>
{require name="tw_acg:statics/wap/css/sort_list.css"}
{require name="tw_acg:statics/wap/js/load_more.js"}
