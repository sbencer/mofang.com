{* 新闻列表页 *}
{foreach $news as $val}
<li>
    <a href="{$val.url}" class="fl">
        <img src="{qiniuthumb($val.thumb,320,180)}" class="fl">
        <p>{$val.title}</p>
    </a>
</li>
{/foreach}