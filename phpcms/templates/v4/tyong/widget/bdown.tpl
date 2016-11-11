{* 游戏下载 *}
<div class="containerB w636 fr j_tabs">

    {pc M=partition action=app_down_help partid=$partition_id apptype=help}
        {if array_is_null($data)}
            {$num = 1}
        {else}
            {$num = 2}
        {/if}
    {/pc}

    <div class="hd-bg clearfix">
        <ul class="strat-side-hd clearfix">
            <li class="hot-curr">
                游戏下载
                <span class="{if isset($type) }line_b{else}line{/if}"></span>
                <em class="hot"></em>
            </li>
            {if $num == 2 }
                <li>
                    助手攻略
                    <span class="{if isset($type) }line_b{else}line{/if}"></span>
                    <em class="hot"></em>
                </li>
            {/if}
            <li>
                新游宝贝
                <span class="{if isset($type) }line_b{else}line{/if}"></span>
                <em class="hot"></em>
            </li>
            <li>
                魔方游戏宝
                <span class="{if isset($type) }line_b{else}line{/if}"></span>
                <em class="hot"></em>
            </li>
        </ul>
    </div>

    <div class="j_tabs_con">
        <div class="one_game clearfix j_tabs_c">
            {pc M=partition action=app_down_help partid=$partition_id apptype=down}
            <div class="first fl w300">
                <img class="fl" src="{$data['image']}" title="{$data['name']}">
                <h3 class="fl">{$data['name']}</h3>
                <p class="fl">{$data['desc']}</p>
            </div>
            <div class="xiazai_down fr {if $smarty.get.iframe != 1 }w300{else}w272{/if}">
                <p class="fl w150">
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
                </p>
                {if !empty($data.qrcode) }
                    <p class="fr erwei">
                        <img src="{qiniuthumb($data.qrcode,80,80)}" title="{$data.name}" style="width:80px;">
                    </p>
                {/if}
            </div>
            {/pc}
        </div>

        {if $num == 2}
        <div class="one_game clearfix fn-hide j_tabs_c">
            {pc M=partition  action=app_down_help partid=$partition_id apptype=help}
            <div class="first fl w300">
                <img class="fl" src="{$data.image}" title="{$data.name}">
                <h3 class="fl">{$data.name}</h3>
                <p class="fl app-txt">{$data.desc}</p>
            </div>
            <div class="xiazai_down fr {if $smarty.get.iframe != 1 }w300{else}w272{/if}">
                <p class="fl w150">
                    <a href="{strip}
                        {if !empty($data['android']) }
                            {$data['android']}
                        {else}
                            javascript:alert('敬请期待');
                        {/if}{/strip}" target="_blank">
                        <img src="/statics/v4/tyong/img/anzhuo.png">
                    </a>
                    <a href="{strip}
                        {if !empty($data['ios']) }
                            {$data['ios']}
                        {else}
                            javascript:alert('敬请期待');
                        {/if}" target="_blank">
                        <img style="margin-top:6px" src="/statics/v4/tyong/img/pingguo.png">
                    </a>
                </p>
                {if !empty($data.qrcode) }
                    <p class="fr erwei">
                        <img src="{qiniuthumb($data.qrcode,80,80)}" title="{$data.name}" style="width:80px;">
                    </p>
                {/if}
            </div>
            {/pc}
        </div>
        {/if}
        <div class="one_game clearfix j_tabs_c fn-hide">
            <div class="first fl w300">
                <img class="fl" src="/statics/v4/tyong/img/xinyouicon.png" title="新游宝贝">
                <h3 class="fl">新游宝贝</h3>
                <p class="fl app-txt">全宇宙最快的游戏新闻、视频<br>你不可错过的新游预订服务<br>游戏上架抢先通知下载！</p>
            </div>
            <div class="xiazai_down fr {if $smarty.get.iframe != 1 }w300{else}w272{/if}">
                <p class="fl w150">
                    <a href="http://attach.mofang.com/xybb_mofang_v1.3.apk" target="_blank">
                        <img src="/statics/v4/tyong/img/anzhuo.png">
                    </a>
                    <a href="http://attach.mofang.com/gamebaby.ipa" target="_blank">
                        <img style="margin-top:6px" src="/statics/v4/tyong/img/pingguo.png">
                    </a>
                </p>
                <p class="fr erwei"><img src="/statics/v4/tyong/img/xinyouer.png" title="新游宝贝" style="width:80px;"></p>
            </div>
        </div>
        <div class="one_game clearfix j_tabs_c fn-hide">
            <div class="first fl w300">
                <img class="fl" src="/statics/v4/tyong/img/zhushouicon.png" title="魔方游戏宝">
                <h3 class="fl">魔方游戏宝</h3>
                <p class="fl app-txt">手游资讯 发现好玩<br>有人有料 惊喜福利</p>
            </div>
            <div class="xiazai_down fr {if $smarty.get.iframe != 1 }w300{else}w272{/if}">
                <p class="fl w150">
                    <a href="http://app.mofang.com/yxb/download?pf=android" target="_blank">
                        <img src="/statics/v4/tyong/img/anzhuo.png">
                    </a>
                    <a href="{if !empty($data['ios']) }{$data['ios']}{else}javascript:alert('敬请期待');{/if}" target="_blank">
                        <img style="margin-top:6px" src="/statics/v4/tyong/img/pingguo.png">
                    </a>
                </p>
                <p class="fr erwei"><img src="/statics/v4/tyong/img/jiajia_qrcode.png" title="魔方游戏助手" style="width:80px;"></p>
            </div>
        </div>
    </div>
</div>
