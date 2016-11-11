{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base.tpl'}

{* 主体区域 ss *}
{block name='main'}
    <div class="hw-main j_bg_par">
    {pc M=content action=lists catid=10000082 order='id desc' num=1}
    	{foreach $data as $val}
            <a href="{$val.url}" class="hw-bg j_hw_bg" data-uri="{$val.thumb}" target="_blank" style="background-image: url(); background-position: 50% 0%; background-repeat: no-repeat;">
             <span class="bg-close j_close_btn"></span>   
            </a>
        {/foreach}
    {/pc}
        {require name="tw_mofang:statics/js/lazyBg.js"}
        {require name="tw_mofang:statics/js/sort_tab.js"}
    	<div class="hw-main-wrap">
    		<div class="hw-main-common w1000 mb10 pb10">
    			{* carouse *}
    			{include file="tw_mofang/widget/v3/index/carouse.tpl"}
    		</div>
            <div class="hw-main-common w1000 mb10">
                {* sort information *}
                {include file="tw_mofang/widget/v3/index/sort_information.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* hot game *}
                {include file="tw_mofang/widget/v3/index/hot_game.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* hot introduce *}
                {include file="tw_mofang/widget/v3/index/hot_introduce.tpl"}
            </div>
            {pc M="content" action="lists" catid="10000221" order="listorder desc, id desc" num="2" return="facetime"}
            {if $facetime}
            <div class="facetime">
                {* mofang facetime*}
                <div class="mf-facetime">
                    <div class="mf-con">
                    {foreach $facetime as $val}
                        {if $val@first}
                        <a href="{$val.url}" class="left_time">
                            <img src="{$val.thumb}">
                        </a>
                        {else}
                        <a href="{$val.url}" class="right_time">
                            <img src="{$val.thumb}">
                        </a>
                        {/if}
                    {/foreach}
                    </div>
                </div>
            </div>
            {/if}
            <div class="hw-main-common w1000 mb10">
                {* rank *}
                {include file="tw_mofang/widget/v3/index/rank.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* brand *}
                {include file="tw_mofang/widget/v3/index/brand.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* prize last *}
                {include file="tw_mofang/widget/v3/index/prize_last.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* evaluating *}
                {include file="tw_mofang/widget/v3/index/evaluating.tpl"}
                {* evaluating *}
                {include file="tw_mofang/widget/v3/index/video.tpl"}
            </div> 
    	</div>
    </div>
{/block}
