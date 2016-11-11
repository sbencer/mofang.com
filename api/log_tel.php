<?php

$tel = addslashes($_GET['tel']);

$line = $tel . PHP_EOL;
file_put_contents(dirname(__FILE__) . '/yyt_tel.txt', $line, FILE_APPEND);

echo 1;
