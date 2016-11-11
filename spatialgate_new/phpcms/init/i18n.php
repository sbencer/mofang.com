<?php
if(!defined("MFE_BASE_PATH")){
    exit("MFE_BASE_PATH not defined");
}

////////////////////////////////////////////////////
//+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=
// GETTEXT CONFIG
//+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=
////////////////////////////////////////////////////

define('MEBB_IGNORE_ERRORS', true);
define('MEBB_TEMPLATE_EXTENSION', 'tpl');

DEFINE('MEBB_PATH',MFE_BASE_PATH.DIRECTORY_SEPARATOR.'smarty-gettext-v1.2.11'.DIRECTORY_SEPARATOR);

// echo MEBB_PATH.'mebb_functions_glob_recursive.php';
include realpath(MEBB_PATH.'mebb_functions_glob_recursive.php');
include realpath(MEBB_PATH.'mebb_i18n_smarty.php');
include_once MEBB_PATH.'mebb_i18n_smarty_function_locale.php';

//2. INTEGRATE THE CUSTOM LOCALES FUNCTION. ACTUALLY THAT'S THE ONLY THING YOU REALLY HAVE TO DO
$smarty->registerPlugin('function', 'locale', '\\mebb\\app\\core\\web\\smarty\\functions\\locale');

//3. SOMEWHERE IN YOUR APPLICATION YOU SET:
//    -- THE PATH FOR THE LOCALE FILES
$smarty->assign('path', MFE_BASE_PATH.'locale');

//4. SOMEWHERE IN YOUR APPLICATION BEFORE THE FETCH/DISPLAY FUNCTION CALL
//   SET THE LOCALE TO USE. PROBABLY YOU ARE DOING THIS ANYWAYS ALREADY
//   IF YOU ARE USING GETTEXT IN YOUR PHP APPLICATION ALREADY
//   N.B.: for a tutorial consider http://onlamp.com/pub/a/php/2002/06/13/php.html

$language = (isset($argv[1])?trim($argv[1]):'de_DE');
putenv("LANG=$language"); 
setlocale(LC_ALL, $language);

if (isset($_GET['gettext'])) {
  //3.) we compile all the templates in the template directory
  //    you can also set a custom directory/subdirectory and only consider files therein,
  //    if you like to create multiple po/mo files
  $info = array();//the passback array for error definitions (in case there are any)
  $sources = \mebb\lib\i18n\smarty\compile($smarty, null, $info);

  //4.) we're saving the files to the temporary directory. We've chosen to save them individually
  //    because the po/mo files will at least contain an indication of the origin for the
  //    message IDs, even if the line # will not be correct and the file-name will
  //    be re-formatted; but hey, that's as good it gets. Feedback, ideas, suggestions, etc. 
  //    more than welcome
  $directory = \mebb\lib\i18n\smarty\save($smarty, $sources);

  //DONE. The rest ist just for informational and playful purposes :
  //You can no go to the directory and use any program to extract the message-IDs 
  //If you are using xgettext, use the following command
  // > cd /my/directory/with/translation/
  // > xgettext -n *.tpl --language=PHP 

  print 'The following templates have been compiled into '.$directory.':'.PHP_EOL;
  foreach($sources as $source){
    print '  - '.$source['file_original'].PHP_EOL;
  }

  if(count($info['errors'])>0){
    print PHP_EOL.PHP_EOL.'The following errors have occured:'.PHP_EOL;
    foreach($info['errors'] as $error){
      $exception = $error['exception'];
      $file = $error['file'];
      print $file.' has the following error: '.$error['message'].PHP_EOL; 
    }
  }
  exit(0);
}


// function _($a) {
//   return $a;
// }
// function gettext($a) {
//   return $a;
// }
// function ngettext($a) {
//   return $a;
// }
