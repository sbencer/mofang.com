{extends file='tw_mofang/v4/tw_base.tpl'}

{* 主体区域 *}
{block name=main}
    {require name="tw_mofang:statics/css/v4/index.css"}
    {require name="tw_mofang:statics/css/v4/swiper.min.css"}
	{require name="tw_mofang:statics/js/v4/index.js"}
    {require name="tw_mofang:statics/js/lazyBg.js"}
        {require name="tw_mofang:statics/js/sort_tab.js"}

    <div class="index-ad">
        {pc M=content action=lists catid=10000082 order='id desc' num=1}
    	{foreach $data as $val}
            <a href="{$val.url}" class="hw-bg j_hw_bg" data-uri="{$val.thumb}" target="_blank" style="background-image: url(); background-position: 50% 0%; background-repeat: no-repeat;">
             <span class="bg-close j_close_btn"></span>   
            </a>
        {/foreach}
    {/pc}
    </div>
    <div class="index-wrap w1200">
        {include file="tw_mofang/v4/widget_index_focus.tpl"}
        {* 三笑影音專區 、魔方直播廣場  上市游戏、测评文章、品牌馆 *}
        {include file="tw_mofang/v4/widget_index_main.tpl"}
        {* Cosplay & 展場SG 特集 *}
        {include file="tw_mofang/v4/widget_index_cosplay.tpl"}
    </div>
{/block}
