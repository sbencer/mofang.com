<?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 18:35:24
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/wap/show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4196593015602806c8b5795-92484917%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '54cb1bab27f552cbebdcc9b1068a20027b72fa1e' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/wap/show.tpl',
      1 => 1443004508,
      2 => 'file',
    ),
    '00f5f52938c1a9a56840d9aff22e5ec881afb0f8' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/wap/base.tpl',
      1 => 1443004508,
      2 => 'file',
    ),
    '5f9a030aba09c4ba94554bba191c2825f55162fd' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/common/hw/m_base.tpl',
      1 => 1443004486,
      2 => 'file',
    ),
    'f785ecb67e738d2591683df133e90adfd5cfcd20' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/common/m_doctype.tpl',
      1 => 1443004487,
      2 => 'file',
    ),
    '31cb7aa8d1a147e5d09fdcc2e85d670e9fed6d4c' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/header.tpl',
      1 => 1443004512,
      2 => 'file',
    ),
    '481c0f6abf5506d61e5eb905e528f4cf7874c666' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/news_detail.tpl',
      1 => 1443004512,
      2 => 'file',
    ),
    '137b22a442afea3f5ddc7d59ae0dc7c2e18cd1e2' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/hot_search.tpl',
      1 => 1443004512,
      2 => 'file',
    ),
    '4a324b942c279a5575f408460853509be9947233' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/news.tpl',
      1 => 1443004512,
      2 => 'file',
    ),
    '08e65ed9fb0b571fa8a228fd7f9664606eb608c0' => 
    array (
      0 => '/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl',
      1 => 1443004512,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4196593015602806c8b5795-92484917',
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
  'unifunc' => 'content_5602806ca8fab1_08506859',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5602806ca8fab1_08506859')) {function content_5602806ca8fab1_08506859($_smarty_tpl) {?>

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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '4196593015602806c8b5795-92484917');
content_5602806c9ae472_30016290($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/header.tpl" */?>
    
    <div class="m-content">
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/news_detail.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/news_detail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '4196593015602806c8b5795-92484917');
content_5602806c9fbd42_49209862($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/news_detail.tpl" */?>
    	
        <?php /*  Call merged included template "tw_acg/widget/wap/hot_search.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/hot_search.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '4196593015602806c8b5795-92484917');
content_5602806ca0fdf0_25418199($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/hot_search.tpl" */?>
        
        <?php /*  Call merged included template "tw_acg/widget/wap/news.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/news.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '4196593015602806c8b5795-92484917');
content_5602806ca1f0b5_37530976($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/news.tpl" */?>
	 </div>

    
    <?php /*  Call merged included template "tw_acg/widget/wap/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tw_acg/widget/wap/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '4196593015602806c8b5795-92484917');
content_5602806ca777e9_65814191($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tw_acg/widget/wap/footer.tpl" */?>
    <?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/g.css",$_smarty_tpl->smarty);?>


</body><?php if(class_exists('FISPagelet', false)){echo FISPagelet::jsHook();}?>
<?php $tpl=str_replace("\\", "/", $_smarty_tpl->template_resource);if(!class_exists('FISPagelet')){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::setPageName(str_replace("/data/www/taiwanACG/phpcms/templates/v4/", "", $tpl));$_smarty_tpl->registerFilter('output', array('FISPagelet', 'renderResponse'));?></html>
<?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 18:35:24
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5602806c9ae472_30016290')) {function content_5602806c9ae472_30016290($_smarty_tpl) {?><div class="zq_header">
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/common.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 18:35:24
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/news_detail.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5602806c9fbd42_49209862')) {function content_5602806c9fbd42_49209862($_smarty_tpl) {?><div class="news_detail">
	<div class="news_detail_title">
        <h2>故事描述主角兄妹因為家中貧窮，而被繼母丟棄在森林中，兩人在森林中無!</h2>
        <p>2015 年9月21日 星期一</p>
    </div>
    <div class="news_detail_content">
    	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    </div>
    <div class="share clearfix">
    	<h2>分享到:</h2>
        <ul class="clearfix">
        	<li><a href="#"><img src="/statics/v4/tw_acg/wap/images/share_img_09.png" /></a></li>
            <li><a href="#"><img src="/statics/v4/tw_acg/wap/images/share_img_11.png" /></a></li>
            <li><a href="#"><img src="/statics/v4/tw_acg/wap/images/share_img_13.png" /></a></li>
        </ul>
    </div>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/news_detail.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/news_detail.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 18:35:24
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/hot_search.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5602806ca0fdf0_25418199')) {function content_5602806ca0fdf0_25418199($_smarty_tpl) {?><div class="hotsearch">
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/hot_search.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 18:35:24
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/news.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5602806ca1f0b5_37530976')) {function content_5602806ca1f0b5_37530976($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/data/www/taiwanACG/phpcms/init/smarty/plugins/modifier.truncate.php';
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
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/index_news.css",$_smarty_tpl->smarty);?><?php }} ?><?php /* Smarty version Smarty-3.1.13, created on 2015-09-23 18:35:24
         compiled from "/data/www/taiwanACG/phpcms/templates/v4/tw_acg/widget/wap/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_5602806ca777e9_65814191')) {function content_5602806ca777e9_65814191($_smarty_tpl) {?><div class="footer">
    <h2>魔方數位資訊服務有限公司</h2>
    <p>版權所有(C) 2015 Mofang lnc All Rights Rserved.</p>
</div>
<?php if(!class_exists('FISPagelet', false)){require_once('/data/www/taiwanACG/phpcms/init/plugin/lib/FISPagelet.class.php');}FISPagelet::load("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty,false);FISPagelet::addHashTable("tw_acg:statics/wap/css/footer.css",$_smarty_tpl->smarty);?><?php }} ?>