<div class="v-carouse-wrap">
    <div class="v-carouse clearfix j_v_car">
    {pc M=content action=lists catid=10000068 order='id desc' num=5}
        {foreach $data as $val}
        <div class="v-carouse-li">
            <a href="{$val.url}" data-color="{$val.bg_color}" style="background-image:url({$val.thumb})"></a>
        </div>
        {/foreach}
    {/pc}
    </div>
</div>
{require name="tw_mofang:statics/css/video/video_carouse.css"}
{require name="tw_mofang:statics/js/fix.js"}
{require name="tw_mofang:statics/js/v_carouse.js"}
