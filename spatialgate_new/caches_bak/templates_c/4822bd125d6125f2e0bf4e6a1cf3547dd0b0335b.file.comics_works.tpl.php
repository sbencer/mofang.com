<?php /* Smarty version Smarty-3.1.13, created on 2016-09-05 16:18:20
         compiled from "/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/comics/comics_works.tpl" */ ?>
<?php /*%%SmartyHeaderCode:122631432457cd2a4c16a3e1-59963979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4822bd125d6125f2e0bf4e6a1cf3547dd0b0335b' => 
    array (
      0 => '/data/www/mofang.com/spatialgate/phpcms/templates/v4/tw_acg/widget/comics/comics_works.tpl',
      1 => 1473041738,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '122631432457cd2a4c16a3e1-59963979',
  'function' => 
  array (
  ),
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
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_57cd2a4c1a8405_51071236',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57cd2a4c1a8405_51071236')) {function content_57cd2a4c1a8405_51071236($_smarty_tpl) {?><div class="works-title clearfix">
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
<a class="works_back" href="javascript:;">回到上一頁</a><?php }} ?>