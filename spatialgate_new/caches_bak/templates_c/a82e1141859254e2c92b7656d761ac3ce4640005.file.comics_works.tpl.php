<?php /* Smarty version Smarty-3.1.13, created on 2016-01-04 15:25:50
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/comics_works.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20127924955683ad5241ef17-25298778%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a82e1141859254e2c92b7656d761ac3ce4640005' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/comics_works.tpl',
      1 => 1451892218,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20127924955683ad5241ef17-25298778',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5683ad5244ada2_56362327',
  'variables' => 
  array (
    'thumb' => 0,
    'title' => 0,
    'description' => 0,
    'episode_list' => 0,
    'data' => 0,
    'catid' => 0,
    'id' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5683ad5244ada2_56362327')) {function content_5683ad5244ada2_56362327($_smarty_tpl) {?><div class="works-title clearfix">
    <div class="title-img fl">
        <a href="javascript:;">
            <img src="<?php echo $_smarty_tpl->tpl_vars['thumb']->value;?>
">
        </a>
    </div>
    <div class="title-intro fl">
        <h2><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</a></h2>
        <p class="pop_like already">999</p>
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
cartoon/anicomic/<?php echo $_smarty_tpl->tpl_vars['catid']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['val']->value['eid'];?>
.html" target="_blank"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></li>
        <?php } ?>
    </ul>
</div>
<a class="works_back" href="javascript:;">回到上一頁</a><?php }} ?>