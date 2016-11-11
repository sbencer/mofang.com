<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-10">
    <form method="post" action="?m=h5game&c=h5game&a=edit" name="myform" id="myform">
         <input type="hidden" name="info[id]" value="<?php echo $id;?>">
        <fieldset>
            <legend>H5遊戲修改</legend>
            <table class="table_form" width="100%" cellspacing="0">
                <tbody> 
                    <tr>
                        <th><strong>圖標上傳：</strong></th>
                        <td>
                            <div>
                                <?php echo form::images('info[icon]', 'icon', $icon, 'content');?>
                            </div>
                        </td>
                    </tr>


                    <tr>
                        <th><strong>圖標上傳：</strong></th>
                        <td>
                            <div>
                                <?php echo form::images('info[thumb]', 'thumb', $thumb, 'content_thumb');?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><strong>遊戲名：</strong></th>
                        <td><input name="info[gamename]" id="gamename" class="input-text" type="text" size="50" value="<?php echo $gamename;?>"/></td>
                    </tr>
                    <tr>
                        <th><strong>簡介：</strong></th>
                        <td>

                            <textarea style="height: 100px; width: 400px;" id="description" cols="20" rows="3" name="info[description]" class="input-text"><?php echo $description;?></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th><strong>詳情：</strong></th>
                        <td>
                            <textarea style="height: 100px; width: 400px;" id="content" cols="20" rows="3" name="info[content]" class="input-text"><?php echo $content;?>
                            </textarea>
                        </td>
                    </tr>

                    <tr>
                        <th><strong>遊戲鏈接：</strong></th>
                        <td><input name="info[link]" id="link" class="input-text" type="text" size="50" value="<?php echo $link;?>"/></td>
                    </tr>
                    <tr>
                        <th><strong>大小：</strong></th>
                        <td><input name="info[size]" id="size" class="input-text" type="text" size="20" value="<?php echo $size;?>"/>(示例：10M )</td>
                    </tr>

                    <tr>
                        <th><strong>熱度值：</strong></th>
                        <td><input name="info[hot]" id="hot" class="input-text" type="text" size="20" value="<?php echo $hot;?>"/></td>
                    </tr>

                    <tr>
                        <th><strong>支持平台：</strong></th>
                        <td>
                            <label class="ib" style="width:120px"><input type="checkbox" name="info[android]" id="android" value="1" <?php if($android==1){ echo 'checked';}?>> 安卓</label>
                            <label class="ib" style="width:120px"><input type="checkbox" name="info[ios]" id="ios" value="1" <?php if($ios==1){ echo 'checked';}?>> IOS</label>
                            <label class="ib" style="width:120px"><input type="checkbox" name="info[ipad]" id="ipad" value="1" <?php if($ipad==1){ echo 'checked';}?>> IPAD</label>
                        </td>
                    </tr>

                    <tr>
                        <th><strong>所屬分類：</strong></th>
                        <td> 
                            <select name="info[category]" id="category">
                                <option value="1" <?php if($category==1){echo 'selected';}?>>休閒類</option>
                                <option value="2" <?php if($category==2){echo 'selected';}?>>益智類</option>
                                <option value="3" <?php if($category==3){echo 'selected';}?>>冒險類</option>
                                <option value="4" <?php if($category==4){echo 'selected';}?>>體育類</option>
                                <option value="5" <?php if($category==5){echo 'selected';}?>>射擊類</option>
                                <option value="6" <?php if($category==6){echo 'selected';}?>>策略類</option>
                                <option value="7" <?php if($category==7){echo 'selected';}?>>敏捷類</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th><strong>狀態：</strong></th>
                        <td>
                            <select name="info[status]" id="status">
                                <?php if($status==99){ ?>
                                    <option value="99" checked>開放</option>
                                    <option value="0">關閉</option> 
                                <?php }else{?> 
                                    <option value="99" >開放</option>
                                    <option value="0" checked>關閉</option> 
                                <?php } ?>
                                
                            </select>
                        </td>
                    </tr> 
                </tbody>
            </table>
            
            <div class="bk15"></div>
            <input type="submit" value="提交" class="button" name="dosubmit" id="dosubmit">
        </fieldset>
    </form>
</div>
