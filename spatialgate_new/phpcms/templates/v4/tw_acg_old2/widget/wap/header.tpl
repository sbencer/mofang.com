<div class="zq_header">
    <a class="icon-menu" href="javascript:;"><i></i></a>
    <h1 class="topic"><a href="{$smarty.const.APP_PATH}">次元角落ACG資訊站</a></h1>
    <span class="icon-search"><i></i></span>
</div>
<!--logo导航 start-->
<div class="logo_nav">
    <a class="icon_logo" href="{siteurl($siteid)}">logo</a>
    <ul class="nav_template">
    {pc module="content" action="category" catid="0" num="25" siteid="$siteid" order="listorder ASC"}
        {foreach $data as $val}
        <li {if $catid == $val.catid}class="curr"{/if}><a href="{$val.url}">{$val.catname}</a></li>
        {/foreach}
    {/pc}
    </ul>
</div>
<!--logo导航 end-->
{require name="tw_acg:statics/wap/css/common.css"}