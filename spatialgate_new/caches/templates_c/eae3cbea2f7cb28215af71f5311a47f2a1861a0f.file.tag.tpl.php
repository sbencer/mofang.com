<?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:51:25
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/wap/tag.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25793534057d15bf38b8234-48070658%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eae3cbea2f7cb28215af71f5311a47f2a1861a0f' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/wap/tag.tpl',
      1 => 1474361882,
      2 => 'file',
    ),
    'fbf03a8d711dedd38f95790da9c831ef46387af8' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/wap/base.tpl',
      1 => 1474361882,
      2 => 'file',
    ),
    '6280707fa4db8df4ab1bcf72f73b2e218f0aa59a' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/common/hw/m_base.tpl',
      1 => 1474361680,
      2 => 'file',
    ),
    '7a2c5599ca0fbe4da6f31126c6acd20b108b3306' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/common/hw/m_doctype.tpl',
      1 => 1474361680,
      2 => 'file',
    ),
    'd838ced5c8e20b42781f8dc2bd766ebfee99e1e5' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/header.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
    '63b456e360e4e2017ddec8b00f3c8662f8cc246d' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/news_tag.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
    '0b486e9d81fe62389d3d27d1c849f906016d7ba0' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
    'a917cd6bb3c2028c97a5a96e2b786317dd461e1d' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/classify.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
    '48f5b6ae893cf1d00c4e08153a935d0367e66558' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/right_search.tpl',
      1 => 1474361938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25793534057d15bf38b8234-48070658',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_57d15bf39fc627_13467977',
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
<?php if ($_valid && !is_callable('content_57d15bf39fc627_13467977')) {function content_57d15bf39fc627_13467977($_smarty_tpl) {?>

<!doctype html>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISResource::setFramework(FISResource::load("common:statics/js/loader/sea.js", $_smarty_tpl->smarty));FISPagelet::init('NOSCRIPT'); ?><html>
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

    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/m_normalize.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/m_normalize.css",$_smarty_tpl->smarty);?>
	<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/hw/wapv6/base.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/hw/wapv6/base.css",$_smarty_tpl->smarty);?>
    
    <link rel="shortcut icon" href="http://pic1.mofang.com/2015/0728/20150728113409872.ico" type="image/x-icon" />
    
    <?php echo $_smarty_tpl->getSubTemplate ('common/hw/jiajia_api.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


    
        <?php if ($_smarty_tpl->tpl_vars['MFE_USE_COMBO']->value){?>
            <?php if ($_smarty_tpl->tpl_vars['MFE_DEBUG']->value){?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea/combo.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea/combo.js',$_smarty_tpl->smarty);?>
            <?php }else{ ?>
                <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/boot.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/boot.js',$_smarty_tpl->smarty);?>
            <?php }?>
        <?php }else{ ?>
            <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
        <?php }?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('modules:statics/js/sea-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('modules:statics/js/sea-config.js',$_smarty_tpl->smarty);?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/hw/wapv6/wap-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/hw/wapv6/wap-config.js',$_smarty_tpl->smarty);?>
    
	
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



    <script>
        var SURL = "<?php echo @constant('APP_PATH');?>
index.php?m=content&c=tag&ajax=1&tag=<?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
";
        var tplEle = "news_tag";
        var catid = '<?php echo $_GET['catid'];?>
'; 
        var page = 1;
    </script>


<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::cssHook();?><?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::jsLoaderHook();?></head>

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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '25793534057d15bf38b8234-48070658');
content_57e1069ddf56d2_46589096($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/header.tpl" */?>
    
    <div class="m-content">
        
        <?php /*  Call merged included template "tw_acg/widget/wap/news_tag.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/news_tag.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '25793534057d15bf38b8234-48070658');
content_57e1069de20296_20376657($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/news_tag.tpl" */?>
	 </div>

    


    
    <span class="go-up"></span>
    </div>
    
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/classify.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/classify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '25793534057d15bf38b8234-48070658');
content_57e1069de46fd1_57661239($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/classify.tpl" */?>
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/right_search.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/right_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '25793534057d15bf38b8234-48070658');
content_57e1069de720b2_80190843($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/right_search.tpl" */?>
    
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/common.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/common.js",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/go_top.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/go_top.js",$_smarty_tpl->smarty);?>
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
<?php $tpl=str_replace("\\", "/", $_smarty_tpl->template_resource);if(!class_exists('FISPagelet')){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::setPageName(str_replace("/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/", "", $tpl));$_smarty_tpl->registerFilter('output', array('FISPagelet', 'renderResponse'));?></html>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:51:25
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e1069ddf56d2_46589096')) {function content_57e1069ddf56d2_46589096($_smarty_tpl) {?><div class="zq_header">
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:51:25
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/news_tag.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e1069de20296_20376657')) {function content_57e1069de20296_20376657($_smarty_tpl) {?><div class="sorts clearfix">
    <div class="list_title clearfix">
        <h2 class="fl"><?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
相關分類資訊</h2>
    </div>
    <ul class="sort_list append clearfix">
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" class="fl">
                <img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],320,180);?>
" class="fl">
                <p><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</p>
            </a>
        </li>
        <?php } ?>
    </ul>
    <a class="load_more" href="javascript:;"><span>還要查看更多</span></a>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/sort_list.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/sort_list.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/load_more.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/load_more.js",$_smarty_tpl->smarty);?>

<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:51:25
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e1069de3c7c5_86062873')) {function content_57e1069de3c7c5_86062873($_smarty_tpl) {?><div class="footer">
    <h2>魔方數位資訊服務有限公司</h2>
    <p>版權所有(C) 2015 Mofang lnc All Rights Rserved.</p>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:51:25
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/classify.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e1069de46fd1_57661239')) {function content_57e1069de46fd1_57661239($_smarty_tpl) {?><div class="classify">
	<div class="classify_top">
    	<div class="land">
        	<a class="clearfix" href="#">
            	<img class="fl" src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/land_img_03_71c624c.png" />
            	<p class="fl">請登錄</p>
            </a>
        </div>
        <div class="land_after clearfix">
        	<a class="clearfix" href="#">
            	<img class="fl" src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/land_after_03_74e266e.png" />
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/classify.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/classify.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:51:25
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/wap/right_search.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e1069de720b2_80190843')) {function content_57e1069de720b2_80190843($_smarty_tpl) {?><div class="right_search">
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/right_search.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/right_search.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty);?>
<?php }} ?>