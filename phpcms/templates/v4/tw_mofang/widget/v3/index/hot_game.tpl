<div class="hot-game-img">
{pc M="content" action="lists" catid="10000134" order="listorder desc, id desc" num="3"}
    {foreach $data as $val}
    <a href="{$val.url}"><img src="{qiniuthumb($val.thumb,400,224)}"></a>
    {/foreach}
{/pc}
</div>
<div class="hot-game-wrap">
    <div class="hot-game-classify mb10 j_hot_tab">
        <div class="hot-game-top fl">
            <span class="curr j_tab">熱門遊戲</span>
            <span class="j_tab">人氣專區</span>
        </div>
        <div class="j_con_wrap">
            <div class="game-class-right clearfix j_con">
            {pc M=content action=lists catid=10000064 order='listorder desc, id desc' num=10}
                {foreach $data as $val}
                <a href="{$val.url}" target="_blank" class="fl">
                    <img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}">
                    <span>{$val.title}</span>
                </a>
                {/foreach}
            {/pc}
            </div>
            <div class="game-class-right clearfix disno j_con">
            {pc M=content action=lists catid=10000065 order='listorder desc, id desc' num=10}
                {foreach $data as $val}
                <a href="{$val.url}" target="_blank" class="fl">
                    <img src="{qiniuthumb($val.thumb,80,80)}" alt="{$val.title}">
                    <span>{$val.title}</span>
                </a>
                {/foreach}
            {/pc}
            </div>
        </div>   
    </div>
</div>
{require name="tw_mofang:statics/js/tab_change.js"}
{require name="tw_mofang:statics/js/tab.js"}
{require name="tw_mofang:statics/css/v3/hot_game.css"}
