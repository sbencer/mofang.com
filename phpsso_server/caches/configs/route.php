<?php
/**
 * 路由配置文件
 * 默認配置為default如下：
 * 'default'=>array(
 * 	'm'=>'phpcms', 
 * 	'c'=>'index', 
 * 	'a'=>'init', 
 * 	'data'=>array(
 * 		'POST'=>array(
 * 			'catid'=>1
 * 		),
 * 		'GET'=>array(
 * 			'contentid'=>1
 * 		)
 * 	)
 * )
 * 基中“m”為模型,“c”為控制器，“a”為事件，“data”為其他附加參數。
 * data為一個二維數組，可設置POST和GET的默認參數。POST和GET分別對應PHP中的$_POST和$_GET兩個超全局變量。在程序中您可以使用$_POST['catid']來得到data下面POST中的數組的值。
 * data中的所設置的參數等級比較低。如果外部程序有提交相同的名字的變量，將會覆蓋配置文件中所設置的值。如：
 * 外部程序POST了一個變量catid=2那麼你在程序中使用$_POST取到的值是2，而不是配置文件中所設置的1。
 */
return array(
	'default'=>array('m'=>'admin', 'c'=>'index', 'a'=>'init'),
);