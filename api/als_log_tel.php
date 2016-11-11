<?php

$tel = addslashes($_GET['tel']);
$type = addslashes($_GET['type']);

$line = $tel . ' ' . $type . PHP_EOL;
file_put_contents(dirname(__FILE__) . '/als_tel_new.txt', $line, FILE_APPEND);

echo 1;
