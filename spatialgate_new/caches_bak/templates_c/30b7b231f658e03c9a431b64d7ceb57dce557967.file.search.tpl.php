<?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20100866915645ca290eaad3-10513942%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30b7b231f658e03c9a431b64d7ceb57dce557967' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/search.tpl',
      1 => 1456799915,
      2 => 'file',
    ),
    '4fa97041e44bfd0c95ef663bcc24a8a41bfc2942' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/base.tpl',
      1 => 1456799914,
      2 => 'file',
    ),
    'fcb77c1cd84e0ac9ae9e3c03adad8185ca1b16ea' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/common/hw/base.tpl',
      1 => 1456799846,
      2 => 'file',
    ),
    'de5149c2d7ef6dbed6c40e66f412e53a7580598f' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/common/hw/seajs_base.tpl',
      1 => 1456799847,
      2 => 'file',
    ),
    'b788a6eaf25954aaaa3bd520fa38d8d2ff707722' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/common/hw/doctype.tpl',
      1 => 1456799846,
      2 => 'file',
    ),
    '627865c433f3a5ba05a04f95a88983e56925b9f1' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/header.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    '33f112ad5a75d28cb8d50c90f8c6428a574a9ea2' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/search.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    '1daa0b61d66ca1d5c3a6cc5294ddc52be70151bd' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/acg_topic.tpl',
      1 => 1456799947,
      2 => 'file',
    ),
    '3ac6fcc95216573464263e8536bda7628c1e4de3' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/entrance.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    '4e79de3f6f472c93b8c5dd45a1a9534b5d0c4b4c' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/ranking.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    'e0437f21e80e32cf54b51b5abeec5918bce2e2a1' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/miss_information.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    '309078207aaf29116095d82c0223a21a76f1b5b0' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/game_introduce.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    '0128114c0bb259ba1e43e8ccdfafc638d86dbdcd' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/footer.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20100866915645ca290eaad3-10513942',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5645ca29307e67_02067747',
  'variables' => 
  array (
    'title' => 0,
    'wap_url' => 0,
    'cnzz_code' => 0,
    'ios_ad_token' => 0,
    'mfe_go_home' => 0,
    'is_partition' => 0,
    'floating_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5645ca29307e67_02067747')) {function content_5645ca29307e67_02067747($_smarty_tpl) {?>

<!doctype html>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISResource::setFramework(FISResource::load("common:statics/js/loader/sea.js", $_smarty_tpl->smarty));FISPagelet::init('NOSCRIPT'); ?><html>
<head>

    <meta charset="utf-8"/>

    
    <!--[if !IE]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--<![endif]-->
    
    

    
    <meta name="renderer" content="webkit">

    <title><?php if ($_smarty_tpl->tpl_vars['SEO']->value['title']){?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['title'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['site_title'];?>
<?php }?></title>

    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['SEO']->value['keyword'];?>
">

    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['SEO']->value['description'];?>
">

    
    
    <meta name="mobile-agent" content="format=html5; url=<?php echo $_smarty_tpl->tpl_vars['wap_url']->value;?>
">
    <meta name="mobile-agent" content="format=xhtml; url=<?php echo $_smarty_tpl->tpl_vars['wap_url']->value;?>
">
    <link rel="alternate" type="applicationnd.wap.xhtml+xml" media="handheld" href="<?php echo $_smarty_tpl->tpl_vars['wap_url']->value;?>
" />
    


    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/cssreset.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/cssreset.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/cssbase.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/cssbase.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/cssfonts.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/cssfonts.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/common.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/browser_update.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/browser_update.css",$_smarty_tpl->smarty);?>

    
    
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    
    
    <!--[if IE 6]>
        <script src="../statics/js/loader/dd_belatedpng.js"></script>
        <script>
            DD_belatedPNG.fix('.pngfix');
        </script>
    <![endif]-->


    
    <!--[if lt IE 9]>
        <script src="../statics/js/loader/html5shiv.js"></script>
    <![endif]-->

    <script>

    
    var MFE = {};

    
    var CONFIG = {};

    
    CONFIG['cnzz_code'] = '<?php echo $_smarty_tpl->tpl_vars['cnzz_code']->value;?>
';

    </script>

    
    

    

    
    <?php if (@constant('MFE_USE_COMBO')){?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/boot.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/boot.js',$_smarty_tpl->smarty);?>
    <?php }else{ ?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
    <?php }?>

    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('modules:statics/js/sea-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('modules:statics/js/sea-config.js',$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/base-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/base-config.js',$_smarty_tpl->smarty);?>

    <script>
        var lang_conf = "TW";
        
            var defaultURL = "http://u.mofang.com.tw";
        
    </script>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/login.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/login.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/js/hw/base-config.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/js/hw/base-config.js",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/common-ref.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/common-ref.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}ob_start();?>
        seajs.use(["login/check"])
    <?php $script = ob_get_clean();if($script!==false){if(class_exists('FISPagelet', false)){if(FISPagelet::$cp) {if (!in_array(FISPagelet::$cp, FISPagelet::$arrEmbeded)){FISPagelet::addScript($script);FISPagelet::$arrEmbeded[] = FISPagelet::$cp;}} else {FISPagelet::addScript($script);}}}FISPagelet::$cp = null;?>   

<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::cssHook();?><?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::jsLoaderHook();?></head>

<body>

    
	<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/common.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/common.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/common.js",$_smarty_tpl->smarty);?>
    
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T2VNZ3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T2VNZ3');</script>
    <!-- End Google Tag Manager -->
    

    
    
        <?php /*  Call merged included template "tw_acg/widget/header.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022bd9c259_54461374($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/header.tpl" */?> 
    



    
    <div class="acg-content">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'34','order'=>'listorder desc','limit'=>'1',));}$_smarty_tpl->assign('data',$data);?>   
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <a href="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['val']->value['url'])===null||$tmp==='' ? 'javascript:void(0);' : $tmp);?>
" class="screen-gg j_hw_bg" style="display:block;height:100%;background-image: url(<?php echo (($tmp = @$_smarty_tpl->tpl_vars['val']->value['thumb'])===null||$tmp==='' ? 'http://pic1.mofang.com/2015/1117/20151117025247711.jpg' : $tmp);?>
); background-position: 50% 0%; background-repeat: no-repeat;padding-bottom:80px;">
            <span class="bg-close j_close_btn"></span>   
        </a>
        <?php } ?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        <div class="container">
        
	 
    <div class="sort">
    	<div class="sort_left">
    		
    		<?php /*  Call merged included template "tw_acg/widget/search.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022be05d51_45307352($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/search.tpl" */?>
    	</div>
        <div class="sort_right">
            
            <?php /*  Call merged included template "tw_acg/widget/acg_topic.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/acg_topic.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022be6ad17_58536268($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/acg_topic.tpl" */?>
            <div class="row-white"></div>
            
            <?php /*  Call merged included template "tw_acg/widget/entrance.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/entrance.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022be85e23_46475903($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/entrance.tpl" */?>
            
            <?php /*  Call merged included template "tw_acg/widget/ranking.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/ranking.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022bea2583_52268846($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/ranking.tpl" */?>
            
            <?php /*  Call merged included template "tw_acg/widget/miss_information.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/miss_information.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022bee6a63_85913305($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/miss_information.tpl" */?>
            
            <?php /*  Call merged included template "tw_acg/widget/game_introduce.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/game_introduce.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022bf08295_33535797($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/game_introduce.tpl" */?>
        </div>
    </div>

        </div>
    </div>
    
    

    
    
    

    

    
    
        <?php /*  Call merged included template "tw_acg/widget/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '20100866915645ca290eaad3-10513942');
content_56d5022bf3d017_52072805($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/footer.tpl" */?> 
    
    
    
    

    

    
    

    
    


    
    

	<div style="display:none;">

		<!-- Start Alexa Certify Javascript -->
		<script type="text/javascript">
		_atrk_opts = { atrk_acct:"yaoJi1a8Dy00w9", domain:"mofang.com.tw",dynamic: true};
		(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
		</script>
		<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=yaoJi1a8Dy00w9" style="display:none" height="1" width="1" alt="" /></noscript>
		<!-- End Alexa Certify Javascript -->
	</div>



    
    <?php if (!$_smarty_tpl->tpl_vars['mfe_go_home']->value){?>
	<script>
	    setTimeout(function(){
            seajs.use(['jobs']);
	    },100);
	</script>
    <?php }?>

    

    
    <?php if ($_smarty_tpl->tpl_vars['is_partition']->value==1){?>
    <script>
        window.CONFIG = window.CONFIG || {};
        CONFIG.partationPopupUrl = "<?php echo $_smarty_tpl->tpl_vars['floating_url']->value;?>
";
        seajs.use("p/popup");
    </script>
    <?php }?>

    
    <?php if ($_GET['firebug']){?>
        <script type="text/javascript" src="https://getfirebug.com/firebug-lite-debug.js"></script>
    <?php }?>

</body><?php if(class_exists('FISPagelet', false)){echo FISPagelet::jsHook();}?>
<?php $tpl=str_replace("\\", "/", $_smarty_tpl->template_resource);if(!class_exists('FISPagelet')){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::setPageName(str_replace("/data/www/www.spatialgate.com.tw/phpcms/templates/v4/", "", $tpl));$_smarty_tpl->registerFilter('output', array('FISPagelet', 'renderResponse'));?></html>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022bd9c259_54461374')) {function content_56d5022bd9c259_54461374($_smarty_tpl) {?><div class="acg-headerbox">
	<div class="acg-header clearfix">
		<div class="header-wrap w1000 clearfix">
			<a href="<?php echo @constant('APP_PATH');?>
" class="acg-logo"></a>
			<div class="header-left">
				<a href="/"><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/header_left_a9e7d13.png"></a>
			</div>
			<div class="header-right">
				<div class="right-share">
					<h3>分享到:</h3>
					<a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));" class="fb"></a>
					<a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)) .concat(' ') .concat(encodeURIComponent(location.href))));" class="tw"></a>
					<a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));" class="gp"></a>
					<a href="javascript: void(window.open('http://www.plurk.com/?qualifier=shares&status=' .concat(encodeURIComponent(location.href)) .concat(' ') .concat('&#40;') .concat(encodeURIComponent(document.title)) .concat('&#41;')));" class="pu"></a>
				</div>
				<div class="right-login">
					<form action="/index.php" style="font-size:0;overflow:hidden;float:left;">
						<input type="hidden" name="m" value="search">
						<input type="text" class="search-content" name="q" placeholder="搜尋" value="<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
" onkeydown="">
						<input type="submit" class="search-button" id="search" value="">
					</form>
					<div class="hw-login-no" id="header-user-nologin">
		                <a href="#2" id="login" class="login-in">登入</a>
		                <a href="#2" id="reg" class="sign-in">註冊</a>
		            </div>
		            <div class="hw-login-had  disno" id="header-user-info">
						<a href="#2" id="logined" target="_blank"></a>
						<a href="#2" id="logout">退出</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="title-content clearfix">
		<div class="content-wrap clearfix">
			<ul class="clearfix">
				<li><a href="<?php echo cat_url(12);?>
">新聞</a></li>
				<li><a href="<?php echo cat_url(9);?>
">漫畫</a></li>
				<li><a href="<?php echo cat_url(6);?>
">動畫</a></li>
				<li><a href="<?php echo cat_url(21);?>
">小說</a></li>
				<li><a href="<?php echo cat_url(23);?>
">遊戲</a></li>
				<li><a href="<?php echo cat_url(20);?>
">活動</a></li>
				<li><a href="<?php echo cat_url(16);?>
">專欄</a></li>
				<li style="display:none;"><a href="<?php echo cat_url(11);?>
">排行</a></li>
				<li><a href="<?php echo cat_url(22);?>
">週邊</a></li>
				<li><a href="<?php echo cat_url(14);?>
">COSPLAY</a></li>
				<li><a href="<?php echo cat_url(15);?>
">萌圖</a></li>
				<li><a href="<?php echo cat_url(43);?>
">漫畫線上看</a></li>
			</ul>
		</div>
	</div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/common.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/acg_login.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/acg_login.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/login_tip.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/login_tip.js",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/search.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022be05d51_45307352')) {function content_56d5022be05d51_45307352($_smarty_tpl) {?><div class="top_img">
<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'28','order'=>'listorder desc','limit'=>'1',));}$_smarty_tpl->assign('data',$data);?>	
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
"></a>
	<?php } ?>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
</div>
<div class="listBox">
	<div class="title">
		<h2><?php if ($_smarty_tpl->tpl_vars['total']->value){?>“<?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
”相關資訊<?php }else{ ?>找不到相關文章<?php }?></h2>
	</div>
	<div class="news_list">
		<ul class="news_list_ul clearfix">
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['result']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			<li>
				<a class="fl" href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],320,180);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
"></a>
				<div class="fr">
					<h4><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></h4>
					<p><?php echo $_smarty_tpl->tpl_vars['val']->value['description'];?>
</p>
					<div class="news_info">
						<span class="icon_horologe"><?php echo date("Y年m月d日 H:i",$_smarty_tpl->tpl_vars['val']->value['updatetime']);?>
</span>
						<span class="icon_view">瀏覽次數:<?php echo get_views("c-".((string)$_smarty_tpl->tpl_vars['val']->value['modelid'])."-".((string)$_smarty_tpl->tpl_vars['val']->value['id']));?>
</span>
						<a class="fr" href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
">詳全文</a>
					</div>
					<div class="news_keywords">
						<?php $_smarty_tpl->tpl_vars['keywords'] = new Smarty_variable(explode(',',$_smarty_tpl->tpl_vars['val']->value['keywords']), null, 0);?>
						關鍵字：
						<?php  $_smarty_tpl->tpl_vars['keyword'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['keyword']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['keywords']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['keyword']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['keyword']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['keyword']->key => $_smarty_tpl->tpl_vars['keyword']->value){
$_smarty_tpl->tpl_vars['keyword']->_loop = true;
 $_smarty_tpl->tpl_vars['keyword']->iteration++;
 $_smarty_tpl->tpl_vars['keyword']->last = $_smarty_tpl->tpl_vars['keyword']->iteration === $_smarty_tpl->tpl_vars['keyword']->total;
?>
							<?php if ($_smarty_tpl->tpl_vars['keyword']->value){?>
								<a href="<?php echo tag($_smarty_tpl->tpl_vars['keyword']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['keyword']->value;?>
</a>
								<?php if (!$_smarty_tpl->tpl_vars['keyword']->last){?>/<?php }?>
							<?php }?>
						<?php } ?>
					</div>
				</div>
			</li>
			<?php } ?>
		<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</ul>
		<div class="pageBox">
			<div class="pagin">
				<?php echo pages($_smarty_tpl->tpl_vars['total']->value,$_smarty_tpl->tpl_vars['page']->value,10);?>

			</div>
		</div>
	</div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/list.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/list.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/acg_topic.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022be6ad17_58536268')) {function content_56d5022be6ad17_58536268($_smarty_tpl) {?><div class="carouse-con-right fr">
	<div class="title">
		<h2>超次元話題</h2>
		<span>大家都在看什麽？</span>
	</div>
	<ul class="article_list">
	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>'19','order'=>'listorder DESC','thumb'=>'1','limit'=>'6',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['val']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['val']->iteration++;
?>
		<li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->iteration;?>
.<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
		<?php } ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	</ul>
	<a class="see_more" href="http://newbbs.mofang.com.tw/forum/6348.html"><span>前往次元討論區</span></a>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/carouse.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/carouse.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/entrance.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022be85e23_46475903')) {function content_56d5022be85e23_46475903($_smarty_tpl) {?>
<div class="hot-font clearfix">
	<h2>熱門關鍵字</h2>
	<div class="font_list clearfix">
	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('module'=>'content',)).'d41d8cd98f00b204e9800998ecf8427e');if(isset($_GET["refreshcached"]) || !$data = getcache($tag_cache_name,'','memcache','html')){$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'types')) {$data = $content_tag->types(array('module'=>'content','limit'=>'20',));}if(!empty($data)){setcache($tag_cache_name, $data, '', 'memcache', 'html', $cache);}}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<a class="f<?php echo $_smarty_tpl->tpl_vars['val']->value['total']%10+10;?>
" href="<?php echo tag($_smarty_tpl->tpl_vars['val']->value['name']);?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</a>
		<?php } ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	</div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/entrance.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/entrance.css",$_smarty_tpl->smarty);?> <?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/ranking.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022bea2583_52268846')) {function content_56d5022bea2583_52268846($_smarty_tpl) {?><div class="hot-ranking clearfix">
	<div class="title">
		<h2 class="fl">人氣排行</h2>
		<div class="tab fr">
			<a class="curr" href="javascript:void(0);">動畫<i></i></a>
			<a href="javascript:void(0);">小說<i></i></a>
			<a href="javascript:void(0);">漫畫<i></i></a>
		</div>
	</div>
	<div class="tab_con">
		<ul class="article_list">
		<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('catid'=>'6','order'=>'views DESC',)).'d41d8cd98f00b204e9800998ecf8427e');if(isset($_GET["refreshcached"]) || !$data = getcache($tag_cache_name,'','memcache','html')){$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'hits')) {$data = $content_tag->hits(array('catid'=>'6','order'=>'views DESC','limit'=>'5',));}if(!empty($data)){setcache($tag_cache_name, $data, '', 'memcache', 'html', $cache);}}$_smarty_tpl->assign('data',$data);?>
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['val']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['val']->iteration++;
?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->iteration;?>
.<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
			<?php } ?>
		<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</ul>
		<ul class="article_list disno">
		<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('catid'=>'21','order'=>'views DESC',)).'d41d8cd98f00b204e9800998ecf8427e');if(isset($_GET["refreshcached"]) || !$data = getcache($tag_cache_name,'','memcache','html')){$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'hits')) {$data = $content_tag->hits(array('catid'=>'21','order'=>'views DESC','limit'=>'5',));}if(!empty($data)){setcache($tag_cache_name, $data, '', 'memcache', 'html', $cache);}}$_smarty_tpl->assign('data',$data);?>
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['val']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['val']->iteration++;
?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->iteration;?>
.<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
			<?php } ?>
		<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</ul>
		<ul class="article_list disno">
		<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$tag_cache_name = md5(implode('&',array('catid'=>'9','order'=>'views DESC',)).'d41d8cd98f00b204e9800998ecf8427e');if(isset($_GET["refreshcached"]) || !$data = getcache($tag_cache_name,'','memcache','html')){$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'hits')) {$data = $content_tag->hits(array('catid'=>'9','order'=>'views DESC','limit'=>'5',));}if(!empty($data)){setcache($tag_cache_name, $data, '', 'memcache', 'html', $cache);}}$_smarty_tpl->assign('data',$data);?>
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['val']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['val']->iteration++;
?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->iteration;?>
.<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
			<?php } ?>
		<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
		</ul>

	</div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/entrance.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/entrance.css",$_smarty_tpl->smarty);?>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/miss_information.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022bee6a63_85913305')) {function content_56d5022bee6a63_85913305($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['posid']->value){?>
<div class="miss_info">	
	<div class="title">
		<h2>也別錯過這裏的情報哦！</h2>
	</div>
	<ul>
	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'position')) {$data = $content_tag->position(array('posid'=>$_smarty_tpl->tpl_vars[posid]->value,'order'=>'listorder DESC','thumb'=>'1','limit'=>'5',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
">
				<img src="<?php echo qiniuthumb($_smarty_tpl->tpl_vars['val']->value['thumb'],320,180);?>
">
				<span><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</span>
			</a>
		</li>
		<?php } ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	</ul>
</div>
<?php }?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/detail.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/detail.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/game_introduce.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022bf08295_33535797')) {function content_56d5022bf08295_33535797($_smarty_tpl) {?><div class="game-intro">
	<ul>
	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'26','order'=>'listorder DESC','thumb'=>'1','limit'=>'1',));}$_smarty_tpl->assign('data',$data);?>
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"  class="special_img">
				<img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['thumb'];?>
">
			</a>
		<li>
		<?php } ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	
	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'27','order'=>'listorder DESC','thumb'=>'1','limit'=>'3',));}$_smarty_tpl->assign('data',$data);?>
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
">
				<img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['thumb'];?>
">
			</a>
		<li>
		<?php } ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	</ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/information.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/information.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:44:59
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5022bf3d017_52072805')) {function content_56d5022bf3d017_52072805($_smarty_tpl) {?><div class="footerBox">
	<div class="footer">
        <?php if ($_smarty_tpl->tpl_vars['isHome']->value){?>
        <div class="footer-con clearfix">
            <span>友情連結:</span>
            <ul>
            <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"link\" data=\"op=link&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$link_tag = pc_base::load_app_class("link_tag", "link");if (method_exists($link_tag, 'type_list')) {$data = $link_tag->type_list(array('typeid'=>'73','order'=>'listorder DESC','limit'=>'20',));}$_smarty_tpl->assign('data',$data);?>
                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</a></li>
                <?php } ?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </ul>
        </div>
        <?php }?>
        <div class="footer-connect clearfix">
            <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/footer_img_82d6333.png">
            <ul>
                <li><a href="mailto:acgmofang@mofang.com.tw">情報投稿</a></li>
                <li><a href="mailto:lenawu@mofang.com.tw"> 商務洽談</a></li>
                <li><a href="http://newbbs.mofang.com.tw/forum/6348.html">次元討論</a></li>
                <li><a href="http://www.mofang.com.tw/">魔方網</a></li>
                <li style="margin-right:-42px;"><a href="mailto:acgmofang@mofang.com.tw">聯絡我們</a></li>
                <li style="margin-left:63px;"><a href="https://www.facebook.com/mofangTW/?fref=ts">魔方粉絲團</a></li>
                <li><a href="http://www.mofang.com.tw/appdownload/277-123-1.html">GAME+</a></li>
                <li><a href="<?php echo @constant('APP_PATH');?>
?wap=1">ACG移動端</a></li>
            </ul>
        </div>
        <p>魔方數位資訊服務有限公司 版權所有 © 2015 Mofang Inc All Rights Reserved.</p>
        <p class="pd-bt">如有違反您的權益，或您發現有任何不當內容或圖片錯誤，請與我們聯繫。我們會第一時間修正更改。</p>
	</div>
</div><?php }} ?>