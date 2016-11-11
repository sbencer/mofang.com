<div class="right_cont">
{*筛选表单*}
{include file="tw_tyong/widget/card/card_filter_form.tpl"} 
<!--content start-->
<div class="filter_content">
    <div class="title">
        <span class="fl_curr">全部</span>
        {*<ul class="fr">
            <li class="curr"><a href="#2">全部</a></li>
            <li><a href="#2">攻擊</a></li>
            <li><a href="#2">傲嬌</a></li>
            <li><a href="#2">回復</a></li>
            <li><a href="#2">平均</a></li>
            <li><a href="#2">惡魔</a></li>
        </ul>*}
    </div>
    <!--table start-->
    <table class="filter_table" cellpadding="0">
        <tr>
            {foreach $field_names as $val}
            <th><a {*class="down up"*} href="javascript:;"><strong>{$val}</strong></a></th>
            {/foreach}
        </tr>
        {foreach $card_data as $val}
        <tr>
            <td>
                <a class="role_name" href="{card_detail_url($smarty.get.setid,$val.id, $smarty.get.p)}"><img src="{$val.data.icon}" alt=""><strong>{$val.data.name}</strong></a>
            </td>
            {foreach $field_keys as $key}
            <td><strong>{$val.data[$key]}</strong></td>
            {/foreach}
        </tr>
        {/foreach}
    </table>
    <!--table end-->
    <!--page  start-->
    <div class="t_align_c">
        <div class="pagin">
            {$URL = preg_replace('/_\d+\./','_{$page}.',$smarty.server.REQUEST_URI)}
            {mfpages($card_total, $smarty.get.page, $card_size, $URL, array(), 5, '上一頁', '下一頁')}
        </div>
    </div>
    <!--page  end-->
</div>
<!--content end-->
</div>
{require name="tw_tyong:statics/css/con_right.css"}
{require name="tw_tyong:statics/css/game_load.css"}
{require name="tw_tyong:statics/js/index.js"}
{require name="tw_tyong:statics/css/card_attr.css"}