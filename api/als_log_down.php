<?php
    function pageVisitCount(){
         $count= "als_down.txt";
         $num= @file_get_contents($count);
         if ($fp= fopen($count,"w+")){
             flock($fp,LOCK_EX);
             $num++;
             fwrite($fp,$num);
             flock($fp,LOCK_UN);
         }
         return $num;
     }
     pageVisitCount();
     header('Location:http://als.mofang.com/d');

