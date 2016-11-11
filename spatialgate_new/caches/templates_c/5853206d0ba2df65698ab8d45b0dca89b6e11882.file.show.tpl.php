<?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/wap/show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:199801663257ccd8e792eda3-50453768%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5853206d0ba2df65698ab8d45b0dca89b6e11882' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/wap/show.tpl',
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
    'fe483bea5b7fbac733d88cc850f710c7af7677b0' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/news_detail.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    'f10e52355639d4b56c4d0af73f21c137c11caae8' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/tag_detail.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
    '884babc96dd654dae65c9c8c346f018d3d68e1d9' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/related.tpl',
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
  'nocache_hash' => '199801663257ccd8e792eda3-50453768',
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
  'unifunc' => 'content_57ccd8e7b27d80_20702438',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57ccd8e7b27d80_20702438')) {function content_57ccd8e7b27d80_20702438($_smarty_tpl) {?>

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
    
    
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta property="fb:app_id" content="" />
    <meta property="og:type"   content="article" />
    <meta property="og:url"    content="<?php echo trim($_smarty_tpl->tpl_vars['url']->value);?>
" />
    <meta property="og:title"  content="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" />
    <meta property="og:image"  content="<?php echo $_smarty_tpl->tpl_vars['thumb']->value;?>
" />
    <meta property="og:description"  content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
    
    

	

    
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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '199801663257ccd8e792eda3-50453768');
content_57ccd8e79c48a1_66178719($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/header.tpl" */?>
    
    <div class="m-content">
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/news_detail.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/news_detail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '199801663257ccd8e792eda3-50453768');
content_57ccd8e79f2f16_29563761($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/news_detail.tpl" */?>
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/tag_detail.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/tag_detail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '199801663257ccd8e792eda3-50453768');
content_57ccd8e7a49908_91641520($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/tag_detail.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/related.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/related.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '199801663257ccd8e792eda3-50453768');
content_57ccd8e7a69a22_95679895($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/related.tpl" */?>
	 </div>

    
    
        
        <?php /*  Call merged included template "tw_acg/widget/wap/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '199801663257ccd8e792eda3-50453768');
content_57ccd8e7a9f797_61049005($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/footer.tpl" */?>
    
    <script language="JavaScript" src="<?php echo @constant('APP_PATH');?>
api.php?op=count&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&modelid=<?php echo $_smarty_tpl->tpl_vars['modelid']->value;?>
"></script>
    <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.5&appId=1500638963557330";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    
    <span class="go-up"></span>
    </div>
    
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/classify.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/classify.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '199801663257ccd8e792eda3-50453768');
content_57ccd8e7ac1f93_29305894($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/classify.tpl" */?>
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/right_search.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/right_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '199801663257ccd8e792eda3-50453768');
content_57ccd8e7af0321_21345686($_smarty_tpl);
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
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57ccd8e79c48a1_66178719')) {function content_57ccd8e79c48a1_66178719($_smarty_tpl) {?><div class="zq_header">
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/news_detail.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57ccd8e79f2f16_29563761')) {function content_57ccd8e79f2f16_29563761($_smarty_tpl) {?><div class="news_detail">
	<div class="news_detail_title">
        <h2><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h2>
        <?php $_smarty_tpl->tpl_vars['weekarray'] = new Smarty_variable(array("日","一","二","三","四","五","六"), null, 0);?>
        <p class="fl"><?php echo date("Y年m月d日",strtotime($_smarty_tpl->tpl_vars['inputtime']->value));?>
 星期<?php echo $_smarty_tpl->tpl_vars['weekarray']->value[date("w",strtotime($_smarty_tpl->tpl_vars['inputtime']->value))];?>
</p><p class="fr">作者: <?php echo (($tmp = @$_smarty_tpl->tpl_vars['authorname']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['username']->value : $tmp);?>
</p>
    </div>
    <div class="fl">
            <span class="inb"><?php echo get_views("c-".((string)$_smarty_tpl->tpl_vars['modelid']->value)."-".((string)$_smarty_tpl->tpl_vars['id']->value));?>
</span>
    </div>
    <div class="shares clearfix">
        <h2>分享到:</h2>
        <ul class="clearfix">
            <li>
                <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/fb_02_8062349.png" />
                </a>
            </li>
            <li>
                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($_smarty_tpl->tpl_vars['title']->value);?>
&url=<?php echo urlencode($_smarty_tpl->tpl_vars['url']->value);?>
">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/tw_02_4c8d335.png" />
                </a>
            </li>
            <li>
                <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/go_02_f9b65e0.png" />
                </a>
            </li>
            <li>
                <a href="http://line.me/R/msg/text/?<?php echo urlencode($_smarty_tpl->tpl_vars['title']->value);?>
%0D%0A<?php echo urlencode($_smarty_tpl->tpl_vars['url']->value);?>
">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/li_02_a1fe523.png" />
                </a>
            </li>
            <li>
                <a href="javascript:void(window.open('http://www.plurk.com/m?qualifier=shares&content='.concat(encodeURIComponent(window.location.href)).concat(' ').concat('(').concat(encodeURIComponent(document.title)).concat(')')));">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/po_02_dcf70d8.png" />
                </a>
            </li>
        </ul>
    </div>
    <div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div>
    <div id="detailBox" class="news_detail_content">
    	<?php echo html5_convert($_smarty_tpl->tpl_vars['content']->value);?>

    </div>
    <div class="fb-like" data-show-faces="false" data-width="450">&nbsp;</div>
    <div class="share clearfix">
    	<h2>分享到:</h2>
        <ul class="clearfix">
        	<li>
                <a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href)) ));">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/fb_01_511123c.png" />
                </a>
            </li>
            <li>
                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($_smarty_tpl->tpl_vars['title']->value);?>
&url=<?php echo urlencode($_smarty_tpl->tpl_vars['url']->value);?>
">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/tw_01_641935e.png" />
                </a>
            </li>
            <li>
                <a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/go_01_4960766.png" />
                </a>
            </li>
            <li>
                <a href="http://line.me/R/msg/text/?<?php echo urlencode($_smarty_tpl->tpl_vars['title']->value);?>
%0D%0A<?php echo urlencode($_smarty_tpl->tpl_vars['url']->value);?>
">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/li_01_636addc.png" />
                </a>
            </li>
            <li>
                <a href="javascript:void(window.open('http://www.plurk.com/m?qualifier=shares&content='.concat(encodeURIComponent(window.location.href)).concat(' ').concat('(').concat(encodeURIComponent(document.title)).concat(')')));">
                    <img src="http://sts0.mofang.com.tw/statics/v4/tw_acg/wap/images/pu_01_fcc3e79.png" />
                </a>
            </li>
        </ul>
    </div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/news_detail.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/news_detail.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/swipebox.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/swipebox.css",$_smarty_tpl->smarty);?>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/js/swipebox.js",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/js/swipebox.js",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/tag_detail.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57ccd8e7a49908_91641520')) {function content_57ccd8e7a49908_91641520($_smarty_tpl) {?><div class="hotsearch">
        <div class="list_title clearfix">
            <h2 class="logo fl">相關分類資訊</h2>
        </div>
        <div class="search_content">
        <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'types')) {$data = $content_tag->types(array('module'=>'content','typeid'=>$_smarty_tpl->tpl_vars[typeid]->value,'limit'=>'20',));}$_smarty_tpl->assign('data',$data);?>
        	<ul>
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        		<li>
                    <a href="<?php echo @constant('APP_PATH');?>
/index.php?m=content&c=tag&catid=<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
&tag=<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
（<?php echo $_smarty_tpl->tpl_vars['val']->value['total'];?>
）
                    </a>
                </li>
            <?php } ?>         
        	</ul>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty);?>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/related.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57ccd8e7a69a22_95679895')) {function content_57ccd8e7a69a22_95679895($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/data/www/mofang.com/spatialgate/phpcms/init/smarty/plugins/modifier.truncate.php';
?><div class="news clearfix">
    <div class="list_title clearfix">
        <h2 class="fl">延伸閱讀</h2>
        <p class="fr"><a href="<?php echo cat_url($_smarty_tpl->tpl_vars['catid']->value);?>
">MORE>></a></p>
    </div>
    <ul class="substance clearfix">
    <?php if(defined('IN_ADMIN')  && !defined('HTML')) {echo "<div class=\"admin_piao\" pc_action=\"content\" data=\"op=content&tag_md5=d41d8cd98f00b204e9800998ecf8427e\"><a href=\"javascript:void(0)\" class=\"admin_piao_edit\">编辑</a>";}$content_tag = pc_base::load_app_class("content_tag", "content");if (method_exists($content_tag, 'relation')) {$data = $content_tag->relation(array('module'=>'content','relation'=>$_smarty_tpl->tpl_vars[relation]->value,'id'=>$_smarty_tpl->tpl_vars[rs]->value[id],'catid'=>$_smarty_tpl->tpl_vars[catid]->value,'keywords'=>$_smarty_tpl->tpl_vars[keywords]->value,'limit'=>'5',));}$_smarty_tpl->assign('data',$data);?>
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57ccd8e7a9f797_61049005')) {function content_57ccd8e7a9f797_61049005($_smarty_tpl) {?><div class="footer">
    <h2>魔方數位資訊服務有限公司</h2>
    <p>版權所有(C) 2015 Mofang lnc All Rights Rserved.</p>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/classify.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57ccd8e7ac1f93_29305894')) {function content_57ccd8e7ac1f93_29305894($_smarty_tpl) {?><div class="classify">
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/mofang.com/spatialgate/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/classify.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/classify.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 10:31:03
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/wap/right_search.tpl" */ ?>
<?php if ($_valid && !is_callable('content_57ccd8e7af0321_21345686')) {function content_57ccd8e7af0321_21345686($_smarty_tpl) {?><div class="right_search">
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