
<div class="right_cont">
{*筛选表单*}
{include file="tw_tyong/widget/card/card_filter_form.tpl"} 
<!--filter_content start-->
<div class="filter_content">
    <div class="title">
        <span class="fr total_result">共{$card_total}個搜尋結果</span> 
    </div>
    <!--result_list start-->
    <ul class="result_list">
        {foreach $card_data as $val}
        <li><a href="{card_detail_url($smarty.get.setid,$val.id, $smarty.get.p)}"><img src="{$val.data.icon}" alt="{$val.data.name}">{$val.data.name}</a></li>
        {/foreach}
    </ul>
    <!--result_list end-->
    <!--page  start-->
    <div class="t_align_c">
        <div class="pagin">
            {$URL = preg_replace('/_\d+\./','_{$page}.',$smarty.server.REQUEST_URI)}
            {mfpages($card_total, $smarty.get.page, $card_size, $URL, array(), 5, '上一頁', '下一頁')}
        </div>
    </div>
    <!--page  end-->
</div>
<!--filter_content end-->
</div>
{require name="tw_tyong:statics/css/con_right.css"}
{require name="tw_tyong:statics/css/game_load.css"}
{require name="tw_tyong:statics/js/index.js"}
{require name="tw_tyong:statics/css/card_attr.css"}
