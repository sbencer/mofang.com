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
                <a href="#2" style="third_logo"><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/logo_anicomic_eeeae77.jpg"></a>
            </div>
            <div class="videos">
                <iframe src="{$smarty.const.APP_PATH}aniComicWeb/aniComicWeb4spatialgate.html?ID={$author_id}+{$cartoon_id}+{$smarty.get.eid}" width="640px" height="360px" frameborder="0"></iframe>
                <p>※動畫有時讀取較慢， 請您耐心等候。感謝！</p>
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
    {require name="tw_acg:statics/css/anicomic_con.css"}

    {* 浮层 *}
    {include file="tw_acg/widget/comics/comics_works_con.tpl"}
{/block}

{* 返回 *}
{block name='go_back'}
    {include file="tw_acg/widget/comics/go_back.tpl"}
    <script language="JavaScript" src="{$smarty.const.APP_PATH}api.php?op=count&id={$id}&modelid={$modelid}"></script>
{/block}