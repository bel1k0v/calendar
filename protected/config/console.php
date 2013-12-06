<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$mainConfig = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=test',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'scheduler_',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);

$devConfig = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'console.dev.php';
if (file_exists($devConfig))
    $mainConfig = require_once $devConfig;

return $mainConfig;