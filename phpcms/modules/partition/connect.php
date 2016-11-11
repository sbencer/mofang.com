<?php
$prefix=$_GET['prefix'];
$project=$_GET['project'];
$name=$_GET['name'];
$mod = $_GET['mod'];
$ext=$_GET['ext'];
$local=$_GET['local'];
$filename = PHPCMS_PATH."statics/".$prefix."/".$project."/".$mod."/".$name.$ext;
$content = file_get_contents($filename);

$domain = "";
$pre = $domain.'/statics/'.$prefix."/".$project."/".$mod."/";
if($ext=="css"){
    @header('Content-type: text/css');
    $content = preg_replace('/\.\.\/img\//i',$pre.'../img/',$content);
}else if($ext="js"){
    @header('Content-type: application/x-javascript; charset=utf-8');
    $content = preg_replace('/\.\.\/img\//i',$pre.'../img/',$content);
    $content = preg_replace('/\.\.\/css\//i',$pre.'../css/',$content);
    $content = preg_replace('/\.\.\/js\//i',$pre.'../js/',$content);
}

echo $content;
exit();
