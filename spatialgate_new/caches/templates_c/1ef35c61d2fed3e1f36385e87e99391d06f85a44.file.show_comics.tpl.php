<?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:14:23
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/show_comics.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2413951857d62858520385-69668556%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ef35c61d2fed3e1f36385e87e99391d06f85a44' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/show_comics.tpl',
      1 => 1474361882,
      2 => 'file',
    ),
    '843a0fbb02b530a4bb0030d949fe113fc0966312' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/full_screen.tpl',
      1 => 1474361882,
      2 => 'file',
    ),
    '454d8f98f5c682a062b30e0e7ee77a5b45fc6a67' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/common/hw/base.tpl',
      1 => 1474361679,
      2 => 'file',
    ),
    '0d0246eae5831f720bdd13e3992d8ea3c2f8993d' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/common/hw/seajs_base.tpl',
      1 => 1474361680,
      2 => 'file',
    ),
    '03df7e3003cd7d9ed31dac14371e4e1fb6f1598e' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/common/hw/doctype.tpl',
      1 => 1474361679,
      2 => 'file',
    ),
    'af876707fba938845c0d645a9c894622feb54a79' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/header.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
    '11f1b1d03f0977a4dc6336a21862fe39e9a3f0a8' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/comics/comics_works.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
    'b0127462c83dbe335da0fce1439dff5438f2ae27' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/comics/comics_works_con.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
    '19addfdc0623d7de2a387fbaec9e979e15afc586' => 
    array (
      0 => '/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/comics/go_back.tpl',
      1 => 1474361937,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2413951857d62858520385-69668556',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_57d62858674470_66865430',
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
<?php if ($_valid && !is_callable('content_57d62858674470_66865430')) {function content_57d62858674470_66865430($_smarty_tpl) {?>

<!doctype html>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISResource::setFramework(FISResource::load("common:statics/js/loader/sea.js", $_smarty_tpl->smarty));FISPagelet::init('NOSCRIPT'); ?><html>
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
    


    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/cssreset.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/cssreset.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/cssbase.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/cssbase.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/cssfonts.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/cssfonts.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/common.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/browser_update.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/browser_update.css",$_smarty_tpl->smarty);?>

    
    
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
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/boot.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/boot.js',$_smarty_tpl->smarty);?>
    <?php }else{ ?>
        <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/loader/sea.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/loader/sea.js',$_smarty_tpl->smarty);?>
    <?php }?>

    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('modules:statics/js/sea-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('modules:statics/js/sea-config.js',$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load('common:statics/js/base-config.js',$_smarty_tpl->smarty,false);FISPagelet::addHashTable('common:statics/js/base-config.js',$_smarty_tpl->smarty);?>

    <script>
        var lang_conf = "TW";
        
            var defaultURL = "http://u.mofang.com.tw";
        
    </script>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/login.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/login.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/js/hw/base-config.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/js/hw/base-config.js",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("common:statics/css/common-ref.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("common:statics/css/common-ref.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}ob_start();?>
        seajs.use(["login/check"])
    <?php $script = ob_get_clean();if($script!==false){if(class_exists('FISPagelet', false)){if(FISPagelet::$cp) {if (!in_array(FISPagelet::$cp, FISPagelet::$arrEmbeded)){FISPagelet::addScript($script);FISPagelet::$arrEmbeded[] = FISPagelet::$cp;}} else {FISPagelet::addScript($script);}}}FISPagelet::$cp = null;?>   

<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::cssHook();?><?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}echo FISPagelet::jsLoaderHook();?></head>

<body>

    
	<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/common.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/common.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/common.js",$_smarty_tpl->smarty);?>
    
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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2413951857d62858520385-69668556');
content_57e0fdef5fa5b1_56951635($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/header.tpl" */?> 
    

    
    
    
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/comics_video.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/comics_video.css",$_smarty_tpl->smarty);?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/iframe.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/iframe.js",$_smarty_tpl->smarty);?>
    <div class="float_video">
        <?php if ($_smarty_tpl->tpl_vars['catid']->value==46){?>
        <div class="video-con">
            
            <iframe id="v_iframe" src="<?php echo @constant('APP_PATH');?>
aniComicWeb/aniComicWeb4spatialgate.html?ID=<?php echo $_smarty_tpl->tpl_vars['author_id']->value;?>
+<?php echo $_smarty_tpl->tpl_vars['cartoon_id']->value;?>
+<?php echo $_GET['eid'];?>
" width="100%" height="0" frameBorder="0"></iframe>   
        </div>
        <?php }else{ ?>
        <div class="video-con">
            
            <iframe id="v_iframe" src="http://manga.hk/website/homepage/works?episode_id=<?php echo $_GET['eid'];?>
" width="100%" height="0" frameBorder="0" ></iframe>
        </div>
        <?php }?>
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'lists')) {$data = $content_tag->lists(array('catid'=>'48','order'=>'listorder desc','limit'=>'1',));}$_smarty_tpl->assign('data',$data);?>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        
        <?php } ?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </div>

    
    <?php /*  Call merged included template "tw_acg/widget/comics/comics_works_con.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/comics/comics_works_con.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2413951857d62858520385-69668556');
content_57e0fdef659843_75467703($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/comics/comics_works_con.tpl" */?>


    
    

    

    
    
    <?php /*  Call merged included template "tw_acg/widget/comics/go_back.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/comics/go_back.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2413951857d62858520385-69668556');
content_57e0fdef68dc24_93712651($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/comics/go_back.tpl" */?>
    <script language="JavaScript" src="<?php echo @constant('APP_PATH');?>
api.php?op=count&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&modelid=<?php echo $_smarty_tpl->tpl_vars['modelid']->value;?>
"></script>

    


    
    

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
<?php $tpl=str_replace("\\", "/", $_smarty_tpl->template_resource);if(!class_exists('FISPagelet')){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::setPageName(str_replace("/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/", "", $tpl));$_smarty_tpl->registerFilter('output', array('FISPagelet', 'renderResponse'));?></html>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:14:23
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e0fdef5fa5b1_56951635')) {function content_57e0fdef5fa5b1_56951635($_smarty_tpl) {?><div class="acg-headerbox">
	<div class="acg-header clearfix">
		<div class="header-wrap w1000 clearfix">
			<a href="<?php echo @constant('APP_PATH');?>
" class="acg-logo"></a>
			<div class="header-left">
				<a href="/"><img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/img/header_left_d7d7273.png"></a>
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/common.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/acg_login.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/acg_login.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/login_tip.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/login_tip.js",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:14:23
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/comics/comics_works_con.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e0fdef659843_75467703')) {function content_57e0fdef659843_75467703($_smarty_tpl) {?><div id="pop_works" class="works">
    <?php /*  Call merged included template "tw_acg/widget/comics/comics_works.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/comics/comics_works.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2413951857d62858520385-69668556');
content_57e0fdef65c7a9_77279254($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/comics/comics_works.tpl" */?>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/comics_works.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/comics_works.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/jquery.fancybox.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/jquery.fancybox.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:14:23
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/comics/comics_works.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e0fdef65c7a9_77279254')) {function content_57e0fdef65c7a9_77279254($_smarty_tpl) {?><div class="works-title clearfix">
    <div class="title-img fl">
        <a href="javascript:;">
            <img src="<?php echo $_smarty_tpl->tpl_vars['thumb']->value;?>
">
        </a>
    </div>
    <div class="title-intro fl">
        <h2><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</a></h2>
        
        <div class="text">
            <span></span>
            <p><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
</p>
        </div>
    </div>
</div>
<?php $_smarty_tpl->tpl_vars['data'] = new Smarty_variable(string2array($_smarty_tpl->tpl_vars['episode_list']->value), null, 0);?>
<div class="con-chapter">
    <ul class="chapter-ul clearfix">
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <li><a href="<?php echo @constant('APP_PATH');?>
cartoon/<?php if ($_smarty_tpl->tpl_vars['catid']->value==46){?>anicomic<?php }else{ ?>manga<?php }?>/<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['val']->value['eid'];?>
.html"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
        <?php } ?>
    </ul>
</div>
<a class="works_back" href="javascript:;">回到上一頁</a><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-20 17:14:23
         compiled from "/data/www/mofang.com/spatialgate_new/phpcms/templates/v4/tw_acg/widget/comics/go_back.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57e0fdef68dc24_93712651')) {function content_57e0fdef68dc24_93712651($_smarty_tpl) {?><div class="go-back">
    <div class="back-content">
        <a href="javascript:;" class="con back_works" data-catid="<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">回作品情報</a>
        <a href="<?php echo cat_url(43);?>
" class="con">回原創漫畫</a>
        <a href="javascript:;" class="top">TOP</a>
    </div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/css/go_back.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/css/go_back.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate_new/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/js/go_back.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/js/go_back.js",$_smarty_tpl->smarty);?><?php }} ?>