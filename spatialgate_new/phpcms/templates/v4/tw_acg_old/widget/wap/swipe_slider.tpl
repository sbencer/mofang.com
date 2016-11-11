<div id="slideBox" class="swipe">
    <div class="swipe-wrap">
    {pc module="content" action="position" posid="18" order="listorder DESC" thumb="1" num="5"}
        {foreach $data as $val}
        <div class="slide-item">
            <a href="{$val.url}" ><img src="{qiniuthumb($val.thumb,800,450)}" alt="{$val.title}"><div class="slider-filter">{$val.title}</div></a>
        </div>
        {/foreach}
    {/pc}
    </div>
    <ul id="slidePage">
        <li class="sliderCurr"></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
{require name="tw_acg:statics/wap/css/swipe_slider.css"}
{require name="tw_acg:statics/wap/js/swipe_slider.js"}