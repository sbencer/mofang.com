<?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:36
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/wap/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24666436457cd0464ee0332-65235527%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '76d53c99c4c6dc2c3b1137290e95caf6b858ac44' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/wap/index.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '14d0d9dda333abd274e7b6d2a12080ecc8c69269' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/wap/base.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '2d01055284e69b17bad0bd9a24cc6bbcf6867c60' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/common/hw/m_base.tpl',
      1 => 1473041737,
      2 => 'file',
    ),
    '5b9c38c9f16708c4cb0e44e133c8921e75221be6' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/common/hw/m_doctype.tpl',
      1 => 1473041737,
      2 => 'file',
    ),
    '4328b3bb892677904869ead1c6b0b34973008a01' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/header.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '5eed2c8edfc307b0b018692aa336cf13ed54a510' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/swipe_slider.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '3a50826a01bb83b9074545bc21e498e5350cc232' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/picture.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '4c6562bc3fcc1eeb45ca4d63c6e531e5dcbfd7d7' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/news.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    'a5fa5e321c6182cd05dc5651f8d6fe95db62ac52' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/calendar.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '30cd3f5c6df232ff3d917e0daa4b48263bfac75b' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/hot_search.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '8abcb9567399cbb245edaf8b31db49ff68593ceb' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '1123ddefbe9bf50199ce0f3b633795be15153790' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/classify.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    'd18f86d024c2cec1a04cb70dd3e69dc42536f727' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/right_search.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24666436457cd0464ee0332-65235527',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'MFE_USE_COMBO' => 0,
    'MFE_DEBUG' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_57cd0465186f42_91247011',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57cd0465186f42_91247011')) {function content_57cd0465186f42_91247011($_smarty_tpl) {?>

<!doctype html>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISResource::setFramework(FISResource::load("common:statics/js/loader/sea.js", $_smarty_tpl->smarty));FISPagelet::init('NOSCRIPT'); ?><html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    
    <meta name="format-detection" content="telephone=no" />

    <title><?php if ($_smarty_tpl->tpl_vars['SEO']->value['title']){?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['title'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['site_title'];?>
<?php }?></title>

    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['SEO']->value['keyword'];?>
">

    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['SEO']->value['description'];?>
">

    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/m_normalize.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/m_normalize.css",$_smarty_tpl->smarty);?>
	<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/hw/wapv6/base.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/hw/wapv6/base.css",$_smarty_tpl->smarty);?>
    
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />
    
    <?php echo $_smarty_tpl->getSubTemplate ('common/hw/jiajia_api.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


    
        <?php if ($_smarty_tpl->tpl_vars['MFE_USE_COMBO']->value){?>
            <?php if ($_smarty_tpl->tpl_vars['MFE_DEBUG']->value){?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea/combo.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea/combo.js',$_smarty_tpl->smarty);?>
            <?php }else{ ?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/boot.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/boot.js',$_smarty_tpl->smarty);?>
            <?php }?>
        <?php }else{ ?>
            <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
        <?php }?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('modules:statics/js/sea-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('modules:statics/js/sea-config.js',$_smarty_tpl->smarty);?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/hw/wapv6/wap-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/hw/wapv6/wap-config.js',$_smarty_tpl->smarty);?>
    
	
        <script>
            adaptation(750);
            //适配
            function adaptation(size){
                if(document.documentElement.clientWidth>size){
                    document.documentElement.style.fontSize=size/26.66666666+'px';
                }else{
                    document.documentElement.style.fontSize=document.documentElement.clientWidth/26.66666666+'px';
                }
            }
        </script>
    
    
    

	

    
    <script>

    
    var MFE = {};

    
    var CONFIG = {};

    </script>




<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::cssHook();?><?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::jsLoaderHook();?></head>

<body>

    
    
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T2VNZ3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T2VNZ3');</script>
    <!-- End Google Tag Manager -->
    
	<div class="wrapper">
	
	<?php /*  Call merged included template "tw_acg/widget/wap/header.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd046502e666_71014285($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/header.tpl" */?>
    
    <div class="m-content">
        
        <?php /*  Call merged included template "tw_acg/widget/wap/swipe_slider.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/swipe_slider.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd0465059673_47404690($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/swipe_slider.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/picture.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/picture.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd0465083460_40185017($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/picture.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/news.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/news.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd04650a0f96_66856898($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/news.tpl" */?>
        
        
        
        <?php /*  Call merged included template "tw_acg/widget/wap/calendar.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/calendar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd04650ce5c3_05918663($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/calendar.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/hot_search.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/hot_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd0465103a16_89236974($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/hot_search.tpl" */?>
        
        
    </div>

    
        
        <?php /*  Call merged included template "tw_acg/widget/wap/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd0465121c62_42534162($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/footer.tpl" */?>
    
    
    <span class="go-up"></span>
    </div>
    
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/classify.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/classify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd046512b620_07015011($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/classify.tpl" */?>
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/right_search.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/right_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '24666436457cd0464ee0332-65235527');
content_57cd0465155853_36971177($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/right_search.tpl" */?>
    
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/common.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/common.js",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/go_top.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/go_top.js",$_smarty_tpl->smarty);?>
    <script>
		var SearchURL = "<?php echo @constant('APP_PATH');?>
index.php?m=search&c=index&a=init&siteid=1&ajax=1&q=";
    </script>
    
    <div style="display:none;">
        
            <!-- Start Alexa Certify Javascript -->
            <script type="text/javascript">
            _atrk_opts = { atrk_acct:"yaoJi1a8Dy00w9", domain:"spatialgate.com.tw",dynamic: true};
            (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
            </script>
            <noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=yaoJi1a8Dy00w9" style="display:none" height="1" width="1" alt="" /></noscript>
            <!-- End Alexa Certify Javascript -->  
        
    </div>
    


</body><?php if(class_exists('FISPagelet', false)){echo FISPagelet::jsHook();}?>
<?php $tpl=str_replace("\\", "/", $_smarty_tpl->template_resource);if(!class_exists('FISPagelet')){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::setPageName(str_replace("/data/www/mofang.com/spatialgate/phpcms/templates/v4/", "", $tpl));$_smarty_tpl->registerFilter('output', array('FISPagelet', 'renderResponse'));?></html>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd046502e666_71014285')) {function content_57cd046502e666_71014285($_smarty_tpl) {?><div class="zq_header">
    <a class="icon-menu" href="javascript:;"><i></i></a>
    <h1 class="topic"><a href="<?php echo @constant('APP_PATH');?>
">次元角落ACG資訊站</a></h1>
    <span class="icon-search"><i></i></span>
</div>
<!--logo导航 start-->
<div class="logo_nav">
    <a class="icon_logo" href="<?php echo siteurl($_smarty_tpl->tpl_vars['siteid']->value);?>
">logo</a>
    <ul class="nav_template">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'category')) {$data = $content_tag->category(array('module'=>'content','catid'=>'0','siteid'=>'((string)$_smarty_tpl->tpl_vars[siteid]->value)','order'=>'listorder ASC','limit'=>'25',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li <?php if ($_smarty_tpl->tpl_vars['catid']->value==$_smarty_tpl->tpl_vars['val']->value['catid']){?>class="curr"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['catname'];?>
</a></li>
        <?php } ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<!--logo导航 end-->
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/swipe_slider.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd0465059673_47404690')) {function content_57cd0465059673_47404690($_smarty_tpl) {?><div id="slideBox" class="swipe">
    <div class="swipe-wrap">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('module'=>'content','posid'=>'18','order'=>'listorder DESC','thumb'=>'1','limit'=>'5',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <div class="slide-item">
            <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" ><img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],800,450);?>
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/swipe_slider.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/swipe_slider.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/swipe_slider.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/swipe_slider.js",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/picture.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd0465083460_40185017')) {function content_57cd0465083460_40185017($_smarty_tpl) {?><div class="picture">
    <ul class="clearfix">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'19','order'=>'listorder DESC','thumb'=>'1','limit'=>'6',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],320,180);?>
"></a>
            <span><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/new_671bfd8.png"></span>
            <div class="shadow"></div>
            <p><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</p>
        </li>
        <?php } ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/picture.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/picture.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/news.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd04650a0f96_66856898')) {function content_57cd04650a0f96_66856898($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/data/www/mofang.com/spatialgate/phpcms/init/smarty/plugins/modifier.truncate.php';
?><div class="news clearfix">
    <div class="list_title clearfix">
        <h2 class="fl">ACG資訊看這邊</h2>
        <p class="fr"><a href="<?php echo cat_url(12);?>
">MORE>></a></p>
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
                <div class="fl"><img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],320,180);?>
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/calendar.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd04650ce5c3_05918663')) {function content_57cd04650ce5c3_05918663($_smarty_tpl) {?><div class="calendar">
    <div class="list_title clearfix">
        <h2 class="fl">活動行事歷</h2>
    </div>
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'event')) {$event = $content_tag->event(array('catid'=>'37','limit'=>'30',));}$_smarty_tpl->assign('event',$event);?>
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'calendar')) {$calstr = $content_tag->calendar(array('event'=>$_smarty_tpl->tpl_vars[event]->value,'limit'=>'20',));}$_smarty_tpl->assign('calstr',$calstr);?>
    <div id="calendar">
        <?php echo $_smarty_tpl->tpl_vars['calstr']->value;?>

    </div>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['event']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
	<div class="activity_alert" id="event-<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
	    <h2 class="activity_title">
	        <span><?php echo $_smarty_tpl->tpl_vars['val']->value['activedate'];?>
</span>
	        <span><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</span>
	        <span><?php echo $_smarty_tpl->tpl_vars['val']->value['keywords'];?>
</span>
	    </h2>
	    <ul class="activity_content">
	        <li>
	            <span>活動時間:</span>
	            <?php echo $_smarty_tpl->tpl_vars['val']->value['activetime'];?>

	        </li>
	        <li>
	            <span>活動地址:</span>
	            <?php echo $_smarty_tpl->tpl_vars['val']->value['activeaddr'];?>

	        </li>
	        <li>
	            <span>網&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;站:</span>
	            <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['website'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['website'];?>
</a>
	        </li>
	        <li>
	            <span>客服聯絡:</span>
	            <?php echo $_smarty_tpl->tpl_vars['val']->value['teline'];?>

	        </li>
	    </ul>
	    <a class="close_btn" href="javascript:;"></a>
	</div>
	<?php } ?>
	<div class="mask"></div>
</div>


<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/activity_alert.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/activity_alert.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/calendar.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/calendar.css",$_smarty_tpl->smarty);?>

<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/hot_search.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd0465103a16_89236974')) {function content_57cd0465103a16_89236974($_smarty_tpl) {?><div class="hotsearch">
        <div class="list_title clearfix">
            <h2 class="logo fl">熱門搜索分類</h2>
        </div>
        <div class="search_content">
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'types')) {$data = $content_tag->types(array('module'=>'content','limit'=>'20',));}$_smarty_tpl->assign('data',$data);?>
        	<ul>
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        		<li><a href="<?php echo @constant('APP_PATH');?>
index.php?m=content&c=tag&tag=<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
（<?php echo $_smarty_tpl->tpl_vars['val']->value['total'];?>
）</a></li>
            <?php } ?>
        	</ul>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd0465121c62_42534162')) {function content_57cd0465121c62_42534162($_smarty_tpl) {?><div class="footer">
    <h2>魔方數位資訊服務有限公司</h2>
    <p>版權所有(C) 2015 Mofang lnc All Rights Rserved.</p>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/classify.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd046512b620_07015011')) {function content_57cd046512b620_07015011($_smarty_tpl) {?><div class="classify">
	<div class="classify_top">
    	<div class="land">
        	<a class="clearfix" href="#">
            	<img class="fl" src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/land_img_03_b22bf21.png" />
            	<p class="fl">請登錄</p>
            </a>
        </div>
        <div class="land_after clearfix">
        	<a class="clearfix" href="#">
            	<img class="fl" src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/land_after_03_862f6a7.png" />
            	<div class="land_big fl">
                	<h2>LENA</h2>
                    <span class="land_z">178</span><span class="land_x">357</span>
                </div>
            </a>
        </div>
    </div>
    <ul class="classify_text">
    	<li>
        	<a href="<?php echo @constant('APP_PATH');?>
"><i class="c1"></i>次元角落首页</a>
        </li>
        <li>
        	<a href="http://bbs.mofang.com.tw/forum-432-1.html"><i class="c2"></i>討論區</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(12);?>
"><i class="c3"></i>NEWS</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(6);?>
"><i class="c4"></i>動畫</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(9);?>
"><i class="c5"></i>漫畫</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(21);?>
"><i class="c6"></i>小說</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(23);?>
"><i class="c7"></i>遊戲</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(20);?>
"><i class="c8"></i>活動</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(16);?>
"><i class="c9"></i>專欄</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(11);?>
"><i class="c10"></i>排行</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(22);?>
"><i class="c11"></i>精選週邊</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(14);?>
"><i class="c12"></i>Cosplay</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(15);?>
"><i class="c13"></i>萌萌der</a>
        </li>
        <li>
        	<a href="<?php echo cat_url(17);?>
"><i class="c14"></i>痛車</a>
        </li>
        <li style="display:none;">
        	<a href="<?php echo cat_url(18);?>
"><i class="c15"></i>Doll</a>
        </li>
        <li style="display:none;">
        	<a href="<?php echo cat_url(19);?>
"><i class="c16"></i>軍武</a>
        </li>
        <li>
        	<a href="<?php echo @constant('APP_PATH');?>
?pc=1"><i class="c17"></i>PC頁面</a>
        </li>
        <li>
        	<a href="javascript:;"><i class="c18"></i>退出登錄</a>
        </li>
    </ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/classify.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/classify.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 13:36:37
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/right_search.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57cd0465155853_36971177')) {function content_57cd0465155853_36971177($_smarty_tpl) {?><div class="right_search">
    <div class="twm-search">
        <div class="right-search">
            <div class="search-wrap">
                <form action="http://www.spatialgate.com.tw/index.php">
                    <input type="hidden" name="m" value="search">
                    <input type="text" id="search-input" name="q" placeholder="自由搜尋" onkeydown>
                    <!--<input type="submit" class="search-btn" id="search" value="">-->
                </form>
            </div>		
        </div>		
        <div class="search-content">
            <span class="empty">沒有相關文章</span>
            <ul class="search_con clearfix">
            </ul>
        </div>
    </div>
    <div class="new-app">
            <div class="list_titles clearfix">
                <h2>最新遊戲APP推薦</h2>
            </div>
            <div class="search-content">
            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('module'=>'content','catid'=>'10','order'=>'listorder desc, id desc','field'=>'id,title,thumb,url','thumb'=>'1','limit'=>'5',));}$_smarty_tpl->assign('data',$data);?>
                <ul class="clearfix">
                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                    <li>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" class="fl">
                            <img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],100);?>
" class="fp fl">
                            <em class="fp"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</em>
                            <span class="fr arrow">&gt;</span>
                        </a>
                    </li>
                <?php } ?>
                </ul>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>
    </div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/right_search.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/right_search.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty);?>
<?php }} ?>