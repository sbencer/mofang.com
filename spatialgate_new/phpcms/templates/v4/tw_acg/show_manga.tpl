{*
    base            : seajs 
    mofang_base     : (phpcms)
    mofang_new_base : (yii)
*}

{extends file='tw_acg/base.tpl'}
{block name='main'}
    <div class="float_video">
        <div class="video-con">
            <div class="href clearfix">
                <a href="#2" style="third_logo"><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/logo_manga_c798c09.jpg"></a>
            </div>
            <div class="videos">
                <a href="#4">
                    <iframe id="v_iframe" src="http://manga.hk/website/homepage/works?episode_id={$smarty.get.eid}" width="640" height="600"></iframe>
                </a>    
            </div>
        </div>
        {pc M="content" action="lists" catid="48" order="listorder desc" num="1"}
        {foreach $data as $val}
        <a href="{$val.url}" style="width:100%; display:block; margin:20px auto;">
            <img src="{$val.thumb}" alt="{$val.title}">
        </a>
        {/foreach}
        {/pc}
    </div>
    {require name="tw_acg:statics/css/comics_video.css"}

    {* 浮层 *}
    {include file="tw_acg/widget/comics_works_con.tpl"}
{/block}

{* 返回 *}
{block name='go_back'}
    {include file="tw_acg/widget/go_back.tpl"}
{/block}
