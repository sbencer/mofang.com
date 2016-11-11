{if !empty($module_setting[$module_name]['tujian']) && $module_setting[$module_name]['disable_type'] == 0 }
    {$tujian=explode(',',$module_setting[$module_name]['tujian'])}
    {$module_style=1}
{else if !empty($tujian_arr) && $tujian_topic_disable_type == 0 }
    {$tujian=explode(',',$tujian_arr)}
    {$module_style=1}
{/if}
<script>
    CONFIG.urlUpdateTujian = "/index.php?m=partition&c=index&p={$dir_name}&a=get_tujian_list";
</script>
{if $module_style}
    <div class="bod_one clearfix">
        {* 专区图鉴 *}
        <div class="clearfix tujian_head fl" id="tujian">
            <div class="picture_map">
                <div class="hd-bg">
                    {if ( isset($tujian_type) || $tujian_type == 'more' )}
                    <ul class="fl yingxiong j_tabs_title">
                        {foreach from=$tujian key=val_key item=val_catid}
                            {pc M=partition action=idtoname catid=$val_catid}
                                <li {if $val_key == 0}class="hot-curr tuj"{/if}>
                                    {$data['catname']}
                                </li>
                            {/pc}
                        {/foreach}
                    </ul>
                    <a href="{get_part_url($tujian_pid,'tyong')}" target="_blank">
                        <span class="hd-more">更多&gt;&gt;</span>
                    </a>
                    {else}
                    <ul class="strat-side-hd clearfix">
                        <li class="hot-curr tuj">游戏图鉴<span class="line"></span></li>
                    </ul>
                    {* 图鉴主分类 *}
                    <ul class="fr yingxiong j_tabs_title">
                        {foreach from=$tujian key=tj_key item=tj_val}
                            {pc M=partition action=idtoname catid=$tj_val return=tab}
                            {/pc}
                            {$catname=$tab['catname']}
                            {* 图鉴主分类名称 *}
                            {pc M=partition action=copy_list catid=$tj_val}
                                <li {if $tj_key == 0 } class="hot-curr" {/if} >
                                    {$catname}
                                </li>
                            {/pc}
                        {/foreach}
                    </ul>
                    {/if}
                </div>
            </div>
            <div class="tujian-bd-con j_tabs_con">
                {foreach from=$tujian key=tj_key item=tj_val}
                <div class="tujian-bd j_tabs_c clearfix {if $tj_key!=0 }fn-hide{/if}">
                    {* 图鉴子分类 *}
                    <ul class="tujian_bd fl">
                        {pc M=partition action=copy_list catid=$tj_val}
                            {if !empty($data)}
                                {* 输出图鉴自分类名称 *}
                                {foreach from=$data key=key item=val}
                                    {* 默认选中第一个子分类 *}
                                    <li class="btn_tujian_sub_cate{if $key == 0 } xuanzhong{/if}" data-cateid="{$val['catid']}">
                                        {$val['catname']}
                                    </li>
                                {/foreach}
                            {else}
                                {literal}
                                <style type="text/css">
                                    .tujian_bd{height:40px;}
                                </style>
                                {/literal}
                            {/if}
                        {/pc}
                    </ul>
                    {* 图鉴列表 *}
                    <div class="picture_tu fl">
                        <ul class="clearfix">
                            {* 输出图鉴内容 *}
                            {pc M=partition action=lists2 partid=$tj_val makeurl=1 fields='id,catid,url,title,shortname,inputtime,thumb' pagenum=100}
                            {$data = $data['contents']}
                                {foreach from=$data item=val}
                                <li>
                                    <a href="{get_info_url($val.catid,$val.id)}" target="_blank">
                                        <img src="{qiniuthumb($val['thumb'],100,100)}" title="{$val['shortname']}">
                                        {mb_strimwidth($val['shortname'],0,14)}
                                    </a>
                                </li>
                                {/foreach}
                            {/pc}
                        </ul>
                    </div>
                </div>
                {/foreach}
            </div>
        </div>
        {* 专题四图 *}
        <div class="hot_project fr" id="topic">
            <div class="hd-bg">
                <ul class="strat-side-hd clearfix">
                    <li class="hot tuj">热门专题<span class="line"></span></li>
                </ul>
            </div>
            <ul class="hot_project_pic">
                {foreach from=$part_topic_pic item=topic_val}
                    {if $topic_val['type'] == 0 }
                    <li><a href="{$topic_val['link']}" target="_blank"><img src="{$topic_val['pic']}" title="{$topic_val['name']}"></a></li>
                    {else}
                    {$topic_ids = explode(',',$topic_val['link'])}
                    {$topic_partid = $topic_ids[0]}
                    {$topic_id = $topic_ids[1]}
                    <li><a href="{get_info_url($topic_partid,$topic_id)}" target="_blank"><img src="{qiniuthumb($topic_val['pic'],270,102)}" title="{$topic_val['name']}"></a></li>
                    {/if}
                {/foreach}
            </ul>
        </div>
    </div>
{/if}
