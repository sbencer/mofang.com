<div class="picture">
    <ul class="clearfix">
    {pc M="content" action="lists" catid=$catid order="listorder DESC" thumb="1" num="4"}
        {foreach $data as $val}
        <li>
            <a href="{$val.url}"><img src="{qiniuthumb($val.thumb,320,180)}"></a>
            <span><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/new_671bfd8.png"></span>
            <div class="shadow"></div>
            <p>{$val.title}</p>
        </li>
        {/foreach}
    {/pc}
    </ul>
</div>
{require name="tw_acg:statics/wap/css/picture.css"}