{*
    **************************************************
    * wap 头部
    ***************************************************
*}

<div class="hd">
    {block name="toolbar"}
    <div class="toolbar">
        {* logo *}
	    <a class="logo background" href="http://m.mofang.com"></a>

        {* 工具按钮 *}
        {block name="toolbutton"}
            {if $wap_index_page}
                <div class="btn-search background"></div>
            {/if}
            <!-- <a href="http://m.mofang.com/index.php?m=content&c=login"><div class="btn-tool background"></div></a> -->
            <div class="btn-user-icon background"></div>
        {/block}

        {* 搜索工具条 *}
        {block name="searchbar"}
            {if $wap_index_page}
            <div class="search">
            {else}
            <style>
                .bd{
                    padding-top:4.58333rem;
                }
                .search {
                    box-shadow:none;
                }
            </style>
            <div class="search" style="display:block;">
            {/if}
                <div class="search_inner clearfix">
                    <form action="">
                        <input class="input_query" placeholder="请输入关键词" type="text" name="q-header" value="" />
                        <input id="search-header" class="btn_submit background" type="submit" name="" value="" />
                    </form>
                </div>
            </div>
            {require name="common:statics/js/v5/wap_search.js"}
        {/block}
    </div>
    {/block}

    {* 如果是首页则显示加加下载提示 *}
    {if $wap_index_page}
        {require name="common:statics/js/m/jiajia.js"}
        <div id="jiajia-download-tip" class="jiajia-download-tip background">
            <a href="http://app.mofang.com/yxb/download?pf=android" class="once-down">立即下载</a>
        </div>
    {/if}

</div>

{* 异步登陆想过处理 *}
{script}
    seajs.use("login/wapcheck");
{/script}
