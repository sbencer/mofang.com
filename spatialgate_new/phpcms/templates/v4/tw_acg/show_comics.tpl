{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/full_screen.tpl'}
{block name='wrapper'}
    
    {require name="tw_acg:statics/css/comics_video.css"}
    {require name="tw_acg:statics/js/iframe.js"}
    <div class="float_video">
        {if $catid == 46}
        <div class="video-con">
            {*<div class="href clearfix">
                <a href="#2" style="third_logo"><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/logo_anicomic_eeeae77.jpg"></a>
            </div>*}
            <iframe id="v_iframe" src="{$smarty.const.APP_PATH}aniComicWeb/aniComicWeb4spatialgate.html?ID={$author_id}+{$cartoon_id}+{$smarty.get.eid}" width="100%" height="0" frameBorder="0"></iframe>   
        </div>
        {else}
        <div class="video-con">
            {*<div class="href clearfix">
                <a href="#2" style="third_logo"><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/logo_manga_c798c09.jpg"></a>
            </div>*}
            <iframe id="v_iframe" src="http://manga.hk/website/homepage/works?episode_id={$smarty.get.eid}" width="100%" height="0" frameBorder="0" ></iframe>
        </div>
        {/if}
        {pc M="content" action="lists" catid="48" order="listorder desc" num="1"}
        {foreach $data as $val}
        {*<a href="{$val.url}" style="width:100%; display:block; margin:20px auto; text-align:center">
            <img src="{$val.thumb}" alt="{$val.title}">
        </a>*}
        {/foreach}
        {/pc}
    </div>

    {* 浮层 *}
    {include file="tw_acg/widget/comics/comics_works_con.tpl"}
{/block}

{* 返回 *}
{block name='go_back'}
    {include file="tw_acg/widget/comics/go_back.tpl"}
    <script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}