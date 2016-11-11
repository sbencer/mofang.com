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
            <div class="kp-sidebar kp-nav">
                <div class="hd-bg">
                    <ul class="strat-side-hd clearfix">
                        <li class="hot-curr">快速导航<span class="line"></span></li>
                    </ul>
                </div>
                <div class="kp-index-box">
                    <h3>物品分类</h3>
                    <div class="kp-index-shili">
                        <ul>
                            <li><a href="">武器</a></li>
                            <li><a href="">药剂</a></li>
                            <li><a href="">手持</a></li>
                            <li><a href="">饰品</a></li>
                        </ul>
                    </div>
                    <h3>任务类型</h3>
                    <div class="kp-index-shili">
                        <ul>
                            <li><a href="">新手任务</a></li>
                            <li><a href="">日常活动</a></li>
                            <li><a href="">手持</a></li>
                            <li><a href="">饰品</a></li>
                            <li><a href="">今日活动</a></li>
                            <li><a href="">转职任务</a></li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="kp-content">
                {* 卡牌分类索引 *}
                <div class="kp-tConts kp-cate-index">
                    <div class="hd-bg">
                        <ul class="strat-side-hd clearfix">
                            <li class="hot-curr">卡牌分类索引<span class="line"></span></li>
                        </ul>
                    </div>
                    <div class="kp-cate-index-hd">
                        <div class="kp-cate-index-list">
                            <span>按势力查询：</span>
                            <a class="curr" href="">剑术之城</a>
                            <a href="">技巧之场</a>
                            <a href="">魔法之派</a>
                            <a href="">妖精</a>
                        </div>
                        <div class="kp-cate-index-list">
                            <span>按星级查询：</span>
                            <a  class="curr" href="">一星</a>
                            <a href="">二星</a>
                            <a href="">三星</a>
                            <a href="">四星</a>
                        </div>
                        <div class="kp-cate-index-list">
                            <span>按cost查询：</span>
                            <a  class="curr" href="">1-5</a>
                            <a href="">6-10</a>
                            <a href="">11-15</a>
                            <a href="">16-20</a>
                            <a href="">20+</a>
                        </div>
                    </div>
                    <div class="kp-cate-index-bd">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <th rowspan="2" scope="col">卡牌图片</th>
                                <th rowspan="2" scope="col">星级</th>
                                <th rowspan="2" scope="col">cost</th>
                                <th rowspan="2" scope="col">阵营</th>
                                <th colspan="2" scope="col">普通卡片LV1</th>
                                <th colspan="4" scope="col">普通卡片满破</th>
                            </tr>
                            <tr>
                                <th scope="col">HP</th>
                                <th scope="col">AKT</th>
                                <th scope="col">HP</th>
                                <th scope="col">AKT</th>
                                <th scope="col">合围</th>
                                <th scope="col">CP</th>
                            </tr>
                            {test_data c1=2}
                            {foreach from=$data key=k item=v}
                            {if $v@iteration is even by 1}
                            <tr class="even-bg">
                                <td width="18%">
                                    <a class="kp-picBox" href="">
                                        <img src="http://pics.mofang.com/2014/0227/20140227110520980.png" title="刀塔传奇">
                                        <span>辉煌型安吉莉亚</span>
                                    </a>
                                </td>
                                <td width="9%">2</td>
                                <td width="9%">5</td>
                                <td width="10%">剑术之城</td>
                                <td width="9%">950</td>
                                <td width="9%">960</td>
                                <td width="9%">930</td>
                                <td width="9%">930</td>
                                <td width="9%">930</td>
                                <td width="9%">830</td>
                            </tr>
                            {else}
                            <tr>
                                <td width="18%">
                                    <a class="kp-picBox" href="">
                                        <img src="http://pics.mofang.com/2014/0227/20140227110520980.png" title="刀塔传奇">
                                        <span>辉煌型安吉莉亚</span>
                                    </a>
                                </td>
                                <td width="9%">2</td>
                                <td width="9%">5</td>
                                <td width="10%">剑术之城</td>
                                <td width="9%">950</td>
                                <td width="9%">960</td>
                                <td width="9%">930</td>
                                <td width="9%">930</td>
                                <td width="9%">930</td>
                                <td width="9%">830</td>
                            </tr>
                            {/if}
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


{/block}

{block name="footer"}
    {$smarty.block.parent}
{/block}
