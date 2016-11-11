<div class="ranking">
    <div class="list_title clearfix">
        <h2 class="fl">排行榜</h2>
        <!-- <p class="fr"><a href="#">MORE>></a></p> -->
    </div>
    <ul class="ranking_text">
    {pc module="content" action="lists" catid=11 order="listorder desc, id desc" field="id,title,thumb,url" thumb=1 num=5}
        {foreach $data as $val}
            {if $val@iteration < 4}
            <li>
                <span class="no{$val@iteration}">NO.{$val@iteration}</span>
                <span class="king_{$val@iteration}"></span>
                <a class="king_text" href="{$val.url}">{$val.title}</a>
            </li>
            {else}
            <li>
                <span class="no4">NO.{$val@iteration}</span>
                <span class="king_4">
                </span><a class="king_text" href="{$val.url}">{$val.title}</a>
            </li>  
            {/if}
        {/foreach}
    {/pc}
    </ul>
</div>
{require name="tw_acg:statics/wap/css/ranking.css"}