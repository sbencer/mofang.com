<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<div class="pad_10">
    <div class="common-form">
        <form action="?m=admin&c=shorturlcount&a=chartCount" method="get">
            <table width="100%" class="table_form contentWrap">
                <input type="hidden" name="m" value="admin"/>
                <input type="hidden" name="c" value="shorturlcount"/>
                <input type="hidden" name="a" value="chartCount"/>
                <input type="hidden" name="menuid" value="<?=$_GET['menuid']?>" />
                <tr>
                    <td  width="80"><?php echo L('shorturlcount_time')?></td>
                    <td>
                        <input type="text" name="begintime"  class="input-text" value="<?php if(!empty($begintime)){ echo date('Y-m-d', $begintime);}else{
                            echo $begintime;
                        }?>"/> -
                        <input type="text" name="endtime"  class="input-text"  value="<?php if(!empty($endtime)){ echo date('Y-m-d', $endtime);}?>"/>  <?=L('shorturlcount_timelabel')?> （20130205）
                    </td>
                </tr>
                <tr>
                    <td><?php echo L('shorturl_pname');?></td>
                    <td>
                        <select name="cid[]" multiple style="width: 200px;height: 200px;">
                            <?php
                            printSelect($formatAllClass, $level=0, $cid);
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo L('shorturl_type');?></td>
                    <td>
                        <input type="radio" name="type" value="day" <?php if (isset($type)) { echo $type=='day'? 'checked="checked"' : '';}?>/><?php echo L('shorturl_type_day');?>
                        <input type="radio" name="type" value="week" <?php if (isset($type)) { echo $type=='week'? 'checked="checked"' : '';}?>/><?php echo L('shorturl_type_week');?>
                        <input type="radio" name="type" value="month" <?php if (isset($type)) { echo $type=='month'? 'checked="checked"' : '';}?>/><?php echo L('shorturl_type_monty');?>
                    </td>
                </tr>
            </table>

            <div class="bk15"></div>

            <Input type="submit" />
            <a href="<?php
            if (isset($_GET['cid'])) {
                $queryData = array(
                    'menuid' => $_GET['menuid'],
                    'begintime' => $_GET['begintime'],
                    'endtime' => $_GET['endtime'],
                    'pc_hash' => $_GET['pc_hash'],
                    'type' => $_GET['type'],
                    'showType' => 'chunk',
                    'cid' => $cid
                );
                printf('?m=admin&c=shorturlcount&a=chartCount&%s',
                    http_build_query($queryData)
                );
            } else {
                printf('?m=admin&c=shorturlcount&a=chartCount&menuid=%s&pc_hash=%s&showType=chunk',
                    $_GET['menuid'], //menuid
                    $_GET['pc_hash']
                );
            }
            ?>"><?=L('shorturl_count_table_m')?></a>
        </form>

        <div id="main" style="height:500px;border:1px solid #ccc;padding:10px;"></div>


        <!--Step:2 Import echarts.js-->
        <!--Step:2 引入echarts.js-->
        <script src="/statics/js/echarts.js"></script>

        <script type="text/javascript">
            // Step:3 conifg ECharts's path, link to echarts.js from current page.
            // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径
            require.config({
                paths: {
                    echarts: '/statics/js'
                }
            });
            var option = {
                title : {
                    text: '选定的日期的点击统计',
                    subtext: '<?=date('Y-m-d', $begintime)?>——<?=date('Y-m-d', $endtime)?>'
                },
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:[   <?php foreach ($shorturlData as $val) {?>
                        '<?=$val['shorturl']?> <?=$val['url']?> <?=$allClassData[$val['cid']]['name']?>',
                        <?php }?>]
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : [<?php foreach ($dateArr as $val) {?>
                            '<?php
                            switch($type) {
                                case 'day':
                                    echo date("Y/m/d", $val);
                                    break;
                                case 'week':
                                    echo substr($val, 0, 4) . "年" . substr($val, 4, 2) ."周";
                                    break;
                                case 'monty':
                                    echo substr($val, 0, 4) . "年" . substr($val, 4, 2) ."月";
                                    break;
                            }?>',
                            <?php }?>]
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value} 次'
                        }
                    }
                ],
                series : [
                    <?php foreach ($shorturlData as $val) {?>
                    {
                        name:"<?=$val['shorturl']?> <?=$val['url']?> <?=$allClassData[$val['cid']]['name']?>",
                        type:'line',
                        data:[
                            <?php foreach ($chartData[$val['id']] as $val) {?>
                            '<?php echo $val['total'];?>',
                            <?php }?>
                        ]
                    },
                    <?php }?>
                ]
            };

            // Step:4 require echarts and use it in the callback.
            // Step:4 动态加载echarts然后在回调函数中开始使用，注意保持按需加载结构定义图表路径
            require(
                [
                    'echarts',
                    'echarts/chart/bar',
                    'echarts/chart/line',
                    'echarts/chart/map'
                ],
                function (ec) {
                    //--- 折柱 ---
                    var myChart = ec.init(document.getElementById('main'));
                    myChart.setOption(option);
                }
            );
        </script>

    </div></div>
</body>
</html>


