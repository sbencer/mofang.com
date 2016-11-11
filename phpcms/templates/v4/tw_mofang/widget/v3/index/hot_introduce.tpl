    <div class="hot-introduce clearfix">
        <h3 class="h3_title">魔方推薦</h3>
        <div class="con mlr-9">
            <div class="con-hd clearfix">
                <ul class="clearfix">
                    <li class="curr">綜合</li>
                    <li>RPG</li>
                    <li>卡牌</li>
                    <li>休閒</li>
                    <li>策略</li>
                    <li>動作</li>
                </ul>
                <!-- <form method="get" action="">
                    <input type="hidden" name="" value="search">
                    <input type="text" class="search-input" name="" onkeydown="">
                    <input type="submit" class="search-btn" id="search">
                </form> -->
            </div>
            <div class="con-cont">
                <div class="cont clearfix">
                {pc M=content action=lists catid=10000070 order='listorder asc, id desc' num=6}
                    {foreach $data as $val}
                    <a href="{$val.url}" target="_blank">
                        <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                        <p>{$val.title}</p>
                    </a>
                    {/foreach}
                {/pc}
                </div>
                <div class="cont clearfix disno">
                {pc M=content action=lists catid=10000071 order='listorder asc, id desc' num=6}
                    {foreach $data as $val}
                    <a href="{$val.url}" target="_blank">
                        <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                        <p>{$val.title}</p>
                    </a>
                    {/foreach}
                {/pc}
                </div>
                <div class="cont clearfix disno">
                {pc M=content action=lists catid=10000078 order='listorder asc, id desc' num=6}
                    {foreach $data as $val}
                    <a href="{$val.url}" target="_blank">
                        <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                        <p>{$val.title}</p>
                    </a>
                    {/foreach}
                {/pc}
                </div>
                <div class="cont clearfix disno">
                {pc M=content action=lists catid=10000073 order='listorder asc, id desc' num=6}
                    {foreach $data as $val}
                    <a href="{$val.url}" target="_blank">
                        <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                        <p>{$val.title}</p>
                    </a>
                    {/foreach}
                {/pc}
                </div>
                <div class="cont clearfix disno">
                {pc M=content action=lists catid=10000077 order='listorder asc, id desc' num=6}
                    {foreach $data as $val}
                    <a href="{$val.url}" target="_blank">
                        <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                        <p>{$val.title}</p>
                    </a>
                    {/foreach}
                {/pc}
                </div>
                <div class="cont clearfix disno">
                {pc M=content action=lists catid=10000075 order='listorder asc, id desc' num=6}
                    {foreach $data as $val}
                    <a href="{$val.url}" target="_blank">
                        <img src="{qiniuthumb($val.thumb,400,224)}" alt="{$val.title}">
                        <p>{$val.title}</p>
                    </a>
                    {/foreach}
                {/pc}
                </div>
            </div>
        </div>
    </div>
{require name="tw_mofang:statics/css/v3/hot_introduce.css"}
{require name="tw_mofang:statics/js/v3/hot_introduce.js"}