{*内容页列表页游戏下载*}
<div class="sidebar-down">
        {pc M=partition action=app_down_help partid=$partition_id apptype=help}
            {if array_is_null($data)}
                {$num = 1}
            {else}
                {$num = 2}
            {/if}
        {/pc}
    <div class="hd-bg">
        <ul class="strat-side-hd clearfix">
            <li class="hot-curr">游戏下载<span class="{if isset($type) }line_b{else}line{/if}"></span><i class="hot_icon"></i></li>
            {if $num == 2 }
                <li>攻略助手<span class="{if isset($type) }line_b{else}line{/if}"></span><i class="hot_icon"></i></li>
            {/if}
             <li>加加<span class="{if isset($type) }line_b{else}line{/if}"></span><i class="hot_icon"></i></li>
        </ul>
    </div>
    <div class="sidebar-down-com j_tabs_con">
        <div class="sidebar-cont j_tabs_c">
            {pc M=partition action=app_down_help partid=$partition_id apptype=down}
                <div class="clearfix wrap_cont">
                    <img class="icon_big" src="{$data.image}" title="{$data.name}" />
                    <div class="sidebar-cont-info">
                        <h3>{$data.name}</h3>
                        <p class="app-txt">{$data.desc}</p>
                    </div>
                </div>
                <div class="clearfix">
                    <span style="float:left; width: 160px;">
                        <a href="{strip}
                        {if !empty($data['android']) }
                            {$data['android']}
                        {else}
                            javascript:alert('敬请期待');
                        {/if}
                        {/strip}" target="_blank">
                        <img src="/statics/v4/tyong/img/anzhuo.png">
                    </a>
                        <a href="{strip}
                        {if !empty($data['ios']) }
                            {$data['ios']}
                        {else}
                            javascript:alert('敬请期待');
                        {/if}
                        {/strip}" target="_blank">
                        <img style="margin-top:6px" src="/statics/v4/tyong/img/pingguo.png">
                    </a>
                    </span>
                    {if !empty($data.qrcode) }
                    <span style="float:left;" class="erwei">
                        <a style="float:;"><img src="{qiniuthumb($data.qrcode,80,80)}" title="{$data.name}" style="width:85px;margin-top:5px;"/></a>
                    </span>
                    {/if}
                </div>
            {/pc}
        </div>
        {if $num == 2 }
        <div class="sidebar-cont j_tabs_c fn-hide">
            {pc M=partition action=app_down_help partid=$partition_id apptype=help}
            <div class="clearfix wrap_cont">
                <img class="icon_big" src="{$data.image}" title="{$data.name}" />
                <div class="sidebar-cont-info">
                    <h3>{$data.name}</h3>
                    <p>{$data.desc}</p>
                </div>
            </div>
            <div class="clearfix">
                <span style="float:left; width: 160px;">
                    <a href="{strip}
                        {if !empty($data['android']) }
                            {$data['android']}
                        {else}
                            javascript:alert('敬请期待');
                        {/if}
                        {/strip}" target="_blank">
                        <img src="/statics/v4/tyong/img/anzhuo.png">
                    </a>
                    <a href="{strip}
                        {if !empty($data['ios']) }
                            {$data['ios']}
                        {else}
                            javascript:alert('敬请期待');
                        {/if}
                        {/strip}" target="_blank">
                        <img style="margin-top:6px" src="/statics/v4/tyong/img/pingguo.png">
                    </a>
                </span>
                {if !empty($data.qrcode) }
                <span style="float:left;" class="erwei">
                    <a style="float:;"><img src="{qiniuthumb($data.qrcode,80,80)}" title="{$data.name}" style="width:85px;margin-top:5px;"/></a>
                </span>
                {/if}
            </div>
            {/pc}
        </div>
        {/if}

    <!--加加-->
    <div class="sidebar-cont j_tabs_c fn-hide">
             <div class="clearfix wrap_cont">
                <img class="icon_big" src="/statics/v4/tyong/img/zhushouicon.png" title="加加" />
                <div class="sidebar-cont-info">
                    <h3>加加</h3>
                    <p>跨服交友  实时语音边玩边聊<br>定制工具  PK辅助解放双手<br>独家福利  超值礼包元宝道具</p>
                </div>
            </div>
            <div class="clearfix">
                <span style="float:left; width: 160px;">
                    <a href="http://jiajia.mofang.com/download" target="_blank">
                        <img src="/statics/v4/tyong/img/anzhuo.png">
                    </a>
                    <a href="javascript:alert('敬请期待');" target="_blank">
                        <img style="margin-top:6px" src="/statics/v4/tyong/img/pingguo.png">
                    </a>
                </span>
                <span style="float:left;" class="erwei">
                    <a style="float:;"><img src="/statics/v4/tyong/img/jiajia_qrcode.png" title="魔方游戏助手" style="width:85px;margin-top:5px;"/></a>
                </span>
            </div>
        </div>


    </div>
</div>
