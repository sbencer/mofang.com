{*
    **************************************************
    *
    *  main              : 主体区域
    *  footer            : 页面底部
    *  statistical       : 统计代码
    *
    *
    ***************************************************
*}

{extends file='common/base.tpl'}

{* 标题 *}
{block name=title}{strip}
    {if $SEO.title}
        {$SEO.title}
    {else}
        {$SEO.site_title}
    {/if}
{/strip}{/block}

{* 关键词 *}
{block name=keywords}{strip}
    {$SEO.keyword}
{/strip}{/block}

{* 页面描述 *}
{block name=description}{strip}
    {$SEO.description}
{/strip}{/block}


{block name=head}
    {$smarty.block.parent}
    {require name="content:statics/css/common-v4.css"}
    {require name="content:statics/css/show_content.css"}
    {require name="common:statics/css/404.css"}
    {require name="common:statics/css/brower_update.css"}
    {block name=tip_dialog_css}
        {require name="content:statics/css/tiplog.css"}
    {/block}
{/block}

{* html body *}
{block name=body}
    {$smarty.block.parent}
    {* show头部 *}
    {block name="show-header"}
        {include file='content/show_header_static.tpl'}
    {/block}
    
    {* 主体区域 *}
    {block name=main}

        <div class="wrapper J_ping error-page" style="margin-top:20px; zoom: 1; _z-index: 3;">
            <div class="mf-container">
                {block name="show-main"}
                <div class="errorBox">
                    <div class="error404">
                        <div class="errorSearch">
                            <h1>亲，您找的宝贝不在了，试试搜索吧！</h1>
                            <div class="errorSearch-bar clearfix">
                                <form target="_blank" method="get" action="/index.php">
                                    <input type="hidden" value="search" name="m">
                                    <input type="hidden" value="all" name="type">
                                    <input type="text" class="keyWord" placeholder="请输入关键词" autocomplete="off" name="q" >
                                    <span class="goSearch"><input type="submit" value="搜索" class="submit-btn"></span>
                                </form>
                            </div>
                            <p>错误代码：404 </p>
                        </div>
                    </div>
                    <div class="error-map">
                        <div class="clearfix">
                            <dl>
                                <dt><a target="_blank"  href="javascript:void(0)" onclick="return false;">全站导航</a></dt>
                                <dd>
                                    <a target="_blank" href="http://www.mofang.com/xinyou/687-1.html">新闻</a>
                                    <a target="_blank" href="http://www.mofang.com/pingce/688-1.html">试玩</a>
                                    <a target="_blank" href="http://www.mofang.com/gonglue/689-1.html">攻略</a>

                                    <a target="_blank" href="http://www.mofang.com/teji/922-1.html">特辑</a>
                                    <a target="_blank" href="http://www.mofang.com/hanhua/1027-1.html">汉化</a>
                                    <a target="_blank" href="http://www.mofang.com/cty/1157-1.html">初体验</a>

                                    <a target="_blank" href="http://www.mofang.com/pandian/1017-1.html">盘点</a>
                                    <a target="_blank" href="http://www.mofang.com/wenda/1022-1.html">问答</a>
                                    <a target="_blank" href="http://www.mofang.com/jx/1160-1.html">精选</a>

                                    <a target="_blank" href="http://www.mofang.com/sjhz/1228-1.html">上架</a>
                                    <a target="_blank" href="http://www.mofang.com/appmm/1158-1.html">魔免</a>
                                    <a target="_blank" href="http://www.mofang.com/pandian/1017-1.html">盘点</a>

                                    <a target="_blank" href="http://www.mofang.com/dnw/1162-1.html">逗你玩</a>
                                    <a target="_blank" href="http://www.mofang.com/dnw/1119-1.html">伴你玩</a>
                                </dd>
                            </dl>
                            <dl>
                                <dt><a target="_blank" href="javascript:void(0)" onclick="return false;">热门游戏专区</a></dt>
                                <dd>
                                    <a target="_blank" href="http://pvz2.mofang.com/">植物大战僵尸2</a>
                                    <a target="_blank" href="http://luobo2.mofang.com/">保卫萝卜2</a>
                                    <a target="_blank" href="http://www.mofang.com/ttkp/">天天酷跑</a>

                                    <a target="_blank" href="http://pvz2.mofang.com/">天天飞车</a>
                                    <a target="_blank" href="http://dtcq.mofang.com/">刀塔传奇</a>
                                    <a target="_blank" href="http://qmdgs.mofang.com/">全民打怪兽</a>

                                    <a target="_blank" href="http://www.mofang.com/fknsg/">放开那三国</a>
                                    <a target="_blank" href="http://www.mofang.com/ttxd/">天天炫斗</a>
                                </dd>
                            </dl>
                            <dl>
                                <dt><a target="_blank" href="http://c.mofang.com">产业</a></dt>
                                <dd>
                                    <a target="_blank" href="http://c.mofang.com/applepie/1253-1.html">苹果派</a>
                                    <a target="_blank" href="http://c.mofang.com/shilu/255-1.html">中国媒良心</a>
                                    <a target="_blank" href="http://c.mofang.com/meitu/173-1.html">美女图</a>
                                </dd>
                            </dl>
                            <dl>
                                <dt><a target="_blank" href="http://v.mofang.com">视频</a></dt>
                                <dd>
                                    <a target="_blank" href="http://v.mofang.com/fwbk/1172-1.html">非玩不可</a>
                                    <a target="_blank" href="http://v.mofang.com/markpi/934-1.html">魔客派</a>
                                    <a target="_blank" href="http://v.mofang.com/introduction/472-1.html">视频攻略</a>
                                </dd>
                            </dl>
                            <dl>
                                <dt><a target="_blank" href="javascript:void(0)" onclick="return false;">助手</a></dt>
                                <dd>
                                    <a target="_blank" href="http://app.mofang.com/yxb/download?pf=android">魔方游戏宝</a>
                                    <a target="_blank" href="http://www.mofang.com/appdownload/277-1.html">app攻略助手</a>
                                </dd>
                            </dl>
                            <dl>
                                <dt><a target="_blank"  href="javascript:void(0)" onclick="return false;">其他</a></dt>
                                <dd>
                                    <a target="_blank" href="http://fahao.mofang.com">发号</a>
                                    <a target="_blank" href="http://game.mofang.com">游戏中心</a>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                {/block}
            </div>
        </div>
    {/block}

    {* 页面底部、版权信息等*}
    {block name=footer}
        {* show尾部 *}
        {block name="show-footer"}
            {include file='content/show_footer.tpl'}
        {/block}
        {require name='content:statics/js/search.js'}
        {require name='common:statics/js/update_tip.js'}
    {/block}

{/block}


