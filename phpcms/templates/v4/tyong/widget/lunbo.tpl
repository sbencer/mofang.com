<!-- 轮播图 -->
{if !empty($slide_id) }
<div class="containerB w636a fr" style="overflow:hidden;">
    <div id="J_slide" class="{if $_GET['iframe'] != 1 }news-bd-slide{/if}" >
        <ul class="news-bd-slide-cont clearfix">
            {pc M=partition action=partition_contents partid=$slide_id makeurl=1 fields='id,catid,url,title,inputtime,thumb' nums=$slide_nums}
                {foreach from=$data key=key item=val}
                <li>
                    <a href="{$val.url}" target="_blank"><img src="{qiniuthumb($val.thumb,640,300)}" title="{$val.title}" /></a>
                    <p class="idnex-mask"><a href="{$val.url}" target="_blank">{$val.title}</a></p>
                </li>
                {/foreach}
            {/pc}
        </ul>
    </div>
</div>
{/if}
