<?php /* Smarty version Smarty-3.1.13, created on 2016-03-11 13:36:14
         compiled from "/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/events.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1380253048567cc6a33c41d1-04554281%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c108dccab0309306350053ca8faebfa21d7688a3' => 
    array (
      0 => '/data/www/www.spatialgate.com.tw/phpcms/templates/v4/tw_acg/widget/events.tpl',
      1 => 1456799948,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1380253048567cc6a33c41d1-04554281',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_567cc6a33efdb9_54308231',
  'variables' => 
  array (
    'event' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_567cc6a33efdb9_54308231')) {function content_567cc6a33efdb9_54308231($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
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
<?php } ?><?php }} ?>