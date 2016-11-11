{extends file='common/mofang_new_base.tpl'}

{* 头部设置样式 *}
{block name="head"}
    {$smarty.block.parent}

    {require name="tyong:statics/css/whiteblue/model.css"}
    {require name="tyong:statics/css/relaxed.css"}
    {require name="tyong:statics/css/whiteblue/common.css"}
    {require name="tyong:statics/css/whiteblue/ref_sidebar.css"}

    {* add css *}
    {require name="tyong:statics/css/kapai.css"}

{/block}

{block name="main"}

    <div class="kp-main">
        <div class="breadcrumb">
            <span>您正在访问：</span>
            <a href="#">首页</a> &gt;
            <a href="#">百万亚瑟王</a> &gt;
            <span>亚瑟王卡牌</span>
        </div>
        <div class="kp-row clearfix">
            <div class="kp-sidebar kp-index">
                <div class="hd-bg">
                    <ul class="strat-side-hd clearfix">
                        <li class="hot-curr">卡牌分类索引<span class="line"></span></li>
                    </ul>
                </div>
                <div class="kp-index-box">
                    <h3>按势力查询</h3>
                    <div class="kp-index-shili">
                        <ul>
                            <li><a href="">剑术之称</a></li>
                            <li><a href="">技巧之场</a></li>
                            <li><a href="">魔法之派</a></li>
                            <li><a href="">妖精</a></li>
                        </ul>
                    </div>
                    <h3>按星级查询</h3>
                    <div class="kp-index-shili kp-index-other">
                        <ul>
                            <li><a href=""><span>1</span></a></li>
                            <li><a href=""><span>2</span></a></li>
                            <li><a href=""><span>3</span></a></li>
                            <li><a href=""><span>4</span></a></li>
                            <li><a href=""><span>5</span></a></li>
                            <li><a href=""><span>6</span></a></li>
                        </ul>
                    </div>
                    <h3>按COST查询</h3>
                    <div class="kp-index-shili kp-index-other">
                        <ul>
                            <li><a href="">1-5</a></li>
                            <li><a href="">6-10</a></li>
                            <li><a href="">11-15</a></li>
                            <li><a href="">16-20</a></li>
                            <li><a href="">11-15</a></li>
                            <li><a href="">26+</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="kp-content">
                <div class="kp-tConts clearfix kp-mb10">
                    {* 推荐卡牌 *}
                    <div class="kp-mbox">
                        <div class="hd-bg">
                            <ul class="strat-side-hd clearfix">
                                <li class="hot-curr">推荐卡牌<span class="line"></span></li>
                            </ul>
                        </div>
                        <div class="kp-item">
                            <ul>
                                {test_data c1=5}
                                {foreach from=$data key=k item=v}
                                <li>
                                    <a class="kp-item-pic" href="">
                                        <img src="http://pic2.mofang.com/2014/0331/20140331053503957.jpg" title="祭品">
                                    </a>
                                    <div class="kp-item-infor">
                                        <h3><a href="">辉煌型安吉莉亚</a></h3>
                                        <p>擅长于远程攻击的特化骑士，攻击的特化骑士。</p>
                                        <p><a href="">详细&gt;&gt;</a></p>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                    {* 卡牌图鉴 *}
                    <div class="kp-mbox">
                        <div class="hd-bg">
                            <ul class="strat-side-hd clearfix">
                                <li class="hot-curr">卡牌图鉴<span class="line"></span></li>
                            </ul>
                        </div>
                        <div class="kp-item">
                            <ul>
                                {test_data c1=5}
                                {foreach from=$data key=k item=v}
                                <li>
                                    <a class="kp-item-pic kp-app-pic" href="">
                                        <img src="http://pics.mofang.com/2014/0122/20140122093542439.jpg" title="祭品">
                                    </a>
                                    <div class="kp-item-infor">
                                        <h3><a href="">辉煌型安吉莉亚</a></h3>
                                        <p>擅长于远程攻击的特化骑士，攻击的特化骑士。</p>
                                        <p><a href="">详细&gt;&gt;</a></p>
                                    </div>
                                </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                    {* 更新公告 *}
                    <div class="kp-notice">
                        <div class="hd-bg">
                            <ul class="strat-side-hd clearfix">
                                <li class="hot-curr">更新公告<span class="line"></span></li>
                            </ul>
                        </div>
                        <div class="kp-notice-item">
                            <ul>
                                {test_data c1=4}
                                {foreach from=$data key=k item=v}
                                <li>
                                    <a href="">新增姬纯白华恋系列卡牌数据</a>
                                    <span>2014.03.04</span>
                                </li>
                                {/foreach}
                            </ul>
                        </div>
                        <div class="kp-task">
                            <h3><b></b>今日任务(星期五)</h3>
                            <p><a href="">拒绝万物的朽木之森</a></p>
                            <div class="kp-task-table">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <th scope="col" width="30%">探索奖励</th>
                                        <td width="60%">50000水晶</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">密境特效</th>
                                        <td>探索获得Gold4倍（星期五是绝对要努力赚钱的一天）努力赚钱
                                            <br><br><br><br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {* 卡牌数据 *}
                <div class="kp-tConts kp-data">
                    <div class="hd-bg">
                        <ul class="strat-side-hd clearfix">
                            <li class="hot-curr">卡牌数据<span class="line"></span></li>
                        </ul>
                        <a href="#" target="_blank"><span class="hd-more">更多&gt;&gt;</span></a>
                    </div>
                    <div class="kp-data-item">
                        <ul>
                            {test_data c1=18}
                            {foreach from=$data key=k item=v}
                            <li>
                                <a href="">
                                    <img src="http://pics.mofang.com/2014/0125/20140125105258728.jpg">
                                    <span>辉煌型安吉莉亚</span>
                                </a>
                            </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


{/block}

{block name="footer"}
    {$smarty.block.parent}
{/block}
