<?php
DEFINE('BASE_PATH', __DIR__.DIRECTORY_SEPARATOR);
if(file_exists(BASE_PATH.'../../../../../.mebb')){//this is just for the our framework. just ignore this. the else block is relevant for you :)
  include_once BASE_PATH.'../../../../smarty/Smarty.class.php';
}else{
  include_once BASE_PATH.'../../../../smarty/Smarty.class.php';
  include realpath(BASE_PATH.'../../../mebb_i18n_smarty_function_locale.php');
}

//1. SETUP SMARTY AS YOU USUALLY DO, i.e. DON'T JUST COPY THE BELOW, UNLESS IT FITS YOUR NEEDS
//LOAD ALL THE MODIFIERS, FILTER, ETC. THAT YOU USE IN YOUR TEMPLATES, OTHERWISE, YOU'LL
//ENCOUNTER A LOT OF COMPILE ERRORS :D
$smarty = new \Smarty();
$smarty->setTemplateDir(BASE_PATH.'templates');
$smarty->setCompileDir(BASE_PATH.'compile');
$smarty->setCacheDir(BASE_PATH.'compile');
$smarty->setConfigDir(BASE_PATH.'compile');

//2. SOMEWHERE IN YOUR APPLICATION BEFORE THE FETCH/DISPLAY FUNCTION CALL
//   SET THE LOCALE TO USE. PROBABLY YOU ARE DOING THIS ANYWAYS ALREADY
//   IF YOU ARE USING GETTEXT IN YOUR PHP APPLICATION ALREADY
//   N.B.: for a tutorial consider http://onlamp.com/pub/a/php/2002/06/13/php.html
$language = (isset($argv[1])?trim($argv[1]):'de_DE');
putenv("LANG=$language"); 
setlocale(LC_ALL, $language);

$path = BASE_PATH.'locale';
$domain = 'messages';//this is the default text-domain
bindtextdomain($domain, $path); 
textdomain($domain);
bind_textdomain_codeset($domain, 'UTF-8');


//DONE! THE REST IST JUST FOR DEMONSTRATION PURPOSES
print $smarty->fetch('example_00.tpl');

?>
