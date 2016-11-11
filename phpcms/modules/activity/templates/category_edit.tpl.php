<?php
    defined('IN_ADMIN') or exit('No permission resources.');
    $show_dialog = $show_header = 1;
    include $this->admin_tpl('header', 'activity');
?>

<?php if( $show_header ) { ?>
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <?php if(isset($big_menu)) { echo '<a class="add fb" href="'.$big_menu[0].'"><em>'.$big_menu[1].'</em></a>　';} else {$big_menu = '';} ?>
    <?php if(!$parentid) { echo admin::submenu($_GET['menuid'],$big_menu);} ?>
    </div>
</div>
<?php } ?>

<?php if( $parentid ) {?>
<p style="padding-left:10px;">
    <span style="color:purple;">當前位置:&nbsp;<?php echo $curr_parent_name;?> </span>
</p>
<?php }?>

<style type="text/css">
    html{_overflow-y:scroll}
</style>

<form name="myform" id="myform" action="?m=activity&c=activity&a=edit" method="post">
    <div class="pad-10">
        <div class="col-tab">
            <ul class="tabBut cu-li">
                <li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',12,1);">添加活動</li>
                <li id="tab_setting_2" onclick="SwapTab('setting','on','',12,2);">SEO配置</li>
                <li id="tab_setting_3" onclick="SwapTab('setting','on','',12,3);">浮窗配置</li>
                <li id="tab_setting_4" onclick="SwapTab('setting','on','',12,4);"><font color="green">僅供微信分享配置</font></li>
                <li id="tab_setting_5" onclick="SwapTab('setting','on','',12,5);"><font color="red">輪盤設置</font></li>
            </ul>
            <!-- 基本選項 -->
            <div id="div_setting_1" class="contentList pad-10">
                <table width="100%" class="table_form ">
                    <tbody>
                        <tr>
                            <th width="200"><?php if($parentid) { echo '分頁名稱';}else{ echo '活動名稱';}?>：</th>
                            <td>
                                <span id="normal_add">
                                    <?php if ($parentid) {?>
                                    <input type="hidden" name="info[parentid]" value="<?php echo $parentid;?>">
                                    <?php }?>
                                    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                                    <input type="text" name="info[activity_name]" id="activity_name" class="input-text" value="<?php echo $activity_name;?>">
                                </span>
                            </td>
                        </tr>
                        <tr <?php if ($parentid) {?>style="display:none;"<?php }?>>
                            <th width="200">活動英文標識：</th>
                            <td><input name='info[domain_dir]' type='text' id='meta_title' value="<?php echo $domain_dir;?>" maxlength='60'></td>
                        </tr>
                        <tr <?php if ($parentid) {?>style="display:none;"<?php }?>>
                            <th width="200">是否顯示工具條：</th>
                            <td>
                                <input type='radio' name='info[is_use_ad]' value='1' <?php if($is_use_ad=='1') echo 'checked'; ?> class="redirect_type" /> 是&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type='radio' name='info[is_use_ad]' value='0' <?php if($is_use_ad=='0') echo 'checked'; ?> class="redirect_type" /> 否&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr <?php if ($parentid) {?>style="display:none;"<?php }?>>
                            <th width="200">是否顯示通底：</th>
                            <td>
                                <input type='radio' name='info[is_use_footer]' value='1' <?php if($is_use_footer=='1') echo 'checked'; ?> class="redirect_type" /> 是&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type='radio' name='info[is_use_footer]' value='0' <?php if($is_use_footer=='0') echo 'checked'; ?> class="redirect_type" /> 否&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <?php if ($parentid) {?>
                        <tr>
                            <th width="200">活動單頁名稱：</th>
                            <td><input name='info[page_name]' type='text' id='meta_title' value="<?php echo $page_name;?>" maxlength='60'></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <th>背景圖：</th>
                            <td><?php echo form::images('info[bg_pic]', 'bg_pic', $bg_pic, 'content');?></td>
                        </tr>
                        <tr>
                            <th>添加熱區：</th>
                            <td>
                                <textarea style="display:none;" name='info[map_setting]' id="map_setting"><?php echo $map_setting;?></textarea>
                                
                                <input name="dosubmit_test" type="button" class="button" onclick="window.open('?m=activity&c=activity&a=add_map_setting');" onclick22="omnipotent('map_setting','?m=activity&c=activity&a=add_map_setting','添加背景熱區',1)" value="添加背景熱區">
                            </td>
                        </tr>
                        <tr>
                            <th width="200">二維碼：</th>
                            <td><?php echo form::images('info[qr_code]', 'qr_code', $qr_code, 'content');?></td>
                        </tr>
                        <tr>
                            <th width="200">統計代碼：</th>
                            <td>
                                <textarea name="info[staticstics_code]" id="staticstics_code" style="width:90%;height:40px"><?php echo $staticstics_code;?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- SEO配置 -->
            <div id="div_setting_2" class="contentList pad-10 hidden">
                <table width="100%" class="table_form ">
                    <tr>
                        <th width="200"><strong>META Title（欄目標題）</strong><br/>針對搜索引擎設置的標題</th>
                        <td><input name='setting[meta_title]' type='text' id='meta_title' value='<?php echo $setting['meta_title'];?>' size='60' maxlength='60'></td>
                    </tr>
                    <tr>
                        <th><strong>META Keywords（欄目關鍵詞）</strong><br/>關鍵字中間用半角逗號隔開</th>
                        <td><textarea name='setting[meta_keywords]' id='meta_keywords' style="width:90%;height:40px"><?php echo $setting['meta_keywords'];?></textarea></td>
                    </tr>
                    <tr>
                        <th><strong>META Description（欄目描述）</strong><br/>針對搜索引擎設置的網頁描述</th>
                        <td><textarea name='setting[meta_description]' id='meta_description' style="width:90%;height:50px"><?php echo $setting['meta_description'];?></textarea></td>
                    </tr>
                </table>
            </div>
            <!-- 浮窗配置 -->
            <div id="div_setting_3" class="contentList pad-10 hidden">
            <table width="100%" class="table_form ">
                    <tr <?php if ($parentid) {?>style="display:none;"<?php }?>>
                        <th width="200">浮窗開關：</th>
                        <td>
                        <input type='radio' name='float_win[open]' value='0' class="redirect_type" <?php if($float_win['open']==0) echo 'checked'; ?>/> 關閉&nbsp;&nbsp;&nbsp;
                        <input type='radio' name='float_win[open]' value='1' class="redirect_type" <?php if($float_win['open']==1) echo 'checked'; ?>/> 開啟&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <th width="200">遊戲圖標：</th>
                        <td>
                            <?php echo form::images('float_win[game_pic]', 'game_pic', $float_win['game_pic'], 'content');?>
                            &nbsp;&nbsp;浮窗底色：&nbsp;&nbsp;
                            <input name='float_win[global_c]' type='text' id='meta_title' value='<?php echo $float_win['global_c'];?>' maxlength='60'>
                        </td>
                    </tr>
                    <tr>
                        <th width="200">標題：</th>
                        <td>
                            <input name='float_win[qr_title]' type='text' id='meta_title' value='<?php echo $float_win['qr_title'];?>' size="60" maxlength='60'>
                            &nbsp;&nbsp;說明：&nbsp;&nbsp;
                            <input name='float_win[qr_content]' type='text' id='meta_title' value='<?php echo $float_win['qr_content'];?>' size="40" maxlength='60'>
                        </td>
                    </tr>
                    <tr>
                        <th width="200">二維碼：</th>
                        <td>
                            <?php echo form::images('float_win[qr_pic]', 'qr_pic', $float_win['qr_pic'], 'content');?>
                            &nbsp;&nbsp;底部文字：&nbsp;&nbsp;
                            <input name='float_win[qr_word]' type='text' id='meta_title' value='<?php echo $float_win['qr_word'];?>' maxlength='60'>
                        </td>
                    </tr>
                    <tr>
                        <th>官網鏈接：</th>
                        <td>
                            <input name='float_win[official_url]' type='text' id='meta_title' value='<?php echo $float_win['official_url'];?>' size="60" maxlength='60'>
                            &nbsp;&nbsp;官網鏈接底色：&nbsp;&nbsp;
                            <input name='float_win[official_c]' type='text' id='meta_title' value='<?php echo $float_win['official_c'];?>' maxlength='60'>
                        </td>
                    </tr>
                    <tr>
                        <th>攻略站鏈接：</th>
                        <td>
                            <input name='float_win[partition_url]' type='text' id='meta_title' value='<?php echo $float_win['partition_url'];?>' size="60" maxlength='60'>
                            &nbsp;&nbsp;攻略站鏈接底色：&nbsp;&nbsp;
                            <input name='float_win[partition_c]' type='text' id='meta_title' value='<?php echo $float_win['partition_c'];?>' maxlength='60'>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- 微信分享 -->
            <div id="div_setting_4" class="contentList pad-10 hidden">
                <table width="100%" class="table_form ">
                    <tr>
                        <th width="200">分享圖片</th>
                        <td><?php echo form::images('weixin[pic]', 'activity_pic', $weixin['pic'], 'content');?></td>
                    </tr>
                    <tr>
                        <th>分享標題</th>
                        <td><input name='weixin[title]' type='text' id='meta_title' value='<?php echo $weixin['title'];?>' size='60' maxlength='60'></td>
                    </tr>
                    <tr>
                        <th>分享描述</th>
                        <td><textarea name='weixin[description]' id='meta_description' style="width:90%;height:50px"><?php echo $weixin['description'];?></textarea></td>
                    </tr>
                </table>
            </div>
            <!-- 輪盤設置 -->
            <div id="div_setting_5" class="contentList pad-10 hidden">
                <table width="100%" class="table_form ">
                    <tbody>
                        <tr <?php if ($parentid) {?>style="display:none;"<?php }?>>
                            <th width="200">輪盤類型：</th>
                            <td>
                            <input type='radio' name='roulette[type]' value='0' class="redirect_type" <?php if($roulette['type']==0) echo 'checked'; ?>/> 0輪&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='roulette[type]' value='1' class="redirect_type" <?php if($roulette['type']=='1') echo 'checked'; ?>/> 8輪&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type='radio' name='roulette[type]' value='2' class="redirect_type" <?php if($roulette['type']=='2') echo 'checked'; ?>/> 14輪&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <th>關聯活動ID：</th>
                            <td><input name='roulette[relation_id]' type='text' id='meta_title' value='<?php echo $roulette["relation_id"];?>' size='20' maxlength='60'></td>
                        </tr>
                        <tr>
                            <th>抽獎按鈕：</th>
                            <td><?php echo form::images('roulette[button_pic]', 'button_pic', $roulette["button_pic"], 'content');?></td>
                        </tr>
                        <tr>
                            <th>謝謝參與ID：</th>
                            <td><input name='roulette[default]' type='text' id='default' value='<?php echo $roulette["default"];?>' size='20' maxlength='60'></td>
                        </tr>
                        <tr>
                          <th width="80">獎品圖：</th>
                          <td>
                          <?php 
                            if(is_array($roulette['prize_pic'])) {
                                foreach($roulette['prize_pic'] as $_k=>$_v) {
                                $list_str .= "<div id='image_prize_{$_k}' style='padding:1px'><input type='text' name='prize_key[]' value='{$_k}' style='width:160px;' class='input-text'><input type='text' name='prize_value[]' value='{$_v}' style='width:310px;' ondblclick='image_priview(this.value);' class='input-text'><a href=\"javascript:remove_div('image_prize_{$_k}')\">".L('remove_out', '', 'content')."</a></div>";
                                }
                                echo $list_str;
                            }
                            ?>
                            <div id="prize" class="picList"></div>
                            <?php 
                                $upload_number = 14;
                                $upload_allowext = 'gif|jpg|jpeg|png|bmp';
                                $isselectimage = 0;
                                $authkey = upload_key("$upload_number,$upload_allowext,$isselectimage");?>
                                <div class="picBut cu"><a herf="javascript:void(0);" onclick="javascript:flashupload('prize_pics', '附件上傳','prize',change_images,'<?php echo $upload_number?>,<?php echo $upload_allowext;?>,<?php echo $isselectimage;?>','content','0','<?php echo $authkey;?>')"> 選擇圖片 </a></div>
                        </td>
                        </tr>
                        <tr>
                            <th>輪盤規則說明/描述</th>
                            <td><textarea name='roulette[rule]' id='rule' style="width:500px;height:135px"><?php echo $roulette['rule'];?></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bk15"></div>
            <input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button">
        </div>
    </div>
</form>

<script language="JavaScript">
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
    function change_images(uploadid,returnid){
        var d = window.top.art.dialog({id:uploadid}).data.iframe;
        var in_content = d.$("#att-status").html().substring(1);
        var in_filename = d.$("#att-name").html().substring(1);
        var str = $('#'+returnid).html();
        var contents = in_content.split('|');
        var filenames = in_filename.split('|');
        $('#'+returnid+'_tips').css('display','none');
        if(contents=='') return true;
        $.each( contents, function(i, n) {
            var ids = parseInt(Math.random() * 10000 + 10*i);
            var filename = filenames[i].substr(0,filenames[i].indexOf('.'));
            str += "<li id='image"+ids+"'><input type='text' name='"+returnid+"_key[]' value='"+filename+"' style='width:160px;' class='input-text' onfocus=\"if(this.value == this.defaultValue) this.value = ''\"     onblur=\"if(this.value.replace(' ','') == '') this.value = this.defaultValue;\"><input type='text' name='"+returnid+"_value[]' value='"+n+"' style='width:310px;' ondblclick='image_priview(this.value);' class='input-text'><a href=\"javascript:remove_div('image"+ids+"')\">移除</a> </li>";
            });

        $('#'+returnid).html(str);
    }
    function image_priview(img) {
        window.top.art.dialog({title:'圖片查看',fixed:true, content:'<img src="'+img+'" />',id:'image_priview',time:5});
    }
    function remove_div(id) {
        $('#'+id).remove();
    }
</script>
</body>
</html>
