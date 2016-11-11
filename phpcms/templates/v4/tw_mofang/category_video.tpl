{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_mofang/hw_base_det.tpl'}

{* 主体区域 *}

{* 主体区域 *}
{block name='main'}
    <div class="hw-video-main hw-v-wrap">
        {* 头部轮播图 *}
        {block name="v-carouse"}
            {include file="tw_mofang/widget/video/video_carouse.tpl"}
        {/block}
        <div class="hw-main-wrap">
        {block name="ggao"}
        {/block}
        {block name="bread"}
        <div class="hw-common-bread mb10 w1000">
            <h3>
                <a href="http://{$smarty.server.SERVER_NAME}">首頁</a>
                {mfcatpos3($smarty.get.catid, '<em>></em>')}
                {if $title}<em>></em><span class="curr">{$title}</span>{/if}
            </h3>
        </div>
        {/block}
        {block name="main-content"}
        <div class="hw-main-content j_left">
        {* <div class="hw-main-common w1000_nb mb10">
                {include file="tw_mofang/widget/video/carouse.tpl"}
            </div>*}
            <div class="hw-main-common w1000 mb10">
                {* 人氣閱讀 *}
                {include file="tw_mofang/widget/video/hot_read.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* 網絡精選 *}
                {include file="tw_mofang/widget/video/network.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* 魔客派 *}
                {include file="tw_mofang/widget/video/moke.tpl"}
            </div>
            <div class="hw-main-common w1000 mb10">
                {* 遊戲評鑑 *}
                {include file="tw_mofang/widget/video/game_ce.tpl"}
            </div>
        </div>
        {/block}
        </div>
    </div>
{/block}
