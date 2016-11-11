<?php
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Raiders List',
    // 默認路由
    'defaultController'    => 'partition/index',

	'preload'=>array('log'),

    // 加載全部依賴
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

    // 後台模塊
	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'mofangmysql',
		    'ipFilters'=>array('192.168.2.39','::1'),
		),
	),

    // 用戶配置
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
        // 數據庫配置1
		'db'=>array(
        'connectionString' => 'mysql:host=10.6.16.194;dbname=mofang_www;',
			'emulatePrepare' => true,
			'username' => 'mofang_www',
			'password' => 'RnJ6hp8FQdSW',
			'charset' => 'utf8',
            'tablePrefix'=>'www_',
            'class' => 'CDbConnection',
		),
        // 數據庫配置2
        'cms_db'=>array(
        'connectionString' => 'mysql:host=192.168.1.99;dbname=mofang_www',
			'emulatePrepare' => true,
			'username' => 'mofang_www',
			'password' => 'RnJ6hp8FQdSW',
			'charset' => 'utf8',
            'tablePrefix'=>'www_',
            'class' => 'CDbConnection',
		),
        // 緩存
        'cache'=>array(
            //'class'=>' system.caching.CMemCache',
            'class'=>'CMemCache',
            'servers'=>array(
                array(
                    'host'=>'192.168.1.200',
                    'port'=>11211,
                    'weight'=>100,
                ),
            ),
        ),
        // 錯誤測試模版
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
        // smarty模板
        'smarty' => array(
            'class' => 'ext.CSmarty'
        ),
        // 錯誤記錄
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
                /*
				array(
					'class'=>'CWebLogRoute',
				),
                */
			),
		),
	),
);
