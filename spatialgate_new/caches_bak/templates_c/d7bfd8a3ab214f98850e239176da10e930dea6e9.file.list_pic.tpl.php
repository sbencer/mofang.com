<?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:58:23
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/list_pic.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6440073835667f3ce1f6d58-74104189%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd7bfd8a3ab214f98850e239176da10e930dea6e9' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/list_pic.tpl',
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
    '12d4855a4768d07b6ff352c357cbbf8607be2c3d' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/top_zixun.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    '63354a63d79e39c508550a6d96505d52959fce3b' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/infinite_list.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
    '4eac8113a7e5038807506c062729733a46a57408' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/side_fix.tpl',
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
  'nocache_hash' => '6440073835667f3ce1f6d58-74104189',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5667f3ce3938a3_50430105',
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
<?php if ($_valid && !is_callable('content_5667f3ce3938a3_50430105')) {function content_5667f3ce3938a3_50430105($_smarty_tpl) {?>

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

    <script>
        var SURL = "<?php echo @constant('APP_PATH');?>
index.php?m=content&c=index&a=ajax_lists&date_format=1&exp=views";
        var tplEle = "news_list";
        var catid = '<?php echo $_GET['catid'];?>
'; 
        var page = 1;
    </script>

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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '6440073835667f3ce1f6d58-74104189');
content_56d5054f20a033_47247875($_smarty_tpl);
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
        
    
    <?php /*  Call merged included template "tw_acg/widget/top_zixun.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/top_zixun.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '6440073835667f3ce1f6d58-74104189');
content_56d5054f24d581_90103036($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/top_zixun.tpl" */?>     

    
         
        <?php /*  Call merged included template "tw_acg/widget/infinite_list.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/infinite_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '6440073835667f3ce1f6d58-74104189');
content_56d5054f2692c9_25010256($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/infinite_list.tpl" */?>  
    
    <?php /*  Call merged included template "tw_acg/widget/side_fix.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/side_fix.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '6440073835667f3ce1f6d58-74104189');
content_56d5054f2988e9_86403117($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/side_fix.tpl" */?>  

        </div>
    </div>
    
    

    
    
    

    

    
    
        <?php /*  Call merged included template "tw_acg/widget/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '6440073835667f3ce1f6d58-74104189');
content_56d5054f2b2bc9_82573719($_smarty_tpl);
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
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:58:23
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5054f20a033_47247875')) {function content_56d5054f20a033_47247875($_smarty_tpl) {?><div class="acg-headerbox">
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/login_tip.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/login_tip.js",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:58:23
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/top_zixun.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5054f24d581_90103036')) {function content_56d5054f24d581_90103036($_smarty_tpl) {?><div class="top_zixun">
	<a class="fl" href="<?php echo cat_url(12);?>
"><img src='http://sts0.mofang.com.tw/statics/v4/tw_acg/img/top_zixun_img_7e87b21.jpg' alt="新聞速報"></a>
	<ul class="top_zx_list">
	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('modelid'=>'1','order'=>'listorder DESC','thumb'=>'1','limit'=>'10',));}$_smarty_tpl->assign('data',$data);?>
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
		<?php } ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	</ul>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/top_zixun.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/top_zixun.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:58:23
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/infinite_list.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5054f2692c9_25010256')) {function content_56d5054f2692c9_25010256($_smarty_tpl) {?><div class="container">
	<div id="infiniteBox" class="infiniteBox">
	<?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>$_smarty_tpl->tpl_vars[catid]->value,'order'=>'id desc','limit'=>'10',));}$_smarty_tpl->assign('data',$data);?>
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
	    <div class="grid">
	      	<div class="imgholder">
	      		<a class="fancybox" href="<?php echo $_smarty_tpl->tpl_vars['val']->value['thumb'];?>
">
	      			<img class="lazy" src="<?php echo $_smarty_tpl->tpl_vars['val']->value['thumb'];?>
" data-original="<?php echo $_smarty_tpl->tpl_vars['val']->value['thumb'];?>
"  />
	      		</a>
	    	</div>
	      	<p><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></p>
	      	<p class="icon_horologe">
	      		<?php echo date("Y年m月d日 H:i:s",$_smarty_tpl->tpl_vars['val']->value['inputtime']);?>

	      	</p>
	      	<p class="icon_view">
	      		<?php echo get_views("c-3-".((string)$_smarty_tpl->tpl_vars['val']->value['id']));?>

	      	</p>
	    </div>
	    <?php } ?>
	<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
	</div>
	<!--loading start-->
	<img class="load-img" src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/loding_183e9ee.gif">
	<!--loading end-->
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/infinite_list.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/infinite_list.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/jquery.fancybox.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/jquery.fancybox.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/infinite_list.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/infinite_list.js",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:58:23
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/side_fix.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5054f2988e9_86403117')) {function content_56d5054f2988e9_86403117($_smarty_tpl) {?><div class="side_fix">
	
    <?php if ($_smarty_tpl->tpl_vars['catid']->value==38){?>
	<a href="https://docs.google.com/forms/d/167e0Wk40dFRdhfpdulUJqZ_J96FE0MCma7m92b_L0Nk/viewform" target="_blank">
        <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/ad1_890f2cb.png">
    </a>
    <?php }?>
	
    <?php if ($_smarty_tpl->tpl_vars['catid']->value==14){?>
	<a href="https://docs.google.com/forms/d/1dBM44OnDf7nGMdropvyQ_b7SFk-9g922fvkNcRbiGUk/viewform" target="_blank">
        <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/ad2_7877235.png">
    </a>
    <?php }?>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/www.spatialgate.com.tw/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/common.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-03-01 10:58:23
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_56d5054f2b2bc9_82573719')) {function content_56d5054f2b2bc9_82573719($_smarty_tpl) {?><div class="footerBox">
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