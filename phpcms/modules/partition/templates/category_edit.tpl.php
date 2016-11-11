<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script type="text/javascript">
<!--
    $(function(){
        $.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
        $("#modelid").formValidator({onshow:"<?php echo L('select_model');?>",onfocus:"<?php echo L('select_model');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('select_model');?>"}).defaultPassed();
        $("#catname").formValidator({onshow:"<?php echo L('input_catname');?>",onfocus:"<?php echo L('input_catname');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_catname');?>"}).defaultPassed();
        $("#catdir").formValidator({onshow:"<?php echo L('input_dirname');?>",onfocus:"<?php echo L('input_dirname');?>"}).regexValidator({regexp:"^([a-zA-Z0-9、-]|[_]){0,30}$",onerror:"<?php echo L('enter_the_correct_catname');?>"}).inputValidator({min:1,onerror:"<?php echo L('input_dirname');?>"}).ajaxValidator({type : "get",url : "",data :"m=admin&c=category&a=public_check_catdir&old_dir=<?php echo $catdir;?>",datatype : "html",cached:false,getdata:{parentid:'parentid'},async:'false',success : function(data){    if( data == "1" ){return true;}else{return false;}},buttons: $("#dosubmit"),onerror : "<?php echo L('catname_have_exists');?>",onwait : "<?php echo L('connecting');?>"}).defaultPassed();
        $("#url").formValidator({onshow:" ",onfocus:"<?php echo L('domain_name_format');?>",tipcss:{width:'300px'},empty:true}).inputValidator({onerror:"<?php echo L('domain_name_format');?>"}).regexValidator({regexp:"http:\/\/(.+)\/$",onerror:"<?php echo L('domain_end_string');?>"});
        $("#template_list").formValidator({onshow:"<?php echo L('template_setting');?>",onfocus:"<?php echo L('template_setting');?>",oncorrect:"<?php echo L('input_right');?>"}).inputValidator({min:1,onerror:"<?php echo L('template_setting');?>"}).defaultPassed();
    })
//-->
</script>
<!-- 配置上傳圖片的寬度 -->
<style type="text/css">
    .app_down_logo{
        
        width:300px;
    }
    .tr_bor_top {
        border-top: 2px solid #444;
    }
</style>

<form name="myform" id="myform" action="?m=partition&c=partition&a=edit" method="post">
<div class="pad-10">
<div class="col-tab">

<ul class="tabBut cu-li">
    <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',16,1);"><?php echo L('catgory_basic');?></li>
    <li id="tab_setting_3" onclick="SwapTab('setting','on','',16,3);"><?php echo L('catgory_template');?></li>
    <li id="tab_setting_4" onclick="SwapTab('setting','on','',16,4);"><?php echo L('catgory_seo');?></li>
    <!-- <li id="tab_setting_5" onclick="SwapTab('setting','on','',8,5);"><?php echo L('catgory_private');?></li> -->

    <!-- $parentid為0時，為專區配置修改，修改欄目時不顯示 -->
    <?php if( $parentid == 0 ){?>
        <li id="tab_setting_6" onclick="SwapTab('setting','on','',16,6);">關聯遊戲</li>
        <li id="tab_setting_7" onclick="SwapTab('setting','on','',16,7);"><font color="#71bc52">頭圖</font></li>
        <li id="tab_setting_8" onclick="SwapTab('setting','on','',16,8);">跳轉button</li>
        <li id="tab_setting_9" onclick="SwapTab('setting','on','',16,9);">遊戲下載信息</li>
        <li id="tab_setting_10" onclick="SwapTab('setting','on','',16,10);">友鏈及內鏈配置</li>
        <li id="tab_setting_11" onclick="SwapTab('setting','on','',16,11);">模板基本配置</li>
        <!-- 專區類型是否是官網，官網則有官網配置，不“執行”模版配置 -->
        <?php if( !$setting['is_official'] ){?>
        <!-- 模版類型是否是通用模版，不是通用模版，不“顯示”通用模塊配置 -->
        <li id="tab_setting_12" onclick="SwapTab('setting','on','',16,12);"><font color="#16aaff">通用模塊配置</font></li>
        <?php }else{?>
            <li id="tab_setting_13" onclick="SwapTab('setting','on','',16,13);">官網內嵌配置</li>
        <?php }?>
        <li id="tab_setting_14" onclick="SwapTab('setting','on','',16,14);"><font color="#71bc52">button項&nbsp;v2</font></li>
    <?php }?>
        <li id="tab_setting_15" onclick="SwapTab('setting','on','',16,15);">內嵌iframe配置</li>
    <?php if( $parentid == 0 ){?>
        <li id="tab_setting_16" onclick="SwapTab('setting','on','',16,16);">移動端配置</li>
        <li id="tab_setting_2" onclick="SwapTab('setting','on','',16,2);"><font color="#71bc52">廣告配置</font></li>
    <?php }?>
</ul>
<!-- 基本選項 -->
<div id="div_setting_1" class="contentList pad-10">
    <table width="100%" class="table_form ">
        <?php if($parentid){?>
        <tr>
            <th width="200"><?php echo L('parent_category')?>：</th>
            <td>
                <?php //echo form::select_category('category_content_'.$this->siteid,$parentid,'name="info[parentid]" id="parentid"',L('please_select_parent_category'),0,-1);?>
                <?php //echo form::select_partition(1,$sub_id[1],'category_content_'.$this->siteid,$catid,'name="info[parentid]" id="parentid"','請選擇上級分區',0,-1);?>
                <?php echo form::select_partition(0,0,'category_content_'.$this->siteid,$parentid,'name="info[parentid]" id="parentid"','請選擇上級分區',0,-1);?>
            </td>
        </tr>
          <?php }?>

          <tr>
            <th><?php if( !$parentid ){ echo L('catname');}else{ echo "欄目名稱"; } ?>：</th>
            <td>
                <input type="text" name="info[catname]" id="catname" class="input-text" value="<?php echo $catname;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                總係數：<input type="text" name="setting[rate_weight]" class="input-text" value="<?php echo $setting['rate_weight'];?>" />
            </td>
          </tr>
            <tr>
                <th>攻略欄目：</th>
                <td><input type="text" name="setting[app_gonglue_cha]" class="input-text" value="<?php echo $setting['app_gonglue_cha'];?>" /></td>
            </tr>

           <?php if($parentid){?>
            <tr>
                <th>Tab標簽：</th>
                <td>
                    <input type='radio' name='info[is_tab]' value='1' <?php if($is_tab == 1) echo "checked";?> id="normal_addid"> 是&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='info[is_tab]' value='0' <?php if($is_tab == 0) echo "checked"; ?> id="normal_addid"> 否&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <th>Tab標簽(<font color="green">New助手</font>)：</th>
                <td>
                    <input type='radio' name='info[is_tab2]' value='1' <?php if($is_tab2 == 1) echo "checked";?> id="normal_addid"> 是&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='info[is_tab2]' value='0' <?php if($is_tab2 == 0) echo "checked"; ?> id="normal_addid"> 否&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <th>Tab圖片(<font color="green">New助手</font>)：</th>
                <td><?php echo form::images('setting[new_tab_image]', 'image', $setting['new_tab_image'], 'content');?></td>
            </tr>
            <tr>
                <th>列表樣式：</th>
                <td>
                    <input type='radio' name='info[cont_type]' value='1' <?php if($cont_type==1) echo "checked";?> > 圖文列表&nbsp;&nbsp;
                    <input type='radio' name='info[cont_type]' value='2' <?php if($cont_type==2) echo "checked";?> > 文字列表&nbsp;&nbsp;
                    <input type='radio' name='info[cont_type]' value='3' <?php if($cont_type==3) echo "checked";?> > 圖鑑列表&nbsp;&nbsp;
                    <input type='radio' name='info[cont_type]' value='4' <?php if($cont_type==4) echo "checked";?> > 圖文數值列表(卡牌庫)&nbsp;&nbsp;
                    <input type='radio' name='info[cont_type]' value='5' <?php if($cont_type==5) echo "checked";?> > 視頻列表及詳情頁
                    <input type='radio' name='info[cont_type]' value='6' <?php if($cont_type==6) echo "checked";?> > 英雄阵容列表
                </td>
            </tr>

            <tr>
                <th>內容樣式：</th>
                <td>
                    <input type='radio' name='info[cont_style]' value='0' <?php if($cont_style==0) echo "checked";?> > 默認&nbsp;&nbsp;
                    <input type='radio' name='info[cont_style]' value='1' <?php if($cont_style==1) echo "checked";?> > 滑動&nbsp;&nbsp;
                    <input type='radio' name='info[cont_style]' value='2' <?php if($cont_style==2) echo "checked";?> > 卡牌&nbsp;&nbsp;
                </td>
            </tr>
        <?php }?>

        <?php if( !$parentid ){?>

        <tr>
            <th>推薦位欄目：</th>
            <td><input type="text" name="info[rec_channel]" class="input-text" value="<?php echo $rec_channel;?>" /></td>
          </tr>

        <tr>
            <th>Android包：</th>
            <td>
                <input type="text" name="info[pack_android]" class="input-text" value="<?php echo $pack_android;?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                APP係數：<input type="text" name="setting[app_weight]" class="input-text" value="<?php echo $setting['app_weight'];?>" />
            </td>
          </tr>

        <tr>
            <th>iOS包：</th>
            <td><input type="text" name="info[pack_ios]" class="input-text" value="<?php echo $pack_ios;?>" /></td>
          </tr>
        <tr>
            <th>Web頭圖：</th>
            <td>
                <?php
                    $web_header = form::images_partition('setting[web_header]', 'web_header', $setting['web_header'], 'web_header','','','input-text');
                    echo $web_header;
                ?>
            </td>
        </tr>
        <tr>
            <th>專區背圖：</th>
            <td>
                <?php
                    $web_background = form::images_partition('setting[web_background]', 'web_background', $setting['web_background'], 'web_background','','','input-text');
                    echo $web_background;
                ?>
            &nbsp;&nbsp;背圖鏈接：&nbsp;
            <input name='setting[web_bg_url]' type='text' id='meta_title' value='<?php echo $setting['web_bg_url'];?>' size='60' maxlength='60'>
            </td>
        </tr>
        <tr>
            <th>縮略默認圖：</th>
            <td>
                <?php
                    $no_pic = form::images_partition('setting[no_pic]', 'no_pic', $setting['no_pic'], 'no_pic','','','input-text');
                    echo $no_pic;
                ?>
            </td>
        </tr>
          <?php }?>


        <?php if( !$parentid ){ ?>
        <tr>
            <th>是否上線：</th>
            <td>
                <input type='radio' name='info[is_online]' value='0' <?php if( !$is_online ) echo "checked";?> id="normal_addid"> 不上線&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='info[is_online]' value='1' <?php if( $is_online ) echo "checked";?> > 上線</td>
        </tr>
        <tr>
            <th>獨立域名：</th>
            <td>
                <input type='radio' name='info[is_domain]' value='0' <?php if( !$is_domain ) echo "checked";?> id="normal_addid"> 不啟用&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='info[is_domain]' value='1' <?php if( $is_domain ) echo "checked";?> > 啟用</td>
                <!-- <?php if(!$is_domain){ echo '未啟用'; }else{ echo '已啟用';  } ?> -->
        </tr>
        <tr>
            <th>專區類型：</th>
            <td>
                <input type='radio' name='setting[is_official]' value="0" <?php if( $setting['is_official']!=1 ) echo "checked";?> id="normal_addid"> 普通&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='setting[is_official]' value="1" <?php if( $setting['is_official']==1 ) echo "checked";?>> 官網
            </td>
        </tr>
        <tr>
            <th width="200">Smarty模板：</th>
            <td>
                <input type='radio' name='setting[is_general_template]' value='0' <?php if( !$setting['is_general_template'] ) echo "checked";?> id="normal_addid"> 否&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='setting[is_general_template]' value='1' <?php if( $setting['is_general_template'] ) echo "checked";?> > 是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                註：除老的簡轉繁專區外，其他都選‘是’
                <!--<?php if( $setting['is_general_template'] ){ ?>
                    升級：&nbsp;&nbsp;
                    <input type="radio" name="setting[is_go_up]" value="0" <?php if( !$setting['is_go_up'] ) echo "checked";?> id="normal_addid"> 否&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="setting[is_go_up]" value="1" <?php if( $setting['is_go_up'] ) echo "checked";?> > 是
                <?php }?>-->
            </td>
        </tr>
        <tr>
            <th width="200">移動模版：</th>
            <td>
                <input type='radio' name='setting[is_mobile_template]' value='0' <?php if( !$setting['is_mobile_template'] ) echo "checked";?> id="normal_addid"> 不啟用&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='setting[is_mobile_template]' value='1' <?php if( $setting['is_mobile_template'] ) echo "checked";?> > 啟用
            </td>
        </tr>
        <tr>
            <th width="200">啟用搜索：</th>
            <td>
                <input type='radio' name='setting[is_search]' value='0' <?php if( !$setting['is_search'] ) echo "checked";?> id="normal_addid"> 不啟用&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='setting[is_search]' value='1' <?php if( $setting['is_search'] ) echo "checked";?> > 啟用
                &nbsp;&nbsp;&nbsp;&nbsp;搜索代碼：&nbsp;
                <input name='setting[search_code]' type='text' id='meta_title' value='<?php echo $setting['search_code'];?>' size='40' maxlength='40'>
            </td>
        </tr>
        <tr>
            <th width="200">卡牌數據庫標識：</th>
            <td><input name='setting[card_db_ename]' type='text' id='meta_title' value='<?php echo $setting['card_db_ename'];?>' size='60' maxlength='60'></td>
        </tr>
        <tr>
            <th width="200">英文標識：</th>
            <td>
                <input name='info[domain_dir]' type='text' id='meta_title' value='<?php echo $domain_dir;?>' size='60' maxlength='60'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                專區係數：<input type="text" name="setting[strategy_weight]" class="input-text" value="<?php echo $setting['strategy_weight'];?>" />
            </td>
        </tr>
        <tr>
            <th width="200">社區id：</th>
            <td>
                <input name='info[bbs_id]' type='text' id='meta_title' value='<?php echo $bbs_id;?>' size='60' maxlength='60'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='setting[is_newbbs]' value='0' <?php if( !$setting['is_newbbs'] ) echo "checked";?> id="normal_addid"> 老bbs&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' name='setting[is_newbbs]' value='1' <?php if( $setting['is_newbbs'] ) echo "checked";?> > 新feed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                BBS係數：<input type="text" name="setting[bbs_weight]" class="input-text" value="<?php echo $setting['bbs_weight'];?>" />
            </td>
        </tr>
        <?php }?>

        <?php if($parentid){?>
         <tr>
            <th>圖鑑圖片：</th>
            <td>
                <?php
                    $tj_pic = form::images_partition('setting[tj_pic]', 'tj_pic', $setting['tj_pic'], 'tj_pic','','','input-text');
                    echo $tj_pic;
                ?>
            </td>
          </tr>
         <tr>
            <th>欄目轉向鏈接：</th>
            <td>
                <input name='setting[tj_link]' type='text' id='meta_title' value='<?php echo $setting['tj_link'];?>' size='60' maxlength='60'>
            </td>
          </tr>
        <?php }?>

        <tr>
            <th><?php if( !$parentid ){ echo L('catgory_img'); }else{ echo "欄目圖片"; } ?>：</th>
            <td><?php echo form::images('info[image]', 'image', $image, 'content');?></td>
          </tr>
         <tr>
          <th><?php echo L('workflow');?>：</th>
          <td>
          <?php
            $workflows = getcache('workflow_'.$this->siteid,'commons');
            if($workflows) {
                $workflows_datas = array();
                foreach($workflows as $_k=>$_v) {
                    $workflows_datas[$_v['workflowid']] = $_v['workname'];
                }
                echo form::select($workflows_datas,$setting['workflowid'],'name="setting[workflowid]"',L('catgory_not_need_check'));
            } else {
                echo '<input type="hidden" name="setting[workflowid]" value="">';
                echo L('add_workflow_tips');
            }
        ?>
          </td>
        </tr>

        <tr>
         <th><?php echo L('ismenu');?>：</th>
          <td>
          <input type='radio' name='info[ismenu]' value='1' <?php if($ismenu) echo 'checked';?>> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
          <input type='radio' name='info[ismenu]' value='0' <?php if(!$ismenu) echo 'checked';?>> <?php echo L('no');?></td>
        </tr>

    </table>
</div>

<!-- 模板選擇  -->
<div id="div_setting_3" class="contentList pad-10 hidden">
    <table width="100%" class="table_form ">
        <tbody>
            <tr>
                <td width="120">模板類型：</td> 
                <td>
                    <input type='radio' name='setting[template_type]' onclick="show_tem_type(this.value)" value='0' <?php if($setting['template_type']==0) echo "checked";?> checked id="normal_addid"> 通用模板&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[template_type]' onclick="show_tem_type(this.value)" value='1' <?php if($setting['template_type']==1) echo "checked";?> > 新模板&nbsp;&nbsp;&nbsp;&nbsp; 
                    <input type='radio' name='setting[template_type]' onclick="show_tem_type(this.value)" value='2' <?php if($setting['template_type']==2) echo "checked";?> > 自定義模版
                </td>
            </tr>
        </tbody>

        <!-- 老模板 -->
        <tbody id="tem_type_0" <?php if($setting['template_type']!=0) echo 'style="display:none"';?> >
            <tr>
                <th width="200"></th>
                <td  id="other_template"><font color=red>使用專區通用配置模板</font></td>
            </tr> 
        </tbody>

        <!-- 新模板 -->
        <tbody id="tem_type_1" <?php if($setting['template_type']!=1) echo 'style="display:none"';?> >
            <?php if(!$parentid){?>
            <tr>
                <th width="200">色调：</th>
                <td style="text-align:left;">
                    <input type='radio' name='setting[tem_setting][partition_color]' value='red' <?php if($setting['tem_setting']['partition_color']=='red') echo 'checked'; ?> class="redirect_type" /> 紅色&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][partition_color]' value='blue' <?php if($setting['tem_setting']['partition_color']=='blue') echo 'checked'; ?> class="redirect_type" /> 藍色&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][partition_color]' value='peach' <?php if($setting['tem_setting']['partition_color']=='peach') echo 'checked'; ?> class="redirect_type" /> 桃色&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][partition_color]' value='green' <?php if($setting['tem_setting']['partition_color']=='green') echo 'checked'; ?> class="redirect_type" /> 綠色&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][partition_color]' value='brown' <?php if($setting['tem_setting']['partition_color']=='brown') echo 'checked'; ?> class="redirect_type" /> 棕色&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][partition_color]' value='purple' <?php if($setting['tem_setting']['partition_color']=='purple') echo 'checked'; ?> class="redirect_type" /> 紫色&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <?php }?>
        </tbody>


        <!-- 自定義模板 -->
       <!-- <tbody id="tem_type_2" <?php if($setting['template_type']!=2) echo 'style="display:none"';?> > -->
        <tbody id="tem_type_2" <?php if($setting['template_type']!=2) echo 'style="display:none"';?> >
            <?php if(!$parentid){?>
            <tr>
                <th width="200">自定義首頁：</th>
                <td>
                    <input type="text" name="setting[tem_new_2][index]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_2']['index'];?>">
                    <span style="width:200px;padding-left:100px;">移動版首頁：</span>
                    <input type="text" name="setting[tem_new_2][m_index]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_2']['m_index'];?>">
                </td>
            </tr>
            <?php }?>
            <tr height="36">
                <th width="200">自定義列表頁模板：</th>
                <td>
                    <input type="text" name="setting[tem_new_2][list]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_2']['list'];?>" >
                    <span style="width:200px;padding-left:100px;">列表頁模板：</span>
                    <input type="text" name="setting[tem_new_2][m_list]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_2']['m_list'];?>" >
                </td>
            </tr>
            <tr>
                <th width="200">自定義內容頁模板：</th>
                <td>
                    <input type="text" name="setting[tem_new_2][content]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_2']['content']; ?>">
                    <span style="width:500px;margin-left:100px;">內容頁模板：</span>
                    <input type="text" name="setting[tem_new_2][m_content]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_2']['m_content']; ?>">
                </td>
            </tr>
        </tbody>


         <!-- 自定義模板 -->
       <!-- <tbody id="tem_type_2" <?php if($setting['template_type']!=2) echo 'style="display:none"';?> > -->
        <?php if(!$parentid && false){?>
        <tbody id="tem_type_3" >
            <!-- 測試模版功能 -->
            <tr>
                <td width="120">測試模板配置：</td> 
            <td>
            </td>
            </tr>
            <tr>
            <th width="200">測試首頁：</th>
                <td>
                    <input type="text" name="setting[tem_new_test][index]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_test']['index'];?>">
                </td>
            </tr>
            <tr height="36">
            <th width="200">測試列表頁：</th>
                <td>
                    <input type="text" name="setting[tem_new_test][list]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_test']['list'];?>" >
                </td>
            </tr>
            <tr>
                <th width="200">測試內容頁：</th>
                <td>
                    <input type="text" name="setting[tem_new_test][content]" style="width:300px;" class="input-text" value="<?php echo $setting['tem_new_test']['content']; ?>">
                </td>
            </tr>
            <tr>
                <td width="120">
                    <input name="dosubmit_test" type="button" value="發布測試" class="button" onclick="javascript:window.top.art.dialog({id:'import',iframe:'?m=partition&c=partition&a=push_partition&p=<?php echo $_GET['catid'];?>', title:'專區發布', width:'700', height:'100', lock:true}, function(){var d = window.top.art.dialog({id:'import'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'import'}).close()});void(0);">

                    &nbsp;&nbsp;&nbsp;

                    <input name="look_test" type="button" value="點擊訪問測試效果" class="button" onclick="window.open('<?php echo "index.php?m=partition&c=index&a=init&p=".$domain_dir."&ptest=1"; ?>')">
                </td> 
                <td>
                </td>
            </tr>
        </tbody>
        <?php } ?>


    </table>
</div>

<!-- SEO配置及浮窗配置 -->
<div id="div_setting_4" class="contentList pad-10 hidden">
    <table width="100%" class="table_form ">
        <!--
        <tr>
          <th width="200"><strong>綁定域名</strong></th>
          <td><input name='setting[domain]' type='text' id='meta_title' value='<?php echo $setting['domain'];?>' size='60' maxlength='60'></td>
        </tr>
        -->

        <tr>
          <th width="200"><?php echo L('meta_title');?></th>
          <td><input name='setting[meta_title]' type='text' id='meta_title' value='<?php echo $setting['meta_title'];?>' size='60' maxlength='60'></td>
        </tr>
        <tr>
          <th ><?php echo L('meta_keywords');?></th>
          <td><textarea name='setting[meta_keywords]' id='meta_keywords' style="width:90%;height:40px"><?php echo $setting['meta_keywords'];?></textarea></td>
        </tr>
        <tr>
          <th ><strong><?php echo L('meta_description');?></th>
          <td><textarea name='setting[meta_description]' id='meta_description' style="width:90%;height:50px"><?php echo $setting['meta_description'];?></textarea></td>
        </tr>

        <!--浮窗內容配置 !$parentid為空，則說明是專區頂級欄目，則顯示。否則不顯示（目前此處功能預留，備後面如果專區需要顯示獨立的浮窗用）  -->   
        <?php if(!$parentid){?>
        <tr style="height:36px;" class="tr_bor_top">
            <th>浮層/廣告：</th>
            <td>
            </td>
        </tr>
        <tr style="height:36px;">
            <th style="width:130px;text-align:right;">浮窗<font color="red">廣告</font>配置：</th>
            <td style="text-align:left;" colspan="3">
                <input type="radio" name="setting[tem_setting][is_float]" value="0" id="is_float" <?php if(!$setting[tem_setting][is_float] ) echo "checked";?>> 不顯示&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="setting[tem_setting][is_float]" value="1" <?php if($setting[tem_setting][is_float]) echo "checked";?>> 顯示
            </td>
        </tr> 
        <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[tem_setting][floating][0][name]' value="<?php echo $setting['tem_setting']['floating'][0]['name'];?>" type='text' style='width:80px;'/>
                <?php 
                    $topic_pic_0 = $setting['tem_setting']['floating'][0]['pic'];
                    $curr_form_html = form::images_partition('setting[tem_setting][floating][0][pic]', 'floating_pic1', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[tem_setting][floating][0][link]' value="<?php echo $setting['tem_setting']['floating'][0]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr> 

        <!--浮窗文字配置-->
        <tr style="height:36px;" class="">
            <th style="width:130px;text-align:right;">通欄<font color="red">廣告</font>配置：</th>
            <td style="text-align:left;" colspan="3">
                <input type="radio" name="setting[tem_setting][is_ad]" value="0" id="is_ad" <?php if(!$setting[tem_setting][is_ad] ) echo "checked";?>> 不顯示&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="setting[tem_setting][is_ad]" value="1" <?php if($setting[tem_setting][is_ad]) echo "checked";?>> 顯示
            </td>
        </tr> 

        <tr>
            <th style="width:130px;text-align:right;"></th>
            <td style="text-align:left;" colspan="3">
                標題：<input name='setting[tem_setting][banner_ad][0][name]' value="<?php echo $setting['tem_setting']['banner_ad'][0]['name'];?>" type='text' style='width:80px;'/>
                <?php 
                    $topic_pic_0 = $setting['tem_setting']['banner_ad'][0]['pic'];
                    $curr_form_html = form::images_partition('setting[tem_setting][banner_ad][0][pic]', 'banner_ad_pic1', $topic_pic_0, 'partition','','','input-text');
                    echo $curr_form_html;
                ?>
                URL：<input name='setting[tem_setting][banner_ad][0][link]' value="<?php echo $setting['tem_setting']['banner_ad'][0]['link'];?>" id="redirect" style="width:300px;" />
            </td>
        </tr>

        <?php  } ?>
        <!--浮空配置結束-->

    </table>
</div>
<!--
<div id="div_setting_5" class="contentList pad-10 hidden">
    <table width="100%" >
            <tr>
            <th width="200"><?php echo L('role_private')?>：</th>
            <td>
                <table width="100%" class="table-list">
                  <thead>
                    <tr>
                      <th align="left"><?php echo L('role_name');?></th><th><?php echo L('view');?></th><th><?php echo L('add');?></th><th><?php echo L('edit');?></th><th><?php echo L('delete');?></th><th><?php echo L('listorder');?></th><th><?php echo L('push');?></th><th><?php echo L('move');?></th>
                  </tr>
                    </thead>
                     <tbody>
                    <?php
                    $roles = getcache('role','commons');
                    foreach($roles as $roleid=> $rolrname) {
                    $disabled = $roleid==1 ? 'disabled' : '';

                    ?>
                    <tr>
                      <td><?php echo $rolrname?></td>
                      <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('init',$roleid);?> value="init,<?php echo $roleid;?>" ></td>
                      <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('add',$roleid);?> value="add,<?php echo $roleid;?>" ></td>
                      <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('edit',$roleid);?> value="edit,<?php echo $roleid;?>" ></td>
                      <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('delete',$roleid);?> value="delete,<?php echo $roleid;?>" ></td>
                      <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('listorder',$roleid);?> value="listorder,<?php echo $roleid;?>" ></td>
                      <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('push',$roleid);?> value="push,<?php echo $roleid;?>" ></td>
                      <td align="center"><input type="checkbox" name="priv_roleid[]" <?php echo $disabled;?> <?php echo $this->check_category_priv('move',$roleid);?> value="move,<?php echo $roleid;?>" ></td>
                  </tr>
                  <?php }?>

                 </tbody>
                </table>
            </td>

          </tr>
            <tr><td colspan=2><hr style="border:1px dotted #F2F2F2;"></td>
            </tr>

          <tr>
            <th width="200"><?php echo L('group_private')?>：</th>
            <td>
                <table width="100%" class="table-list">
                  <thead>
                    <tr>
                      <th align="left"><?php echo L('group_name');?></th><th><?php echo L('allow_vistor');?></th><th><?php echo L('allow_contribute');?></th>
                  </tr>
                    </thead>
                     <tbody>
                <?php
                $group_cache = getcache('grouplist','member');
                foreach($group_cache as $_key=>$_value) {
                if($_value['groupid']==1) continue;
                ?>
                    <tr>
                      <td><?php echo $_value['name'];?></td>
                      <td align="center"><input type="checkbox" name="priv_groupid[]"  <?php echo $this->check_category_priv('visit',$_value['groupid'],0);?> value="visit,<?php echo $_value['groupid'];?>" ></td>
                      <td align="center"><input type="checkbox" name="priv_groupid[]"  <?php echo $this->check_category_priv('add',$_value['groupid'],0);?> value="add,<?php echo $_value['groupid'];?>" ></td>
                  </tr>
                <?php }?>
                 </tbody>
                </table>
            </td>
          </tr>
          <tr>
           <th width="200"><?php echo L('apply_to_child');?></th>
            <td><input type='radio' name='priv_child' value='1'> <?php echo L('yes');?>&nbsp;&nbsp;&nbsp;&nbsp;
          <input type='radio' name='priv_child' value='0' checked> <?php echo L('no');?></td></td>
          </tr>
    </table>
</div>
-->

<!-- 關聯遊戲，只有專區修改才可配置  -->
<?php if( $parentid == 0 ){ ?>
    <div id="div_setting_6" class="contentList pad-10 hidden">
        <table width="100%" class="table_form">

            <!--
            <tr>
                <th width="200"><?php echo L('contribute_add_point');?></th>
                    <td><input name='setting[presentpoint]' type='text' value='1' size='5' maxlength='5' style='text-align:center'> <?php echo L('contribute_add_point_tips');?></td>
            </tr>
            -->

            <tr>
                <th width="200"><strong>所屬遊戲：</strong></th>
                <td>
                    <input type="hidden" name="relation_game" id="relation_hao" value="<?php echo $related_games; ?>" style="50">
                    <div>
                    <!-- <input type="text" id='relation_hao_text' /> -->
                    <ul class='list-dot' style='line-height:28px;' id='relation_hao_text'>
                        <?php
                        $related_games_array = explode( '|',$related_games );
                        if( !empty($related_games_array[0]) ){
                            foreach( $related_games_array as $key=>$value ){
                                //game_data = game_str + '-' + id;
                                if(strpos($value, '-')){
                                    //關聯的老庫遊戲
                                    $temp_game_info = explode('-',$value);
                                    echo "<li id='game".$temp_game_info[1]."' style='width:210px;float:left;padding-right:5px;'>·<span>".$game_info_array[$value]."</span><a href='javascript:;' class='close' style='padding-bottom:5px;' onclick=\"remove_relation_game_partition('relation_hao','game".$temp_game_info[1]."','".$value."')\"></a></li>";
                                }else{
                                    //關聯的新庫遊戲
                                    echo "<li id='game".$value."' style='width:210px;float:left;padding-right:5px;'>·<span>".$game_info_array[$value]."</span><a href='javascript:;' class='close' style='padding-bottom:5px;' onclick=\"remove_relation_game_partition('relation_hao','game".$value."','".$value."')\"></a></li>";
                                }
                                
                            }
                        }
                        ?>
                    </ul>
                    <input type="button" value="選擇所屬遊戲" onclick="omnipotent('select_hao','<?php echo APP_PATH;?>index.php?m=partition&c=partition&a=public_relation_game_list','選擇所屬遊戲(新)',1)" class="button">
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- 頭圖  -->
    <div id="div_setting_7" class="pad-10 hidden">
        <table width="100%">
            <tr>
                <th width="5%">排序</th>
                <th width="10%">名稱</th>
                <th width="30%">圖片</th>
                <th width="30%">跳轉</th>
                <th width="8%">操作</th>
                <th width="3%"></th>
            </tr>

            <!--
            <tr style="margin-top:10px;">
                <td><input name='header_pic[0][name]' type='text' style=''/></td>
                <td style="text-align:center;"><?php echo form::upfiles('header_pic[0][url]', 'pic_url', '', 'hao', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
                <td>
                    <input type='radio' name='header_pic[0][redirect_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='header_pic[0][redirect_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name='header_pic[0][redirect]' id="redirect" />
                </td>
                <td style="text-align:center;"><a href="javascript:void(0)" class="dele_header_pic">刪除</a></td>
                <td style="text-align:center;"><a href="javascript:void(0)" class="add_header_pic">新增</a></td>
            </tr>-->
            <?php
                if( !empty($header_pic_array) ){
                    foreach( $header_pic_array as $key=>$value ){

                        $checked_catid = '';
                        $checked_url = '';
                        if( $value['redirect_type']==1 ){
                            $checked_catid = 'checked';
                        }else{
                            $checked_url = 'checked';
                        }

                            $temp_image = form::images_partition('header_pic['.$key.'][image]', 'image_headerpic'.$key, $value['image'], 'partition','','','input-text');
                            $new_item_html = "<tr style='margin-top:10px;'><td><input name='header_pic[$key][listorder]' type='text' class='input-text' style='width:30px;' value='{$value['listorder']}'/></td><td><input name='header_pic[{$key}][name]' type='text' value='{$value['name']}' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>{$temp_image}</td><td><input type='radio' name='header_pic[{$key}][redirect_type]' value='0' {$checked_url} checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='header_pic[{$key}][redirect_type]' value='1' {$checked_catid} class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='header_pic[{$key}][redirect_type]' value='2' {$checked_catid} class='redirect_type' /> 瀏覽器&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='header_pic[{$key}][redirect]' value='{$value['redirect']}' class='input-text' style='width:300px;' id='redirect_btn' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_header_pic'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_header_pic'>新增</a></td></tr>";
                        echo $new_item_html;
                    }
                }else{
                        $temp_image = form::images_partition('header_pic[0][image]', 'image_headerpic0', '', 'partition','','','input-text');
                    $new_item_html = "<tr style='margin-top:10px;'><td><input name='header_pic[0][name]' type='text' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>{$temp_image}</td><td><input type='radio' name='header_pic[0][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='header_pic[0][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='header_pic[0][redirect]' class='input-text' id='redirect_btn' style='width:300px;'/></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_header_pic'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_header_pic'>新增</a></td></tr>";
                    echo $new_item_html;
                }
            ?>

            <!--
            <tr>
                <th width="200"><?php echo L('contribute_add_point');?></th>
                    <td><input name='setting[presentpoint]' type='text' value='1' size='5' maxlength='5' style='text-align:center'> <?php echo L('contribute_add_point_tips');?></td>
            </tr>
            -->

            <!--
            <tr>
                <th width="200"><strong>所屬遊戲：</strong></th>
                <td>
                    <input type="hidden" name="relation_game" id="relation_hao" value="" style="50">
                    <div>
                    <ul class='list-dot' style='line-height:28px;' id='relation_hao_text'></ul>
                    <input type="button" value="選擇所屬遊戲" onclick="omnipotent('select_hao','<?php echo APP_PATH;?>index.php?m=partition&amp;c=partition&amp;a=game_info','選擇所屬遊戲',1)" class="button">
                    </div>
                </td>
            </tr>
            -->
        </table>
    </div>

    <!-- 跳轉button -->
    <div id="div_setting_8" class="pad-10 hidden">
        <table width="100%">
            <tr>
                <th width="10%">名稱</th>
                <th width="30%">圖片</th>
                <th width="30%">跳轉</th>
                <th width="8%">操作</th>
                <th width="3%"></th>
            </tr>

            <!--
            <tr style="margin-top:10px;">
                <td><input name='redirect_button[0][name]' type='text' style="margin-top:10px;"/></td>
                <td style="text-align:center;"><?php echo form::upfiles('redirect_button[0][url]', 'pic_url2', '', 'hao2', '', 50, '', '', 'gif|jpg|jpeg|png|bmp')?></td>
                <td>
                    <input type='radio' name='redirect_button[0][redirect_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='redirect_button[0][redirect_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name='redirect_button[0][redirect]' id="redirect_btn" />
                </td>
                <td style="text-align:center;"><a href="javascript:void(0)" class="dele_redirect_button">刪除</a></td>
                <td style="text-align:center;"><a href="javascript:void(0)" class="add_redirect_button">新增</a></td>
            </tr>
            -->

            <?php
                if( !empty($redirect_button_array) ){
                    foreach( $redirect_button_array as $key=>$value ){

                        $checked_catid = '';
                        $checked_url = '';
                        if( $value['redirect_type']==1 ){
                            $checked_catid = 'checked';
                        }else{
                            $checked_url = 'checked';
                        }
                            $temp_image = form::images_partition('redirect_button['.$key.'][image]', 'image_redirect'.$key, $value['image'], 'partition','','','input-text');
                        $new_item_html = "<tr style='margin-top:10px;'><td><input name='redirect_button[{$key}][name]' type='text' value='{$value['name']}' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>{$temp_image}</td><td><input type='radio' name='redirect_button[{$key}][redirect_type]' value='0' {$checked_url} class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='redirect_button[{$key}][redirect_type]' value='1' {$checked_catid} class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='redirect_button[{$key}][redirect]' value='{$value['redirect']}' class='input-text' id='redirect_btn' style='width:300px;' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_redirect_button'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_redirect_button'>新增</a></td></tr>";
                        echo $new_item_html;
                    }
                }else{
                        $temp_image = form::images_partition('redirect_button[0][image]', 'image_redirect0', '', 'partition','','','input-text');
                    $new_item_html = "<tr style='margin-top:10px;'><td><input name='redirect_button[0][name]' type='text' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>{$temp_image}</td><td><input type='radio' name='redirect_button[0][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='redirect_button[0][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='redirect_button[0][redirect]' class='input-text' id='redirect_btn' style='width:300px;' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_redirect_button'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_redirect_button'>新增</a></td></tr>";
                    echo $new_item_html;
                }
            ?>
        </table>
    </div>

    <!-- 遊戲下載信息 -->
    <div id="div_setting_9" class="contentList pad-10 hidden">
        <table width="100%" style="float:left;width:500px;margin:0 80px;">
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">app名：</th>
                <td style="text-align:left;"><input name='setting[app_down][name]' type='text' style="width:300px;" value="<?php echo $setting['app_down']['name'];?>"/></td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">遊戲Logo：</th>
                <td style="text-align:left;">
                    <?php
                        $app_down_logo = form::images_partition('setting[app_down][image]', 'pic_url3', $setting['app_down']['image'], 'hao3','','','app_down_logo input-text');
                        echo $app_down_logo;
                    ?>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">遊戲描述：</th>
                <td style="text-align:left;">
                    <textarea rows="3" cols="50" name='setting[app_down][desc]' style="width:300px;" ><?php echo $setting['app_down']['desc'];?></textarea>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">IOS下載：</th>
                <td style="text-align:left;">
                    <input name='setting[app_down][ios]' type='text' style="width:300px;" value="<?php echo $setting['app_down']['ios'];?>" />
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">Android下載：</th>
                <td style="text-align:left;">
                    <input name='setting[app_down][android]' type='text' style="width:300px;" value="<?php echo $setting['app_down']['android'];?>"/>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">三方渠道下載：</th>
                <td style="text-align:left;">
                    <input name='setting[app_down][apk]' type='text' style="width:300px;" value="<?php echo $setting['app_down']['apk'];?>"/>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">二維碼：</th>
                <td style="text-align:left;">
                    <?php
                        $app_down_qrcode = form::images_partition('setting[app_down][qrcode]', 'qrcode', $setting['app_down']['qrcode'], 'qrcode','','','app_down_logo input-text');
                        echo $app_down_qrcode;
                    ?>
                </td>
            </tr>
        </table>
        <table width="100%" style="float:left;width:500px;margin:0 80px;">
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">助手名：</th>
                <td style="text-align:left;">
                    <input name='setting[app_help][name]' type='text' style="width:300px;" value="<?php echo $setting['app_help']['name'];?>"/>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">助手Logo：</th>
                <td style="text-align:left;">
                    <?php
                        $app_help_logo = form::images_partition('setting[app_help][image]', 'pic_url4', $setting['app_help']['image'], 'hao3','','','app_down_logo input-text');
                        echo $app_help_logo;
                    ?>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">助手描述：</th>
                <td style="text-align:left;">
                    <textarea rows="3" cols="50" name='setting[app_help][desc]' style="width:300px;" ><?php echo $setting['app_help']['desc'];?></textarea>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">IOS下載：</th>
                <td style="text-align:left;">
                    <input name='setting[app_help][ios]' type='text' style="width:300px;" value="<?php echo $setting['app_help']['ios'];?>" />
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">Android下載：</th>
                <td style="text-align:left;">
                    <input name='setting[app_help][android]' type='text' style="width:300px;" value="<?php echo $setting['app_help']['android'];?>"/>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">三方渠道下載：</th>
                <td style="text-align:left;">
                    <input name='setting[app_help][apk]' type='text' style="width:300px;" value="<?php echo $setting['app_help']['apk'];?>"/>
                </td>
            </tr>
            <tr style="height:36px;">
                <th style="text-align:right;width:100px;">二維碼：</th>
                <td style="text-align:left;">
                    <?php
                        $app_help_qrcode = form::images_partition('setting[app_help][qrcode]', 'qrcode_help', $setting['app_help']['qrcode'], 'qrcode_help','','','app_down_logo input-text');
                        echo $app_help_qrcode;
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- 友情鏈接配置 -->
    <!-- 新增文章內鏈配置 -->
    <div id="div_setting_10" class="contentList pad-10 hidden">
        <table width="100%" class="table_form ">
            <?php $setting['tem_setting']['partlink'] = $setting['tem_setting']['partlink'] ? $setting['tem_setting']['partlink'] : array();?>
            <?php usort($setting['tem_setting']['partlink']['links'],"partition_list_cmp_listorder"); ?>
            
            <!-- 判斷是否用專區統一友鏈 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">方案：</th>
                <td style="text-align:left;" colspan="2">
                    <input type='radio' name='setting[tem_setting][partlink][type]' value='1' <?php if($setting['tem_setting']['partlink']['type']=='1') echo 'checked'; ?> class="redirect_type" /> 新增在前&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][partlink][type]' value='2' <?php if($setting['tem_setting']['partlink']['type']=='2') echo 'checked'; ?> class="redirect_type" /> 新增在後&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][partlink][type]' value='0' <?php if($setting['tem_setting']['partlink']['type']=='0') echo 'checked'; ?> class="redirect_type" /> 不使用統一友鏈&nbsp;&nbsp;&nbsp;&nbsp;
                    (<font color="green">添加新友鏈時，鏈接首務必添加"http://"</font>)
                </td>
            </tr>
            <!-- 添加友鏈 -->
            <?php if(empty($setting['tem_setting']['partlink']['links'])){?>
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">友情鏈接：</th>
                <td style="text-align:left;">
                    排序：<input name='setting[tem_setting][partlink][links][0][listorder]' type='text' class="input-text-c" style='width:37px;'/>
                    標題：<input name='setting[tem_setting][partlink][links][0][title]' type='text' style='width:150px;'/>
                    鏈接：<input name='setting[tem_setting][partlink][links][0][url]' id="redirect" style="width:300px;" />
                </td>
                <td style="text-align:left;width:100px;">
                    <a href="javascript:void(0)" class="dele_nav_item">刪除</a>&nbsp;|&nbsp;<a href="javascript:void(0)" class="add_link_item">新增</a>
                </td>
            </tr>
            <?php }?>
            <?php foreach( $setting['tem_setting']['partlink']['links'] as $k_ts=>$v_ts ){?>
            <tr style="height:36px;">
                <th style="width:80px;text-align:right;"><?php if ($k_ts==0) echo '友情鏈接：';?></th>
                <td style="text-align:left;">
                    排序：<input name='setting[tem_setting][partlink][links][<?php echo $k_ts;?>][listorder]' value="<?php echo $v_ts['listorder'];?>" type='text' class="input-text-c" style='width:37px;'/>
                    標題：<input name='setting[tem_setting][partlink][links][<?php echo $k_ts;?>][title]' value="<?php echo $v_ts['title'];?>" type='text' style='width:150px;'/>
                    鏈接：<input name='setting[tem_setting][partlink][links][<?php echo $k_ts;?>][url]' value="<?php echo $v_ts['url'];?>" id="redirect" style="width:300px;" />
                </td>
                <td style="text-align:left;width:100px;">
                    <a href="javascript:void(0)" class="dele_nav_item">刪除</a>&nbsp;|&nbsp;<a href="javascript:void(0)" class="add_link_item">新增</a>
                </td>
            </tr>
            <?php }?>
        </table>
        <table width="100%" class="table_form tr_bor_top">
            <?php if(empty($setting['tem_setting']['keylink'])){?>
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">文章內鏈：</th>
                <td style="text-align:left;">
                    標題：<input name='setting[tem_setting][keylink][0][title]' type='text' style='width:150px;'/>
                    鏈接：<input name='setting[tem_setting][keylink][0][url]' id="redirect" style="width:300px;" />
                </td>
                <td style="text-align:left;width:100px;">
                    <a href="javascript:void(0)" class="dele_nav_item">刪除</a>&nbsp;|&nbsp;<a href="javascript:void(0)" class="add_keylink_item">新增</a>
                </td>
            </tr>
            <?php }?>
            <?php $keylink_sign = 0;?>
            <?php foreach( $setting['tem_setting']['keylink'] as $k_ts=>$v_ts ){?>
                <?php $keylink_sign++;?>
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;"><?php if ($keylink_sign==1) echo '文章內鏈：';?></th>
                    <td style="text-align:left;">
                        標題：<input name='setting[tem_setting][keylink][<?php echo $k_ts;?>][title]' value="<?php echo $v_ts['title'];?>" type='text' style='width:150px;'/>
                        鏈接：<input name='setting[tem_setting][keylink][<?php echo $k_ts;?>][url]' value="<?php echo $v_ts['url'];?>" id="redirect" style="width:300px;" />
                    </td>
                    <td style="text-align:left;width:100px;">
                        <a href="javascript:void(0)" class="dele_nav_item">刪除</a>&nbsp;|&nbsp;<a href="javascript:void(0)" class="add_keylink_item">新增</a>
                    </td>
                </tr>
            <?php }?>
        </table>
    </div>

    <!-- 通用配置信息 -->
    <div id="div_setting_11" class="contentList pad-10 hidden">
        <table width="100%" class="table_form ">
            <?php
                // 如果是官網並且模版選擇不是0（即通用模版），則隱藏其他項只顯示統計代碼
                //if( $setting['template_type'] != 0 ){
                    //$display_type = "style='display:none;'";
                //}else{
                    $display_type = "";
                //}
            ?>
            <tbody <?php echo $display_type;?>>
                <!-- 通用模版色調 -->
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;">通用模版：</th>
                    <td style="text-align:left;">
                        色調：
                        <input type='radio' name='setting[tem_setting][partition_type]' value='darkblue' <?php if($setting['tem_setting']['partition_type']=='darkblue') echo 'checked'; ?> class="redirect_type" /> 深色&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][partition_type]' value='whiteblue' <?php if($setting['tem_setting']['partition_type']=='whiteblue') echo 'checked'; ?> class="redirect_type" /> 白藍&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][partition_type]' value='whitegreen' <?php if($setting['tem_setting']['partition_type']=='whitegreen') echo 'checked'; ?> class="redirect_type" /> 白綠&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][partition_type]' value='darkblue_new' <?php if($setting['tem_setting']['partition_type']=='darkblue_new') echo 'checked'; ?> class="redirect_type" /> 新深色&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][partition_type]' value='whiteblue_new' <?php if($setting['tem_setting']['partition_type']=='whiteblue_new') echo 'checked'; ?> class="redirect_type" /> 新白藍&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][partition_type]' value='whitegreen_new' <?php if($setting['tem_setting']['partition_type']=='whitegreen_new') echo 'checked'; ?> class="redirect_type" /> 新白綠&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td colspan="2">
                        大導航高度：
                        <input type='radio' name='setting[tem_setting][nav_height]' value='45' <?php if($setting['tem_setting']['nav_height']=='45') echo 'checked'; ?> class="redirect_type" /> 無熱鏈&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][nav_height]' value='76' <?php if($setting['tem_setting']['nav_height']=='76') echo 'checked'; ?> class="redirect_type" /> 一行熱鏈&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][nav_height]' value='106' <?php if($setting['tem_setting']['nav_height']=='106') echo 'checked'; ?> class="redirect_type" /> 兩行熱鏈&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <!-- 大導航 -->
                <?php $setting['tem_setting']['nav'] = $setting['tem_setting']['nav'] ? $setting['tem_setting']['nav'] : array();?>
                <?php usort($setting['tem_setting']['nav'],"partition_list_cmp_listorder"); ?>

                <?php if(empty($setting['tem_setting']['nav'])){?>
                    <tr style="height:36px;" class="tr_bor_top">
                        <th style="width:130px;text-align:right;">大導航：</th>
                        <td style="text-align:left;">
                            排序：<input name='setting[tem_setting][nav][0][listorder]' type='text' style='width:50px;'/>
                            名字：<input name='setting[tem_setting][nav][0][name]' type='text' style='width:200px;'/>
                        </td>
                        <td>
                            <input type='radio' name='setting[tem_setting][nav][0][nav_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='setting[tem_setting][nav][0][nav_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name='setting[tem_setting][nav][0][nav_value]' id="redirect" style="width:300px;" />
                        </td>
                        <td style="text-align:left;">
                            <a href="javascript:void(0)" class="dele_nav_item">刪除</a> |
                            <a href="javascript:void(0)" class="add_nav_item">新增</a>
                        </td>
                    </tr>
                <?php }?>
                <?php foreach( $setting['tem_setting']['nav'] as $k_ts=>$v_ts ){?>
                    <tr style="height:36px;" <?php if ($k_ts==0) echo "class='tr_bor_top'";?>>
                        <th style="width:130px;text-align:right;"><?php if ($k_ts==0) echo '大導航：';?></th>
                        <td style="text-align:left;">
                            排序：<input name='setting[tem_setting][nav][<?php echo $k_ts;?>][listorder]'  value="<?php echo $v_ts['listorder'];?>" type='text' style='width:50px;'/>
                            名字：<input name='setting[tem_setting][nav][<?php echo $k_ts;?>][name]' value="<?php echo $v_ts['name'];?>" type='text' style='width:200px;'/>
                        </td>
                        <td>
                            <input type='radio' name='setting[tem_setting][nav][<?php echo $k_ts;?>][nav_type]' value='0' <?php if($v_ts['nav_type']==0){echo "checked"; }?> class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='setting[tem_setting][nav][<?php echo $k_ts;?>][nav_type]' value='1' <?php if($v_ts['nav_type']==1){echo "checked";} ?> class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name='setting[tem_setting][nav][<?php echo $k_ts;?>][nav_value]' value="<?php echo $v_ts['nav_value'];?>" id="redirect" style="width:300px;" />
                        </td>
                        <td style="text-align:left;">
                            <a href="javascript:void(0)" class="dele_nav_item">刪除</a> |
                            <a href="javascript:void(0)" class="add_nav_item">新增</a>
                        </td>
                    </tr>
                <?php }?>
                <!-- 導航下小鏈接 -->
                <?php $setting['tem_setting']['littlenav'] = $setting['tem_setting']['littlenav'] ? $setting['tem_setting']['littlenav'] : array();?>
                <tr style="height:36px;" class="tr_bor_top">
                    <th style="width:130px;text-align:right;">導航小鏈接：</th>
                    <td style="text-align:left;" colspan="3">
                        類型： 
                        <select name='littlenav_type' class="littlenav_type">
                            <!-- <option value="1">詳情頁url</option> -->
                            <option value="2">列表頁欄目ID</option>
                            <option value="3">欄目下短標題</option>
                        </select>
                        <a href="javascript:void(0)" class="add_littlenav_type">新增</a>
                    </td>
                </tr>
                <tr class="tr_end_point" style="display:none;"></tr>
                <?php if(isset($setting['tem_setting']['littlenav']['list_id'])){?>
                <?php foreach( $setting['tem_setting']['littlenav']['list_id'] as $k_ts=>$v_ts ){?>
                    <tr style='height:36px;'>
                        <th style='width:130px;text-align:right;'></th>
                        <td style='text-align:left;'>
                            排序：<input class='input-text' name='setting[tem_setting][littlenav][list_id][<?php echo $k_ts;?>][listorder]' value='<?php echo $v_ts["listorder"];?>' type='text' style='width:50px;'/>
                            類型：列表頁欄目id <input class='input-text' name='setting[tem_setting][littlenav][list_id][<?php echo $k_ts;?>][type]' value='<?php echo $v_ts["type"];?>' type='text' style='display:none;'>
                            <span style='float:right;'>分類標題：<input class='input-text' name='setting[tem_setting][littlenav][list_id][<?php echo $k_ts;?>][title]' value='<?php echo $v_ts["title"];?>' type='text' style='width:80px;'/></span>
                        </td>
                        <td>
                            欄目ID數組：<input class='input-text' name='setting[tem_setting][littlenav][list_id][<?php echo $k_ts;?>][partid_arr]' value='<?php echo $v_ts["partid_arr"];?>' id='redirect' style='width:300px;' />
                        </td>
                        <td>
                            <a href='javascript:void(0)' class='dele_nav_item'>刪除</a>
                        </td>
                    </tr>
                <?php }?>
                <?php }?>
                <?php if(isset($setting['tem_setting']['littlenav']['id_list'])){?>
                <?php foreach( $setting['tem_setting']['littlenav']['id_list'] as $k_ts=>$v_ts ){?>
                    <tr style='height:36px;'>
                        <th style='width:130px;text-align:right;'></th>
                        <td style='text-align:left;'>
                            排序：<input class='input-text' name='setting[tem_setting][littlenav][id_list][<?php echo $k_ts;?>][listorder]' value='<?php echo $v_ts["listorder"];?>' type='text' style='width:50px;'/>
                            類型：欄目下短標題 <input class='input-text' name='setting[tem_setting][littlenav][id_list][<?php echo $k_ts;?>][type]' value='<?php echo $v_ts["type"];?>' type='text' style='display:none;'>
                            <span style='float:right;'>分類標題：<input class='input-text' name='setting[tem_setting][littlenav][id_list][<?php echo $k_ts;?>][name]' value='<?php echo $v_ts["name"];?>' type='text' style='width:80px;'/></span>
                        </td>
                        <td>
                            欄目ID：<input class='input-text' name='setting[tem_setting][littlenav][id_list][<?php echo $k_ts;?>][partid]' value='<?php echo $v_ts["partid"];?>' type='text' style='width:80px;'/>
                            調用條數：<input class='input-text' name='setting[tem_setting][littlenav][id_list][<?php echo $k_ts;?>][nums]' value='<?php echo $v_ts["nums"];?>' type='text' style='width:80px;'/>
                        </td>
                        <td>
                            <a href='javascript:void(0)' class='dele_nav_item'>刪除</a>
                        </td>
                    </tr>
                <?php }?>
                <?php }?>
                <!-- 快捷導航 -->
                <?php $setting['tem_setting']['fastnav'] = $setting['tem_setting']['fastnav'] ? $setting['tem_setting']['fastnav'] : array();?>
                <?php usort($setting['tem_setting']['fastnav'],"partition_list_cmp_listorder"); ?>

                <?php if(empty($setting['tem_setting']['fastnav'])){?>
                    <tr style="height:36px;" class="tr_bor_top">
                        <th style="width:130px;text-align:right;">快捷導航：</th>
                        <td style="text-align:left;">
                            排序：<input name='setting[tem_setting][fastnav][0][listorder]' type='text' style='width:50px;'/>
                            名字：<input name='setting[tem_setting][fastnav][0][title]' type='text' style='width:200px;'/>
                        </td>
                        <td style="text-align:left;">
                            <input type='radio' name='setting[tem_setting][fastnav][0][nav_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='setting[tem_setting][fastnav][0][nav_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name='setting[tem_setting][fastnav][0][fastnav_id]' id="redirect" style="width:300px;" />
                        </td>
                        <td style="text-align:left;">
                            <a href="javascript:void(0)" class="dele_nav_item">刪除</a> |
                            <a href="javascript:void(0)" class="add_fastnav_item">新增</a>
                        </td>
                    </tr>
                <?php }?>
                <?php foreach( $setting['tem_setting']['fastnav'] as $k_ts=>$v_ts ){?>
                    <tr style="height:36px;" <?php if ($k_ts==0) echo "class='tr_bor_top'";?>>
                        <th style="width:130px;text-align:right;"><?php if ($k_ts==0) echo '快捷導航：';?></th>
                        <td style="text-align:left;">
                            排序：<input name='setting[tem_setting][fastnav][<?php echo $k_ts;?>][listorder]'  value="<?php echo $v_ts['listorder'];?>" type='text' style='width:50px;'/>
                            名字：<input name='setting[tem_setting][fastnav][<?php echo $k_ts;?>][title]' value="<?php echo $v_ts['title'];?>" type='text' style='width:200px;'/>
                        </td>
                        <td style="text-align:left;">
                            <input type='radio' name='setting[tem_setting][fastnav][<?php echo $k_ts;?>][nav_type]' value='0' <?php if($v_ts['nav_type']==0){echo "checked"; }?> class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='setting[tem_setting][fastnav][<?php echo $k_ts;?>][nav_type]' value='1' <?php if($v_ts['nav_type']==1){echo "checked";} ?> class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name='setting[tem_setting][fastnav][<?php echo $k_ts;?>][fastnav_id]' value="<?php echo $v_ts['fastnav_id'];?>" id="redirect" style="width:300px;" />
                        </td>
                        <td style="text-align:left;">
                            <a href="javascript:void(0)" class="dele_nav_item">刪除</a> |
                            <a href="javascript:void(0)" class="add_fastnav_item">新增</a>
                        </td>
                        <td style="width:350px;"></td>
                    </tr>
                <?php }?>
                <!-- 論壇 -->
                <tr style="height:36px;" class="tr_bor_top">
                    <th style="width:130px;text-align:right;">接口相關：</th>
                    <td style="text-align:left;">
                        專區論壇：<input name='setting[tem_setting][bbs_nav_url]' value="<?php echo $setting['tem_setting']['bbs_nav_url'];?>" type='text' style="width:300px;" />&nbsp;(<font color="green">論壇鏈接</font>)
                    </td>
                    <td style="text-align:left;" colspan="2">
                        熱貼接口：<input name='setting[tem_setting][bbs_cat_api_url]' value="<?php echo $setting['tem_setting']['bbs_cat_api_url'];?>" type='text' style="width:50px;" />&nbsp;(<font color="green">bbs門戶權限用戶配置，此為接口bid</font>)
                    </td>
                </tr>
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;"></th>
                    <td style="text-align:left;">
                        禮包鏈接：<input name='setting[tem_setting][mf_libao_url]' value="<?php echo $setting['tem_setting']['mf_libao_url'];?>" type='text' style="width:300px;" />&nbsp;(<font color="green">禮包鏈接</font>)
                    </td>
                    <td style="text-align:left;" colspan="2">
                        Q群接口：
                        群號：<input name='setting[tem_setting][qq_qun_url][qun_hao]' value="<?php echo $setting['tem_setting']['qq_qun_url']['qun_hao'];?>" type='text' style="width:80px;" />
                        idkey：<input name='setting[tem_setting][qq_qun_url][qun_idkey]' value="<?php echo $setting['tem_setting']['qq_qun_url']['qun_idkey'];?>" type='text' style="width:380px;" />&nbsp;(<font color="green">Q群管理員權限用戶配置</font>)
                    </td>
                </tr>
                <!-- 專題四圖 -->
                <tr>
                    <th style="width:130px;text-align:right;">專題四圖：</th>
                    <td style="text-align:left;" colspan="3">
                        標題：<input name='setting[tem_setting][topic_pic][0][name]' value="<?php echo $setting['tem_setting']['topic_pic'][0]['name'];?>" type='text' style='width:80px;'/>
                        <?php 
                            $topic_pic_0 = $setting['tem_setting']['topic_pic'][0]['pic'];
                            $curr_form_html = form::images_partition('setting[tem_setting][topic_pic][0][pic]', 'topic_pic1', $topic_pic_0, 'partition','','','input-text');
                            echo $curr_form_html;
                        ?>
                        <input style="margin-left:100px;" type='radio' name='setting[tem_setting][topic_pic][0][type]' value='0' <?php if($setting['tem_setting']['topic_pic'][0]['type']==0){ echo "checked";}?> class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][topic_pic][0][type]' value='1' <?php if($setting['tem_setting']['topic_pic'][0]['type']==1){ echo "checked";}?> class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name='setting[tem_setting][topic_pic][0][link]' value="<?php echo $setting['tem_setting']['topic_pic'][0]['link'];?>" id="redirect" style="width:300px;" />
                    </td>
                </tr>
                <tr>
                    <td style="width:130px;text-align:right;"></td>
                    <td style="text-align:left;" colspan="3">
                        標題：<input name='setting[tem_setting][topic_pic][1][name]' value="<?php echo $setting['tem_setting']['topic_pic'][1]['name'];?>" type='text' style='width:80px;'/>
                        <?php 
                            $topic_pic_1 = $setting['tem_setting']['topic_pic'][1]['pic'];
                            $curr_form_html = form::images_partition('setting[tem_setting][topic_pic][1][pic]', 'topic_pic2', $topic_pic_1, 'partition','','','input-text');
                            echo $curr_form_html;
                        ?>
                        <input style="margin-left:100px;" type='radio' name='setting[tem_setting][topic_pic][1][type]' value='0' <?php if($setting['tem_setting']['topic_pic'][1]['type']==0){ echo "checked";}?> class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][topic_pic][1][type]' value='1' <?php if($setting['tem_setting']['topic_pic'][1]['type']==1){ echo "checked";}?> class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name='setting[tem_setting][topic_pic][1][link]' value="<?php echo $setting['tem_setting']['topic_pic'][1]['link'];?>" id="redirect" style="width:300px;" />
                    </td>
                </tr>
                <tr>
                    <td style="width:130px;text-align:right;"></td>
                    <td style="text-align:left;" colspan="3">
                        標題：<input name='setting[tem_setting][topic_pic][2][name]' value="<?php echo $setting['tem_setting']['topic_pic'][2]['name'];?>" type='text' style='width:80px;'/>
                        <?php 
                            $topic_pic_2 = $setting['tem_setting']['topic_pic'][2]['pic'];
                            $curr_form_html = form::images_partition('setting[tem_setting][topic_pic][2][pic]', 'topic_pic3', $topic_pic_2, 'partition','','','input-text');
                            echo $curr_form_html;
                        ?>
                        <input style="margin-left:100px;" type='radio' name='setting[tem_setting][topic_pic][2][type]' value='0' <?php if($setting['tem_setting']['topic_pic'][2]['type']==0){ echo "checked";}?> class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][topic_pic][2][type]' value='1' <?php if($setting['tem_setting']['topic_pic'][2]['type']==1){ echo "checked";}?> class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name='setting[tem_setting][topic_pic][2][link]' value="<?php echo $setting['tem_setting']['topic_pic'][2]['link'];?>" id="redirect" style="width:300px;" />
                    </td>
                </tr>
                <tr>
                    <td style="width:130px;text-align:right;"></td>
                    <td style="text-align:left;" colspan="3">
                        標題：<input name='setting[tem_setting][topic_pic][3][name]' value="<?php echo $setting['tem_setting']['topic_pic'][3]['name'];?>" type='text' style='width:80px;'/>
                        <?php 
                            $topic_pic_3 = $setting['tem_setting']['topic_pic'][3]['pic'];
                            $curr_form_html = form::images_partition('setting[tem_setting][topic_pic][3][pic]', 'topic_pic4', $topic_pic_3, 'partition','','','input-text');
                            echo $curr_form_html;
                        ?>
                        <input style="margin-left:100px;" type='radio' name='setting[tem_setting][topic_pic][3][type]' value='0' <?php if($setting['tem_setting']['topic_pic'][3]['type']==0){ echo "checked";}?> class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][topic_pic][3][type]' value='1' <?php if($setting['tem_setting']['topic_pic'][3]['type']==1){ echo "checked";}?> class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name='setting[tem_setting][topic_pic][3][link]' value="<?php echo $setting['tem_setting']['topic_pic'][3]['link'];?>" id="redirect" style="width:300px;" />
                    </td>
                </tr>
                <!-- 內容/列表頁配置 -->
                <tr style="height:36px;" class="tr_bor_top">
                    <th style="width:130px;text-align:right;">內容/列表頁配置：</th>
                    <td style="text-align:left;">
                        熱門攻略id：<input name='setting[tem_setting][hot_gls]' value="<?php echo $setting['tem_setting']['hot_gls'];?>" type='text' style="width:300px;" />
                    </td>
                    <td style="text-align:left;" colspan="2">
                        遊戲視頻id：<input name='setting[tem_setting][hot_video]' value="<?php echo $setting['tem_setting']['hot_video'];?>" type='text' style="width:300px;" />
                    </td>
                </tr>
            <?php if( $setting['template_type'] != 0 ){?>
            </tbody>
            <tbody>
            <?php }?>
                <!-- 統計代碼 -->
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;">統計代碼：</th>
                    <td style="text-align:left;" colspan="3">
                        <textarea rows="3" cols="50" name='setting[tem_setting][statistical_code]' style="width:1200px;" ><?php echo $setting['tem_setting']['statistical_code'];?></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 模塊展示配置 -->
    <div id="div_setting_12" class="contentList pad-10 hidden">
        <div class="line-x" style="padding: 0 0 6px;">
            功能模塊選擇：
            <select name="module_type" class="module_type">
                <option value="1">熱門攻略 & 新手指引</option>
                <option value="2">副本信息 & 遊戲攻略</option>
                <option value="3">專區遊戲視頻</option>
                <option value="4">PVP攻略 & PVP視頻</option>
                <option value="5">專區遊戲圖鑑</option>
                <option value="6">專區遊戲圖集</option>
                <option value="7">視頻頂部輪播</option>
                <option value="8">專區視頻直播</option>
                <option value="9">專區視頻3X2</option>
                <option value="10">專區視頻3X3</option>
                <option value="11">專區視頻1+4</option>
                <option value="12">專區視頻4X3</option>
                <option value="13">自定義新聞列表</option>
            </select>
            <a href="javascript:void(0)" class="add_module_item">新增</a>
        </div>
        <div class="bk10"></div>
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="38">排序</th>
                        <th width="150">分區類型</th>
                        <th>相關數據</th>
                        <th>是否禁用</th>
                        <th width="70">管理操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height:36px;">
                        <td align="center"></td>
                        <td align="center">資訊下載輪播</td>
                        <td>
                            <span style="text-align:left;">新聞資訊：</span>
                            <input name='setting[tem_setting][news]' type='text' value="<?php echo $setting['tem_setting']['news'];?>" style="width:80px;" />&nbsp;(<font color="green">如含多欄目，用','分隔，最多三個</font>)
                            輪播圖：欄目id：<input name='setting[tem_setting][slide][catid]' type='text' value="<?php echo $setting['tem_setting']['slide']['catid'];?>" style="width:60px;" />
                            <span style="padding-left:10px;">調取條數</span>
                            <input name='setting[tem_setting][slide][nums]' type='text' value="<?php echo $setting['tem_setting']['slide']['nums'];?>" style="width:60px;" />&nbsp;(<font color="green">0或不填為不限制</font>)
                        </td>
                        <td align="center">(<font color="green">始終不禁用</font>)</td>
                        <td align="center">(<font color="green">必需項</font>)</td>
                    </tr>
                    <tr style="height:36px;">
                        <td align="center"></td>
                        <td align="center">影片分享區</td>
                        <td>
                            欄目id：<input name='setting[tem_setting][videos][catid]' type='text' value="<?php echo $setting['tem_setting']['videos']['catid'];?>" style="width:60px;" />
                            <!-- 調取條數：<input name='setting[tem_setting][videos][nums]' type='text' value="<?php echo $setting['tem_setting']['relaxed']['nums'];?>" style="width:60px;" />&nbsp;(<font color="green">默認為10條</font>) -->
                        </td>
                        <td align="center">(<font color="green">始終不禁用</font>)</td>
                        <td align="center">(<font color="green">外嵌使用</font>)</td>
                    </tr>
                    <?php foreach( $setting['module_setting'] as $k_md => $v_md ){?>
                        <?php if($v_md['type']=='newgls_guide'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>熱門攻略 & 新手指引</td>
                            <td>
                                熱門攻略：<input name='setting[module_setting][<?php echo $k_md;?>][gls]' type='text' value="<?php echo $setting['module_setting'][$k_md]['gls'];?>" style="width:80px;" />&nbsp;(<font color="green">如含多欄目，用','分隔，最多兩個</font>)
                                新手指引：<input name='setting[module_setting][<?php echo $k_md;?>][guide][guide_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['guide']['guide_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">5個欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][guide][guide_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['guide']['guide_pid'];?>" style="width:50px;" />
                                標準：
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][guide][guide_type]' value='1' <?php if($setting['module_setting'][$k_md]['guide']['guide_type']=='1') echo 'checked'; ?> class="redirect_type" /> 是&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][guide][guide_type]' value='0' <?php if($setting['module_setting'][$k_md]['guide']['guide_type']=='0') echo 'checked'; ?> class="redirect_type" /> 否&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td align="center">
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class="redirect_type" /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class="redirect_type" /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='team'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>副本信息 & 遊戲攻略</td>
                            <td>
                                副本信息：<input name='setting[module_setting][<?php echo $k_md;?>][team_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['team_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，請用','分隔</font>)
                                副本攻略：<input name='setting[module_setting][<?php echo $k_md;?>][fuben]' type='text' value="<?php echo $setting['module_setting'][$k_md]['fuben'];?>" style="width:80px;" />&nbsp;(<font color="green">兩個欄目，請用','分隔</font>)
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][team_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['team_title'];?>" style="width:80px;" />
                                標準：
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][team_type]' value='1' <?php if($setting['module_setting'][$k_md]['team_type']=='1') echo 'checked'; ?> class="redirect_type" /> 是&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][team_type]' value='0' <?php if($setting['module_setting'][$k_md]['team_type']=='0') echo 'checked'; ?> class="redirect_type" /> 否&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td align="center">
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class="redirect_type" /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class="redirect_type" /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='video'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區遊戲視頻</td>
                            <td>
                                遊戲視頻：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][video_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][video_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='pvp'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>PVP攻略 & PVP視頻</td>
                            <td>
                                PVP攻略：<input name='setting[module_setting][<?php echo $k_md;?>][pvp_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['pvp_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                PVP視頻：<input name='setting[module_setting][<?php echo $k_md;?>][pvpv]' type='text' value="<?php echo $setting['module_setting'][$k_md]['pvpv'];?>" style="width:50px;" />
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][pvp_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['pvp_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][pvp_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['pvp_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='tujian_topic'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區遊戲圖鑑</td>
                            <td>
                                遊戲圖鑑：<input name='setting[module_setting][<?php echo $k_md;?>][tujian]' type='text' value="<?php echo $setting['module_setting'][$k_md]['tujian'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='tuji'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區遊戲圖集</td>
                            <td>
                                遊戲圖集：<input name='setting[module_setting][<?php echo $k_md;?>][tuji_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['tuji_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][tuji_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['tuji_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][tuji_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['tuji_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='video/video_column32'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區視頻3X2</td>
                            <td>
                                遊戲視頻：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][video_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][video_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='video/video_column3'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區視頻3X4</td>
                            <td>
                                遊戲視頻：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][video_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][video_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='video/video_column3_big'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區視頻1+4</td>
                            <td>
                                遊戲視頻：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][video_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][video_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='video/video_column4'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區視頻4X3</td>
                            <td>
                                遊戲視頻：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][video_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][video_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='live'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>專區視頻直播</td>
                            <td>
                                遊戲視頻：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][video_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][video_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='slider'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>視頻頂部輪播</td>
                            <td>
                                遊戲視頻：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                                更多：<input name='setting[module_setting][<?php echo $k_md;?>][video_pid]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_pid'];?>" style="width:50px;" />
                                顯示標題：<input name='setting[module_setting][<?php echo $k_md;?>][video_title]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_title'];?>" style="width:80px;" />
                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                        <?php if($v_md['type']=='custom_new'){?>
                        <tr>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][listorder]' value="<?php echo $setting['module_setting'][$k_md]['listorder'];?>" class="input-text-c input-text" type='text' size='3'/></td>
                            <td align="center"><input name='setting[module_setting][<?php echo $k_md;?>][type]' value="<?php echo $setting['module_setting'][$k_md]['type'];?>" type='hidden'/>自定義新聞列表</td>
                            <td>
                                新聞欄目：<input name='setting[module_setting][<?php echo $k_md;?>][video_arr]' type='text' value="<?php echo $setting['module_setting'][$k_md]['video_arr'];?>" style="width:200px;" />&nbsp;(<font color="green">如含多欄目，用','分隔</font>)

                            </td>
                            <td align='center'>
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='1' <?php if($setting['module_setting'][$k_md]['disable_type']=='1') echo 'checked'; ?> class='redirect_type' /> 是
                                <input type='radio' name='setting[module_setting][<?php echo $k_md;?>][disable_type]' value='0' <?php if($setting['module_setting'][$k_md]['disable_type']=='0') echo 'checked'; ?> class='redirect_type' /> 否
                            </td>
                            <td align="center"><a href="javascript:void(0)" class="dele_nav_item">刪除</a></td>
                        </tr>
                        <?php }?>
                    <?php }?>
                </tbody>
            </table>
            <div class="btn">
                (<font color="green">更新公告！！！目前可以實現模塊復用了！</font>)
            </div>
        </div>
    </div>

    <!-- 官網內嵌其他網站iframe配置 by jozh -->
    <?php if($setting['is_official']){?>
        <?php if(!$is_parent['parentid']){?>
            <div id="div_setting_13" class="contentList pad-10 hidden">
                <table width="100%" class="table_form ">
                    <?php $setting['tem_setting']['iframelink'] = $setting['tem_setting']['iframelink'] ? $setting['tem_setting']['iframelink'] : array();?>
                    <?php usort($setting['tem_setting']['iframelink'],"partition_list_cmp_listorder"); ?>
                    <tr style="height:36px;">
                        <th style="width:130px;text-align:right;">iframe樣例：</th>
                        <td colspan="2">
                        <a href="http://www.mofang.com/official_ex.ex" target="_blank"><font color="green">點擊下載樣例文件，然後記事本打開並另存為html格式，瀏覽器即可瀏覽 </font></a>
                        </td>
                    </tr>
                    <!-- 添加內嵌iframe鏈接 -->
                    <?php if(empty($setting['tem_setting']['iframelink'])){?>
                    <tr style="height:36px;">
                        <th style="width:130px;text-align:right;">iframe鏈接：</th>
                        <td style="text-align:left;">
                            排序：<input name='setting[tem_setting][iframelink][0][listorder]' type='text' class="input-text-c" style='width:37px;'/>
                            標題：<input name='setting[tem_setting][iframelink][0][title]' type='text' style='width:150px;'/>
                            鏈接：<input name='setting[tem_setting][iframelink][0][url]' id="redirect" style="width:300px;" />
                        </td>
                        <td style="text-align:left;">
                            <a href="javascript:void(0)" class="dele_nav_item">刪除</a>&nbsp;|&nbsp;<a href="javascript:void(0)" class="add_ifm_link_item">新增</a>
                        </td>
                    </tr>
                    <?php }?>
                    <?php foreach( $setting['tem_setting']['iframelink'] as $k_ts=>$v_ts ){?>
                    <tr style="height:36px;">
                        <th style="width:80px;text-align:right;"><?php if ($k_ts==0) echo 'iframe鏈接：';?></th>
                        <td style="text-align:left;">
                            排序：<input name='setting[tem_setting][iframelink][<?php echo $k_ts;?>][listorder]' value="<?php echo $v_ts['listorder'];?>" type='text' class="input-text-c" style='width:37px;'/>
                            標題：<input name='setting[tem_setting][iframelink][<?php echo $k_ts;?>][title]' value="<?php echo $v_ts['title'];?>" type='text' style='width:150px;'/>
                            鏈接：<input name='setting[tem_setting][iframelink][<?php echo $k_ts;?>][url]' value="<?php echo $v_ts['url'];?>" id="redirect" style="width:300px;" />
                        </td>
                        <td style="text-align:left;">
                            <a href="javascript:void(0)" class="dele_nav_item">刪除</a>&nbsp;|&nbsp;<a href="javascript:void(0)" class="add_ifm_link_item">新增</a>
                        </td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        <?php }?>
    <?php }?>

    <!-- button項v2 -->
    <?php $setting['button_v2'] = $setting['button_v2'] ? $setting['button_v2'] : array();?>
    <?php usort($setting['button_v2'],"partition_list_cmp_listorder"); ?>
    <div id="div_setting_14" class="pad-10 hidden">
        <table width="100%">
            <?php
                if( !empty($setting['button_v2']) ){
                    foreach( $setting['button_v2'] as $k_set_button=>$v_set_button ){
                        $temp_image = form::images_partition('setting[button_v2]['.$k_set_button.'][image]', 'image_button'.$k_set_button, $v_set_button['image'], 'partition','',30,'input-text');
            ?>
                <tr style='margin-top:10px;'>
                    <td style='width:100px;'>排序：<input name='setting[button_v2][<?php echo $k_set_button; ?>][listorder]' value='<?php echo $v_set_button['listorder']; ?>' type='text' style='width:50px;' class='input-text' />
                    </td>
                    <td style='width:280px;' >名字：<input name='setting[button_v2][<?php echo $k_set_button; ?>][name]' value='<?php echo $v_set_button['name']; ?>' type='text' style='width:200px;' class='input-text' />
                    </td>
                    <td style='width:300px;'>圖片：<?php echo $temp_image; ?></td>
                    <td style='text-align:left;width:430px;'>
                        <input type='radio' name='setting[button_v2][<?php echo $k_set_button; ?>][button_type]' value='0' <?php if($v_set_button['button_type']==0) echo "checked"; ?> class='redirect_type' /> url&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[button_v2][<?php echo $k_set_button; ?>][button_type]' value='1' <?php if($v_set_button['button_type']==1) echo "checked"; ?> class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[button_v2][<?php echo $k_set_button; ?>][button_type]' value='2' <?php if($v_set_button['button_type']==2) echo "checked"; ?> class='redirect_type' /> 瀏覽器&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[button_v2][<?php echo $k_set_button; ?>][button_type]' value='3' <?php if($v_set_button['button_type']==3) echo "checked"; ?> class='redirect_type' /> 卡牌&nbsp;&nbsp;&nbsp;
                        <input name='setting[button_v2][<?php echo $k_set_button; ?>][button_value]' value='<?php echo $v_set_button['button_value']; ?>' id='redirect' style='width:300px;' class='input-text' />
                    </td>
                    <td style='text-align:left;width:30px;'>
                        <a href='javascript:void(0)' class='dele_button_item'>刪除</a>
                    </td>
                    <td style='text-align:left;width:30px;'>
                        <a href='javascript:void(0)' class='add_button_item'>新增</a>
                    </td>
                    <td style='width:100px;'></td>
                 </tr>
            <?php
                    }
                }else{
                    $temp_image = form::images_partition('setting[button_v2][0][image]', 'image_button0', '', 'partition','',30,'input-text');
                    $new_item_html = "<tr style='margin-top:10px;'><td style='width:100px;'>排序：<input name='setting[button_v2][0][listorder]' type='text' style='width:50px;' class='input-text' /></td><td style='width:280px;' >名字：<input name='setting[button_v2][0][name]' type='text' style='width:200px;' class='input-text' /></td><td style='width:300px;'>圖片：{$temp_image}</td><td style='text-align:left;width:430px;'>
                    <input type='radio' name='setting[button_v2][0][button_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[button_v2][0][button_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[button_v2][0][button_type]' value='2' class='redirect_type' /> 卡牌&nbsp;&nbsp;&nbsp;
                    <input name='setting[button_v2][0][button_value]' id='redirect' style='width:300px;' class='input-text' /></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='dele_button_item'>刪除</a></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='add_button_item'>新增</a></td><td style='width:100px;'></td></tr>";
                    echo $new_item_html;
                }
            ?>
        </table>
    </div>
<?php }?>
    <!-- 內嵌頁 by jozh -->
    <div id="div_setting_15" class="contentList pad-10 hidden">
        <table width="100%" class="table_form">
            <tr style="height:36px;">
                <th>圖文排版：</th>
                <td style="text-align:left;">
                    <input type='radio' name='setting[tem_setting][neiqian_list][global][type]' onclick="show_pic_type(this.value)" value='0' <?php if($setting[tem_setting]['neiqian_list']['global']['type']==0){ echo "checked";}?> class="redirect_type" /> 圖文橫向&nbsp;&nbsp;
                    <img src="<?php echo IMG_PATH.'admin_img/1.jpg';?>" height="30px;"/>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][neiqian_list][global][type]' onclick="show_pic_type(this.value)" value='1' <?php if($setting[tem_setting]['neiqian_list']['global']['type']==1){ echo "checked";}?> class="redirect_type" /> 圖文縱向&nbsp;&nbsp;
                    <img src="<?php echo IMG_PATH.'admin_img/2.jpg';?>" height="30px;"/>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[tem_setting][neiqian_list][global][type]' onclick="show_pic_type(this.value)" value='2' <?php if($setting[tem_setting]['neiqian_list']['global']['type']==2){ echo "checked";}?> class="redirect_type" /> 列表橫向&nbsp;&nbsp;
                    <img src="<?php echo IMG_PATH.'admin_img/3.jpg';?>" height="30px;"/>
                </td>
            </tr>
            <tbody>
                <tr style="height:36px;" class="tr_bor_top">
                    <th style="width:130px;text-align:right;">整體控制：</th>
                    <td style="text-align:left;">
                        字體：
                        <input name='setting[tem_setting][neiqian_list][global][font]' width='20' type='text' value="<?php echo $setting[tem_setting]['neiqian_list']['global']['font'];?>"/>
                        背景顏色：
                        <input name='setting[tem_setting][neiqian_list][global][iframe_color]' type='text' value="<?php echo $setting[tem_setting]['neiqian_list']['global']['iframe_color'];?>"/>
                        列表字體顏色：
                        <input name='setting[tem_setting][neiqian_list][global][a_color]' type='text' value="<?php echo $setting[tem_setting]['neiqian_list']['global']['a_color'];?>"/>
                        鼠標懸浮顏色：
                        <input name='setting[tem_setting][neiqian_list][global][a_hover_color]' type='text' value="<?php echo $setting[tem_setting]['neiqian_list']['global']['a_hover_color'];?>"/>
                    </td>
                </tr>
                <tr style="height:36px;">
                    <th></th>
                    <td style="text-align:left;">
                        iframe屬性：
                        寬：
                        <input name='setting[tem_setting][neiqian_list][global][width]' type='text' style="width:30px;" value="<?php echo $setting[tem_setting]['neiqian_list']['global']['width'];?>"/>px
                        &nbsp;&nbsp;&nbsp;&nbsp;高：
                        <input name='setting[tem_setting][neiqian_list][global][height]' type='text' style="width:30px;" value="<?php echo $setting[tem_setting]['neiqian_list']['global']['height'];?>"/>px
                    </td>
                </tr>
                <tr style="height:36px;">
                    <th></th>
                    <td style="text-align:left;">
                        整體邊距：
                        左邊距：
                        <input name='setting[tem_setting][neiqian_list][global][pl]' type='text' style="width:30px;" value="<?php echo $setting[tem_setting]['neiqian_list']['global']['pl'];?>"/>px
                        &nbsp;&nbsp;&nbsp;&nbsp;上邊距：
                        <input name='setting[tem_setting][neiqian_list][global][pt]' type='text' style="width:30px;" value="<?php echo $setting[tem_setting]['neiqian_list']['global']['pt'];?>"/>px
                    </td>
                </tr>
            </tbody>
            <tbody id="pic_type_1" <?php if($setting['tem_setting']['neiqian_list']['global']['type'] == 2) echo 'style="display: none;"';?>>
                <tr style="height:36px;" class="tr_bor_top">
                    <th style="width:130px;text-align:right;">圖片配置：</th>
                    <td style="text-align:left;">
                        欄目ID：
                        <input name='setting[tem_setting][neiqian_list][pic][partid]' type='text' style="width:60px;" value="<?php echo $setting[tem_setting]['neiqian_list']['pic']['partid'];?>"/>(<font color='green'>圖片：填寫即有，不填即無</font>)
                    </td>
                </tr>
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;"></th>
                    <td style="text-align:left;">
                        圖片屬性：
                        寬：
                        <input name='setting[tem_setting][neiqian_list][pic][width]' type='text' style="width:30px;" value="<?php echo $setting[tem_setting]['neiqian_list']['pic']['width'];?>"/>px
                        &nbsp;&nbsp;&nbsp;&nbsp;高：
                        <input name='setting[tem_setting][neiqian_list][pic][height]' type='text' style="width:30px;" value="<?php echo $setting[tem_setting]['neiqian_list']['pic']['height'];?>"/>px
                    </td>
                </tr>
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;"></th>
                    <td style="text-align:left;">
                        圖片位置：
                        <select name="setting[tem_setting][neiqian_list][pic][pic_type]">
                            <option value="left" <?php if($setting['tem_setting']['neiqian_list']['pic']['pic_type']=='left') echo 'selected';?>>居左</option>
                            <option value="right" <?php if($setting['tem_setting']['neiqian_list']['pic']['pic_type']=='right') echo 'selected';?>>居右</option>
                        </select>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr style="height:36px;" class="tr_bor_top">
                    <th style="width:130px;text-align:right;">列表配置：</th>
                    <td style="text-align:left;">
                        欄目ID：
                        <input id="neiqian_list_partid" name='setting[tem_setting][neiqian_list][list][partid]' type='text' value="<?php echo $setting[tem_setting]['neiqian_list']['list']['partid'];?>"/>
                        調取條數：
                        <input name='setting[tem_setting][neiqian_list][list][nums]' type='text' value="<?php echo $setting[tem_setting]['neiqian_list']['list']['nums'];?>"/>
                        字數限制：
                        <input name='setting[tem_setting][neiqian_list][list][limit]' type='text' style="width:60px;" value="<?php echo $setting[tem_setting]['neiqian_list']['list']['limit'];?>"/>(<font color='green'>漢字數</font>)
                        字號：
                        <input name='setting[tem_setting][neiqian_list][list][font]' type='text' style="width:60px;" value="<?php echo $setting[tem_setting]['neiqian_list']['list']['font'];?>"/>
                    </td>
                </tr>
                <!-- <tr style="height:36px;">
                    <th style="width:130px;text-align:right;"></th>
                    <td style="text-align:left;">
                        第一條加粗：
                        <input type='radio' name='setting[tem_setting][neiqian_list][list][is_bold]' value='1' <?php if($setting[tem_setting]['neiqian_list']['list']['is_bold']==1){ echo "checked";}?> class="redirect_type" /> 是&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][neiqian_list][list][is_bold]' value='0' <?php if($setting[tem_setting]['neiqian_list']['list']['is_bold']==0){ echo "checked";}?> class="redirect_type" /> 否
                    </td>
                    </tr> -->
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;"></th>
                    <td style="text-align:left;">
                        行間距：
                        <input name='setting[tem_setting][neiqian_list][list][height]' type='text' style="width:60px;" value="<?php echo $setting[tem_setting]['neiqian_list']['list']['height'];?>"/>
                        列寬：
                        <input name='setting[tem_setting][neiqian_list][list][width]' type='text' style="width:60px;" value="<?php echo $setting[tem_setting]['neiqian_list']['list']['width'];?>"/>
                    </td>
                </tr>
                <tr style="height:36px;">
                    <th style="width:130px;text-align:right;"></th>
                    <td style="text-align:left;">
                        加標簽：
                        <input name='setting[tem_setting][neiqian_list][list][tag]' type='text' style="width:60px;" value="<?php echo $setting[tem_setting]['neiqian_list']['list']['tag'];?>"/>(<font color='green'>填寫即有，不填即無! 例：[攻略]</font>)
                        加時間：
                        <select name="setting[tem_setting][neiqian_list][list][time_type]">
                            <option value="0" <?php if($setting['tem_setting']['neiqian_list']['list']['time_type']==0) echo 'selected';?>>請選擇</option>
                            <option value="1" <?php if($setting['tem_setting']['neiqian_list']['list']['time_type']==1) echo 'selected';?>>Y-m-d</option>
                            <option value="2" <?php if($setting['tem_setting']['neiqian_list']['list']['time_type']==2) echo 'selected';?>>m-d</option>
                        </select>
                        (<font color='green'>選擇則加，反之不加</font>)
                    </td>
                </tr>
                <tr>
                    <th style="width:130px;text-align:right;"></th>
                    <td style="text-align:left;">
                        列表行分隔線：
                        <select name="setting[tem_setting][neiqian_list][list][li_style]">
                            <option value="0" <?php if($setting['tem_setting']['neiqian_list']['list']['li_style']=='0') echo 'selected';?>>請選擇</option>
                            <option value="dashed" <?php if($setting['tem_setting']['neiqian_list']['list']['li_style']=='dashed') echo 'selected';?>>-虛線</option>
                            <option value="dotted" <?php if($setting['tem_setting']['neiqian_list']['list']['li_style']=='dotted') echo 'selected';?>>.虛線</option>
                            <option value="solid" <?php if($setting['tem_setting']['neiqian_list']['list']['li_style']=='solid') echo 'selected';?>>實線</option>
                        </select>
                        分割線顏色：
                        <input name='setting[tem_setting][neiqian_list][list][li_color]' type='text' value="<?php echo $setting[tem_setting]['neiqian_list']['list']['li_color'];?>"/>
                    </td>
                </tr>
                <tr style="height:36px;">
                    <th></th>
                    <td style="text-align:left;">
                        魔方入口：
                        <input type='radio' name='setting[tem_setting][neiqian_list][global][is_mfin]' value='1' <?php if($setting[tem_setting]['neiqian_list']['global']['is_mfin']==1){ echo "checked";}?> class="redirect_type" /> 是&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][neiqian_list][global][is_mfin]' value='0' <?php if($setting[tem_setting]['neiqian_list']['global']['is_mfin']==0){ echo "checked";}?> class="redirect_type" /> 否&nbsp;&nbsp;&nbsp;&nbsp;
                        專區入口：
                        <input type='radio' name='setting[tem_setting][neiqian_list][global][is_partin]' value='1' <?php if($setting[tem_setting]['neiqian_list']['global']['is_partin']==1){ echo "checked";}?> class="redirect_type" /> 是&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][neiqian_list][global][is_partin]' value='0' <?php if($setting[tem_setting]['neiqian_list']['global']['is_partin']==0){ echo "checked";}?> class="redirect_type" /> 否&nbsp;&nbsp;&nbsp;&nbsp;
                        專區搜索：
                        <input type='radio' name='setting[tem_setting][neiqian_list][global][is_search]' value='1' <?php if($setting[tem_setting]['neiqian_list']['global']['is_search']==1){ echo "checked";}?> class="redirect_type" /> 啟用&nbsp;&nbsp;
                        <input type='radio' name='setting[tem_setting][neiqian_list][global][is_search]' value='0' <?php if($setting[tem_setting]['neiqian_list']['global']['is_search']==0){ echo "checked";}?> class="redirect_type" /> 不啟用&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr style="height:36px;" class="tr_bor_top">
                    <th style="width:130px;text-align:right;">鏈接查看：</th>
                    <td style="text-align:left;">
                        <span style="color:green" class="show_url" data="<?php echo $iframe_url;?>">點擊生成url</span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a id="neiqian_url" href="" target="_blank"></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php if( $parentid == 0 ){ ?>
    <!-- 移動端配置 by jozh -->
    <div id="div_setting_16" class="contentList pad-10 hidden">
        <table width="100%" class="table_form ">
            <!-- 頭部導航 -->
            <?php $setting['wap_setting']['nav'] = $setting['wap_setting']['nav'] ? $setting['wap_setting']['nav'] : array();?>

            <?php if(empty($setting['wap_setting']['nav'])){?>
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">頭部導航：</th>
                <td style="text-align:left;">
                    排序：<input name='setting[wap_setting][nav][0][listorder]' type='text' style='width:50px;'/>
                    名字：<input name='setting[wap_setting][nav][0][name]' type='text' style='width:200px;'/>
                </td>
                <td>
                    <input type='radio' name='setting[wap_setting][nav][0][nav_type]' value='0' checked class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[wap_setting][nav][0][nav_type]' value='1' class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name='setting[wap_setting][nav][0][nav_value]' id="redirect" style="width:300px;" />
                </td>
                <td style="text-align:left;">
                    <a href="javascript:void(0)" class="dele_nav_item">刪除</a> |
                    <a href="javascript:void(0)" class="add_wap_nav_item">新增</a>
                </td>
            </tr>
            <?php }?>
            <?php foreach( $setting['wap_setting']['nav'] as $k_ts=>$v_ts ){?>
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;"><?php if ($k_ts==0) echo '頭部導航：';?></th>
                <td style="text-align:left;">
                    排序：<input name='setting[wap_setting][nav][<?php echo $k_ts;?>][listorder]'  value="<?php echo $v_ts['listorder'];?>" type='text' style='width:50px;'/>
                    名字：<input name='setting[wap_setting][nav][<?php echo $k_ts;?>][name]' value="<?php echo $v_ts['name'];?>" type='text' style='width:200px;'/>
                </td>
                <td>
                    <input type='radio' name='setting[wap_setting][nav][<?php echo $k_ts;?>][nav_type]' value='0' <?php if($v_ts['nav_type']==0){echo "checked"; }?> class="redirect_type" /> url&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type='radio' name='setting[wap_setting][nav][<?php echo $k_ts;?>][nav_type]' value='1' <?php if($v_ts['nav_type']==1){echo "checked";} ?> class="redirect_type" /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name='setting[wap_setting][nav][<?php echo $k_ts;?>][nav_value]' value="<?php echo $v_ts['nav_value'];?>" id="redirect" style="width:300px;" />
                </td>
                <td style="text-align:left;">
                    <a href="javascript:void(0)" class="dele_nav_item">刪除</a> |
                    <a href="javascript:void(0)" class="add_wap_nav_item">新增</a>
                </td>
            </tr>
            <?php }?>
            <!-- 自定義欄目 -->
            <tr style="height:32px;" class="tr_bor_top">
                <th style="width:130px;text-align:right;"><?php if ($k_ts==0) echo '自定義欄目：';?></th>
                <td style="text-align:left;">
                    欄目名稱：<input name='setting[wap_setting][category][cname]'  value="<?php ?>" type='text' style='width:100px;'/>
                    欄目ID：<input name='setting[wap_setting][category][cid]' value="<?php ?>" type='text' style='width:100px;'/>
                </td>
                <td>

                </td>

                <td style="text-align:left;">
                    <a href="javascript:void(0)" class="dele_wap_category">刪除</a> |
                    <a href="javascript:void(0)" class="add_wap_category">新增</a>
                </td>
            </tr>
            <tr>
                <th style="width:130px;text-align:right;">自定義圖案：</th>
                <td>
                    欄目背景圖：
                        <?php
                            $web_header = form::images_partition('setting[wap_setting][category_style][background]', 'category_background', $setting['wap_setting']['category_style']['background'], 'category_background','','','input-text');
                            echo $web_header;
                        ?>
                </td>
                <td>
                    標題圖示：
                        <?php
                            $web_header = form::images_partition('setting[wap_setting][category_style][catioc]', 'category_catioc', $setting['wap_setting']['category_style']['catioc'], 'category_catioc','','','input-text');
                            echo $web_header;
                        ?> 
                </td>
            <tr>
                <th style="width:130px;text-align:right;">欄目標題：</th>
                <td>
                   文字字體：<input name='setting[wap_setting][category_style][font_family]' value="<?php ?>" type='text' style='width:50px;'/>
                   文字顏色：<input name='setting[wap_setting][category_style][font_color]' value="<?php ?>" type='text' style='width:50px;'/>
                   文字加粗：<input type="radio" name="setting[wap_setting][category][font_bold]" value="1" class="redirect_type"> 是 <input type="radio" name="[wap_setting][category_style][font_bold]" value="0" checked="" class="redirect_type"> 否  
                </td>
            </tr>
            <tr>
                <th style="width:130px;text-align:right;">使用新模版：</th>
                <td>
                    <input type="radio" name="setting[wap_setting][new_template]" value="1" <?php if($setting[wap_setting][new_template] == 1) echo 'checked'; ?> class="redirect_type"> 是 <input type="radio" name="setting[wap_setting][new_template]" value="0" <?php if($setting[wap_setting][new_template] == 0) echo 'checked'; ?> class="redirect_type"> 否  
                </td>
            </tr>
            <!-- 自定義欄目 -->
            <!-- 頭條新聞 -->
            <tr style="height:36px;" class="tr_bor_top">
                <th style="width:130px;text-align:right;">頭條新聞：</th>
                <td style="text-align:left;" colspan="3">
                    欄目ID：<input name='setting[wap_setting][top]' type='text' value="<?php echo $setting['wap_setting']['top'];?>" style='width:200px;'/>
                </td>
            </tr>
            <!-- 輪 播 圖 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">輪 播 圖：</th>
                <td style="text-align:left;" colspan="3">
                    欄目ID：<input name='setting[wap_setting][lunbo]' type='text' value="<?php echo $setting['wap_setting']['lunbo'];?>" style='width:200px;'/>
                </td>
            </tr>
            <!-- 新聞列表 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">新聞列表：</th>
                <td style="text-align:left;" colspan="3">
                    欄目ID：<input name='setting[wap_setting][news]' type='text' value="<?php echo $setting['wap_setting']['news'];?>" style='width:200px;'/>
                </td>
            </tr>
            <!-- 最新攻略 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">最新攻略：</th>
                <td style="text-align:left;" colspan="3">
                    欄目ID：<input name='setting[wap_setting][gonglue]' type='text' value="<?php echo $setting['wap_setting']['gonglue'];?>" style='width:200px;'/>
                </td>
            </tr>
            <!-- 精彩視頻 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">精彩視頻：</th>
                <td style="text-align:left;" colspan="3">
                    欄目ID：<input name='setting[wap_setting][video]' type='text' value="<?php echo $setting['wap_setting']['video'];?>" style='width:200px;'/>
                </td>
            </tr>
            <!-- 百科圖鑑 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">百科圖鑑：</th>
                <td style="text-align:left;" colspan="3">
                    欄目ID：<input name='setting[wap_setting][tujian][pid]' type='text' value="<?php echo $setting['wap_setting']['tujian']['pid'];?>" style='width:50px;'/>&nbsp;&nbsp;
                    子欄目ID：<input name="setting[wap_setting][tujian][chids]" type='text' value="<?php echo $setting['wap_setting']['tujian']['chids'];?>" style="width:200px;">&nbsp;(<font color="green">如含多欄目，用','分隔</font>)
                </td>
            </tr>
            <!-- 精華貼接口 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">精華貼：</th>
                <td style="text-align:left;" colspan="3">
                    接口ID：<input name='setting[wap_setting][bbs_elite]' class="elite" type='text' value='<?php echo $setting['wap_setting']['bbs_elite'];?>' style='width:50px;'/>&nbsp;(<font color="green">bbs門戶權限用戶配置，此為接口bid</font>)
                </td>
            </tr>
            <!-- 內容頁熱點內容 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">內容頁熱點：</th>
                <td style="text-align:left;" colspan="3">
                    欄目ID：<input name='setting[wap_setting][hot_cont]' type='text' value="<?php echo $setting['wap_setting']['hot_cont'];?>" style='width:200px;'/>
                </td>
            </tr>
            <!--disable_type基本情報 -->
            <tr style="height:36px;">
                <th style="width:130px;text-align:right;">基本情報禁用：</th>
                <td ><input type="radio" name="setting[wap_setting][disable_type]" value="1" class="redirect_type"> 是 <input type="radio" name="setting[wap_setting][disable_type]" value="0" checked="" class="redirect_type"> 否 </td>
            </tr>
        </table>
    </div>
    
    <!-- 廣告配置  -->
    <div id="div_setting_2" class="pad-10 hidden">
        <table width="100%">
            <tr>
                <th width="5%">排序</th>
                <th width="10%">名稱</th>
                <th width="30%">圖片</th>
                <th width="30%">跳轉</th>
                <th width="8%">操作</th>
                <th width="3%"></th>
            </tr>

            <?php
                if( !empty($setting['ad_pic']) ){
                    foreach( $setting['ad_pic'] as $key=>$value ){

                        $checked_catid = '';
                        $checked_url = '';
                        if( $value['redirect_type']==1 ){
                            $checked_catid = 'checked';
                        }else{
                            $checked_url = 'checked';
                        }

                            $temp_image = form::images_partition('setting[ad_pic]['.$key.'][image]', 'image_headerpic'.$key, $value['image'], 'partition','','','input-text');
                            $new_item_html = "<tr style='margin-top:10px;'><td><input name='setting[ad_pic][$key][listorder]' type='text' class='input-text' style='width:30px;' value='{$value['listorder']}'/></td><td><input name='setting[ad_pic][{$key}][name]' type='text' value='{$value['name']}' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>{$temp_image}</td><td><input type='radio' name='setting[ad_pic][{$key}][redirect_type]' value='0' {$checked_url} checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[ad_pic][{$key}][redirect_type]' value='1' {$checked_catid} class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='setting[ad_pic][{$key}][redirect]' value='{$value['redirect']}' class='input-text' style='width:300px;' id='redirect_btn' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_ad_pic'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_ad_pic'>新增</a></td></tr>";
                        echo $new_item_html;
                    }
                }else{
                        $temp_image = form::images_partition('setting[ad_pic][0][image]', 'image_headerpic0', '', 'partition','','','input-text');
                    $new_item_html = "<tr style='margin-top:10px;'><td><input name='setting[ad_pic][$key][listorder]' type='text' class='input-text' style='width:30px;' value='0'/></td><td><input name='setting[ad_pic][0][name]' type='text' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>{$temp_image}</td><td><input type='radio' name='setting[ad_pic][0][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[ad_pic][0][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name=setting[ad_pic][0][redirect]' class='input-text' id='redirect_btn' style='width:300px;'/></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_ad_pic'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_ad_pic'>新增</a></td></tr>";
                    echo $new_item_html;
                }
            ?>
        </table>
    </div>
<?php }?>


    <div class="bk15"></div>
    <input type="hidden" id="max_redirect_btn_nums" value="<?php echo $count_button;?>" />
    <input type="hidden" id="max_header_pic_nums" value="<?php echo $count_header_pic;?>" />
    <input type="hidden" id="max_nav_item_nums" value="<?php echo count($setting['tem_setting']['nav']);?>" />
    <input type="hidden" id="max_button_item_nums" value="<?php echo count($setting['button_v2'])>0 ? count($setting['button_v2']):0; ?>" />
    <input name="catid" type="hidden" value="<?php echo $catid;?>">
    <!-- by jozh -->
    <input type="hidden" id="max_littlenav_list_id_nums" value="<?php echo (count($setting['tem_setting']['littlenav']['list_id'])-1);?>" />
    <input type="hidden" id="max_littlenav_id_list_nums" value="<?php echo (count($setting['tem_setting']['littlenav']['id_list'])-1);?>" />
    <input type="hidden" id="max_link_item_nums" value="<?php echo count($setting['tem_setting']['partlink']['links']);?>" />
    <input type="hidden" id="max_keylink_item_nums" value="<?php echo count($setting['tem_setting']['keylink']);?>" />
    <input type="hidden" id="max_ifm_link_item_nums" value="<?php echo count($setting['tem_setting']['iframelink']);?>" />
    <input type="hidden" id="max_temp_item_nums" value="<?php echo count($setting['tem_setting']['column']);?>" />
    <input type="hidden" id="max_fastnav_item_nums" value="<?php echo count($setting['tem_setting']['fastnav']);?>" />
    <input type="hidden" id="max_wap_nav_item_nums" value="<?php echo count($setting['wap_setting']['nav']);?>" />
    <input type="hidden" id="max_wap_categroy_item_nums" value="<?php echo count($setting['wap_setting']['nav']);?>" />
    <input type="hidden" id="max_ad_pic_nums" value="<?php echo count($setting['ad_pic']);?>" />
    <input type="hidden" id="new_k" value="<?php echo count($setting['module_setting'])+20;?>" />

    <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">

</form>
</div>

</div>
<!--table_form_off-->
</div>

<script type="text/javascript">
    //跳轉button
    $(".add_redirect_button").live("click",
        function(){

            var new_btn_nums = parseInt($("#max_redirect_btn_nums").val()) + 1;
            $.ajax({
                url: "?m=partition&c=partition&a=ajax_upload_img&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
                async : false,
                data : "curr_id=" + new_btn_nums,
                type:"post",
                success: function( data  ){
                    //console.log(data);
                    data = eval(data);
                    $ap_html = "<tr style='margin-top:10px;'><td><input name='redirect_button["+ new_btn_nums +"][name]' type='text' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>" + data +"</td><td><input type='radio' name='redirect_button["+ new_btn_nums +"][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='redirect_button["+ new_btn_nums +"][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='redirect_button["+ new_btn_nums +"][redirect]' class='input-text' id='redirect_btn' style='width:300px;' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_redirect_button'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_redirect_button'>新增</a></td></tr>";
                    //$(this).parent().parent().after($ap_html);
                    //$("#max_redirect_btn_nums").val(new_btn_nums);
                }
            });

            $(this).parent().parent().after($ap_html);
            $("#max_redirect_btn_nums").val(new_btn_nums);
        }
    )
    $(".dele_redirect_button").live("click",
        function(){
            //alert($(this).parent().parent().html());
            $(this).parent().parent().remove();
        }
    )
    //導航鏈接項修訂
    $(".add_nav_item").live("click",
        function(){
            var max_nav_item_nums = parseInt($("#max_nav_item_nums").val()) + 1;
            $ap_html = "<tr style='height:36px;'><th style='width:130px;text-align:right;'></th><td style='text-align:left;'>排序：<input class='input-text' name='setting[tem_setting][nav]["+max_nav_item_nums+"][listorder]' type='text' style='width:50px;'/>名字：<input class='input-text' name='setting[tem_setting][nav]["+max_nav_item_nums+"][name]' type='text' style='width:200px;'/></td><td><input type='radio' name='setting[tem_setting][nav]["+max_nav_item_nums+"][nav_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[tem_setting][nav]["+max_nav_item_nums+"][nav_type]' value='1' class='redirect_type'/> 欄目&nbsp;&nbsp;&nbsp;&nbsp;<input class='input-text' name='setting[tem_setting][nav]["+max_nav_item_nums+"][nav_value]' id='redirect' style='width:300px;'/></td><td style='text-align:left;'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a> | <a href='javascript:void(0)' class='add_nav_item'>新增</a></td></tr>";


            $(this).parent().parent().after($ap_html);
            $("#max_nav_item_nums").val(max_nav_item_nums);
        }
    )
    //模版欄目選擇 by jozh
    $(".add_temp_item").live("click",
        function(){
            var column_type = $(".column_type").serialize().toString();
            switch(column_type){
                case 'column_type=1':
                    $ap_html = "<tr><td align='center'><input name='setting[tem_setting][column][newgls_guide][listorder]' class='input-text-c input-text' type='text' size='3'/></td><td align='center'>熱門攻略 & 新手指引</td><td>熱門攻略：<input class='input-text' name='setting[tem_setting][gls]' type='text' style='width:80px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔，最多兩個</font>)新手指引：<input class='input-text' name='setting[tem_setting][guide][guide_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>包含有5個欄目，用','分隔</font>)更多：<input class='input-text' name='setting[tem_setting][guide][guide_pid]' type='text' style='width:50px;' />標準：<input type='radio' name='setting[tem_setting][guide][guide_type]' value='1' class='redirect_type' /> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[tem_setting][guide][guide_type]' value='0' class='redirect_type' /> 否&nbsp;&nbsp;&nbsp;&nbsp;</td><td align='center'><input type='radio' name='setting[tem_setting][newgls_guide_disable_type]' value='1' class='redirect_type' /> 是 <input type='radio' name='setting[tem_setting][newgls_guide_disable_type]' value='0' checked class='redirect_type' /> 否 </td><td align='center'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                break;
                case 'column_type=2':
                    $ap_html = "<tr><td align='center'><input name='setting[tem_setting][column][team][listorder]' class='input-text-c input-text' type='text' size='3'/></td><td align='center'>副本信息 & 遊戲攻略</td><td>副本信息：<input class='input-text' name='setting[tem_setting][team][team_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)副本攻略：<input class='input-text' name='setting[tem_setting][team][fuben]' type='text' style='width:80px;' />&nbsp;(<font color='green'>兩個欄目，請用','分隔</font>)顯示標題：<input class='input-text' name='setting[tem_setting][team][team_title]' type='text' style='width:80px;' />標準：<input type='radio' name='setting[tem_setting][team][team_type]' value='1' class='redirect_type' /> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[tem_setting][team][team_type]' value='0' class='redirect_type' /> 否&nbsp;&nbsp;&nbsp;&nbsp;</td><td align='center'><input type='radio' name='setting[tem_setting][team][disable_type]' value='1' class='redirect_type' /> 是 <input type='radio' name='setting[tem_setting][team][disable_type]' value='0' checked class='redirect_type' /> 否 </td><td align='center'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                break;
                case 'column_type=3':
                    $ap_html = "<tr><td align='center'><input name='setting[tem_setting][column][video][listorder]' class='input-text-c input-text' type='text' size='3'/></td><td align='center'>專區遊戲視頻</td><td>遊戲視頻：<input class='input-text' name='setting[tem_setting][video][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[tem_setting][video][video_pid]' type='text' style='width:50px;' /></td><td align='center'><input type='radio' name='setting[tem_setting][video][disable_type]' value='1' class='redirect_type' /> 是 <input type='radio' name='setting[tem_setting][video][disable_type]' value='0' checked class='redirect_type' /> 否 </td><td align='center'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                break;
                case 'column_type=4':
                    $ap_html = "<tr><td align='center'><input name='setting[tem_setting][column][pvp][listorder]' class='input-text-c input-text' type='text' size='3'/></td><td align='center'>PVP攻略 & PVP視頻</td><td>PVP攻略：<input class='input-text' name='setting[tem_setting][pvp][pvp_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)PVP視頻：<input class='input-text' name='setting[tem_setting][pvp][pvpv]' type='text' style='width:50px;' />更多：<input class='input-text' name='setting[tem_setting][pvp][pvp_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[tem_setting][pvp][pvp_title]' type='text' style='width:80px;' /></td><td align='center'><input type='radio' name='setting[tem_setting][pvp][disable_type]' value='1' class='redirect_type' /> 是 <input type='radio' name='setting[tem_setting][pvp][disable_type]' value='0' checked class='redirect_type' /> 否 </td><td align='center'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                break;
                case 'column_type=5':
                    $ap_html = "<tr><td align='center'><input name='setting[tem_setting][column][tujian_topic][listorder]' class='input-text-c input-text' type='text' size='3'/></td><td align='center'>專區遊戲圖鑑</td><td>遊戲圖鑑：<input class='input-text' name='setting[tem_setting][tujian]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)</td><td align='center'><input type='radio' name='setting[tem_setting][tujian_topic_disable_type]' value='1' class='redirect_type' /> 是 <input type='radio' name='setting[tem_setting][tujian_topic_disable_type]' value='0' checked class='redirect_type' /> 否 </td><td align='center'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                break;
                case 'column_type=6':
                    $ap_html = "<tr><td align='center'><input name='setting[tem_setting][column][tuji][listorder]' class='input-text-c input-text' type='text' size='3'/></td><td align='center'>專區遊戲圖集</td><td>遊戲圖集：<input class='input-text' name='setting[tem_setting][tuji][tuji_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[tem_setting][tuji][tuji_pid]' type='text' style='width:50px;' /></td><td align='center'><input type='radio' name='setting[tem_setting][tuji][disable_type]' value='1' class='redirect_type' /> 是 <input type='radio' name='setting[tem_setting][tuji][disable_type]' value='0' checked class='redirect_type' /> 否 </td><td align='center'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                break;
                case 'column_type=7':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video/video_column3' type='hidden'/>專區視頻3X4</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'column_type=8':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video/video_column3_big' type='hidden'/>專區視頻1+4</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'column_type=9':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video/video_column4' type='hidden'/>專區視頻4X3</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
            }
            var btn = $(this);
            var point = btn.parents('.contentList').find("table tbody").eq(0).find('>tr').last();
            point.after($ap_html);
            $("#max_temp_item_nums").val(max_temp_item_nums);
        }
    )
    //新模版欄目選擇 by jozh
    $(".add_module_item").live("click",
        function(){
            var new_k = parseInt($("#new_k").val()) + 1;
            var module_type = $(".module_type").serialize().toString();
            var order = "<tr><td align='center'><input name='setting[module_setting]["+new_k+"][listorder]' class='input-text-c input-text' type='text' size='3'/></td>";
            var dis_del = "<td align='center'><input type='radio' name='setting[module_setting]["+new_k+"][disable_type]' value='1' class='redirect_type' /> 是 <input type='radio' name='setting[module_setting]["+new_k+"][disable_type]' value='0' checked class='redirect_type' /> 否 </td><td align='center'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
            switch(module_type){
                case 'module_type=1':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='newgls_guide' type='hidden'/>熱門攻略 & 新手指引</td><td>熱門攻略：<input class='input-text' name='setting[module_setting]["+new_k+"][gls]' type='text' style='width:80px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔，最多兩個</font>)新手指引：<input class='input-text' name='setting[module_setting]["+new_k+"][guide][guide_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>包含有5個欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][guide][guide_pid]' type='text' style='width:50px;' />標準：<input type='radio' name='setting[module_setting]["+new_k+"][guide][guide_type]' value='1' class='redirect_type' /> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[module_setting]["+new_k+"][guide][guide_type]' value='0' class='redirect_type' /> 否&nbsp;&nbsp;&nbsp;&nbsp;</td>"+dis_del;
                break;
                case 'module_type=2':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='team' type='hidden'/>副本信息 & 遊戲攻略</td><td>副本信息：<input class='input-text' name='setting[module_setting]["+new_k+"][team_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)副本攻略：<input class='input-text' name='setting[module_setting]["+new_k+"][fuben]' type='text' style='width:80px;' />&nbsp;(<font color='green'>兩個欄目，請用','分隔</font>)顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][team_title]' type='text' style='width:80px;' />標準：<input type='radio' name='setting[module_setting]["+new_k+"][team_type]' value='1' class='redirect_type' /> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[module_setting]["+new_k+"][team_type]' value='0' class='redirect_type' /> 否&nbsp;&nbsp;&nbsp;&nbsp;</td>"+dis_del;
                break;
                case 'module_type=3':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video' type='hidden'/>專區遊戲視頻</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=4':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='pvp' type='hidden'/>PVP攻略 & PVP視頻</td><td>PVP攻略：<input class='input-text' name='setting[module_setting]["+new_k+"][pvp_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)PVP視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][pvpv]' type='text' style='width:50px;' />更多：<input class='input-text' name='setting[module_setting]["+new_k+"][pvp_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][pvp_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=5':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='tujian_topic' type='hidden'/>專區遊戲圖鑑</td><td>遊戲圖鑑：<input class='input-text' name='setting[module_setting]["+new_k+"][tujian]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)</td>"+dis_del;
                break;
                case 'module_type=6':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='tuji' type='hidden'/>專區遊戲圖集</td><td>遊戲圖集：<input class='input-text' name='setting[module_setting]["+new_k+"][tuji_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][tuji_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][tuji_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=7':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='slider' type='hidden'/>視頻頂部輪播</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=8':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='live' type='hidden'/>專區視頻直播</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=9':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video/video_column32' type='hidden'/>專區視頻3X2</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=10':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video/video_column3' type='hidden'/>專區視頻3X3</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=11':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video/video_column3_big' type='hidden'/>專區視頻1+4</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=12':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='video/video_column4' type='hidden'/>專區視頻4X3</td><td>遊戲視頻：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)更多：<input class='input-text' name='setting[module_setting]["+new_k+"][video_pid]' type='text' style='width:50px;' />顯示標題：<input class='input-text' name='setting[module_setting]["+new_k+"][video_title]' type='text' style='width:80px;' /></td>"+dis_del;
                break;
                case 'module_type=13':
                    $ap_html = order+"<td align='center'><input name='setting[module_setting]["+new_k+"][type]' value='custom_new' type='hidden'/>自定義新聞列表</td><td>新聞欄目：<input class='input-text' name='setting[module_setting]["+new_k+"][video_arr]' type='text' style='width:200px;' />&nbsp;(<font color='green'>如含多欄目，用','分隔</font>)</td>"+dis_del;
                break;
            }
            var btn = $(this);
            var point = btn.parents('.contentList').find("table tbody").eq(0).find('>tr').last();
            point.after($ap_html);
            $("#new_k").val(new_k);
        }
    )
    //添加小導航 by jozh
    $(".add_littlenav_type").live("click",
        function(){
            var littlenav_type = $(".littlenav_type").serialize().toString();

            var max_littlenav_list_id_nums = parseInt($("#max_littlenav_list_id_nums").val()) + 1;
            var max_littlenav_id_list_nums = parseInt($("#max_littlenav_id_list_nums").val()) + 1;
            switch( littlenav_type ){
                // case 'littlenav_type=1':
                //  $ap_html = "<tr style='height:36px;'><th style='width:130px;text-align:right;'></th><td style='text-align:left;'>排序：<input class='input-text'  name='setting[tem_setting][littlenav][cont_url][listorder]' type='text' style='width:50px;'/>類型：詳情頁url <span style='float:right;'>分類標題：<input class='input-text'  name='setting[tem_setting][littlenav][cont_url]["+max_littlenav_cont_url_nums+"][title]' type='text' style='width:80px;'/></span></td><td> 鏈接名：<input class='input-text'  name='setting[tem_setting][littlenav][cont_url]["+max_littlenav_cont_url_nums+"][name]' type='text' style='width:80px;'/> url：<input class='input-text'  name='setting[tem_setting][littlenav][cont_url]["+max_littlenav_cont_url_nums+"][littlenav_value]' id='redirect' style='width:300px;' /></td><td><a href='javascript:void(0)' class='dele_nav_item'>刪除</a> | <a href='javascript:void(0)' class='add_littlenav_cont_url'>新增</a></td></tr>";
                // break;
                case 'littlenav_type=2':
                    $ap_html = "<tr style='height:36px;'><th style='width:130px;text-align:right;'></th><td style='text-align:left;'>排序：<input class='input-text' name='setting[tem_setting][littlenav][list_id]["+max_littlenav_list_id_nums+"][listorder]' type='text' style='width:50px;'/>類型：列表頁欄目id<input class='input-text' name='setting[tem_setting][littlenav][list_id]["+max_littlenav_list_id_nums+"][type]' value='list_id' type='text' style='display:none;'> <span style='float:right;'>分類標題：<input class='input-text' name='setting[tem_setting][littlenav][list_id]["+max_littlenav_list_id_nums+"][title]' type='text' style='width:80px;'/></span></td><td>欄目ID數組：<input class='input-text' name='setting[tem_setting][littlenav][list_id]["+max_littlenav_list_id_nums+"][partid_arr]' id='redirect' style='width:300px;' /></td><td><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                    $("#max_littlenav_list_id_nums").val(max_littlenav_list_id_nums);
                break;
                case 'littlenav_type=3':
                    $ap_html = "<tr style='height:36px;'><th style='width:130px;text-align:right;'></th><td style='text-align:left;'>排序：<input class='input-text' name='setting[tem_setting][littlenav][id_list]["+max_littlenav_id_list_nums+"][listorder]' type='text' style='width:50px;'/>類型：欄目下短標題<input class='input-text' name='setting[tem_setting][littlenav][id_list]["+max_littlenav_id_list_nums+"][type]' value='id_list' type='text' style='display:none;'> <span style='float:right;'>分類標題：<input class='input-text' name='setting[tem_setting][littlenav][id_list]["+max_littlenav_id_list_nums+"][name]' type='text' style='width:80px;'/></span></td><td>欄目ID：<input class='input-text' name='setting[tem_setting][littlenav][id_list]["+max_littlenav_id_list_nums+"][partid]' type='text' style='width:80px;'/> 調用條數：<input name='setting[tem_setting][littlenav][id_list]["+max_littlenav_id_list_nums+"][nums]' type='text' style='width:60px;' class='input-text'></td><td><a href='javascript:void(0)' class='dele_nav_item'>刪除</a></td></tr>";
                    $("#max_littlenav_id_list_nums").val(max_littlenav_id_list_nums);
                break;
            }
            var html = $($ap_html);
            var btn = $(this);
            var tr = btn.parent().parent().nextAll(".tr_end_point").eq(0);
            var a = tr.before(html);
            // debugger;
            // console.log(tr);
        }
    )
    //添加快捷導航 by jozh
    $(".add_fastnav_item").live("click",
        function(){
            var max_fastnav_item_nums = parseInt($("#max_fastnav_item_nums").val()) + 1;
            $ap_html = "<tr style='height:36px;'><th style='width:130px;text-align:right;'></th><td style='text-align:left;'>排序：<input class='input-text' name='setting[tem_setting][fastnav]["+max_fastnav_item_nums+"][listorder]' type='text' style='width:50px;'/>名字：<input class='input-text' name='setting[tem_setting][fastnav]["+max_fastnav_item_nums+"][title]' type='text' style='width:200px;'/></td><td style='text-align:left;'><input type='radio' name='setting[tem_setting][fastnav]["+max_fastnav_item_nums+"][nav_type]' value='0' checked class='redirect_type'/> url&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[tem_setting][fastnav]["+max_fastnav_item_nums+"][nav_type]' value='1' class='redirect_type'/> 欄目&nbsp;&nbsp;&nbsp;&nbsp;<input class='input-text' name='setting[tem_setting][fastnav]["+max_fastnav_item_nums+"][fastnav_id]' id='redirect' style='width:300px;'/></td><td style='text-align:left;'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a> | <a href='javascript:void(0)' class='add_fastnav_item'>新增</a></td></tr>";
            $(this).parent().parent().after($ap_html);
            $("#max_fastnav_item_nums").val(max_fastnav_item_nums);
        }
    )
    //添加友情鏈接 by jozh
    $(".add_link_item").live("click",
        function(){
            var max_link_item_nums = parseInt($("#max_link_item_nums").val()) + 1;
            $ap_html = "<tr style='height:36px;'><th style='width:80px;text-align:right;'></th><td style='text-align:left;'>排序：<input name='setting[tem_setting][partlink][links]["+max_link_item_nums+"][listorder]' type='text' class='input-text input-text-c' style='width:37px;'/> 標題：<input class='input-text' name='setting[tem_setting][partlink][links]["+max_link_item_nums+"][title]' type='text' style='width:150px;'/> 鏈接：<input class='input-text' name='setting[tem_setting][partlink][links]["+max_link_item_nums+"][url]' id='redirect' style='width:300px;'/></td><td style='text-align:left;'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a>&nbsp;|&nbsp;<a href='javascript:void(0)' class='add_link_item'>新增</a></td></tr>";
            $(this).parent().parent().after($ap_html);
            $("#max_link_item_nums").val(max_link_item_nums);
        }
    )
    //添加文章內鏈 by jozh
    $(".add_keylink_item").live("click",
        function(){
            var max_keylink_item_nums = parseInt($("#max_keylink_item_nums").val()) + 1;
            $ap_html = "<tr style='height:36px;'><th style='width:80px;text-align:right;'></th><td style='txt-align:left;'>標題：<input class='input-text' name='setting[tem_setting][keylink]["+max_keylink_item_nums+"][title]' type='text' style='width:150px;'/> 鏈接：<input class='input-text' name='setting[tem_setting][keylink]["+max_keylink_item_nums+"][url]' id='redirect' style='width:300px;'/></td><td style='text-align:left;'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a>&nbsp;|&nbsp;<a href='javascript:void(0)' class='add_keylink_item'>新增</a></td></tr>";
            $(this).parent().parent().after($ap_html);
            $("#max_keylink_item_nums").val(max_keylink_item_nums);
        }
    )
    //添加官網內嵌鏈接 by jozh
    $(".add_ifm_link_item").live("click",
        function(){
            var max_ifm_link_item_nums = parseInt($("#max_ifm_link_item_nums").val()) + 1;
            $ap_html = "<tr style='height:36px;'><th style='width:80px;text-align:right;'></th><td style='text-align:left;'>排序：<input name='setting[tem_setting][iframelink]["+max_ifm_link_item_nums+"][listorder]' type='text' class='input-text input-text-c' style='width:37px;'/> 標題：<input class='input-text' name='setting[tem_setting][iframelink]["+max_ifm_link_item_nums+"][title]' type='text' style='width:150px;'/> 鏈接：<input class='input-text' name='setting[tem_setting][iframelink]["+max_ifm_link_item_nums+"][url]' id='redirect' style='width:300px;'/></td><td style='text-align:left;'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a>&nbsp;|&nbsp;<a href='javascript:void(0)' class='add_ifm_link_item'>新增</a></td></tr>";
            $(this).parent().parent().after($ap_html);
            $("#max_ifm_link_item_nums").val(max_ifm_link_item_nums);
        }
    )
    //移動端頭部導航添加 by jozh
    $(".add_wap_nav_item").live("click",
        function(){
            var max_wap_nav_item_nums = parseInt($("#max_wap_nav_item_nums").val()) + 1;
            $ap_html = "<tr style='height:36px;'><th style='width:130px;text-align:right;'></th><td style='text-align:left;'>排序：<input class='input-text' name='setting[wap_setting][nav]["+max_wap_nav_item_nums+"][listorder]' type='text' style='width:50px;'/>名字：<input class='input-text' name='setting[wap_setting][nav]["+max_wap_nav_item_nums+"][name]' type='text' style='width:200px;'/></td><td><input type='radio' name='setting[wap_setting][nav]["+max_wap_nav_item_nums+"][nav_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[wap_setting][nav]["+max_wap_nav_item_nums+"][nav_type]' value='1' class='redirect_type'/> 欄目&nbsp;&nbsp;&nbsp;&nbsp;<input class='input-text' name='setting[wap_setting][nav]["+max_wap_nav_item_nums+"][nav_value]' id='redirect' style='width:300px;'/></td><td style='text-align:left;'><a href='javascript:void(0)' class='dele_nav_item'>刪除</a> | <a href='javascript:void(0)' class='add_wap_nav_item'>新增</a></td></tr>";


            $(this).parent().parent().after($ap_html);
            $("#max_wap_nav_item_nums").val(max_wap_nav_item_nums);
        }
    )
    $(".dele_nav_item").live("click",
        function(){
            $(this).parent().parent().remove();
        }
    )
    //移動端自定義欄目添加 by wangqiang
    $(".add_wap_category").live("click",
        function(){
            var max_wap_categroy_item_nums = parseInt($("#max_wap_categroy_item_nums").val()) + 1;
            $ap_html = "<tr style='height:32px;'><th style='width:130px;text-align:right;'></th><td style='text-align:left;'>欄目名稱：<input name='setting[wap_setting][category][max_wap_categroy_item_nums][cname]'  value='' type='text' style='width:100px;'/>&nbsp;&nbsp;欄目ID：<input name='setting[wap_setting][category][max_wap_categroy_item_nums][cid]' value='' type='text' style='width:100px;'/></td><td></td><td style='text-align:left;'><a href='javascript:void(0)' class='dele_wap_category'>刪除</a>&nbsp;|&nbsp;<a href='javascript:void(0)' class='add_wap_category'>新增</a></td></tr>";
            $(this).parent().parent().after($ap_html);
            $("#max_wap_categroy_item_nums").val(max_wap_categroy_item_nums);
        }
    )
    $(".dele_wap_category").live("click",
        function(){
            $(this).parent().parent().remove();
        }
    )
    //頭圖
    $(".add_header_pic").live("click",
        function(){

            var new_header_pic_nums = parseInt($("#max_header_pic_nums").val()) + 1;
            $.ajax({
                url: "?m=partition&c=partition&a=ajax_upload_img2&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
                async : false,
                data : "curr_id=" + new_header_pic_nums,
                type:"post",
                success: function( data  ){
                    //console.log(data);
                    data = eval(data);
                    $ap_html = "<tr style='margin-top:10px;'><td><input name='header_pic["+ new_header_pic_nums +"][listorder]' type='text' class='input-text' style='width:30px;' value=''/></td><td><input name='header_pic["+ new_header_pic_nums +"][name]' type='text' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>" + data +"</td><td><input type='radio' name='header_pic["+ new_header_pic_nums +"][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='header_pic["+ new_header_pic_nums +"][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='header_pic["+ new_header_pic_nums +"][redirect]' class='input-text' style='width:300px;' id='redirect_btn' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_header_pic'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_header_pic'>新增</a></td></tr>";
                    //$(this).parent().parent().after($ap_html);
                    //$("#max_redirect_btn_nums").val(new_btn_nums);
                }
            });

            $(this).parent().parent().after($ap_html);
            $("#max_header_pic_nums").val(new_header_pic_nums);
        }
    )
    $(".dele_header_pic").live("click",
        function(){
            //alert($(this).parent().parent().html());
            $(this).parent().parent().remove();
        }
    )
    //廣告配置
    $(".add_ad_pic").live("click",
        function(){

            var new_ad_pic_nums = parseInt($("#max_ad_pic_nums").val()) + 1;
            $.ajax({
                url: "?m=partition&c=partition&a=ajax_upload_img2&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
                async : false,
                data : {'curr_id':new_ad_pic_nums,'name':'setting[ad_pic]'},
                type:"post",
                success: function( data  ){
                    //console.log(data);
                    data = eval(data);
                    $ap_html = "<tr style='margin-top:10px;'><td><input name='setting[ad_pic]["+ new_ad_pic_nums +"][listorder]' type='text' class='input-text' style='width:30px;' value='0'/></td><td><input name='setting[ad_pic]["+ new_ad_pic_nums +"][name]' type='text' class='input-text' style='width:300px;'/></td><td style='text-align:center;'>" + data +"</td><td><input type='radio' name='setting[ad_pic]["+ new_ad_pic_nums +"][redirect_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[ad_pic]["+ new_ad_pic_nums +"][redirect_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='setting[ad_pic]["+ new_ad_pic_nums +"][redirect]' class='input-text' style='width:300px;' id='redirect_btn' /></td><td style='text-align:center;'><a href='javascript:void(0)' class='dele_ad_pic'>刪除</a></td><td style='text-align:center;'><a href='javascript:void(0)' class='add_ad_pic'>新增</a></td></tr>";
                    //$(this).parent().parent().after($ap_html);
                    //$("#max_redirect_btn_nums").val(new_btn_nums);
                }
            });

            $(this).parent().parent().after($ap_html);
            $("#max_ad_pic_nums").val(new_header_pic_nums);
        }
    )
    $(".dele_ad_pic").live("click",
        function(){
            //alert($(this).parent().parent().html());
            $(this).parent().parent().remove();
        }
    )
    //Banner v2
    $(".add_button_item").live("click",
        function(){
            var max_button_item_nums = parseInt($("#max_button_item_nums").val()) + 1;
            $.ajax({
                url: "?m=partition&c=partition&a=ajax_upload_img3&pc_hash=<?php echo $_SESSION['pc_hash'];?>",
                async : false,
                data : "curr_id=" + max_button_item_nums,
                type:"post",
                success: function( data  ){
                    data = $.parseJSON(data);
                    $ap_html = "<tr style='margin-top:10px;'><td style='width:100px;'>排序：<input name='setting[button_v2]["+max_button_item_nums+"][listorder]' type='text' style='width:50px;' class='input-text' /></td><td style='width:280px;' >名字：<input name='setting[button_v2]["+max_button_item_nums+"][name]' type='text' style='width:200px;' class='input-text' /></td><td style='width:300px;'>圖片："+data+"</td><td style='text-align:left;width:430px;'><input type='radio' name='setting[button_v2]["+max_button_item_nums+"][button_type]' value='0' checked class='redirect_type' /> url&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[button_v2]["+max_button_item_nums+"][button_type]' value='1' class='redirect_type' /> 欄目&nbsp;&nbsp;&nbsp;<input type='radio' name='setting[button_v2]["+max_button_item_nums+"][button_type]' value='2' class='redirect_type' /> 卡牌&nbsp;&nbsp;&nbsp;<input name='setting[button_v2]["+max_button_item_nums+"][button_value]' id='redirect' style='width:300px;' class='input-text' /></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='dele_button_item'>刪除</a></td><td style='text-align:left;width:30px;'><a href='javascript:void(0)' class='add_button_item'>新增</a></td><td style='width:100px;'></td></tr>";
                }
            });
            $(this).parent().parent().after($ap_html);
            $("#max_button_item_nums").val(max_button_item_nums);
        }
    )
    $(".dele_button_item").live("click",
        function(){
            $(this).parent().parent().remove();
        }
    )
</script>


<script language="JavaScript">
<!--
    window.top.$('#display_center_id').css('display','none');
    $(function(){
        var url = $('#url').val();
        if(!url.match(/^http:\/\//)) $('#url').val('');
    })
    function SwapTab(name,cls_show,cls_hide,cnt,cur){
        for(i=1;i<=cnt;i++){
            if(i==cur){
                 $('#div_'+name+'_'+i).show();
                 $('#tab_'+name+'_'+i).attr('class',cls_show);
            }else{
                 $('#div_'+name+'_'+i).hide();
                 $('#tab_'+name+'_'+i).attr('class',cls_hide);
            }
        }
    }

    function load_file_list(en_part) {
        $.getJSON('?m=admin&c=category&a=public_tpl_file_list_partition&en_part='+en_part, function(data){$('#category_template').html(data.category_template);$('#list_template').html(data.list_template);$('#show_template').html(data.show_template);});
    }
    <?php echo "load_file_list('".$catid."')"; ?>

    //顯示模板配置
    function show_pic_type(obj) {
        if (obj==0 || obj==1){
            $('#pic_type_1').show();
        } else {
            $('#pic_type_1').hide();
        }
    }

    //顯示模板配置
    function show_tem_type(obj) {
        for (var i=0; i<=2; i++){
            if (obj==i){
                $('#tem_type_'+i).show();
            } else {
                $('#tem_type_'+i).hide();
            }
        }
    }
//-->
</script>
<!-- by jozh -->
<script type="text/javascript">
    $(".show_url").live("click",
        function(){
            var iframe_url = $('.show_url').attr('data');
            var neiqian_list_partid = $("#neiqian_list_partid").val();
            var neiqian_url = iframe_url+'list_'+neiqian_list_partid+'_1.html';
            $("#neiqian_url").html(neiqian_url);
            $("#neiqian_url").attr('href',neiqian_url);
            $(".partname").val(domain_dir);
        }
    )
</script>
