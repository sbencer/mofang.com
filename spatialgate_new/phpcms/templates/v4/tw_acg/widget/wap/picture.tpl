<div class="picture">
    <ul class="clearfix">
    {pc M="content" action="position" posid="19" order="listorder DESC" thumb="1" num="6"}
        {foreach $data as $val}
        <li>
            <a href="{$val.url}"><img src="{qiniuthumb($val.thumb,320,180)}"></a>
            <span><img src="/statics/v4/tw_acg/wap/images/new.png"></span>
            <div class="shadow"></div>
            <p>{$val.title}</p>
        </li>
        {/foreach}
    {/pc}
    </ul>
</div>
{require name="tw_acg:statics/wap/css/picture.css"}