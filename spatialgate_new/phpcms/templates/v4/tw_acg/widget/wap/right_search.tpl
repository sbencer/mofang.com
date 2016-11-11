<div class="right_search">
    <div class="twm-search">
        <div class="right-search">
            <div class="search-wrap">
                <form action="http://www.spatialgate.com.tw/index.php">
                    <input type="hidden" name="m" value="search">
                    <input type="text" id="search-input" name="q" placeholder="自由搜尋" onkeydown>
                    <!--<input type="submit" class="search-btn" id="search" value="">-->
                </form>
            </div>		
        </div>		
        <div class="search-content">
            <span class="empty">沒有相關文章</span>
            <ul class="search_con clearfix">
            </ul>
        </div>
    </div>
    <div class="new-app">
            <div class="list_titles clearfix">
                <h2>最新遊戲APP推薦</h2>
            </div>
            <div class="search-content">
            {pc module="content" action="lists" catid=10 order="listorder desc, id desc" field="id,title,thumb,url" thumb=1 num=5}
                <ul class="clearfix">
                {foreach $data as $val}
                    <li>
                        <a href="{$val.url}" class="fl">
                            <img src="{qiniuthumb($val.thumb,100)}" class="fp fl">
                            <em class="fp">{$val.title}</em>
                            <span class="fr arrow">&gt;</span>
                        </a>
                    </li>
                {/foreach}
                </ul>
            {/pc}
            </div>
    </div>
</div>
{require name="tw_acg:statics/wap/css/right_search.css"}
{require name="tw_acg:statics/wap/css/common.css"}
