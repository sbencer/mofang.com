{if !empty($relaxed)}
<div class="w960 hh-content-con-toptitle">
    <div class="hd-bg">
        <ul class="strat-side-hd clearfix">
            <li class="hot-curr">轻松一刻<span class="line"></span></li>
            {* <li class="">精美壁纸<span class="line"></span></li> *}
        </ul>
        {* <a href="{get_part_url($relaxed,'tyong')}" target="_blank"><span class="hd-more">更多&gt;&gt;</span></a> *}
    </div>
    <ul class="hh-content-con-big clearfix">
        {pc M=partition action=partition_contents partid=$relaxed makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' nums=10}
            {foreach from=$data item=val}
            <li>
                <a href="{$val.url}">
                    <img class="list-content-con-img" src="{qiniuthumb($val.thumb,72,72)}">
                    {mb_strimwidth($val.shortname,0,10)}
                </a>
            </li>
            {/foreach}
        {/pc}
    </ul>
</div>
{/if}
