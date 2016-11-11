<?php
    defined('IN_ADMIN') or exit('No permission resources.');
    $show_dialog = 1;
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

<form name="searchform" style="padding-bottom:100px;" id="searchform" action="?m=activity&c=activity&a=add_map_setting" method="get" >
    <div class="J_imgMap">
        <img src="" name="test" usemap="#Map" ref="imageMaps">
    </div>
    <input type="button" onclick="javascript:save_datas();" value="記錄結果"/>
    <input type="button" onclick="javascript:cancal();" value="取消操作"/>
</form>
<script type="text/javascript" src="<?php echo JS_PATH.'jquery.image-maps.js';?>"></script>
<script>
     var DEBUG = 0;
    $(function(){
        // 加載背景圖
        var back_url = $("#bg_pic",window.opener.window.document).val();
        var back_img = $('.J_imgMap img');
        back_img.attr('src',back_url);
        back_img.on("load",function(){

            // 初始化寬高
            back_img.attr("width",back_img.width());
            back_img.attr("height",back_img.height());

            // 初始化組件
            $('.J_imgMap').imageMaps();

            // 還原鏈接位置
            var v = $("#map_setting",window.opener.window.document).val();
            var links = JSON.parse(v);
            var addBtn = $(".button-conrainer input");
            
            for(var i in links){
                linksFn(links[i]);
            }
            function linksFn(valArr){
                                
                $.each(valArr,function(i,o){
                     addBtn.click();
                    setTimeout(function(){
                        var ref = o.ref || "1";
                        var pos = $('.map-position[ref='+ref+']');
                        pos.css({
                          left:o.left,
                          top:o.top,
                          width:o.width,
                          height:o.height,
                        });
                        var link = $('.map-link[ref='+ref+']');
                        link.find(".link_coords").val(o.coords);
                        link.find(".link_name").val(o.link);
                        var target = link.find('.link_target');
                        if(o.target == '_blank'){
                            target.attr('checked',"checked");
                        }else{
                            target.removeAttr('checked');
                        }
                    },300);
                }); 

            }
           
           
        });
    });
    function save_datas(){
        var links = {};
        var aArr=[];
        var videoArr=[];
        var va = true;
        $('.map-link').each(function(){
            if(!va){
                return false;
            }
            var p = $(this);
            var InputVal = p.find(".link_name").val();
            
            var target = p.find(".link_target").attr('checked');
            target = target?"_blank":"_self";
            var coords = p.find(".link_coords").val();
            var coordsMap = coords.split(',');
            var x1 = parseInt(coordsMap[0],10);
            var y1 = parseInt(coordsMap[1],10);
            var x2 = parseInt(coordsMap[2],10);
            var y2 = parseInt(coordsMap[3],10);

            var re = /(script|embed)/g;
            if(re.test(InputVal)){
                var oJson = {
                    ref : p.attr("ref"),
                    link :InputVal,
                    target:target,
                    left:x1,
                    top:y1,
                    width:x2-x1,
                    height:y2-y1,
                    coords:coords
                }
                videoArr.push(oJson);
            }else{
                 var oJson = {
                    ref : p.attr("ref"),
                    link :InputVal,
                    target:target,
                    left:x1,
                    top:y1,
                    width:x2-x1,
                    height:y2-y1,
                    coords:coords
                }
                aArr.push(oJson);
            }
            
            if(!InputVal|| !InputVal.length){
                va = false;
                var name = p.find(".link-number-text").text();
                alert("請填寫【" + name + "】對應的網址");
                p.find(".link_name").focus();
            }
        });
        if(!va){
            return false;
        }
        links['a']=aArr;
        links['video']=videoArr;
        links=JSON.stringify(links);
        $("#map_setting",window.opener.window.document).val(links);
        window.close();
    }
    function cancal(){
        window.close();
    }
</script>
</body>
</html>
