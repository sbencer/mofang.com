<?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/wap/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:50893072456027f1ef377e4-04731316%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76c531553b5c72727b902511c8478003569d094a' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/wap/index.tpl',
      1 => 1443008204,
      2 => 'file',
    ),
    '00f5f52938c1a9a56840d9aff22e5ec881afb0f8' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/wap/base.tpl',
      1 => 1443008204,
      2 => 'file',
    ),
    '5f9a030aba09c4ba94554bba191c2825f55162fd' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/common/hw/m_base.tpl',
      1 => 1443006344,
      2 => 'file',
    ),
    'f785ecb67e738d2591683df133e90adfd5cfcd20' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/common/m_doctype.tpl',
      1 => 1443006345,
      2 => 'file',
    ),
    '31cb7aa8d1a147e5d09fdcc2e85d670e9fed6d4c' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/header.tpl',
      1 => 1443008206,
      2 => 'file',
    ),
    '5502fca00cb86827d37b30f2082accc2d5b74fac' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/swipe_slider.tpl',
      1 => 1443008206,
      2 => 'file',
    ),
    '4eca0cbe6962e0c0863c9f884b092b7c923f5ecc' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/picture.tpl',
      1 => 1443008206,
      2 => 'file',
    ),
    '4a324b942c279a5575f408460853509be9947233' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/news.tpl',
      1 => 1443008206,
      2 => 'file',
    ),
    'd11064d43001889d7ccf372fc07300b4fd8d2afa' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/ranking.tpl',
      1 => 1443008206,
      2 => 'file',
    ),
    '177009520e3e5ba290201ce57b775aea401d04a4' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/calendar.tpl',
      1 => 1443008205,
      2 => 'file',
    ),
    '137b22a442afea3f5ddc7d59ae0dc7c2e18cd1e2' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/hot_search.tpl',
      1 => 1443008206,
      2 => 'file',
    ),
    '08e65ed9fb0b571fa8a228fd7f9664606eb608c0' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl',
      1 => 1443008206,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50893072456027f1ef377e4-04731316',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_56027f1f3384d7_67883995',
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'MFE_USE_COMBO' => 0,
    'MFE_DEBUG' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56027f1f3384d7_67883995')) {function content_56027f1f3384d7_67883995($_smarty_tpl) {?>

<!doctype html>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISResource::setFramework(FISResource::load("common:statics/js/loader/sea.js", $_smarty_tpl->smarty));FISPagelet::init('NOSCRIPT'); ?><html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    
    <meta name="format-detection" content="telephone=no" />

    <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>

    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">

    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
">

    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/m_base.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/m_base.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/m_normalize.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/m_normalize.css",$_smarty_tpl->smarty);?>

    
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />
    
    <?php echo $_smarty_tpl->getSubTemplate ('common/p/jiajia_api.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


    
        <?php if ($_smarty_tpl->tpl_vars['MFE_USE_COMBO']->value){?>
            <?php if ($_smarty_tpl->tpl_vars['MFE_DEBUG']->value){?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea/combo.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea/combo.js',$_smarty_tpl->smarty);?>
            <?php }else{ ?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/boot.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/boot.js',$_smarty_tpl->smarty);?>
            <?php }?>
        <?php }else{ ?>
            <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
        <?php }?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('modules:statics/js/sea-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('modules:statics/js/sea-config.js',$_smarty_tpl->smarty);?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/base-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/base-config.js',$_smarty_tpl->smarty);?>
    

    

	

    
    <script>

    
    var MFE = {};

    
    var CONFIG = {};

    </script>



<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::cssHook();?><?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::jsLoaderHook();?></head>

<body>

    
	
	<?php /*  Call merged included template "tw_acg/widget/wap/header.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91cc5c11_64922320($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/header.tpl" */?>
    
    <div class="m-content">
        
        <?php /*  Call merged included template "tw_acg/widget/wap/swipe_slider.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/swipe_slider.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91cf0000_81637504($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/swipe_slider.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/picture.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/picture.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91d1c462_57851372($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/picture.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/news.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/news.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91d41472_51988545($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/news.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/ranking.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/ranking.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91d6cae1_18719282($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/ranking.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/calendar.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/calendar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91d74896_07111252($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/calendar.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/hot_search.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/hot_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91d85065_58620486($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/hot_search.tpl" */?>
    </div>

    
    <?php /*  Call merged included template "tw_acg/widget/wap/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '50893072456027f1ef377e4-04731316');
content_56028f91d8dcc7_44762937($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/footer.tpl" */?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty);?>


</body><?php if(class_exists('FISPagelet', false)){echo FISPagelet::jsHook();}?>
<?php $tpl=str_replace("\\", "/", $_smarty_tpl->template_resource);if(!class_exists('FISPagelet')){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::setPageName(str_replace("/data/www/taiwanACG/phpcms/templates/v4/", "", $tpl));$_smarty_tpl->registerFilter('output', array('FISPagelet', 'renderResponse'));?></html>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91cc5c11_64922320')) {function content_56028f91cc5c11_64922320($_smarty_tpl) {?><div class="zq_header">
    <a class="icon-menu" href="javascript:;"></a>
    <h1 class="topic">次元角落ACG資訊站</h1>
    <span class="icon-search"></span>
</div>
<!--logo导航 start-->
<div class="logo_http://local.acgtw.com/index.php#2nav">
    <a class="icon_logo" href="<?php echo siteurl($_smarty_tpl->tpl_vars['siteid']->value);?>
">logo</a>
    <ul class="nav_template">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('module'=>'content','catid'=>'0','siteid'=>'((string)$_smarty_tpl->tpl_vars[siteid]->value)','order'=>'listorder ASC','limit'=>'25',));}$_smarty_tpl->assign('data',$data);?>
        <li class="curr"><a href="#2">News</a></li>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['catname'];?>
</a></li>
        <?php } ?>
        <li><a href="#2">活動</a></li>
        <li><a href="#2">專欄</a></li>
        <li><a href="#2">小說</a></li>
        <li><a href="#2">遊戲</a></li>
        <li><a href="#2">排行</a></li>
        <li><a href="#2">周邊</a></li>
        <li><a href="#2">美圖</a></li>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<!--logo导航 end-->
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/swipe_slider.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91cf0000_81637504')) {function content_56028f91cf0000_81637504($_smarty_tpl) {?><div id="slideBox" class="swipe">
    <div class="swipe-wrap">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('module'=>'content','posid'=>'18','order'=>'listorder DESC','thumb'=>'1','limit'=>'5',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <div class="slide-item">
            <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" ><img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],320,180);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
"><div class="slider-filter"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</div></a>
        </div>
        <?php } ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </div>
    <ul id="slidePage">
        <li class="sliderCurr"></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/swipe_slider.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/swipe_slider.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/swipe_slider.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/swipe_slider.js",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/picture.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91d1c462_57851372')) {function content_56028f91d1c462_57851372($_smarty_tpl) {?><div class="picture">
    <ul class="clearfix">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'19','order'=>'listorder DESC','thumb'=>'1','limit'=>'6',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],160,90);?>
"></a>
            <span><img src="/statics/v4/tw_acg/wap/images/new.png"></span>
            <div class="shadow"></div>
            <p><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</p>
        </li>
        <?php } ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/picture.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/picture.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/news.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91d41472_51988545')) {function content_56028f91d41472_51988545($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/data/www/taiwanACG/phpcms/init/smarty/plugins/modifier.truncate.php';
?><div class="news clearfix">
    <div class="list_title clearfix">
        <h2 class="fl">ACG資訊看這邊</h2>
        <p class="fr"><a href="#">MORE>></a></p>
    </div>
    <ul class="substance clearfix">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('module'=>'content','posid'=>'20','order'=>'listorder DESC','thumb'=>'1','limit'=>'10',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li>
        	<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
">
            <h3><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</h3>
            <div class="list_content clearfix">
                <div class="fl"><img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],160,90);?>
"></div>
                <p class="fl"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['val']->value['description'],70);?>
</p>
            </div>
            </a>
        </li>
        <?php } ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/ranking.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91d6cae1_18719282')) {function content_56028f91d6cae1_18719282($_smarty_tpl) {?><div class="ranking">
    <div class="list_title clearfix">
        <h2 class="fl">排行榜</h2>
        <p class="fr"><a href="#">MORE>></a></p>
    </div>
    <ul class="ranking_text">
        <li>
            <span class="no1">NO.1</span><span class="king_1"></span><a class="king_text" href="#">水晶契約</a>
        </li>
        <li>
            <span class="no2">NO.2</span><span class="king_2"></span><a class="king_text" href="#">水晶契約</a>
        </li>
        <li>
            <span class="no3">NO.3</span><span class="king_3"></span><a class="king_text" href="#">水晶契約水晶契約水晶契約</a>
        </li>
        <li>
            <span class="no4">NO.4</span><span class="king_4"></span><a class="king_text" href="#">水晶契約</a>
        </li>
        <li>
            <span class="no4">NO.5</span><span class="king_4"></span><a class="king_text" href="#">水晶契約</a>
        </li>
    </ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/ranking.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/ranking.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/calendar.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91d74896_07111252')) {function content_56028f91d74896_07111252($_smarty_tpl) {?><div class="calendar">
    <div class="list_title clearfix">
        <h2 class="fl">活動行事歷</h2>
    </div>
    <div id="calendar"></div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}ob_start();?>
	
	seajs.use(['jquery'],function($){
		$('#calendar').calendarWidget();
	})
	
<?php $script = ob_get_clean();if($script!==false){if(class_exists('FISPagelet', false)){if(FISPagelet::$cp) {if (!in_array(FISPagelet::$cp, FISPagelet::$arrEmbeded)){FISPagelet::addScript($script);FISPagelet::$arrEmbeded[] = FISPagelet::$cp;}} else {FISPagelet::addScript($script);}}}FISPagelet::$cp = null;?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/calendar.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/calendar.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/calendar.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/calendar.js",$_smarty_tpl->smarty);?>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/hot_search.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91d85065_58620486')) {function content_56028f91d85065_58620486($_smarty_tpl) {?><div class="hotsearch">
        <div class="list_title clearfix">
            <h2 class="logo fl">熱門搜索分類</h2>
        </div>
        <div class="search_content">
        	<ul>
        		<li><a href="#2">水晶契約契約（199）</a></li>
        		<li><a href="#2">水晶契約契約（132）</a></li>
        		<li><a href="#2">水晶契約契約（128）</a></li>
        		<li><a href="#2">水晶契約契約（98）</a></li>
        		<li><a href="#2">水晶契約契約（108）</a></li>
        		<li><a href="#2">水晶契約契約（98）</a></li>
        		<li><a href="#2">水晶契約契約（98）</a></li>
        		<li><a href="#2">水晶契約契約（98）</a></li>
        		<li><a href="#2">水晶契約契約（98）</a></li>
        		<li><a href="#2">水晶契約契約（98）</a></li>
        	</ul>
        </div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 19:40:01
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56028f91d8dcc7_44762937')) {function content_56028f91d8dcc7_44762937($_smarty_tpl) {?><div class="footer">
    <h2>魔方數位資訊服務有限公司</h2>
    <p>版權所有(C) 2015 Mofang lnc All Rights Rserved.</p>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty);?><?php }} ?>